<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        All Expire Product
                    </v-col>
                    <v-col cols="2">
                        <v-btn outlined elevation="5" class="float-right" small @click="exportExcel()" :loading="exportLoading">
                            <v-icon left color="success">mdi-file-excel</v-icon>
                            Export
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div v-if="allData.data">
                    <v-row>
                        <v-col lg="2" cols="4">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="2" cols="4">
                            <!-- search_field -->
                            <v-select v-model="search_field" label="Search By:" :items="customSrcByFields" item-text="text"
                                item-value="value" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="8" cols="4">
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                                hide-details
                                class="mb-5"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <th>Name/Model</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Serial</th>
                                <th>File</th>
                                <th>Purchase Date</th>
                                <th>Remarks</th>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in allData.data" :key="singleData.id">
                                    <td>
                                        <span v-if="singleData.name">{{singleData.name}}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.category">{{ singleData.category.name }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.subcategory">{{ singleData.subcategory.name }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.serial">{{ singleData.serial }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <a v-if="singleData.document" :href="'/images/inventory/'+singleData.document"
                                            class="btn btn-info btn-sm text-white" download>
                                            <v-icon color="white">mdi-download-network-outline</v-icon> Document
                                        </a>
                                        <span v-else class="text-danger">Not Attached</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.purchase">{{ singleData.purchase }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.remarks" v-html="singleData.remarks"></span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" :limit="3" @pagination-change-page="getResults" class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </v-card-text>
        </v-card>

    </div>
</template>



<script>
   

    export default {
      
        data() {

            return {
                // dialog
                dataModalDialog:false,

                // loader
                addNetworklLoader:false,


                //current page url
                currentUrl: '/inventory/admin/w-product/expire-product',


                customSrcByFields:[
                    {
                        value: 'All',
                        text: 'All'
                    },
                    {
                        value: 'serial',
                        text: 'Serial'
                    },
                    {
                        value: 'cat_id',
                        text: 'Category'
                    },
                    {
                        value: 'subcat_id',
                        text: 'Subcategory'
                    },
                ],

                // exportLoading
                exportLoading: false,


            }


        },

        methods: {

            exportExcel(){
                this.exportLoading = true;

                axios({
                    method: 'get',
                    url: this.currentUrl+'/export_data?search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field,

                    responseType: 'blob', // important
                }).then((response) => {

                    

                    let repName = new Date();

                    const url = URL.createObjectURL(new Blob([response.data]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', `${repName}.xlsx`)
                    document.body.appendChild(link)
                    link.click()

                    this.exportLoading = false;

                }).catch(error => {
                    //stop Loading
                    this.exportLoading = false
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!',
                        text: 'Somthing going wrong !!'
                    })
                })


            }


        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        },



    }

</script>