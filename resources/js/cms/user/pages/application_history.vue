<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <v-row>
          <v-col cols="10"> My Application Complain List </v-col>
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
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>
                  <a href="#" @click.prevent="change_sort('id')">Num.</a>
                  <span v-if="sort_direction == 'desc' && sort_field == 'id'"
                    >&uarr;</span
                  >
                  <span v-if="sort_direction == 'asc' && sort_field == 'id'"
                    >&darr;</span
                  >
                </th>
                <th>
                  <a href="#" @click.prevent="change_sort('process')"
                    >Process</a
                  >
                  <span
                    v-if="sort_direction == 'desc' && sort_field == 'process'"
                    >&uarr;</span
                  >
                  <span
                    v-if="sort_direction == 'asc' && sort_field == 'process'"
                    >&darr;</span
                  >
                </th>
                <th>Type</th>
                <th>Details</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in allData.data" :key="item.id">
                <td>
                  <div class="pa-1 info rounded-pill h4 text-white text-center">
                    {{ item.id }} (A)
                  </div>
                  <div
                    v-if="
                      item.document ||
                      item.document2 ||
                      item.document3 ||
                      item.document4
                    "
                  >
                    <span v-if="item.document">
                      <a
                        v-if="item.document"
                        :href="docPath + item.document"
                        class="btn btn-info btn-sm text-white"
                        download
                      >
                        <v-icon color="white" dense>mdi-paperclip</v-icon> 1
                      </a>
                    </span>
                    <span v-if="item.document2">
                      <a
                        v-if="item.document2"
                        :href="docPath + item.document2"
                        class="btn btn-info btn-sm text-white"
                        download
                      >
                        <v-icon color="white" dense>mdi-paperclip</v-icon> 2
                      </a>
                    </span>
                    <span v-if="item.document3">
                      <a
                        v-if="item.document3"
                        :href="docPath + item.document3"
                        class="btn btn-info btn-sm text-white"
                        download
                      >
                        <v-icon color="white" dense>mdi-paperclip</v-icon> 3
                      </a>
                    </span>
                    <span v-if="item.document4">
                      <a
                        v-if="item.document4"
                        :href="docPath + item.document4"
                        class="btn btn-info btn-sm text-white"
                        download
                      >
                        <v-icon color="white" dense>mdi-paperclip</v-icon> 4
                      </a>
                    </span>
                  </div>
                  <div v-else class="text-danger text-center">
                    No Document's Send
                  </div>
                </td>

                <td>
                  {{ item.process }}
                </td>

                <td>
                  <b>Category:</b>
                  <span v-if="item.category">{{ item.category.name }}</span
                  ><br />
                  <b>Subcategory:</b>
                  <span v-if="item.subcategory">{{
                    item.subcategory.name
                  }}</span>
                </td>

                <td>
                  <b>Complain At:</b>
                  <span v-if="item.created_at">{{
                    item.created_at | moment("MMMM Do YYYY, h:mm a")
                  }}</span>
                  <br />
                  <b>Last Update:</b>
                  <span v-if="item.updated_at">{{
                    item.updated_at | moment("MMMM Do YYYY, h:mm a")
                  }}</span>

                  <div v-if="item.details">
                    <b>Details:</b>
                    <div
                      v-if="item.details.length < 100"
                      v-html="item.details"
                    ></div>
                    <div v-else>
                      <span
                        v-html="item.details.substring(0, 100) + ' .....'"
                      ></span>
                      <v-btn
                        small
                        text
                        plain
                        color="primary"
                        @click="longTextHTML(item)"
                        ><u>See More </u>
                      </v-btn>
                    </div>
                  </div>
                </td>

                <td>
                  <span v-if="item.process == 'Not Process'">
                    <v-btn
                      v-if="item.process == 'Not Process' && item.status == 1"
                      @click="complainCancel(item.id)"
                      color="error"
                      depressed
                      elevation="20"
                    >
                      <v-icon left>mdi-close-octagon-outline</v-icon> Cancel
                    </v-btn>
                    <span v-else class="error--text">Canceled</span>
                  </span>
                  <v-btn
                    v-else
                    @click="remarksDetailsShow(item)"
                    color="success"
                    depressed
                    small
                    elevation="20"
                  >
                    <v-icon left>mdi-eye-arrow-left </v-icon> View
                  </v-btn>

                  <v-btn
                    v-if="item.process == 'Closed' && item.rating == null"
                    @click="feedback(item)"
                    color="teal white--text"
                    depressed
                    small
                    elevation="20"
                  >
                    <v-icon left>mdi-star-half-full </v-icon> Rating
                  </v-btn>

                  <v-rating
                    v-if="item.rating"
                    :value="item.rating"
                    color="yellow darken-3"
                    background-color="grey darken-1"
                    empty-icon="$ratingFull"
                    readonly
                  ></v-rating>
                  <div v-if="item.feedback">
                    <div v-if="item.feedback.length < 100">
                      {{ item.feedback }}
                    </div>
                    <div v-else>
                      {{ item.feedback.substring(0, 100) + "..." }}
                      <v-btn
                        small
                        text
                        plain
                        color="primary"
                        @click="longText(item.feedback)"
                        ><u> See More </u>
                      </v-btn>
                    </div>
                  </div>
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
            Sorry !! You have no complain in
            <b class="text-success">Application</b> section.
          </div>
        </h4>
      </v-card-text>
    </v-card>

    <!-- remarks infomation modal -->
    <v-dialog v-if="allRemarks" v-model="remarksDialog">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10"> Remarks Details </v-col>
            <v-col cols="2">
              <v-btn
                @click="remarksDialog = false"
                color="red lighten-1 white--text"
                small
                class="float-right"
              >
                <v-icon left dark>mdi-close-octagon</v-icon> Close
              </v-btn>
            </v-col>
          </v-row>
        </v-card-title>
        <v-card-text>
          <table class="table table-bordered mt-5">
            <thead class="text-center">
              <tr>
                <th>Process</th>
                <th>Details</th>
                <th>Document</th>
                <th>Action By</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in allRemarks.remarks" :key="index">
                <td class="text-center">
                  {{ item.process }}
                </td>

                <td v-html="item.details"></td>

                <td class="text-center">
                  <span v-if="item.document">
                    <a
                      v-if="item.document"
                      :href="docPath + item.document"
                      class="btn btn-info btn-sm text-white"
                      download
                    >
                      <v-icon color="white" small>mdi-paperclip</v-icon>
                      Document
                    </a>
                  </span>
                  <span v-else class="text-danger">No Document's Send</span>
                </td>

                <td class="text-center">
                  <span v-if="item.created_at">{{
                    item.created_at | moment("MMMM Do YYYY, h:mm a")
                  }}</span
                  ><br />
                  <span v-if="item.makby" class="text-muted small"
                    >--{{ item.makby.name }}</span
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- app rating -->
    <app-rating
      @childToParent="childToParentCall"
      v-if="appratingDialogShow"
      :key="appratingKey"
      :currentDataId="currentDataId"
    ></app-rating>

    <!-- longtextDialog -->
    <v-dialog v-model="longtextDialog" max-width="300">
      <v-card>
        <v-card-text>
          {{ currentText }}
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- longtextDialog -->
    <!-- <v-dialog v-model="longtextDialogHTML" max-width="500">
            <v-card class="p-2">
                <v-card-text v-html="currentTextHTML" class="p-0 m-0"></v-card-text>
            </v-card>
        </v-dialog> -->
    <v-dialog v-model="longtextDialogHTML">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10"> Details </v-col>
            <v-col cols="2">
              <v-btn
                @click="longtextDialogHTML = false"
                color="red lighten-1 white--text"
                small
                class="float-right"
              >
                <v-icon left dark>mdi-close-octagon</v-icon> Close
              </v-btn>
            </v-col>
          </v-row>
        </v-card-title>
        <v-card-text>
          <div class="table-responsive">
            <table class="table table-bordered">
              <tr class="text-center">
                <td><b>Process: </b> {{ currentTextHTML.process }}</td>
                <td>
                  <b>Complain At: </b>
                  <span v-if="currentTextHTML.created_at">{{
                    currentTextHTML.created_at | moment("MMMM Do YYYY, h:mm a")
                  }}</span>
                </td>
                <td>
                  <b>Last Update: </b>
                  <span v-if="currentTextHTML.updated_at">{{
                    currentTextHTML.updated_at | moment("MMMM Do YYYY, h:mm a")
                  }}</span>
                </td>
              </tr>

              <tr></tr>

              <tr>
                <td colspan="3" v-html="currentTextHTML.details"></td>
              </tr>
            </table>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
import appRating from "../pages/appRating.vue";
export default {
  components: {
    "app-rating": appRating,
  },

  data() {
    return {
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
      currentUrl: "/cms/app",

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
      docPath: "/images/application/",

      // rating component
      appratingDialogShow: false,
      appratingKey: 0,

      // currentDataId
      currentDataId: "",

      // longtextDialog
      longtextDialog: false,
      currentText: "",
      longtextDialogHTML: false,
      currentTextHTML: "",
    };
  },

  methods: {
    childToParentCall() {
      this.getResults();
    },

    // longtextDialog
    longText(value) {
      this.currentText = value;
      this.longtextDialog = true;
    },

    // longtextDialogHTML
    longTextHTML(value) {
      this.currentTextHTML = value;
      this.longtextDialogHTML = true;
    },

    // feedback
    feedback(data) {
      this.currentDataId = data.id;
      this.appratingDialogShow = true;
      this.appratingKey++;
    },

    // Get table data
    getResults(page = 1) {
      this.dataLoading = true;
      axios
        .get(
          this.currentUrl +
            "/history?page=" +
            page +
            "&paginate=" +
            this.paginate +
            "&search=" +
            this.search +
            "&sort_direction=" +
            this.sort_direction +
            "&sort_field=" +
            this.sort_field +
            "&search_field=" +
            this.search_field +
            "&sort_by_day=" +
            this.sort_by_day +
            "&sort_by_startDate=" +
            this.sort_by_startDate +
            "&sort_by_endDate=" +
            this.sort_by_endDate
        )
        .then((response) => {
          // console.log(response.data.data);
          //console.log(response.data.from, response.data.to);
          this.allData = response.data;
          this.totalValue = response.data.total;
          this.dataShowFrom = response.data.from;
          this.dataShowTo = response.data.to;

          // Loading Animation
          this.dataLoading = false;
        });
    },

    // remarksDetailsShow
    remarksDetailsShow(val) {
      this.allRemarks = [];
      this.allRemarks = val;
      this.remarksDialog = true;
    },

    // complainCancel
    complainCancel(val) {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to cancel this complain !",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes!",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          //console.log(id);
          this.$Progress.start();
          axios
            .post(this.currentUrl + "/complain_cancel", {
              id: val,
            })
            .then((response) => {
              //console.log(response);
              Swal.fire("Changed!", "Status has been Changed.", "success");
              // Refresh Tbl Data with current page
              this.getResults(this.currentPageNumber);
              this.$Progress.finish();
            })
            .catch((data) => {
              Swal.fire({
                icon: "error",
                title: "Somthing Going Wrong<br>" + data.message,
                customClass: "text-danger",
              });
              // Swal.fire("Failed!", data.message, "warning");
            });
        }
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
      this.$Progress.start();
      this.getResults();
      this.$Progress.finish();
    },

    sort_by_endDate: function () {
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
