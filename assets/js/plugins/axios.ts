import Vue, { PluginObject } from 'vue';
import axios, { AxiosRequestConfig } from 'axios';
import AuthUtils from '@/utils/auth.utils';
declare var BASE_URL: any;

// Full config:  https://github.com/axios/axios#request-config
// axios.defaults.baseURL = process.env.baseURL || process.env.apiUrl || '';
// axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

const config: AxiosRequestConfig = {
  baseURL: `${BASE_URL}api` || '',
};

const _axios = axios.create(config);

_axios.interceptors.request.use(
  cfg => {
    // Reload token from localstorage
    if (AuthUtils.isAuthenticated()) {
      cfg.headers.common.Authorization = `Bearer ${AuthUtils.getTocken()}` 
    }
    return cfg;
  },
  err => Promise.reject(err)
);

_axios.interceptors.response.use(
  res => {
    return res
  },
  err =>
    {
      // Suppress token when unautorized
      if (err.response.status === 401 && !!AuthUtils.getTocken()) {
        AuthUtils.disconnect();
        window.location.reload();
      }
      return Promise.reject(err)
    }
);

const Plugin: PluginObject<any> = {
  install: (vue) => {
    vue.$axios = _axios;
  },
};
Plugin.install = (vue) => {
  vue.$axios = _axios;
  window.axios = _axios;
  Object.defineProperties(Vue.prototype, {
    $axios: {
      get() {
        return _axios;
      },
    },
  });
};

export default Plugin;
