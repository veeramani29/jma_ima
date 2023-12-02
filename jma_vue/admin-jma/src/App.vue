<template>
  <v-app>
    <loader></loader>
    <v-toolbar v-if="login == true && notFound == true" dark>
      <v-app-bar-nav-icon @click="closeModal()"></v-app-bar-nav-icon>

      <v-toolbar-title>Japan Macro Advisors</v-toolbar-title>

      <div class="flex-grow-1"></div>
      <v-menu offset-y>
        <template v-slot:activator="{ on }">
          <div class="pro-drop" color="primary" dark v-on="on">
            <img src="takuji.png" /> Takuji Okubo
            <v-icon>keyboard_arrow_down</v-icon>
          </div>
        </template>
        <v-list class="admDroDow">
          <v-list-item>
            <v-list-item-title @click="changePsw"
              >Change Password</v-list-item-title
            >
          </v-list-item>
          <v-list-item>
            <v-list-item-title @click="clearLocalStorage"
              >Logout</v-list-item-title
            >
          </v-list-item>
        </v-list>
      </v-menu>
    </v-toolbar>

    <v-content class="con-main" :class="{ active: isActive }">
      <span v-if="login == true && notFound == true">
        <LeftNavigation />
      </span>
      <div class="px-3">
        <router-view></router-view>
      </div>
    </v-content>
  </v-app>
</template>
<style lang="scss" scoped>
.v-application .primary {
  width: 100%;
}
.admDroDow {
  .v-list-item__title {
    cursor: pointer;
  }
}
</style>
<script>
import LeftNavigation from "./components/LeftNavigation";
import Loader from "@/components/loader";
export default {
  name: "App",
  components: {
    LeftNavigation,
    Loader
  },
  data() {
    return {
      profile: {
        pic: require("@/assets/takuji.png")
      },
      // items: [{ title: "Profile",link: "/postAdd",clearFunction:"clearLocalStorage()"}, { title: "Logout",link: "/",clearFunction:"clearLocalStorage()"}],
      isActive: false,
      mini: true,
      login: false,
      notFound: false,
      isLoading: false
    };
  },
  methods: {
    changePsw() {
      this.$router.push("/ChangePassword");
    },
    clearLocalStorage() {
      this.axios
        .get(this.nodejsServer + "login/sessionDestroy")
        .then(response => {
          if (!response.data.err_code) {
            sessionStorage.clear();
            localStorage.clear();
            window.location.href = this.baseURL;
          }
        });
    },
    closeModal() {
      this.mini = !this.mini;
      this.isActive = !this.isActive;
      Event.$emit("i-got-clicked", this.mini);
    }
  },
  created() {
    if (this.$route.name != "Login") {
      this.login = true;
    }
    // if (this.Loading == "true") {
    //   this.isLoading = true;
    // } else {
    //   this.isLoading = false;
    // }

    if (this.$route.name != "not-found") {
      this.notFound = true;
    }
  }
};
</script>
