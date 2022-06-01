import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


export default new Vuex.Store({

    state : {
        auth  : null,
        roles : null,
        draft: null,
        CountNotProcess: null,
        CountProcess: null,
        CountDeliverable: null,
        CountService: null,
        CountServiceAccess: null,

        ConuntHOService: null,
        ConuntHOServiceAccess: null,
        AllZoneOfficesAssign:[],

        CountAppDamage: null,
        CountAppPartialDamage: null,
        CountNotAppDamage: null,
        CountNotAppPartialDamage: null,
    },

    getters : {

        getAuth(state){
            return state.auth;
        },
        getRoles(state){
            return state.roles;
        },
        getDraft(state){
            return state.draft;
        },

        // count
        getCountNotProcess(state){
            return state.CountNotProcess;
        },

        getCountProcess(state){
            return state.CountProcess;
        },

        getCountDeliverable(state){
            return state.CountDeliverable;
        },

        getCountService(state){
            return state.CountService;
        },
        getCountServiceAccess(state){
            return state.CountServiceAccess;
        },

        getConuntHOService(state){
            return state.ConuntHOService;
        },
        getConuntHOServiceAccess(state){
            return state.ConuntHOServiceAccess;
        },
        getAllZoneOfficesAssign(state){
            return state.AllZoneOfficesAssign;
        },

        getCountAppDamage(state){
            return state.CountAppDamage;
        },
        getCountAppPartialDamage(state){
            return state.CountAppPartialDamage;
        },
        getCountNotAppDamage(state){
            return state.CountNotAppDamage;
        },
        getCountNotAppPartialDamage(state){
            return state.CountNotAppPartialDamage;
        },

    },

    mutations : {

        // Auth User
        setAuth(state, data){
            state.auth = data;
        },

        // Roles User
        setRoles(state, data){
            state.roles = data;
        },

        // Draft User
        setDraft(state, data){
            //console.log('store drft', data)
            state.draft = data;
        },


        setCountNotProcess(state, data){
            state.CountNotProcess = data;
        },

        setCountProcess(state, data){
            state.CountProcess = data;
        },

        setCountDeliverable(state, data){
            state.CountDeliverable = data;
        },

        setCountService(state, data){
            state.CountService = data;
        },
        setCountServiceAccess(state, data){
            state.CountServiceAccess = data;
        },

        setConuntHOService(state, data){
            state.ConuntHOService = data;
        },
        setConuntHOServiceAccess(state, data){
            state.ConuntHOServiceAccess = data;
        },
        setAllZoneOfficesAssign(state, data){
            state.AllZoneOfficesAssign = data;
        },

        setConuntAppDamage(state, data){
            state.CountAppDamage = data;
        },
        setConuntAppPartialDamage(state, data){
            state.CountAppPartialDamage = data;
        },
        setConuntNotAppDamage(state, data){
            state.CountNotAppDamage = data;
        },
        setConuntNotAppPartialDamage(state, data){
            state.CountNotAppPartialDamage = data;
        },
    
    },

    actions :  {
        
    },

});