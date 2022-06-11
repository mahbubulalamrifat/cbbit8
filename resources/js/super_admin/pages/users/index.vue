<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <h3 class="card-title">All User List</h3>
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
      </div>

      <div class="card-body">
        <div v-if="allData.data">
          <!-- change -->
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

            <v-col cols="6" lg="3">
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

            <v-col cols="6" lg="2">
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

            <v-col cols="12" lg="3">
              <v-text-field
                prepend-icon="mdi-clipboard-text-search"
                v-model="search"
                label="Search:"
                placeholder="Search Input..."
              ></v-text-field>
            </v-col>
          </v-row>

          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>
                    <a href="#" @click.prevent="change_sort('login')">login</a>
                    <span
                      v-if="sort_direction == 'desc' && sort_field == 'login'"
                      >&uarr;</span
                    >
                    <span
                      v-if="sort_direction == 'asc' && sort_field == 'login'"
                      >&darr;</span
                    >
                  </th>
                  <th>
                    Details
                    <span class="float-right"
                      ><a href="#" @click.prevent="change_sort('status')"
                        >Active/Inactive User</a
                      >
                      <span
                        v-if="
                          sort_direction == 'desc' && sort_field == 'status'
                        "
                        >&uarr;</span
                      >
                      <span
                        v-if="sort_direction == 'asc' && sort_field == 'status'"
                        >&darr;</span
                      ></span
                    >
                  </th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="singleData in allData.data" :key="singleData.id">
                  <td>
                    {{ singleData.login }}<br />
                    <v-avatar size="100" @click="currentUserView(singleData)">
                      <img
                        v-if="singleData.image"
                        :src="imagePathSm + singleData.image"
                        alt="image"
                      />
                    </v-avatar>

                    <v-tooltip bottom>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn
                          v-bind="attrs"
                          v-on="on"
                          @click="resendRegisterMail(singleData.login)"
                          small
                          class="float-right"
                          elevation="20"
                        >
                          <v-icon>mdi-email-send</v-icon>
                        </v-btn>
                      </template>
                      <span>Register Email Send</span>
                    </v-tooltip>
                  </td>
                  <td>
                    <b>Name: </b> {{ singleData.name }} <br />
                    <b>Department: </b> {{ singleData.department }} <br />
                    <b>Office ID: </b> {{ singleData.office_id }} <br />
                    <b>Office: </b> {{ singleData.office }} <br />
                    <b>Business Unit: </b> {{ singleData.business_unit }} <br />
                    <!-- Manager ID Selected -->
                    <span v-if="singleData.manager_id">
                      <b>Manager: </b>
                      <!-- {{ singleData.manager_id }}  -->
                      <span>
                        <span
                          v-for="item in manegerData(singleData.manager_id)"
                          :key="item.id"
                        >
                          <v-btn
                            @click="currentUserView(item)"
                            small
                            outlined
                            class="mx-1"
                          >
                            {{ item.name }}</v-btn
                          >
                        </span>
                      </span>
                    </span>
                    <!-- Manager Email have -->
                    <span v-else-if="singleData.manager_emails">
                      <b>Manager Emails: </b> {{ singleData.manager_emails }}
                    </span>
                    <!-- Manager Not selected -->
                    <span v-else>
                      <b>Manager:</b>
                      <span class="text-danger">Not Selected</span>
                    </span>

                    <div>
                      <b>Last Login:</b>
                      <span
                        v-if="singleData.last_login"
                        class="success--text"
                        >{{
                          singleData.last_login.created_at
                            | moment("MMM Do, YYYY , h:mm:ss a")
                        }}</span
                      >
                      <span v-else class="error--text">N/A</span>
                    </div>
                  </td>

                  <td>
                    <span v-if="singleData.roles.length">
                      <span
                        v-for="(role, index) in singleData.roles"
                        :key="index"
                      >
                        <span class="pa-1 m-1 rounded-pill small"
                          >{{ role.name }},
                        </span>
                      </span>
                    </span>
                    <span v-else>
                      <span class="text-danger">You have no roles</span>
                    </span>
                  </td>

                  <td>
                    <!-- Admin Access -->
                    <div class="m-1">
                      <v-btn
                        v-if="singleData.admin == 1"
                        @click="statusChangeAdmin(singleData)"
                        outlined
                        elevation="10"
                        color="green darken-2"
                      >
                        <v-icon left>mdi-check-decagram</v-icon> Admin
                      </v-btn>
                      <v-btn
                        v-else
                        @click="statusChangeAdmin(singleData)"
                        outlined
                        elevation="10"
                        color="red accent-2"
                      >
                        <v-icon left>mdi-close-octagon</v-icon> Admin
                      </v-btn>
                    </div>
                    <!-- User Access -->
                    <div class="m-1">
                      <v-btn
                        v-if="singleData.user == 1"
                        @click="statusChangeUser(singleData)"
                        outlined
                        elevation="10"
                        color="green darken-2"
                      >
                        <v-icon left>mdi-check-decagram</v-icon> User
                      </v-btn>
                      <v-btn
                        v-else
                        @click="statusChangeUser(singleData)"
                        outlined
                        elevation="10"
                        color="red accent-2"
                      >
                        <v-icon left>mdi-close-octagon</v-icon> User
                      </v-btn>
                    </div>

                    <hr />
                    <div>
                      <span v-if="singleData.status == 1" class="text-success"
                        >Active</span
                      >
                      <span v-else class="text-danger">Blocked</span>
                      <span
                        class="text-muted small float-right"
                        v-if="singleData.status_by"
                        >--{{ userNameByID(singleData.status_by) }}</span
                      >
                    </div>

                    <div>
                      <span v-if="singleData.verify == 1" class="text-success"
                        >Verified</span
                      >
                      <span v-else class="text-danger">Not Verified</span>
                      <span
                        class="text-muted small float-right"
                        v-if="singleData.verify_by"
                        >--{{ userNameByID(singleData.verify_by) }}</span
                      >
                    </div>
                  </td>

                  <td>
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
                      @click="editRoleModel(singleData)"
                      small
                      elevation="10"
                      class="mb-1"
                    >
                      <v-icon>mdi-alpha-r-circle-outline</v-icon> Role
                    </v-btn>

                    <div class="small text-muted mt-3">
                      <b>Updated At:</b>
                      <span v-if="singleData.updated_at">{{
                        singleData.updated_at | moment("MMMM Do, YYYY")
                      }}</span>
                      <span v-else class="error--text">N/A</span>
                    </div>
                    <div class="small text-muted">
                      <b>Created At:</b>
                      <span v-if="singleData.created_at">{{
                        singleData.created_at | moment("MMMM Do, YYYY")
                      }}</span>
                      <span v-else class="error--text">N/A</span>
                    </div>
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
      </div>
    </div>

    <!--Role Assign Dilog  Modal -->
    <v-dialog v-model="roleModelShow" persistent scrollable>
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10"> Assign Global Roles </v-col>
            <v-col cols="2">
              <v-btn
                @click="roleModelShow = false"
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
          <v-row>
            <!-- {{ currentRoles }} -->
            <v-col
              class="pa-0"
              cols="3"
              v-for="(role, index) in allRoles"
              :key="index"
            >
              <v-checkbox
                v-model="currentRoles"
                :label="role.name"
                color="indigo"
                :value="role.id"
                hide-details
              ></v-checkbox>
            </v-col>

            <v-btn
              @click="updateUserRole()"
              block
              blockdepressed
              :loading="roleUpdating"
              color="primary mt-10"
            >
              <v-icon left dark>mdi-circle-edit-outline</v-icon> Update
            </v-btn>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- user-create-compoment -->
    <!-- Single User Details  -->
    <v-dialog v-model="dataModalDialog" fullscreen scrollable>
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
          <form @submit.prevent="editmode ? updateData() : createData()">
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  type="text"
                  label="User AD ID"
                  :rules="[(v) => !!v || 'AD ID is required!']"
                  v-model="form.login"
                  required
                >
                </v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('login')"
                  v-html="form.errors.get('login')"
                />
              </v-col>

              <v-col cols="12" md="4">
                <v-text-field
                  type="text"
                  label="User Name"
                  :rules="[(v) => !!v || 'User Name is required!']"
                  v-model="form.name"
                  required
                >
                </v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('name')"
                  v-html="form.errors.get('name')"
                />
              </v-col>

              <v-col cols="12" md="4">
                <v-text-field
                  type="text"
                  label="User Department"
                  :rules="[(v) => !!v || 'Department is Missing!']"
                  v-model="form.department"
                >
                </v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('department')"
                  v-html="form.errors.get('department')"
                />
              </v-col>

              <v-col cols="12" md="4">
                <v-text-field
                  type="text"
                  label="User Office ID"
                  v-model="form.office_id"
                >
                </v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('office_id')"
                  v-html="form.errors.get('office_id')"
                />
              </v-col>

              <v-col cols="12" md="4">
                <v-text-field
                  type="text"
                  label="User Office Contact"
                  v-model="form.office_contact"
                >
                </v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('office_contact')"
                  v-html="form.errors.get('office_contact')"
                />
              </v-col>

              <v-col cols="12" md="4">
                <v-text-field
                  type="text"
                  label="User Personal Contact"
                  v-model="form.personal_contact"
                >
                </v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('personal_contact')"
                  v-html="form.errors.get('personal_contact')"
                />
              </v-col>

              <v-col cols="12" md="4">
                <v-text-field
                  type="email"
                  label="User Office Email"
                  :rules="[(v) => /.+@.+/.test(v) || 'E-mail must be valid']"
                  v-model="form.office_email"
                ></v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('office_email')"
                  v-html="form.errors.get('office_email')"
                />
              </v-col>

              <v-col cols="12" md="4">
                <v-text-field
                  type="email"
                  label="User Personal Email"
                  :rules="[(v) => /.+@.+/.test(v) || 'E-mail must be valid']"
                  v-model="form.personal_email"
                ></v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('personal_email')"
                  v-html="form.errors.get('personal_email')"
                />
              </v-col>

              <v-col cols="12" md="4">
                <v-text-field
                  type="text"
                  label="User Office Location"
                  :rules="[(v) => !!v || 'Office Location is Missing!']"
                  v-model="form.office"
                >
                </v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('office')"
                  v-html="form.errors.get('office')"
                />
              </v-col>

              <v-col cols="12" md="4">
                <v-text-field
                  type="text"
                  label="User Business Unit"
                  :rules="[(v) => !!v || 'Business Unit is Missing!']"
                  v-model="form.business_unit"
                >
                </v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('business_unit')"
                  v-html="form.errors.get('business_unit')"
                />
              </v-col>

              <v-col cols="12" md="4">
                <v-file-input
                  :rules="imageRules"
                  accept="image/png, image/jpeg, image/bmp"
                  placeholder="Pick an image"
                  prepend-icon="mdi-camera"
                  label="Choose Image"
                  @change="uploadImageByName($event, 'image')"
                ></v-file-input>
                <div
                  color="red"
                  v-if="form.errors.has('image')"
                  v-html="form.errors.get('image')"
                />
              </v-col>

              <v-col cols="12" md="2">
                <v-img
                  :src="showImageByName('image')"
                  class="rounded rounded-circle"
                  height="100px"
                  width="100px"
                  alt="Image"
                />
              </v-col>

              <v-col cols="12" md="3">
                <v-radio-group
                  label="Account Status"
                  v-model="form.status"
                  row
                  required
                >
                  <v-radio label="Active" color="success" :value="1"></v-radio>
                  <v-radio label="Blocked" color="red" :value="0"></v-radio>
                </v-radio-group>
              </v-col>

              <v-col cols="12" md="3">
                <label>User Type</label>
                <div class="d-flex">
                  <v-checkbox
                    v-model="form.user"
                    color="success"
                    label="User"
                    :value="1"
                    class="mr-3"
                  >
                  </v-checkbox>
                  <v-checkbox
                    v-model="form.admin"
                    color="indigo"
                    label="Admin"
                    :value="1"
                  >
                  </v-checkbox>
                </div>
              </v-col>
            </v-row>

            <!-- Start Manager Selection -->
            <hr />
            <v-row>
              <div class="m-auto">
                <v-radio-group
                  row
                  v-model="radioBtnSeelected"
                  @change="managerSelectBy()"
                >
                  <v-radio
                    label="Manager Select By ID"
                    color="success"
                    value="managerById"
                  ></v-radio>
                  <v-radio
                    label="Or Manul Input Email Address"
                    color="indigo"
                    value="managerByEmail"
                  >
                  </v-radio>
                </v-radio-group>
              </div>

              <div
                class="col-md-12 text-center mb-1"
                :class="{ hide: !managerByIdShow }"
              >
                <span v-if="selectedManagerName.length > 0">
                  <span v-for="item in selectedManagerName" :key="item">
                    <span class="px-1 mx-1 info rounded text-white">{{
                      item
                    }}</span>
                  </span>
                </span>
                <span v-else class="text-danger">Not Selected</span>
              </div>

              <div
                class="col-md-12 text-center"
                :class="{ hide: !managerByIdShow }"
              >
                <v-btn @click="managerSelectComponent()" color="info">
                  <v-icon left>mdi-select-search</v-icon> Select Manager
                </v-btn>
              </div>
              <div
                class="col-md-12"
                id="managerByEmailShow"
                :class="{ hide: !managerByEmailShow }"
              >
                <v-text-field
                  type="text"
                  label="User Manager Emails"
                  v-model="form.manager_emails"
                >
                </v-text-field>
                <div
                  class="text-danger"
                  v-if="form.errors.has('manager_emails')"
                  v-html="form.errors.get('manager_emails')"
                />
              </div>
            </v-row>
            <hr />
            <!-- End Manager Selection -->
            <v-row>
              <v-col
                class="pa-0"
                cols="3"
                v-for="(role, index) in allRoles"
                :key="index"
              >
                <v-checkbox
                  v-model="currentRoles"
                  :label="role.name"
                  color="indigo"
                  :value="role.id"
                  hide-details
                ></v-checkbox>
              </v-col>
            </v-row>
            <hr />

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
          </form>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- manager-select -->
    <manager-select
      v-if="managerSelectComponentShow"
      :key="managerModalKey"
      :children-request="letParentResponse"
      :selected_id="form.manager_id"
      :user_full_list="fullUserList"
    ></manager-select>

    <!-- user-details -->
    <user-details
      v-if="CurrentUserData"
      :userData="CurrentUserData"
      :key="userDetailsDialogKey"
    ></user-details>

    <v-overlay :value="overlayshow" z-index="9999">
      <v-progress-circular indeterminate size="64">
        <v-icon>mdi-email</v-icon>
      </v-progress-circular>
    </v-overlay>
  </div>
</template>


<script>
// vform
import Form from "vform";

import allJsMethods from "./indexMethods";

import ManagerSelec from "./manager_select.vue";
import userMethods from "./js/methods";
import userTblData from "./js/data";
import userFormFields from "./js/userFormField";

// User Details Show By Dialog
import userDetails from "./details/user_details.vue";
import userDetailsData from "./details/js/data";
import userDetailsMethods from "./details/js/methods";

export default {
  components: {
    "manager-select": ManagerSelec,
    "user-details": userDetails,
  },

  data() {
    return {
      //current page url
      currentUrl: "/super_admin/user",

      radioBtnSeelected: "managerById",
      managerByIdShow: true,
      managerByEmailShow: false,
      // Manager Select
      managerSelectDilog: false,

      // Manager Component
      managerSelectComponentShow: false,
      managerModalKey: "",
      selectedManager: [],
      selectedManagerName: [],

      allRoles: {},
      currentRoles: [],
      currentRoleId: null,
      roleUpdating: false,
      roleModelShow: false,

      // userData
      ...userTblData,

      // userFormFields
      ...userFormFields,

      singleUserModalShow: false,
      singleUserModalData: {},

      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+/.test(v) || "E-mail must be valid",
      ],
      imageRules: [
        (v) => !!v || "Image is required",
        (v) => !v || v.size < 2000000 || "Image size should be less than 2 MB!",
      ],

      // Current User Show By Dilog
      ...userDetailsData,

      fullUserList: "",
      overlayshow: false,
    };
  },

  methods: {
    // All JS Methods
    ...allJsMethods,

    //managerSelectComponentShow
    managerSelectComponent() {
      this.managerModalKey++;
      this.managerSelectComponentShow = true;
    },

    // letParentResponse()
    letParentResponse(request) {
      this.selectedManagerName = request.manager_name;
      // this.selectedManager = request.manager_id
      this.form.manager_id = request.manager_id;
      // this.setManager()
      console.log(
        "parent Response",
        request.manager_name,
        request.manager_id,
        request,
        this.form.manager_id
      );
    },

    // CurrentUserData
    ...userDetailsMethods,

    // resendRegisterMail
    resendRegisterMail(val) {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to resend registered email !",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Resend Email",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          this.overlayshow = true;
          axios
            .get("/super_admin/register/register_mail_send/" + val)
            .then((response) => {
              this.overlayshow = false;
              Swal.fire({
                icon: "success",
                title: response.data,
              });
            })
            .catch((error) => {
              this.overlayshow = false;
              console.log(error);
            });
        }
      });
    },
  },

  mounted() {
    setTimeout(() => {
      // Get Roles
      this.getRoles();
      // All ZoneOffices
      this.getZoneOffices();
      //getDepartments
      this.getDepartments();
    }, 1000);
  },

  created() {
    this.$Progress.start();
    // Fetch initial results
    this.getResults();
    this.getFullList();
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
