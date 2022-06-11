<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        Old Product List
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="addDataModel()" color="primary" elevation="20" small outlined
                            class="float-right">
                            <v-icon left>mdi-card-plus</v-icon> Add
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
                            <!-- by_location -->
                            <v-select v-model="by_location" label="Location List:" :items="locationUniqList" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="2" cols="4">
                            <!-- search_type -->
                            <v-select v-model="search_type" label="Product type:" :items="search_by_type"
                                item-text="text" item-value="value" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="2" cols="6">
                            <!-- search_field -->
                            <v-select v-model="search_field" label="Search By:" :items="customSrcByFields"
                                item-text="text" item-value="value" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="4" cols="6">
                            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" hide-details
                                class="mb-5" outlined dense></v-text-field>
                        </v-col>
                    </v-row>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th class="col-10">
                                        Details
                                    </th>
                                    <th class="col-2">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in allData.data" :key="singleData.id">
                                    <td class="text-left">
                                        <v-row>
                                            <v-col>

                                                <div>
                                                    <b>Product Name or Model: </b> <span
                                                        v-if="singleData.name">{{ singleData.name }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>
                                                <div>
                                                    <b>Product Category: </b> <span
                                                        v-if="singleData.category">{{ singleData.category.name }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>
                                                <div>
                                                    <b>Product Serial: </b> <span
                                                        v-if="singleData.serial">{{ singleData.serial }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>
                                                <div>
                                                    <b>Invoice Number: </b> <span
                                                        v-if="singleData.invoice_num">{{ singleData.invoice_num }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>
                                                
                                                <div class="small text-muted">
                                                    <b>Updated At:</b> <span
                                                        v-if="singleData.updated_at">{{ singleData.updated_at | moment("MMMM Do, YYYY") }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>
                                                <div class="small text-muted">
                                                    <b>Created At:</b> <span
                                                        v-if="singleData.created_at">{{ singleData.created_at | moment("MMMM Do, YYYY") }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>

                                            </v-col>
                                            <v-col>

                                                <div>
                                                    <b>Location: </b> <span
                                                        v-if="singleData.location">{{ singleData.location }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>
                                                <div>
                                                    <b>Operation: </b> <span
                                                        v-if="singleData.operation">{{ singleData.operation.name }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>
                                                <div>
                                                    <b>Department: </b> <span
                                                        v-if="singleData.department">{{ singleData.department }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>
                                                <div>
                                                    <b>Request Payment Number: </b> <span
                                                        v-if="singleData.req_payment_num">{{ singleData.req_payment_num }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>
                                                <div>
                                                    <b>Bill Submit Date : </b> <span
                                                        v-if="singleData.bill_submit">{{ singleData.bill_submit | moment("MMMM Do YYYY") }}</span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>
                                                

                                                <div>
                                                    <b>Remarks : </b> <span v-if="singleData.remarks"
                                                        v-html="singleData.remarks"></span>
                                                    <span v-else class="error--text">N/A</span>
                                                </div>

                                            </v-col>
                                        </v-row>

                                    </td>

                                    <td>

                                        <v-btn class="m-1" v-if="isSuperAdmin()" @click="editDataModel(singleData)"
                                            color="info" elevation="20" small>
                                            <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                                        </v-btn>

                                        <v-btn class="ma-1" v-if="isAdministrator()" @click="deleteDataTemp(singleData.id)"
                                            color="error" elevation="20" small>
                                            <v-icon left>mdi-delete-empty</v-icon> Delete
                                        </v-btn>

                                        <v-btn class="ma-2" @click="view(singleData)" color="success" elevation="20" small>
                                            <v-icon left>mdi-eye</v-icon> View
                                        </v-btn>
                                        <br>
                                        <span class="text-muted small">Create By-- </span>
                                        <v-btn x-small dense v-if="singleData.makby"
                                            @click="currentUserView(singleData.makby)">{{ singleData.makby.name }}</v-btn>
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
                        <p class="text-center h1">Loading.. <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                            </v-icon>
                        </p>
                    </div>
                </div>
               <h4 v-if="!totalValue && !dataLoading" class="text-center">
                <svg
                    class="svg-icon"
                    style="
                    width: 3.5em;
                    height: 3.5em;
                    vertical-align: middle;
                    fill: currentColor;
                    overflow: hidden;
                    "
                    viewBox="0 0 1024 1024"
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                    d="M294.12766 457.521021C137.956766 457.521021 10.893617 584.58417 10.893617 740.755064 10.893617 796.922553 27.364766 851.281702 58.542298 897.906383 68.542638 912.939574 88.870128 916.904851 103.859745 906.926298 118.871149 896.90417 122.901787 876.598468 112.87966 861.608851 88.913702 825.747064 76.255319 783.959149 76.255319 740.755064 76.255319 620.620255 173.992851 522.882723 294.12766 522.882723 414.262468 522.882723 512 620.620255 512 740.755064 512 860.889872 414.262468 958.627404 294.12766 958.627404 250.771064 958.627404 208.874213 945.90366 172.990638 921.828766 158.044596 911.806638 137.717106 915.72834 127.629617 930.761532 117.585702 945.751149 121.594553 966.056851 136.58417 976.122553 183.274213 1007.430809 237.742298 1023.989106 294.12766 1023.989106 450.298553 1023.989106 577.361702 896.925957 577.361702 740.755064 577.361702 584.58417 450.298553 457.521021 294.12766 457.521021ZM183.873362 851.009362C190.257021 857.393021 198.623319 860.573957 206.989617 860.573957 215.334128 860.573957 223.700426 857.393021 230.084085 851.009362L294.138553 786.976681 358.171234 851.009362C364.554894 857.393021 372.921191 860.573957 381.287489 860.573957 389.632 860.573957 397.998298 857.393021 404.381957 851.009362 417.149277 838.242043 417.149277 817.565957 404.381957 804.798638L340.349277 740.74417 404.381957 676.711489C417.149277 663.94417 417.149277 643.268085 404.381957 630.500766 391.614638 617.733447 370.938553 617.733447 358.171234 630.500766L294.138553 694.533447 230.084085 630.500766C217.316766 617.733447 196.640681 617.733447 183.873362 630.500766 171.106043 643.268085 171.106043 663.94417 183.873362 676.711489L247.906043 740.74417 183.873362 804.798638C171.106043 817.565957 171.106043 838.242043 183.873362 851.009362ZM992.064272 881.053957 859.096783 748.086468C941.365379 667.974809 991.323506 556.467745 991.323506 435.744681 991.323506 195.453277 795.848443 0 555.578826 0 327.03074 0 136.065634 178.41566 120.81457 406.201191 119.616272 424.219234 133.233294 439.797106 151.229549 441.017191 168.964357 442.171915 184.803677 428.576681 186.045549 410.580426 198.987166 217.000851 361.323847 65.361702 555.578826 65.361702 759.812357 65.361702 925.961804 231.511149 925.961804 435.744681 925.961804 603.615319 812.777123 750.853447 650.723677 793.796085 633.272102 798.436766 622.879591 816.302298 627.498485 833.753872 631.376613 848.416681 644.601464 858.068426 659.068187 858.068426 661.835166 858.068426 664.667506 857.741617 667.456272 857.000851 719.375251 843.231319 766.849634 820.115064 808.724698 790.13583L945.853549 927.264681C952.237209 933.64834 960.603506 936.851064 968.948017 936.851064 977.314315 936.851064 985.680613 933.64834 992.064272 927.264681 1004.831591 914.497362 1004.831591 893.821277 992.064272 881.053957Z"
                    fill="#990f02"
                    />
                </svg>

                <div
                    class="text-uppercase"
                    style="letter-spacing: 4px; color: #990f02"
                >
                    No Data
                </div>
                </h4>

            </v-card-text>
        </v-card>


        <!-- Modal -->
        <v-dialog persistent v-model="dataModalDialog">
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            {{dataModelTitle}}
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false, resetForm()" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-form v-model="valid" ref="form">
                        <form @submit.prevent="editmode ? updateData() : createData()">

                            <v-row align-content="center">

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('category')"
                                        v-html="form.errors.get('category')" />
                                    <v-autocomplete :items="allCategory" v-model="form.cat_id" label="Select Category"
                                        :rules="[v => !!v || 'Category is required!']" dense required>
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('operation_id')"
                                        v-html="form.errors.get('operation_id')" />
                                    <v-autocomplete :items="operation" v-model="form.operation_id"
                                        label="Select Operation" :rules="[v => !!v || 'Operation is required!']" dense
                                        required></v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('location')"
                                        v-html="form.errors.get('location')" />
                                    <v-autocomplete :items="allLocationList" v-model="form.location"
                                        label="Select Business Unit" :rules="[v => !!v || 'Business Unit is required!']"
                                        dense required></v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('department')"
                                        v-html="form.errors.get('department')" />
                                    <v-autocomplete :items="allDepartmentList" v-model="form.department" label="Select Department Name"
                                        :rules="[v => !!v || 'Department is required!']" dense required></v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('type')"
                                        v-html="form.errors.get('type')" />
                                    <v-autocomplete :items="type" v-model="form.type" label="Select Product Type"
                                        :rules="[v => !!v || 'Product Type is required!']" dense required>
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('name')"
                                        v-html="form.errors.get('name')" />
                                    <v-text-field v-model="form.name" label="Product Name or Model"
                                        :rules="[v => !!v || 'Product Name or Model is required!']"
                                        placeholder="Enter Product Product Name or Model" dense required>
                                    </v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('serial')"
                                        v-html="form.errors.get('serial')" />
                                    <v-text-field v-model="form.serial" label="Serial number"
                                        :rules="[v => !!v || 'erail Number is required!']"
                                        placeholder="Enter Serial number" dense required>
                                    </v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('invoice_num')"
                                        v-html="form.errors.get('invoice_num')" />
                                    <v-text-field v-model="form.invoice_num" label="Invoice Number"
                                        placeholder="Enter invoice number" dense>
                                    </v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('bill_submit')"
                                        v-html="form.errors.get('bill_submit')" />
                                    <!-- Date Picker -->
                                    <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                                        :return-value.sync="date" offset-y min-width="auto" dense>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.bill_submit" label="Bill Submit Date"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" dense>
                                            </v-text-field>
                                        </template>
                                        <v-date-picker v-model="form.bill_submit" scrollable dense>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu = false">
                                                Cancel</v-btn>
                                            <v-btn text color="primary" @click="$refs.menu.save(date)">
                                                OK </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('req_payment_num')"
                                        v-html="form.errors.get('req_payment_num')" />
                                    <v-text-field v-model="form.req_payment_num" label="Request Payment Number"
                                        placeholder="Enter request payment number" dense>
                                    </v-text-field>
                                </v-col>


                                <!-- Details -->
                                <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('remarks')"
                                        v-html="form.errors.get('remarks')" />
                                    <v-row>
                                        <v-col cols="8">
                                            <label>Details :</label>
                                        </v-col>
                                        <v-col cols="4" v-if="drafts">
                                            <v-autocomplete :items="drafts" dense v-model="selectDraft" label="Draft">
                                            </v-autocomplete>
                                        </v-col>
                                    </v-row> 
                                    <vue-editor
                                        :class="{ error_bg: (form.remarks && ( form.remarks.length <= 10 || form.remarks.length >= 20000 )) }"
                                        v-model="form.remarks" :editorToolbar="customToolbar"></vue-editor>
                                    <v-row>
                                        <v-col cols="10">
                                            <span v-if="(form.remarks && form.remarks.length <= 10)"
                                                class="small text-danger">10 chars minimum or more.</span>
                                            <span v-if="(form.remarks && form.remarks.length >= 20000)"
                                                class="small text-danger">Description must be 20,000 characters or
                                                less.</span>
                                        </v-col>
                                        <v-col cols="2">
                                            <span class="float-right">{{ form.remarks.length }}/ 20,000</span>
                                        </v-col>
                                    </v-row>

                                </v-col>
                            </v-row>






                            <v-btn v-show="editmode" type="submit" block depressed :loading="dataModalLoading"
                                color="primary">
                                <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                            </v-btn>
                            <v-btn v-show="!editmode" type="submit" block depressed :loading="dataModalLoading"
                                color="primary">
                                <v-icon left dark>mdi-shape-polygon-plus</v-icon> Create
                            </v-btn>


                        </form>
                    </v-form>

                </v-card-text>
            </v-card>
        </v-dialog>





        <!-- view product -->
        <view-product v-if="currentData" :currentData="currentData" :category="currentCategory"
            :operation="currentOperation" :key="leaveActionKey"></view-product>


        <!-- user-details -->
        <user-details v-if="CurrentUserData" :userData="CurrentUserData" :key="userDetailsDialogKey"></user-details>


    </div>

</template>


<script>
    // vform
    import Form from 'vform';
    import viewProduct from './../viewData.vue'

    import {
        VueEditor
    } from "vue2-editor";
    import vue2EditorToolbar from "./../../pages/common/js/vue2_editor_toolbar"


    import userTblData from './../../../../super_admin/pages/users/js/data'
    import userTblMethods from './../../../../super_admin/pages/users/js/methods'

    // User Details Show By Dialog
    import userDetails from './../../../../super_admin/pages/users/details/user_details.vue'
    import userDetailsData from './../../../../super_admin/pages/users/details/js/data'
    import userDetailsMethods from './../../../../super_admin/pages/users/details/js/methods'



    export default {

        components: {
            VueEditor,
            "view-product": viewProduct,
            'user-details': userDetails,
        },

        data() {

            return {

                //current page url
                currentUrl: '/inventory/admin/old_product',


                // timepicker
                menu: false,
                date: '',


                roomRules: [v => !!v || 'This field is required!'],

                docRules: [
                    value => !value || value.size < 2000000 || 'Document size should be less than 2 MB!',
                ],

                remRules: [
                    v => (v || '').length <= 20000 || 'Description must be 20,000 characters or less',
                    v => (v || '').length >= 10 || '10 chars minimum or more',
                ],

                // Custom Toolbar for vue2 text editor
                ...vue2EditorToolbar,

                // warranty
                warranty: 'n',
                warranty_type: 'month',
                warranty_type_data: '',

                documentAppend: '',

                // modal  for view data
                viewModal: false,


                // Form
                form: new Form({
                    id: '',
                    cat_id: '',
                    //subcat_id: '',
                    serial: '',
                    name: '',
                    remarks: '',
                    operation_id: '',
                    location: '',
                    department: '',
                    type: '',
                    rec_name: '',
                    rec_contact: '',
                    rec_position: '',
                    invoice_num: '',
                    bill_submit: '',
                    req_payment_num: '',

                }),

                customSrcByFields: [{
                        value: 'All',
                        text: 'All'
                    },
                    {
                        value: 'invoice_num',
                        text: 'Invoice Number'
                    },
                    {
                        value: 'req_payment_num',
                        text: 'Request Payment Number'
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
                        value: 'name',
                        text: 'Name'
                    },
                    {
                        value: 'operation',
                        text: 'Operation'
                    },
                    {
                        value: 'department',
                        text: 'Department'
                    },
                    {
                        value: 'rec_name',
                        text: 'Receiver Name'
                    },
                    {
                        value: 'rec_position',
                        text: 'Receiver Position'
                    },

                ],



                // type
                type: [{
                        value: 'Running',
                        text: 'Running Product'
                    },
                    {
                        value: 'Damaged',
                        text: 'Damaged Product'
                    },
                ],


                // search_by_type
                search_by_type: [{
                        value: 'All',
                        text: 'All'
                    },
                    {
                        value: 'Running',
                        text: 'Running Product'
                    },
                    {
                        value: 'Damaged',
                        text: 'Damaged Product'
                    },
                ],


                // view details
                currentData: '',
                leaveActionKey: 0,
                


                // userTblData
                ...userTblData,

                // Current User Show By Dilog
                ...userDetailsData,

                // search_type
                search_type: '',

            }


        },

        methods: {

            // userTblMethods
            //...userTblMethods,

           

            // Edit Data Modal
            editDataModel(singleData) {

                this.editmode = true;
                this.dataModelTitle = 'Update Product'
                this.form.fill(singleData);

                if (singleData.remarks === null) {
                    this.form.remarks = '';
                }
                // Subcategory
                this.getSubcategory()
                this.dataModalDialog = true;
            },

            // view
            view(data) {
                if (data.category) {
                    this.currentCategory = data.category.name
                }
                
                if (data.operation) {
                    this.currentOperation = data.operation.name
                }

                this.leaveActionKey++
                this.currentData = data
            },

            // Get table data
            getResults(page = 1) {
                this.dataLoading = true;
                axios.get(this.currentUrl + '/index?page=' + page +
                        '&paginate=' + this.paginate +
                        '&search=' + this.search +
                        '&sort_direction=' + this.sort_direction +
                        '&sort_field=' + this.sort_field +
                        '&search_field=' + this.search_field +
                        '&by_location=' + this.by_location +
                        '&search_type=' + this.search_type
                    )
                    .then(response => {
                        //console.log(response.data.data);
                        //console.log(response.data.from, response.data.to, response.data.current_page);
                        this.allData = response.data;
                        this.totalValue = response.data.total;
                        this.dataShowFrom = response.data.from;
                        this.dataShowTo = response.data.to;
                        this.currentPageNumber = response.data.current_page
                        // Loading Animation
                        this.dataLoading = false;

                    });
            },



            // CurrentUserData
            ...userDetailsMethods,



        },


        watch: {
           

            //Excuted When make change value 
            search_type: function (value) {
                this.$Progress.start();
                this.getResults();
                this.$Progress.finish();
            },
        },

        mounted() {
            this.getOptions();
            this.getAllCategory();
            this.getAllLocations();
        },


        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();

            this.$Progress.finish();
        },



    }

</script>

<style scoped>
    .v-input--selection-controls {
        margin-top: -6px;
        padding-top: 0px;
    }

    .v-radio {
        display: inline !important;
    }

</style>
