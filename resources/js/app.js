// bootstrap, jquery, gerekli kütüphaneler burada

require('./bootstrap');

window.Vue = require('vue');

//tarih saat kütüphanesş
import moment from 'moment';
Vue.use(require('vue-moment'));
//dil seçimi
Vue.prototype.$lang="tr";

Vue.config.productionTip = false

//  grafikler
import VueCharts from 'vue-chartjs'
import { Bar, Line } from 'vue-chartjs'

//sweetalert kütüphanesi
import swal from 'sweetalert2'
window.swal = swal;

// sweetalertin üstte görünen versiyonu
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

//dosya yüklemek için
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

//translations

import translations from '../../public/js/lang.json'
Vue.prototype.$trans = translations;

// vform kütüphanesi
import { Form, HasError, AlertError } from 'vform';

window.Form=Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//Kullanıcı yetkilendirmeleri
import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

//Axios kütüphanesi backendle iletişim için
window.axios = require('axios');

// linklerin yönetimi için
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//uyarı mesajlarının yönetimi için
import VueProgressBar from 'vue-progressbar'

//datetimepicker
import datePicker from 'vue-bootstrap-datetimepicker';
import 'bootstrap/dist/css/bootstrap.css';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
Vue.use(datePicker);
jQuery.extend(true, jQuery.fn.datetimepicker.defaults, {
    icons: {
        time: 'far fa-clock',
        date: 'far fa-calendar',
        up: 'fas fa-arrow-up',
        down: 'fas fa-arrow-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        today: 'fas fa-calendar-check',
        clear: 'far fa-trash-alt',
        close: 'far fa-times-circle'
    }
});

Vue.use(VueProgressBar, {
    color: 'blue',
    failedColor: 'red',
    height: '50px'
})

//  Componentler
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('passport-clients', require('./components/passport/Clients.vue').default);
Vue.component('passport-authorized-clients',require('./components/passport/AuthorizedClients.vue').default);
Vue.component('passport-personal-access-tokens',require('./components/passport/PersonalAccessTokens.vue').default);
Vue.component('not-found',require('./components/NotFound.vue').default);

// Page Components

let routes = [
    { path: '/', component: require('./components/Dashboard.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/registerpage', component: require('./components/registerpage.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/users.vue').default },
    { path: '/sss', component: require('./components/sss.vue').default },
    { path: '/profile', component: require('./components/profile.vue').default },
    { path: '/contactinfo', component: require('./components/contactinfo.vue').default },
    { path: '/socialmedia', component: require('./components/Socialmedia.vue').default },
    { path: '/carousel', component: require('./components/caruselmain.vue').default },
    { path: '/carouselalt', component: require('./components/caruselalt.vue').default },
    { path: '/settings', component: require('./components/settings.vue').default },
    { path: '/blog-categories', component: require('./components/blog/categories.vue').default },
    { path: '/blog-posts', component: require('./components/blog/posts.vue').default },
    { path: '/home-extras', component: require('./components/extras.vue').default },
    { path: '/contactus', component: require('./components/contactus.vue').default },
    { path: '/pages', component: require('./components/pages.vue').default },
    { path: '/regs', component: require('./components/regapplications.vue').default },
    { path: '/ourteam', component: require('./components/ourteam.vue').default },
    { path: '/activities', component: require('./components/activities/icerikolustur.vue').default },
    { path: '/activitycreator', component: require('./components/activities/creator.vue').default },
    { path: '/employees', component: require('./components/employees/creator.vue').default },

    { path: '/affiliates', component: require('./components/affiliates/icerikolustur.vue').default },
    { path: '/hizmettur', component: require('./components/hizmetler/hizmettur.vue').default },
    { path: '/althizmettur', component: require('./components/hizmetler/althizmettur.vue').default },
    { path: '/icerikolustur', component: require('./components/hizmetler/icerikolustur.vue').default },
    { path: '/sayfaolustur', component: require('./components/sayfalar/icerikolustur.vue').default },
    { path: '/blogolustur', component: require('./components/bloglar/icerikolustur.vue').default },
    { path: '/caruselolustur', component: require('./components/carousel/icerikolustur.vue').default },
    { path: '/galeryolustur', component: require('./components/galery/icerikolustur.vue').default },
    { path: '/commentolustur', component: require('./components/comments/icerikolustur.vue').default },
    { path: '/konaklamaolustur', component: require('./components/konaklama/icerikolustur.vue').default },
    { path: '/makaleyorumlari', component: require('./components/bloglar/comments.vue').default },
    { path: '/dilsecenekleri', component: require('./components/localization.vue').default },

    { path: '*', component: require('./components/NotFound.vue').default }

]

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active'
})

Vue.filter('upText',function(text) {
    if (!text) return ''
    text = text.toString()
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate',function(created) {
    return moment(created).format('MMM Do YY');
});
Vue.filter('difDate',function(created) {
    return moment(created).add(3, 'h');
});
window.Fire = new Vue();



const app = new Vue({
    el: '#app',
    router,
    data: {
        search: ''
    },
     methods: {
        searchit: _.debounce(() => {
             Fire.$emit('searching');
        },1000),

        printme() { window.print();  }
    }
});
