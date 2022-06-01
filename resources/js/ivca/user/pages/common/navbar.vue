<template>
    <div>
        <!-- change -->
        <v-toolbar flat dense dark class="nav-color">

            <v-app-bar-nav-icon href="/dashboard">
                <v-img src="/all-assets/common/icon/ivca.png" alt="iVCA" max-height="40" max-width="40" contain
                    class="nav-logo-bg"></v-img>
            </v-app-bar-nav-icon>

            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">

                <v-btn small text link route exact :to="{ name: 'ivca_dashboard'}">
                    Dashboard
                </v-btn>

                <!-- <v-btn small text link route href="/ivca">
                    Dashboard
                </v-btn> -->

                <!-- v-if="isMro()" -->
                <v-btn small text link route :to="{ name: 'ivca_mro_schedule'}">
                    Mro Schedules
                </v-btn>

                <!-- v-if="isFood()" -->
                <v-btn small text link route :to="{ name: 'ivca_food_schedule'}">
                    Food Schedules
                </v-btn>

                <v-btn small text link route href="/user-logout">
                    Logout
                </v-btn>

            </v-toolbar-items>


            <v-app-bar-nav-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        </v-toolbar>
        <!-- change -->
        <v-navigation-drawer v-model="drawer" absolute temporary right style="height:100vh;" src="/all-assets/common/icon/ivca.png">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>IVCA User</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense>

                <v-list-item link route :to="{ name: 'ivca_dashboard'}" exact>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <!-- v-if="isMro()" -->
                <v-list-item link route :to="{ name: 'ivca_mro_schedule'}">
                    <v-list-item-content>
                        <v-list-item-title>Mro Schedules</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <!-- v-if="isFood()" -->
                <v-list-item link route :to="{ name: 'ivca_food_schedule'}">
                    <v-list-item-content>
                        <v-list-item-title>Food Schedules</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item link route href="/user-logout">
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
       
    }
</script>

<style>
    .nav-color {
        background: #aa4b6b;
        background: -webkit-linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
        background: linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
    }

    .v-btn--active {
        color: #fff;
        background: linear-gradient(to right, #aa4b6b, #6b6b83, #3b8d99);
    }

    a:hover {
        text-decoration: none;
    }

    .nav-logo-bg {
        background-color: white !important;
        border-radius: 8px;
    }

</style>
