<template>
  <v-content>
    <BannerSmall />
    <v-container>
      <v-row>
        <v-col cols="12" sm="2">
          <LeftNavigation />
        </v-col>
        <v-col cols="12" sm="10">
          <Indicator />
        </v-col>
      </v-row>
    </v-container>
    <UserModals />
  </v-content>
</template>
<script>
import LeftNavigation from "../shared/leftNavigation";
import Indicator from "./indicator";
import UserModals from "@/components/shared/modals/userModals";
import BannerSmall from "@/components/banners/bannerSmall";
export default {
  components: {
    LeftNavigation,
    Indicator,
    UserModals,
    BannerSmall
  }
};
</script>