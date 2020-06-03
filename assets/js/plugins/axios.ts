import Vue, { PluginObject } from 'vue';
import axios, { AxiosRequestConfig } from 'axios';
declare var BASE_URL: any;

// Full config:  https://github.com/axios/axios#request-config
// axios.defaults.baseURL = process.env.baseURL || process.env.apiUrl || '';
// axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

const config: AxiosRequestConfig = {
  baseURL: `${BASE_URL}api` || '',
  // validateStatus: () => true
};

// eslint-disable-next-line no-underscore-dangle
const _axios = axios.create(config);

_axios.interceptors.request.use(
  cfg =>
    // Do something before request is sent
    // eslint-disable-next-line implicit-arrow-linebreak
    cfg,
  err =>
    // Do something with request error
    // eslint-disable-next-line implicit-arrow-linebreak
    Promise.reject(err)
  ,
);

const Plugin: PluginObject<any> = {
  install: (vue) => {
    // eslint-disable-next-line no-param-reassign
    vue.$axios = _axios;
  },
};
Plugin.install = (vue) => {
  // eslint-disable-next-line no-param-reassign
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
