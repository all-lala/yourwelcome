import Vue from 'vue';
import Axios from './plugins/axios';
import App from './App.vue';
import router from './router';
import store from './store';
import vuetify from './plugins/vuetify';
import Vuex from 'vuex';
import i18n from './i18n/i18n';
import axios from 'axios';

Vue.config.productionTip = false;

Vue.use(Vuex);
Vue.use(Axios);

new Vue({
  router,
  store,
  i18n,
  vuetify,
  render: h => h(App),
}).$mount('#app');
