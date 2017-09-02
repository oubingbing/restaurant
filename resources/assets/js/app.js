
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
require('vue-resource');

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';

Vue.use(ElementUI);

Vue.prototype.configs = require('./config.js');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('login', require('./components/Login.vue'));
Vue.component('adminIndex', require('./components/AdminIndex.vue'));
Vue.component('adminRestaurant', require('./components/AdminRestaurant.vue'));
Vue.component('employeeIndex', require('./components/EmployeeIndex.vue'));
Vue.component('activateAccount', require('./components/ActivateAccount.vue'));
Vue.component('calendar', require('./components/Calendar.vue'));
Vue.component('material', require('./components/Material.vue'));


const app = new Vue({
    el: '#app',
    mounted() {
        Vue.http.interceptors.push(function(request, next) {
            var token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
            request.headers.set('X-CSRF-TOKEN', token);
            next();
        });
    },
});
