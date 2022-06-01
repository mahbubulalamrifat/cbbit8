<template>
    <div>
       
       <v-row>
            <v-col cols="12" lg="4">
                <v-card>
                    <v-card-subtitle>Total iAccess Email Application</v-card-subtitle>
                    <v-card-text>
                        <div class="d-flex justify-content-between align-items-center h4">
                            <span>
                                <v-icon size="30">mdi-email-check-outline</v-icon>
                                {{allData.emailData}}
                            </span>
                            <span>
                                <!-- {{ allDashboardData.allOperation }} -->
                                <strong>{{ Math.ceil(value) }}%</strong>
                            </span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" lg="4">
                <v-card>
                    <v-card-subtitle>Total iAccess Internet/Web Access Application</v-card-subtitle>
                    <v-card-text>
                        <div class="d-flex justify-content-between align-items-center h4">
                            <span>
                                <v-icon size="30">mdi-web</v-icon>
                                {{allData.internetData}}
                            </span>
                            <span>
                                <!-- {{ allDashboardData.allOperation }} -->
                                <strong>{{ Math.ceil(value) }}%</strong>
                            </span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" lg="4">

                <v-card>
                    <v-card-subtitle>Total iAccess Account/Authority Application</v-card-subtitle>
                    <v-card-text>
                        <div class="d-flex justify-content-between align-items-center h4">
                            <span>
                                <v-icon size="30">mdi-account-cowboy-hat-outline</v-icon>
                                {{allData.accountData}}
                            </span>
                            <span>
                                <!-- {{ allDashboardData.allOperation }} -->
                                <strong>{{ Math.ceil(value) }}%</strong>
                            </span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" lg="4">

                <v-card>
                    <v-card-subtitle>Total iAccess Guest User Application</v-card-subtitle>
                    <v-card-text>
                        <div class="d-flex justify-content-between align-items-center h4">
                            <span>
                                <v-icon size="30">mdi-account-network-outline</v-icon>
                                {{allData.guestData}}
                            </span>
                            <span>
                                <!-- {{ allDashboardData.allOperation }} -->
                                <strong>{{ Math.ceil(value) }}%</strong>
                            </span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

    </div>
</template>

<script>


export default {
   
    data(){
        return{

            allData: '',
            value: 100,
            currentUrl: '/iaccess/admin',

        }
    },

    methods:{

        dashboardData(){
            axios.get(this.currentUrl+'/dashboard_data').then(response=>{
                
                console.log(response.data)
                this.allData = response.data;
                
            }).
            catch(error=>{
                console.log(error)
            })
        },

     
    },

    mounted(){
        this.dashboardData();
    },

    created(){
     
    }
}
</script>

