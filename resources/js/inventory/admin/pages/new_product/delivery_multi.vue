<template>
    <div>
        <v-dialog persistent v-model="deliverModal">
            <v-card>
                    <v-card-title class="justify-center">
                        <v-row>
                            <v-col cols="10">
                               Multiple Product Delivery Details
                            </v-col>
                            <v-col cols="2">
                                <v-btn @click="deliverModal = false, resetForm()" color="red lighten-1 white--text" small
                                    class="float-right">
                                    <v-icon left dark>mdi-close-octagon</v-icon> Close
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text>
                        <v-form v-model="valid" ref="form" >
                            <form @submit.prevent="deliveryData()">

                                <v-row>

                                    <table class="table small">
                                        <tr v-for="(item, index) in currentData" :key="index">
                                            <th>{{ index+1 }}. ID:</th>
                                            <td>{{ item.id }}</td>
                                            <th>{{ index+1 }}. Category:</th>
                                            <td>{{ item.category }}</td>
                                            <th>{{ index+1 }}. Name:</th>
                                            <td>{{ item.name }}</td>
                                            <th>{{ index+1 }}. Serial:</th>
                                            <td>{{ item.serial }}</td>
                                        </tr>
                                    </table>

                                    <!-- <v-col cols="12" lg="4">
                                        <v-text-field disabled label="Category" :value="item.category" small></v-text-field>
                                    </v-col>
                                   

                                    <v-col cols="12" lg="4">
                                        <v-text-field disabled v-model="item.name" label="Product Name or Model" small></v-text-field>
                                    </v-col>

                                    <v-col cols="12" lg="4">
                                        <v-text-field disabled v-model="item.serial" label="Serial Number" small></v-text-field>
                                    </v-col> -->
                                </v-row>
                                <v-row>

                                    <v-col cols="12" lg="4">
                                        <div class="small text-danger" v-if="form.errors.has('operation_id')"
                                            v-html="form.errors.get('operation_id')" />
                                        <v-autocomplete :items="operation" v-model="form.operation_id"
                                            label="Select Operation" :rules="[v => !!v || 'Operation is required!']"
                                            dense  required></v-autocomplete>
                                    </v-col>

                                    <v-col cols="12" lg="4">
                                        <div class="small text-danger" v-if="form.errors.has('location')"
                                            v-html="form.errors.get('location')" />
                                        <v-autocomplete :items="allLocationList" v-model="form.location"
                                            label="Select Office / Location Unit" :rules="[v => !!v || 'Business Unit is required!']"
                                            dense  required></v-autocomplete>
                                    </v-col>

                                    <v-col cols="12" lg="4">
                                        <div class="small text-danger" v-if="form.errors.has('department')"
                                            v-html="form.errors.get('department')" />
                                        <v-autocomplete :items="allDepartmentList" v-model="form.department"
                                            label="Select Department Name" :rules="[v => !!v || 'Department is required!']"
                                            dense  required></v-autocomplete>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <!-- Details -->
                                    <v-col cols="8">
                                        <div class="small text-danger" v-if="form.errors.has('remarks')"
                                            v-html="form.errors.get('remarks')" />
                                        <label>Details :</label>
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

                                    <v-col cols="4">
                                        <v-col cols="12">
                                            <div class="small text-danger" v-if="form.errors.has('rec_name')"
                                                v-html="form.errors.get('rec_name')" />
                                            <v-text-field v-model="form.rec_name" :rules="[v => !!v || 'Reciver Name is required!']" label="Receiver name" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <div class="small text-danger" v-if="form.errors.has('rec_contact')"
                                            v-html="form.errors.get('rec_contact')" />
                                            <v-text-field v-model="form.rec_contact" :rules="numberRules" label="Receiver Contact" dense required></v-text-field>
                                        </v-col>

                                        <v-col cols="12" >
                                            <div class="small text-danger" v-if="form.errors.has('rec_position')"
                                            v-html="form.errors.get('rec_position')" />
                                            <v-text-field v-model="form.rec_position" :rules="[v => !!v || 'Reciver Position is required!']" label="Receiver Position" required></v-text-field>
                                        </v-col>

                                    </v-col>

                                </v-row>






                                <v-btn type="submit" block depressed :loading="dataModalLoading"
                                    color="primary">
                                    <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                                </v-btn>

                            </form>
                        </v-form>

                    </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>



<script>
// vform
import Form from 'vform';
import {VueEditor} from "vue2-editor";
import vue2EditorToolbar from "./../../pages/common/js/vue2_editor_toolbar"
export default {

    props:['currentData'],

    data(){
        return{
            deliverModal: true,

            // numberRules
            numberRules: [
                v => !!v || 'Phone Number is required',
                v => v.length == 11 || 'Phone Number must be 11 characters',
                v => /01+/.test(v) || 'Phone Number must be valid',
            ],



            // deliver Form
            form: new Form({
                // id: '',
                // cat_id: '',
                // //subcat_id: '',
                // serial: '',
                // name: '',
                remarks: '',
                operation_id: '',
                location: '',
                department: '',
                rec_name: '',
                rec_contact: '',
                rec_position: '',
                product_ids: [],

            }),

            // Custom Toolbar for vue2 text editor
            ...vue2EditorToolbar,


            currentUrl: '/inventory/admin/new_product',
        }
    },

    components: {
        VueEditor
    },

    
    methods:{
        

        deliveryData(){

            this.form.post(this.currentUrl + '/deliver_multi').then((response) => {
                //console.log(response);
                Swal.fire(
                    'Delivered!',
                    'Your Product has been Delivered.',
                    'success'
                );
                // Refresh Tbl Data with current page
                //this.getResults(this.currentPageNumber);
                // Parent to child
                this.$emit('childToParent');
                this.deliverModal = false;
                this.$Progress.finish();

            }).catch((data) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Somthing Going Wrong<br>'+data.message,
                    customClass: 'text-danger'
                });
                // Swal.fire("Failed!", data.message, "warning");
            });

        },

        setIDsinForm(){
            this.currentData.forEach(element => {
                this.form.product_ids.push(element.id)
            });
            console.log('form-product_ids', this.form.product_ids)
        }

    },

    

    created(){
        this.setIDsinForm();
        this.getOptions();
        //console.log('currentData', this.currentData)
    }


}
</script>