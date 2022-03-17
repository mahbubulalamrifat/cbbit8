<template>
    <div>
        <h3>Remaining Stock</h3>
        <v-row>
            <v-col cols="12" lg="3"  v-for="(item, index) in allDashboardData" :key="index">
                <v-card>
                    <v-img
                    class="white--text align-end teal"
                    height="150px"
                    >
                    <div class="d-flex justify-content-between">
                        <v-card-title v-text="item.category.name"></v-card-title>
                        
                        <v-card-title v-text="item.total" class="align-end"></v-card-title>
                    </div>
                    </v-img>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>



export default {
   
    data(){
        return{
            // current Url
            currentUrl : '/inventory/admin',
            allDashboardData : '',

           
        }
    },

    methods:{

        getDashboardData(){
            axios.get( this.currentUrl + '/dashboard_data').then(response=>{
                console.log(response.data)
                this.allDashboardData = response.data.remainProduct
            }).catch(error=>{
                console.log(error)
            })
        }

     
    },

    created(){
        this.getDashboardData()
    
    }
}
</script>

