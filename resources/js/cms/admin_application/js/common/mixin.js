import axios from "axios";
import store from './../store'
import { mapGetters } from 'vuex'


import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'


import globalRolePermissions from './../../../../role_permissions'
import {debounce} from './../../../../helpers'



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
        dataModalDialog :false,
        // Loading Animation
        dataModalLoading: false,

        editmode: false,
        dataModelTitle: 'Store Data',
        // Loading Animation
        dataLoading: false,

        imageMaxSize: '2111775',
        fileMaxSize: '5111775',

        // Tbl number of data show
        tblItemNumberShow:[5,10,15,25,50,100],

        // v-form
        valid: false,
        
        // overlay
        overlay:false,

        // For Report search
        allZoneOffices:[],
        allDepartments:[],

        // pdf
        pdfFile: '',
        viewDocument: false,
        // for pdf only
        docPath2: 'images/application/',
          pdfReadyLoading: false,
        
        //   imageFile
          imageFile: '',
          viewImage: false,
          imageReadyLoading: false,
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




        // get Zone Offices
        getZoneOffices(){
            axios.get('/super_admin/user/zoneoffices').then(response=>{
                // console.log(response.data)
                this.allZoneOffices = response.data
            }).catch(error=>{
                console.log(error)
            })
        },

        // get Departments
        getDepartments(){
            axios.get('/super_admin/user/departments').then(response=>{
                //console.log(response.data)
                this.allDepartments = response.data
            }).catch(error=>{
                console.log(error)
            })
        },



        // countNotProcess
        countAll() {

            axios.get('/cms/a_admin/count/sidebar_count_data').then(response=>{
                //console.log(response.data)

                store.commit('setCountNotProcess', response.data.notprocess)
                store.commit('setCountProcess', response.data.process)
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
            this.pdfFile = bytes.buffer
            this.pdfReadyLoading = false
            this.appDetailsLodaing = false;
            this.checkID = '';
            this.viewDocument = true
            return bytes.buffer;
        },


        // PDF
        pdfGetFile(doc) {
            this.pdfReadyLoading = true
            axios.post('/cms/a_admin/pdf_get_file', {
                document: doc
            }).then((res) => {
                this.base64ToArrayBuffer(res.data)
            }).catch(error=>{
                this.pdfReadyLoading = false
                console.error(error)
            });
        },


        imageGetFile(doc) {
            //console.log(doc);
            this.imageReadyLoading = true;
            this.imageFile = doc;
            this.viewImage = true;
            this.imageReadyLoading = false;
            
            
        }

        
     

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

         //Excuted When make change value 
         start_date: function (value) {
            if(this.end_date){
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            }
        },

        end_date: function (value) {
            if(this.start_date){
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            }
        },

        
        zone_office: function (value) {
            this.$Progress.start();
            this.getResults();
            this.$Progress.finish();
        },

        department: function (value) {
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


    computed : {

        // map this.count to store.state.count getLoading 
        ...mapGetters({
            'auth'      : 'getAuth',
            'roles'     : 'getRoles',
            'sidebar_notprocess_counter'  : 'getCountNotProcess',
            'sidebar_process_counter'     : 'getCountProcess',
        }),

    },



  }