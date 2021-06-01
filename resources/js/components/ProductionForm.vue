<template>
    <form :action="route" method="POST">

        <input type="hidden" name="_token" :value="$root.csrf">
        <input type="hidden" name="recipe_id" :value="production.recipe_id">
        <input type="hidden" name="recipe_quantity" :value="production.recipe_quantity">
        <input type="hidden" name="recipe_extra_cost" :value="production.recipe_extra_cost">
        <input type="hidden" name="recipe_lines_cost" :value="recipe.lines_cost">
        <input type="hidden" name="times" :value="production.times">
        <input type="hidden" name="quantity" :value="production.times * recipe.quantity">
        <input type="hidden" name="total" :value="recipe.total_cost">

        <div class="form-group">
            <label for="product">Producto:</label>
            <v-select id="product" placeholder="Buscar" class="w-auto d-inline-block" label="name" :filterable="false" v-model="product" :options="products" @search="onSearch" @input="recipe = null">
              </v-select>
        </div>

        <div class="form-group" v-if="product">
            <label for="recipe">Receta:</label>
            <v-select id="recipe" placeholder="Seleccionar" class="w-auto d-inline-block" label="name" :filterable="false" v-model="recipe" :options="product.recipes">
              </v-select>
            <span v-if="recipe">
                &nbsp;&nbsp;Cantidad producida: <vue-numeric
                    separator="."
                    decimal-separator=","
                    v-bind:precision="$root.precision"
                    read-only
                    :value=recipe.quantity
                ></vue-numeric> {{ $root.measures[product.measure] }}
            </span>
        </div>

        <template v-if="recipe">
            <div class="form-group">
                <label for="quantity">Cantidad:</label>
                <vue-numeric
                    v-bind:precision="$root.precision"
                    separator="."
                    decimal-separator=","
                    v-model="production.times"
                    v-bind:minus="false"
                    class="form-control w-auto d-inline-block"
                    v-bind:class="{'is-valid': production.times > 0, 'is-invalid': production.times <= 0}"
                ></vue-numeric>
                &nbsp;&nbsp;Total a producir: <vue-numeric
                    separator="."
                    decimal-separator=","
                    v-bind:precision="$root.precision"
                    read-only
                    :value="recipe.quantity * production.times"
                ></vue-numeric> {{ $root.measures[product.measure] }}
            </div>

            <div class="form-group">
                Costo extra Receta: <vue-numeric
                    separator="."
                    decimal-separator=","
                    v-bind:precision="$root.precision"
                    read-only
                    :value="recipe.extra_cost"
                ></vue-numeric>
            </div>

            <div class="form-group">
                Costo total producción: <vue-numeric
                    separator="."
                    decimal-separator=","
                    v-bind:precision="$root.precision"
                    read-only
                    :value="recipe.total_cost"
                ></vue-numeric>
            </div>

            <div class="form-group">
                Costo por {{ $root.measures[product.measure] }} producida: <vue-numeric
                    separator="."
                    decimal-separator=","
                    v-bind:precision="$root.precision"
                    read-only
                    :value="recipe.total_cost / (production.times * recipe.quantity)"
                ></vue-numeric>
            </div>
        </template>

        <v-client-table v-if="recipe" :data="recipe.lines" :columns="childColumns" :options="childOptions">

            <template slot="name" slot-scope="data">
                <a :href="$root.base_url + '/products/' + data.row.id + '/edit'">{{ data.row.name }}</a>
            </template>

            <template slot="pivot.quantity" slot-scope="data">
                <span v-bind:class="{'text-success': data.row.stock > (data.row.pivot.quantity * production.times), 'text-danger': (data.row.pivot.quantity * production.times) >= data.row.stock}">
                    <vue-numeric
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.precision"
                        read-only
                        :value="data.row.pivot.quantity * production.times"
                    ></vue-numeric>
                </span>
            </template>

            <template slot="stock" slot-scope="data">
                <vue-numeric
                    separator="."
                    decimal-separator=","
                    v-bind:precision="$root.precision"
                    read-only
                    :value=data.row.stock
                ></vue-numeric>
            </template>

            <template slot="quantity_recipe" slot-scope="data">
                <vue-numeric
                    separator="."
                    decimal-separator=","
                    v-bind:precision="$root.precision"
                    read-only
                    :value=data.row.pivot.quantity
                ></vue-numeric>
            </template>

            <template slot="average_cost" slot-scope="data">
                <div>
                    <vue-numeric
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.precision"
                        read-only
                        :value=data.row.average_cost
                    ></vue-numeric>
                </div>
            </template>

            <template slot="cost" slot-scope="data">
                <div>
                    <vue-numeric
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.precision"
                        read-only
                        :value="data.row.average_cost * data.row.pivot.quantity * production.times"
                    ></vue-numeric>
                </div>
            </template>

            <template slot="measure" slot-scope="data">
                {{ $root.measures[data.row.measure] }}
            </template>

        </v-client-table>

        <button type="submit" v-bind:disabled="!validForm" class="btn btn-primary">Producir</button>
    </form>
</template>
 
<script>
    export default {
        data() {
            return {
                production: {
                    recipe_id: null,
                    times: 1,
                    recipe_quantity: null,
                    recipe_extra_cost: null,
                },
                product: null, // selected product
                recipe: null, // selected recipe
                products: [], // select product options
                childColumns: ['id', 'name', 'measure', 'stock', 'average_cost', 'quantity_recipe', 'pivot.quantity', 'cost'],
                childOptions: {},
            }
        },
        computed: {

            validForm: function()
            {
                let c = false

                if ( this.recipe ) 
                {
                    c = this.recipe.lines.filter(item => item.stock < ( item.pivot.quantity * this.production.times ) ).length == 0
                }

                return this.recipe && this.production.times && c
            },

            route: function()
            {
                return this.$root.base_url + '/productions'
            }
        },

        watch: {

            recipe: function(newRecipe){
                this.production.recipe_id = newRecipe ? newRecipe.id : ''
                this.production.times = 1
                this.production.recipe_quantity = newRecipe ? newRecipe.quantity : ''
                this.production.recipe_extra_cost = newRecipe ? newRecipe.extra_cost : ''
            }
        },

        created: function()
        {
            this.childOptions = {...this.$root.options}
            this.childOptions.headings.name = 'Producto'
            this.childOptions.headings.quantity_recipe = 'Cantidad Receta'
            this.childOptions.headings.cost = 'Costo Línea'
            this.childOptions.headings['pivot.quantity'] = 'Cantidad Necesaria'
            this.childOptions.sortable = ['name', 'pivot.quantity', 'detail', 'stock']
            this.childOptions.orderBy = {
                column: 'name',
                ascending: true
            }

            this.childOptions.cellClasses['quantity_recipe'] = [{
                class:'text-right',
                condition: row => true
            }]

            // Preselectes
            this.product = this.$attrs.product
            this.recipe = this.$attrs.recipe ? this.product.recipes.find(item => item.id == this.$attrs.recipe.id) : null
        },

        methods: {

            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.search(loading, search, this);
                }
            },

            search: _.debounce((loading, search, vm) => {
              fetch(
                vm.$root.base_url + '/search/' + '?filters[productions]=1&with[]=recipes&orderBy=name&order=asc&model=Product&q=' + encodeURI(search)
              ).then(res => {

                res.json().then(json => (vm.products = json));
                loading(false);
              });
            }, 350)
          }
    }
</script>