import { Route, NavigationGuardNext } from 'vue-router';
import AuthUtils from '@/utils/auth.utils';

export default class AuthMiddleWare {
  public static auth({to, next}: {to: Route, next: NavigationGuardNext}) {
    if(AuthUtils.isAuthenticated()) {
      next();
    } else {
      next({
        name: 'login', params: { source: to.fullPath },
      });
    }
  }
}

export const Auth = AuthMiddleWare.auth;
