<template>
  <v-content>
    <div class="myChartToggle">
      <button class="mctTitle" v-on:click="myFilter()" v-bind:class="{active: ratateIcon}">
        <v-icon>mdi-chevron-right</v-icon>
      </button>
      <transition name="fade">
        <div class="mctContent" v-if="show">
          <ul>
            <li class="mccPleLog">Please login to access MyChart function</li>
            <li class="mccBtn">
              <v-btn small color="primary">
                <v-icon>mdi-login-variant</v-icon>Login
                <!-- <v-icon>mdi-folder-plus-outline</v-icon>Add Folder -->
              </v-btn>
            </li>
          </ul>
        </div>
      </transition>
    </div>
  </v-content>
</template>
<script>
export default {
  data() {
    return {
      show: false,
      ratateIcon: false
    };
  },
  methods: {
    myFilter: function() {
      this.ratateIcon = !this.ratateIcon;
      this.show = !this.show;
    }
  }
};
</script>
<style lang="scss" scoped>
@import "@/assets/_variables.scss";
.myChartToggle {
  position: fixed;
  left: 0;
  top: calc(50% - 41px);
  z-index: 55;
  .mctTitle {
    color: #ffffff;
    padding: 24px 7px 24px 5px;
    border-radius: 0 3px 3px 0;
    position: relative;
    float: right;
    line-height: 1;
    cursor: pointer;
    background-image: url(../../../assets/images/my_charts.png);
    background-color: #316ab4;
    background-position: center top;
    width: 26px;
    height: 129px;
    i {
      -webkit-transition: 0.6s all ease;
      transition: 0.6s all ease;
      top: 40px;
      position: relative;
      left: -2px;
      color: #ffffff;
      font-size: 19px;
    }
    &.active i {
      -webkit-transform: rotate(180deg);
      -ms-transform: rotate(180deg);
      transform: rotate(180deg);
      -webkit-transition: 0.6s all ease;
      transition: 0.6s all ease;
    }
  }
  .mctContent {
    display: block;
    max-width: 197px;
    overflow: hidden;
    -webkit-transition: 0.3s all ease;
    transition: 0.3s all ease;
    height: 187px;
    box-shadow: 0 1px 11px -1px #000;
    position: relative;
    float: left;
    background: #2d2d2d;
    color: #ffffff;
    ul {
      padding-left: 0;
      list-style: none;
    }
    .mccPleLog {
      font-family: "Lato";
      font-size: 16px;
      letter-spacing: 1px;
      border-bottom: 0;
      text-align: center;
      line-height: 2;
    }
    .mccBtn {
      border-bottom: 0;
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100%;
      padding: 0;
    }
    .v-btn {
      width: 100%;
      border-radius: 0;
      .v-icon {
        font-size: 16px;
        padding-right: 5px;
      }
    }
  }
}
.fade-enter-active,
.fade-leave-active {
  width: 197px;
  -webkit-transition: 0.3s all ease;
  transition: 0.3s all ease;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
  -webkit-transition: 0.3s all ease;
  transition: 0.3s all ease;
  width: 0;
}
</style>