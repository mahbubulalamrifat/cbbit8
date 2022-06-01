import axios from "axios";
import { mapGetters } from 'vuex'
// Vuex File
// import store from './../vuex/store';

import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'
import rolesPermission from './roles_permission'

import {debounce} from './../../../../helpers'


export default {
    data() {
      return {
      
        // DataTbl Common Featurs 
        paginate: 10,
        search: '',
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

        // veutify Dilog
        dataModalDilog: false,
        valid: false,
        modalBtnLoading: false,

        // Tbl number of data show
        tblItemNumberShow:[5,10,15,25,50,100],
        search_field:'',

      }
    },

    methods: {

        
        // Permission Role check
        ...rolesPermission,
      
        // Paginate Methods
        ...paginateMethods,

        // Image Upload Methods
        ...imageMethods,

        // create Update Methods
        ...createUpdate,




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


    computed : {

        // map this.count to store.state.count getLoading 
        ...mapGetters({
            'auth'      : 'getAuth',
            'roles'     : 'getRoles',
        }),
       
        // All Roles Permission
        // ...rolesPermission

    },



  }