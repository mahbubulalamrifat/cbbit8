import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import er404 from '../pages/common/404.vue'


import BU from './../pages/bu/index.vue'

import InternetAccessRequest from './../pages/form/internet_access_request.vue'
import AccountAuthorityRequest from './../pages/form/account_authority_request.vue'
import EmailRequest from './../pages/form/email_request.vue'
import GuestRequest from './../pages/form/guest_request.vue'


const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/iaccess/admin', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'Admin Demo Dashboard',
            },   
        },

        { 
            path: '/iaccess/admin/bu', 
            component: BU,
            name: 'BU',
            meta:{
                title: 'Admin iAccess BU',
            },   
        },

        { 
            path: '/iaccess/admin/internet-access', 
            component: InternetAccessRequest,
            name: 'InternetAccessRequest',
            meta:{
                title: 'Admin Internet Access Request',
            },   
        },

        { 
            path: '/iaccess/admin/account-authority', 
            component: AccountAuthorityRequest,
            name: 'AccountAuthorityRequest',
            meta:{
                title: 'Admin Account Authority Request',
            },   
        },

        { 
            path: '/iaccess/admin/email-request', 
            component: EmailRequest,
            name: 'EmailRequest',
            meta:{
                title: 'Admin Email Request',
            },   
        },

        { 
            path: '/iaccess/admin/guest-request', 
            component: GuestRequest,
            name: 'GuestRequest',
            meta:{
                title: 'Admin Guest Request',
            },   
        },

        


        { 
            path: '/iaccess/admin/*', 
            component: er404,
            name: 'er404',
            meta:{
                title: 'Super Admin 404',
            },   
        },

    ]
});


// Run brfore every route request
router.beforeEach( (to, from, next) => {
    // console.log(to, to.meta);
 
    let appName = 'CPB-IT';
    let title = to.meta && to.meta.title ? to.meta.title : '';
    // set current title
    document.title =`${ appName } ${ title }`;

    next();
});


export default router;