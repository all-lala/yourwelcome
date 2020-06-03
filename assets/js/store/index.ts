import Vue from 'vue';
import Vuex, { StoreOptions } from 'vuex';
import MariageStore from './mariage.store';
import InviteStore from './invite.store';
import TableStore from './table.store';
import UserStore from './user.store';
import ThemeStore from './theme.store';
import VictoryStore from './victory.store';

Vue.use(Vuex);

const store: StoreOptions<any> = {
  modules: {
    mariage: new MariageStore(),
    invite: new InviteStore(),
    table: new TableStore(),
    user: new UserStore(),
    theme: new ThemeStore(),
    victory: new VictoryStore()
  },
};

export default new Vuex.Store(store);
