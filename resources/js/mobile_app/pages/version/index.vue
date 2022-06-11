<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <h3 class="card-title">App Version</h3>
          </div>
          <div class="col-6">
            <v-btn
              @click="addDataModel"
              elevation="10"
              small
              class="float-right"
              color="primary"
              outlined
            >
              <v-icon small>mdi-card-plus</v-icon> Add
            </v-btn>
          </div>
        </div>
        <div>
          <span>Get App Version </span><br />
          <a href="/api/mobileapp/version?appname=abc" target="_blank">
            {{ baseUrl + "/api/mobileapp/version?appname=abc" }}</a
          >
        </div>
      </div>

      <div class="card-body">
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
                label="Search:"
                v-model="search"
                placeholder="Search by any data at the table..."
              ></v-text-field>
            </v-col>
          </v-row>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="text-center">
                <tr>
                  <th>
                    <a href="#" @click.prevent="change_sort('id')">ID</a>
                    <span v-if="sort_direction == 'desc' && sort_field == 'id'"
                      >&uarr;</span
                    >
                    <span v-if="sort_direction == 'asc' && sort_field == 'id'"
                      >&darr;</span
                    >
                  </th>
                  <th>
                    <a href="#" @click.prevent="change_sort('name')">Name</a>
                    <span
                      v-if="sort_direction == 'desc' && sort_field == 'name'"
                      >&uarr;</span
                    >
                    <span v-if="sort_direction == 'asc' && sort_field == 'name'"
                      >&darr;</span
                    >
                  </th>
                  <th>
                    <a href="#" @click.prevent="change_sort('version')"
                      >Version</a
                    >
                    <span
                      v-if="sort_direction == 'desc' && sort_field == 'version'"
                      >&uarr;</span
                    >
                    <span
                      v-if="sort_direction == 'asc' && sort_field == 'version'"
                      >&darr;</span
                    >
                  </th>
                  <th>Created By</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="singleData in allData.data" :key="singleData.id">
                  <td>{{ singleData.id }}</td>
                  <td>{{ singleData.name }}</td>
                  <td>{{ singleData.version }}</td>
                  <td>
                    <span v-if="singleData.makby">{{
                      singleData.makby.name
                    }}</span>
                  </td>

                  <td class="text-center">
                    <v-btn
                      v-if="singleData.status"
                      @click="statusChange(singleData)"
                      small
                      color="primary"
                      elevation="10"
                      class="mb-1"
                    >
                      <v-icon left>mdi-check-decagram</v-icon> Active
                    </v-btn>
                    <v-btn
                      v-else
                      @click="statusChange(singleData)"
                      small
                      color="warning"
                      elevation="10"
                      class="mb-1"
                    >
                      <v-icon left>mdi-close-octagon</v-icon> Inactive
                    </v-btn>

                    <v-btn
                      @click="editDataModel(singleData)"
                      small
                      color="info"
                      elevation="10"
                      class="mb-1"
                    >
                      <v-icon left>mdi-circle-edit-outline</v-icon> Edit
                    </v-btn>

                    <v-btn
                      @click="deleteData(singleData.id)"
                      small
                      color="error"
                      elevation="10"
                      class="mb-1"
                    >
                      <v-icon left>mdi-delete-empty</v-icon> Delete
                    </v-btn>
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
            <p class="text-center">
              <i class="fas fa-spinner fa-pulse text-success fa-10x"></i>
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
    </div>

    <!-- Dilog  -->
    <v-dialog v-model="dataModalDialog" persistent max-width="600px">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10">
              {{ dataModelTitle }}
            </v-col>
            <v-col cols="2">
              <v-btn
                @click="dataModalDialog = false"
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
          <v-form v-model="valid">
            <form @submit.prevent="editmode ? updateData() : createData()">
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    type="text"
                    label="App Name:"
                    :rules="[(v) => !!v || 'App Name is required!']"
                    v-model="form.name"
                    required
                  >
                  </v-text-field>
                  <div
                    v-if="form.errors.has('name')"
                    v-html="form.errors.get('name')"
                  />
                </v-col>

                <v-col cols="12">
                  <v-text-field
                    type="text"
                    label="App Version:"
                    :rules="[(v) => !!v || 'App Version is required!']"
                    v-model="form.version"
                    required
                  >
                  </v-text-field>
                  <div
                    v-if="form.errors.has('version')"
                    v-html="form.errors.get('version')"
                  />
                </v-col>

                <v-btn
                  block
                  blockdepressed
                  :loading="dataModalLoading"
                  color="primary mt-3"
                  type="submit"
                >
                  <span v-if="editmode">
                    <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
                  </span>
                  <span v-else>
                    <v-icon left dark>mdi-shape-polygon-plus </v-icon> Create
                  </span>
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
      //current page url
      currentUrl: "/mobile_app/version",
      // Base URL
      baseUrl: window.location.origin,

      // Form
      form: new Form({
        id: "",
        name: "",
        version: "",
      }),
    };
  },

  methods: {},

  created() {
    this.$Progress.start();
    // Fetch initial results
    this.getResults();
    this.$Progress.finish();
  },
};
</script>
