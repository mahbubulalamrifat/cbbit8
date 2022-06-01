<template>
    <div>
        <v-card>
            <v-card-title class="justify-center">
                <v-row>
                    <v-col cols="10">
                        Announcement
                    </v-col>
                    <v-col cols="2">
                        <v-btn @click="addDataModel()" color="primary" elevation="10" small outlined
                            class="float-right">
                            <v-icon small>mdi-card-plus</v-icon> Add
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>

            <v-card-text>
                <div v-if="allData.data">
                    <v-row>
                        <v-col cols="3">
                            <!-- Show -->
                            <v-select v-model="paginate" label="Show:" :items="tblItemNumberShow" small>
                            </v-select>
                        </v-col>

                        <v-col cols="9">
                            <v-text-field prepend-icon="mdi-clipboard-text-search" v-model="search" label="Search:"
                                placeholder="Search Input..."></v-text-field>
                        </v-col>
                    </v-row>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <th>Message</th>
                                <th>Announcement Time</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr v-for="singleData in allData.data" :key="singleData.id">
                                    <td>{{ singleData.message }}</td>
                                    <td>{{ singleData.start | moment("MMMM Do YYYY") }} to {{ singleData.end | moment("MMMM Do YYYY") }}</td>
                                    <td v-if="singleData.makby">{{ singleData.makby.name }}</td>

                                    <td class="text-center">
                                        <v-btn v-if="singleData.status" @click="statusChange(singleData)"
                                            color="success" depressed small class="m-1">
                                            <v-icon left>mdi-check-circle-outline</v-icon> Active
                                        </v-btn>
                                        <v-btn v-else @click="statusChange(singleData)" color="warning"
                                            depressed small class="m-1">
                                            <v-icon left>mdi-alert-circle-outline </v-icon> Inactive
                                        </v-btn>

                                        <v-btn @click="editDataModel(singleData)" color="info" depressed small>
                                            <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                                        </v-btn>
                                        <v-btn @click="deleteDataDirict(singleData.id)" color="error" depressed small>
                                            <v-icon left>mdi-delete-empty</v-icon> Delete
                                        </v-btn>
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
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">Sorry !! Data Not Available</h1>

            </v-card-text>
        </v-card>





        <!-- Modal -->
        <v-dialog v-model="dataModalDialog" max-width="600px" persistent>
            <v-card>
                <v-card-title class="justify-center">
                    <v-row>
                        <v-col cols="10">
                            <span v-if="editmode">Update Announcement</span>
                            <span v-else>Add New Announcement</span>
                        </v-col>
                        <v-col cols="2">
                            <v-btn @click="dataModalDialog = false,resetForm()" color="red lighten-1 white--text" small
                                class="float-right">
                                <v-icon left dark>mdi-close-octagon</v-icon> Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-form v-model="valid" ref="form">
                        <form @submit.prevent="editmode ? updateData() : createData()">

                            <v-row>

                                <v-col cols="12">
                                    <v-textarea v-model="form.message" outlined label="Announcement Message" placeholder="Enter Announcement Message"
                                        :rules="announcementRules" required></v-textarea>
                                    <div class="text-danger" v-if="form.errors.has('message')"
                                    v-html="form.errors.get('message')" />
                                </v-col>

                                <v-col cols="12" lg="6">
                                    <v-menu v-model="menu" min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.start" label="Start Date"
                                                prepend-icon="mdi-calendar" v-bind="attrs" v-on="on">
                                            </v-text-field>
                                        </template>

                                        <v-date-picker v-model="form.start" no-title scrollable>
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
                                            <v-text-field v-model="form.end" label="End Date"
                                                prepend-icon="mdi-calendar" v-bind="attrs" v-on="on">
                                            </v-text-field>
                                        </template>

                                        <v-date-picker v-model="form.end" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu2 = false">
                                                Cancel
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>

                            </v-row>

                            <v-btn v-show="editmode" type="submit" block depressed :loading="announcementLoader"
                                color="primary">
                                <v-icon>mdi-edit</v-icon> Update
                            </v-btn>
                            <v-btn v-show="!editmode" type="submit" block depressed :loading="announcementLoader"
                                color="primary">
                                <v-icon>mdi-save</v-icon> Create
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


    export default {

        data() {

            return {

                // menu
                menu: '',
                menu2: '',

                // v-form
                valid: false,
                // dialog
                dataModalDialog: false,

                // loader
                announcementLoader: false,

                announcementRules: [v => !!v || 'This field is required!'],


                //current page url

                currentUrl: '/super_admin/announcement',


                // Form
                form: new Form({
                    id: '',
                    message: '',
                    start: '',
                    end: '',

                }),


            }


        },

        methods: {



        },


        mounted() {
            this.$Progress.start();
            // Fetch initial results
            this.getResults();
            this.$Progress.finish();
        },



    }

</script>
