
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('login-section', require('./components/administrator/Login.vue'));
Vue.component('cpusers-section', require('./components/administrator/Users.vue'));
Vue.component('cpbankpayment-section', require('./components/administrator/BankPayment.vue'));
Vue.component('cpbankcustomer-section', require('./components/administrator/BankCustomer.vue'));
Vue.component('provinsi-section', require('./components/administrator/Provinsi.vue'));
Vue.component('kabupaten-section', require('./components/administrator/Kabupaten.vue'));

const app = new Vue({
    el: '#app'
});
