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

            <template v-slot:child_row="data">
                <div><b>Descripción:</b> {{data.row.detail}}</div>
            </template>

            <template slot="actions" slot-scope="data">
                <a class="btn btn-primary btn-sm" :href="$root.base_url + '/products/' + data.row.id + '/edit/'">Editar</a>

                <a @click="deleteProduct(data.row.id, $event)" class="btn btn-danger btn-sm">Borar</a>

                <a v-if="data.row.productions" class="btn btn-warning btn-sm" :href="$root.base_url + '/products/' + data.row.id + '/recipes/'">Recetas</a>
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
                            let i = this.products.map(data => data.id).indexOf(id);
                            this.products.splice(i, 1)
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