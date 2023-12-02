<template>
  <v-app id="inspire">
    <div class="text-center">
      <v-dialog v-model="dialog" persistent width="500">
        <v-card>
          <v-card-title class="headline grey lighten-2" primary-title
            >Admin Login</v-card-title
          >

          <v-card-text>
            <v-form
              @submit.prevent="submit"
              ref="form"
              v-model="valid"
              lazy-validation
              autocomplete="false"
            >
              <v-text-field
                v-model="userName"
                label="User Name"
                name="login"
                prepend-icon="person"
                :rules="[v => !!v || 'Username Required']"
                type="text"
              />
              <v-text-field
                v-model="password"
                id="password"
                label="Password"
                name="password"
                prepend-icon="lock"
                :rules="[v => !!v || 'Password Required']"
                type="password"
              />
              <v-divider></v-divider>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn type="submit" color="primary" @click="submit"
                  >Login</v-btn
                >
              </v-card-actions>
            </v-form>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-snackbar v-model="snackbar">
            {{ notification }}
            <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
          </v-snackbar>
          <!-- <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-card-title color="primary" dark flat>Login form</v-card-title>
              <v-card-text></v-card-text>
              <v-divider></v-divider>
              <v-card-actions class="pr-4">
                <v-spacer />
              </v-card-actions>
            </v-card>
          </v-col>-->
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    userName: "",
    password: "",
    // loginResponse:"",
    loginStatus: "",
    snackbar: false,
    notification: "Something went wrong",
    dialog: true
  }),
  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true;
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    created() {},
    submit() {
      if (this.$refs.form.validate()) {
        const loginData = {
          user: this.userName,
          password: this.password
        };

        // this.$store.dispatch("login", { loginData });return false;
        this.axios
          .post(this.nodejsServer + "login/login", loginData)
          .then(response => {
            if (!response.data.err_code) {
              // console.log(response);
              if (typeof response.data.admin_data.admin_id == "number") {
                const response_data = response.data.admin_data;
                // localStorage.setItem("logged-inAdmin", response_data);
                localStorage.setItem("imaAdmins", response_data);
                localStorage.setItem("token", response.data.token);
                var currentDate = Math.round(new Date().getTime() / 1000);
                localStorage.setItem("time", currentDate + 24 * 3600);
                this.axios.defaults.headers.common["Authorization"] =
                  response.data.token;
                //this.$store.dispatch("saveData",  response_data );
                window.location.href =
                  this.env("VUE_APP_BASE_URL") + "postList";
                // this.$router.push("/postList");
                this.dialog = false;
              }
            } else {
              localStorage.removeItem("logged-inAdmin");
              sessionStorage.removeItem("imaAdmins");
              this.notification = response.data.message;
              this.snackbar = true;
            }
          });
      }
    }
  }
};
</script>
