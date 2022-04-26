import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


export default new Vuex.Store({

    state : {
        auth : null,
        roles: null,
        hardCounter: null,
        appCounter: null,
    },

    getters : {

        getAuth(state){
            return state.auth;
        },
        getRoles(state){
            return state.roles;
        },

        getHardCounter(state){
            return state.hardCounter;
        },

        getAppCounter(state){
            return state.appCounter;
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

        setHardCounter(state, data){
            state.hardCounter = data;
        },

        setAppCounter(state, data){
            state.appCounter = data;
        },
    
    },

    actions :  {
        
    },

});