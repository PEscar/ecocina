<template>
    <div>
        <v-server-table ref="myTable" :url="this.$root.base_url + '/data'" :columns="columns" :options="options">
            <!-- <template slot="measure" slot-scope="data">
                <span v-if="data.row.measure == 1" class="badge badge-secondary">Unidades</span>
                <span v-if="data.row.measure == 2" class="badge badge-secondary">Kilo</span>
                <span v-if="data.row.measure == 3" class="badge badge-secondary">Litro</span>
            </template>

            <template slot="sales" slot-scope="data">
                <span v-if="data.row.sales" class="badge badge-success">Si</span>
                <span v-else class="badge badge-danger">No</span>
            </template>

            <template slot="shoppings" slot-scope="data">
                <span v-if="data.row.shoppings" class="badge badge-success">Si</span>
                <span v-else class="badge badge-danger">No</span>
            </template>

            <template slot="productions" slot-scope="data">
                <span v-if="data.row.productions" class="badge badge-success">Si</span>
                <span v-else class="badge badge-danger">No</span>
            </template> -->

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
                <div><b>Líneas:</b></div>

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

                    </v-client-table>
            </template>

            <template slot="actions" slot-scope="data">
                <a class="btn btn-primary btn-sm" :href="$root.base_url + '/purchases/' + data.row.id + '/edit/'">Editar</a>

                <a @click="deletePurchase(data.row.id, $event)" class="btn btn-danger btn-sm">Borar</a>
            </template>

        </v-server-table>
    </div>
</template>
 
<style>
    .VueTables__limit {
        display: none!important;
    }
</style>

<script>
    export default {
        data() {
            return {
                options: {
                    filterable: false,
                    paginate: false,
                    headings: {
                        date: 'Fecha',
                        supplier: 'Proveedor',
                        total: 'Total',
                        id: 'ID',
                        actions: 'Acciones',
                    },
                    cellClasses:{
                        total: [{
                            class:'text-right',
                            condition: row => true
                        }],
                    }
                },
                columns: [
                    'id',
                    'date',
                    'supplier',
                    'total',
                    'actions',
                ],
                childColumns: [/*'pivot.id', */'name', 'pivot.quantity', 'pivot.price_per_unit', 'pivot.total'],
                childOptions: {
                    filterable: false,
                    pagination: { show: false },
                    headings: {
                        total: 'Total',
                        'pivot.id': 'ID',
                        name: 'Producto',
                        'pivot.quantity': 'Cantidad',
                        'pivot.price_per_unit': 'Precio por Unidad',
                        'pivot.total': 'Total',
                    },
                    cellClasses:{
                        total: [{
                            class:'text-right',
                            condition: row => true
                        }],
                        'pivot.price_per_unit': [{
                            class:'text-right',
                            condition: row => true
                        }],
                        'pivot.quantity': [{
                            class:'text-right',
                            condition: row => true
                        }],
                        'pivot.total': [{
                            class:'text-right',
                            condition: row => true
                        }],
                    },
                    orderBy: {
                        column: 'name',
                        ascending: true
                    }
                },
            }
        },

        async mounted() {

            $(".VueTables__search").removeClass('form-inline')

            this.$refs.myTable.setRequestParams({
                order:{column:'date',ascending:true},
                customFilters:{
                    model: 'Purchase',
                    with: 'lines',
                }
            })
        },

        methods: {

            deletePurchase(id, e) {

                let confirm = window.confirm('Estás seguro de borrar esta compra ? Toda la información asociada al mismo se perderá.');

                if ( confirm )
                {
                    this.axios
                        .delete(this.$root.base_url + '/purchases/' + id)
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