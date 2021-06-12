<template>
    <form :action="route" method="POST">

        <div>
            <input type="hidden" name="_token" :value="$root.csrf">
            prod: <input type="text" v-for="line in regularization.lines" name="products[]" :value="line.pivot.product_id"><br>
            qtty: <input type="text" v-for="line in regularization.lines" name="qttys[]" :value="line.pivot.quantity"><br>
            type: <input type="text" v-for="line in regularization.lines" name="types[]" :value="line.pivot.type"><br>
            updt cost: <input type="text" v-for="line in regularization.lines" name="update_product_average_cost[]" :value="line.pivot.update_product_average_cost">
        </div>

        <div class="form-group">
            <label for="detail">Comentario</label>
            <input class="w-75 form-control d-inline-block" id="detail" type="text" name="detail">
        </div>

        <div class="form-group">
            <label for="product">Agregar Productos</label>
            <v-select class="w-auto d-inline-block" placeholder="Buscar" id="product" label="name" :filterable="false" v-model="line" :options="searchOptions" @search="onSearch">
              </v-select>
        </div>

        <hr>

        <v-client-table ref="myTable" :data="regularization.lines" :columns="columns" :options="tableOptions">
            <template slot="measure" slot-scope="data">
                {{ $root.measures[data.row.measure] }}
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

            <template slot="type" slot-scope="data">
                <select
                    class="form-control"
                    @input="updateLine($event, data.row.pivot.product_id, 'type')"
                    :value="data.row.pivot.type"
                    >
                    <option value='in'>Entrada</option>
                    <option value='out'>Salida</option>
                </select>
            </template>

            <template slot="update_product_average_cost" slot-scope="data">
                <select
                    class="form-control"
                    @input="updateLine($event, data.row.pivot.product_id, 'update_product_average_cost')"
                    :value="data.row.pivot.update_product_average_cost"
                    >
                    <option value='1'>Si</option>
                    <option value='0'>No</option>
                </select>
            </template>

            <template slot="name" slot-scope="data">
                <a target="_blank" :href="$root.base_url + '/products/' + data.row.pivot.product_id + '/edit'">{{ data.row.name }}</a>
            </template>

            <template slot="new_average_cost" slot-scope="data">

                <template v-if="data.row.pivot.update_product_average_cost == 1">
                    <vue-numeric
                        v-if="data.row.pivot.type == 'out'"
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.cost_decimals"
                        read-only
                        :value="( data.row.average_cost * data.row.stock ) / ( data.row.stock - data.row.pivot.quantity )"
                    ></vue-numeric>

                    <vue-numeric
                        v-else
                        separator="."
                        decimal-separator=","
                        v-bind:precision="$root.cost_decimals"
                        read-only
                        :value="( data.row.average_cost * data.row.stock ) / ( data.row.stock + data.row.pivot.quantity )"
                    ></vue-numeric>
                </template>

                <vue-numeric
                    v-else
                    separator="."
                    decimal-separator=","
                    v-bind:precision="$root.cost_decimals"
                    read-only
                    :value="data.row.average_cost"
                ></vue-numeric>
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

            <template slot="pivot.quantity" slot-scope="data">
                <vue-numeric
                    v-bind:precision="$root.precision"
                    separator="."
                    decimal-separator=","
                    :value="data.row.pivot.quantity"
                    v-bind:minus="false"
                    class="form-control w-auto"
                    :ref="'product_q_' + data.row.pivot.product_id"
                    v-bind:class="{'is-valid': data.row.pivot.quantity > 0, 'is-invalid': data.row.pivot.quantity <= 0}"
                    @input="updateLine($event, data.row.pivot.product_id, 'quantity')"
                ></vue-numeric>
            </template>

            <template slot="pivot.price_per_unit" slot-scope="data">
                <vue-numeric
                    v-bind:precision="$root.precision"
                    separator="."
                    decimal-separator=","
                    :value="data.row.pivot.price_per_unit"
                    v-bind:minus="false"
                    class="form-control w-auto"
                    :ref="'product_p_' + data.row.pivot.product_id"
                    v-bind:class="{'is-valid': data.row.pivot.price_per_unit > 0, 'is-invalid': data.row.pivot.price_per_unit <= 0}"
                    @input="updateLine($event, data.row.pivot.product_id, 'price_per_unit')"
                ></vue-numeric>
            </template>

            <template slot="pivot.total" slot-scope="data">
                <vue-numeric
                    separator="."
                    decimal-separator=","
                    v-bind:precision="$root.precision"
                    read-only
                    :value="data.row.pivot.total"
                ></vue-numeric>
            </template>

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
                regularization: {
                    lines: [],
                },
                line: null, // Selected product
                searchOptions: [],
                tableOptions: {},
                columns: [
                    'name',
                    'measure',
                    'stock',
                    'type',
                    'pivot.quantity',
                    'average_cost',
                    'update_product_average_cost',
                    'new_average_cost',
                    'actions',
                ]
            }
        },
        props: {
            editPurchase: Object,
        },
        computed: {

            validForm: function()
            {
                return this.regularization.lines.length > 0 && this.regularization.lines.filter(item => item.pivot.quantity == 0).length == 0
            },

            route: function()
            {
                return this.$root.base_url + '/regularizations' + ( this.regularization.id ? '/' + this.regularization.id : '' )
            },
        },

        watch: {

            line: function (newLine) {

                // Distinct that recipe product
                if( newLine && this.regularization.lines.find(item => item.pivot.product_id == newLine.id) )
                {
                    alert('El producto ya se encuentra en esta regularización');
                }
                else if (newLine)
                {
                    let newLineIndex = this.regularization.lines.push({

                        name: newLine.name,
                        measure: newLine.measure,
                        stock: newLine.stock,
                        average_cost: newLine.average_cost,
                        pivot: {
                            product_id: newLine.id,
                            quantity: 0,
                            type: 'in',
                            update_product_average_cost: 1
                        }
                    })

                    // Focus en dinamically generated input
                    let index = 'product_q_' + newLine.id

                    // Make reactive new property
                    this.$set(this.regularization.lines[newLineIndex - 1].pivot, 'quantity', 0)
                    this.$set(this.regularization.lines[newLineIndex - 1].pivot, 'price_per_unit', 0)
                    this.$set(this.regularization.lines[newLineIndex - 1].pivot, 'total', 0)

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
            this.purchase = this.editPurchase ? this.editPurchase : {lines: [], date: new Date}

            this.tableOptions = {...this.$root.options}
            this.tableOptions.headings.update_product_average_cost = 'Recalcular Costo Promedio'
            this.tableOptions.headings.new_average_cost = 'Nuevo Cost Promedio'
            this.tableOptions.orderBy = {
                column: 'name',
                ascending: true
            }
        },

        methods: {

            updateLine: function(value = null, product_id = null, keyOrigin = null)
            {
                let line = this.regularization.lines.find(item => item.pivot.product_id == product_id)

                if ( keyOrigin == 'quantity' )
                {
                    line.pivot.total = value * line.pivot.price_per_unit
                    line.pivot.quantity = value;
                }
                else if (keyOrigin == 'type' || keyOrigin == 'update_product_average_cost')
                {
                    line.pivot[keyOrigin] = value.target.value
                }
            },

            deleteProduct: function(product_id)
            {
                this.regularization.lines = this.regularization.lines.filter(line => line.pivot.product_id != product_id)
            },

            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.search(loading, search, this);
                }
            },

            search: _.debounce((loading, search, vm) => {
              fetch(
                vm.$root.base_url + '/search/' + '?orderBy=name&order=asc&model=Product&q=' + encodeURI(search)
              ).then(res => {

                res.json().then(json => (vm.searchOptions = json));
                loading(false);
              });
            }, 350)
          }
    }
</script>