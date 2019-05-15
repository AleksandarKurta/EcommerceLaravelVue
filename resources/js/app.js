
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import Vuex from 'vuex';
import { Form, HasError, AlertError } from 'vform'
import { routes } from './routes'
import moment from 'moment'
import VueProgressBar from 'vue-progressbar'
import PrettyCheckbox from 'pretty-checkbox-vue';
import Gate from './Gate';

Vue.use(VueRouter)
Vue.use(Vuex)

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('welcome', require('./components/Welcome.vue').default );

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});

// Filter - first char to uppercase
Vue.filter('TextUppercase', function(text){
    return text[0].toUpperCase() + text.slice(1);
});

// Filter - date
Vue.filter('dateFilter', function(date){
    return moment(date).format('MMMM Do YYYY');
})

Vue.use(PrettyCheckbox);

// Vue Progress bar
const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
      speed: '0.5s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
  }
Vue.use(VueProgressBar, options)

// SweetAlert
import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

// Fire global event
window.Fire = new Vue();

//Gate Auth
Vue.prototype.$gate = new Gate(window.user);

//Register global component
Vue.component(
    'app-not-found',
    require('./components/NotFound.vue').default
);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('front-products', require('./components/FrontProducts.vue').default);

const app = new Vue({
    el: '#app',
    router,
    data: {
        search: ''
    },
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        }, 300),
        printme() {
            window.print();
        }          
    }
});
