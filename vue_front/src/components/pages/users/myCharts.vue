<template>
  <v-content>
    <Banner />
    <v-container>
      <v-row>
        <v-col cols="12">
          <v-tabs v-model="tab" text right class="mychTabs">
            <v-tabs-slider></v-tabs-slider>
            <v-tab href="#tab-large">
              <v-icon>mdi-view-grid</v-icon>Large
            </v-tab>
            <v-tab href="#tab-2">
              <v-icon>mdi-format-list-bulleted-square</v-icon>List
            </v-tab>
            <v-tab href="#tab-3">
              <v-icon>mdi-grid</v-icon>Small
            </v-tab>
          </v-tabs>

          <v-tabs-items v-model="tab" class="mcTabItems">
            <v-tab-item value="tab-large">
              <div class="main-title">
                <h1 class="folder-title">aaaaaaa</h1>
                <div class="mttl-line"></div>
              </div>
              <div class="mclBtns">
                <v-btn small color="primary">
                  <v-icon>mdi-download</v-icon>Export to Powerpoint
                </v-btn>
                <v-btn small color="primary">
                  <v-icon>mdi-printer</v-icon>Print
                </v-btn>
              </div>
              <div class="sec-title">
                <h1 class>PAGE 1</h1>
                <div class="sttl-line"></div>
              </div>
              <v-row>
                <v-col sm="6">
                  <div class="sub-title">
                    <h5 class="exhibit-title">Congress - Total number of Tweets</h5>
                    <div class="sttl-line"></div>
                  </div>
                  <Chart />
                </v-col>
                <v-col sm="6">
                  <div class="sub-title">
                    <h5 class="exhibit-title">Congress - Total number of Tweets</h5>
                    <div class="sttl-line"></div>
                  </div>
                  <Chart />
                </v-col>
              </v-row>
            </v-tab-item>
            <v-tab-item v-for="i in 3" :key="i" :value="'tab-' + i">
              <v-card flat>
                <v-card-text>{{ text }}</v-card-text>
              </v-card>
            </v-tab-item>
          </v-tabs-items>
        </v-col>
      </v-row>
    </v-container>
  </v-content>
</template>
<script>
import Banner from "@/components/banners/myCharts";
import Chart from "@/components/shared/charts/myChart";
export default {
  components: {
    Banner,
    Chart
  },
  data() {
    return {
      tab: null,
      text:
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
    };
  }
};
</script>
<style lang="scss">
.mychTabs {
  .v-tab {
    font-size: 12px;
    padding: 0 10px;
    .v-icon {
      font-size: 17px;
      padding-right: 5px;
    }
  }
  .v-tabs-bar {
    height: 37px;
  }
  &.v-tabs > .v-tabs-bar {
    background-color: transparent;
  }
}
.mcTabItems {
  &.v-tabs-items {
    background-color: transparent;
  }
  .mclBtns {
    text-align: right;
    margin-bottom: 15px;
    .v-btn {
      margin-left: 10px;
    }
    .v-icon {
      font-size: 17px;
      padding-right: 5px;
    }
  }
  .sec-title h1 {
    font-size: 18px;
    padding-bottom: 5px;
  }
  .exhibit-title {
    font-size: 17px;
    padding-bottom: 4px;
    margin-bottom: 21px;
  }
}
</style>
