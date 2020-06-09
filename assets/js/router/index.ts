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
import Theme from '../views/Theme.vue';
import ConfigurationAccueil from '../views/ConfigurationAccueil.vue';
import {Auth} from '@/middlewares/auth.middleware'
import AuthUtils from '@/utils/auth.utils';
import User from '@/models/user.model';
declare var BASE_URL: any;

Vue.use(VueRouter);

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
        meta: {
          middleware: [
            Auth
          ]
        }
      },
      {
        path: '/configuration',
        name: 'configGenerale',
        component: ConfigGenerale,
        meta: {
          middleware: [
            Auth
          ]
        }
      },
      {
        path: '/configuration/table',
        name: 'tables',
        component: InvitesView,
        meta: {
          middleware: [
            Auth
          ]
        }
      },
      {
        path: '/configuration/table/:id',
        name: 'tableDetail',
        component: TableView,
        meta: {
          middleware: [
            Auth
          ]
        }
      },
      {
        path: '/configuration/table/new',
        name: 'tableDetailNew',
        component: TableView,
        meta: {
          middleware: [
            Auth
          ]
        }
      },
    ],
  },
  {
    path: '/theme',
    name: 'theme',
    component: Theme,
    meta: {
      middleware: [
        Auth
      ]
    }
  },
];

const router = new VueRouter({
  mode: 'history',
  base: BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  if(AuthUtils.isAuthenticated()){
    // If user authenticated create user
    if (!store.state.user || !store.state.user.user) {
      const user = Object.assign(new User(), AuthUtils.getTokenData());
      store.commit('user/user', user);
    }
    // If route is login or register redirect to home
    if(to.name === 'login' || to.name === 'register') {
      next({name: 'configAccueil'});
    }
  } else {
    store.commit('user/user', null);
    AuthUtils.removeToken();
  }

  /**
   * middleware actions
   */
  if (!to.meta.middleware) {
    next();
  } else {
    const context = {
      to, from, next
    };
    to.meta.middleware.forEach((mdw: any) => {
      mdw({...context});
    });
  }

});

export default router;