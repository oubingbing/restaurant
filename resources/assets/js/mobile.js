/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
require('vue-resource');

import Mint from 'mint-ui';
import 'mint-ui/lib/style.css'

Vue.use(Mint);

Vue.prototype.configs = require('./config.js');

Vue.component('login', require('./components/mobile/Login.vue'));
Vue.component('sign', require('./components/mobile/Sign.vue'));
Vue.component('purchase', require('./components/mobile/purchase.vue'));

import {Tabbar, TabItem, Navbar, TabContainer, TabContainerItem} from 'mint-ui';

Vue.component('mt-tabbar', Tabbar);
Vue.component('mt-tab-item', TabItem);
Vue.component('mt-navbar', Navbar);
Vue.component('mt-tab-container', TabContainer);
Vue.component('mt-tab-container-item', TabContainerItem);


const app = new Vue({
    el: '#app',
    mounted() {
        Vue.http.interceptors.push(function (request, next) {
            var token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
            request.headers.set('X-CSRF-TOKEN', token);
            next();
        });
    },
});
