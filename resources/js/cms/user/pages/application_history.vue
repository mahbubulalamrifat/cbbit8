<template>
    <div>

        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        My Application Complain List
                    </v-col>
                    <v-col cols="2">

                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <v-row>
                    <v-col cols="6" lg="2">
                        <!-- Show -->
                        <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                        </v-select>
                    </v-col>

                    <v-col cols="6" lg="2">
                        <v-select :items="reportType" label="Select Type" v-model="sort_by_day"></v-select>
                    </v-col>

                    <v-col cols="12" lg="2">
                        <v-menu v-model="menu" min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="sort_by_startDate" label="Start Date" prepend-icon="mdi-calendar"
                                    readonly v-bind="attrs" v-on="on" clearable>
                                </v-text-field>
                            </template>

                            <v-date-picker v-model="sort_by_startDate" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menu = false">
                                    Cancel
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                    </v-col>

                    <v-col cols="12" lg="2">
                        <v-menu v-model="menu2" min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="sort_by_endDate" label="End Date" prepend-icon="mdi-calendar"
                                    readonly v-bind="attrs" v-on="on" clearable></v-text-field>
                            </template>

                            <v-date-picker v-model="sort_by_endDate" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menu2 = false">
                                    Cancel
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                    </v-col>

                    <v-col>
                        <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                            placeholder="Search Input..."></v-text-field>
                    </v-col>
                </v-row>
                <div v-if="allData.data" class="table-responsive">

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>
                                    <a href="#" @click.prevent="change_sort('id')">Num.</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'id'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'id'">&darr;</span>
                                </th>
                                <th>
                                    <a href="#" @click.prevent="change_sort('process')">Process</a>
                                    <span v-if="sort_direction == 'desc' && sort_field == 'process'">&uarr;</span>
                                    <span v-if="sort_direction == 'asc' && sort_field == 'process'">&darr;</span>
                                </th>
                                <th>Type</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in allData.data" :key="item.id">

                                <td>
                                    <div class="pa-1 info rounded-pill h4 text-white text-center">
                                        {{ item.id }} (A)
                                    </div>
                                    <div v-if="item.document || item.document2 || item.document3 || item.document4">
                                        <span v-if="item.document">
                                            <a v-if="item.document" :href="docPath+item.document"
                                                class="btn btn-info btn-sm text-white" download>
                                                <v-icon color="white" dense>mdi-paperclip</v-icon> 1
                                            </a>
                                        </span>
                                        <span v-if="item.document2">
                                            <a v-if="item.document2" :href="docPath+item.document2"
                                                class="btn btn-info btn-sm text-white" download>
                                                <v-icon color="white" dense>mdi-paperclip</v-icon> 2
                                            </a>
                                        </span>
                                        <span v-if="item.document3">
                                            <a v-if="item.document3" :href="docPath+item.document3"
                                                class="btn btn-info btn-sm text-white" download>
                                                <v-icon color="white" dense>mdi-paperclip</v-icon> 3
                                            </a>
                                        </span>
                                        <span v-if="item.document4">
                                            <a v-if="item.document4" :href="docPath+item.document4"
                                                class="btn btn-info btn-sm text-white" download>
                                                <v-icon color="white" dense>mdi-paperclip</v-icon> 4
                                            </a>
                                        </span>
                                    </div>
                                    <div v-else class="text-danger text-center">No Document's Send</div>

                                </td>

                                <td>
                                    {{ item.process }}
                                </td>

                                <td>
                                    <b>Category:</b> <span v-if="item.category">{{ item.category.name }}</span><br>
                                    <b>Subcategory:</b> <span v-if="item.subcategory">{{ item.subcategory.name }}</span>
                                </td>

                                <td>
                                    <b>Complain At:</b> <span
                                        v-if="item.created_at">{{ item.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                    <br>
                                    <b>Last Update:</b> <span
                                        v-if="item.updated_at">{{ item.updated_at | moment("MMMM Do YYYY, h:mm a") }}</span>

                                    <div v-if="item.details">
                                        <b>Details:</b>
                                        <div v-if="item.details.length<100" v-html="item.details"></div>
                                        <div v-else><span v-html="item.details.substring(0,100)+' .....'"></span> <v-btn small text plain
                                                color="primary" @click="longTextHTML(item)"><u>See More </u>
                                            </v-btn>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span v-if="item.process == 'Not Process'">
                                        <v-btn v-if="item.process == 'Not Process' && item.status == 1"
                                            @click="complainCancel(item.id)" color="error" depressed elevation="20">
                                            <v-icon left>mdi-close-octagon-outline</v-icon> Cancel
                                        </v-btn>
                                        <span v-else class="error--text">Canceled</span>
                                    </span>
                                    <v-btn v-else @click="remarksDetailsShow(item)" color="success" depressed small
                                        elevation="20">
                                        <v-icon left>mdi-eye-arrow-left </v-icon> View
                                    </v-btn>

                                    <v-btn v-if=" item.process == 'Closed' && item.rating == null"
                                        @click="feedback(item)" color="teal white--text" depressed small elevation="20">
                                        <v-icon left>mdi-star-half-full </v-icon> Rating
                                    </v-btn>

                                    <v-rating v-if="item.rating" :value="item.rating" color="yellow darken-3"
                                        background-color="grey darken-1" empty-icon="$ratingFull" readonly></v-rating>
                                    <div v-if="item.feedback">
                                        <div v-if="item.feedback.length<100">{{ item.feedback }}</div>
                                        <div v-else>{{ item.feedback.substring(0,100)+"..."}} <v-btn small text plain
                                                color="primary" @click="longText(item.feedback)"><u> See More </u>
                                            </v-btn>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
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
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                            </v-icon>
                        </p>
                    </div>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! You have no complain in <b class="text-success">Application</b> section.</h1>

            </v-card-text>
        </v-card>


        <!-- remarks infomation modal -->
        <v-dialog v-if="allRemarks" v-model="remarksDialog">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Remarks Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="remarksDialog = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <table class="table table-bordered mt-5">
                        <thead class="text-center">
                            <tr>
                                <th>Process</th>
                                <th>Details</th>
                                <th>Document</th>
                                <th>Action By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in allRemarks.remarks" :key="index">

                                <td class="text-center">
                                    {{ item.process }}
                                </td>

                                <td v-html="item.details"></td>

                                <td class="text-center">
                                    <span v-if="item.document">
                                        <a v-if="item.document" :href="docPath+item.document"
                                            class="btn btn-info btn-sm text-white" download>
                                            <v-icon color="white" small>mdi-paperclip</v-icon> Document
                                        </a>
                                    </span>
                                    <span v-else class="text-danger">No Document's Send</span>
                                </td>

                                <td class="text-center">
                                    <span
                                        v-if="item.created_at">{{ item.created_at | moment("MMMM Do YYYY, h:mm a") }}</span><br>
                                    <span v-if="item.makby" class="text-muted small">--{{ item.makby.name }}</span>
                                </td>

                            </tr>

                        </tbody>
                    </table>

                </v-card-text>
            </v-card>
        </v-dialog>


        <!-- app rating -->
        <app-rating @childToParent="childToParentCall" v-if="appratingDialogShow" :key="appratingKey"
            :currentDataId="currentDataId"></app-rating>


        <!-- longtextDialog -->
        <v-dialog v-model="longtextDialog" max-width="300">
            <v-card>
                <v-card-text>
                    {{ currentText }}
                </v-card-text>
            </v-card>
        </v-dialog>

        <!-- longtextDialog -->
        <!-- <v-dialog v-model="longtextDialogHTML" max-width="500">
            <v-card class="p-2">
                <v-card-text v-html="currentTextHTML" class="p-0 m-0"></v-card-text>
            </v-card>
        </v-dialog> -->
        <v-dialog v-model="longtextDialogHTML">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            Details
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="longtextDialogHTML = false" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr class="text-center">
                                <td>
                                    <b>Process: </b> {{ currentTextHTML.process }}
                                </td>
                                <td>
                                    <b>Complain At: </b> <span v-if="currentTextHTML.created_at">{{ currentTextHTML.created_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                </td>
                                <td>
                                    <b>Last Update: </b> <span v-if="currentTextHTML.updated_at">{{ currentTextHTML.updated_at | moment("MMMM Do YYYY, h:mm a") }}</span>
                                </td>
                            <tr>
                                
                            <tr>
                                <td colspan="3" v-html="currentTextHTML.details"></td>
                            </tr>
                        </table>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
        
    </div>

</template>


<script>
    import appRating from '../pages/appRating.vue'
    export default {

        components: {
            'app-rating': appRating
        },

        data() {

            return {

                // dialog
                driverModal: false,
                bookbyModal: false,

                // driverData
                driverData: '',
                bookbyData: '',

                // datepicker

                menu: '',
                menu2: '',


                //current page url
                currentUrl: '/cms/app',


                // sort by day
                sort_by_day: '',

                // sort by between date
                sort_by_startDate: '',
                sort_by_endDate: '',


                // report type
                reportType: [{
                        value: '',
                        text: "All"
                    },
                    {
                        value: "3",
                        text: "Last 3 Days Reports"
                    },
                    {
                        value: "5",
                        text: "Last 5 Days Reports"
                    },
                    {
                        value: "7",
                        text: "Last 7 Days Reports"
                    },
                    {
                        value: "10",
                        text: "Last 10 Days Reports"
                    },
                    {
                        value: "15",
                        text: "Last 15 Days Reports"
                    },
                    {
                        value: "30",
                        text: "Last 30 Days Reports"
                    },
                ],

                remarksDialog: false,
                allRemarks: [],
                docPath: '/images/application/',


                // rating component
                appratingDialogShow: false,
                appratingKey: 0,

                // currentDataId
                currentDataId: '',

                // longtextDialog
                longtextDialog: false,
                currentText: '',
                longtextDialogHTML: false,
                currentTextHTML: '',

            }


        },

        methods: {
            childToParentCall() {
                this.getResults();
            },

            // longtextDialog
            longText(value) {
                this.currentText = value;
                this.longtextDialog = true;
            },

            // longtextDialogHTML
            longTextHTML(value) {
                this.currentTextHTML = value;
                this.longtextDialogHTML = true;
            },

            // feedback
            feedback(data) {
                this.currentDataId = data.id;
                this.appratingDialogShow = true;
                this.appratingKey++
            },

            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/history?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field +
                        '&sort_by_day=' + this.sort_by_day +
                        '&sort_by_startDate=' + this.sort_by_startDate +
                        '&sort_by_endDate=' + this.sort_by_endDate
                    )
                    .then(response => {
                        // console.log(response.data.data);
                        //console.log(response.data.from, response.data.to);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;

                        // Loading Animation
                        this.dataLoading = false;

                    });
            },



            // remarksDetailsShow
            remarksDetailsShow(val) {
                this.allRemarks = []
                this.allRemarks = val
                this.remarksDialog = true
            },


            // complainCancel
            complainCancel(val) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to cancel this complain !',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes!',
                }).then((result) => {

                    // Send request to the server
                    if (result.value) {
                        //console.log(id);
                        this.$Progress.start();
                        axios.post(this.currentUrl + '/complain_cancel', {
                            id: val
                        }).then((response) => {
                            //console.log(response);
                            Swal.fire(
                                'Changed!',
                                'Status has been Changed.',
                                'success'
                            );
                            // Refresh Tbl Data with current page
                            this.getResults(this.currentPageNumber);
                            this.$Progress.finish();

                        }).catch((data) => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Somthing Going Wrong<br>' + data.message,
                                customClass: 'text-danger'
                            });
                            // Swal.fire("Failed!", data.message, "warning");
                        });
                    }
                })

            },







        },


        watch: {

            sort_by_day: function () {
                this.sort_by_startDate = ''
                this.sort_by_endDate = ''
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },


            sort_by_startDate: function () {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

            sort_by_endDate: function () {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },

        },



        created() {

            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();

        }



    }

</script>

<style scoped>
    .image-thum-size {
        height: 50px;
        width: 100px;
    }

    .bg_card {
        background: linear-gradient(120deg, rgb(249, 168, 37) 60%, rgba(0, 0, 0, 1) 40%);
    }

</style>
