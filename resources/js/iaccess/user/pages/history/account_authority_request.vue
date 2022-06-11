<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <v-row>
          <v-col cols="10"> My Account / Authority Request History List </v-col>
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
                  <span v-if="item.document || item.document2 || item.document3">
                    <span v-if="item.document">
                        <span v-if="item.document && item.document.includes('.pdf')">
                        <v-btn
                            v-if="item.document"
                            @click="pdfGetFile(docPath2 + item.document)"
                            small
                            class="ma-1"
                            color="primary"
                            ><v-icon left>mdi-eye</v-icon>NID (PDF)</v-btn
                        >
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
                            v-if="item.document && item.document"
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
                    </span>
                    
                    <span v-if="item.document2">
                        <span v-if="item.document2.includes('.pdf')">
                        <v-btn
                            v-if="item.document2"
                            @click="pdfGetFile(docPath2 + item.document2)"
                            small
                            class="ma-1"
                            color="success"
                            ><v-icon left>mdi-eye</v-icon>OID (PDF)</v-btn
                        >
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

                    <span v-if="item.document3">
                        <span v-if="item.document3 && item.document3.includes('.pdf')">
                        <v-btn
                            v-if="item.document3"
                            @click="pdfGetFile(docPath2 + item.document3)"
                            small
                            class="ma-1"
                            color="success"
                            ><v-icon left>mdi-eye</v-icon>DOC (PDF)</v-btn
                        >
                        </span>
                        <span
                        v-else-if="
                            (item.document3 && item.document3.includes('.jpg')) ||
                            (item.document3 && item.document3.includes('.jpeg')) ||
                            (item.document3 && item.document3.includes('.png')) ||
                            (item.document3 && item.document3.includes('.JPG')) ||
                            (item.document3 && item.document3.includes('.JPEG')) ||
                            (item.document3 && item.document3.includes('.PNG'))
                        "
                        >
                        <v-btn
                            v-if="item.document3"
                            :loading="imageReadyLoading"
                            @click="imageGetFile(docPath2 + item.document3)"
                            small
                            class="ma-1"
                            color="success"
                        >
                            <v-icon left>mdi-eye</v-icon> DOC (image)
                        </v-btn>
                        </span>
                        <span v-else>
                        <a
                            v-if="item.document3"
                            :href="docPath + item.document3"
                            class="btn btn-info btn-sm text-white"
                            download
                        >
                            <v-icon color="white" small>mdi-paperclip</v-icon> DOC
                        </a>
                        </span>
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
                    ><v-icon left small color="white">mdi-check-decagram</v-icon
                    >Approved
                    <small>{{
                      item.manager_approved | moment("MMMM Do YYYY")
                    }}</small></span
                  >
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
                      ><v-icon left small color="white"
                        >mdi-check-decagram</v-icon
                      >Approved
                      <small>{{
                        item.bu_approved | moment("MMMM Do YYYY")
                      }}</small></span
                    >
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
                    class="white--text"
                    ><v-icon left>mdi-eye</v-icon>View</v-btn
                  >
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
        <h1 v-if="!totalValue && !dataLoading" class="text-danger text-center">
          Sorry !! Data Not Available
        </h1>
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
                {{ applicationDetails.name }}'s Account Authority Request Form
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
              ></v-text-field>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Position"
                dense
                readonly
                v-model="applicationDetails.position"
              ></v-text-field>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field
                filled
                label="Branch"
                dense
                readonly
                v-model="applicationDetails.branch"
              ></v-text-field>
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
              ></v-textarea>
            </v-col>
            <v-col cols="12" lg="6">
              <v-textarea
                filled
                label="Purpose"
                dense
                readonly
                v-model="applicationDetails.purpose"
              ></v-textarea>
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
      currentUrl: "/iaccess/history/account_authority",

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
