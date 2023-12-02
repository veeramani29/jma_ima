<template>
  <v-content>
    <div class="main-title">
      <h1>
        {{shareChart}}
      </h1>
      <div class="mttl-line"></div>
    </div>
    <p>
      India's GDP growth further slowed down to 4.5% YoY in July-September
      quarter of Fiscal Year 2020. The decline in GDP for this quarter was
      primarily led by weak investment and contraction in export growth. At this
      backdrop, with growth in eight core industries contracting by 5.8% YoY for
      the third consecutive month in October and credit supply and domestic
      demand remaining lackluster, we believe the recovery in GDP is unlikely in
      October-December 2019. (November 29, 2019)
    </p>
    <router-link to="indicator">
      Click here for the full version of comments and chart functions.
    </router-link>
    <Chart />
    <div class="main-title">
      <h1>Recently updated pages</h1>
      <div class="mttl-line"></div>
    </div>
    <div class="sec-title sec-date">
      <span class="latest">Latest</span>
      <span class="released first">December 12, 2019</span>
      <h1>
        <router-link to="#" class="title-link"
          >Consumer Price Index (CPI)</router-link
        >
      </h1>
      <div class="sttl-line"></div>
    </div>
    <h5>
      November CPI at 3-year high driven by surge in food prices; Core CPI
      continues to remain low.
    </h5>
    <p>
      Indias' Consumer Price Index (CPI) for November rises to almost a three
      year high at 5.54% YoY driven by increasing food prices. On the other
      hand, the prices of the other components in the CPI basket either remained
      constant or increased only marginally. Thus, the pace of growth in core
      CPI continues to remain low.
    </p>
    <p>
      The prices of vegetables, which constitute about 13 percent of weightage
      in the food basket i...
    </p>
    <div class="text-right">
      <router-link to="#">Read More</router-link>
    </div>
  </v-content>
</template>
<script>
import Chart from "../shared/charts/chart";
export default {
  components: {
    Chart
  },
   data() {
    return {
      shareChart: "veera"
      }
      }
};
</script>
