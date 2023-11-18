import './bootstrap';
import Vuex from 'vuex';

window.Vue = require('vue').default;

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        item: {},
        transacao: {
            status: '',
            mensagem: '',
            dados: ''
        }
    }
});

Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('home-component', require('./components/Home.vue').default);
Vue.component('marcas-component', require('./components/Marcas.vue').default);
Vue.component('modelos-component', require('./components/Modelos.vue').default);
Vue.component('input-container-component', require('./components/InputContainer.vue').default);
Vue.component('table-component', require('./components/Table.vue').default);
Vue.component('card-component', require('./components/Card.vue').default);
Vue.component('modal-component', require('./components/Modal.vue').default);
Vue.component('alert-component', require('./components/Alert.vue').default);
Vue.component('paginate-component', require('./components/Paginate.vue').default);

Vue.filter('formataDataTempoGlobal', function (dt) {
    if (!dt) return '';

    dt = dt.split('T');

    let data = dt[0];
    let tempo = dt[1];

    data = data.split('-');
    tempo = tempo.split('.');

    return `${data[2]}/${data[1]}/${data[0]} ${tempo[0]}`;
});

const app = new Vue({
    el: '#app',
    store
});
