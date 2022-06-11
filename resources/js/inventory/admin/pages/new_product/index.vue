<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col lg="8" cols="6">
                        New Product List
                    </v-col>
                    <v-col lg="2" cols="6">
                        <div class="m-auto">
                            <v-btn @click="delieverMulti()" color="success" elevation="20" small>
                                <v-icon left>mdi-upload</v-icon>Multiple Delivery
                            </v-btn>
                        </div>
                    </v-col>
                    <v-col lg="2" cols="2">
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
                            <!-- search_field -->
                            <v-select v-model="search_field" label="Search By:" :items="customSrcByFields"
                                item-text="text" item-value="value" outlined dense>
                            </v-select>
                        </v-col>

                        <v-col lg="8" cols="4">
                            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" hide-details
                                class="mb-5" outlined dense></v-text-field>
                        </v-col>
                    </v-row>

                   <!-- selected_pro_ids: {{ selected_products_raw }} -->

                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th class="col-10">Details</th>
                                    <th class="col-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in allData.data" :key="singleData.id">

                                    <td class="text-left">
                                        <v-row>
                                            <v-col cols="12" lg="6">
                                                <div>
                                                    <input type="checkbox" id="checkbox" v-model="selected_products_raw" :value="singleData">
                                                    <label for="checkbox">{{ singleData.id }}</label>
                                                    <!-- <v-checkbox v-model="selected_products_raw" :value="singleData" :label="`${singleData.id}`"> </v-checkbox> -->
                                                </div>
                                                <div>
                                                    <b>Name/Model:</b> {{ singleData.name }}
                                                </div>
                                                <div>
                                                    <b>Serial:</b> <span v-html="singleData.serial"></span>
                                                </div>

                                                <div>
                                                    <b>Unit Price:</b> <span v-if="singleData.unit_price">
                                                        {{singleData.unit_price}}
                                                    </span>
                                                    <span v-else class="error--text">Not Available</span>
                                                </div>
                                                <div>
                                                    <b>Remarks:</b> <span v-html="singleData.remarks"></span>
                                                </div>

                                            </v-col>
                                            <v-col cols="12" lg="6">
                                                <div>
                                                    <b>Category:</b> <span
                                                        v-if="singleData.category">{{ singleData.category.name }}</span>
                                                </div>
                                                <div>
                                                    <b>Warranty:</b> <span
                                                        v-if="singleData.warranty && singleData.warranty > $moment(new Date()).format('YYYY-MM-DD')">
                                                        {{ singleData.warranty | moment("from") }} </span>
                                                    <span v-else class="error--text">Expired </span>
                                                </div>
                                                <div>
                                                    <b>Documents:</b>
                                                    <v-btn v-if="singleData.document"
                                                        :href="'/images/inventory/'+singleData.document" color="info"
                                                        download small>
                                                        <v-icon left>mdi-attachment</v-icon> File
                                                    </v-btn>
                                                    <span v-else class="text-danger">N/A</span>
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
                                        </v-row>
                                    </td>

                                    <td>

                                        <v-btn class="m-1" v-if="isSuperAdmin()" @click="editDataModel(singleData)"
                                            color="info" elevation="20" small>
                                            <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                                        </v-btn>

                                        <v-btn class="ma-2" v-if="isAdministrator()"
                                            @click="deleteDataTemp(singleData.id)" color="error" elevation="20" small>
                                            <v-icon left>mdi-delete-empty</v-icon> Delete
                                        </v-btn>

                                        <v-btn class="ma-2 text-white" @click="deliever(singleData)" color="orange"
                                            elevation="20" small>
                                            <v-icon left>mdi-upload</v-icon> Delivery
                                        </v-btn>
                                        <span v-if="isSuperAdmin()">
                                            <v-btn v-if="singleData.damage_st === null"
                                                @click="damageChange(singleData)" color="success" depressed small>
                                                <v-icon left>mdi-check-circle-outline</v-icon> Running
                                            </v-btn>

                                            <v-btn v-else @click="damageChange(singleData)" color="error" depressed
                                                small>
                                                <v-icon left>mdi-alert-circle-outline </v-icon> Damage
                                            </v-btn>
                                        </span>

                                        <br>
                                        <span v-if="singleData.makby" class="small text-muted">Create By--
                                            {{ singleData.makby.name }}</span>
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
                                    <div class="small text-danger" v-if="form.errors.has('cat_id')"
                                        v-html="form.errors.get('cat_id')" />
                                    <v-autocomplete :items="allCategory" v-model="form.cat_id" label="Select Category"
                                        :rules="[v => !!v || 'Category is required!']" dense required>
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
                                    <div class="small text-danger" v-if="form.errors.has('po_number')"
                                        v-html="form.errors.get('po_number')" />
                                    <v-text-field v-model="form.po_number" label="Product order (P.O.) number"
                                        :rules="[v => !!v || 'P.O. is required!']"
                                        placeholder="Enter Product order (P.O.) number" dense required>
                                    </v-text-field>
                                </v-col>


                                <!-- Document -->
                                <v-col cols="12" lg="4">
                                    <v-file-input @change="uploadDocByName($event, 'document')" show-size
                                        label="Document" accept="image/*, .pdf, .xlsx, .docx" :rules="docRules" dense>
                                        <template slot="append" v-if="editmode">
                                            <span v-if="form.document" class="text-success">
                                                <v-icon color="success">mdi-check-decagram-outline</v-icon> Yes
                                            </span>
                                            <span v-else class="text-danger">
                                                <v-icon color="error">mdi-close-octagon</v-icon> No
                                            </span>
                                        </template>
                                    </v-file-input>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('purchase')"
                                        v-html="form.errors.get('purchase')" />
                                    <!-- Date Picker -->
                                    <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                                        :return-value.sync="date" offset-y min-width="auto" dense>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.purchase" label="Purchase Bill Date"
                                                prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" required
                                                dense :rules="[v => !!v || 'Purchase Bill Date is required!']">
                                            </v-text-field>
                                        </template>
                                        <v-date-picker v-model="form.purchase" scrollable dense>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu = false">
                                                Cancel</v-btn>
                                            <v-btn text color="primary" @click="$refs.menu.save(date)">
                                                OK </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('serial')"
                                        v-html="form.errors.get('serial')" />
                                    <v-text-field v-model="form.serial" label="Serial Number"
                                        :rules="[v => !!v || 'Serial number is required!']"
                                        placeholder="Enter Product Serial number" dense required>
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
                                    <v-menu ref="menu2" v-model="menu2" :close-on-content-click="false"
                                        :return-value.sync="date" offset-y min-width="auto" dense>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.bill_submit" label="Bill Submit Date"
                                                prepend-icon="mdi-calendar" v-bind="attrs" v-on="on" dense>
                                            </v-text-field>
                                        </template>
                                        <v-date-picker v-model="form.bill_submit" scrollable dense>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu2 = false">
                                                Cancel</v-btn>
                                            <v-btn text color="primary" @click="$refs.menu2.save(date)">
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

                                <v-col cols="12" lg="4">
                                    <!-- {{ warranty }} -->
                                    <v-radio-group label="Warranty Status" v-model="warranty" row
                                        :rules="[v => !!v || 'Warranty is required!']" required>
                                        <v-radio label="Yes" value="y" color="success"></v-radio>
                                        <v-radio label="No" value="n" color="error"></v-radio>
                                    </v-radio-group>
                                </v-col>

                                <v-col cols="12" lg="4" v-if="warranty == 'y'">
                                    <v-row>
                                        <v-col cols="6">
                                            <v-select v-model="warranty_type"
                                                :items="[{text:'Month', value: 'month'}, {text:'Year', value: 'year'}]"
                                                label="Select Month or Year" dense></v-select>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-text-field type="number" v-model="warranty_type_data"
                                                label="Number Month or Year"
                                                :rules="[v => !!v || 'Number is required!']"
                                                placeholder="Number Month or Year" dense>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="small text-danger" v-if="form.errors.has('unit_price')"
                                        v-html="form.errors.get('unit_price')" />
                                    <v-text-field v-model="form.unit_price" label="Unit Price"
                                        placeholder="Enter request payment number" dense required>
                                    </v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <v-radio-group label="Multiple Product Input" v-model="multi_product_st" row
                                        :rules="[v => !!v || 'Product quantity is required!']" required>
                                        <v-radio label="Yes" value="y" color="success"></v-radio>
                                        <v-radio label="No" value="n" color="error"></v-radio>
                                    </v-radio-group>
                                </v-col>

                                <v-col cols="12" lg="4" v-if="multi_product_st == 'y'">
                                    <v-text-field type="number" v-model="form.multi_product_quantity"
                                        label="Total Number of product" :rules="[v => !!v || 'Number is required!']"
                                        placeholder="Enter total quantity of product" required>
                                    </v-text-field>
                                </v-col>

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
                                    <v-textarea v-model="form.remarks" placeholder="Enter product details"
                                        counter="2000" outlined required></v-textarea>
                                </v-col>


                                <!-- Details  -->
                                <!-- <v-col cols="12">
                                    <div class="small text-danger" v-if="form.errors.has('remarks')"
                                        v-html="form.errors.get('remarks')" />
                                    <v-row>
                                        <v-col cols="8">
                                            <label>Details :</label>
                                        </v-col>
                                        <v-col cols="4" v-if="drafts.length">
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
                                </v-col> -->
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



        <delivery-component v-if="currentData" :currentData="currentData" :category="currentCategory"
            :key="leaveActionKey" @childToParent="childToParentCall">
        </delivery-component>

        <delivery-component-multi v-if="selected_products.length" 
            :key="leaveActionKeyMulti" @childToParent="childToParentCall" :currentData="selected_products"></delivery-component-multi>

    </div>

</template>


<script>
    // vform
    import Form from 'vform';
    import deliveryModal from './delivery.vue';
    import deliveryModalMulti from './delivery_multi.vue';

    import {
        VueEditor
    } from "vue2-editor";
    import vue2EditorToolbar from "./../../pages/common/js/vue2_editor_toolbar"



    export default {

        components: {
            VueEditor,
            'delivery-component': deliveryModal,
            'delivery-component-multi': deliveryModalMulti,
        },

        data() {

            return {

                //current page url
                currentUrl: '/inventory/admin/new_product',


                // timepicker
                menu: false,
                menu2: false,
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
                multi_product_st: 'n',


                allCategory: [],
                allCatData: '',


                // Form 
                form: new Form({
                    id: '',
                    cat_id: '',
                    serial: '',
                    name: '',
                    remarks: '',
                    document: '',
                    purchase: '',
                    warranty: '',
                    unit_price: '',
                    invoice_num: '',
                    bill_submit: '',
                    req_payment_num: '',
                    po_number: '',
                    multi_product_quantity: '',

                }),


                customSrcByFields: [{
                        value: 'All',
                        text: 'All'
                    },
                    {
                        value: 'serial',
                        text: 'Serial'
                    },
                    {
                        value: 'cat_id',
                        text: 'Category'
                    }
                ],

                sortByProduct: [],




                // deliver details
                currentData: '',
                leaveActionKey: 0,
                currentCategory: '',
                currentSubcategory: '',

                // selectedProId
                selected_products_raw: [],
                selected_products: [],
                leaveActionKeyMulti: '',



            }


        },

        methods: {

            childToParentCall() {
                //console.log('child') // someValue
                // refresh data
                
                // this.selected_products = []
                this.getResults();
                this.selected_products_raw = []
                console.log('child', this.selected_products_raw)

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

           

            // Create Data
            createData() {
                this.dataModalLoading = true;
                //console.log('Form submited');
                this.$Progress.start()

                // warranty Data
                if (this.warranty_type == 'month') {
                    if (this.warranty_type_data && this.form.purchase) {
                        this.form.warranty = this.$moment(this.form.purchase).add(this.warranty_type_data, 'M').format(
                            'YYYY-MM-DD')
                        console.log('warranty-month: ', this.form.warranty)
                    }
                }
                if (this.warranty_type == 'year') {
                    if (this.warranty_type_data && this.form.purchase) {
                        this.form.warranty = this.$moment(this.form.purchase).add(this.warranty_type_data * 12, 'M')
                            .format('YYYY-MM-DD')
                        console.log('warranty-year: ', this.form.warranty)
                    }
                }

                // request send and get response
                this.form.post(this.currentUrl + '/store' + '').then(response => {

                    // Input field make empty
                    this.form.reset();
                    this.form.errors.clear();
                    this.resetForm();
                    this.dataModalLoading = false;
                    // Hide model
                    this.dataModalDialog = false;
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$Progress.finish();
                    //custom field empty
                    this.customFieldEmpty();

                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.msg
                    });

                }).catch(error => {
                    this.dataModalLoading = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong',
                        customClass: 'text-danger'
                    });
                    console.log(response);
                });



            },

            // Edit Data Modal
            editDataModel(singleData) {

                this.editmode = true;
                this.dataModelTitle = 'Update Product'
                //this.form.reset();

                // Warranty
                if (singleData.warranty) {
                    this.warranty = 'y'
                    this.warranty_type = 'month'
                    let start = this.$moment(singleData.warranty)
                    this.warranty_type_data = start.diff(this.$moment(singleData.purchase), 'months')
                    //console.log(this.warranty_type_data, start)
                }


                //console.log('singleData before',  singleData.document)
                this.form.fill(singleData);
                //console.log('singleData after',  this.form.document, singleData)
                // Subcategory
                //this.getSubcategory()

                this.dataModalDialog = true;
            },

            // Update data
            updateData() {
                this.dataModalLoading = true;
                //console.log('Edit Form submited', this.form.id);
                this.$Progress.start();

                // warranty Data
                if (this.warranty_type == 'month') {
                    if (this.warranty_type_data && this.form.purchase) {
                        this.form.warranty = this.$moment(this.form.purchase).add(this.warranty_type_data, 'M').format(
                            'YYYY-MM-DD')
                        console.log('warranty-month: ', this.form.warranty)
                    }
                }
                if (this.warranty_type == 'year') {
                    if (this.warranty_type_data && this.form.purchase) {
                        this.form.warranty = this.$moment(this.form.purchase).add(this.warranty_type_data * 12, 'M')
                            .format('YYYY-MM-DD')
                        console.log('warranty-year: ', this.form.warranty)
                    }
                }

                //console.log(this.form);

                // request send and get response
                this.form.post(this.currentUrl + '/update').then(response => {

                    // Input field make empty
                    this.form.reset();
                    this.form.errors.clear();
                    this.resetForm();
                    this.dataModalLoading = false;
                    // Hide model
                    this.dataModalDialog = false;
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$Progress.finish();

                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.msg
                    });

                }).catch(error => {
                    this.dataModalLoading = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong',
                        customClass: 'text-danger'
                    });
                    console.log(response);
                });

            },


            // deliever
            deliever(data) {
                if (data.category) {
                    this.currentCategory = data.category.name
                }
                this.leaveActionKey++
                this.currentData = data
            },

            // delieverMulti
            delieverMulti() {
                //console.log( this.selected_products_raw)
                this.selected_products = []
                if ( this.selected_products_raw.length ) {
                   
                    this.selected_products_raw.forEach(element => {
                       this.selected_products.push({
                           'id': element.id,
                           'name': element.name,
                           'category' : element.category.name,
                           'serial' : element.serial,
                       })
                    });

                   this.leaveActionKeyMulti++
                   //console.log( this.selected_products, this.selected_products.id )

                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Please, select checkbox',
                        customClass: 'text-danger'
                    });
                }

            
                
            },


            //custom field empty
            customFieldEmpty() {
                // For Multi product
                this.multi_product_st = 'n'
                // For warranty
                this.warranty = 'n'
                this.warranty_type = 'month'
                this.warranty_type_data = ''
            }


        },



        created() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();

            this.getAllCategory();

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
