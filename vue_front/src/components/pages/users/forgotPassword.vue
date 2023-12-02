<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="2">
        <LeftNavigation />
      </v-col>
      <v-col cols="12" sm="10">
        <div class="userLogin">
          <v-row>
            <v-col cols="12" sm="8">
              <v-card>
                <div class="main-title">
                  <h1>Forgot Password</h1>
                  <div class="mttl-line"></div>
                </div>
                <p>
                  Please enter your email address to retrieve your password.
                </p>
                <v-form ref v-model="forgotPassword" :lazy-validation="lazy">
                  <v-text-field
                    v-model="regEmail"
                    :rules="emailRules"
                    label="E-mail ID"
                    required
                  ></v-text-field>
                  <v-btn
                    :disabled="!forgotPassword"
                    color="success"
                    class="mt-4"
                    @click="validate"
                    >Submit</v-btn
                  >
                </v-form>
              </v-card>
            </v-col>
          </v-row>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import LeftNavigation from "@/components/shared/leftNavigation";
export default {
  components: {
    LeftNavigation
  },
  data() {
    return {
      forgotPassword: false,
      lazy: false,
      password: "",
      regEmail: "",
      emailRules: [
        v => !!v || "E-mail is required",
        v => /.+@.+/.test(v) || "E-mail must be valid"
      ]
    };
  }
};
</script>
<style lang="scss">
.userLogin {
  .v-card {
    padding: 25px;
  }
}
</style>
