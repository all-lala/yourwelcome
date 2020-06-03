import Vue from 'vue';
import Axios from './plugins/axios';
import App from './App.vue';
import router from './router';
import store from './store';
import vuetify from './plugins/vuetify';
import Vuex from 'vuex';
import i18n from './i18n/i18n';

Vue.config.productionTip = false;

Vue.use(Vuex);
Vue.use(Axios);

const vue = new Vue({
  router,
  store,
  i18n,
  vuetify,
  render: h => h(App),
}).$mount('#app');

// Gestion des erreurs d'autorisation
vue.$axios.interceptors.response.use(
  res => {
    return res;
  },
  err => {
    if (vue.$router.currentRoute.name !== 'login' && err.response.status === 401 && err.response.statusText === 'Unauthorized') {
      sessionStorage.removeItem('Authorization');
      Vue.$axios.defaults.headers.common.Authorization = undefined;
      vue.$router.push({ name: 'login', params: { source: vue.$route.path } });
    } else {
      return Promise.reject(err);
    }
  }
);
