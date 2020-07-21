import Theme from "@/models/theme.model";
import { Module, MutationTree, ActionTree, GetterTree } from 'vuex';
import ThemeService from '@/service/theme.service';

interface ThemeStoreState {
  themes: Theme[];
}

export default class ThemeStore implements Module<ThemeStoreState, any> {
  public namespaced = true;

  state: ThemeStoreState = {
    themes: []
  }

  mutations: MutationTree<ThemeStoreState> = {
    themes: (state: ThemeStoreState, themes: Theme[]) => {
      state.themes = themes && themes.map(
        tab => Object.assign(new Theme(), tab),
      );
    }
  }

  /**
   * Retourne un theme en fonction de son nom
   */
  getters: GetterTree<ThemeStoreState, any> = {
    getTheme(state: ThemeStoreState): (name: string) => Theme | undefined {
      return (name: string) => state.themes.find(theme => theme.name === name);
    }
  }

  actions: ActionTree<ThemeStoreState, any> = {
    loadThemes(context) {
      ThemeService.getThemes().then(themes => context.commit('themes', themes))
    },
  }
}
