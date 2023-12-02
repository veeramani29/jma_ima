<template>
  <v-content>
    <v-container>
      <v-row>
        <v-col sm="2">
          <LeftNavigation />
        </v-col>
        <v-col sm="10">
          <v-card>
            <v-tabs v-model="tab" icons-and-text class="maTabHea">
              <v-tabs-slider></v-tabs-slider>

              <v-tab href="#tab-1">
                Profile
                <v-icon>mdi-briefcase-edit-outline</v-icon>
              </v-tab>

              <v-tab href="#tab-2">
                Change Password
                <v-icon>mdi-lock-reset</v-icon>
              </v-tab>

              <v-tab href="#tab-3">
                Manage Subscription
                <v-icon>mdi-account-star-outline</v-icon>
              </v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
              <v-tab-item value="tab-1">
                <v-card flat>
                  <v-card-text>
                    <v-simple-table v-show="proDetails">
                      <template v-slot:default>
                        <tbody>
                          <tr>
                            <td>Email</td>
                            <td>m.yousuff@japanmacroadvisors.com</td>
                          </tr>
                          <tr>
                            <td>Given name</td>
                            <td>Mohammed</td>
                          </tr>
                          <tr>
                            <td>Surname</td>
                            <td>Yousuff</td>
                          </tr>
                          <tr>
                            <td>Country</td>
                            <td>India</td>
                          </tr>
                          <tr>
                            <td>Phone</td>
                            <td>N/A</td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                    <v-form ref="form" v-model="valid" lazy-validation v-show="proEdit">
                      <v-row>
                        <v-col sm="6">
                          <v-text-field v-model="email" label="E-mail" readonly></v-text-field>
                        </v-col>
                        <v-col sm="6">
                          <v-text-field
                            v-model="fName"
                            :rules="[v => !!v || 'Given Name required']"
                            label="Given Name"
                            required
                          ></v-text-field>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col sm="4">
                          <v-text-field
                            v-model="lName"
                            :rules="[v => !!v || 'Surname required']"
                            label="Surname"
                            required
                          ></v-text-field>
                        </v-col>
                        <v-col sm="4">
                          <v-select
                            v-model="countryName"
                            :items="items"
                            :rules="[v => !!v || 'Item is required']"
                            label="Country"
                            required
                          ></v-select>
                        </v-col>
                        <v-col cols="12" sm="4">
                          <vue-tel-input v-model="phoneNumber" enabledCountryCode></vue-tel-input>
                        </v-col>
                      </v-row>

                      <v-btn :disabled="!valid" color="success" class="mr-4">Save</v-btn>
                      <v-btn color="secondary" @click="proToggle()">Cancel</v-btn>
                    </v-form>
                    <div class="text-right" v-show="editBtn">
                      <v-btn text color="primary" @click="proToggle()">Edit Profile</v-btn>
                    </div>
                  </v-card-text>
                </v-card>
              </v-tab-item>
              <v-tab-item value="tab-2">
                <v-card flat>
                  <v-card-text>
                    <v-row class="justify-center">
                      <v-col sm="6">
                        <v-form ref="changePassword" v-model="formChaPas" lazy-validation>
                          <v-text-field
                            v-model="curPassword"
                            :rules="[v => !!v || 'Please Enter Current Password']"
                            label="Current Password"
                            required
                            type="password"
                          ></v-text-field>
                          <v-text-field
                            v-model="newPassword"
                            :rules="[v => !!v || 'Please Enter New Password']"
                            label="New Password"
                            required
                            type="password"
                          ></v-text-field>
                          <v-text-field
                            v-model="conPassword"
                            :rules="[v => !!v || 'Please Enter Confirm Password']"
                            label="Confirm Password"
                            required
                            type="password"
                          ></v-text-field>
                          <v-btn :disabled="!formChaPas" color="success">Validate</v-btn>
                        </v-form>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-tab-item>
              <v-tab-item value="tab-3">
                <v-card flat class="manAccount">
                  <v-card-text>
                    You have been our registered user since Apr 20, 2017.
                    <h3 class="maSubt">
                      Subscription type :
                      <v-icon color="success">mdi-account</v-icon>Free
                    </h3>
                    <v-card class="maSubPan">
                      <v-card-text>
                        <h3 class="maUpgs">
                          Upgrade your subscription to:
                          <v-btn color="primary">
                            <v-icon>mdi-account-star</v-icon>Premium
                          </v-btn>
                        </h3>
                        <div class="maUpgrade">
                          <v-btn color="success" to="/do_payment">Upgrade</v-btn>
                        </div>
                      </v-card-text>
                    </v-card>
                    <p>
                      If you would like to cancel your Free subscription, contact
                      <a
                        href="mailto:support@indiamacroadvisors.com"
                      >support</a> or submit your query to
                      <a
                        href="http://indiamacroadvisors.com/helpdesk/post/"
                      >Help Desk.</a>
                    </p>
                  </v-card-text>
                  <!-- active user -->
                  <v-card-text>
                    <div class="sub-title sub-title2">
                      <div class="ttl_sec2">You have been our registered user since Apr 20, 2017.</div>
                      <h5>Your Subscription Information</h5>
                      <div class="sttl-line"></div>
                    </div>
                    <v-data-table :headers="headers" :items="desserts" hide-default-footer></v-data-table>
                    <p>Your account will auto-renew on Jan 02, 1970.</p>
                    <p>
                      If you would like to cancel your Premium subscription, please click
                      <router-link to="/cancel_subscription">revert to free account.</router-link>
                    </p>
                    <p> 
                      For any assistance, feel free to contact us at
                      <a href="mailto:support@indiamacroadvisors.com">support@indiamacroadvisors.com</a> or submit your query to
                      <router-link to="/help_desk">Help Desk.</router-link>
                    </p>
                    <p></p>
                  </v-card-text>
                </v-card>
              </v-tab-item>
            </v-tabs-items>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-content>
</template>
<script>
import LeftNavigation from "@/components/shared/leftNavigation";
import { VueTelInput } from "vue-tel-input";
export default {
  components: {
    LeftNavigation,
    VueTelInput
  },
  data() {
    return {
      tab: null,
      text:
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
      valid: true,
      email: "mohammedyousuff1990@gmail.com",
      fName: "Mohammed",
      lName: "Yousuff",
      items: ["Item 1", "Item 2", "Item 3", "Item 4"],
      phoneNumber: "",
      countryName: "",
      proDetails: true,
      proEdit: false,
      editBtn: true,
      formChaPas: true,
      conPassword: "",
      newPassword: "",
      curPassword: "",
      headers: [
        {
          text: "Subscription Type",
          value: "type"
        },
        { text: "Amount", value: "amount" },
        { text: "Auto renew", value: "renew" },
        { text: "Status", value: "status" }
      ],
      desserts: [
        {
          type: 1,
          amount: "April 2019-20",
          renew: "June 30, 2019",
          status: "active"
        },
        {
          type: 1,
          amount: "May 2019-20",
          renew: "July 30, 2019",
          status: "deactive"
        }
      ]
    };
  },
  methods: {
    proToggle() {
      this.proDetails = !this.proDetails;
      this.proEdit = !this.proEdit;
      this.editBtn = !this.editBtn;
    }
  }
};
</script>
<style lang="scss">
@import "@/assets/_variables.scss";
.manAccount {
  .maSubt {
    margin: 30px 0;
    .v-icon {
      font-size: 21px;
      margin-right: 5px;
    }
  }
  .maUpgs {
    margin-left: 10px;
    .v-btn {
      margin-left: 15px;
    }
  }
  .maUpgrade {
    text-align: center;
    margin-top: 15px;
  }
  .maSubPan {
    margin-bottom: 20px;
  }
}
.maTabHea.v-tabs > .v-tabs-bar {
  background-color: $lGray;
}
</style>