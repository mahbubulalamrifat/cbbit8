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

// verified
import VerifyInternetAccessRequest from './../pages/verify/internet_access_request.vue'
import VerifyAccountAuthorityRequest from './../pages/verify/account_authority_request.vue'
import VerifyEmailRequest from './../pages/verify/email_request.vue'
import VerifyGuestRequest from './../pages/verify/guest_request.vue'

// rejected
import RejectInternetAccessRequest from './../pages/reject/internet_access_request.vue'
import RejectAccountAuthorityRequest from './../pages/reject/account_authority_request.vue'
import RejectEmailRequest from './../pages/reject/email_request.vue'
import RejectGuestRequest from './../pages/reject/guest_request.vue'


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

        // verified
        { 
            path: '/iaccess/admin/verify-internet-access', 
            component: VerifyInternetAccessRequest,
            name: 'VerifyInternetAccessRequest',
            meta:{
                title: 'Admin Verified Internet Access Request',
            },   
        },

        { 
            path: '/iaccess/admin/verify-account-authority', 
            component: VerifyAccountAuthorityRequest,
            name: 'VerifyAccountAuthorityRequest',
            meta:{
                title: 'Admin Verified Account Authority Request',
            },   
        },

        { 
            path: '/iaccess/admin/verify-email-request', 
            component: VerifyEmailRequest,
            name: 'VerifyEmailRequest',
            meta:{
                title: 'Admin Verified Email Request',
            },   
        },

        { 
            path: '/iaccess/admin/verify-guest-request', 
            component: VerifyGuestRequest,
            name: 'VerifyGuestRequest',
            meta:{
                title: 'Admin Verified Guest Request',
            },   
        },


        // rejected
        { 
            path: '/iaccess/admin/reject-internet-access', 
            component: RejectInternetAccessRequest,
            name: 'RejectInternetAccessRequest',
            meta:{
                title: 'Admin Verified Internet Access Request',
            },   
        },

        { 
            path: '/iaccess/admin/reject-account-authority', 
            component: RejectAccountAuthorityRequest,
            name: 'RejectAccountAuthorityRequest',
            meta:{
                title: 'Admin Verified Account Authority Request',
            },   
        },

        { 
            path: '/iaccess/admin/reject-email-request', 
            component: RejectEmailRequest,
            name: 'RejectEmailRequest',
            meta:{
                title: 'Admin Verified Email Request',
            },   
        },

        { 
            path: '/iaccess/admin/reject-guest-request', 
            component: RejectGuestRequest,
            name: 'RejectGuestRequest',
            meta:{
                title: 'Admin Verified Guest Request',
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