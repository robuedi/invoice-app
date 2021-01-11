require('./bootstrap');


window.Vue = require('vue');

Vue.component('invoice-index-component', require('./components/InvoiceIndextComponent.vue').default);
Vue.component('invoice-location-component', require('./components/InvoiceLocationComponent.vue').default);

const app = new Vue({
    el: '#app',
});
