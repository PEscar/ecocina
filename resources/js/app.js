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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(ClientTable);
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
// Vue.component('product-form', require('./components/ProductForm.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: () => ({
		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
		base_url: document.querySelector('meta[name="base-url"]').getAttribute('content'),
		precision: parseInt(document.querySelector('meta[name="precision"]').getAttribute('content')), // For qttys
	})
});
