require('./bootstrap');

window.Vue = require('vue');

import Form from './Form'
window.Form = Form

Vue.component('invoice-home-component', require('./components/InvoiceHomeComponent.vue').default);

const app = new Vue({
    el: '#app',
});
