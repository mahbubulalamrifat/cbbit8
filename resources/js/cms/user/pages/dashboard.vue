<template>
    <div class="mt-lg-5 mt-sm-0">

        <div class="background_color_2 box-shadow col-lg-11 col-12 m-auto py-4 rounded">
            <div>
                <p class="text-center h3">CMS Dashboard</p>
            </div>

            <div class="d-flex flex-wrap justify-content-around align-items-center adjust-gap">
                <div class="col-12 col-lg-6 m-auto responsive-gap">
                    <div class="d-flex flex-column align-items-center">
                        <div @click="hardwareComplainDialog()">
                            <img src="/all-assets/common/icon/hardware.png" alt="image" class="img-fluid images bg-white" />
                        </div>
                        <div class="h2 my-1">Hardware & Network</div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 m-auto">
                    <div class="d-flex flex-column align-items-center">
                        <div @click="applicationComplainDialog()">
                            <img src="/all-assets/common/icon/application.png" alt="image" class="img-fluid images bg-white" />
                        </div>
                        <div class="h2 my-1">Business Application</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- hardware-complain -->
        <hardware-complain v-if="hardwareDialogShow" :key="hardwareComKey" ></hardware-complain>

        <!-- application-complain -->
        <application-complain v-if="applicationDialogShow" :key="applicationComKey" ></application-complain>



        <!-- not ratings component modal -->
        <v-dialog persistent v-model="counterDialogShow" max-width="600">
            <v-card>
                <v-card-title class="justify-space-between">
                    <span class="text-danger"> Notification!!</span> 
                    <v-btn color="error" @click="counterDialogShow = false" small>
                        <v-icon left>mdi-close-circle</v-icon>Close
                    </v-btn> 
                </v-card-title>
                
                <v-card-text @click="redirect()">
                    <div class="rounded-lg px-3 text-center font-weight-bold py-2 indigo lighten-2" > Your have <span class="h3 error--text"> {{ selectedCount }} {{selectedComp}} </span> pending ratings &nbsp; </div>
                    <div class="rounded-lg px-3 text-center font-weight-bold py-2 deep-purple lighten-1 my-3">Please Fulfill Rating section. </div>
                    <div class="rounded-lg px-3 text-center font-weight-bold py-2 cyan darken-1">Otherwise you can't place any complain in future. </div>
                </v-card-text>
            </v-card>
        </v-dialog>

    </div>
</template>



<script>

    import hardwareComplain from './hardware_complain.vue'
    import applicationComplain from './application_complain.vue'


    export default {

        components:{
            hardwareComplain,
            applicationComplain,
        },

        data(){
            return{

                hardwareDialogShow: false,
                hardwareComKey: 0,


                applicationDialogShow: false,
                applicationComKey: 0,


                // selected component
                selectedComp: '',
                selectedCount: '',

            }
        },

        methods:{

            // hardwareComplainDialog
            hardwareComplainDialog(){
                this.selectedCount = this.hardRating;
                if(this.hardRating > 2){
                    this.counterDialogShow=true;
                }

                this.hardwareDialogShow = true
                this.hardwareComKey++;
                
            },

            // applicationComplainDialog
            applicationComplainDialog(){
                this.selectedCount = this.appRating;
                if(this.appRating > 2){
                    this.counterDialogShow=true;
                }

                this.applicationDialogShow = true
                this.applicationComKey++;
                
            },

            // redirect
            redirect(){
                if(this.selectedComp == "Application"){

                    this.$router.push({ name: 'ApplicationHistory' });
                }else{
                    this.$router.push({ name: 'HardwareHistory' });
                }
            }

        },

        watch:{
            applicationDialogShow: function(e){
                if(e){
                    this.applicationDialogShow = false;
                    this.selectedComp = 'Application';
                }
            },

            hardwareComplainDialog: function(e){
                if(e){
                    this.hardwareComplainDialog = false;
                    this.selectedComp = 'Hardware';
                }
            }
        },

        


    }

</script>


<style scoped>
    .background_color_2 {
        background: #aa4b6b;
        background: -webkit-linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
        background: linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
    }

    .background_color {
        background: #16222a;
        background: -webkit-linear-gradient(to right, #3a6073, #16222a);
        background: linear-gradient(to right, #3a6073, #16222a);
        height: 100vh;
    }

    .box-shadow {
        color: white;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .images {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        transition: 0.3s;
    }

    .images:hover {
        transform: scale(1.1);
    }

    @media screen and (max-width: 500px) {
        .responsive-gap {
            padding-bottom: 1.5rem;
        }
    }

</style>
