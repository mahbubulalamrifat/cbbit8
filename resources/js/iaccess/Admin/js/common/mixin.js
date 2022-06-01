import axios from "axios";
import {
    mapGetters
} from 'vuex'


import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'
import store from './../store'

import globalRolePermissions from './../../../../role_permissions'
import {
    debounce
} from './../../../../helpers'




export default {
    data() {
        return {

            paginate: 10,
            search: '',
            search_field: '',
            sort_direction: 'desc',
            sort_field: 'id',
            currentPageNumber: null,
            // Our data object that holds the Laravel paginator data
            allData: {},
            totalValue: '',
            dataShowFrom: '',
            dataShowTo: '',

            // For Modal Dilog
            dataModalDialog: false,
            // Loading Animation
            dataModalLoading: false,

            editmode: false,
            dataModelTitle: 'Store Data',
            // Loading Animation
            dataLoading: false,

            imageMaxSize: '2111775',
            fileMaxSize: '5111775',

            // Tbl number of data show
            tblItemNumberShow: [5, 10, 15, 25, 50, 100],
            // v-form
            valid: false,

            overlayshow: false,

            sort_by_day: '',
            sort_by_startDate: '',
            sort_by_endDate: '',
            sort_by_type: '',


            // report type by day
            reportTypesDays: [{
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

            approveType: [{
                    value: '',
                    text: "All"
                },
                {
                    value: "m",
                    text: "By Manager"
                },
                {
                    value: "mb",
                    text: "Manager & B.U"
                },
                {
                    value: "v",
                    text: "Verified"
                },
                {
                    value: "nv",
                    text: "Not Verified"
                }
            ],


            // pdf
            pdf: '',
            viewDocument: false,
            // for pdf only
            docPath2: 'images/iaccess/',
            pdfReadyLoading:false,

        }
    },

    methods: {


        // Permission Role check
        ...globalRolePermissions,

        // Paginate Methods
        ...paginateMethods,

        // Image Upload Methods
        ...imageMethods,

        // create Update Methods
        ...createUpdate,

        // count
        countAll() {

            axios.get('/iaccess/admin/sidebar_count_data').then(response=>{
                // console.log(response.data)

                store.commit('setCountEmailRequest', response.data.email)
                store.commit('setCountInternetRequest', response.data.internet)
                store.commit('setCountAccountRequest', response.data.account)
                store.commit('setCountGuestRequest', response.data.guest )
                
            }).
            catch(error=>{
                console.log(error)
            })
            
        },

        // PDF
        base64ToArrayBuffer(base64) {
            var binary_string = window.atob(base64);
            var len = binary_string.length;
            var bytes = new Uint8Array(len);
            for (var i = 0; i < len; i++) {
                bytes[i] = binary_string.charCodeAt(i);
            }
            this.pdf = bytes.buffer
            this.pdfReadyLoading = false
            this.appDetailsLodaing = false;
            this.checkID = '';
            this.viewDocument = true
            return bytes.buffer;
        },

        // PDF
        pdfGetFile(doc) {
            this.pdfReadyLoading = true
            axios.post('/iaccess/pdf_get_file', {
                document: doc
            }).then((res) => {
                this.base64ToArrayBuffer(res.data)
            }).catch(error=>{
                this.pdfReadyLoading = false
                console.error(error)
            });
        }

        // End Methods
    },

    watch: {

        //Excuted When make change value 
        paginate: function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        },

        //Excuted When make change value 
        search: debounce(function () {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        }, 500),

        //Excuted When make change value 
        search_field: function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        },

        sort_by_day: function () {
            this.sort_by_startDate = ''
            this.sort_by_endDate = ''
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        },


        sort_by_startDate: function () {
            this.sort_by_day = ''
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        },

        sort_by_endDate: function () {
            this.sort_by_day = ''
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        },

        sort_by_type: function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        }

    },

    created() {
        // window.addEventListener('resize', this.handleResize);
        // this.handleResize();

    },


    mounted() {

    },


    destroyed() {
        // window.removeEventListener('resize', this.handleResize);
    },


    computed: {

        // map this.count to store.state.count getLoading 
        ...mapGetters({
            'auth': 'getAuth',
            'roles': 'getRoles',

            'CountEmail'    : 'getCountEmailRequest',
            'CountInternet' : 'getCountInternetRequest',
            'CountAccount'  : 'getCountAccountRequest',
            'CountGuest'    : 'getCountGuestRequest',
        }),

    },



}
