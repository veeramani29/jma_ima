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
              <h1>Post Your Query</h1>
              <div class="mttl-line"></div>
            </div>
            <p>
              One of our research associate will get back to you within 2
              business working days, please leave your query below in the
              description box and hit submit tab at the bottom. We work Mon-Fri:
              8:00am - 5:30pm IST hours.
            </p>
            <v-form ref="form" v-model="valid" :lazy-validation="lazy">
              <v-textarea
                filled
                :rules="[v => !!v || 'Please enter your query.']"
                label="Your query"
                required
              ></v-textarea>
              <v-btn :disabled="!valid" color="primary">Submit</v-btn>
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
    lazy: false
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
