import User from "@/models/user.model";
import { Module, MutationTree, ActionTree, GetterTree } from 'vuex';

interface UserStoreState {
  user?: User;
}

export default class UserStore implements Module<UserStoreState, any> {
  public namespaced = true;

  state: UserStoreState = {
    user: undefined
  }

  mutations: MutationTree<UserStoreState> = {
    user: (state: UserStoreState, user: User) => {
      state.user = user;
    }
  }

  actions: ActionTree<UserStoreState, any> = {
    disconnect(context): void {
      sessionStorage.removeItem('Authorization');
      context.commit('user', null);
    }
  }
}