<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="2">
        <LeftNavigation />
      </v-col>
      <v-col cols="12" sm="10">
        <div class="userLogin">
          <v-card>
            <div class="main-title">
              <h1>Downgrading your account to Free</h1>
              <div class="mttl-line"></div>
            </div>
            <p>
              We hope you enjoyed the timely updates on Indian economy and the
              use of My Charts functions.
            </p>
            <p>
              Below are details on what would happen to premium contents you
              have used when you revert to Free account user.
            </p>
            <div class="sub-title">
              <h5>What would happen to My Charts?</h5>
              <div class="sttl-line"></div>
            </div>
            <p>
              Even when you cancel your Premium account, you will continue to
              have access to all the My Charts functions. But you can only use
              one folder and up to 1 page. We will keep the default folder in
              the first position in the My Charts menu. Please note that
              deletion of other folders are permanent. All other folders you did
              not delete but not in the first position will become inaccessible
              but you can re-access them if you become our Premium account user
              again.
            </p>
            <div class="sub-title">
              <h5>What would happen when I upgrade back?</h5>
              <div class="sttl-line"></div>
            </div>
            <p>
              All the premium contents will be waiting for you when need them.
              When you re-upgrade to a paid-plan, you will regain access to all
              the contents you lost access to when you became a Free account
              user.
            </p>
            <div class="sub-title">
              <h5>What would happen to my billing?</h5>
              <div class="sttl-line"></div>
            </div>
            <p>
              Once you downgrade to Free, your account will immediately change
              to a Free account and you will not be charged afterward while you
              remain a Free account user.
            </p>
            <v-form ref="form" v-model="valid" :lazy-validation="lazy">
              <v-checkbox
                v-model="checkbox"
                :rules="[v => !!v || 'You must agree to continue!']"
                label="I read everything above and I would like to downgrade my account to Free."
                required
              ></v-checkbox>
              <v-btn color="primary" class="mr-4">Cancel</v-btn>
              <v-btn :disabled="!valid" color="primary"
                >Downgrad to Free user</v-btn
              >
            </v-form>
          </v-card>
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
  data: () => ({
    valid: true,
    lazy: false,
    checkbox: false
  })
};
</script>
<style lang="scss">
.userLogin {
  .v-card {
    padding: 25px;
  }
}
</style>
