/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify';
import VueCarousel from 'vue-carousel';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);
Vue.use(VueCarousel);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);


//atoms
Vue.component('custom-button', require('./components/atoms/custom-button.vue').default);
Vue.component('file-input-tag', require('./components/atoms/file-input-tag.vue').default);
Vue.component('input-text', require('./components/atoms/input-text.vue').default);
// Vue.component('magnify-button', require('./components/atoms/file-input-tag.vue').default);
Vue.component('pulldown', require('./components/atoms/pulldown.vue').default);
Vue.component('search-text', require('./components/atoms/search-text.vue').default);
Vue.component('text-area', require('./components/atoms/text-area.vue').default);

//molecules
Vue.component('button-event', require('./components/molecules/button-event.vue').default);
Vue.component('file-input', require('./components/molecules/file-input.vue').default);
// Vue.component('icon-button-event', require('./components/molecules/icon-button-event.vue').default);
Vue.component('label-text', require('./components/molecules/label-text.vue').default);
Vue.component('label-text-area', require('./components/molecules/label-text-area.vue').default);
Vue.component('pagenation', require('./components/molecules/pagenation.vue').default);
Vue.component('pulldown-event', require('./components/molecules/pulldown-event.vue').default);
Vue.component('modal', require('./components/molecules/modal.vue').default);

//organisms
Vue.component('carousel-list', require('./components/organisms/carousel-list.vue').default);
Vue.component('file-input-component', require('./components/organisms/file-input-component.vue').default);
Vue.component('text-component', require('./components/organisms/text-component.vue').default);
Vue.component('list-index', require('./components/organisms/list-index.vue').default);
Vue.component('radar-chart', require('./components/organisms/radar-chart.vue').default);
Vue.component('coordinate-pulldown', require('./components/organisms/coordinate-pulldown.vue').default);
Vue.component('modal-link', require('./components/organisms/modal-link.vue').default);
Vue.component('items-pagenate', require('./components/organisms/items-pagenate.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify()
});
