
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

// other component
Vue.component('loginas', require('./components/LoginAs.vue'));
Vue.component('signupas', require('./components/SignUpAs.vue'));
Vue.component('premiumpage', require('./components/PremiumPage.vue'));

// customer
Vue.component('logincustomer', require('./components/customers/Login.vue'));
Vue.component('registercustomer', require('./components/customers/Register.vue'));
Vue.component('customerdashboard', require('./components/customers/Dashboard.vue'));
Vue.component('customereditaccount', require('./components/customers/SettingAccount.vue'));
Vue.component('bookingvendor', require('./components/customers/BookingVendor.vue'));
Vue.component('editbookingvendor', require('./components/customers/EditBooking.vue'));
Vue.component('customermainorder', require('./components/customers/orders/MainOrders.vue'));
Vue.component('customersummaryorder', require('./components/customers/orders/SummaryOrder.vue'));
Vue.component('customerorderlist', require('./components/customers/orders/ListTransaction.vue'));
Vue.component('lupapasswordcustomer', require('./components/customers/LupaPassword.vue'));
Vue.component('changepasswordcustomer', require('./components/customers/ChangePassword.vue'));
//customer

// vendor
Vue.component('registervendor', require('./components/vendors/Register.vue'));
Vue.component('loginvendor', require('./components/vendors/Login.vue'));
Vue.component('vendoreditaccount', require('./components/vendors/SettingAccount.vue'));
Vue.component('vendorportfolio', require('./components/vendors/Portfolio.vue'));
Vue.component('vendorportfolioimages', require('./components/vendors/PortfolioImage.vue'));
Vue.component('vendororderlist', require('./components/vendors/orders/ListTransaction.vue'));
Vue.component('vendorsummaryorder', require('./components/vendors/orders/SummaryOrder.vue'));
Vue.component('lupapasswordvendor', require('./components/vendors/LupaPassword.vue'));
Vue.component('changepasswordvendor', require('./components/vendors/ChangePassword.vue'));
Vue.component('withdrawvendor', require('./components/vendors/Withdraw.vue'));
Vue.component('messagevendor', require('./components/vendors/Messages.vue'));
// vendor

Vue.component('discoveryvendor', require('./components/DiscoveryVendor.vue'));
Vue.component('getdetailvendor', require('./components/DetailVendor.vue'));

const app = new Vue({
    el: '#app',
    data: {
      statusTransaction: {
        'approval': 'Menunggu Diterima',
        'approved': 'Pesanan Diterima',
        'rejected': 'Pesanan ditolak',
        'pending': 'Pesanan ditunda',
        'payment_waiting': 'Menunggu Pembayaran',
        'payment_verify': 'Verifikasi Pembayaran',
        'paid': 'Dibayar',
        'process': 'Sedang diproses',
        'onprogress': 'Sedang dikerjakan',
        'report': 'Laporan Terlampir',
        'done': 'Selesai',
        'cancel': 'Pesanan Dibatalkan'
      }
    }
});
