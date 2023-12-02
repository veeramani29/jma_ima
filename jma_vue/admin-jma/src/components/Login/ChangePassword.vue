<template>
  <div>
    <v-card>
      <v-card-title>Change Password</v-card-title>
      <v-card-text>
        <v-form class="pt-0" ref="form" v-model="valid" lazy-validation autocomplete="false">
          <v-row>
            <v-snackbar v-model="snackbar">
              {{ notification }}
              <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
            </v-snackbar>
            <v-col cols="12" sm="4" class="pt-0">
              <v-text-field
                v-model="oldPassword"
                label="Old Password"
                :rules="[v => !!v || 'Please enter old password']"
                :append-icon="typePassword ? 'mdi-eye' : 'mdi-eye-off'"
                :type="typePassword ? 'text' : 'password'"
                @click:append="typePassword = !typePassword"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="4" class="pt-0">
              <v-text-field
                v-model="newPassword"
                label="New Password"
                :rules="[v => !!v || 'Please enter password']"
                :append-icon="typePassword ? 'mdi-eye' : 'mdi-eye-off'"
                :type="typePassword ? 'text' : 'password'"
                @click:append="typePassword = !typePassword"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="4" class="pt-0">
              <v-text-field
                v-model="confirmPassword"
                label="Confirm Password"
                :rules="[v => !!v || 'Please enter confirm password']"
                :append-icon="typePassword ? 'mdi-eye' : 'mdi-eye-off'"
                :type="typePassword ? 'text' : 'password'"
                @click:append="typePassword = !typePassword"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit">Update</v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
export default {
  data: () => ({
    snackbar: false,
    valid: true,
    notification: "Something went wrong",
    oldPassword: "",
    newPassword: "",
    confirmPassword: "",
    typePassword: false
  }),
  created() {},
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
      if (
        this.newPassword == this.confirmPassword &&
        this.$refs.form.validate()
      ) {
        const userData = {
          password: this.newPassword,
          oldPassword: this.oldPassword
        };
        this.axios
          .post(this.nodejsServer + "settings/changePassword", userData)
          .then(response => {
            if (!response.data.err_code) {
              this.notification = response.data;
              this.snackbar = true;
              // this.$router.push("/PostList");
            } else {
              this.notification = response.data.message;
              this.snackbar = true;
            }
          });
      } else {
        this.notification =
          "Confirm Password is not equal to your new passwword";
        this.snackbar = true;
      }
    }
  }
};
</script>