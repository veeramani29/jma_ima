import Vue from "vue";
import App from "./App.vue";
import axios from "axios";
import VueAxios from "vue-axios";
Vue.use(VueAxios, axios);
import vuetify from "./plugins/vuetify";
import highcharts from "./plugins/highcharts";
import router from "./router";
import clipboard from "./plugins/clipboard";
import fullpage from "./plugins/fullpage";
import JQuery from "jquery";
window.$ = JQuery;
//const Handlebars = require("handlebars");
import Handlebars from "handlebars";
window.Handlebars = Handlebars;
import MobileDetect from "mobile-detect";
window.MobileDetect = MobileDetect;
//import $ from 'jquery'
import Ima from "./assets/js/ima";

var objectParams = {
  myChart: {
    folderList: [],
    chartBookListInactive: []
  }
};
global.IMA = new Ima(
  "https://www.japanmacroadvisors.com/",
  "home",
  "index",
  "",
  "http",
  objectParams
);
import { store } from "./store/store";
import VueYouTubeEmbed from "vue-youtube-embed";
Vue.use(VueYouTubeEmbed);
Vue.use(VueYouTubeEmbed, {
  global: true
});
Vue.nodejsServer = Vue.prototype.nodejsServer = "http://localhost:5000/";
Vue.config.productionTip = false;
export const Event = new Vue();
new Vue({
  store: store,
  vuetify,
  highcharts,
  clipboard,
  render: h => h(App),
  router,
  fullpage
}).$mount("#app");
