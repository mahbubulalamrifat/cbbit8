<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-12">
            <span class="card-title h3">MRO Audit Schedules</span>
            <span class="text-muted">{{
              new Date() | moment("dddd, MMMM Do YYYY")
            }}</span>
            <span v-if="auth" class="float-right"
              >{{ auth.name }} <span v-if="isAdmin()"> ( Admin )</span>
              <span v-else-if="isAuditor()"> ( Auditor )</span>
              <span v-else-if="isUser()">( User )</span></span
            >
          </div>
        </div>
      </div>

      <div class="card-body">
        <div v-if="allData.data">
          <div class="row mb-2">
            <div class="col form-inline small">
              <select v-model="paginate" class="form-control form-control-sm">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>
            </div>

            <div class="col">
              <input
                v-model="search"
                class="form-control form-control-sm"
                type="text"
                placeholder="Search by any data at the table..."
              />
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Action</th>
                  <th>
                    <a href="#" @click.prevent="change_sort('date')"
                      >Audit Date</a
                    >
                    <span
                      v-if="sort_direction == 'desc' && sort_field == 'date'"
                      >&uarr;</span
                    >
                    <span v-if="sort_direction == 'asc' && sort_field == 'date'"
                      >&darr;</span
                    >
                  </th>

                  <th>Vendor Number</th>
                  <th>Suppier Name</th>
                  <th>Address</th>
                  <th>Telephone</th>
                  <th>Auditor Name</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="singleData in allData.data" :key="singleData.id">
                  <td class="text-center">
                    <div class="mb-3">
                      <!-- audited_manufacturer -->
                      <span v-if="singleData.audited_manufacturer">
                        <v-badge
                          v-if="singleData.audited_manufacturer.status == 1"
                          color="success"
                          content="Manufacturer Audit Completed"
                          inline
                        ></v-badge>
                      </span>

                      <!-- audited_importer -->
                      <span v-else-if="singleData.audited_importer">
                        <v-badge
                          v-if="singleData.audited_importer.status == 1"
                          color="success"
                          content="Importer Audit Completed"
                          inline
                        ></v-badge>
                      </span>
                      <!-- audited_retailer -->
                      <span v-else-if="singleData.audited_retailer">
                        <v-badge
                          v-if="singleData.audited_retailer.status == 1"
                          color="success"
                          content="Retailer Audit Completed"
                          inline
                        ></v-badge>
                      </span>

                      <span v-else>
                        <!-- Token Genrated -->
                        <span
                          v-if="
                            singleData.activetoken &&
                            singleData.activetoken.token &&
                            !isAuditor()
                          "
                        >
                          <v-badge
                            color="info"
                            content="Token Genrated"
                            inline
                          ></v-badge>
                        </span>
                      </span>
                    </div>

                    <!-- v-if="isAuditor()" -->
                    <div>
                      <!-- Generated Token Part -->
                      <span
                        v-if="
                          singleData.activetoken && singleData.activetoken.token
                        "
                      >
                        <b
                          class="
                            h3
                            rounded
                            bg-primary
                            p-2
                            text-light
                            link-hobar
                            spacing
                          "
                          @click="goForAudit(singleData.activetoken.token)"
                          >{{ singleData.activetoken.token }}</b
                        >
                      </span>
                      <!--Not Generated Token Part -->
                      <span v-else>
                        <!-- Schedule date not matched with current date -->

                        <span v-if="checkGenerateTokenAccess(singleData)">
                          <button
                            @click="generateToken(singleData)"
                            class="btn btn-success btn-sm m-1 link-hobar"
                          >
                            <i class="far fa-check-circle"></i> Token Generate
                          </button>
                        </span>
                        <!-- Schedule date matched with current date -->
                        <span v-else>
                          <button
                            class="
                              btn btn-success btn-sm
                              m-1
                              link-hobar-disabled
                            "
                            disabled
                          >
                            <i class="far fa-check-circle"></i> Token Generate
                          </button>
                        </span>
                      </span>
                    </div>

                    <!-- v-if="isUser() && !isAuditor()" -->
                    <div>
                      <!-- Schedule date not matched with current date -->
                      <span v-if="singleData.date == todayDate">
                        <button
                          @click="showModal(singleData)"
                          class="btn btn-success btn-sm m-1 link-hobar"
                        >
                          <i class="far fa-clipboard"></i> Put Token
                        </button>
                      </span>

                      <span v-else>
                        <button
                          class="btn btn-success btn-sm m-1 link-hobar-disabled"
                          disabled
                        >
                          <i class="far fa-clipboard"></i> Put Token
                        </button>

                        <!-- {{ todayDate }} == {{ singleData.date }}  -->
                      </span>
                    </div>
                  </td>
                  <td>{{ singleData.date }}</td>
                  <td>
                    <span v-if="singleData.vendor">{{
                      singleData.vendor.vendor_number
                    }}</span>
                  </td>
                  <td>
                    <span v-if="singleData.vendor">{{
                      singleData.vendor.suppier_name
                    }}</span>
                  </td>
                  <td>
                    <span v-if="singleData.vendor">{{
                      singleData.vendor.address
                    }}</span>
                  </td>
                  <td>
                    <span v-if="singleData.vendor">{{
                      singleData.vendor.telephone
                    }}</span>
                  </td>
                  <td>
                    <span v-if="singleData.user">{{
                      singleData.user.name
                    }}</span>
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

    <!-- token_check_model -->
    <v-dialog v-model="token_check_model" max-width="500px">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10"> Verify Token </v-col>
            <v-col cols="2">
              <v-btn
                @click="token_check_model = false"
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
            <form @submit.prevent="putTokenByUser()">
              <v-text-field
                v-model="form.token"
                label="Enter role token"
                :class="{ 'is-invalid': form.errors.has('token') }"
                :rules="[(v) => !!v || 'Token is required!']"
                required
              ></v-text-field>
              <div
                class="small text-danger"
                v-if="form.errors.has('token')"
                v-html="form.errors.get('token')"
              />
              <div>
                <v-btn
                  type="submit"
                  block
                  dense
                  :loading="tokenCheckLoading"
                  color="primary"
                  ><v-icon>mdi-card-search</v-icon> Verify Token</v-btn
                >
              </div>
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

import moment from "moment";

export default {
  data() {
    return {
      valid: false,
      // dialog
      token_check_model: false,
      tokenCheckLoading: false,

      // current page url
      currentUrl: "/ivca/mro",
      sort_direction: "asc",
      sort_field: "date",
      allVendors: {},

      todayDate: moment().format("Y-MM-DD"),

      // Form
      form: new Form({
        id: "",
        token: "",
        vendor_id: "",
      }),
    };
  },

  methods: {
    // Check Role
    checkRole() {
      if (!this.isMro()) {
        // Error alart
        Swal.fire({
          icon: "error",
          title: "Error !!",
          text: "Sorry !, You have no access",
        });
        // Redirect
        this.$router.push({
          name: "ivca_dashboard",
        });
      }
    },

    // Get table data
    getDirectResults(page = 1) {
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
            this.sort_field
        )
        .then((response) => {
          console.log(response.data.data);

          this.allData = response.data;
          this.totalValue = response.data.total;
          this.dataShowFrom = response.data.from;
          this.dataShowTo = response.data.to;

          // Loading Animation
          this.dataLoading = false;
        });
    },

    // checkGenerateTokenAccess
    checkGenerateTokenAccess(singleData) {
      if (
        singleData.user_id == this.auth.id &&
        singleData.date == this.todayDate
      ) {
        return true;
      }
      return false;
    },

    // Generate token
    generateToken(singleData) {
      axios
        .post(this.currentUrl + "/token/create", {
          scheduleId: singleData.id,
          vendorId: singleData.vendor.id,
        })
        .then((response) => {
          //console.log(response.data)

          this.getResults();

          Swal.fire(
            response.data.status,
            response.data.msg,
            response.data.icon
          );
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // goForAudit
    goForAudit(token) {
      this.$router.push({
        name: "ivca_mro_choose_template",
        query: {
          token: token,
        },
      });
    },

    // Put Token By User
    putTokenByUser() {
      // Loading
      this.tokenCheckLoading = true;
      this.form
        .post(this.currentUrl + "/token/check_by_user")
        .then((response) => {
          //console.log(response.data)

          // Loading
          this.tokenCheckLoading = false;

          // Hide Model
          this.hideModal();

          Swal.fire({
            icon: response.data.icon,
            title: response.data.status,
            text: response.data.msg,
          });

          if (response.data.status == "Success") {
            // Redirect
            this.$router.push({
              name: "ivca_mro_audit_questions",
              query: {
                token: response.data.token,
              },
            });
          }
        })
        .catch((error) => {
          // Loading
          this.tokenCheckLoading = false;
          // Error
          Swal.fire({
            icon: "error",
            title: "Error !!",
            text: "Sorry! Somthing going wrong",
          });
          console.log(error);
        });
    },

    // Show Modal
    showModal(singleData) {
      console.log(singleData.vendor_id);
      //this.form.token = singleData.activetoken.token
      this.form.vendor_id = singleData.vendor_id;
      // this.form.fill(singleData)
      //this.$refs['token_check_model'].show();
      this.token_check_model = true;
    },

    // Hide Modal
    hideModal() {
      //this.$refs['token_check_model'].hide();
      this.token_check_model = false;
    },
  },

  // computed: {
  //     // a computed getter
  //     checkRunAudit: function (data) {
  //         // `this` points to the vm instance
  //         console.log('computed'+data)

  //         return data
  //     }
  // },

  created() {
    this.$Progress.start();
    // Check access
    this.checkRole();

    // Fetch initial results
    this.getDirectResults();

    this.$Progress.finish();

    console.log("Today", this.todayDate, this.auth);
  },
};
</script>
