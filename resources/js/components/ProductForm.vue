<template>
    <form :action="route" method="POST">

        <input type="hidden" name="_token" :value="$root.csrf">

        <div class="form-group">
            <input type="text" name="name" class="form-control" v-model="product.name" v-bind:class="{ 'is-valid' : product.name, 'is-invalid' : !product.name }" placeholder="Carne Picada">
            <small class="form-text text-muted">Nombre del producto.</small>
        </div>

        <div class="form-group">
            <input type="text" name="detail" class="form-control" v-model="product.detail" placeholder="Carne de vaca molida">
            <small class="form-text text-muted">Descripción del producto.</small>
        </div>

        <div class="form-group">
            <div class="form-radio d-inline">
                <input name="measure" class="form-radio-input" id="unit" v-model="product.measure" type="radio" value="1">
                <label class="form-radio-label" for="unit">
                Unidades
                </label>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div class="form-radio d-inline">
                <input name="measure" class="form-radio-input" id="kg" v-model="product.measure" type="radio" value="2">
                <label class="form-radio-label" for="kg">
                Kilo
                </label>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div class="form-radio d-inline">
                <input name="measure" class="form-radio-input" id="lt" v-model="product.measure" type="radio" value="3">
                <label class="form-radio-label" for="lt">
                Litro
                </label>
            </div>

            <small v-if="!product.measure" class="form-text text-danger">Debes seleccionar unidad de medida.</small>
        </div>

        <div class="form-group">
            <div class="form-check d-inline-block">
                <input type="hidden" name="sales" v-if="!product.sales" value="0">
                <input name="sales" class="form-check-input" id="sales" v-model="product.sales" type="checkbox" value="1">
                <label class="form-check-label" for="sales">
                Ventas
                </label>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div class="form-check d-inline-block">
                <input type="hidden" name="shoppings" v-if="!product.shoppings" value="0">
                <input name="shoppings" class="form-check-input" id="shoppings" v-model="product.shoppings" type="checkbox" value="1">
                <label class="form-check-label" for="shoppings">
                Compras
                </label>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div class="form-check d-inline-block">
                <input type="hidden" name="productions" v-if="!product.productions" value="0">
                <input name="productions" class="form-check-input" id="productions" v-model="product.productions" type="checkbox" value="1">
                <label class="form-check-label" for="productions">
                Producción
                </label>
            </div>

            <small v-if="!product.sales && !product.shoppings && !product.productions" class="form-text text-danger">Debes seleccionar por lo menos un uso del producto.</small>
        </div>

        <button type="submit" v-bind:disabled="!validForm" class="btn btn-primary">Guardar</button>
    </form>
</template>
 
<script>
    export default {
        data() {
            return {
                product: {},
            }
        },
        props: {
            editProduct: Object
        },
        computed: {
            validForm: function()
            {
                return this.product.name && ( this.product.sales || this.product.shoppings || this.product.productions ) && this.product.measure
            },

            route: function()
            {
                return this.$root.base_url + '/products' + ( this.product.id ? '/' + this.product.id : '' )
            }
        },

        created: function()
        {
            this.product = this.editProduct ? this.editProduct : {}
        }
    }
</script>