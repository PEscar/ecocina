<template>
    <div class="card">
        <div class="card-header">Ventas<a :href="$root.base_url + '/sales/create'" class="float-right">Nueva</a></div>

        <div class="card-body">

            <h2>Filtros</h2>
            <hr>

            <div class="form-group">
                <label for="customer">Cliente</label>
                <input type="text" v-model="filter_q" @keyup="setRequestParams()" id="customer" placeholder="Juan Pérez" class="form-control d-inline-block w-auto">
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

                        <span v-if="data.row.total == 0">
                            0
                        </span>
                    </div>
                </template>

                <template v-slot:child_row="data">
                        <v-client-table :data="data.row.lines" :columns="childColumns" :options="childOptions">

                            <template slot="pivot.quantity" slot-scope="data">
                                <vue-numeric
                                    separator="."
                                    decimal-separator=","
                                    v-bind:precision="$root.precision"
                                    read-only
                                    :value=data.row.pivot.quantity
                                ></vue-numeric>
                            </template>

                            <template slot="pivot.price_per_unit" slot-scope="data">
                                <vue-numeric
                                    separator="."
                                    decimal-separator=","
                                    v-bind:precision="$root.precision"
                                    read-only
                                    :value=data.row.pivot.price_per_unit
                                ></vue-numeric>
                            </template>

                            <template slot="pivot.total" slot-scope="data">
                                <vue-numeric
                                    separator="."
                                    decimal-separator=","
                                    v-bind:precision="$root.precision"
                                    read-only
                                    :value=data.row.pivot.total
                                ></vue-numeric>
                            </template>

                            <template slot="name" slot-scope="data">
                                <a :href="$root.base_url + '/products/' + data.row.id + '/edit'">{{ data.row.name }}</a>
                            </template>
                        </v-client-table>
                </template>

                <template slot="actions" slot-scope="data">
                    <a class="btn btn-primary btn-sm" :href="$root.base_url + '/sales/' + data.row.id + '/edit'">Editar</a>

                    <a @click="deletePurchase(data.row.id, $event)" class="btn btn-danger btn-sm">Borar</a>
                </template>

            </v-server-table>
        </div>
    </div>
</template>

<style type="text/css">
    .VueTables__limit {
        display: none!important;
    }
</style>

<script>
    export default {
        data() {
            return {
                filter_q: '',
                filter_from: '',
                filter_to: '',
                options: {},
                childOptions: {},
                columns: [
                    'id',
                    'date',
                    'customer',
                    'total',
                    'actions',
                ],
                childColumns: ['id', 'name', 'pivot.quantity', 'pivot.price_per_unit', 'pivot.total'],
            }
        },

        mounted: function() {

            this.setRequestParams()
            this.options = this.$root.options
            this.childOptions = {...this.$root.options}

            this.options.sortable = ['id', 'date', 'customer']

            this.childOptions.headings.name = 'Producto'
            this.childOptions.sortable = ['id', 'name', 'pivot.quantity', 'pivot.price_per_unit', 'pivot.total']
            this.childOptions.orderBy = {
                column: 'name',
                ascending: true
            }
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
                filters.date.from = this.filter_from || null
                filters.date.to = this.filter_to || null

                this.$refs.myTable.setRequestParams({
                    order:{column:'date',ascending:false},
                    customFilters:{
                        model: 'Sale',
                        with: ['lines'],
                        query: this.filter_q,
                        filters: filters,
                    }
                })
            },

            deletePurchase(id, e) {

                let confirm = window.confirm('Estás seguro de borrar esta venta ? Toda la información asociada a la misma se perderá.');

                if ( confirm )
                {
                    this.axios
                        .delete(this.$root.base_url + '/sales/' + id)
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