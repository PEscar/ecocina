<template>
    <form :action="route" method="POST">

        <input type="hidden" name="_token" :value="$root.csrf">
        <input type="hidden" name="date" :value="purchase.date ? $root.moment(purchase.date).format('YYYY-MM-DD') : ''">
        <input type="hidden" v-for="line in purchase.lines" name="products[]" :value="line.pivot.product_id">
        <input type="hidden" v-for="line in purchase.lines" name="qttys[]" :value="line.pivot.quantity">
        <input type="hidden" v-for="line in purchase.lines" name="prices[]" :value="line.pivot.price_per_unit">
        <input type="hidden" v-for="line in purchase.lines" name="totals[]" :value="line.pivot.total">

        <div class="form-group">
            <label for="supplier">Proveedor</label>
            <input type="text" v-model="purchase.supplier" id="supplier" class="form-control w-auto d-inline" v-bind:class="{'is-valid': purchase.supplier, 'is-invalid': !purchase.supplier}" name="supplier">
        </div>

        <div class="form-group">
            <label for="date">Fecha</label>
            <v-datepicker
                :clear-button=true
                :language="$root.datepicker_langs[$root.user_lang]"
                placeholder="DD/MM/AAAA"
                class="form-control w-auto d-inline-block"
                v-model="purchase.date"
                :format="$root.datepicker_date_format"
                v-bind:class="{ 'is-valid' : purchase.date, 'is-invalid' : !purchase.date }"
            ></v-datepicker>
        </div>

        <div class="form-group">
            <label for="product">Agregar Productos</label>
            <v-select class="w-auto d-inline-block" placeholder="Buscar" id="product" label="name" :filterable="false" v-model="line" :options="searchOptions" @search="onSearch">
              </v-select>
        </div>

        <hr>

        <div class="form-group float-right font-weight-bold">
            <label for="date">Total:&nbsp;</label>
            <vue-numeric
                separator="."
                decimal-separator=","
                v-bind:precision="$root.precision"
                read-only
                :value="purchase.total"
            ></vue-numeric>
        </div>

        <v-client-table ref="myTable" :data="purchase.lines" :columns="columns" :options="tableOptions">
            <template slot="measure" slot-scope="data">
                {{ $root.measures[data.row.measure] }}
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
                purchase: {
                    lines: []
                },
                line: null, // Selected product
                searchOptions: [],
                tableOptions: {
                    headings: {
                        name: 'Nombre',
                        measure: 'U. Medida',
                        actions: 'Acciones',
                        'pivot.quantity': 'Cantidad',
                        'pivot.price_per_unit': 'Precio U.',
                        'pivot.total': 'Total',
                    },
                    filterable: false,
                    cellClasses:{
                        'pivot.total': [{
                            class:'text-right',
                            condition: row => true
                        }],
                    },
                    orderBy:{
                        column: 'name',
                        ascending: true   
                    },
                },
                columns: [
                    'name',
                    'measure',
                    'pivot.quantity',
                    'pivot.price_per_unit',
                    'pivot.total',
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
                return this.purchase.lines.length > 0 && this.purchase.lines.filter(item => item.pivot.quantity == 0 || item.pivot.price_per_unit == 0).length == 0 && this.purchase.supplier
            },

            route: function()
            {
                return this.$root.base_url + '/purchases' + ( this.purchase.id ? '/' + this.purchase.id : '' )
            },
        },

        watch: {

            line: function (newLine) {

                // Distinct that recipe product
                if( newLine && this.purchase.lines.find(item => item.pivot.product_id == newLine.id) )
                {
                    alert('El producto ya se encuentra en esta compra');
                }
                else if (newLine)
                {
                    let newLineIndex = this.purchase.lines.push({

                        name: newLine.name,
                        measure: newLine.measure,
                        pivot: {
                            product_id: newLine.id,
                            total: 0,
                            quantity: 0,
                            price_per_unit: 0,
                        }
                    })

                    // Focus en dinamically generated input
                    let index = 'product_q_' + newLine.id

                    // Make reactive new property
                    this.$set(this.purchase.lines[newLineIndex - 1].pivot, 'quantity', 0)
                    this.$set(this.purchase.lines[newLineIndex - 1].pivot, 'price_per_unit', 0)
                    this.$set(this.purchase.lines[newLineIndex - 1].pivot, 'total', 0)

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
            this.purchase = this.editPurchase ? this.editPurchase : {lines: []}
        },

        methods: {

            updateLine: function(value = null, product_id = null, keyOrigin = null)
            {
                let line = this.purchase.lines.find(item => item.pivot.product_id == product_id)

                if ( keyOrigin == 'quantity' )
                {
                    line.pivot.total = value * line.pivot.price_per_unit
                    line.pivot.quantity = value;
                }
                else if (keyOrigin == 'price_per_unit')
                {
                    line.pivot.total = value * line.pivot.quantity
                    line.pivot.price_per_unit = value;
                }

                this.updateTotal()
            },

            updateTotal: function()
            {
                this.purchase.total = this.purchase.lines.reduce( function(a, b){
                    return a + b.pivot.total;
                }, 0)
            },

            deleteProduct: function(product_id)
            {
                this.purchase.lines = this.purchase.lines.filter(line => line.id != product_id)
                this.updateTotal()
            },

            onSearch(search, loading) {
                if(search.length) {
                    loading(true);
                    this.search(loading, search, this);
                }
            },

            search: _.debounce((loading, search, vm) => {
              fetch(
                vm.$root.base_url + '/search/' + '?filters[purchases]=1&orderBy=name&order=asc&model=Product&q=' + encodeURI(search)
              ).then(res => {

                res.json().then(json => (vm.searchOptions = json));
                loading(false);
              });
            }, 350)
          }
    }
</script>