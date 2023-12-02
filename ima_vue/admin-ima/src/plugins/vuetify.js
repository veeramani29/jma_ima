// src/plugins/vuetify.js
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

// const opts = {}

// export default new Vuetify(opts)
Vue.use(Vuetify);

export default new Vuetify({
  icons: {
    iconfont: 'md',
  },
});