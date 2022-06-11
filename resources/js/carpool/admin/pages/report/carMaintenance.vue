<template>
  <div>
    <v-card>
      <v-card-title>
        <v-row>
          <v-col cols="8"> Car Maintenance Records </v-col>
          <v-col cols="4">
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
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <div v-if="allData.data">
          <v-row>
            <v-col cols="3">
              <!-- Show -->
              <v-select
                v-model="paginate"
                label="Show:"
                :items="tblItemNumberShow"
                small
              >
              </v-select>
            </v-col>

            <v-col cols="9">
              <v-text-field
                prepend-icon="mdi-clipboard-text-search"
                v-model="search"
                label="Search:"
                placeholder="Search Input..."
              ></v-text-field>
            </v-col>
          </v-row>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="text-center">
                <tr>
                  <th>
                    <a href="#" @click.prevent="change_sort('name')">Driver</a>
                    <span
                      v-if="sort_direction == 'desc' && sort_field == 'name'"
                      >&uarr;</span
                    >
                    <span v-if="sort_direction == 'asc' && sort_field == 'name'"
                      >&darr;</span
                    >
                  </th>
                  <th>
                    <a href="#" @click.prevent="change_sort('name')">Car</a>
                    <span
                      v-if="sort_direction == 'desc' && sort_field == 'name'"
                      >&uarr;</span
                    >
                    <span v-if="sort_direction == 'asc' && sort_field == 'name'"
                      >&darr;</span
                    >
                  </th>
                  <th>
                    <a href="#" @click.prevent="change_sort('start')"
                      >Maintenance Start</a
                    >
                    <span
                      v-if="sort_direction == 'desc' && sort_field == 'start'"
                      >&uarr;</span
                    >
                    <span
                      v-if="sort_direction == 'asc' && sort_field == 'start'"
                      >&darr;</span
                    >
                  </th>
                  <th>
                    <a href="#" @click.prevent="change_sort('end')"
                      >Maintenance End</a
                    >
                    <span v-if="sort_direction == 'desc' && sort_field == 'end'"
                      >&uarr;</span
                    >
                    <span v-if="sort_direction == 'asc' && sort_field == 'end'"
                      >&darr;</span
                    >
                  </th>

                  <th>
                    <a href="#" @click.prevent="change_sort('status')"
                      >Status</a
                    >
                    <span
                      v-if="sort_direction == 'desc' && sort_field == 'status'"
                      >&uarr;</span
                    >
                    <span
                      v-if="sort_direction == 'asc' && sort_field == 'status'"
                      >&darr;</span
                    >
                  </th>
                  <th>
                    <a href="#" @click.prevent="change_sort('register')"
                      >Register</a
                    >
                    <span
                      v-if="
                        sort_direction == 'desc' && sort_field == 'register'
                      "
                      >&uarr;</span
                    >
                    <span
                      v-if="sort_direction == 'asc' && sort_field == 'register'"
                      >&darr;</span
                    >
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="singleData in allData.data" :key="singleData.id">
                  <td>
                    <span v-if="singleData.driver">
                      <v-btn
                        color="indigo white--text"
                        small
                        depressed
                        @click="getDriverModalData(singleData.driver.id)"
                      >
                        {{ singleData.driver.name }}
                      </v-btn>
                    </span>
                    <span v-else class="error--text">Not Found !</span>
                  </td>
                  <td>
                    <span v-if="singleData.car"
                      >{{ singleData.car.name }} ||
                      {{ singleData.car.number }}</span
                    >
                  </td>
                  <td>
                    {{ singleData.start | moment("MMMM Do YYYY, h:mm a") }}
                  </td>
                  <td>{{ singleData.end | moment("MMMM Do YYYY, h:mm a") }}</td>
                  <td>
                    <span v-if="singleData.status == 1">Accepted</span
                    ><span v-else>Canceled</span>
                  </td>

                  <td>
                    <span v-if="singleData">{{ singleData.created_at }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
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

    <!-- driver infomation modal -->
    <v-dialog v-model="driverModal" max-width="600px">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10"> Driver Details </v-col>
            <v-col cols="2">
              <v-btn
                @click="driverModal = false"
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
          <v-list-item three-line>
            <v-list-item-content class="text-overline">
              <div>
                Name: <span v-if="driverData">{{ driverData.name }}</span>
              </div>
              <div>
                Contact: <span v-if="driverData">{{ driverData.contact }}</span>
              </div>

              <div>
                License:
                <span v-if="driverData.driver">{{ driverData.driver }}</span>
                <span v-else class="error--text">Not Available !</span>
              </div>

              <div>
                NID: <span v-if="driverData.nid">{{ driverData.nid }}</span>
                <span v-else class="error--text">Not Available !</span>
              </div>
            </v-list-item-content>

            <v-list-item-avatar tile size="100">
              <v-img
                v-if="driverData.image"
                :src="imagePathSm + driverData.image"
                alt="image"
                max-height="120px"
                contain
              ></v-img>
            </v-list-item-avatar>
          </v-list-item>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
export default {
  data() {
    return {
      // dialog
      driverModal: false,

      //current page url
      currentUrl: "/carpool/admin/report",

      // allData
      allData: "",

      // driverData
      driverData: "",

      imageMaxSize: "5111775",
      imagePath: "/images/carpool/",
      imagePathSm: "/images/carpool/driver/small/",

      // exportLoading
      exportLoading: false,
    };
  },

  methods: {
    getResults(page = 1) {
      this.dataLoading = true;
      axios
        .get(
          this.currentUrl +
            "/car-maintenance?page=" +
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
            this.search_field
        )
        .then((response) => {
          //console.log(response.data.data);
          //console.log(response.data.from, response.data.to);
          this.allData = response.data;
          this.totalValue = response.data.total;
          this.dataShowFrom = response.data.from;
          this.dataShowTo = response.data.to;
          this.currentPageNumber = response.data.current_page;

          //console.log('currentPageNumber: ', this.currentPageNumber)

          // Loading Animation
          this.dataLoading = false;
        });
    },

    // exportExcel
    exportExcel() {
      this.exportLoading = true;

      axios({
        method: "get",
        url:
          this.currentUrl +
          "/export_data_maint?search=" +
          this.search +
          "&sort_direction=" +
          this.sort_direction +
          "&sort_field=" +
          this.sort_field +
          "&search_field=" +
          this.search_field,

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

  mounted() {},

  created() {
    this.$Progress.start();
    // Fetch initial results
    this.getResults();
    this.$Progress.finish();
  },
};
</script>
