<template>
  <div>
    <v-card>
      <v-card-title> All Internet / Web Access Request List </v-card-title>

      <v-card-text class="table-responsive">
        <v-row>
          <v-col cols="4" lg="2">
            <!-- Show -->
            <v-select
              v-model="paginate"
              label="Show:"
              :items="tblItemNumberShow"
              small
            >
            </v-select>
          </v-col>

          <v-col cols="4" lg="2">
            <v-select
              :items="reportTypesDays"
              label="By Days"
              v-model="sort_by_day"
            ></v-select>
          </v-col>

          <v-col cols="4" lg="2">
            <v-select
              :items="approveType"
              label="By Approve Type"
              v-model="sort_by_type"
            ></v-select>
          </v-col>

          <v-col cols="12" lg="2">
            <v-menu v-model="menu" min-width="auto">
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="sort_by_startDate"
                  label="Start Date"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  clearable
                >
                </v-text-field>
              </template>

              <v-date-picker v-model="sort_by_startDate" no-title scrollable>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="menu = false">
                  Cancel
                </v-btn>
              </v-date-picker>
            </v-menu>
          </v-col>

          <v-col cols="12" lg="2">
            <v-menu v-model="menu2" min-width="auto">
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="sort_by_endDate"
                  label="End Date"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  clearable
                ></v-text-field>
              </template>

              <v-date-picker v-model="sort_by_endDate" no-title scrollable>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="menu2 = false">
                  Cancel
                </v-btn>
              </v-date-picker>
            </v-menu>
          </v-col>

          <v-col>
            <v-text-field
              prepend-icon="mdi-clipboard-text-search"
              v-model="search"
              label="Search:"
              placeholder="Search Input..."
            ></v-text-field>
          </v-col>
        </v-row>

        <div v-if="allData.data">
          <v-card v-for="item in allData.data" :key="item.id" class="mb-3">
            <v-card-text>
              <v-row>
                <v-col cols="12" lg="5">
                  <v-row>
                    <v-col cols="12" lg="6">
                      <div>
                        <b>Req. No:</b>
                        <span
                          v-if="item.number"
                          class="
                            px-1
                            info
                            rounded-pill
                            h6
                            text-white text-center
                          "
                          >{{ item.number }}</span
                        >
                        <span v-else class="text-danger">N/A</span><br />
                        <b>Apply By:</b>
                        <v-btn
                          x-small
                          class="secondary"
                          v-if="item.makby"
                          @click="currentUserView(item.makby)"
                        >
                          <v-avatar
                            size="20"
                            @click="currentUserView(item.makby)"
                          >
                            <img
                              v-if="item.makby.image"
                              :src="'/images/users/small/' + item.makby.image"
                              alt="image"
                            />
                          </v-avatar>
                          {{ item.makby.name }}
                        </v-btn>
                        <br />
                        <b>Name:</b> {{ item.name }}<br />
                        <b>Position:</b> {{ item.position }}<br />
                        <b>Branch:</b> {{ item.branch }}<br />
                        <b>Department:</b> {{ item.department }}<br />
                        <b>Office Mobile:</b> {{ item.office_mobile }}<br />
                        <b>Register At:</b>
                        <span v-if="item.created_at">{{
                          item.created_at | moment("MMM Do YYYY")
                        }}</span>
                      </div>
                    </v-col>
                    <v-col cols="12" lg="6">
                      <div>
                        <b>Personal Mobile:</b> {{ item.personal_mobile }}<br />
                        <b>Personal Email:</b> {{ item.personal_email }}<br />
                        <b>Office Email:</b> {{ item.office_email }}<br />
                        <b>Internet ID:</b>
                        <span v-if="item.internet_id">{{
                          item.internet_id
                        }}</span>
                        <span v-else class="error--text">N/A</span><br />
                        <b>Attachments:</b>
                        <span v-if="item.document || item.document2">
                          <span v-if="item.document.includes('.pdf')">
                            <v-btn
                              v-if="item.document"
                              :loading="pdfReadyLoading"
                              @click="pdfGetFile(docPath2 + item.document)"
                              small
                              class="ma-1"
                              color="primary"
                            >
                              <v-icon left>mdi-eye</v-icon>NID (PDF)
                            </v-btn>
                          </span>
                          <span
                            v-else-if="
                              (item.document &&
                                item.document.includes('.jpg')) ||
                              (item.document &&
                                item.document.includes('.jpeg')) ||
                              (item.document &&
                                item.document.includes('.png')) ||
                              (item.document &&
                                item.document.includes('.JPG')) ||
                              (item.document &&
                                item.document.includes('.JPEG')) ||
                              (item.document && item.document.includes('.PNG'))
                            "
                          >
                            <v-btn
                              v-if="item.document"
                              :loading="imageReadyLoading"
                              @click="imageGetFile(docPath2 + item.document)"
                              small
                              class="ma-1"
                              color="primary"
                            >
                              <v-icon left>mdi-eye</v-icon> NID (image)
                            </v-btn>
                          </span>
                          <span v-else>
                            <a
                              v-if="item.document"
                              :href="docPath + item.document"
                              class="btn btn-info btn-sm text-white m-1"
                              download
                            >
                              <v-icon color="white" small>mdi-paperclip</v-icon>
                              NID
                            </a>
                          </span>

                          <span v-if="item.document2.includes('.pdf')">
                            <v-btn
                              v-if="item.document2"
                              :loading="pdfReadyLoading"
                              @click="pdfGetFile(docPath2 + item.document2)"
                              small
                              class="ma-1"
                              color="success"
                            >
                              <v-icon left>mdi-eye</v-icon>OID (PDF)
                            </v-btn>
                          </span>
                          <span
                            v-else-if="
                              (item.document2 &&
                                item.document2.includes('.jpg')) ||
                              (item.document2 &&
                                item.document2.includes('.jpeg')) ||
                              (item.document2 &&
                                item.document2.includes('.png')) ||
                              (item.document2 &&
                                item.document2.includes('.JPG')) ||
                              (item.document2 &&
                                item.document2.includes('.JPEG')) ||
                              (item.document2 &&
                                item.document2.includes('.PNG'))
                            "
                          >
                            <v-btn
                              v-if="item.document2"
                              :loading="imageReadyLoading"
                              @click="imageGetFile(docPath2 + item.document2)"
                              small
                              class="ma-1"
                              color="success"
                            >
                              <v-icon left>mdi-eye</v-icon> OID (image)
                            </v-btn>
                          </span>
                          <span v-else>
                            <a
                              v-if="item.document2"
                              :href="docPath + item.document2"
                              class="btn btn-info btn-sm text-white"
                              download
                            >
                              <v-icon color="white" small>mdi-paperclip</v-icon>
                              OID
                            </a>
                          </span>
                        </span>
                        <span v-else class="text-danger"
                          >No Document's Send</span
                        >
                      </div>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="12" lg="3">
                  <div><b>Request For:</b> {{ item.request_for }}</div>
                  <div>
                    <b>Web URL:</b>
                    <div v-if="item.web_url">
                      <div v-if="item.web_url.length < 100">
                        {{ item.web_url }}
                      </div>
                      <div v-else>
                        {{ item.web_url.substring(0, 100) + "....." }}
                        <v-btn
                          small
                          text
                          plain
                          color="primary"
                          @click="longText(item.web_url)"
                          ><u> See More </u></v-btn
                        >
                      </div>
                    </div>
                    <div v-else class="error--text">N/A</div>
                  </div>
                  <div>
                    <b>Purpose:</b>
                    <div v-if="item.purpose">
                      <div v-if="item.purpose.length < 80">
                        {{ item.purpose }}
                      </div>
                      <div v-else>
                        {{ item.purpose.substring(0, 80) + "..." }}
                        <v-btn
                          small
                          text
                          plain
                          color="primary"
                          @click="longText(item.purpose)"
                          ><u> See More </u>
                        </v-btn>
                      </div>
                    </div>
                    <div v-else class="error--text">N/A</div>
                  </div>
                </v-col>

                <v-col cols="12" lg="4">
                  <div>
                    <b> Manager:</b>
                    <span v-if="item.manager">{{ item.manager.name }}</span>
                    <div v-if="item.manager_approved">
                      <span class="success rounded-pill h6 text-white px-2">
                        <v-icon left small color="white"
                          >mdi-check-decagram</v-icon
                        >Approved
                        <small>{{
                          item.manager_approved | moment("MMMM Do YYYY")
                        }}</small>
                      </span>
                    </div>
                    <div v-else>
                      <span class="error rounded-pill h6 text-white px-2"
                        >Not Approved
                      </span>
                      <v-btn @click="emailResend(item.id, 'm')" x-small>
                        <v-icon>mdi-email-check</v-icon>
                      </v-btn>
                    </div>
                  </div>
                  <div>
                    <b>B.U Head:</b>
                    <span v-if="item.buhead">{{ item.buhead.name }}</span>
                    <div v-if="item.manager_approved">
                      <div v-if="item.bu_approved">
                        <span class="success rounded-pill h6 text-white px-2">
                          <v-icon left small color="white"
                            >mdi-check-decagram</v-icon
                          >Approved
                          <small>{{
                            item.bu_approved | moment("MMMM Do YYYY")
                          }}</small>
                        </span>
                      </div>
                      <div v-else>
                        <span class="info rounded-pill h6 text-white px-2"
                          >Not Yet Approve</span
                        >
                        <v-btn @click="emailResend(item.id, 'b')" x-small>
                          <v-icon>mdi-email-check</v-icon>
                        </v-btn>
                      </div>
                    </div>
                    <div v-else>
                      <span class="error rounded-pill h6 text-white px-2"
                        >Waiting for Approve</span
                      >
                    </div>
                  </div>
                  <div>
                    <b>Action:</b>
                    <span v-if="item.manager_approved && item.bu_approved">
                      <span v-if="item.verify">{{ item.verify.name }}</span
                      ><br />
                      <div v-if="item.verify_date">
                        <span
                          v-if="item.verify_status == 1"
                          class="success rounded-pill h6 text-white px-2"
                        >
                          <v-icon left small color="white"
                            >mdi-check-decagram</v-icon
                          >
                          Verified
                          <small>{{
                            item.verify_date | moment("MMMM Do YYYY")
                          }}</small>
                        </span>
                        <span
                          v-if="item.verify_status == 2"
                          class="error rounded-pill h6 text-white px-2"
                        >
                          <v-icon left small color="white"
                            >mdi-close-octagon</v-icon
                          >
                          Rejected
                          <small>{{
                            item.verify_date | moment("MMMM Do YYYY")
                          }}</small>
                        </span>

                        <v-btn @click="emailResend(item.id, 'v')" x-small>
                          <v-icon>mdi-email-check</v-icon>
                        </v-btn>

                        <div v-if="item.verify_remarks">
                          Remarks:
                          <div v-if="item.verify_remarks.length < 40">
                            {{ item.verify_remarks }}
                          </div>
                          <div v-else>
                            {{ item.verify_remarks.substring(0, 40) + "..." }}
                            <v-btn
                              small
                              text
                              plain
                              color="primary"
                              @click="longText(item.verify_remarks)"
                              ><u> See More </u>
                            </v-btn>
                          </div>
                        </div>
                      </div>

                      <div v-else>
                        <v-btn
                          @click="showRemarksDialog(item.id, 1)"
                          small
                          color="success"
                          elevation="10"
                          class="mb-1"
                        >
                          <v-icon left>mdi-check-decagram</v-icon> Verify
                        </v-btn>

                        <v-btn
                          @click="showRemarksDialog(item.id, 2)"
                          small
                          color="error"
                          elevation="10"
                          class="mb-1"
                        >
                          <v-icon left>mdi-close-octagon</v-icon> Reject
                        </v-btn>
                      </div>

                      <div>
                        <v-btn
                          @click="getDetails(item.id)"
                          v-if="item.id == checkID"
                          small
                          color="teal"
                          class="white--text"
                        >
                          <v-icon left>mdi-eye</v-icon>View Form
                        </v-btn>
                        <v-btn
                          @click="getDetails(item.id)"
                          v-if="item.id != checkID"
                          small
                          color="teal"
                          class="white--text"
                        >
                          <v-icon left>mdi-eye</v-icon>View Form
                        </v-btn>
                      </div>
                    </span>
                    <span v-else>
                      <span class="error rounded-pill h6 text-white px-2">
                        Waiting for Approve</span
                      >
                    </span>
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>

          <div>
            <span>Total Records: {{ totalValue }}</span>
          </div>
          <pagination
            :data="allData"
            :limit="3"
            @pagination-change-page="getResults"
            class="justify-content-end"
          >
            <span slot="prev-nav">&lt; Previous</span>
            <span slot="next-nav">Next &gt;</span>
          </pagination>
        </div>
        <div v-else>
          <div v-if="dataLoading" class="p-5 my-5">
            <p class="text-center h1">
              Loading..
              <v-icon color="success" size="100"
                >mdi mdi-loading mdi-spin
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

    <!-- Remarks -->
    <v-dialog v-model="remarkDialog" max-width="500">
      <v-card>
        <v-card-title class="text-h5 justify-center"> Remarks </v-card-title>

        <v-card-text>
          <form @submit.prevent="remarkStore()">
            <div
              class="small text-danger"
              v-if="form.errors.has('verify_remarks')"
              v-html="form.errors.get('verify_remarks')"
            />
            <v-textarea
              label="Remarks"
              placeholder="Give Your Remarks"
              outlined
              v-model="form.verify_remarks"
              sm="1"
              :rules="remRules"
              required
            ></v-textarea>

            <v-btn
              color="primary"
              :loading="dataModalDialog"
              block
              type="submit"
            >
              Submit
            </v-btn>

            <v-btn text @click="remarkDialog = false" color="error" block>
              Close
            </v-btn>
          </form>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- longtextDialog  -->
    <v-dialog v-model="longtextDialog" max-width="300">
      <v-card>
        <v-card-text class="p-2" dark>
          {{ currentText }}
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-overlay :value="overlayshow" z-index="9999">
      <v-progress-circular indeterminate size="64">
        <v-icon>mdi-email</v-icon>
      </v-progress-circular>
    </v-overlay>

    <!-- viewDocumentDialog -->
    <v-dialog v-model="viewDocument" max-width="900">
      <v-card>
        <vue-pdf-app :file="pdfFile" />
      </v-card>
    </v-dialog>

    <!-- user-details -->
    <user-details
      v-if="CurrentUserData"
      :userData="CurrentUserData"
      :key="userDetailsDialogKey"
    ></user-details>

    <v-overlay :value="overlayFileView">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>

    <!-- viewImageDialog -->
    <v-dialog v-model="viewImage">
      <v-card>
        <v-card-title>
          <a
            :href="'/' + imageFile"
            class="btn btn-info btn-sm text-white m-1"
            download
          >
            <v-icon color="white" small>mdi-paperclip</v-icon> Download
          </a>
        </v-card-title>
        <v-img :src="'/' + imageFile" alt="image" contain></v-img>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
import Form from "vform";
import VuePdfApp from "../common/pdfViewApp.vue";

// User Details Show By Dialog
import userDetails from "./../../../../super_admin/pages/users/details/user_details.vue";
import userDetailsData from "./../../../../super_admin/pages/users/details/js/data";
import userDetailsMethods from "./../../../../super_admin/pages/users/details/js/methods";

export default {
  components: {
    "vue-pdf-app": VuePdfApp,
    "user-details": userDetails,
  },

  data() {
    return {
      applicationDetails: {},
      checkID: "",

      // dialog
      driverModal: false,
      bookbyModal: false,

      // driverData
      driverData: "",
      bookbyData: "",

      // datepicker

      menu: "",
      menu2: "",

      //current page url
      currentUrl: "/iaccess/admin/iwaccess",

      remarksDialog: false,
      allRemarks: [],
      docPath: "/images/iaccess/",

      // longtextDialog
      longtextDialog: false,
      currentText: "",

      remRules: [
        (v) =>
          (v || "").length <= 20000 ||
          "Feedback must be 20,000 characters or less",
        (v) => (v || "").length >= 10 || "10 chars minimum or more",
      ],

      form: new Form({
        id: "",
        verify_status: "",
        verify_remarks: "",
      }),

      remarkDialog: false,

      // Current User Show By Dilog
      ...userDetailsData,
    };
  },

  methods: {
    // CurrentUserData
    ...userDetailsMethods,

    // longtextDialog
    longText(value) {
      this.currentText = value;
      this.longtextDialog = true;
    },
    showRemarksDialog(val, st) {
      this.form.id = val;
      this.form.verify_status = st;
      this.remarkDialog = true;
    },
    //End longtextDialog

    // complainCancel
    remarkStore() {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to close this request!",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes!",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          //console.log(id);
          this.overlayshow = true;
          this.dataModalDialog = true;
          this.form
            .post(this.currentUrl + "/remarks_action")
            .then((response) => {
              //console.log(response);
              Swal.fire({
                title: "Changed!",
                text: "Status has been Changed.",
                type: "success",
                timer: 3000,
              });
              // Refresh Tbl Data with current page
              this.getResults(this.currentPageNumber);
              this.remarkDialog = false;
              this.dataModalDialog = false;
              this.overlayshow = false;
            })
            .catch((data) => {
              this.dataModalDialog = false;
              this.overlayshow = false;
              Swal.fire({
                icon: "error",
                title: "Somthing Going Wrong<br>" + data.message,
                customClass: "text-danger",
                timer: 3000,
              });
              // Swal.fire("Failed!", data.message, "warning");
            });
        }
      });
    },

    //emailResend
    emailResend(val, type) {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to resend email!",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes!",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          //console.log(id);
          this.overlayshow = true;
          axios
            .post(this.currentUrl + "/email_resend?id=" + val + "&type=" + type)
            .then((response) => {
              console.log(response);
              Swal.fire({
                title: "Successfully!",
                text: "Email has been sent.",
                type: "success",
                timer: 3000,
              });
              // Refresh Tbl Data with current page
              this.getResults(this.currentPageNumber);

              this.overlayshow = false;
            })
            .catch((data) => {
              this.overlayshow = false;
              Swal.fire({
                icon: "error",
                title: "Somthing Going Wrong<br>" + data.message,
                customClass: "text-danger",
                timer: 3000,
              });
              // Swal.fire("Failed!", data.message, "warning");
            });
        }
      });
    },

    getDetails(id) {
      this.overlayFileView = true;
      axios
        .get(this.currentUrl + "/get_app_details/" + id)
        .then((response) => {
          this.base64ToArrayBuffer(response.data);
          this.overlayFileView = false;
        })
        .catch((error) => {
          this.overlayFileView = false;
          Swal.fire({
            icon: "error",
            title: "Somthing Going Wrong<br>",
            customClass: "text-danger",
          });
        });
    },
  },

  created() {
    this.$Progress.start();
    // Fetch initial results
    this.getResults();
    this.$Progress.finish();
  },
};
</script>

<style scoped>
.image-thum-size {
  height: 50px;
  width: 100px;
}

.bg_card {
  background: linear-gradient(
    120deg,
    rgb(249, 168, 37) 60%,
    rgba(0, 0, 0, 1) 40%
  );
}
</style>
