<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="2">
        <LeftNavigation />
      </v-col>
      <v-col cols="12" sm="7">
        <div class="main-title">
          <h1>Sign Up</h1>
          <div class="mttl-line"></div>
        </div>
        <v-snackbar v-model="snackbar">
          {{ text }}
          <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-form
          ref="form"
          v-model="valid"
          :lazy-validation="lazy"
          class="regForm"
        >
          <v-radio-group v-model="userType" :mandatory="false">
            <v-bottom-navigation :value="activeBtn" color="primary">
              <v-btn>
                <span>Free</span>
                <v-icon>mdi-account</v-icon>
                <v-radio
                  name="userType"
                  type="radio"
                  v-bind:value="'free'"
                  checked>
                </v-radio>
              </v-btn>
              <v-btn>
                <span>Premium</span>
                <v-icon>mdi-account-star</v-icon>
                <v-radio   
                  name="userType"
                  type="radio"
                  v-bind:value="'premium'">
                </v-radio>
              </v-btn>
            </v-bottom-navigation>
          </v-radio-group>
          <v-row>
            <v-col cols="12" sm="2">
              <v-select
                v-model="user_title"
                :items="title"
                label="Title"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="5">
              <v-text-field
                v-model="firstname"
                :rules="nameRules"
                label="Given name *"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="5">
              <v-text-field
                v-model="surname"
                :rules="nameRules"
                label="Surname *"
                required
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <v-text-field
                v-model="email"
                :rules="emailRules"
                label="E-mail"
                required
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="6">
              <v-select
                v-model="countries"
                :items="countryList"
                item-text="country_name"
                item-value="country_id"
                label="Country"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="6">
              <v-select
                v-model="industry"
                :items="sector"
                item-text="user_industry_value"
                item-value="user_industry_id"
                label="Sector (pick one)"
              ></v-select>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="6">
              <v-select
                v-model="position"
                :items="jobFunction"
                item-text="user_position_value"
                item-value="user_position_id"
                label="Job function (pick one)"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="6">
              <!-- https://www.npmjs.com/package/vue-tel-input -->
              <vue-tel-input
                v-model="phoneNumber" v-on:country-changed="countryChanged"
                enabledCountryCode 
              ></vue-tel-input>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" class="rfCheck">
              <v-checkbox
                :value="agreeData"
                :rules="[v => !!v || 'You must agree to continue!']"
                label="Agree with"
                required
              ></v-checkbox>
              <v-btn text @click="toggleModal()">terms and Condition</v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <!--<vue-recaptcha ref="recaptcha"
                  @verify="onCaptchaVerified"
                  @expired="onCaptchaExpired"
                  sitekey="6LfiYNIUAAAAAAaAQS_rH7EboKkM5VsmDreYKIpd">
                <v-btn color="primary">Click me</v-btn>
              </vue-recaptcha>-->
            </v-col>
          </v-row>
          <v-row class="text-center">
            <v-col cols="12">
              <v-btn
                :disabled="!valid"
                color="success"
                class="mr-4"
                @click="validate"
                >Validate</v-btn
              >
              <v-btn color="error" class="mr-4" @click="reset"
                >Reset Form</v-btn
              >
            </v-col>
          </v-row>
        </v-form>
      </v-col>
      <v-col cols="12" sm="3">
        <RightSideBar />
      </v-col>
    </v-row>
    <Condition />
  </v-container>
</template>
<script>
import LeftNavigation from "@/components/shared/leftNavigation";
import RightSideBar from "@/components/shared/rightSideBar";
import Condition from "@/components/shared/modals/condition";
import { VueTelInput } from "vue-tel-input";
//import VueRecaptcha from "vue-recaptcha";
export default {
  components: {
    LeftNavigation,
    RightSideBar,
    VueTelInput,
    Condition,
    //VueRecaptcha
  },
  data() {
    return {
      valid: false,
      lazy: false,
      activeBtn: 0,
      title: ["Mr", "Mrs", "Miss", "Ms", "Dr", "Prof", "Sir", "Other"],
      firstname: "",
      surname: "",
      nameRules: [v => !!v || "Name is required"],
      email: "",
      emailRules: [
        v => !!v || "E-mail is required",
        v => /.+@.+/.test(v) || "E-mail must be valid"
      ],
      user_title: [],
      sector: [],
      jobFunction: [],
      position: null,
      industry: null,
      countryCode: ["+91", "+911"],
      mobileNumber: "",
      phoneNumber: "",
      //dialcode: VueTelInput.('getSelectedCountryData').dialCode,
      userType: "free",
      radios:"",
      countryList: [],
      countries: [],
      select: null,
      defaultIndicatorID: "",
      snackbar: false,
      text: "Thank you for successfully siging up"
    };
  },
  created() {
    this.axios.get(this.nodejsServer + "countryData/country").then(response => {
      this.countryList = response.data;
    });

    this.axios
      .get(this.nodejsServer + "sectorData/user_industry")
      .then(response => {
        this.sector = response.data;
      });

    this.axios
            .get(this.nodejsServer + "defaultIndicators")
            .then(response => {
                var defaultIndicators = '';
                response.data.map(function(i){
                    defaultIndicators += i.post_category_id +',';               
                });
                defaultIndicators = defaultIndicators.replace(/,\s*$/, "");
                this.defaultIndicatorID = defaultIndicators;
                //window.console.log(defaultIndicatorID);
              });
    this.axios
      .get(this.nodejsServer + "jobData/user_position")
      .then(response => {
        this.jobFunction = response.data;
      });
  },
  computed: {
    agreeData() {
      return this.$store.state.agreeTerm;
    },
    dataDynamic() {
      return this.$store.state.dynamicData;
    }
  },
  methods: {
    countryChanged(country) {
      this.country = country.dialCode
      //window.console.log(this.country);
    },
    rndStr(len) {
          let text = " "
          let chars = "abcdefghijklmnopqrstuvwxyz"

          for( let i=0; i < len; i++ ) {
          text += chars.charAt(Math.floor(Math.random() * chars.length))
          }

          return text;
		},
    validate() {
      if (this.$refs.form.validate()) {
       // this.$refs.recaptcha.execute();
          if(this.userType == 'free'){
            this.userType = 1;
          }else{
            this.userType = 2;
          }

        const postData = {
          user_title: this.user_title,
          fname: this.firstname,
          lname: this.surname,
          email: this.email,
          password: this.rndStr(8),
          country_id: this.countries,
          country_code: this.country,
          phone: this.phoneNumber,
          user_position_id: this.position,
          user_industry_id: this.industry,
          user_type_id: this.userType, //Free
          user_status_id: 4, //Inactive
          registered_on: Date.now(),
          expiry_on: 0,
          user_upgrade_status: "NU",
          want_to_email_alert: this.defaultIndicatorID
        };
        this.axios
          .post(this.nodejsServer + "register-submit/", postData)
          .then(response => {
            this.data = response.data;
            this.text = response.data;
            if(typeof this.text === "string" ){
              this.snackbar = true;
            }
            else{
              this.$store.state.dynamicData = response.data;
              this.$router.push("/registration_success");
            }
          })
          .catch(e => {
            this.errors.push(e);
          });
      }
    },
      /* onCaptchaVerified: function (recaptchaToken) {
      const self = this;
      self.status = "submitting";
      self.$refs.recaptcha.reset();
      axios.post("https://vue-recaptcha-demo.herokuapp.com/signup", {
        email: self.email,
        password: self.password,
        recaptchaToken: recaptchaToken
      }).then((response) => {
        self.sucessfulServerResponse = response.data.message;
      }).catch((err) => {
        self.serverError = getErrorMessage(err);


        //helper to get a displayable message to the user
        function getErrorMessage(err) {
          let responseBody;
          responseBody = err.response;
          if (!responseBody) {
            responseBody = err;
          }
          else {
            responseBody = err.response.data || responseBody;
          }
          return responseBody.message || JSON.stringify(responseBody);
        }

      }).then(() => {
        self.status = "";
      });


    },
    onCaptchaExpired: function () {
      this.$refs.recaptcha.reset();
    },*/
    toggleModal() {
      this.$store.state.termConModal = !this.$store.state.termConModal;
    },
    reset() {
      this.$refs.form.reset();
    }
  }
};
</script>
<style lang="scss">
@import "@/assets/_variables.scss";
.regForm {
  .v-input--radio-group--column {
    .v-input__control {
      width: 100%;
    }
    .v-radio {
      position: absolute;
      width: 100%;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }
    .v-bottom-navigation .v-btn {
      padding: 0;
    }
    .v-input__slot {
      overflow: hidden;
    }
    .v-input--selection-controls__input {
      width: 100%;
      height: 100%;
      opacity: 0;
    }
    .v-input--selection-controls__ripple {
      width: 100%;
      height: 100%;
    }
    .v-btn.v-btn--active {
      color: $primari-color;
    }
  }
  .rfCheck {
    display: flex;
    .v-input--selection-controls {
      margin-top: 0;
    }
    .v-btn:not(.v-btn--round).v-size--default {
      text-transform: capitalize;
      padding: 0 7px;
      height: 30px;
    }
  }
}
</style>
