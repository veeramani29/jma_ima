<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="2">
        <LeftNavigation />
      </v-col>
      <v-col cols="12" sm="7">
        <div class="userLogin">
          <v-card>
            <div class="main-title">
              <h1>Thank you for requesting forgot password</h1>
              <div class="mttl-line"></div>
            </div>
            <p>
              <b>Dear Mohammed,</b>
            </p>
            <p>
              We have sent your login credentials to
              <b>m.yousuff@japanmacroadvisors.com.</b>
            </p>
            <p>
              If you are still having problem logging into your account, please
              write to us to
              <b></b> .
            </p>
            <p>
              Thanks,
              <br />IMA Team.
            </p>
          </v-card>
        </div>
      </v-col>
      <v-col cols="12" sm="3">
        <RightSideBar />
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import LeftNavigation from "@/components/shared/leftNavigation";
import RightSideBar from "@/components/shared/rightSideBar";
export default {
  components: {
    LeftNavigation,
    RightSideBar
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
