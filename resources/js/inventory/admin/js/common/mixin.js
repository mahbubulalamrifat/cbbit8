import axios from "axios";
import { mapGetters } from 'vuex'


import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'
import globalRolePermissions from './../../../../role_permissions'
import {debounce} from './../../../../helpers'
import store from './../store'


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
        dataModelTitle: 'Add Product',
        // Loading Animation
        dataLoading: false,

        imageMaxSize: '2111775',
        fileMaxSize: '5111775',

        // Tbl number of data show
        tblItemNumberShow:[5,10,15,25,50,100],
        // v-form
        valid: false,

        selectDraft:'',

        locationUniqList: [],
        // by_location for sort
        by_location:'',

        allCategory: [],

        allDepartmentList: [],
        allLocationList: [],
        operation: [],
        currentOperation: '',

        allCatData: '',
        currentCategory: '',
                

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




        // all Replay Draft
        allReplayDraft(){
            axios.get('/inventory/admin/draft/all_data').then(response=>{
                //console.log(response.data)
                //this.allRepDrafts = response.data;
                // Store
                store.commit('setDraft', response.data )

            }).catch(error=>{
                console.log(error)
            })
        },


        // getBusinessUnitOldProductTable
        getAllLocations() {
            axios.get('/inventory/admin/old_product/locations').then(response => {
                // location
                response.data.forEach(element => {
                    this.locationUniqList.push({
                        value: element.location,
                        text: element.location
                    });
                    //console.log( this.allDepartmentList, element);
                });

            }).catch(error => {
                console.log(error)
            })
        },


        // getAllCategory
        getAllCategory() {
            axios.get('/inventory/admin/category/all').then(response => {
                this.allCatData = response.data
                //console.log(response.data)
                for (let i = 0; i < response.data.length; i++) {
                    this.allCategory.push(response.data[i]);
                    this.allCategory[i] = {
                        value: response.data[i].id,
                        text: response.data[i].name
                    };
                }
            }).catch(error => {
                console.log(error)
            })
        },

        // getOptions
        getOptions() {
            axios.get('/inventory/admin/old_product/options').then(response => {
                // console.log(response.data);
                // allDepartmentList
                response.data.department.forEach(element => {
                    this.allDepartmentList.push({
                        value: element.department,
                        text: element.department
                    });
                    //console.log('getOffice',  this.allDepartmentList, element);
                });

                // allLocationList
                response.data.zone_office.forEach(element => {
                    this.allLocationList.push({
                        value: element.zone_office,
                        text: element.zone_office
                    });
                    //console.log( this.allDepartmentList, element);
                });

                // operation
                response.data.operation.forEach(element => {
                    this.operation.push({
                        value: element.id,
                        text: element.name
                    });
                    //console.log('operation',  this.allDepartmentList, element);
                });

            }).catch(error => {
                console.log(error)
            })
        },


        // exportExcel
        exportExcel() {
            this.exportLoading = true;

            axios({
                method: 'get',
                url: this.currentUrl + '/export_data?search=' + this.search +
                    '&sort_direction=' + this.sort_direction +
                    '&sort_field=' + this.sort_field +
                    '&search_field=' + this.search_field +
                    '&by_location=' + this.by_location,

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

        // selectDraft
        selectDraft: function(value){
            if(this.form.remarks){
                this.form.remarks = this.form.remarks + value 
            }else{
                this.form.remarks = value 
            }
        }, 

        //Excuted When make change value 
        by_location: function (value) {
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
            'drafts'    : 'getDraft',
        }),

    },



  }