<template>
    <form :action="route" method="POST">

        {{ route }}
        <input type="hidden" name="_token" :value="$root.csrf">

        <div class="form-group d-inline">
            <input id="qtty" class="form-control w-75" type="text" v-model="recipe.quantity" name="quantity"> <label fot="qtty">{{ measures[product.measure] }}</label>
            <small class="form-text text-muted">Indique la cantidad producida.</small>
        </div>

        <div class="form-group">
            <v-select label="name" :filterable="false" :options="searchOptions" @search="onSearch">
              </v-select>
            <small class="form-text text-muted">Buscar ingredientes.</small>
        </div>

        <hr>

        <v-client-table ref="myTable" :data="recipe.lines" :columns="columns" :options="tableOptions">

            <template slot="actions" slot-scope="data">
                <a @click="deleteProduct(data.row.id, $event)" class="btn btn-danger btn-sm">Borar</a>
            </template>

        </v-client-table>

        <button type="submit" v-bind:disabled="!validForm" class="btn btn-primary">Guardar</button>
    </form>
</template>
 
<script>
    export default {
        data() {
            return {
                measures: [],
                recipe: {
                    lines: [],
                    quantity: 2,
                    extra_cost: 0,
                },
                searchOptions: [],
                tableOptions: {
                    headings: {
                        name: 'Nombre',
                        measure: 'U. Medida',
                        actions: 'Acciones',
                        quantity: 'Cantidad',
                    }
                },
                columns: [
                    'name',
                    'measure',
                    'quantity',
                    'actions',
                ]
            }
        },
        props: {
            editRecipe: Object,
            product: Object,
        },
        computed: {
            validForm: function()
            {
                return true
            },

            route: function()
            {
                return this.$root.base_url + '/products/' + this.product.id + '/recipes' + ( this.recipe.id ? '/' + this.recipe.id : '' )
            }
        },

        created: function()
        {
            // Carga de receta a editar (si la hay)
            this.recipe = this.editRecipe ? this.editRecipe : {lines: []}

            // Etiquetas de unidades de medida.
            this.measures[1] = 'Unidades'
            this.measures[2] = 'Kilos'
            this.measures[3] = 'Litros'
        },

        methods: {

            deleteProduct: function(id)
            {

            },

            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.search(loading, search, this);
                }
            },

            search: _.debounce((loading, search, vm) => {
              fetch(
                vm.$root.base_url + '/products/' + '?q=' + encodeURI(search)
              ).then(res => {

                res.json().then(json => (vm.searchOptions = json));
                loading(false);
              });
            }, 350)
          }
    }
</script>