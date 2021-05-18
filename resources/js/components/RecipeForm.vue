<template>
    <form :action="route" method="POST">

        <input type="hidden" name="_token" :value="$root.csrf">
        <input type="hidden" name="product_id" :value="recipe.product_id">
        <input type="hidden" name="quantity" :value="recipe.quantity">
        <input type="hidden" name="extra_cost" :value="recipe.extra_cost">
        <input type="hidden" v-for="line in recipe.lines" name="products[]" :value="line.pivot.product_id">
        <input type="hidden" v-for="line in recipe.lines" name="qttys[]" :value="line.pivot.quantity">

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" v-model="recipe.name" id="name" class="form-control w-auto d-inline" v-bind:class="{'is-valid': recipe.name, 'is-invalid': !recipe.name}" name="name">
        </div>

        <div class="form-group">
            <label for="detail">Descripción</label>
            <input type="text" v-model="recipe.detail" id="detail" class="form-control w-75 d-inline" name="detail">
        </div>

        <div class="form-group">
            Receta para producir <vue-numeric
                v-bind:precision="$root.precision"
                separator="."
                decimal-separator=","
                v-model="recipe.quantity"
                v-bind:minus="false"
                class="form-control w-auto d-inline"
                v-bind:class="{'is-valid': recipe.quantity > 0, 'is-invalid': recipe.quantity <= 0}"
            ></vue-numeric>&nbsp;&nbsp;{{ measures[product.measure] }}
        </div>

        <div class="form-group">
            Costo Extra <vue-numeric
                v-bind:precision="$root.precision"
                separator="."
                decimal-separator=","
                v-model="recipe.extra_cost"
                v-bind:minus="false"
                class="form-control w-auto d-inline"
            ></vue-numeric>
        </div>

        <div class="form-group">
            <label for="ingredients">Buscar ingredientes</label>
            <v-select id="ingredients" label="name" :filterable="false" v-model="line" :options="searchOptions" @search="onSearch">
              </v-select>
        </div>

        <hr>

        <v-client-table ref="myTable" :data="recipe.lines" :columns="columns" :options="tableOptions">

            <template slot="measure" slot-scope="data">
                {{ measures[data.row.measure] }}
            </template>

            <template slot="detail" slot-scope="data">
                <input type="text" class="form-control" v-model="recipe.lines[data.index - 1].pivot.detail" name="details[]">
            </template>

            <template slot="quantity" slot-scope="data">
                <vue-numeric
                    v-bind:precision="$root.precision"
                    separator="."
                    decimal-separator=","
                    v-model="recipe.lines[data.index - 1].pivot.quantity"
                    v-bind:minus="false"
                    class="form-control w-auto"
                    :ref="'product_' + recipe.lines[data.index - 1].pivot.product_id"
                    v-bind:class="{'is-valid': recipe.lines[data.index - 1].pivot.quantity > 0, 'is-invalid': recipe.lines[data.index - 1].pivot.quantity <= 0}"
                ></vue-numeric>
            </template>

            <template slot="actions" slot-scope="data">
                <a @click="deleteProduct(data.index, $event)" class="btn btn-danger btn-sm">Borar</a>
            </template>

        </v-client-table>

        <button type="submit" v-bind:disabled="!validForm" class="btn btn-primary">Guardar</button>
    </form>
</template>
 
<script>
    export default {
        data() {
            return {
                measures: [], // Labels
                recipe: {
                    lines: []
                },
                line: {}, // Selected product
                searchOptions: [],
                tableOptions: {
                    headings: {
                        name: 'Nombre',
                        measure: 'U. Medida',
                        actions: 'Acciones',
                        quantity: 'Cantidad',
                        detail: 'Detalle',
                    },
                    filterable: false,
                },
                columns: [
                    'name',
                    'measure',
                    'quantity',
                    'detail',
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
                return this.recipe.quantity > 0 && this.recipe.lines.length > 0 && this.recipe.lines.filter(item => item.pivot.quantity == 0).length == 0 && this.recipe.name
            },

            route: function()
            {
                return this.$root.base_url + '/recipes' + ( this.recipe.id ? '/' + this.recipe.id : '' )
            }
        },

        watch: {

            line: function (newLine) {

                // Distinct that recipe product
                if ( newLine && this.product.id == newLine.id )
                {
                    alert('No puedes componer un producto de sí mismo')
                }
                else if( newLine && this.recipe.lines.find(item => item.pivot.product_id == newLine.id) )
                {
                    alert('El producto ya se encuentra en la receta');
                }
                else if (newLine)
                {
                    let algo = this.recipe.lines.push({

                        name: newLine.name,
                        measure: newLine.measure,
                        pivot: {
                            product_id: newLine.id,
                        }
                    })

                    // Focus en dinamically generated input
                    let index = 'product_' + newLine.id

                    // Make reactive new property
                    this.$set(this.recipe.lines[algo - 1].pivot, 'quantity', 0)

                    this.$nextTick(() => {
                        this.$refs[index].$el.focus()
                    })

                    this.line = null
                }
            }
        },

        created: function()
        {
            // Carga de receta a editar (si la hay)
            this.recipe = this.editRecipe ? this.editRecipe : {lines: [], quantity: 0, product_id: this.product.id}

            // Etiquetas de unidades de medida.
            this.measures[1] = 'Unidad/es'
            this.measures[2] = 'Kilo/s'
            this.measures[3] = 'Litro/s'
        },

        methods: {

            deleteProduct: function(index)
            {
                this.recipe.lines.splice( index - 1, 1 )
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