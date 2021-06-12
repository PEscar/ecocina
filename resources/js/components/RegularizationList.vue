<template>
    <div class="card">
        <div class="card-header">Regularizaciones<a :href="$root.base_url + '/regularizations/create'" class="float-right">Nueva</a></div>

        <div class="card-body">

            <h2>Filtros</h2>
            <hr>

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

                <template slot="created_at" slot-scope="data">
                    {{ $root.moment(data.row.created_at).format($root.date_format) }}
                </template>

                <template v-slot:child_row="data">

                    <h3>Movimientos</h3>

                    <v-client-table :data="data.row.stock_movement.lines" :columns="childColumns" :options="childOptions">

                        <template slot="quantity" slot-scope="data">
                            <vue-numeric
                                separator="."
                                decimal-separator=","
                                v-bind:precision="$root.precision"
                                read-only
                                :value=data.row.quantity
                            ></vue-numeric>
                        </template>

                        <template slot="type" slot-scope="data">
                            <span v-if="data.row.type == 'in'">
                                <i  class="fas fa-sign-in-alt text-success"></i> Entrada
                            </span>
                            <span v-else>
                                <i class="fas fa-sign-out-alt text-danger"></i> Salida
                            </span>
                        </template>

                        <template slot="product.name" slot-scope="data">
                            <a :href="$root.base_url + '/products/' + data.row.product.id + '/edit'">{{ data.row.product.name }}</a>
                        </template>
                    </v-client-table>
                </template>

                <template slot="actions" slot-scope="data">
                    <a class="btn btn-primary btn-sm" :href="$root.base_url + '/regularizations/' + data.row.id + '/edit'">Editar</a>

                    <a @click="deleteRegularization(data.row.id, $event)" class="btn btn-danger btn-sm">Borar</a>
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
                    'created_at',
                    'detail',
                    'actions',
                ],
                childColumns: ['id', 'product.name', 'quantity', 'type'],
            }
        },

        mounted: function() {

            this.setRequestParams()
            this.options = this.$root.options
            this.childOptions = {...this.$root.options}

            this.options.sortable = ['id', 'created_at', 'total', 'quantity']
            this.options.headings.created_at = 'Fecha'
            this.options.headings.detail = 'Comentario'

            this.childOptions.headings.name = 'Producto'
            this.childOptions.headings.quantity = 'Cantidad'
            this.childOptions.sortable = ['id', 'name', 'pivot.quantity'/*, 'pivot.price_per_unit', 'pivot.total'*/]
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

                filters.created_at = {}
                filters.created_at.from = this.filter_from ? this.$root.moment(this.filter_from).format(this.$root.datepicker_filter_format) : null
                filters.created_at.to = this.filter_to ? this.$root.moment(this.filter_to).format(this.$root.datepicker_filter_format) : null

                this.$refs.myTable.setRequestParams({
                    order:{column:'created_at',ascending:false},
                    customFilters:{
                        model: 'Regularization',
                        with: ['stockMovement.lines.product'],
                        query: this.filter_q,
                        filters: filters,
                    }
                })
            },

            deleteRegularization(id, e) {

                let confirm = window.confirm('Estás seguro de borrar esta regularización ? Todos los movimientos asociados a la misma serán revertidos.');

                if ( confirm )
                {
                    this.axios
                        .delete(this.$root.base_url + '/regularizations/' + id)
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