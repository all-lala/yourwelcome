import Vue from 'vue';
import Victory from "@/models/victory.model";
import { Module, MutationTree, ActionTree, GetterTree } from 'vuex';
import Urls from '@/utils/urls';
import VictoryService from '@/service/victory.service';

interface VictoryStoreState {
  victories: Victory[];
}

export default class VictoryStore implements Module<VictoryStoreState, any> {
  public namespaced = true;

  state: VictoryStoreState = {
    victories: []
  }

  mutations: MutationTree<VictoryStoreState> = {
    victories: (state: VictoryStoreState, victorys: Victory[]) => {
      state.victories = victorys && victorys.map(
        tab => Object.assign(new Victory(), tab),
      );
    }
  }

  /**
   * Retourne un victory en fonction de son nom
   */
  getters: GetterTree<VictoryStoreState, any> = {
    getVictory(state: VictoryStoreState): (name: string) => Victory | undefined {
      return (name: string) => state.victories.find(victory => victory.name === name);
    }
  }

  actions: ActionTree<VictoryStoreState, any> = {
    loadVictories(context) {
      VictoryService.getVictories().then(victories => context.commit('victories', victories));
    },
  }
}
