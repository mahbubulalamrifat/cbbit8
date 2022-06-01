<template>
    <div>
        <v-toolbar flat dense dark class="nav-color" >

            <v-app-bar-nav-icon href="/">
                <v-img  src="/all-assets/common/icon/cms.png" alt="room" max-height="40" max-width="40" contain class="nav-logo-bg"></v-img>
            </v-app-bar-nav-icon>

            <v-spacer></v-spacer>
            <v-avatar v-if="auth.image">
                <v-img :src="'/images/users/small/'+auth.image" alt="CPB-IT" max-height="40" max-width="40" contain>
                </v-img>
            </v-avatar>
               <span v-if="auth" class="m-1">{{ auth.name }} ({{ auth.login }})</span>
            <v-spacer></v-spacer>


            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn text link route :to="{ name: 'Dashboard'}" small exact>
                    Dashboard
                </v-btn>

                <v-btn text link route :to="{ name: 'HardwareHistory'}" small>
                    Hardware History
                    <v-badge v-if="hardRating" color="error ml-1" :content="hardRating"></v-badge>
                </v-btn>

                <v-btn text link route :to="{ name: 'ApplicationHistory'}" small>
                    Application History
                    <v-badge v-if="appRating" color="error ml-1" :content="appRating"></v-badge>
                </v-btn>

            
                <v-btn text link route href="/logout" small>
                    Logout
                </v-btn>
            </v-toolbar-items>

            <v-app-bar-nav-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

        </v-toolbar>


        <v-navigation-drawer v-model="drawer" absolute temporary right overlay-opacity=".6" overlay-color="green"
            src="/all-assets/common/icon/cms.png" style="height:100vh;">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>CMS User</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense class="img-opcty">

                <v-list-item link route :to="{ name: 'Dashboard'}" exact>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route :to="{ name: 'HardwareHistory'}">
                    <v-list-item-content>
                        <v-list-item-title>Hardware History
                            <v-badge v-if="hardRating" color="error ml-2" :content="hardRating"></v-badge>
                        </v-list-item-title>
                        
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route :to="{ name: 'ApplicationHistory'}">
                    <v-list-item-content>
                        <v-list-item-title :content="appRating">Application History
                            <v-badge v-if="appRating" color="error ml-2" :content="appRating"></v-badge>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route href="/logout">
                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

    </div>
</template>


<script>

    export default {
       
        data(){
            return{
                drawer: null,
            }
        },

        // mounted(){
        //     this.closeComplainForRating();
        // }

       
    }

</script>

<style scoped>
    .v-btn--active{
        color: #fff;
        background: linear-gradient(90deg,#aa4b6b,#6b6b83,#3b8d99);
        border-radius: 25px;
        margin-left: 14px;
        margin-right: 14px;
    }
    
    .nav-color {
        background: #aa4b6b;
        background: -webkit-linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
        background: linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
    }

    .nav-logo-bg{
        background-color: white !important;
        border-radius: 8px;
    }

    a:hover{
        text-decoration: none;
    }

    .img-opcty {
        /* Fallback for web browsers that doesn't support RGBa */
        background: rgb(244, 241, 241) !important;
        /* RGBa with 0.6 opacity */
        background: rgba(244, 241, 241, 0.6) !important;
    }

</style>
