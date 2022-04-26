import axios from "axios";
import {
    mapGetters
} from 'vuex'

import store from '../store';


import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'


import globalRolePermissions from '../../../../role_permissions'





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

            // Tbl number of data show
            tblItemNumberShow: [5, 10, 15, 25, 50, 100],

            hardRating: null,
            appRating: null,


            counterDialogShow: false,
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





        handleResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        },


        // Add model show
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        // Edit Model show
        editModal(singleData) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(singleData);
        },


        closeComplainForRating() {
            axios.get('/cms/ratings').then(response => {

                store.commit('setHardCounter', response.data.hardRating);
                this.hardRating = response.data.hardRating;
                store.commit('setAppCounter', response.data.appRating);
                this.appRating = response.data.appRating
                
               
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
        search: function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        },

        //Excuted When make change value 
        search_field: function (value) {
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

            'hardCounter': 'getHardCounter',
            'appCounter': 'getAppCounter',

        }),

    },



}
