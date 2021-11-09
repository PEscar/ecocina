<template>
    <div>
        <h2>Filtros</h2>
        <hr>
        <div class="form-group">
            <label for="name">Nombre / Descripción</label>
            <input type="text" v-model="filter_q" @keyup="setRequestParams()" id="name" placeholder="Puré de Papas" class="form-control d-inline-block w-auto">
        </div>

        <hr>
        <v-server-table ref="myTable" :url="this.$root.base_url + '/data'" :columns="columns" :options="options">

            <template slot="measure" slot-scope="data">
                <span v-if="data.row.measure == 1" class="badge badge-secondary">Unidades</span>
                <span v-if="data.row.measure == 2" class="badge badge-secondary">Kilo</span>
                <span v-if="data.row.measure == 3" class="badge badge-secondary">Litro</span>
                <span v-if="data.row.measure == 4" class="badge badge-secondary">Metro</span>
                <span v-if="data.row.measure == 5" class="badge badge-secondary">Metro^2</span>
            </template>

            <template slot="sales" slot-scope="data">
                <span v-if="data.row.sales" class="badge badge-success">Si</span>
                <span v-else class="badge badge-danger">No</span>
            </template>

            <template slot="purchases" slot-scope="data">
                <span v-if="data.row.purchases" class="badge badge-success">Si</span>
                <span v-else class="badge badge-danger">No</span>
            </template>

            <template slot="productions" slot-scope="data">
                <span v-if="data.row.productions" class="badge badge-success">Si</span>
                <span v-else class="badge badge-danger">No</span>
            </template>

            <template slot="stock" slot-scope="data">
                <template v-if="data.row.stock > 0">
                    <vue-numeric
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.precision"
                        read-only
                        :value=data.row.stock
                    ></vue-numeric>
                </template>

                <template v-else>
                    0
                </template>
            </template>

            <template slot="average_cost" slot-scope="data">
                <template v-if="data.row.average_cost > 0">
                    <vue-numeric
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.cost_decimals"
                        read-only
                        :value=data.row.average_cost
                    ></vue-numeric>
                </template>

                <template v-else>
                    0
                </template>
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
                filter_q : '',
                products: [],
                options: {},
                columns: [
                    'id',
                    'name',
                    'detail',
                    'measure',
                    'stock',
                    'average_cost',
                    'sales',
                    'purchases',
                    'productions',
                    'actions',
                ]
            }
        },

        mounted: function()
        {
            this.options = this.$root.options
            this.options.headings.name = 'Nombre'
            this.options.sortable = ['name', 'detail', 'purchases', 'productions', 'sales', 'stock', 'measure', 'average_cost', 'id']

            this.setRequestParams()
        },

        methods: {

            setRequestParams: function()
            {
                this.$refs.myTable.setRequestParams({
                    order:{column:'name',ascending:true},
                    customFilters:{
                        model: 'Product',
                        query: this.filter_q,
                    }
                })
            },

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