<template>
  <div>
    <v-toolbar>
      <v-container>
        <v-row>
          <v-col cols="12" sm="3">
            <v-toolbar-title>
              <router-link to="/">
                <img src="../../assets/logo.png" class="tb-logo" />
              </router-link>
            </v-toolbar-title>
          </v-col>
          <v-col cols="12" sm="9">
            <v-toolbar-items>
              <v-btn text to="/">Home</v-btn>
              <v-btn text to="/about">About IMA</v-btn>
              <v-btn text to="/product">Products</v-btn>
              <v-btn text to="/career">Careers</v-btn>
              <v-btn text to="/contact">Contact</v-btn>
              <v-btn text>What We Offer</v-btn>
              <v-btn text to="/login">User Login</v-btn>
            </v-toolbar-items>
            <!-- <v-btn
              class="ma-2"
              @click="toggleMenu()"
              tile
              large
              color="teal"
              icon
            >
              <v-icon>mdi-menu</v-icon>
            </v-btn>-->
          </v-col>
        </v-row>
      </v-container>
    </v-toolbar>
  </div>
</template>
<script>
export default {
  computed: {
    menuData() {
      return this.$store.state.mini;
    }
  },
  methods: {
    toggleMenu() {
      this.$store.state.mini = !this.$store.state.mini;
    }
  }
};
</script>
<style lang="scss" scoped>
@import "@/assets/_variables.scss";
.v-toolbar__content {
  .v-toolbar__items {
    justify-content: flex-end;
    padding: 5px 0;
  }
  .tb-logo {
    height: 15px;
  }
  .v-btn {
    text-transform: none;
    &::before {
      background-color: transparent;
    }
  }
  .v-btn--active {
    color: $primari-color;
  }
  .container {
    padding: 0 12px;
  }
}
.theme--light.v-sheet{
  background-color:rgba(245,245,245,0.9);
}
</style>
