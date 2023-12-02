/*import Vue from 'vue';
import HighchartsVue from 'highcharts-vue'
window.HighchartsVue = HighchartsVue;
Vue.use(HighchartsVue)*/

import Vue from 'vue';
//import * as HighchartsVue from 'highcharts-vue'
import StockModule from 'highcharts/modules/stock';

import Highcharts from 'highcharts';
//import stockInit from 'highcharts/modules/stock'
window.HighchartsVue = Highcharts;
window.Highcharts = Highcharts;StockModule(Highcharts);
//stockInit(HighchartsVue)
Vue.use(Highcharts)