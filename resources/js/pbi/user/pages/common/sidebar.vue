<template>
    <div >
        <v-app-bar app flat dense class="bg-transparent">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-btn icon @click="toggle()">
                <v-icon v-if="fullscreen">mdi-fullscreen</v-icon>
                <v-icon v-else>mdi-fullscreen-exit</v-icon>
            </v-btn>

            <v-spacer></v-spacer>
            <v-app-bar-title class="px-3" style="background-color: #ffc107; ">{{ reportName }}</v-app-bar-title>
            <v-spacer></v-spacer>


            <v-menu bottom left>
                <template v-slot:activator="{ on, attrs }">
                    <span v-if="auth" class="m-1">{{ auth.name }}</span>
                    <v-avatar v-bind="attrs" v-on="on" contain>
                        <img v-if="auth.image" :src="'/images/users/small/'+auth.image" alt="image">
                        <img v-else src="https://www.w3schools.com/howto/img_avatar.png" alt="image">
                    </v-avatar>
                </template>

                <v-list>
                    <v-list-item link router href="/logout">
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>


        <!-- sidebar -->
        <v-navigation-drawer app dark v-model="drawer" class="bg_color" src="/all-assets/common/sidebar_powerbi.png">
            <v-list-item class="px-2" link href="/">
                <v-list-item-icon>
                    <img src="/all-assets/common/icon/powerbi.png" alt="" height="40px" contain>
                </v-list-item-icon>
                <v-list-item-title>PBI</v-list-item-title>
            </v-list-item>
            <v-divider></v-divider>

            <v-list dense>

                <v-list-item link router :to="{name: 'Dashboard'}" exact>
                    <v-list-item-icon>
                        <v-icon>mdi-view-dashboard-outline </v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                 <!-- Sidebar Multi level Item -->
                <v-list-group prepend-icon="mdi-account-group" active-class="white--text" no-action>
                    <template v-slot:activator>
                        <v-list-item-title>BI Reports</v-list-item-title>
                    </template>

                    <v-list-item v-for="(item, index) in pbis" :key="index" link router :to="{name: 'Reports', query: { name:item} }" exact>
                        <v-list-item-content>
                            <v-list-item-title>{{ item }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>

        
             

                <v-list-item link router href="/logout">
                    <v-list-item-icon>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-icon>

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
        data() {
            return {
                fullscreen: true,
                drawer: true,
            };
        },
        methods: {
            toggle() {
                this.fullscreen = !this.fullscreen
                if(this.fullscreen == false){
                    this.expand();
                }else{
                    this.exitExpand();
                }
            },
            expand() {
                var elem = document.documentElement;
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                }
            },
            exitExpand() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            },
        },


        created(){
            //console.log('sidebar : ', this.reportName);
        }

    };

</script>


<style scoped>
    .bg_color {
       background: black;
    }

    a:hover {
        text-decoration: none;
    }

    .v-list-group__items .v-list-item--active, .v-list-item--active {
        color: #ffc107 !important;
        color: white;
        border-left: 2px solid #ffc107;
        border-radius: 0;
    }

    .theme--dark.v-list-item--active::before, .theme--dark.v-list-item--active:hover::before, .theme--dark.v-list-item:focus::before {
        opacity: 0 !important;
    }

</style>
