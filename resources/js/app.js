import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import VueTheMask from 'vue-the-mask';
import Vuelidate from 'vuelidate';
import Notifications from 'vue-notification'

Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(VueTheMask);
Vue.use(Vuelidate);
Vue.use(Notifications);

import App from './views/App';
import Home from './views/Home';
import PropertiesIndex from './views/PropertiesIndex';
import PropertiesCreate from './views/PropertiesCreate';
import PropertiesEdit from './views/PropertiesEdit';
import ContractsIndex from './views/ContractsIndex';
import ContractsCreate from './views/ContractsCreate';
import ContractsEdit from './views/ContractsEdit';
import NotFound from './views/NotFound';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            title: 'Home',
            path: '/',
            name: 'home',
            component: Home
        },
        {
            title: 'Propriedades',
            path: '/properties',
            name: 'properties.index',
            component: PropertiesIndex
        },
        {
            path: '/properties/create',
            name: 'properties.create',
            component: PropertiesCreate
        },
        {
            path: '/properties/:id/edit',
            name: 'properties.edit',
            component: PropertiesEdit,
        },
        {
            title: 'Contratos',
            path: '/contracts',
            name: 'contracts.index',
            component: ContractsIndex
        },
        {
            path: '/contracts/create',
            name: 'contracts.create',
            component: ContractsCreate
        },
        {
            path: '/contracts/:id/edit',
            name: 'contracts.edit',
            component: ContractsEdit,
        },
        { path: '/404', name: '404', component: NotFound },
        { path: '*', redirect: '/404' },
    ],
});

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    components: { App },
    router,
});