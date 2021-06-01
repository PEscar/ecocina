<template>
    <div class="card">
        <div class="card-header">Gastos<a :href="$root.base_url + '/expenses/create'" class="float-right">Nuevo</a></div>

        <div class="card-body">
            <h2>Filtros</h2>
            <hr>
            <div class="form-group">
                <label for="name">Nombre / Descripción</label>
                <input type="text" v-model="filter_q" @keyup="setRequestParams()" id="name" placeholder="Alquiler" class="form-control d-inline-block w-auto">
            </div>

            <div class="form-group">
                    <label for="from">Desde</label>
                    <v-datepicker
                        :clear-button=true
                        :language="$root.datepicker_langs[$root.user_lang]"
                        placeholder="DD/MM/AAAA"
                        class="form-control w-auto d-inline-block"
                        v-model="filter_from"
                        :format="$root.datepicker_date_format"
                         @input="setRequestParams()"
                         :disabledDates="fromDisabledDates"
                         :highlighted="$root.highlighted_dates"
                    ></v-datepicker>
                </div>

                <div class="form-group">
                    <label for="from">Hasta</label>
                    <v-datepicker
                        :clear-button=true
                        :language="$root.datepicker_langs[$root.user_lang]"
                        placeholder="DD/MM/AAAA"
                        class="form-control w-auto d-inline-block"
                        v-model="filter_to"
                        :format="$root.datepicker_date_format"
                         @input="setRequestParams()"
                         :disabledDates="untilDisabledDates"
                         :highlighted="$root.highlighted_dates"
                    ></v-datepicker>
                </div>

            <hr>
            <v-server-table ref="myTable" :url="this.$root.base_url + '/data'" :columns="columns" :options="options">

                <template slot="date" slot-scope="data">
                        {{ $root.moment(data.row.date).format($root.date_format) }}
                    </template>

                <template slot="total" slot-scope="data">
                    <div>
                        <vue-numeric
                            separator="."
                            decimal-separator=","
                            v-bind:precision="$root.precision"
                            read-only
                            :value=data.row.total
                        ></vue-numeric>
                    </div>
                </template>

                <template slot="actions" slot-scope="data">
                    <a class="btn btn-primary btn-sm" :href="$root.base_url + '/expenses/' + data.row.id + '/edit/'">Editar</a>

                    <a @click="deleteExpense(data.row.id, $event)" class="btn btn-danger btn-sm">Borar</a>
                </template>

            </v-server-table>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                filter_q : '',
                filter_from: null,
                filter_to: null,
                options: {},
                columns: [
                    'id',
                    'date',
                    'name',
                    'total',
                    'actions',
                ]
            }
        },

        mounted: function()
        {
            this.options = this.$root.options

            this.options.sortable = ['id', 'name', 'date', 'total']

            this.setRequestParams()
        },

        computed: {
            untilDisabledDates: function()
            {
                return this.filter_from ? {to: this.filter_from} : {}
            },

            fromDisabledDates: function()
            {
                return this.filter_to ? {from: this.filter_to} : {}
            }
        },

        methods: {

            setRequestParams: function()
            {
                let filters = {}

                filters.date = {}
                filters.date.from = this.filter_from ? this.$root.moment(this.filter_from).format(this.$root.datepicker_filter_format) : null
                filters.date.to = this.filter_to ? this.$root.moment(this.filter_to).format(this.$root.datepicker_filter_format) : null

                this.$refs.myTable.setRequestParams({
                    order:{column:'date',ascending:false},
                    customFilters:{
                        model: 'Expense',
                        query: this.filter_q,
                        filters: filters,
                    }
                })
            },

            deleteExpense(id, e) {

                let confirm = window.confirm('Estás seguro de borrar este producto ? Toda la información asociada al mismo se perderá.');

                if ( confirm )
                {
                    this.axios
                        .delete(this.$root.base_url + '/expenses/' + id)
                        .then(response => {
                            this.$refs.myTable.refresh()
                        });
                }
                else
                {
                    e.preventDefault()
                }
            }
        }
    }
</script>