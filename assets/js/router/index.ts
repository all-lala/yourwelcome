import Vue from 'vue';
import VueRouter from 'vue-router';
import ConfigurationLayout from '../views/ConfigurationLayout.vue';
import TableView from '../views/TableView.vue';
import InvitesView from '../views/InvitesView.vue';
import ConfigGenerale from '../views/ConfigGenerale.vue';
import AccueilLayout from '../views/AccueilLayout.vue';
import Accueil from '../views/Accueil.vue';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import store from '@/store';
import User from '@/models/user.model';
import Theme from '../views/Theme.vue';
import ConfigurationAccueil from '../views/ConfigurationAccueil.vue';
declare var BASE_URL: any;

Vue.use(VueRouter);

function parseJwt(token: string): any {
  const base64Url = token.split('.')[1];
  const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
  const jsonPayload = decodeURIComponent(atob(base64).split('').map(c => `%${(`00${c.charCodeAt(0).toString(16)}`).slice(-2)}`).join(''));

  return JSON.parse(jsonPayload);
}

function validJwt(authorization: string) {
  return authorization && (parseJwt(authorization).exp - (new Date().getTime() / 1000) > 0);
}

const routes = [
  {
    path: '',
    name: '',
    component: AccueilLayout,
    children: [
      {
        path: '/',
        name: 'accueil',
        component: Accueil,
      },
      {
        path: '/login',
        name: 'login',
        component: Login,
      },
      {
        path: '/register',
        name: 'register',
        component: Register,
      }
    ]
  },
  {
    path: '',
    name: '',
    component: ConfigurationLayout,
    children: [
      {
        path: '/configAccueil',
        name: 'configAccueil',
        component: ConfigurationAccueil,
      },
      {
        path: '/configuration',
        name: 'configGenerale',
        component: ConfigGenerale,
      },
      {
        path: '/configuration/table',
        name: 'tables',
        component: InvitesView,
      },
      {
        path: '/configuration/table/:id',
        name: 'tableDetail',
        component: TableView,
      },
      {
        path: '/configuration/table/new',
        name: 'tableDetailNew',
        component: TableView,
      },
    ],
  },
  {
    path: '/theme',
    name: 'theme',
    component: Theme,
  },
];

const router = new VueRouter({
  mode: 'history',
  base: BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  // Routes public qui ne necessitent pas d'autorisation
  const publicRoutesNames = ['accueil', 'register', 'login'];
  const authorization = sessionStorage.getItem('Authorization');

  if (!validJwt(authorization || '')) {
    sessionStorage.removeItem('Authorization');
  } else {
    const user = Object.assign(new User(), parseJwt(authorization || ''));
    store.commit('user/user', user);
  }
  if (publicRoutesNames.find(routeName => routeName === to.name)) {
    next();
  } else if (!authorization && to.name !== 'login') {
    next({
      name: 'login', params: { source: from.path },
    });
  } else if (authorization && to.name === 'login') {
    Vue.$axios.defaults.headers.common = { Authorization: `Bearer ${authorization}` };
    next({
      name: 'configGenerale',
    });
  } else {
    Vue.$axios.defaults.headers.common = { Authorization: `Bearer ${authorization}` };
    next();
  }
});

export default router;
