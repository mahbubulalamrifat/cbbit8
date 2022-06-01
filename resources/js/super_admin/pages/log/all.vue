<template>
    <div>


        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h3 class="card-title">All Login Logs</h3>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div v-if="allData.data">
                    <v-row>
                         <v-col cols="3" lg="2">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small></v-select>
                        </v-col>

                        <v-col cols="9" lg="2">
                            <v-select v-model="short_by" label="Sort By:" :items="sortOptions"></v-select>
                        </v-col>

                        <v-col cols="12" lg="2">
                            <!-- <v-text-field prepend-icon="mdi-calendar-cursor" label="Start:" type="date" v-model="start_date" ></v-text-field> -->
                            <v-menu v-model="menu" min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="start_date" label="Start date"
                                        prepend-inner-icon="mdi-calendar"  v-bind="attrs" v-on="on" 
                                        clearable></v-text-field>
                                </template>

                                <v-date-picker v-model="start_date" no-title scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="menu = false">
                                        Cancel
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-col cols="12" lg="2">
                            <!-- <v-text-field prepend-icon="mdi-calendar-cursor" label="End:" type="date" v-model="end_date" ></v-text-field> -->
                            <v-menu v-model="menu2" min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="end_date" label="End Date" prepend-inner-icon="mdi-calendar"
                                         v-bind="attrs" v-on="on"  clearable></v-text-field>
                                </template>

                                <v-date-picker v-model="end_date" no-title scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="menu2 = false">
                                        Cancel
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>

                        <v-col cols="12" lg="4">
                            <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..."></v-text-field>
                        </v-col>
                    </v-row>
                   

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>
                                        <a href="#" @click.prevent="change_sort('id')">ID</a>
                                        <span v-if="sort_direction == 'desc' && sort_field == 'id'">&uarr;</span>
                                        <span v-if="sort_direction == 'asc' && sort_field == 'id'">&darr;</span>
                                    </th>
                                    <th>Status</th>
                                    <th>
                                        <a href="#" @click.prevent="change_sort('login_id')">Login ID</a>
                                        <span v-if="sort_direction == 'desc' && sort_field == 'login_id'">&uarr;</span>
                                        <span v-if="sort_direction == 'asc' && sort_field == 'login_id'">&darr;</span>
                                    </th>
                                    <th>
                                        <a href="#" @click.prevent="change_sort('ip')">IP</a>
                                        <span v-if="sort_direction == 'desc' && sort_field == 'ip'">&uarr;</span>
                                        <span v-if="sort_direction == 'asc' && sort_field == 'ip'">&darr;</span>
                                    </th>
                                    <th>
                                        <a href="#" @click.prevent="change_sort('os')">OS</a>
                                        <span v-if="sort_direction == 'desc' && sort_field == 'os'">&uarr;</span>
                                        <span v-if="sort_direction == 'asc' && sort_field == 'os'">&darr;</span>
                                    </th>
                                    <th>
                                        <a href="#" @click.prevent="change_sort('browser')">Browser</a>
                                        <span v-if="sort_direction == 'desc' && sort_field == 'browser'">&uarr;</span>
                                        <span v-if="sort_direction == 'asc' && sort_field == 'browser'">&darr;</span>
                                    </th>
                                    <th>
                                        <a href="#" @click.prevent="change_sort('device')">Device</a>
                                        <span v-if="sort_direction == 'desc' && sort_field == 'device'">&uarr;</span>
                                        <span v-if="sort_direction == 'asc' && sort_field == 'device'">&darr;</span>
                                    </th>
                                    <th>
                                        <a href="#" @click.prevent="change_sort('created_at')">Login At</a>
                                        <span
                                            v-if="sort_direction == 'desc' && sort_field == 'created_at'">&uarr;</span>
                                        <span v-if="sort_direction == 'asc' && sort_field == 'created_at'">&darr;</span>
                                    </th>
                                    <th>
                                        <a href="#" @click.prevent="change_sort('created_at')">Logout At</a>
                                        <span
                                            v-if="sort_direction == 'desc' && sort_field == 'created_at'">&uarr;</span>
                                        <span v-if="sort_direction == 'asc' && sort_field == 'created_at'">&darr;</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in allData.data" :key="singleData.id">
                                    <td>{{ singleData.id }}</td>
                                    <td>
                                       <span v-if="singleData.status == 1" class="text-success">Successful</span>
                                       <span v-if="singleData.status == 3" class="text-danger">Not authorized AD</span>
                                       <span v-if="singleData.status == 0" class="text-danger">Not authorized CPB-IT</span>
                                       <span v-if="singleData.status == 2" class="text-danger">User blocked</span>
                                    </td>
                                    <td>{{ singleData.login_id }}</td>
                                    <td>{{ singleData.ip }}</td>
                                    <td>{{ singleData.os }}</td>
                                    <td>{{ singleData.browser }}</td>
                                    <td>{{ singleData.device }}</td>
                                    <td>
                                        <span v-if="singleData.created_at">{{ singleData.created_at | moment("MMM Do, YYYY , h:mm:ss a") }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="singleData.updated_at != singleData.created_at">{{ singleData.updated_at | moment("MMM Do, YYYY , h:mm:ss a") }}</span>
                                        <span v-else class="error--text">N/A</span>
                                    </td>
                                
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <span>Total Records: {{ totalValue }}</span>
                    </div>
                    <pagination :data="allData" :limit="3" @pagination-change-page="getResults"
                        class="justify-content-end">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-else>
                    <div v-if="dataLoading" class="p-5 my-5">
                        <p class="text-center"><i class="fas fa-spinner fa-pulse text-success fa-10x"></i></p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </div>
        </div>

    


    </div>

</template>


<script>
   
    export default {

        data() {

            return {

                //current page url
                currentUrl: '/super_admin/logs',

                sortOptions:[
                    {
                        text: 'Successful login',
                        value: 's'
                    },
                    {
                        text: 'AD login Error',
                        value: 'ae'
                    },
                    {
                        text: 'CPB login Error',
                        value: 'ce'
                    },
                ],

                // datepicker
                menu: '',
                menu2: '',
                short_by:'',
                start_date: '',
                end_date:'',
                

            }


        },

        methods: {

            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl+'/all?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field +
                        '&short_by=' + this.short_by +
                        '&start=' + this.start_date +
                        '&end=' + this.end_date 
                    )
                    .then(response => {
                        //console.log(response.data.data);
                        //console.log(response.data.from, response.data.to);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;
                        this.currentPageNumber  = response.data.current_page
                        // Loading Animation
                        this.dataLoading = false;

                    });
            },


        },

        watch:{

            short_by:function(){
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            }

        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        },



    }

</script>
