require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('login-component', require('./components/Login.vue').default);

const app = new Vue({
    el: '#app',
});
