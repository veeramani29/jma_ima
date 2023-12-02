<template>
  <v-content>
    <v-dialog v-model="modalData" persistent max-width="690" class="modLogin">
      <v-card>
        <v-card-title class="headline">
          Login
          <v-spacer></v-spacer>
          <v-btn text @click="toggleModal()">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <p>
            This feature is available for registered users only. Please log-in to access our Save to
            <b>My Charts function.</b>
          </p>
          <div class="mlBtn">
            <v-btn small color="primary">
              <v-icon>mdi-linkedin</v-icon>Sign in
            </v-btn>
            <v-btn small color="primary">
              <v-icon>mdi-facebook</v-icon>Sign in
            </v-btn>
          </div>
          <div class="mlOr">OR</div>
          <v-form ref="form" v-model="valid" :lazy-validation="lazy">
            <v-row>
              <v-col cols="12" md="6">
                <v-text-field v-model="email" :rules="emailRules" label="E-mail" required></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="firstname"
                  :rules="passwordRules"
                  label="Password"
                  type="password"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-btn :disabled="!valid" color="primary" class="mr-4" @click="validate">Submit</v-btn>
                <router-link to="#">Forgot Password ?</router-link>
              </v-col>
            </v-row>
          </v-form>
          <div class="mlReg">
            Not registered?
            <br />
            <router-link to="#">
              Setup a
              <b>Free Account</b>
            </router-link>to access our services free of charge.
          </div>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="error" primary @click="toggleModal()">close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-content>
</template>
<script>
export default {
  data: () => ({
    valid: true,
    firstname: "",
    email: "",
    emailRules: [
      v => !!v || "E-mail is required",
      v => /.+@.+/.test(v) || "E-mail must be valid"
    ],
    passwordRules: [v => !!v || "Please enter Your password"],
    lazy: false
  }),
  computed: {
    modalData() {
      return this.$store.state.signInModal;
    }
  },
  methods: {
    toggleModal() {
      this.$store.state.signInModal = !this.$store.state.signInModal;
    },
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true;
      }
    }
  }
};
</script>
<style lang="scss">
.v-dialog .v-card__title .v-btn {
  padding-right: 0;
  min-width: unset;
}
</style>