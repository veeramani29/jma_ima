<template>
  <v-app>
    <Header />
    <v-content>
      <router-view></router-view>
    </v-content>
    <Footer />
    <myChartsToggle />
  </v-app>
</template>

<script>
import Header from "./components/shared/header";
import Footer from "@/components/shared/footer";
import myChartsToggle from "@/components/shared/charts/myChartsToggle";
export default {
  name: "App",
  components: {
    Header,
    Footer,
    myChartsToggle
  },

  data() {
    return {};
  }
};
</script>
<style lang="scss">
@media (min-width: 1264px) {
  .container {
    max-width: 1230px;
  }
}
</style>
