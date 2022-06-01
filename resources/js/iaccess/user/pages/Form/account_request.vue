<template>
    <v-dialog v-model="dataModalDialog" >

        <v-card>
            <v-card-title>
                <v-row>
                    <v-col lg="10" cols="8">
                        Official Account Authority Request Form
                    </v-col>
                    <v-col lg="2" cols="4">
                        <v-btn @click="dataModalDialog = false" color="error" small class="float-right">
                            <v-icon left dark>mdi-close </v-icon> Close
                        </v-btn>

                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-text>

                 <v-form v-model="valid" ref="form">
                    <form @submit.prevent="createData()">

                        <!-- <v-stepper-content step="1"> -->

                            <v-row class="mt-2">
                                <v-col cols="12" lg="4">
                                    <div class="text-danger" v-if="form.errors.has('name')"
                                        v-html="form.errors.get('name')" />
                                    <v-text-field label="Name" placeholder="Enter applicant name" v-model="form.name" required
                                        :rules="[v => !!v || 'Name is required!']" dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="text-danger" v-if="form.errors.has('position')" 
                                        v-html="form.errors.get('position')" />
                                    <v-text-field label="Position" placeholder="Enter applicant position" v-model="form.position" required
                                        :rules="[v => !!v || 'Position is required!']" dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="text-danger" v-if="form.errors.has('branch')"
                                        v-html="form.errors.get('branch')" />
                                    <v-autocomplete label="Branch:" placeholder="Enter applicant branch" v-model="form.branch" required
                                        :rules="[v => !!v || 'Branch is required!']" :items="Offices" dense>
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="text-danger" v-if="form.errors.has('department')"
                                        v-html="form.errors.get('department')" />
                                    <v-autocomplete label="Departments:" placeholder="Enter applicant department" v-model="form.department" required
                                        :rules="[v => !!v || 'Department is required!']" :items="Departments" dense>
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="text-danger" v-if="form.errors.has('office_mobile')"
                                        v-html="form.errors.get('office_mobile')" />
                                    <v-text-field label="Office Mobile" :rules="numberRules" placeholder="Enter applicant office mobile" v-model="form.office_mobile" 
                                         dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="text-danger" v-if="form.errors.has('personal_mobile')"
                                        v-html="form.errors.get('personal_mobile')" />
                                    <v-text-field label="Personal Mobile" placeholder="Enter applicant personal mobile" v-model="form.personal_mobile" required
                                        :rules="numberRules" dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="text-danger" v-if="form.errors.has('personal_email')"
                                        v-html="form.errors.get('personal_email')" />
                                    <v-text-field label="Personal e-mail" placeholder="Enter applicant personal e-mail" v-model="form.personal_email" required
                                        :rules="emailRules" dense></v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="text-danger" v-if="form.errors.has('office_email')"
                                        v-html="form.errors.get('office_email')" />
                                    <v-text-field label="Office e-mail" :rules="emailRules" placeholder="Enter applicant office e-mail" v-model="form.office_email" dense>
                                    </v-text-field>
                                </v-col>

                                <v-col cols="12" lg="4" v-if="int_id == 'n'">
                                    <div class="text-danger" v-if="form.errors.has('document')"
                                        v-html="form.errors.get('document')" />
                                    <v-file-input prepend-icon="mdi-paperclip"
                                        @change="uploadDocumentByName($event, 'document')"
                                        label="NID / Passport (Only Thai)" size="sm" accept=".jpg, .png, .jpeg, .pdf" required dense>
                                    </v-file-input>
                                </v-col>

                                <v-col cols="12" lg="4">
                                    <div class="text-danger" v-if="form.errors.has('manager_id')"
                                        v-html="form.errors.get('manager_id')" />
                                    <v-autocomplete label="Manager:" v-model="form.manager" required
                                        :rules="[v => !!v || 'Manager is required!']" :items="allManager" dense>
                                    </v-autocomplete>
                                </v-col>
 
                                <v-col cols="12" lg="4">
                                    <div class="text-danger" v-if="form.errors.has('bu_id')"
                                        v-html="form.errors.get('bu_id')" />
                                    <v-autocomplete label="B.U. Head:" v-model="form.bu" required
                                        :rules="[v => !!v || 'B.U. is required!']" :items="allBU" dense>
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="12" lg="4" v-if="int_id == 'n'">
                                    <div class="text-danger" v-if="form.errors.has('document2')"
                                        v-html="form.errors.get('document2')" />
                                    <v-file-input prepend-icon="mdi-paperclip"
                                        @change="uploadDocumentByName($event, 'document2')"
                                        label="Office ID / Visa (Only Thai)" size="sm" accept=".jpg, .png, .jpeg, .pdf" required dense>
                                    </v-file-input>
                                </v-col>

                               
                            </v-row>

                        
                            <div>
                                Do you have any ID <b>(like xxxx.yyy)</b> for Smart Soft, Smart Procurement, Win Feed,
                                Win Farm or other
                                <p v-if="int_id == 'n'" class="text-danger" >For first time user must attach National & CP ID card's photocopy
                                with user & users thai superior signature.
                                User must fill up the form properly with also star (**) mark area otherwise canceled by
                                CPB-IT without any notice.</p>
                            </div>
                            <v-row>
                                <v-col lg="2" cols="6">
                                    <v-checkbox v-model="int_id" label="No" value="n" color="error"></v-checkbox>
                                </v-col>
                                <v-col lg="2" cols="6">
                                    <v-checkbox v-model="int_id" label="Yes" value="y" color="success"></v-checkbox>
                                </v-col>
                                <v-col lg="8" cols="12" v-if="int_id == 'y'">
                                    <v-text-field label="Enter the ID" placeholder="Enter AD ID like xxxx.yyy"
                                        v-model="form.internet_id" required></v-text-field>
                                </v-col>
                            </v-row>

                            <div class="h5 py-2 bg-dark text-white text-center" block>Request For</div>
                            <v-row>
                                <div class="text-danger" v-if="form.errors.has('request_for')"
                                    v-html="form.errors.get('request_for')" />
                                <v-col class="py-0" lg="3" cols="6" v-for="(data, index) in options" :key="index" required>
                                    <v-checkbox multiple v-model="form.request_for" :label="data.text"
                                        :value="data.value" color="indigo"  hide-details ></v-checkbox>
                                </v-col>
                            </v-row>

                            <div class="h5 py-2 bg-dark text-white text-center mt-5" block>Access For</div>
                            <v-row>
                                <v-col lg="3" cols="6" v-for="(data, index) in accessOptions" :key="index" class="py-0">
                                    <v-checkbox multiple v-model="form.access_for" :label="data.text" :value="data.value" color="success" hide-details></v-checkbox>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12" lg="6">
                                <div class="text-danger" v-if="form.errors.has('modules')"
                                    v-html="form.errors.get('modules')" />
                                <v-textarea label="Modules" v-model="form.modules" outlined dense></v-textarea>
                                </v-col>
                                <v-col cols="12" lg="6">
                                <div class="text-danger" v-if="form.errors.has('purpose')"
                                    v-html="form.errors.get('purpose')" />
                                <v-textarea label="Purpose" v-model="form.purpose" required
                                    :rules="[v => !!v || 'Purpose is required!']" outlined dense></v-textarea>
                                </v-col>
                            </v-row>
                            
                            <v-row>
                                <v-col cols="12" >
                                    <v-btn color="primary" block type="submit" :loading="dataModalLoading">
                                        Submit
                                    </v-btn>
                                </v-col>
                            </v-row>

                    </form>
                </v-form>

            </v-card-text>
        </v-card>

        <v-overlay :value="overlayshow" z-index="9999">
            <v-progress-circular indeterminate size="64"><v-icon>mdi-email</v-icon></v-progress-circular>
        </v-overlay>

     
    </v-dialog>
</template>

<script>
    import Form from 'vform';
    export default {
        data() {
            return {

                int_id: 'n',

                valid: false,

                step: 1,

                numberRules: [
                    //v => !!v || 'Phone Number is required',
                    v => v.length == 11 || 'Phone Number must be 11 characters',
                    v => /01+/.test(v) || 'Phone Number must be valid',
                ],
                emailRules: [ 
                    //v => !!v || 'Email is required!',
                    v => (v && v.length <= 100) || 'Email must be less than 100 characters',
                    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
                ],

                options:[
                    {
                        value:'Increase Authority',
                        text: 'Increase Authority'
                    },
                    {
                        value:'Decrease Authority',
                        text: 'Decrease Authority'
                    },
                    {
                        value:'Reset Password',
                        text: 'Reset Password'
                    },
                    {
                        value:'Unblock',
                        text: 'Unblock'
                    },
                    {
                        value:'Disable',
                        text: 'Disable'
                    },
                    {
                        value:'Delete',
                        text: 'Delete'
                    },
                ],

                accessOptions:[
                    {
                        value:'Smart Soft',
                        text: 'Smart Soft'
                    },
                    {
                        value:'Smart iLab',
                        text: 'Smart iLab'
                    },
                    {
                        value:'Smart NIR',
                        text: 'Smart NIR'
                    },
                    {
                        value:'Win Food',
                        text: 'Win Food'
                    },
                    {
                        value:'Win Feed',
                        text: 'Win Feed'
                    },
                    {
                        value:'Win Farm (Poultry)',
                        text: 'Win Farm (Poultry)'
                    },
                    {
                        value:'Win Farm (Aqua)',
                        text: 'Win Farm (Aqua)'
                    },
                    {
                        value:'Expense Pivot Report',
                        text: 'Expense Pivot Report'
                    },
                ],


                dataModalDialog: true,
                // dataModalLoading: false,


                currentUrl: '/iaccess/form/account_authority',

                form: new Form({

                    // name: 'Syful',
                    // branch: 'Account',
                    // position: 'Officer',
                    // department: 'Account',
                    // office_mobile: '01707080401',
                    // personal_mobile: '01707080402',
                    // personal_email: 'personal@mail.com',
                    // office_email: 'official@mail.com',

                    name: '',
                    branch: '',
                    position: '',
                    department: '',
                    office_mobile: '',
                    personal_mobile: '',
                    personal_email: '',
                    office_email: '',


                    internet_id: '',
                    manager: '',
                    bu: '',

                    request_for: '',
                    access_for: '',
                    modules: '',
                    purpose: '',


                }),

            }
        },

        methods: {



        },


        mounted() {
            this.getAllManagerBuOfficeDept();

        }
    }

</script>
