<template>
    <form :action="route" method="POST">

        <input type="hidden" name="_token" :value="$root.csrf">
        <input type="hidden" name="product_id" :value="product.id">

        <div class="form-group">
            <input type="text" name="name" placeholder="Pan">
            <small class="form-text text-muted">Buscar ingredientes.</small>
        </div>

        <button type="submit" v-bind:disabled="!validForm" class="btn btn-primary">Guardar</button>
    </form>
</template>
 
<script>
    export default {
        data() {
            return {
                recipe: {},
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
                return this.$root.base_url + '/recipes' + ( this.recipe.id ? '/' + this.recipe.id : '' )
            }
        },

        created: function()
        {
            this.recipe = this.editRecipe ? this.editRecipe : {}
        }
    }
</script>