<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <v-row>
          <v-col cols="10"> My Hardware Complain List </v-col>
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
                ></v-text-field>
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
                  <a href="#" @click.prevent="change_sort('id')">Number</a>
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
                  <div class="pa-1 info rounded-pill h4 text-white">
                    {{ item.id }} (H)
                  </div>

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
                <td>
                  <div
                    v-if="item.process == 'Damaged'"
                    class="pa-1 error rounded-pill h6 text-white"
                  >
                    {{ item.process }}
                  </div>

                  <div v-else class="pa-1 info rounded-pill h6 text-white">
                    {{ item.process }}
                  </div>
                  <!-- damagedReplace -->
                  <div v-if="item.dam_apply && item.dam_apply.rec_name">
                    <v-btn
                      @click="damagedReplaceMethod(item.dam_apply)"
                      color="success"
                      x-small
                    >
                      <v-icon left>mdi-eye-arrow-left </v-icon> Damaged Replaced
                    </v-btn>
                  </div>
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
                        @click="longTextHTML(item.details)"
                        ><u> See More </u>
                      </v-btn>
                    </div>
                  </div>
                </td>

                <td>
                  <span
                    v-if="item.process == 'Not Process' && !item.remarks.length"
                  >
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
                    v-if="item.remarks.length"
                    @click="remarksDetailsShow(item)"
                    color="success"
                    depressed
                    small
                    elevation="20"
                  >
                    <v-icon left>mdi-eye-arrow-left </v-icon> View
                  </v-btn>

                  <!-- Damaged Replace -->
                  <span v-if="item.dam_apply && item.dam_apply.apply_by">
                    <div
                      class="m-1 info rounded-pill h6 text-white text-center"
                    >
                      Replace Applied <br />
                      <span
                        class="small text-warning"
                        v-if="item.dam_apply.apply_at"
                        >{{
                          item.dam_apply.apply_at | moment("MMMM Do YYYY")
                        }}</span
                      >
                    </div>
                  </span>
                  <span v-else>
                    <v-btn
                      v-if="
                        item.dam_apply &&
                        item.dam_apply.applicable_type == 'Applicable'
                      "
                      @click="damagedReplace(item.dam_apply.id)"
                      success
                      depressed
                      small
                      elevation="20"
                    >
                      <v-icon small>mdi-file-replace </v-icon> Replace Apply
                    </v-btn>
                  </span>

                  <!-- Damaged Quation -->
                  <div
                    v-if="item.dam_apply && item.dam_apply.apply_quotation"
                    class="text-center"
                  >
                    <v-btn
                      @click="damagedQuationMethod(item.dam_apply)"
                      color="success"
                      small
                    >
                      <v-icon left>mdi-eye-arrow-left </v-icon> Damaged
                      Quotation
                    </v-btn>
                  </div>

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
                    <div v-if="item.feedback.length < 50">
                      {{ item.feedback }}
                    </div>
                    <div v-else>
                      {{ item.feedback.substring(0, 50) + "..." }}
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
            <b class="text-success">Hardware</b> section.
          </div>
        </h4>
      </v-card-text>
    </v-card>

    <!-- Remarks infomation -->
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
          <!-- All Remarks -->
          <div v-if="allRemarks.remarks" class="mb-2">
            <div v-for="(item, index) in allRemarks.remarks" :key="index">
              <!--Start remarks -->
              <table
                class="
                  table
                  mb-1
                  rem_bg_color
                  text-white
                  rounded
                  border-bottom border-danger
                "
              >
                <!-- remarks -->
                <tr>
                  <th>Process: ({{ index + 1 }})</th>
                  <td>
                    <span
                      v-if="item.process == 'Damaged'"
                      class="text-danger bg-white rounded"
                      >Damaged</span
                    >
                    <span
                      v-else-if="item.process == 'Closed'"
                      class="text-danger bg-white rounded"
                      >Closed</span
                    >
                    <span v-else>{{ item.process }}</span>
                  </td>
                  <th>Document:</th>
                  <td>
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
                    <span v-else class="text-warning">No Document's Send</span>
                  </td>
                </tr>
                <tr>
                  <th>By:</th>
                  <td>
                    {{ item.makby.name }}
                  </td>
                  <th>Action At:</th>
                  <td>
                    <span v-if="item.created_at">{{
                      item.created_at | moment("MMMM Do YYYY, h:mm a")
                    }}</span>
                  </td>
                </tr>

                <tr>
                  <th>Remarks:</th>
                  <td colspan="3" v-html="item.details"></td>
                </tr>
              </table>
              <!--End remarks -->

              <!--Start ho_remarks -->
              <div v-if="item.process == 'HO Service'">
                <div
                  v-for="(item, index) in allRemarks.ho_remarks"
                  :key="index"
                >
                  <table class="table mb-0 bg-info text-white rounded">
                    <tr>
                      <th>HO Process: ({{ index + 1 }})</th>
                      <td>
                        <span
                          v-if="item.process == 'Damaged'"
                          class="text-danger bg-white rounded"
                          >Damaged</span
                        >
                        <span
                          v-else-if="item.process == 'Closed'"
                          class="text-danger bg-white rounded"
                          >Closed</span
                        >
                        <span v-else>{{ item.process }}</span>
                      </td>
                      <th>Document:</th>
                      <td>
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
                        <span v-else class="text-warning"
                          >No Document's Send</span
                        >
                      </td>
                    </tr>
                    <tr>
                      <th>By:</th>
                      <td>
                        <button
                          class="btn btn-secondary btn-sm"
                          v-if="item.makby"
                          @click="currentUserView(item.makby)"
                        >
                          <v-avatar size="20">
                            <img
                              v-if="item.makby.image"
                              :src="'/images/users/small/' + item.makby.image"
                              alt="image"
                            />
                          </v-avatar>
                          {{ item.makby.name }}
                        </button>
                      </td>
                      <th>Action At:</th>
                      <td>
                        <span v-if="item.created_at">{{
                          item.created_at | moment("MMMM Do YYYY, h:mm a")
                        }}</span>
                      </td>
                    </tr>

                    <tr>
                      <th>Remarks:</th>
                      <td colspan="3" v-html="item.details"></td>
                    </tr>
                  </table>
                </div>
              </div>
              <!--End ho_remarks -->
            </div>
          </div>

          <!-- Start Damaged Replaced received -->
          <table
            class="
              table
              mb-1
              dmg_bg_color
              text-white
              rounded
              border-bottom border-danger
            "
            v-if="allRemarks.damage && allRemarks.damage.rep_pro_id"
          >
            <!-- {{ allRemarks.damage }} -->

            <tr>
              <td colspan="8" class="text-center h3 text-success">
                Damaged Replaced
              </td>
            </tr>
            <tr>
              <th>By:</th>
              <td colspan="3">{{ allRemarks.damage.makby.name }}</td>
              <th>Action At:</th>
              <td colspan="3">
                <span v-if="allRemarks.damage.created_at">{{
                  allRemarks.damage.created_at | moment("MMMM Do YYYY, h:mm a")
                }}</span>
              </td>
            </tr>
          </table>
          <!-- Start Damaged Replaced received -->

          <!-- Start Delivered -->
          <table
            class="
              table
              mb-1
              bg-success
              text-white
              rounded
              border-bottom border-danger
            "
            v-if="allRemarks.delivery"
          >
            <!-- {{ allRemarks.delivery }} -->

            <tr>
              <td colspan="8" class="text-center h3">----- Delivered -----</td>
            </tr>
            <tr>
              <th>By:</th>
              <td colspan="3">{{ allRemarks.delivery.makby.name }}</td>
              <th>Action At:</th>
              <td colspan="3">
                <span v-if="allRemarks.delivery.created_at">{{
                  allRemarks.delivery.created_at
                    | moment("MMMM Do YYYY, h:mm a")
                }}</span>
              </td>
            </tr>

            <tr>
              <th>Receiver Name:</th>
              <td>{{ allRemarks.delivery.rec_name }}</td>
              <th>Receiver Contact:</th>
              <td>{{ allRemarks.delivery.rec_contact }}</td>
              <th>Receiver Position:</th>
              <td>{{ allRemarks.delivery.rec_position }}</td>
              <th>Received At:</th>
              <td>
                <span
                  v-if="allRemarks.delivery.updated_at"
                  class="text-warning"
                  >{{
                    allRemarks.delivery.updated_at
                      | moment("MMMM Do YYYY, h:mm a")
                  }}</span
                >
              </td>
            </tr>
            <tr>
              <th>Remarks:</th>
              <td colspan="7" v-html="allRemarks.delivery.details"></td>
            </tr>
          </table>
          <!-- Start Delivered -->
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog max-width="500px" v-model="damQuotationModal">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10"> Damage Replace </v-col>
            <v-col cols="2">
              <v-btn
                @click="damQuotationModal = false"
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
          <div v-if="allRemarks.dam_apply && allRemarks.dam_apply.rep_pro_id">
            <div><b>Receiver Name</b> {{ allRemarks.dam_apply.rec_name }}</div>
            <div>
              <b>Receiver Contact</b> {{ allRemarks.dam_apply.rec_contact }}
            </div>
            <div>
              <b>Receiver Position</b> {{ allRemarks.dam_apply.rec_position }}
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- Damage Replace Receiver details -->
    <v-dialog max-width="700px" v-model="damagedReplaceDialog">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10"> Replace Receiver Details </v-col>
            <v-col cols="2">
              <v-btn
                @click="damagedReplaceDialog = false"
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
          <table class="table">
            <tr>
              <th>Receiver Name</th>
              <td>
                <span v-if="currentDamagedReplaceData.rec_name">{{
                  currentDamagedReplaceData.rec_name
                }}</span>
                <span v-else class="error--text">N/A</span>
              </td>
            </tr>
            <tr>
              <th>Receiver Contact</th>
              <td>
                <span v-if="currentDamagedReplaceData.rec_contact">{{
                  currentDamagedReplaceData.rec_contact
                }}</span>
                <span v-else class="error--text">N/A</span>
              </td>
            </tr>
            <tr>
              <th>Receiver Position</th>
              <td>
                <span v-if="currentDamagedReplaceData.rec_position">{{
                  currentDamagedReplaceData.rec_position
                }}</span>
                <span v-else class="error--text">N/A</span>
              </td>
            </tr>
            <tr>
              <th>Delivery By</th>
              <td>
                <span v-if="currentDamagedReplaceData.makby">{{
                  currentDamagedReplaceData.makby.name
                }}</span>
                <span v-else class="error--text">N/A</span>
              </td>
            </tr>
            <tr>
              <th>Receiver Date</th>
              <td>
                <span v-if="currentDamagedReplaceData.created_at">{{
                  currentDamagedReplaceData.created_at
                    | moment("dddd, MMMM Do YYYY, h:mm:ss a")
                }}</span>
                <span v-else class="error--text">N/A</span>
              </td>
            </tr>
          </table>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- Damage Quation details -->
    <v-dialog v-model="damagedQuotationDialog">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10"> Quotation Details </v-col>
            <v-col cols="2">
              <v-btn
                @click="damagedQuotationDialog = false"
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
          <table class="table">
            <tr>
              <th>Quotation</th>
              <td>
                <span
                  v-if="currentDamagedReplaceData.apply_quotation"
                  v-html="currentDamagedReplaceData.apply_quotation"
                ></span>
                <span v-else class="error--text">N/A</span>
              </td>
            </tr>
            <tr>
              <th>Document</th>
              <td>
                <span v-if="currentDamagedReplaceData.document">
                  <a
                    v-if="currentDamagedReplaceData.document"
                    :href="docPath + currentDamagedReplaceData.document"
                    class="btn btn-info btn-sm text-white"
                    download
                  >
                    <v-icon color="white" small>mdi-paperclip</v-icon> Document
                  </a>
                </span>
                <span v-else class="error--text">N/A</span>
              </td>
            </tr>
          </table>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- hard rating -->
    <hard-rating
      @childToParent="childToParentCall"
      v-if="hardratingDialogShow"
      :key="hardratingKey"
      :currentDataId="currentDataId"
    ></hard-rating>

    <!-- longtextDialog -->
    <v-dialog v-model="longtextDialog" max-width="300">
      <v-card>
        <v-card-text>
          {{ currentText }}
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- longtextDialog -->
    <v-dialog v-model="longtextDialogHTML" max-width="500">
      <v-card class="p-2">
        <v-card-text v-html="currentTextHTML" class="p-0 m-0"></v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
import hardRating from "../pages/hardRating.vue";
export default {
  components: {
    "hard-rating": hardRating,
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
      currentUrl: "/cms/hard",

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
      docPath: "/images/hardware/",

      // damQuotationModal
      damQuotationModal: false,

      damagedReplaceDialog: false,
      currentDamagedReplaceData: "",
      damagedQuotationDialog: false,

      // rating component
      hardratingDialogShow: false,
      hardratingKey: 0,

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
      this.hardratingDialogShow = true;
      this.hardratingKey++;
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
      console.log("remarksDetail", val.remarks, val.ho_remarks);
    },

    // damagedReplace
    damagedReplace(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "Apply for a damaged replacement",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, Apply",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          //console.log(id);
          this.$Progress.start();
          axios(this.currentUrl + "/damage_apply?id=" + id)
            .then((response) => {
              //console.log(response);
              Swal.fire({
                icon: response.data.icon,
                title: response.data.msg,
              });
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

    // damagedReplaceMethod
    damagedReplaceMethod(val) {
      this.currentDamagedReplaceData = val;
      this.damagedReplaceDialog = true;
    },

    // damagedQuationMethod
    damagedQuationMethod(val) {
      this.currentDamagedReplaceData = val;
      this.damagedQuotationDialog = true;
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

.rem_bg_color {
  background: #283c86; /* fallback for old browsers */
  background: -webkit-linear-gradient(
    to right,
    #45a247,
    #283c86
  ); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(
    to right,
    #45a247,
    #283c86
  ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}

.dmg_bg_color {
  background: #009fff; /* fallback for old browsers */
  background: -webkit-linear-gradient(
    to right,
    #ec2f4b,
    #009fff
  ); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(
    to right,
    #ec2f4b,
    #009fff
  ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}

.process_bgclr {
  background: #bbf1c9;
}

.deliver_bg_color {
  background: #00f260; /* fallback for old browsers */
  background: -webkit-linear-gradient(
    to right,
    #0575e6,
    #00f260
  ); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(
    to right,
    #0575e6,
    #00f260
  ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
</style>
