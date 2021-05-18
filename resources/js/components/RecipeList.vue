<template>
    <div>
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
</template>
 
<script>
    export default {
        data() {
            return {
                recipes: [],
                options: {
                    perPage: 10,
                    headings: {
                        id: 'ID',
                        name: 'Nombre',
                        detail: 'Descripción',
                        quantity: 'Cantidad Producida',
                        extra_cost: 'Costo Extra',
                        actions: 'Acciones',
                    },

                },
                columns: [
                    'id',
                    'name',
                    'detail',
                    'quantity',
                    'extra_cost',
                    'actions',
                ],
            }
        },
        props: {product: Object},

        async mounted() {
            this.recipes = this.product.recipes
            $(".VueTables__search").removeClass('form-inline')

            this.$refs.myTable.setRequestParams({
                order:{column:'name',ascending:true},
                customFilters:{
                    model: 'Recipe',
                    filters: '{"product_id":"1"}'
                }
            })
        },

        methods: {

            deleteRecipe(id, e) {

                let confirm = window.confirm('Estás seguro de borrar esta receta ? Toda la información asociada a la misma se perderá.');

                if ( confirm )
                {
                    this.axios
                        .delete(this.$root.base_url + '/recipes/' + id)
                        .then(response => {
                            let i = this.product.recipes.map(data => data.id).indexOf(id);
                            this.product.recipes.splice(i, 1)
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