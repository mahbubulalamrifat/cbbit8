<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <v-row>
          <v-col cols="10">
            My Internet / Web Access Request History List
          </v-col>
          <v-col cols="2"> </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <v-row>
          <v-col cols="6" lg="2">
            <!-- Show -->
            <v-select
              v-model="paginate"
              label="Show:"
              :items="tblItemNumberShow"
              small
            >
            </v-select>
          </v-col>

          <v-col cols="6" lg="2">
            <v-select
              :items="reportType"
              label="Select Type"
              v-model="sort_by_day"
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

        <div v-if="allData.data" class="table-responsive">
          <table class="table table-bordered">
            <thead class="text-center">
              <tr>
                <th>
                  <a href="#" @click.prevent="change_sort('number')">Number</a>
                  <span
                    v-if="sort_direction == 'desc' && sort_field == 'number'"
                    >&uarr;</span
                  >
                  <span v-if="sort_direction == 'asc' && sort_field == 'number'"
                    >&darr;</span
                  >
                </th>
                <th>
                  <a href="#" @click.prevent="change_sort('name')">Name</a>
                  <span v-if="sort_direction == 'desc' && sort_field == 'name'"
                    >&uarr;</span
                  >
                  <span v-if="sort_direction == 'asc' && sort_field == 'name'"
                    >&darr;</span
                  >
                </th>
                <th>
                  <a href="#" @click.prevent="change_sort('branch')">Branch</a>
                  <span
                    v-if="sort_direction == 'desc' && sort_field == 'branch'"
                    >&uarr;</span
                  >
                  <span v-if="sort_direction == 'asc' && sort_field == 'branch'"
                    >&darr;</span
                  >
                </th>
                <th>
                  <a href="#" @click.prevent="change_sort('position')"
                    >Position</a
                  >
                  <span
                    v-if="sort_direction == 'desc' && sort_field == 'position'"
                    >&uarr;</span
                  >
                  <span
                    v-if="sort_direction == 'asc' && sort_field == 'position'"
                    >&darr;</span
                  >
                </th>
                <th>
                  <a href="#" @click.prevent="change_sort('department')"
                    >Department</a
                  >
                  <span
                    v-if="
                      sort_direction == 'desc' && sort_field == 'department'
                    "
                    >&uarr;</span
                  >
                  <span
                    v-if="sort_direction == 'asc' && sort_field == 'department'"
                    >&darr;</span
                  >
                </th>
                <th>
                  <a href="#" @click.prevent="change_sort('created_at')"
                    >Apply At</a
                  >
                  <span
                    v-if="
                      sort_direction == 'desc' && sort_field == 'created_at'
                    "
                    >&uarr;</span
                  >
                  <span
                    v-if="sort_direction == 'asc' && sort_field == 'created_at'"
                    >&darr;</span
                  >
                </th>

                <th>Manager</th>
                <th>B.U Head</th>
                <th>Verify</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr v-for="item in allData.data" :key="item.id">
                <td>
                  <span
                    v-if="item.number"
                    class="pa-1 info rounded-pill h6 text-white text-center"
                    >{{ item.number }}</span
                  >
                  <span v-else class="text-danger">N/A</span>
                </td>
                <td>
                  {{ item.name }}<br />
                  <span v-if="item.document || item.document2">
                    <span v-if="item.document.includes('.pdf')">
                      <v-btn
                        v-if="item.document"
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
                        (item.document && item.document.includes('.jpg')) ||
                        (item.document && item.document.includes('.jpeg')) ||
                        (item.document && item.document.includes('.png')) ||
                        (item.document && item.document.includes('.JPG')) ||
                        (item.document && item.document.includes('.JPEG')) ||
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
                        <v-icon color="white" small>mdi-paperclip</v-icon> NID
                      </a>
                    </span>

                    <span v-if="item.document2.includes('.pdf')">
                      <v-btn
                        v-if="item.document2"
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
                        (item.document2 && item.document2.includes('.jpg')) ||
                        (item.document2 && item.document2.includes('.jpeg')) ||
                        (item.document2 && item.document2.includes('.png')) ||
                        (item.document2 && item.document2.includes('.JPG')) ||
                        (item.document2 && item.document2.includes('.JPEG')) ||
                        (item.document2 && item.document2.includes('.PNG'))
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
                        <v-icon color="white" small>mdi-paperclip</v-icon> OID
                      </a>
                    </span>
                  </span>
                  <span v-else class="text-danger">No Document's Send</span>
                </td>
                <td>{{ item.branch }}</td>
                <td>{{ item.position }}</td>
                <td>{{ item.department }}</td>
                <td>
                  <span v-if="item.created_at">{{
                    item.created_at | moment("MMMM Do YYYY, h:mm a")
                  }}</span>
                </td>
                <td>
                  <span v-if="item.manager">{{ item.manager.name }}</span>
                  <br />
                  <span
                    v-if="item.manager_approved"
                    class="success rounded-pill h6 text-white px-2"
                  >
                    <v-icon left small color="white">mdi-check-decagram</v-icon
                    >Approved
                    <small>{{
                      item.manager_approved | moment("MMMM Do YYYY")
                    }}</small>
                  </span>
                  <span v-else class="error rounded-pill h6 text-white px-2"
                    >Not Approved</span
                  >
                </td>

                <td>
                  <span v-if="item.buhead">{{ item.buhead.name }}</span
                  ><br />
                  <span v-if="item.manager_approved">
                    <span
                      v-if="item.bu_approved"
                      class="success rounded-pill h6 text-white px-2"
                    >
                      <v-icon left small color="white"
                        >mdi-check-decagram</v-icon
                      >Approved
                      <small>{{
                        item.bu_approved | moment("MMMM Do YYYY")
                      }}</small>
                    </span>
                    <span v-else class="error rounded-pill h6 text-white px-2"
                      >Not Approved</span
                    >
                  </span>
                  <span v-else>
                    <span class="info rounded-pill h6 text-white px-2"
                      >Waiting for Manager</span
                    >
                  </span>
                </td>

                <td>
                  <span v-if="item.manager_approved && item.bu_approved">
                    <span v-if="item.verify">{{ item.verify.name }}</span
                    ><br />
                    <span v-if="item.verify_date">
                      <span
                        v-if="item.verify_status == 1"
                        class="success rounded-pill h6 text-white px-2"
                      >
                        <v-icon left small color="white"
                          >mdi-check-decagram</v-icon
                        >
                        Accepted
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

                      <!-- <span class="success rounded-pill h6 text-white px-2">Complete
                                                <small>{{ item.verify_date | moment("MMMM Do YYYY") }}</small>
                                            </span> -->
                      <div v-if="item.verify_remarks.length < 80">
                        Remarks: {{ item.verify_remarks }}
                      </div>
                      <div v-else>
                        Remarks:
                        {{ item.verify_remarks.substring(0, 80) + "....." }}
                        <v-btn
                          small
                          text
                          plain
                          color="primary"
                          @click="longText(item.verify_remarks)"
                        >
                          <u> See More </u></v-btn
                        >
                      </div>
                    </span>
                    <span v-else class="info rounded-pill h6 text-white px-2"
                      >Not Yet Done</span
                    >
                  </span>
                  <span v-else>
                    <span class="error rounded-pill h6 text-white px-2"
                      >Waiting for Approve</span
                    >
                  </span>
                </td>

                <td>
                  <v-btn
                    color="teal"
                    @click="getDetails(item.id)"
                    small
                    v-if="item.id != checkID"
                    class="white--text"
                  >
                    <v-icon left>mdi-eye</v-icon>View
                  </v-btn>
                </td>
              </tr>
            </tbody>
          </table>
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

    <!-- longtextDialog -->
    <v-dialog v-model="longtextDialog" max-width="300">
      <v-card>
        <v-card-text>
          {{ currentText }}
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- viewDocumentDialog -->
    <v-dialog v-model="viewDocument" max-width="900">
      <v-card>
        <vue-pdf-app :file="pdfbase64" />
      </v-card>
    </v-dialog>

    <!-- viewApplication -->
    <v-dialog v-model="viewApplication" fullscreen>
      <v-card>
        <v-card-text>
          <v-card-title>
            <v-row>
              <v-col lg="10" cols="8">
                {{ applicationDetails.name }}'s Internet/Web Access Request Form
              </v-col>
              <v-col lg="2" cols="4">
                <v-btn
                  @click="(viewApplication = false), (checkID = '')"
                  color="error"
                  small
                  class="float-right"
                >
                  <v-icon left dark>mdi-close </v-icon> Close
                </v-btn>
              </v-col>
            </v-row>
          </v-card-title>
          <v-row>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Name"
                dense
                readonly
                v-model="applicationDetails.name"
              >
              </v-text-field>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Position"
                dense
                readonly
                v-model="applicationDetails.position"
              >
              </v-text-field>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Branch"
                dense
                readonly
                v-model="applicationDetails.branch"
              >
              </v-text-field>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Department"
                dense
                readonly
                v-model="applicationDetails.department"
              ></v-text-field>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Office Mobile"
                dense
                readonly
                v-model="applicationDetails.office_mobile"
              ></v-text-field>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Personal Mobile"
                dense
                readonly
                v-model="applicationDetails.personal_mobile"
              ></v-text-field>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Personal Email"
                dense
                readonly
                v-model="applicationDetails.personal_email"
              ></v-text-field>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Office Email"
                dense
                readonly
                v-model="applicationDetails.office_email"
              ></v-text-field>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Internet ID"
                dense
                readonly
                v-model="applicationDetails.internet_id"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <div class="h5 py-2 bg-dark text-white text-center" block>
                Request For
              </div>
              <div class="mx-2">
                {{ applicationDetails.request_for }}
              </div>
            </v-col>
            <v-col cols="12">
              <div class="h5 py-2 bg-dark text-white text-center" block>
                Access For
              </div>
              <div class="mx-2">
                {{ applicationDetails.access_for }}
              </div>
            </v-col>
            <v-col cols="12" lg="6">
              <v-textarea
                filled
                label="Modules"
                dense
                readonly
                v-model="applicationDetails.modules"
              >
              </v-textarea>
            </v-col>
            <v-col cols="12" lg="6">
              <v-textarea
                filled
                label="Purpose"
                dense
                readonly
                v-model="applicationDetails.purpose"
              >
              </v-textarea>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- File preview Overlay -->
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
import VuePdfApp from "../common/pdfViewApp.vue";

export default {
  components: {
    "vue-pdf-app": VuePdfApp,
  },

  data() {
    return {
      // viewApplication
      viewApplication: false,
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
      currentUrl: "/iaccess/history/iwaccess",

      // sort by day
      sort_by_day: "",

      // sort by between date
      sort_by_startDate: "",
      sort_by_endDate: "",

      // report type
      reportType: [
        {
          value: "",
          text: "All",
        },
        {
          value: "3",
          text: "Last 3 Days Reports",
        },
        {
          value: "5",
          text: "Last 5 Days Reports",
        },
        {
          value: "7",
          text: "Last 7 Days Reports",
        },
        {
          value: "10",
          text: "Last 10 Days Reports",
        },
        {
          value: "15",
          text: "Last 15 Days Reports",
        },
        {
          value: "30",
          text: "Last 30 Days Reports",
        },
      ],

      remarksDialog: false,
      allRemarks: [],
      docPath: "/images/iaccess/",

      // longtextDialog
      longtextDialog: false,
      currentText: "",
    };
  },

  methods: {
    // longtextDialog
    longText(value) {
      this.currentText = value;
      this.longtextDialog = true;
    },

    // remarksDetailsShow
    remarksDetailsShow(val) {
      this.allRemarks = [];
      this.allRemarks = val;
      this.remarksDialog = true;
    },

    getDetails(id) {
      this.overlayFileView = true;
      axios
        .get(this.currentUrl + "/get_app_details/" + id)
        .then((response) => {
          this.applicationDetails = response.data;
          this.viewApplication = true;
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

  watch: {
    sort_by_day: function () {
      this.sort_by_startDate = "";
      this.sort_by_endDate = "";
      this.$Progress.start();
      this.getResults();
      this.$Progress.finish();
    },

    sort_by_startDate: function () {
      this.sort_by_day = "";
      this.$Progress.start();
      this.getResults();
      this.$Progress.finish();
    },

    sort_by_endDate: function () {
      this.sort_by_day = "";
      this.$Progress.start();
      this.getResults();
      this.$Progress.finish();
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
