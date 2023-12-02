<template>
  <div>
    <v-card>
      <v-card-title>User Edit</v-card-title>
      <v-card-actions>
        <v-snackbar v-model="snackbar">
            {{ notification }}
          <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-form class="col-12" ref="form" v-model="valid" lazy-validation autocomplete="false">
          <v-container>
            <v-row>
              <v-col cols="12" sm="4">
                <v-select v-model="company" name="company_name" id="id" :items="companyList" item-text="company_name" item-value="id" label="Company" :hint="companyHint"></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-select
                  v-model="userTitle"
                  :items="userTitleList"
                  label="User Title"
                  :rules="[v => !!v || 'Please enter Title']"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="firstName"
                  label="First Name"
                  :rules="[v => !!v || 'Please enter First Name']"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="lastName"
                  label="Last Name"
                  :rules="[v => !!v || 'Please enter Last Name']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="userEmail"
                  label="Email"
                  :rules="[v => !!v || 'Please enter Email']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="password"
                  :append-icon="typePassword ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="typePassword ? 'text' : 'password'"
                  label="Password"
                  :rules="[v => !!v || 'Please enter Password']"
                  @click:append="typePassword = !typePassword"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-select v-model="country" name="country_name" id="country_id" :items="countryList" item-text="country_name" item-value="country_id" label="Country"></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field label="Phone/Mobile" v-model="mobileNumber" type="number"></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-select v-model="userType" name="type_name" id="id" :items="userTypeList" item-text="type_name" item-value="id" label="User Type"></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-select v-model="userStatus" name="status_name" id="id" :items="userStatusList" item-text="status_name" item-value="id" label="User Status"></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-menu
                  v-model="menu2"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="date"
                      label="Expiry On"
                      prepend-icon="event"
                      readonly
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="date" @input="menu2 = false"></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="4">
                <v-select v-model="postAlert" name="text" id="value" :items="postAlertList" item-text="text" item-value="value"  label="New post alert"></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-select v-model="emailVerified" name="text" id="value" :items="emailVerifiedList" item-text="text" item-value="value" label="User email verified ?"></v-select>
              </v-col>
            </v-row>
          </v-container>
          <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit">Submit</v-btn>
          <v-btn color="error" class="mr-4" @click="reset">Reset Form</v-btn>
        </v-form>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  data: () => ({
    snackbar: false,
    notification: "Something went wrong",
    valid: true,
    companyHint: "Note: For corporate users only",
    firstName: "",
    lastName: "",
    userEmail: "",
    password: "",
    typePassword: false,
    mobileNumber: "",
    countryList: [],
    userTypeList: [],
    userStatusList: [],
    companyList: [],
    country: [],
    userType: [],
    userStatus: [],
    company: [],
    date:"",
    menu2: false,
    postAlert:[],
    emailVerified:[],
    userTitle:[],
    userTitleList: ["Mr","Miss","Mrs","Others"],
    postAlertList: [{text:"Yes",value:"Y"},{text:"No",value:"N"}],
    emailVerifiedList: [{text:"Yes",value:"Y"},{text:"No",value:"N"}],
  }),
  created() {
    const editComponent = {
      user_id: this.$route.params.id
    };
    this.axios.post(this.nodejsServer + "user/getEditUser", editComponent).then(response => {
      if(!response.data.err_code){
        this.company = response.data[0].company_id;
        this.country = response.data[0].country_id;
        this.firstName = response.data[0].fname;
        this.lastName = response.data[0].lname;
        this.userEmail = response.data[0].email;
        this.password = response.data[0].password;
        this.mobileNumber = response.data[0].phone;
        this.userStatus = response.data[0].user_status_id;
        this.userType = response.data[0].user_type_id;
        this.postAlert = response.data[0].user_post_alert;
        this.userTitle = response.data[0].user_title;
        this.emailVerified = response.data[0].email_verification;
        if(response.data[0].expiry_on != 0){
          var dateFormat =new Date(response.data[0].expiry_on*1000);
          this.date = dateFormat.getFullYear() + "-" + ("0"+(dateFormat.getMonth() + 1)).slice(-2) + "-"+("0"+dateFormat.getDate()).slice(-2);  
        }
      } else {
        this.notification = response.data.message;
        this.snackbar = true;
      }
    });
    this.axios.get(this.nodejsServer + "user/getUserType").then(response => {
      if(!response.data.err_code){
        this.userTypeList = response.data;
      } else {
        this.notification = response.data.message;
        this.snackbar = true;
      }
    });
    this.axios.get(this.nodejsServer + "user/getUserStatus").then(response => {
      if(!response.data.err_code){
        this.userStatusList = response.data;
      } else {
        this.notification = response.data.message;
        this.snackbar = true;
      }
    });
    this.axios.get(this.nodejsServer + "user/getCompany").then(response => {
      if(!response.data.err_code){
        this.companyList = response.data;
      } else {
        this.notification = response.data.message;
        this.snackbar = true;
      }
    });
    this.axios.get(this.nodejsServer + "user/getUserCountry").then(response => {
      if(!response.data.err_code){
        this.countryList = response.data;
      } else {
        this.notification = response.data.message;
        this.snackbar = true;
      }
    });
  },
  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true;
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    submit() {
      if (this.$refs.form.validate()) { 
        if(typeof this.country != "number")
          this.country = "";
        if(typeof this.company != "number")
          this.company = "";
        if(typeof this.userType != "number")
          this.userType = "";
        if(typeof this.userStatus != "number")
          this.userStatus = "";
        if(typeof this.emailVerified == "object")
          this.emailVerified = "";
        if(typeof this.postAlert == "object")
          this.postAlert = "";

          var expiryDate = "";
        if(this.date == ""){
          expiryDate = 0;
        } else {
          expiryDate = new Date(this.date).getTime() / 1000
        }
        const userData = {
          id: this.$route.params.id,
          company_id: this.company,
          user_title: this.userTitle,
          fname: this.firstName,
          lname: this.lastName,
          email: this.userEmail,
          password: this.password,
          country_id: this.country,
          phone: this.mobileNumber,
          user_type_id: this.userType,
          user_status_id: this.userStatus,
          expiry_on: expiryDate,
          user_post_alert: this.postAlert,
          email_verification: this.emailVerified,
        };
        this.insert = this.axios.post(this.nodejsServer + "user/updateUser", userData).then((response) => {
          if(!response.data.err_code){
            this.$router.push("/UserList");
          } else {
            this.notification = response.data.message;
            this.snackbar = true;
          }
        })
      }
    }
  }
};
</script>