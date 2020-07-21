import Vue from 'vue';
import { Module, MutationTree, ActionTree, ActionContext, GetterTree, Getter } from 'vuex';
import Urls from '@/utils/urls';
import Mariage from '@/models/mariage.model';
import ConfigurationsTheme from '@/models/configurationsTheme.model';
import ConfigurationsVictoire from '@/models/configurationsVictoire.model';
import Configuration from '@/models/configuration.model';
import MariageService from '@/service/mariage.service';
declare var BASE_URL: any;

interface MariageState {
  mariage: Mariage
}

export default class MariageStore implements Module<MariageState, any> {
  public namespaced = true;

  public state: MariageState = {
    mariage: new Mariage()
  };

  getters: GetterTree<MariageState, any> = {
    tableImgFolder(state: MariageState): string {
      return `${BASE_URL}images/tables/${state.mariage.id}/`;
    },
    imgFolderTheme(state: MariageState) {
      return `${BASE_URL}images/configuration/themes/${state.mariage.id}/`
    },
    imgFolderVictory(state: MariageState) {
      return `${BASE_URL}images/configuration/victoires/${state.mariage.id}/`
    },
    getConfig(state: MariageState) {
      return (code: string) => {
        const config = state.mariage.configurations && state.mariage.configurations.find(config => config.code === code);
        return config && config.value;
      }
    },
    getConfigTheme(state: MariageState) {
      return (code: string) => {
        const config = state.mariage.configurationsTheme && state.mariage.configurationsTheme.find(config => config.code === code);
        return config && config.value;
      }
    },
    getConfigVictory(state: MariageState) {
      return (code: string) => {
        const config = state.mariage.configurationsVictoire && state.mariage.configurationsVictoire.find(config => config.code === code);
        return config && config.value;
      }
    },
    getConfigurationsTheme(state: MariageState, getters) {
      const theme = getters.getConfig('theme');
      return state.mariage.configurationsTheme
        ? state.mariage.configurationsTheme.filter(
          config => config.theme && config.theme.name === theme
        )
        : [];
    },
    getConfigurationsVictory(state: MariageState, getters) {
      const victory = getters.getConfig('victory');
      return state.mariage.configurationsVictoire
        ? state.mariage.configurationsVictoire.filter(
          config => {
            return config.victoire && config.victoire.name === victory
          }
        )
        : [];
    },
  }

  public mutations: MutationTree<MariageState> = {
    mariage(state: MariageState, newValue: Mariage) {
      state.mariage = newValue;
    },
    nom(state, nom: string) {
      state.mariage.nom = nom;
    },
    date(state, date: string) {
      state.mariage.date = date;
    },
    setConfig(state: MariageState, newValue: { code: string, value: string }) {
      const config = state.mariage.configurations && state.mariage.configurations.find(config => config.code === newValue.code);
      if (config) {
        config.value = newValue.value;
      } else {
        if (!state.mariage.configurations) {
          state.mariage.configurations = [];
        }
        state.mariage.configurations.push(newValue)
      }
    },
    setConfigurationTheme(state: MariageState, newValue: ConfigurationsTheme[]) {
      state.mariage.configurationsTheme = newValue;
    },
    setConfigurationVictory(state: MariageState, newValue: ConfigurationsVictoire[]) {
      state.mariage.configurationsVictoire = newValue;
    },
  };

  public actions: ActionTree<MariageState, any> = {
    loadConfigurations(context: ActionContext<MariageState, any>) {
      MariageService.getMariage().then(mariage => context.commit('mariage', mariage))
    },
    setConfig(context: ActionContext<MariageState, any>, newValue: Configuration) {
      context.commit('setConfig', newValue);
    },
    setConfigurationTheme(context: ActionContext<MariageState, any>, newValue: ConfigurationsTheme[]) {
      context.commit('setConfigurationTheme', newValue);
    },
    setConfigurationVictory(context: ActionContext<MariageState, any>, newValue: ConfigurationsVictoire[]) {
      context.commit('setConfigurationVictory', newValue);
    },
    save(context: ActionContext<MariageState, any>) {
      MariageService.updateMariage(context.state.mariage).then(mariage => context.commit('mariage', mariage));
    }
  };
}
