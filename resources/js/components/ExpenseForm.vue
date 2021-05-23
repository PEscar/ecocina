<template>
    <form :action="route" method="POST">

        <input type="hidden" name="_token" :value="$root.csrf">
        <input type="hidden" name="date" :value="expense.date ? $root.moment(expense.date).format('YYYY-MM-DD') : ''">
        <input type="hidden" name="total" :value="expense.total">

        <div class="form-group">
            <label>Nombre </label>
            <input type="text" name="name" class="form-control w-auto d-inline" v-model="expense.name" v-bind:class="{ 'is-valid' : expense.name, 'is-invalid' : !expense.name }" placeholder="Alquiler Enero">
        </div>

        <div class="form-group">
            <label for="date">Fecha </label>
            <v-datepicker
                :clear-button=true
                :language="$root.datepicker_langs[$root.user_lang]"
                placeholder="DD/MM/AAAA"
                class="form-control w-auto d-inline-block"
                v-model="expense.date"
                :format="$root.datepicker_date_format"
                v-bind:class="{ 'is-valid' : expense.date, 'is-invalid' : !expense.date }"
                :highlighted="$root.highlighted_dates"
            ></v-datepicker>
        </div>

        <div class="form-group">
            <label for="total">Total </label>
            <vue-numeric
                    v-bind:precision="$root.precision"
                    separator="."
                    decimal-separator=","
                    v-model="expense.total"
                    v-bind:minus="false"
                    class="form-control w-auto d-inline-block"
                    v-bind:class="{'is-valid': expense.total > 0, 'is-invalid': expense.total <= 0}"
                ></vue-numeric>
        </div>

        <button type="submit" v-bind:disabled="!validForm" class="btn btn-primary">Guardar</button>
    </form>
</template>
 
<script>
    export default {
        data() {
            return {
                expense: {},
            }
        },
        props: {
            editExpense: Object
        },
        computed: {
            validForm: function()
            {
                return this.expense.name && this.expense.date && this.expense.total > 0
            },

            route: function()
            {
                return this.$root.base_url + '/expenses' + ( this.expense.id ? '/' + this.expense.id : '' )
            }
        },

        created: function()
        {
            this.expense = this.editExpense ? this.editExpense : {total: 0}
        }
    }
</script>