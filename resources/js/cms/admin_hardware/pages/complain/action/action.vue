<template>
    <div>
        <v-card class="mb-5">
            <v-card-title> Hardware Complain Actions </v-card-title>
            <v-card-text v-if="complainDeta" class="table-responsive">
                <!-- Start Complain and user Details -->
                <table class="table mb-0">
                    <tr>
                        <th>Complain No:</th>
                        <td>
                            <div class="pa-1 info rounded-pill h6 text-white text-center">
                                {{ complainDeta.id }}
                            </div>
                        </td>
                        <th>Category:</th>
                        <td>
                            <v-btn v-if="complainDeta.category" @click="modifyDialogShow()" color="info" small
                                elevation="20">
                                <v-icon left>mdi-playlist-edit</v-icon>
                                {{ complainDeta.category.name }}
                            </v-btn>
                            <v-btn @click="modifyDialogShow()" v-else class="error">N/A</v-btn>
                        </td>
                        <th>Subcategory:</th>
                        <td>
                            <v-btn v-if="complainDeta.subcategory" @click="modifyDialogShow()" color="info" small
                                elevation="20">
                                <v-icon left>mdi-playlist-edit</v-icon>
                                {{ complainDeta.subcategory.name }}
                            </v-btn>
                            <v-btn @click="modifyDialogShow()" v-else class="error">N/A</v-btn>
                        </td>
                    </tr>

                    <tr>
                        <th>Complain By:</th>
                        <td>
                            <button class="btn btn-secondary btn-sm" v-if="complainDeta.makby"
                                @click="currentUserView(complainDeta.makby)">
                                <v-avatar size="20" @click="currentUserView(complainDeta.makby)">
                                    <img v-if="complainDeta.makby.image"
                                        :src="'/images/users/small/' + complainDeta.makby.image" alt="image" />
                                </v-avatar>
                                {{ complainDeta.makby.name }}
                            </button>
                        </td>
                        <th>Department:</th>
                        <td>
                            <span v-if="complainDeta.makby">{{ complainDeta.makby.department }}</span>
                        </td>
                        <th>Register:</th>
                        <td>
                            <span v-if="complainDeta.created_at">{{ complainDeta.created_at | moment("MMMM Do YYYY, h:mm A") }}</span>
                        </td>
                    </tr>

                    <tr>
                        <th>Final Status:</th>
                        <td>
                            <div class="pa-1 success rounded-pill h6 text-white text-center">
                                {{ complainDeta.process }}
                            </div>
                        </td>

                        <th v-if="complainDeta.computer_name">C. Name:</th>
                        <td v-if="complainDeta.computer_name">
                            {{ complainDeta.computer_name }}
                        </td>

                        <th>Files:</th>
                        <td>
                            <span v-if="complainDeta.document">
                                <span v-if="complainDeta.document && complainDeta.document.includes('.pdf')">
                                    <v-btn v-if="complainDeta.document" :loading="pdfReadyLoading"
                                        @click="pdfGetFile(docPath2 + complainDeta.document)" small class="ma-1"
                                        color="primary">
                                        <v-icon left>mdi-eye</v-icon> View
                                    </v-btn>
                                </span>
                                <span v-else-if="
                                    (complainDeta.document &&
                                    complainDeta.document.includes('.jpg')) ||
                                    (complainDeta.document &&
                                    complainDeta.document.includes('.jpeg')) ||
                                    (complainDeta.document &&
                                    complainDeta.document.includes('.png')) ||
                                    (complainDeta.document &&
                                    complainDeta.document.includes('.JPG')) ||
                                    (complainDeta.document &&
                                    complainDeta.document.includes('.JPEG')) ||
                                    (complainDeta.document &&
                                    complainDeta.document.includes('.PNG'))
                                ">
                                    <v-btn v-if="complainDeta.document" :loading="imageReadyLoading"
                                        @click="imageGetFile(docPath2 + complainDeta.document)" small class="ma-1"
                                        color="primary">
                                        <v-icon left>mdi-eye</v-icon> View(image)
                                    </v-btn>
                                </span>
                                <span v-else>
                                    <a v-if="complainDeta.document" :href="docPath + complainDeta.document"
                                        class="btn btn-info btn-sm text-white m-1" download>
                                        <v-icon color="white" small>mdi-paperclip</v-icon> Doc
                                    </a>
                                </span>
                            </span>
                            <span v-else class="text-danger bg-white rounded px-1">N/A</span>
                           
                        </td>
                    </tr>

                    <tr>
                        <th>Rating:</th>
                        <td>
                            <v-rating v-if="complainDeta.rating && complainDeta.process == 'Closed'"
                                :value="complainDeta.rating" color="yellow darken-3" background-color="grey darken-1"
                                empty-icon="$ratingFull" readonly></v-rating>
                            <span v-if="!complainDeta.rating && complainDeta.process != 'Closed'">Waiting for
                                Close</span>
                            <span v-if="!complainDeta.rating && complainDeta.process == 'Closed'"
                                class="text-danger">Not yet rated</span>
                        </td>
                        <th>Feedback:</th>
                        <td colspan="3">{{ complainDeta.feedback }}</td>
                    </tr>

                    <tr v-if="complainDeta.accessories">
                        <th>Accessories:</th>
                        <td colspan="5">{{ complainDeta.accessories }}</td>
                    </tr>
                    <tr>
                        <th>Details:</th>
                        <td colspan="5" v-html="complainDeta.details"></td>
                    </tr>
                </table>
                <!--End Complain and user Details -->

                <!-- All Remarks -->
                <div v-if="complainDeta.remarks" class="mb-2 rem_bg_color">
                    <div v-for="(item, index) in complainDeta.remarks" :key="index">
                        <!--Start remarks -->
                        <table class="table mb-1 text-white rounded border-bottom border-danger">
                            <!-- remarks -->
                            <tr>
                                <th>Process: ({{ index + 1 }})</th>
                                <td>
                                    <span v-if="item.process == 'Damaged'"
                                        class="text-danger bg-white rounded px-1">Damaged</span>
                                    <span v-else-if="item.process == 'Closed'"
                                        class="text-danger bg-white rounded px-1">Closed</span>
                                    <span v-else>{{ item.process }}</span>
                                </td>
                                <th>Document:</th>
                                <td>
                                    <span v-if="item.document">
                                        <span v-if="item.document && item.document.includes('.pdf')">
                                            <v-btn v-if="item.document" :loading="pdfReadyLoading"
                                                @click="pdfGetFile(docPath2 + item.document)" small class="ma-1"
                                                color="primary">
                                                <v-icon left>mdi-eye</v-icon> View (PDF)
                                            </v-btn>
                                        </span>
                                        <span v-else-if="(item.document && item.document.includes('.jpg')) ||(item.document && item.document.includes('.jpeg')) ||
                                            (item.document && item.document.includes('.png')) ||
                                            (item.document && item.document.includes('.JPG')) ||
                                            (item.document && item.document.includes('.JPEG')) ||
                                            (item.document && item.document.includes('.PNG'))">
                                            <v-btn v-if="item.document" :loading="imageReadyLoading"
                                                @click="imageGetFile(docPath2 + item.document)" small class="ma-1"
                                                color="primary">
                                                <v-icon left>mdi-eye</v-icon> View (image)
                                            </v-btn>
                                        </span>
                                        <span v-else>
                                            <a v-if="item.document" :href="docPath + item.document"
                                                class="btn btn-info btn-sm text-white m-1" download>
                                                <v-icon color="white" small>mdi-paperclip</v-icon> Document
                                            </a>
                                        </span>
                                    </span>
                                    <span v-else class="text-danger bg-white rounded px-1">N/A</span>
                                </td>
                            </tr>
                            <tr>
                                <th>By:</th>
                                <td>
                                    <button class="btn btn-secondary btn-sm" v-if="item.makby"
                                        @click="currentUserView(item.makby)">
                                        <v-avatar size="20">
                                            <img v-if="item.makby.image"
                                                :src="'/images/users/small/' + item.makby.image" alt="image" />
                                        </v-avatar>
                                        {{ item.makby.name }}
                                    </button>
                                </td>
                                <th>Action At:</th>
                                <td>
                                    <span v-if="item.created_at">{{ item.created_at | moment("MMMM Do YYYY, h:mm A") }}</span>
                                </td>
                            </tr>

                            <!-- Damage Apply by User -->
                            <!-- {{ complainDeta.damage }} -->
                            <tr v-if=" (item.process == 'Damaged' || item.process == 'Partial Damaged') &&
                                complainDeta.damage && complainDeta.damage.apply_by" class="dmg_bg_color">
                                <th>Replace Applied:</th>
                                <td>Successfully</td>
                                <th>Apply At:</th>
                                <td>
                                    <span v-if="complainDeta.damage.apply_at" >{{ complainDeta.damage.apply_at | moment("MMMM Do YYYY, h:mm A") }}</span>
                                </td>
                            </tr>
                            <!-- Start Remarks Email send  -->
                            <tr v-if="item.mail">
                                <th>E-Mail:</th>
                                <td>
                                    <span v-if="item.mail.status">Successfully Sent</span>
                                    <span v-else class="text-warning">Sending</span>
                                    <v-btn @click="mailSendManual(item.mail.id)" small class="float-right"
                                        elevation="20">
                                        <v-icon>mdi-email-send</v-icon>
                                    </v-btn>
                                </td>
                                <th>Send At:</th>
                                <td>
                                    <span v-if="item.mail.status">{{ item.mail.updated_at | moment("MMMM Do YYYY, h:mm A") }}</span>
                                    <span v-else class="text-warning">Sending</span>
                                </td>
                            </tr>
                            <!-- End Remarks Email send  -->
                            <tr>
                                <th>Remarks:</th>
                                <td colspan="3" v-html="item.details"></td>
                            </tr>
                            <!-- Damaged Replaced -->
                            <tr class="dmg_bg_color" v-if=" item.process == 'Deliverable' && complainDeta.damage && complainDeta.damage.rep_pro_id ">
                                <td colspan="8" class="text-center h3">
                                    Damaged Replaced
                                </td>
                            </tr>


                        </table>
                        <!--End remarks -->

                        <!--Start ho_remarks -->
                        <div v-if="item.process == 'HO Service'">
                            <div v-for="(item, index) in complainDeta.ho_remarks" :key="index">
                                <table class="table mb-0 bg-info text-white rounded">
                                    <tr>
                                        <th>HO Process: ({{ index + 1 }})</th>
                                        <td>
                                            <span v-if="item.process == 'Damaged'"
                                                class="text-danger bg-white rounded px-1">Damaged</span>
                                            <span v-else-if="item.process == 'Closed'"
                                                class="text-danger bg-white rounded px-1">Closed</span>
                                            <span v-else>{{ item.process }}</span>
                                        </td>
                                        <th>Document:</th>
                                        <td>
                                            <span v-if="item.document">
                                                <a v-if="item.document" :href="docPath + item.document"
                                                    class="btn btn-info btn-sm text-white" download>
                                                    <v-icon color="white" small>mdi-paperclip</v-icon>
                                                    Document
                                                </a>
                                            </span>
                                            <span v-else class="text-danger bg-white rounded px-1">N/A</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>By:</th>
                                        <td>
                                            <button class="btn btn-secondary btn-sm" v-if="item.makby"
                                                @click="currentUserView(item.makby)">
                                                <v-avatar size="20">
                                                    <img v-if="item.makby.image"
                                                        :src="'/images/users/small/' + item.makby.image" alt="image" />
                                                </v-avatar>
                                                {{ item.makby.name }}
                                            </button>
                                        </td>
                                        <th>Action At:</th>
                                        <td>
                                            <span v-if="item.created_at">{{ item.created_at | moment("MMMM Do YYYY, h:mm A") }}</span>
                                        </td>
                                    </tr>
                                    <!-- Email send  -->
                                    <tr v-if="item.mail">
                                        <th>E-Mail:</th>
                                        <td colspan="1">
                                            <span v-if="item.mail.status">Successfully Sent</span>
                                            <span v-else class="text-warning">Sending</span>
                                            <v-btn @click="mailSendManual(item.mail.id)" small class="float-right"
                                                elevation="20">
                                                <v-icon>mdi-email-send</v-icon>
                                            </v-btn>
                                        </td>
                                        <th>Send At:</th>
                                        <td colspan="1">
                                            <span v-if="item.mail.status">{{ item.mail.updated_at | moment("MMMM Do YYYY, h:mm A") }}</span>
                                            <span v-else class="text-warning">Sending</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Remarks:</th>
                                        <td colspan="3" v-html="item.details"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!--End ho_remarks -->

                       
                    </div>
                </div>

               
                 

                
                
                <!-- Start Damaged Replaced received -->

                <!-- Start Delivered -->
                <table class=" table mb-1 deliver_bg_color text-white rounded border-bottom border-danger" v-if="complainDeta.delivery">
                    <!-- {{ complainDeta.delivery }} -->

                    <tr>
                        <td colspan="8" class="text-center h3">----- Delivered -----</td>
                    </tr>
                    <tr>
                        <th>By:</th>
                        <td colspan="3">
                            <button class="btn btn-secondary btn-sm" v-if="complainDeta.delivery.makby"
                                @click="currentUserView(complainDeta.delivery.makby)">
                                <v-avatar size="20">
                                    <img v-if="complainDeta.delivery.makby.image" :src="'/images/users/small/' + complainDeta.delivery.makby.image" alt="image" />
                                </v-avatar>
                                {{ complainDeta.delivery.makby.name }}
                            </button>
                        </td>
                        <th>Action At:</th>
                        <td colspan="3">
                            <span v-if="complainDeta.delivery.created_at">{{ complainDeta.delivery.created_at | moment("MMMM Do YYYY, h:mm A") }}</span>
                        </td>
                    </tr>

                    <!-- End Email send  -->
                    <tr v-if="complainDeta.delivery.mail">
                        <th>E-Mail:</th>
                        <td colspan="3">
                            <span v-if="complainDeta.delivery.mail.status">Successfully Sent</span>
                            <span v-else class="text-warning">Sending</span>
                            <v-btn @click="mailSendManual(complainDeta.delivery.mail.id)" small class="float-right"
                                elevation="20">
                                <v-icon>mdi-email-send</v-icon>
                            </v-btn>
                        </td>
                        <th>Send At:</th>
                        <td colspan="3">
                            <span v-if="complainDeta.delivery.mail.status">{{ complainDeta.delivery.mail.updated_at | moment("MMMM Do YYYY, h:mm A") }}</span>
                            <span v-else class="text-warning">Sending</span>
                        </td>
                    </tr>
                    <!-- End Email send  -->
                    <tr>
                        <th>Receiver Name:</th>
                        <td>{{ complainDeta.delivery.rec_name }}</td>
                        <th>Receiver Contact:</th>
                        <td>{{ complainDeta.delivery.rec_contact }}</td>
                        <th>Receiver Position:</th>
                        <td>{{ complainDeta.delivery.rec_position }}</td>
                        <th>Received At:</th>
                        <td>
                            <span v-if="complainDeta.delivery.updated_at">{{
                  complainDeta.delivery.updated_at
                    | moment("MMMM Do YYYY, h:mm A")
                }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Remarks:</th>
                        <td colspan="7" v-html="complainDeta.delivery.details"></td>
                    </tr>
                </table>
                <!-- Start Delivered -->

                <!-- Action Btn  -->
                <div class="mt-3">
                    <v-btn v-if="actionAccess" :loading="actionBtnLoading" block :class="actionBtnColor"
                        @click="actionDialogShow()" elevation="20">
                        <v-icon left>mdi-gesture-tap-button</v-icon> {{ actionBtnText }}
                    </v-btn>

                    <v-btn v-else block :class="actionBtnColor" style="cursor: none">
                        <v-icon left>mdi-gesture-tap-button</v-icon> {{ actionBtnText }}
                    </v-btn>
                </div>

            </v-card-text>
            <v-card-text v-else>
                <div v-if="dataLoading" class="p-5 my-5">
                    <p class="text-center h1">
                        Loading..
                        <v-icon color="success" size="100">mdi mdi-loading mdi-spin
                        </v-icon>
                    </p>
                </div>
                <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">
                    Sorry !! Data Not Available
                </h1>
            </v-card-text>
        </v-card>

        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

        <!-- user-details -->
        <user-details v-if="CurrentUserData" :userData="CurrentUserData" :key="userDetailsDialogKey"></user-details>

        <!-- Modify Dialog -->
        <cat-sub-modify-dialog v-if="CurrentComDataModify" :comData="CurrentComDataModify" :key="comModifyDialogKey"
            @childToParent="childToParentCall"></cat-sub-modify-dialog>

        <!-- Not Process Action Dialog -->
        <action-dialog v-if="actionVal" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog>

        <!-- Processing Action Dialog -->
        <action-dialog-2 v-if="actionVal2" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog-2>

        <!-- H.O. Action Dialog -->
        <action-dialog-3 v-if="actionVal3" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog-3>

        <!-- Damaged Replacment Action Dialog -->
        <action-dialog-4 v-if="actionVal4" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog-4>
        <!-- Damaged Quotation -->
        <action-dialog-5 v-if="actionVal5" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog-5>
        <!-- Delivery -->
        <action-dialog-6 v-if="actionVal6" :comData="CurrentComData" :key="comActionsDialogKey"
            @childToParent="childToParentCall"></action-dialog-6>

        <!-- viewDocumentDialog -->
        <v-dialog v-model="viewDocument" max-width="900">
            <v-card>
                <vue-pdf-app :file="pdfFile" />
            </v-card>
        </v-dialog>

        <!-- viewImageDialog -->
        <v-dialog v-model="viewImage">
            <v-card>
                <v-card-title>
                    <a :href="'/' + imageFile" class="btn btn-info btn-sm text-white m-1" download>
                        <v-icon color="white" small>mdi-paperclip</v-icon> Download
                    </a>
                </v-card-title>
                <v-img :src="'/' + imageFile" alt="image" contain></v-img>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

    import actionAllMethods from './js/action_methods'

    // User Details Show By Dialog
    import userDetails from "../../../../../super_admin/pages/users/details/user_details.vue";
    import userDetailsData from "../../../../../super_admin/pages/users/details/js/data";
    import userDetailsMethods from "../../../../../super_admin/pages/users/details/js/methods";

    import catSubModifyDialog from "./cat_sub_modify.vue";
    import actionDialog from "./dialog/action_dialog.vue";
    import actionDialog2 from "./dialog/action_dialog_2.vue";
    import actionDialog3 from "./dialog/action_dialog_3.vue";
    import actionDialog4 from "./dialog/action_dialog_4.vue";
    import actionDialog5 from "./dialog/action_dialog_5.vue";
    import actionDialog6 from "./dialog/action_dialog_6.vue";

    import VuePdfApp from "../../common/pdfViewApp.vue";

    export default {
        components: {
            "user-details": userDetails,
            "cat-sub-modify-dialog": catSubModifyDialog,
            "action-dialog": actionDialog,
            "action-dialog-2": actionDialog2,
            "action-dialog-3": actionDialog3,
            "action-dialog-4": actionDialog4,
            "action-dialog-5": actionDialog5,
            "action-dialog-6": actionDialog6,
            "vue-pdf-app": VuePdfApp,
        },

        data() {
            return {
                //current page url
                currentUrl: "/cms/h_admin/complain",

                docPath: "/images/hardware/",

                comId: this.$route.query.id,

                complainDeta: "",

                //Action Dialog
                actionBtnLoading: false,
                actionVal: false,
                actionVal2: false,
                actionVal3: false,
                actionVal4: false,
                actionVal5: false,
                actionVal6: false,
                comActionsDialogKey: 3,
                CurrentComData: "",

                // comModifyDialog
                comModifyDialogKey: 5,
                CurrentComDataModify: "",

                actionBtnText: "Action",
                actionBtnColor: "success",
                actionAccess: true,

                // Current User Show By Dilog
                ...userDetailsData,
            };
        },

        methods: {
            childToParentCall() {
                //console.log('child') // someValue
                // refresh data
                this.getComplainData();

                // For sidebar counter
                this.countAll();
            },

            // CurrentUserData
            ...userDetailsMethods,

           // actionAllMethods
           ...actionAllMethods,
        },

        mounted() {
            // console.log('drafts', this.drafts)
        },

        created() {
            this.$Progress.start();
            this.getComplainData();

            this.allReplayDraft();

            //console.log(this.comId, this.$route.query.id, this.isHardwareHoService() )
            this.$Progress.finish();
        },
    };

</script>

<style>
    .rem_bg_color {
        background: #283c86;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #45a247, #283c86);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #45a247, #283c86); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }

    .dmg_bg_color{
        background: #009FFF;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #ec2F4B, #009FFF);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #ec2F4B, #009FFF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }

    .process_bgclr {
        background: #bbf1c9;
    }

    .deliver_bg_color{
        background: #00F260;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #0575E6, #00F260);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #0575E6, #00F260); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }


</style>
