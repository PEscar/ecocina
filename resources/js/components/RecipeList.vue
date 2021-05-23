<template>
    <div class="card">
        <div class="card-header">Recetas<a :href="addRoute" class="float-right">Nueva</a></div>

        <div class="card-body">

            <h2>Filtros</h2>
            <hr>
            <div class="form-group">
                <label for="product">Producto</label>
                <v-select @input="setRequestParams()" id="product" placeholder="Busque un producto..." class="d-inline-block w-auto" label="name" :filterable="false" v-model="product" :options="filter_products" @search="onSearch">
                  </v-select>
            </div>

            <div class="form-group">
                <label for="name">Nombre / Descripción</label>
                <input type="text" v-model="filter_q" @keyup="setRequestParams()" id="name" placeholder="Puré de Papas" class="form-control d-inline-block w-auto">
            </div>

            <hr>

            <v-server-table ref="myTable" :url="this.$root.base_url + '/data'" :columns="columns" :options="options">

                <template v-slot:child_row="data">
                    <div><b>Ingredientes:</b></div>

                    <ul class="fa-ul">
                      <li v-for="line in data.row.lines">

                        <i class="fa-li fa"

                            v-bind:class="{
                                'fa-check': line.stock >= line.pivot.quantity,
                                'text-success': line.stock >= line.pivot.quantity,
                                'fa-times': line.stock < line.pivot.quantity,
                                'text-danger': line.stock < line.pivot.quantity
                            }"></i><strong>{{ line.name }}: </strong> <vue-numeric
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.precision"
                        read-only
                        :value=line.pivot.quantity
                    ></vue-numeric> <small v-if="line.stock < line.pivot.quantity">(faltan <vue-numeric
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.precision"
                        read-only
                        :value="line.pivot.quantity - line.stock"
                    ></vue-numeric> )</small>
                        </li>
                    </ul>
                </template>

                <template slot="product.name" slot-scope="data">
                    <a :href="$root.base_url + '/products/' + data.row.product.id + '/edit'">{{ data.row.product.name }}</a>
                </template>

                <template slot="actions" slot-scope="data">
                    <a class="btn btn-primary btn-sm" :href="$root.base_url + '/recipes/' + data.row.id + '/edit'">Editar</a>

                    <a @click="deleteRecipe(data.row.id, $event)" class="btn btn-danger btn-sm">Borar</a>
                </template>

                <template slot="quantity" slot-scope="data">
                    <vue-numeric
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.precision"
                        read-only
                        :value=data.row.quantity
                    ></vue-numeric>
                </template>

                <template slot="extra_cost" slot-scope="data">
                    <vue-numeric
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.precision"
                        read-only
                        :value=data.row.extra_cost
                    ></vue-numeric>
                </template>

            </v-server-table>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                filter_q: '',
                filter_products: [],
                product: null,
                recipes: [],
                options: {
                    filterable: false,
                    perPage: 10,
                    headings: {
                        id: 'ID',
                        name: 'Nombre',
                        detail: 'Descripción',
                        quantity: 'Cantidad Producida',
                        extra_cost: 'Costo Extra',
                        actions: 'Acciones',
                        'product.name': 'Producto',
                    },
                },
                columns: [
                    'id',
                    'product.name',
                    'name',
                    'detail',
                    'quantity',
                    'extra_cost',
                    'actions',
                ],
            }
        },

        async mounted() {

            this.product = this.$attrs.product

            $(".VueTables__search").removeClass('form-inline')

            this.setRequestParams()
        },

        computed:
        {
            addRoute: function()
            {
                return this.$root.base_url + '/recipes/create' + ( this.product ? '?product=' + this.product.id : '')
            }
        },

        methods: {

            setRequestParams: function()
            {
                let filters = this.product ? {product_id: this.product.id} : {}
                this.$refs.myTable.setRequestParams({
                    order:{column:'name',ascending:true},
                    customFilters:{
                        model: 'Recipe',
                        filters: filters,
                        with: ['lines', 'product'],
                        query: this.filter_q
                    }
                })
            },

            deleteRecipe(id, e) {

                let confirm = window.confirm('Estás seguro de borrar esta receta ? Toda la información asociada a la misma se perderá.');

                if ( confirm )
                {
                    this.axios
                        .delete(this.$root.base_url + '/recipes/' + id)
                        .then(response => {
                            this.$refs.myTable.refresh()
                        });
                }
                else
                {
                    e.preventDefault()
                }
            },

            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.search(loading, search, this);
                }
            },

            search: _.debounce((loading, search, vm) => {
              fetch(
                vm.$root.base_url + '/search/' + '?orderBy=name&order=asc&model=Product&&q=' + encodeURI(search)
              ).then(res => {

                res.json().then(json => (vm.filter_products = json));
                loading(false);
              });
            }, 350)
        }
    }
</script>