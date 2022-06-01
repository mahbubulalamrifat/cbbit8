<template>
    <div>

        <v-row>
            <v-col cols="12" lg="4">
                <v-card>
                    <v-card-subtitle>Total PowerBI Report Type</v-card-subtitle>
                    <v-card-text>
                        <div class="d-flex justify-content-between">
                            <span>
                                <v-icon color="white" size="40">mdi-chart-bar</v-icon>
                                19
                            </span>
                            <span>
                                <!-- {{ allDashboardData.allOperation }} -->
                                <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                            </span>
                        </div>
                        <v-progress-linear class="mt-3" v-model="value" color="indigo" height="25" rounded>
                            <template v-slot:default="{ value }">
                                <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                            </template>
                        </v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="4">
                <v-card>
                    <v-card-subtitle>Total Power BI User</v-card-subtitle>
                    <v-card-text>
                        <div class="d-flex justify-content-between">
                            <span>
                                <v-icon color="white" size="40">mdi-account-group-outline</v-icon>
                                {{pbi_user}}/{{total_user}}
                            </span>
                            <span>
                                <!-- {{ allDashboardData.allOperation }} -->
                                <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                            </span>
                        </div>
                        <v-progress-linear class="mt-3" v-model="value" color="indigo" height="25" rounded>
                            <template v-slot:default="{ value }">
                                <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                            </template>
                        </v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" lg="4">

                <v-card>
                    <v-card-subtitle>Total Power BI Admin</v-card-subtitle>
                    <v-card-text>
                        <div class="d-flex justify-content-between">
                            <span>
                                <v-icon color="white" size="40">mdi-account-cog-outline</v-icon>
                                {{pbi_admin}}/{{total_user}}
                            </span>
                            <span>
                                <!-- {{ allDashboardData.allOperation }} -->
                                <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                            </span>
                        </div>
                        <v-progress-linear class="mt-3" v-model="value" color="indigo" height="25" rounded>
                            <template v-slot:default="{ value }">
                                <strong class="white--text">{{ Math.ceil(value) }}%</strong>
                            </template>
                        </v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>




    </div>
</template>

<script>
    export default {

        data() {
            return {

                value: 100,
                currentUrl: '/pbi/admin',
                total_user: '',
                pbi_user: '',
                pbi_admin: '',

            }
        },

        methods: {

            // Get dahboard data
            getDashboardData() {
                axios.get(this.currentUrl + '/dashboard_data').then(response => {
                    //console.log(response.data)
                    this.total_user = response.data.total_user
                    this.pbi_user = response.data.pbi_user
                    this.pbi_admin = response.data.pbi_admin
                }).catch(error => {
                    console.log(error)
                })
            },


        },

        created() {

            this.$Progress.start();
            this.getDashboardData();
            this.$Progress.finish();
        }
    }

</script>
