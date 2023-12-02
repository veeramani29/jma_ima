import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify';
import router from './router'
//import { createStore } from './store'
// import { sync } from 'vuex-router-sync'
import axios from 'axios'
import VueAxios from 'vue-axios';
import {
  RichTextEditorPlugin
} from '@syncfusion/ej2-vue-richtexteditor';
import CKEditor from '@ckeditor/ckeditor5-vue';
//import VueSession from 'vue-session';
import '@mdi/font/css/materialdesignicons.css'
import Vuetify from 'vuetify/lib'
import md5 from "md5";
axios.defaults.withCredentials = true
const token = localStorage.getItem('token');
if (token) {
  axios.defaults.headers.common['Authorization'] = token;

}



Vue.use(RichTextEditorPlugin, CKEditor, VueAxios, axios, );
Vue.config.productionTip = false
Vue.axios = Vue.prototype.axios = axios;
Vue.md5 = Vue.prototype.md5 = md5;
//----global variables end----
window.Event = new Vue();
export default new Vuetify({
  icons: {
    iconfont: 'mdi', // default - only for display purposes
  },

})
//const store = createStore()
// sync so that route state is available as part of the store
//sync(store, router)

//global variables
//Node js server
Vue.isLoggedIn = Vue.prototype.isLoggedIn = "true";
Vue.uploadsURL = Vue.prototype.uploadsURL = Vue.env('VUE_APP_TEXT_EDITOR_IMAGE_PATH');
Vue.baseURL = Vue.prototype.baseURL = Vue.env('VUE_APP_BASE_URL');
Vue.websiteURL = Vue.prototype.websiteURL = Vue.env('VUE_APP_WEBSITE_URL');
if (Vue.env('NODE_ENV') == 'development')
  Vue.nodejsServer = Vue.prototype.nodejsServer = Vue.env('VUE_APP_ROOT_API') + ":" + Vue.env('VUE_APP_NODE_PORT') + "/api/v1/";
else
  Vue.nodejsServer = Vue.prototype.nodejsServer = Vue.env('VUE_APP_ROOT_API') + "/api/v1/";

axios.create({
  baseURL: Vue.nodejsServer,
  headers: {
    'Content-Type': 'application/json',
    'Access-Control-Allow-Origin': Vue.nodejsServer,
    'Authorization': token
  }
})





Vue.userType = Vue.prototype.userType = function (value) {
  if (value == 1) {
    return 'Free'
  } else if (value == 2) {
    return 'Individual'
  } else {
    return 'corporate'
  }
};



if (window.__INITIAL_STATE__) {
  // We initialize the store state with the data injected from the server
  // store.replaceState(window.__INITIAL_STATE__)
}
new Vue({
  vuetify,
  render: h => h(App),
  router,
}).$mount('#app')