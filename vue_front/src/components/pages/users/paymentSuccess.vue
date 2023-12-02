<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="2">
        <LeftNavigation />
      </v-col>
      <v-col cols="12" sm="10">
        <div class="regSuccessfull">
          <v-card>
            <div class="main-title">
              <h1>Payment Successful</h1>
              <div class="mttl-line"></div>
            </div>
            <p>
              <b>Dear Mohammed Yousuff,</b>
            </p>
            <p>
              Your subscription has been upgraded to Premium. You can continue
              to access your saved charts and other premium content.
              <br />Your account subscription will renew automatically every
              month.
            </p>
            <p>
              If you face any difficulties, please contact
              <a href="mailto:support@indiamacroadvisors.com."
                >support@indiamacroadvisors.com.</a
              >
            </p>
            <p>
              Thank you,
              <br />India Macro Advisors
            </p>
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
  data() {
    return {};
  }
};
</script>
<style lang="scss">
@import "@/assets/_variables.scss";
.regSuccessfull {
  .v-card {
    padding: 25px;
  }
}
</style>
