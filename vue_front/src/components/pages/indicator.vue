<template>
  <v-content>
    <div class="sec-date main-title ind_maittl">
      <span class="released">December 12, 2019</span>
      <h1>Consumer Price Index (CPI)</h1>
      <div class="folussoc_con fus_indicator">
        <v-tooltip top>
          <template v-slot:activator="{ on }">
            <v-btn icon to="#" v-on="on">
              <v-icon>mdi-facebook</v-icon>
            </v-btn>
          </template>
          <span>Share on Facebook</span>
        </v-tooltip>
        <v-tooltip top>
          <template v-slot:activator="{ on }">
            <v-btn icon to="#" v-on="on">
              <v-icon>mdi-twitter</v-icon>
            </v-btn>
          </template>
          <span>Share on Twitter</span>
        </v-tooltip>
        <v-tooltip top>
          <template v-slot:activator="{ on }">
            <v-btn icon to="#" v-on="on">
              <v-icon>mdi-linkedin</v-icon>
            </v-btn>
          </template>
          <span>Share on Linkedin</span>
        </v-tooltip>
      </div>
      <div class="mttl-line"></div>
    </div>
    <h4>November CPI at 3-year high driven by surge in food prices; Core CPI continues to remain low.</h4>
    <ChartEdit />
  </v-content>
</template>
<script>
import ChartEdit from "../shared/charts/chartEdit";
export default {
  components: {
    ChartEdit
  }
};
</script>
<style lang="scss" scoped>
@import "@/assets/_variables.scss";
.ind_maittl {
  &.sec-date > h1 {
    float: left;
    border-bottom: 0;
    margin: 0;
  }
  .folussoc_con {
    border-bottom: 1px solid #ddd;
    text-align: right;
    padding: 5px 0;
    margin: 20px 0;
    .v-icon {
      font-size: 17px;
    }
    .mdi-facebook {
      color: #3b5998;
    }

    .mdi-twitter {
      color: #00acee;
    }

    .mdi-google-plus {
      color: #dd4b39;
    }

    .mdi-linkedin {
      color: #0e76a8;
    }
  }
}
</style>