<template>
    <div>
        <v-toolbar flat dense dark class="nav-color">
            <v-app-bar-nav-icon href="/">
                <v-img src="/all-assets/common/icon/iaccess.png" alt="room" max-height="40" max-width="40" contain
                    class="nav-logo-bg"></v-img>
            </v-app-bar-nav-icon>
            <v-btn color="white black--text ml-2" @click="viewManual" :loading="pdfReadyLoading" small>
                Manual <v-icon right>mdi-eye</v-icon>
            </v-btn>

            <v-spacer></v-spacer>

            <v-avatar v-if="auth.image">
                <v-img :src="'/images/users/small/' + auth.image" alt="CPB-IT" max-height="40" max-width="40" contain>
                </v-img>
            </v-avatar>
            <span v-if="auth" class="m-1">{{ auth.name }} ({{ auth.login }})</span>
            <v-spacer></v-spacer>

            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn text link route :to="{ name: 'Dashboard' }" small exact>
                    Dashboard
                </v-btn>

                <v-menu open-on-hover offset-y small exact>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn v-bind="attrs" v-on="on" text small> Apply History </v-btn>
                    </template>
                    <v-list dense>
                        <v-list-item router link :to="{ name: 'HistoryIWaccess' }">
                            <v-list-item-title>Internet / Web Access Request</v-list-item-title>
                        </v-list-item>

                        <v-list-item router link :to="{ name: 'HistoryAccountAuthority' }">
                            <v-list-item-title>Account / Authority Request</v-list-item-title>
                        </v-list-item>

                        <v-list-item router link :to="{ name: 'HistoryEmailRequest' }">
                            <v-list-item-title>Email Request</v-list-item-title>
                        </v-list-item>

                        <v-list-item router link :to="{ name: 'HistoryGuestUser' }">
                            <v-list-item-title>Guest User Request</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <v-btn text link route href="/logout" small> Logout </v-btn>
            </v-toolbar-items>

            <v-app-bar-nav-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        </v-toolbar>

        <v-navigation-drawer v-model="drawer" absolute temporary right overlay-opacity=".6" overlay-color="green"
            src="/all-assets/common/icon/iaccess.png" style="height: 100vh">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>Carpool</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense class="img-opcty">
                <v-list-item link route :to="{ name: 'Dashboard' }" exact>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-menu open-on-hover offset-y small exact>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn v-bind="attrs" v-on="on" text small> Apply History </v-btn>
                    </template>
                    <v-list dense>
                        <v-list-item router link :to="{ name: 'HistoryIWaccess' }">
                            <v-list-item-title>Internet / Web Access Request</v-list-item-title>
                        </v-list-item>

                        <v-list-item router link :to="{ name: 'HistoryAccountAuthority' }">
                            <v-list-item-title>Account / Authority Request</v-list-item-title>
                        </v-list-item>

                        <v-list-item router link :to="{ name: 'HistoryEmailRequest' }">
                            <v-list-item-title>Email Request</v-list-item-title>
                        </v-list-item>

                        <v-list-item router link :to="{ name: 'HistoryGuestUser' }">
                            <v-list-item-title>Guest User Request</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <v-list-item link route href="/logout">
                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- viewDocumentDialog -->
        <v-dialog v-model="viewDocument" max-width="900">
            <v-card>
                <vue-pdf-app :file="pdfbase64" />
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import VuePdfApp from "./pdfViewApp.vue";
    export default {
        components: {
            "vue-pdf-app": VuePdfApp,
        },
        data() {
            return {
                drawer: null,
            };
        },
        methods: {
            // PDF
            viewManual() {
                this.pdfReadyLoading = true;
                axios
                    .get("/iaccess/iaccess-manual")
                    .then((res) => {
                        this.pdfReadyLoading = false;
                        this.base64ToArrayBuffer(res.data);
                    })
                    .catch((error) => {
                        this.pdfReadyLoading = false;
                        console.error(error);
                    });
            },
        },
    };

</script>

<style scoped>
    .v-btn--active {
        color: #fff;
        background: linear-gradient(90deg, #b86883, #9796f0);
    }

    .nav-color {
        background: linear-gradient(to right, #9796f0, #b86883);
    }

    .nav-logo-bg {
        background-color: white !important;
        border-radius: 8px;
    }

    a:hover {
        text-decoration: none;
    }

    .img-opcty {
        /* Fallback for web browsers that doesn't support RGBa */
        background: rgb(244, 241, 241) !important;
        /* RGBa with 0.6 opacity */
        background: rgba(244, 241, 241, 0.6) !important;
    }

</style>
