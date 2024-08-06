
import './bootstrap';
import Vue from 'vue';
import Vuetify from 'vuetify'
import App from './App.vue';
import router from './route';

window.Vue = Vue;

Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    router: router,
    render: h => h(App)
});
