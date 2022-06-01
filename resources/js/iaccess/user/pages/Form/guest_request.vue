<template>
    <v-dialog v-model="dataModalDialog">

        <v-card>
            <v-card-title>
                <v-row>
                    <v-col lg="10" cols="8">
                        Guest User Request Form
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
                                <v-text-field label="Name" placeholder="Enter applicant name" v-model="form.name"
                                    required :rules="[v => !!v || 'Name is required!']" dense></v-text-field>
                            </v-col>

                            <v-col cols="12" lg="4">
                                <div class="text-danger" v-if="form.errors.has('position')"
                                    v-html="form.errors.get('position')" />
                                <v-text-field label="Position" placeholder="Enter applicant position"
                                    v-model="form.position" required :rules="[v => !!v || 'Position is required!']"
                                    dense></v-text-field>
                            </v-col>

                            <v-col cols="12" lg="4">
                                <div class="text-danger" v-if="form.errors.has('branch')"
                                    v-html="form.errors.get('branch')" />
                                <v-autocomplete label="Branch:" placeholder="Enter applicant branch"
                                    v-model="form.branch" required :rules="[v => !!v || 'Branch is required!']"
                                    :items="Offices" dense>
                                </v-autocomplete>
                            </v-col>

                            <v-col cols="12" lg="4">
                                <div class="text-danger" v-if="form.errors.has('department')"
                                    v-html="form.errors.get('department')" />
                                <v-autocomplete label="Departments:" placeholder="Enter applicant department"
                                    v-model="form.department" required :rules="[v => !!v || 'Department is required!']"
                                    :items="Departments" dense>
                                </v-autocomplete>
                            </v-col>

                            <v-col cols="12" lg="4">
                                <div class="text-danger" v-if="form.errors.has('office_mobile')"
                                    v-html="form.errors.get('office_mobile')" />
                                <v-text-field label="Office Mobile" :rules="numberRules"
                                    placeholder="Enter applicant office mobile" v-model="form.office_mobile" dense>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" lg="4">
                                <div class="text-danger" v-if="form.errors.has('personal_mobile')"
                                    v-html="form.errors.get('personal_mobile')" />
                                <v-text-field label="Personal Mobile" placeholder="Enter applicant personal mobile"
                                    v-model="form.personal_mobile" required :rules="numberRules" dense></v-text-field>
                            </v-col>

                            <v-col cols="12" lg="4">
                                <div class="text-danger" v-if="form.errors.has('personal_email')"
                                    v-html="form.errors.get('personal_email')" />
                                <v-text-field label="Personal e-mail" placeholder="Enter applicant personal e-mail"
                                    v-model="form.personal_email" required :rules="emailRules" dense></v-text-field>
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
                                <div class="text-danger" v-if="form.errors.has('document')"
                                    v-html="form.errors.get('document')" />
                                <v-file-input prepend-icon="mdi-paperclip"
                                    @change="uploadDocumentByName($event, 'document')"
                                    label="NID / Passport (Only Thai)" size="sm" accept=".jpg, .png, .jpeg, .pdf"
                                    required dense>
                                </v-file-input>
                            </v-col>

                            <v-col cols="12" lg="4" v-if="int_id == 'n'">
                                <div class="text-danger" v-if="form.errors.has('document2')"
                                    v-html="form.errors.get('document2')" />
                                <v-file-input prepend-icon="mdi-paperclip"
                                    @change="uploadDocumentByName($event, 'document2')"
                                    label="Office ID / Visa (Only Thai)" size="sm" accept=".jpg, .png, .jpeg, .pdf"
                                    required dense>
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

                        <div class="h5 py-2 bg-dark text-white text-center" block>Guest User Information</div>
                        <v-row class="mt-3">

                            <v-col cols="12" lg="6">
                                <v-text-field label="Guest User Company" placeholder="Enter guest user company"
                                    v-model="form.guest_company" dense></v-text-field>
                            </v-col>

                            <v-col cols="12" lg="6">
                                <div class="text-danger" v-if="form.errors.has('no_of_guest')"
                                    v-html="form.errors.get('no_of_guest')" />
                                <v-text-field type="number" label="Total No of guest" placeholder="Enter total no of guest"
                                    v-model="form.no_of_guest" required  :rules="[v => !!v || 'No of guest is required!']"  dense></v-text-field>
                            </v-col>

                            <v-col cols="12" lg="6">
                                <v-text-field label="Guest Job" placeholder="Enter guest user job"
                                    v-model="form.guest_job" dense></v-text-field>
                            </v-col>

                            <v-col cols="12" lg="6">
                                <div class="text-danger" v-if="form.errors.has('guest_duration')"
                                    v-html="form.errors.get('guest_duration')" />
                                <v-text-field type="number" label="Guest User Duration" placeholder="Enter guest user duration"
                                    v-model="form.guest_duration" required  :rules="[v => !!v || 'Guest user duration is required!']"  dense></v-text-field>
                            </v-col>

                            <v-col cols="12" lg="6">
                                <v-menu v-model="menu" min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="form.start_date" label="Start Date" prepend-icon="mdi-calendar"
                                            readonly v-bind="attrs" v-on="on"></v-text-field>
                                    </template>

                                    <v-date-picker v-model="form.start_date" no-title scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="menu = false">
                                            Cancel
                                        </v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>

                            <v-col cols="12" lg="6">
                                <v-menu v-model="menu2" min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="form.end_date" label="End Date" prepend-icon="mdi-calendar"
                                            readonly v-bind="attrs" v-on="on"></v-text-field>
                                    </template>

                                    <v-date-picker v-model="form.end_date" no-title scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="menu2 = false">
                                            Cancel
                                        </v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>


                        </v-row>

                        <v-row>
                            <v-col cols="12">
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
            <v-progress-circular indeterminate size="64">
                <v-icon>mdi-email</v-icon>
            </v-progress-circular>
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



                dataModalDialog: true,
                // dataModalLoading: false,


                currentUrl: '/iaccess/form/guest_request',

                // datepicker

                menu: '',
                menu2: '',

                form: new Form({
                    
                    // name: 'Syful',
                    // branch: '',
                    // position: 'Officer',
                    // department: '',
                    // office_mobile: '01707080401',
                    // personal_mobile: '01707080402',
                    // personal_email: 'personal@mail.com',

                    name: '',
                    branch: '',
                    position: '',
                    department: '',
                    office_mobile: '',
                    personal_mobile: '',
                    personal_email: '',
                    office_email: '',


                    guest_company: '',
                    no_of_guest: '',
                    guest_job: '',
                    guest_duration: '',
                    start_date: '',
                    end_date: '',

                    manager: '',
                    bu: '',

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
