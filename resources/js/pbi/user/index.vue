<template>
    <v-app class="pbi">
       
        <side-bar></side-bar>
        <v-main>
            <div class="pa-3">
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>
            </div>
        </v-main>
        <page-footer></page-footer>
      
    </v-app>
</template>

<script>


import sideBar from './pages/common/sidebar.vue'
import pageFooter from './pages/common/footer.vue'


export default {

    props: ['authuser', 'permission', 'pbi_access'],

    components:{
       'side-bar'       : sideBar,
       'page-footer'    : pageFooter,
    },

    data(){
        return{
            response: false,
            
        }
    },

    methods:{


      
    

       
    },

   

    created(){

        // Set Auth and Role data in Store
        this.$store.commit('setAuth', JSON.parse(this.authuser) )
        this.$store.commit('setRoles', JSON.parse(this.permission) )
        this.$store.commit('setPbis', JSON.parse(this.pbi_access) )

        let pbiaccessArray = JSON.parse(this.pbi_access)
        this.$store.commit('setReportName', pbiaccessArray[0] )

        this.$Progress.start();

        //this.check(checkUserRole)
      
        //console.log('Index: ', this.roles, this.pbis, this.reportName);

        //console.log('Role: ', this.isAdministrator(), this.isAnyRole(['Administrator', 'Ivca']), this.isRole('Administrator') )

        this.$Progress.finish();  
    }
    
}
</script>

<style scoped>
    .pbi{
        background-color: #F4F7FA
    }
</style>

