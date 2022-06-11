import axios from "axios";
import {
    mapGetters
} from 'vuex'


import paginateMethods from './paginate_methods'
import imageMethods from './image_methods'
import createUpdate from './crud'


import globalRolePermissions from './../../../../role_permissions'



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
            overlayFileView: false,

            Departments: [],
            Offices: [],
            allManager: [],
            allBU: [],

            // Tbl number of data show
            tblItemNumberShow:[5,10,15,25,50,100],
            
            dataModalLoading: false,

            // pdf
            //pdf: '',
            pdfbase64: '',
            viewDocument: false,
            // for pdf only
            docPath2: 'images/iaccess/',
            pdfReadyLoading:false,

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

        

        getAllManagerBuOfficeDept() {
            axios.get('/iaccess/manager_bu_list').then(response => {
                //console.log(response.data)

                // Manager
                response.data.userList.forEach(element => {
                    if(element.office_email){
                        this.allManager.push({
                            value: element,
                            text: element.name+' || '+ element.department+' || '+ element.business_unit
                        });
                    }
                });

                // BU
                response.data.buList.forEach(element => {
                    if(element.email){
                        this.allBU.push({
                            value: element,
                            text: element.name+' || '+ element.designation
                        });
                    }
                });

                // Office
                response.data.allOffices.forEach(element => {
                    if(element.zone_office){
                        this.Offices.push({
                            value: element.zone_office,
                            text: element.zone_office
                        });
                    }
                });

                // Department
                response.data.allDepartment.forEach(element => {
                    if(element.department){
                        this.Departments.push({
                            value: element.department,
                            text: element.department
                        });
                    }
                });
            });
        },


        // PDF
        base64ToArrayBuffer(base64) {
            var binary_string = window.atob(base64);
            var len = binary_string.length;
            var bytes = new Uint8Array(len);
            for (var i = 0; i < len; i++) {
                bytes[i] = binary_string.charCodeAt(i);
            }
            this.pdfbase64 = bytes.buffer
            this.overlayFileView = false
            this.viewDocument = true
            return bytes.buffer;
        },

        // PDF
        pdfGetFile(doc) {
            this.overlayFileView = true
            axios.post('/iaccess/pdf_get_file', {
                document: doc
            }).then((res) => {
                this.base64ToArrayBuffer(res.data)
            }).catch(error=>{
                this.overlayFileView = false
                console.error(error)
            });
        },

        imageGetFile(doc) {
            //console.log(doc);
            this.imageReadyLoading = true;
            this.imageFile = doc;
            this.viewImage = true;
            this.imageReadyLoading = false;
        },

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
        }),

    },



}
