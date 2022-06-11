<template>
  <div>
    <div class="d-flex justify-content-between">
      <h3>All Employee Records</h3>

      <v-btn
        outlined
        elevation="5"
        class="float-right"
        small
        @click="exportExcel()"
        :loading="exportLoading"
      >
        <v-icon left color="success">mdi-file-excel</v-icon>
        Export
      </v-btn>
    </div>

    <div v-if="allData.data">
      <v-row>
        <v-col cols="4" lg="2">
          <!-- Show -->
          <v-select
            v-model="paginate"
            label="Show:"
            :items="tblItemNumberShow"
            outlined
            dense
          >
          </v-select>
        </v-col>

        <v-col cols="4" lg="2">
          <v-autocomplete
            :items="userData"
            label="All Users"
            item-text="name"
            item-value="name"
            v-model="sort_by_user"
            outlined
            dense
          ></v-autocomplete>
        </v-col>

        <v-col cols="4" lg="2">
          <v-select
            :items="reportType"
            label="Select Type"
            v-model="sort_by_day"
            outlined
            dense
          ></v-select>
        </v-col>

        <v-col cols="12" lg="2">
          <v-menu v-model="menu" min-width="auto">
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="sort_by_startDate"
                label="Start Date"
                prepend-inner-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
                outlined
                dense
              ></v-text-field>
            </template>

            <v-date-picker v-model="sort_by_startDate" no-title scrollable>
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="menu = false"> Cancel </v-btn>
            </v-date-picker>
          </v-menu>
        </v-col>

        <v-col cols="12" lg="2">
          <v-menu v-model="menu2" min-width="auto">
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="sort_by_endDate"
                label="End Date"
                prepend-inner-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
                outlined
                dense
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

        <v-col cols="12" lg="2">
          <v-text-field
            prepend-inner-icon="mdi-clipboard-text-search"
            v-model="search"
            label="Search:"
            placeholder="Search Input..."
            outlined
            dense
          ></v-text-field>
        </v-col>
      </v-row>

      <table class="table table-bordered">
        <thead class="text-center">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Temparature</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="singleData in allData.data" :key="singleData.id">
            <td>
              {{ singleData.emp_id }}
            </td>

            <td>
              {{ singleData.name }}
            </td>

            <td>
              {{ singleData.department }}
            </td>

            <td>
              <span v-if="singleData.temp_final > 100">
                <v-btn class="error">{{ singleData.temp_final }}</v-btn>
              </span>

              <span v-else>
                <v-btn class="success">{{ singleData.temp_final }}</v-btn>
              </span>
            </td>

            <td>
              {{ singleData.created_at | moment("MMM Do YYYY") }}
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
          <v-icon color="success" size="100">mdi mdi-loading mdi-spin</v-icon>
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

      <div class="text-uppercase" style="letter-spacing: 4px; color: #990f02">
        No Data
      </div>
    </h4>
  </div>
</template>


<script>
export default {
  data() {
    return {
      //current page url
      currentUrl: "/itemp/admin/report/employee-records",

      // all car data
      userData: [],

      // sort by car value
      sort_by_user: "",

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

      // datepicker
      menu: "",
      menu2: "",

      // exportLoading
      exportLoading: false,
    };
  },

  methods: {
    // Get table data
    getResults(page = 1) {
      this.dataLoading = true;
      axios
        .get(
          this.currentUrl +
            "/index?page=" +
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
            "&sort_by_user=" +
            this.sort_by_user +
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

    // get all user data
    getUserData() {
      axios
        .get(this.currentUrl + "/emp_data")
        .then((response) => {
          this.userData = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    exportExcel() {
      this.exportLoading = true;

      axios({
        method: "get",
        url:
          this.currentUrl +
          "/export_data?search=" +
          this.search +
          "&sort_direction=" +
          this.sort_direction +
          "&sort_field=" +
          this.sort_field +
          "&search_field=" +
          this.search_field +
          "&sort_by_user=" +
          this.sort_by_user +
          "&sort_by_day=" +
          this.sort_by_day +
          "&sort_by_startDate=" +
          this.sort_by_startDate +
          "&sort_by_endDate=" +
          this.sort_by_endDate,

        responseType: "blob", // important
      })
        .then((response) => {
          let repName = new Date();

          const url = URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", `${repName}.xlsx`);
          document.body.appendChild(link);
          link.click();

          this.exportLoading = false;
        })
        .catch((error) => {
          //stop Loading
          this.exportLoading = false;
          console.log(error);
          Swal.fire({
            icon: "error",
            title: "Error !!",
            text: "Somthing going wrong !!",
          });
        });
    },
  },

  watch: {
    //Excuted When make change value
    sort_by_user: function (value) {
      this.$Progress.start();
      this.getResults();
      this.$Progress.finish();
    },

    sort_by_day: function (value) {
      this.$Progress.start();
      this.getResults();
      this.$Progress.finish();
    },

    sort_by_startDate: function (value) {
      this.$Progress.start();
      this.getResults();
      this.$Progress.finish();
    },

    sort_by_endDate: function (value) {
      this.$Progress.start();
      this.getResults();
      this.$Progress.finish();
    },
  },

  mounted() {
    this.getUserData();
  },

  created() {
    this.$Progress.start();
    // Fetch initial results
    this.getResults();
    this.$Progress.finish();
  },
};
</script>
