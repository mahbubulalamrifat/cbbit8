<template>
  <div>
    <v-dialog v-model="managerSelectDilog" max-width="1000" scrollable>
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="5"> Manager Select </v-col>
            <v-col cols="5">
              <div class="m-auto">
                <v-btn @click="request()" color="success" elevation="20">
                  <v-icon left>mdi-bookmark-plus</v-icon>Select Manager
                </v-btn>
              </div>
            </v-col>
            <v-col cols="2">
              <v-btn
                @click="managerSelectDilog = false"
                color="red lighten-1"
                small
                text
                class="float-right"
              >
                <v-icon left dark>mdi-close-octagon</v-icon> Close
              </v-btn>
            </v-col>
          </v-row>
        </v-card-title>
        <v-card-text>
          <div class="card-body table-responsive">
            <div v-if="allData.data">
              <v-row>
                <v-col cols="2">
                  <!-- Show -->
                  <v-select
                    v-model="paginate"
                    label="Show:"
                    :items="tblItemNumberShow"
                    small
                  >
                  </v-select>
                </v-col>

                <v-col cols="2">
                  <!-- zone_office -->
                  <v-select
                    v-model="zone_office"
                    label="Zones:"
                    :items="allZoneOffices"
                    item-text="name"
                    item-value="offices"
                    small
                  >
                  </v-select>
                </v-col>

                <v-col cols="3">
                  <!-- Departments -->
                  <v-select
                    v-model="department"
                    label="Departments:"
                    :items="allDepartments"
                    item-text="department"
                    item-value="department"
                    small
                  >
                  </v-select>
                </v-col>

                <v-col cols="2">
                  <!-- search_field -->
                  <v-select
                    v-model="search_field"
                    label="Search By:"
                    :items="searchByFields"
                    item-text="name"
                    item-value="value"
                    small
                  >
                  </v-select>
                </v-col>

                <v-col cols="3">
                  <v-text-field
                    prepend-icon="mdi-clipboard-text-search"
                    v-model="search"
                    label="Search:"
                    placeholder="Search Input..."
                  ></v-text-field>
                </v-col>
              </v-row>

              <!-- selectedManager : {{ selectedManager }} -->

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>
                      <a href="#" @click.prevent="change_sort('login')"
                        >login</a
                      >
                      <span
                        v-if="sort_direction == 'desc' && sort_field == 'login'"
                        >&uarr;</span
                      >
                      <span
                        v-if="sort_direction == 'asc' && sort_field == 'login'"
                        >&darr;</span
                      >
                    </th>
                    <th>Image</th>
                    <th>
                      <a href="#" @click.prevent="change_sort('name')">Name</a>
                      <span
                        v-if="sort_direction == 'desc' && sort_field == 'name'"
                        >&uarr;</span
                      >
                      <span
                        v-if="sort_direction == 'asc' && sort_field == 'name'"
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
                        v-if="
                          sort_direction == 'asc' && sort_field == 'department'
                        "
                        >&darr;</span
                      >
                    </th>
                    <th>
                      <a href="#" @click.prevent="change_sort('office')"
                        >Office</a
                      >
                      <span
                        v-if="
                          sort_direction == 'desc' && sort_field == 'office'
                        "
                        >&uarr;</span
                      >
                      <span
                        v-if="sort_direction == 'asc' && sort_field == 'office'"
                        >&darr;</span
                      >
                    </th>
                    <th>
                      <a href="#" @click.prevent="change_sort('business_unit')"
                        >Business Unit</a
                      >
                      <span
                        v-if="
                          sort_direction == 'desc' &&
                          sort_field == 'business_unit'
                        "
                        >&uarr;</span
                      >
                      <span
                        v-if="
                          sort_direction == 'asc' &&
                          sort_field == 'business_unit'
                        "
                        >&darr;</span
                      >
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="singleData in allData.data" :key="singleData.id">
                    <td>
                      <v-checkbox
                        v-model="selectedManager"
                        :value="singleData.id"
                        :label="`${singleData.login}`"
                      >
                      </v-checkbox>
                    </td>
                    <td>
                      <img
                        v-if="singleData.image"
                        :src="imagePathSm + singleData.image"
                        alt="image"
                        class="rounded-circle"
                        height="50"
                        width="50"
                      />
                    </td>
                    <td>{{ singleData.name }}</td>
                    <td>{{ singleData.department }}</td>
                    <td>{{ singleData.office }}</td>
                    <td>{{ singleData.business_unit }}</td>
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
                    >mdi mdi-loading mdi-spin</v-icon
                  >
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
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
import userMethods from "./../users/js/methods";
import userTblData from "./../users/js/data";

export default {
  // For parent response
  props: ["childrenRequest"],

  data() {
    return {
      //current page url
      currentUrl: "/super_admin/user",

      managerSelectDilog: true,

      selectedManager: [],

      // userTblData
      ...userTblData,

      fullUserList: "",
    };
  },

  methods: {
    //userMethods
    ...userMethods,

    // request
    request() {
      console.log(
        "request-- selectedManager",
        this.selectedManager,
        this.user_full_list
      );

      if (this.selectedManager.length <= 0) {
        Swal.fire({
          icon: "error",
          title: "Sorry!!, Manager not selected",
        });
      } else {
        // setManager
        this.setManager();

        // Make Object
        let result = {
          manager_id: this.selectedManager,
          manager_name: this.selectedManagerName,
        };

        // Data send to parent
        this.childrenRequest(result);

        //console.log('result', result)

        // Hide Dilog
        this.managerSelectDilog = false;
      }
    },

    //Set Manager
    setManager() {
      // make empty
      this.selectedManagerName = [];

      var allDataArr = this.fullUserList;
      var managerId = this.selectedManager;
      //console.log(managerId, myarr, singleData.manager_id);

      // Manager ID check in all Data
      for (var key in allDataArr) {
        var value = allDataArr[key];
        // Check manager ID in Current Data
        for (var key2 in managerId) {
          var value2 = managerId[key2];
          // Single value check
          if (value2 == value.id) {
            //console.log('value found', value.id, value.name)
            // Name push in array
            this.selectedManagerName.push(value.name);
            // ID Push in form obj
            //this.form.manager_id.push(value.id)
          }
          // console.log('for2 -- ', key2, value2);
        }
      }

      console.log("selectedManagerName", this.selectedManagerName, allDataArr);
    },

    // getFullList
    getFullList() {
      axios
        .get(this.currentUrl + "/full_list")
        .then((response) => {
          this.fullUserList = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  mounted() {
    this.getFullList();
    // All ZoneOffices
    this.getZoneOffices();
    //getDepartments
    this.getDepartments();
  },

  created() {
    this.$Progress.start();
    // Fetch initial results
    this.getResults();
    // Assign
    //this.selectedManager = this.selected_id.split(',').map(Number);
    //this.fullUserList    = this.user_full_list

    //console.log('Selected Id', this.selected_id, this.selectedManager)

    this.$Progress.finish();
  },
};
</script>


<style scoped>
.hide {
  /* visibility: hidden !important; */
  display: none !important;
}

.image-thum-size {
  height: 50px;
  width: 100px;
}
</style>
