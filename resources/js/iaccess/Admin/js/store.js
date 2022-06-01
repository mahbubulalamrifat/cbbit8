import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


export default new Vuex.Store({

    state : {
        auth  : null,
        roles: null,
        email: null,
        internet: null,
        account: null,
        guest: null,
    },

    getters : {

        getAuth(state){
            return state.auth;
        },
        getRoles(state){
            return state.roles;
        },
        getCountEmailRequest(state) {
            return state.email
        },
        getCountInternetRequest(state) {
            return state.internet
        },
        getCountAccountRequest(state) {
            return state.account
        },
        getCountGuestRequest(state) {
            return state.guest
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

        setCountEmailRequest(state,data) {
            state.email = data;
        },
        setCountInternetRequest(state,data) {
            state.internet = data;
        },
        setCountAccountRequest(state,data) {
            state.account = data;
        },
        setCountGuestRequest(state,data) {
            state.guest = data;
        },
    
    },

    actions :  {
        
    },

});