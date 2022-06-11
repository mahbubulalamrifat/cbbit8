<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <v-row>
          <v-col cols="10"> Carpool Car's Table </v-col>
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
                  <th>Images</th>
                  <th>Car Details</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="singleData in allData.data" :key="singleData.id">
                  <td>
                    <img
                      v-if="singleData.image"
                      :src="imagePathSm + singleData.image"
                      alt="image"
                      class="m-1"
                      height="100"
                      width="100"
                    />
                    <img
                      v-if="singleData.image2"
                      :src="imagePathSm + singleData.image2"
                      alt="image"
                      class="m-1"
                      height="100"
                      width="100"
                    />
                    <img
                      v-if="singleData.image3"
                      :src="imagePathSm + singleData.image3"
                      alt="image"
                      class="m-1"
                      height="100"
                      width="100"
                    />
                  </td>
                  <td>
                    <div v-if="singleData.name">
                      <b>Car Name:</b> {{ singleData.name }}
                    </div>
                    <div v-if="singleData.number">
                      <b>Car Number:</b> {{ singleData.number }}
                    </div>
                    <div v-if="singleData.capacity">
                      <b>Capacity:</b> {{ singleData.capacity }}
                    </div>
                    <div v-if="singleData.temporary == 1">
                      <b>Car Type:</b> Temporary

                      <v-btn
                        depressed
                        small
                        color="indigo white--text"
                        class="d-flex flex-end"
                        @click="temporaryChange(singleData)"
                      >
                        <v-icon small>mdi-check</v-icon> Temporary
                      </v-btn>
                    </div>
                    <div v-if="singleData.temporary == 0">
                      <b>Car Type:</b> Regular

                      <v-btn
                        depressed
                        small
                        color="cyan white--text"
                        class="d-flex flex-end"
                        @click="temporaryChange(singleData)"
                      >
                        <v-icon small>mdi-check</v-icon> Regular
                      </v-btn>
                    </div>
                    <div v-if="singleData.remarks">
                      <b>Remarks</b> {{ singleData.remarks }}
                    </div>
                    <div v-if="singleData.last_use">
                      <b>Use Deadline:</b> {{ singleData.last_use }}
                      <v-btn
                        depressed
                        small
                        color="blue-grey white--text"
                        class="d-flex flex-end"
                        @click="deadlineClear(singleData.id)"
                      >
                        <v-icon small>mdi-close</v-icon> Clear Deadline
                      </v-btn>
                    </div>
                  </td>

                  <td class="text-center">
                    <v-btn
                      v-if="singleData.status"
                      @click="statusChange(singleData)"
                      color="success"
                      depressed
                      small
                      class="m-1"
                    >
                      <v-icon left>mdi-check-circle-outline</v-icon> Active
                    </v-btn>
                    <v-btn
                      v-else
                      @click="statusChange(singleData)"
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

                    <v-btn
                      depressed
                      small
                      color="grey white--text"
                      @click="deadlineModal(singleData)"
                      class="m-1"
                    >
                      <v-icon left>mdi-plus-circle-outline</v-icon> Deadline
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

    <!-- Modal -->
    <v-dialog persistent v-model="dataModalDialog" max-width="1100px">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10">
              <span v-if="editmode">Update Car Information</span>
              <span v-else>Add New Car Information</span>
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
          <v-form v-model="valid" ref="form">
            <form @submit.prevent="editmode ? updateData() : createData()">
              <v-row>
                <v-col md="6" cols="12">
                  <div
                    class="text-danger"
                    v-if="form.errors.has('number')"
                    v-html="form.errors.get('number')"
                  />
                  <v-text-field
                    v-model="form.number"
                    label="Enter Car Number"
                    :rules="carRules"
                    required
                  ></v-text-field>
                </v-col>

                <v-col md="6" cols="12">
                  <div
                    class="text-danger"
                    v-if="form.errors.has('name')"
                    v-html="form.errors.get('name')"
                  />
                  <v-text-field
                    v-model="form.name"
                    label="Enter Car Name"
                    :rules="carRules"
                    required
                  >
                  </v-text-field>
                </v-col>
              </v-row>

              <v-row>
                <v-col cols="12" lg="6">
                  <div
                    class="text-danger"
                    v-if="form.errors.has('remarks')"
                    v-html="form.errors.get('remarks')"
                  />
                  <v-textarea
                    outlined
                    rows="2"
                    v-model="form.remarks"
                    label="Enter Car Details"
                  >
                  </v-textarea>
                </v-col>

                <v-col cols="12" lg="6">
                  <div
                    class="text-danger"
                    v-if="form.errors.has('capacity')"
                    v-html="form.errors.get('capacity')"
                  />
                  <v-text-field
                    type="number"
                    v-model="form.capacity"
                    label="Enter Car capacity"
                    :rules="carRules"
                    required
                  ></v-text-field>
                </v-col>

                <v-col lg="6" cols="12">
                  <div
                    class="text-danger"
                    v-if="form.errors.has('status')"
                    v-html="form.errors.get('status')"
                  />
                  <v-select
                    label="Car Status (Default Active)"
                    v-model="form.status"
                    :items="statusOptions"
                    :rules="carRulesOption"
                    required
                  >
                  </v-select>
                </v-col>
                <v-col lg="6" cols="12">
                  <div
                    class="text-danger"
                    v-if="form.errors.has('temporary')"
                    v-html="form.errors.get('temporary')"
                  />
                  <v-select
                    label="Car Type"
                    v-model="form.temporary"
                    :items="typeOptions"
                    :rules="carRulesOption"
                    required
                  >
                  </v-select>
                </v-col>
              </v-row>

              <v-row>
                <!-- Image 1 -->
                <v-col md="4">
                  <v-file-input
                    prepend-icon="mdi-camera"
                    @change="uploadImageByName($event, 'image')"
                    label="Choose 1st Image"
                    accept=".jpg, .png, .jpeg"
                  >
                  </v-file-input>
                </v-col>
                <!-- Image 2 -->
                <v-col md="4">
                  <v-file-input
                    prepend-icon="mdi-camera"
                    @change="uploadImageByName($event, 'image2')"
                    label="Choose 2nd Image"
                    accept=".jpg, .png, .jpeg"
                  >
                  </v-file-input>
                </v-col>
                <!-- Image 2 -->
                <v-col md="4">
                  <v-file-input
                    prepend-icon="mdi-camera"
                    @change="uploadImageByName($event, 'image3')"
                    label="Choose 3rd Image"
                    accept=".jpg, .png, .jpeg"
                  >
                  </v-file-input>
                </v-col>
              </v-row>

              <v-row class="mb-2">
                <v-col md="4">
                  <img
                    :src="showImageByName('image')"
                    class="rounded mx-auto d-block image-thum-size"
                  />
                </v-col>
                <v-col md="4">
                  <img
                    :src="showImageByName('image2')"
                    class="rounded mx-auto d-block image-thum-size"
                  />
                </v-col>
                <v-col md="4">
                  <img
                    :src="showImageByName('image3')"
                    class="rounded mx-auto d-block image-thum-size"
                  />
                </v-col>
              </v-row>

              <v-btn
                v-show="editmode"
                type="submit"
                block
                depressed
                :loading="dataModalLoading"
                color="primary"
              >
                <v-icon>mdi-edit</v-icon> Update
              </v-btn>
              <v-btn
                v-show="!editmode"
                type="submit"
                block
                depressed
                :loading="dataModalLoading"
                color="primary"
              >
                <v-icon>mdi-save</v-icon> Create
              </v-btn>
            </form>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- mdoal car deadline -->
    <v-dialog persistent v-model="deadlineDialog" max-width="600px">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10"> Car Deadline </v-col>
            <v-col cols="2">
              <v-btn
                @click="(deadlineDialog = false), resetForm()"
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
          <v-form v-model="valid" ref="form">
            <form @submit.prevent="createDeadlineData()">
              <v-row>
                <v-col cols="12" md="6">
                  <v-text-field
                    label="Car Name"
                    v-model="form.name"
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    label="Car Name"
                    v-model="form.number"
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-menu v-model="menu" min-width="auto">
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="form.last_use"
                        label="Enter Last Use Date"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        :rules="carRules"
                        required
                      ></v-text-field>
                    </template>

                    <v-date-picker v-model="form.last_use" no-title scrollable>
                      <v-spacer></v-spacer>
                      <v-btn text color="primary" @click="menu = false">
                        Cancel
                      </v-btn>
                    </v-date-picker>
                  </v-menu>
                </v-col>
                <v-btn
                  type="submit"
                  block
                  depressed
                  :loading="addCarpoolLoader"
                  color="primary"
                >
                  <v-icon>mdi-edit</v-icon> Save
                </v-btn>
              </v-row>
            </form>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
// vform
import Form from "vform";

export default {
  data() {
    return {
      // calendar
      menu: "false",
      date: "",

      // v-form
      valid: false,
      // dialog
      dataModalDialog: false,
      deadlineDialog: false,

      // loader
      addCarpoolLoader: false,

      carRules: [(v) => !!v || "This field is required!"],

      carRulesOption: [(v) => v == 0 || v == 1 || "This field is required!"],

      //current page url
      //currentUrl: '/room/admin/room',

      currentUrl: "/carpool/admin/car",

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
        number: "",
        remarks: "",
        capacity: "",
        status: 1,
        temporary: "",
        image: "",
        image2: "",
        image3: "",
        last_use: "",
      }),

      imageMaxSize: "5111775",
      imagePath: "/images/carpool/car/",
      imagePathSm: "/images/carpool/car/small/",

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

      // typeOptions
      typeOptions: [
        {
          value: 1,
          text: "Regular",
        },
        {
          value: 0,
          text: "Temporary",
        },
      ],
    };
  },

  methods: {},

  mounted() {
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
