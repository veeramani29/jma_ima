import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    signInModal: false,
    mini: true,
    termConModal: false,
    agreeTerm: false,
    introVideo: false,
    dynamicData: null,
  }
})