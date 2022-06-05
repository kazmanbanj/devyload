/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import Flash from './components/Flash.vue';
import Paginator from './components/Paginator.vue';
import Thread from './pages/Thread.vue';
import UserNotifications from './components/UserNotifications.vue';
import AvatarForm from './components/AvatarForm.vue';

Vue.component('flash', Flash);
Vue.component('paginator', Paginator);
Vue.component('thread-view', Thread);
Vue.component('user-notifications', UserNotifications);
Vue.component('avatar-form', AvatarForm);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.config.devtools = true;

const app = new Vue({
    el: '#app',
});
