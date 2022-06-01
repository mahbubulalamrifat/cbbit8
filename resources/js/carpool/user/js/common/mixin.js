import axios from "axios";
import {
    mapGetters
} from 'vuex'


import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'


import globalRolePermissions from './../../../../role_permissions'
import {
    debounce
} from './../../../../helpers'


export default {
    data() {
        return {

            // DataTbl Common Featurs 
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
            editmode: false,
            dataModelTitle: 'Store Data',
            // Loading Animation
            dataLoading: false,

            imageMaxSize: '2111775',
            fileMaxSize: '5111775',
            overlayshow: false,


            //comment count
            // commentCount: null,
            // navbarKeyIndex: 0,

            // Tbl number of data show
            tblItemNumberShow: [5, 10, 15, 25, 50, 100],

           
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





        carNotCommented() {
            axios.get('/carpool/comment/comment_count').then(response => {
                let commentCount = response.data;
                // console.log('car commented data', response.data);
                // Data Update in store
                this.$store.commit('setCounter', response.data)
                if (commentCount >= 2) {
                    // Data Update in store
                    this.$store.commit('setCounterDialog', true)
                }

            }).catch(error => {
                // Data Update in store
                this.$store.commit('setCounterDialog', false)
                console.log(error)
            })
        },



        // get all car data
        getCarData() {
            axios.get('/carpool/history/car-data').then(response => {

                response.data.forEach(element => {
                    if(element.driver){
                        var driverName = element.driver.name
                    }else{
                        var driverName = ''  
                    }
                    this.carData.push({
                        value: element.id,
                        text: driverName + ' || ' + element.name + ' -- ' + element.number  
                    })
                });

            }).catch(error => {
                console.log(error)
            })
        },







        // End Methods
    },

    watch: {

        //Excuted When make change  
        paginate: function () {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        },

        //Excuted When make change  
        search: debounce(function () {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        }, 500),

        //Excuted When make change  
        search_field: function () {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        },

       

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

            'notComCount': 'getCounter',
            'counterDialogShow': 'getCounterDialog',
            'counterDialogKey': 'getCounterDialogKey'
        }),

    },



}
