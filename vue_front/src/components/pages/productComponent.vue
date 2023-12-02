<template>
  <v-content>
    <v-container>
      <v-row>
        <v-col cols="12" sm="2">
          <LeftNavigation />
        </v-col>
        <v-col cols="12" sm="10">
          <Product />
        </v-col>
      </v-row>
    </v-container>
  </v-content>
</template>
<script>
import LeftNavigation from "@/components/shared/leftNavigation";
import Product from "@/components/pages/product.vue";
export default {
  components: {
    LeftNavigation,
    Product
  }
};
</script>