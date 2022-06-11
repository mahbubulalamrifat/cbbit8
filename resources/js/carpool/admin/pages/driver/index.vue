<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <v-row>
          <v-col cols="10"> Carpool Driver's Table </v-col>
          <v-col cols="2">
            <v-btn
              @click="addDataModel()"
              color="primary"
              elevation="10"
              small
              outlined
              class="float-right"
            >
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
                  <th>Driver Information</th>
                  <th>Car Information</th>
                  <th>Driver Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="singleData in allData.data" :key="singleData.id">
                  <td>
                    <v-hover v-slot="{ hover }">
                      <v-card class="mx-auto" color="grey lighten-4">
                        <v-img
                          v-if="singleData.image"
                          :src="imagePathSm + singleData.image"
                          max-height="180"
                          max-width="230"
                        >
                          <v-expand-transition>
                            <div
                              v-if="hover"
                              class="
                                transition-fast-in-fast-out
                                teal
                                darken-2
                                v-card--reveal
                                white--text
                                d-flex
                                flex-column
                                justify-center
                                align-center
                              "
                              style="height: 100%"
                            >
                              <div>Driver Name: {{ singleData.name }}</div>
                              <div>Driver Number: {{ singleData.contact }}</div>
                              <div>
                                Driver License: {{ singleData.license }}
                              </div>
                              <div>Driver NID:{{ singleData.nid }}</div>
                            </div>
                          </v-expand-transition>
                        </v-img>
                      </v-card>
                    </v-hover>
                  </td>
                  <td>
                    <div v-if="singleData.car">
                      <v-hover v-slot="{ hover }">
                        <v-card class="mx-auto" color="grey lighten-4">
                          <v-img
                            v-if="singleData.car.image"
                            :src="imagePathSmCar + singleData.car.image"
                            max-height="180"
                            max-width="230"
                          >
                            <v-expand-transition>
                              <div
                                v-if="hover"
                                class="
                                  transition-fast-in-fast-out
                                  teal
                                  darken-2
                                  v-card--reveal
                                  white--text
                                  d-flex
                                  flex-column
                                  justify-center
                                  align-center
                                "
                                style="height: 100%"
                              >
                                <div v-if="singleData.car.name">
                                  Car Name: {{ singleData.car.name }}
                                </div>
                                <div v-if="singleData.car.number">
                                  Car Number: {{ singleData.car.number }}
                                </div>
                                <div v-if="singleData.car.capacity">
                                  Car Capacity: {{ singleData.car.capacity }}
                                </div>
                                <div v-if="singleData.car.temporary == 0">
                                  Car Type: Temporary
                                </div>
                                <div v-if="singleData.car.temporary == 1">
                                  Car Type: Regular
                                </div>
                              </div>
                            </v-expand-transition>
                          </v-img>
                        </v-card>
                      </v-hover>
                    </div>
                  </td>

                  <td
                    v-if="singleData.active_leave.length > 0"
                    class="col-3 text-center align-middle"
                  >
                    <v-btn
                      small
                      color="info"
                      @click="driverAllStatus(singleData.active_leave)"
                    >
                      <v-icon left>mdi-ship-wheel</v-icon> View Leave Status
                    </v-btn>
                  </td>

                  <td v-else class="col-3 text-center align-middle">
                    <div class="error--text">Not Available!!</div>
                  </td>

                  <td class="text-center col-3">
                    <v-btn
                      @click="driverLeave(singleData)"
                      color="info"
                      depressed
                      small
                      class="m-1"
                    >
                      <v-icon left>mdi-ship-wheel</v-icon> Leave Action
                    </v-btn>

                    <v-btn
                      v-if="singleData.car.status"
                      @click="statusChange(singleData.car)"
                      color="success"
                      depressed
                      small
                      class="m-1"
                    >
                      <v-icon left>mdi-check-circle-outline</v-icon> Active
                    </v-btn>
                    <v-btn
                      v-else
                      @click="statusChange(singleData.car)"
                      color="warning"
                      depressed
                      small
                      class="m-1"
                    >
                      <v-icon left>mdi-alert-circle-outline </v-icon> Inactive
                    </v-btn>

                    <v-btn
                      @click="editDataModel(singleData)"
                      color="info"
                      depressed
                      small
                      class="m-1"
                    >
                      <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                    </v-btn>

                    <v-btn
                      v-if="isAdministrator()"
                      @click="deleteDataTemp(singleData.id)"
                      color="error"
                      depressed
                      small
                      class="m-1"
                    >
                      <v-icon left>mdi-delete-empty</v-icon> Delete
                    </v-btn>

                    <br />
                    <span v-if="singleData.makby" class="small text-muted"
                      >Create By-- {{ singleData.makby.name }}</span
                    >
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

    <!-- Driver Add/edit Modal -->
    <v-dialog persistent v-model="dataModalDialog" max-width="1100px">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10">
              <span v-if="editmode">Update Driver Information</span>
              <span v-else>Add New Driver Information</span>
            </v-col>
            <v-col cols="2">
              <v-btn
                @click="(dataModalDialog = false), resetForm()"
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
          <v-form ref="form" v-model="valid" lazy-validation>
            <form @submit.prevent="editmode ? updateData() : createData()">
              <v-row>
                <v-col md="6" cols="12">
                  <v-text-field
                    v-model="form.name"
                    label="Enter Driver Name"
                    :rules="driverRules"
                    required
                  ></v-text-field>
                </v-col>

                <v-col md="6" cols="12">
                  <v-text-field
                    v-model="form.contact"
                    label="Enter Driver Number"
                    :rules="driverRules"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col md="6" cols="12">
                  <v-text-field
                    v-model="form.license"
                    label="Enter Driver License"
                  ></v-text-field>
                </v-col>

                <v-col md="6" cols="12">
                  <v-text-field
                    v-model="form.nid"
                    label="Enter Driver NID"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="6">
                  <v-select
                    label="Driver Status"
                    v-model="form.status"
                    :items="statusOptions"
                    :rules="driverRulesOption"
                    required
                  >
                  </v-select>
                </v-col>
                <v-col md="6" cols="12">
                  <v-select
                    v-model="form.car_id"
                    :items="carData"
                    label="All Cars Data"
                  ></v-select>
                  <!-- <v-text-field v-model="form.status" label="Driver Car" ></v-text-field> -->
                </v-col>
              </v-row>

              <v-row>
                <!-- Image 1 -->
                <v-col md="6">
                  <v-file-input
                    prepend-icon="mdi-camera"
                    show-size
                    @change="uploadImageByName($event, 'image')"
                    label="Choose an Image"
                    :rules="imageRules"
                    accept=".jpg, .png, .jpeg"
                  >
                  </v-file-input>
                </v-col>
                <v-col md="6">
                  <img
                    :src="showImageByName('image')"
                    class="rounded mx-auto d-block image-thum-size"
                  />
                </v-col>
              </v-row>

              <v-btn
                v-show="editmode"
                type="submit"
                block
                depressed
                :loading="addCarpoolLoader"
                color="primary"
              >
                <v-icon>mdi-edit</v-icon> Update
              </v-btn>
              <v-btn
                v-show="!editmode"
                type="submit"
                block
                depressed
                :loading="addCarpoolLoader"
                color="primary"
              >
                <v-icon>mdi-save</v-icon> Create
              </v-btn>
            </form>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- driver form Show -->
    <v-dialog persistent v-model="driverStatus" max-width="700px">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10"> Diver Levae Status </v-col>
            <v-col cols="2">
              <v-btn
                @click="driverStatus = false"
                elevation="20"
                color="error white--text"
                small
                class="float-right"
              >
                <v-icon left dark>mdi-close-octagon</v-icon> Close
              </v-btn>
            </v-col>
          </v-row>
        </v-card-title>

        <v-card-text>
          <table class="table table-borderless text-center">
            <tr>
              <th>Leave Type</th>
              <th>Leave Start</th>
              <th>Leave End</th>
              <th>Action</th>
            </tr>

            <tr v-for="leave in driverStatusData" :key="leave.id">
              <td>
                <div v-if="leave.type == 'lev'">Personal Leave</div>
                <div v-else-if="leave.type == 'req'">Police Requisition</div>
                <div v-else-if="leave.type == 'mant'">Car in Maintenances</div>
              </td>
              <td>
                <div v-if="leave.start">
                  {{ leave.start }}
                </div>
              </td>
              <td>
                <div v-if="leave.end">
                  {{ leave.end }}
                </div>
              </td>
              <td>
                <v-btn
                  v-if="leave.status"
                  @click="statusChangeDriverLeave(leave)"
                  color="success"
                  depressed
                  small
                >
                  <v-icon small>mdi-check-circle-outline</v-icon> Active
                </v-btn>
                <v-btn
                  v-else
                  @click="statusChangeDriverLeave(leave)"
                  color="warning"
                  depressed
                  small
                >
                  <v-icon small>mdi-alert-circle-outline </v-icon> Inactive
                </v-btn>
              </td>
            </tr>
          </table>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- Driver Leave -->
    <driver-leave-action
      v-if="currentCarDriver"
      :currentCarDriver="currentCarDriver"
      :key="leaveActionKey"
      @childToParent="childToParentCall"
    ></driver-leave-action>
  </div>
</template>


<script>
// vform
import Form from "vform";

//  leave component
import driverLeaveAction from "./driver_leave.vue";

export default {
  components: {
    "driver-leave-action": driverLeaveAction,
  },

  data() {
    return {
      // v-form
      valid: false,
      // dialog
      dataModalDialog: false,

      // driverStatus
      driverStatus: false,
      driverStatusData: [],

      // loader
      addCarpoolLoader: false,

      driverRules: [(v) => !!v || "This field is required!"],

      driverRulesOption: [(v) => v == 0 || v == 1 || "This field is required!"],

      imageRules: [
        (v) => !v || v.size < 2000000 || "Image size should be less than 2 MB!",
      ],

      //current page url

      currentUrl: "/carpool/admin/driver",

      activeOptions: [
        {
          text: "Yes",
          value: 1,
        },
        {
          text: "No",
          value: 0,
        },
      ],

      // Form
      form: new Form({
        id: "",
        name: "",
        contact: "",
        license: "",
        nid: "",
        status: "",
        image: "",
        car_id: null,
      }),

      imageMaxSize: "5111775",
      imagePathCar: "/images/carpool/car/",
      imagePathSmCar: "/images/carpool/car/small/",

      imagePath: "/images/carpool/driver/",
      imagePathSm: "/images/carpool/driver/small/",

      // statusOptions
      statusOptions: [
        {
          value: 1,
          text: "Active",
        },
        {
          value: 0,
          text: "Inactive",
        },
      ],

      // all car data
      carData: [],

      // Driver leave
      driverLeaveDilog: false,
      currentCarDriver: "",
      leaveActionKey: 0,
    };
  },

  methods: {
    // Add Data Model
    addDataModel() {
      this.editmode = false;
      this.form.reset();
      this.form.errors.clear();
      this.dataModalDialog = true;
    },

    // childToParentCall
    childToParentCall() {
      this.getResults();
    },

    // get all car data
    getCarData() {
      axios
        .get(this.currentUrl + "/free_car_data")
        .then((response) => {
          for (let i = 0; i < response.data.length; i++) {
            this.carData.push(response.data[i]);
            this.carData[i] = {
              value: response.data[i].id,
              text: response.data[i].name + " || " + response.data[i].number,
            };
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // driverLeavecon
    driverLeave(val) {
      this.leaveActionKey++;
      this.currentCarDriver = val;
    },

    // driverAllStatus
    driverAllStatus(data) {
      // console.log(data)
      this.driverStatus = true;
      this.driverStatusData = data;
    },

    // Change statusChangeDriverLeave
    statusChangeDriverLeave(data) {
      // console.log('status', data.status)
      if (data.status == 1) {
        var text = "Are you want to inactive ?";
        var btnText = "Yes Inactive";
      } else {
        var text = "Are you want to active ?";
        var btnText = "Yes Active";
      }

      Swal.fire({
        title: "Are you sure?",
        text: text,
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: btnText,
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          //console.log(id);
          this.$Progress.start();
          axios
            .post(this.currentUrl + "/leave_status/" + data.id)
            .then((response) => {
              //console.log(response);
              Swal.fire("Changed!", "Status has been Changed.", "success");
              // Refresh Tbl Data with current page
              this.getResults(this.currentPageNumber);
              this.driverStatus = false;
              this.$Progress.finish();
            })
            .catch((data) => {
              this.driverStatus = false;
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
    allData: function (value) {
      this.carData = [];
      this.getCarData();
    },
  },

  mounted() {
    this.getCarData();
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
</style>
