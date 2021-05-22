<template>
    <div>
        <v-server-table ref="myTable" :url="this.$root.base_url + '/data'" :columns="columns" :options="options">

            <template slot="measure" slot-scope="data">
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
            </template>

            <template slot="stock" slot-scope="data">
                <div>
                    <vue-numeric
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.precision"
                        read-only
                        :value=data.row.stock
                    ></vue-numeric>

                    <span v-if="data.row.stock == 0">
                        0
                    </span>
                </div>
            </template>

            <template v-slot:child_row="data">
                <div><b>Descripción:</b> {{data.row.detail}}</div>
            </template>

            <template slot="actions" slot-scope="data">
                <a class="btn btn-primary btn-sm" :href="$root.base_url + '/products/' + data.row.id + '/edit/'">Editar</a>

                <a @click="deleteProduct(data.row.id, $event)" class="btn btn-danger btn-sm">Borar</a>

                <a v-if="data.row.productions" class="btn btn-warning btn-sm" :href="$root.base_url + '/recipes?product=' + data.row.id">Recetas</a>
            </template>

        </v-server-table>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                products: [],
                options: {
                    sortable: ['name'],
                    perPage: 10,
                    headings: {
                        sales: 'Ventas',
                        shoppings: 'Compras',
                        productions: 'Producción',
                        name: 'Nombre',
                        id: 'ID',
                        measure: 'U. Medida',
                        actions: 'Acciones',
                        detail: 'Descripción',
                    },
                    requestFunction(data) {

                        data.model = 'Product'
                        data.orderBy = 'name'

                        return axios.get(this.url, {
                            params: data
                        }).catch(function (e) {
                            this.dispatch('error', e);
                        });
                    },
                    cellClasses:{
                        stock: [{
                            class:'text-right',
                            condition: row => true
                        }]
                    }
                },
                columns: [
                    'id',
                    'name',
                    'detail',
                    'measure',
                    'stock',
                    'sales',
                    'shoppings',
                    'productions',
                    'actions',
                ]
            }
        },

        methods: {

            deleteProduct(id, e) {

                let confirm = window.confirm('Estás seguro de borrar este producto ? Toda la información asociada al mismo se perderá.');

                if ( confirm )
                {
                    this.axios
                        .delete(this.$root.base_url + '/products/' + id)
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