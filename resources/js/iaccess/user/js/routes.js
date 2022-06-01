import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from '../pages/dashboard.vue'
import status from '../pages/status.vue'
import er404 from '../pages/common/404.vue'

import Approve from './../pages/approve/index.vue'

// History
import HistoryIWaccess from './../pages/history/internet_access_request.vue'
import HistoryAccountAuthority from './../pages/history/account_authority_request.vue'
import HistoryEmailRequest from './../pages/history/email_request.vue'
import HistoryGuestUser from './../pages/history/guest_user_request.vue'


const router = new VueRouter({
    mode: 'history',
    routes : [

        { 
            path: '/iaccess', 
            component: Dashboard,
            name: 'Dashboard',
            meta:{
                title: 'iAccess Dashboard',
            },   
        },

        { 
            path: '/iaccess/history-iw', 
            component: HistoryIWaccess,
            name: 'HistoryIWaccess',
            meta:{
                title: 'iAccess History I.W. Access',
            },   
        },

        { 
            path: '/iaccess/history-acc', 
            component: HistoryAccountAuthority,
            name: 'HistoryAccountAuthority',
            meta:{
                title: 'iAccess ACcount/Authority Request',
            },   
        },

        { 
            path: '/iaccess/history-email', 
            component: HistoryEmailRequest,
            name: 'HistoryEmailRequest',
            meta:{
                title: 'iAccess History Email Request',
            },   
        },
        { 
            path: '/iaccess/history-guest', 
            component: HistoryGuestUser,
            name: 'HistoryGuestUser',
            meta:{
                title: 'iAccess History Guest User',
            },   
        },

        // {  
        //     path: '/iaccess/iwaccess/approve', 
        //     component: Approve,
        //     name: 'Approve',
        //     meta:{
        //         title: 'iAccess Approve Status',
        //     },   
        // },
       
        


        { 
            path: '/demo/*', 
            component: er404,
            name: 'er404',
            meta:{
                title: 'iAccesss 404',
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