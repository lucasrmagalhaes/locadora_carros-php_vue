require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('home-component', require('./components/Home.vue').default);

const app = new Vue({
    el: '#app',
});
