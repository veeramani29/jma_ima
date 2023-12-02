<template>
  <v-content>
    <HomeBanner />
    <UserModel />
    <v-container>
      <v-row>
        <v-col sm="2">
          <LeftNavigation />
        </v-col>
        <v-col sm="7">
          <Home />
        </v-col>
        <v-col sm="3">
          <RightSideBar />
        </v-col>
      </v-row>
    </v-container>
  </v-content>
</template>
<script>
import HomeBanner from "@/components/banners/homeBanner";
import LeftNavigation from "@/components/shared/leftNavigation";
import Home from "./home";
import UserModel from "@/components/shared/modals/userModals";
import RightSideBar from "@/components/shared/rightSideBar";

export default {
  components: {
    HomeBanner,
    LeftNavigation,
    Home,
    UserModel,
    RightSideBar
  }
};
</script>
