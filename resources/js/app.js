/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueAxios from 'vue-axios';
import axios from 'axios';
import {ServerTable, ClientTable, Event} from 'vue-tables-2';
import vSelect from 'vue-select';
import VueNumeric from 'vue-numeric'
import moment from 'moment';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(ClientTable, {}, false, 'bootstrap4')
Vue.use(ServerTable, {}, false, 'bootstrap4')
Vue.use(VueAxios, axios);
Vue.component('v-select', vSelect)
Vue.use(VueNumeric)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('product-list', require('./components/ProductList.vue').default);
Vue.component('product-form', require('./components/ProductForm.vue').default);
Vue.component('recipe-list', require('./components/RecipeList.vue').default);
Vue.component('recipe-form', require('./components/RecipeForm.vue').default);
Vue.component('purchase-list', require('./components/PurchaseList.vue').default);
Vue.component('purchase-form', require('./components/PurchaseForm.vue').default);
// Vue.component('product-form', require('./components/ProductForm.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: () => ({
    	date_format: 'DD/MM/YYYY',
    	moment: moment,
		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
		base_url: document.querySelector('meta[name="base-url"]').getAttribute('content'),
		precision: parseInt(document.querySelector('meta[name="precision"]').getAttribute('content')), // For qttys
		options: {
            sortIcon: { base:'fas', up:'fa-sort-down', down:'fa-sort-up', is:'fa-sort' },
            filterable: false,
            sortable: [],
            headings: {
            	date: 'Fecha',
                'pivot.id': 'ID',
                'pivot.price_per_unit': 'Precio por Unidad',
                'pivot.quantity': 'Cantidad',
                'pivot.total': 'Total',
                'product.name': 'Producto',
                actions: 'Acciones',
                detail: 'Descripción',
                extra_cost: 'Costo Extra',
                id: 'ID',
                measure: 'U. Medida',
                name: 'Nombre',
                productions: 'Producción',
                quantity: 'Cantidad Producida',
                sales: 'Ventas',
                shoppings: 'Compras',
                supplier: 'Proveedor',
                total: 'Total',
            },
            cellClasses:{
                total: [{
                    class:'text-right',
                    condition: row => true
                }],
                date: [{
                    class:'text-center',
                    condition: row => true
                }],
                'pivot.price_per_unit': [{
                    class:'text-right',
                    condition: row => true
                }],
                'pivot.quantity': [{
                    class:'text-right',
                    condition: row => true
                }],
                'pivot.total': [{
                    class:'text-right',
                    condition: row => true
                }],
                stock: [{
                    class:'text-right',
                    condition: row => true
                }]
            },
        },
	}),
	mounted: function()
	{
		$(".VueTables__search").removeClass('form-inline')
	}
});
