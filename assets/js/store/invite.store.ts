import Vue from 'vue';
import Invite from "@/models/invite.model";
import { Module, MutationTree, GetterTree, ActionTree, ActionContext } from 'vuex';
import Urls from '@/utils/urls';
import store from '.';
import InviteService from '@/service/invite.service';

interface InviteStoreState {
  invites: Invite[];
}

export default class InviteStore implements Module<InviteStoreState, any> {
  public namespaced = true;

  state: InviteStoreState = {
    invites: []
  }

  public mutations: MutationTree<InviteStoreState> = {
    invites: (state: InviteStoreState, invites: Invite[]) => {
      state.invites = invites;
    },
  }

  public getters: GetterTree<InviteStoreState, any> = {
    invitesNotInTable(state: InviteStoreState) {
      return (tableId: number) => state.invites.filter(invite => !invite.table || invite.table.id !== tableId);
    },
    getInviteByIri(state: InviteStoreState) {
      return (inviteIri: string) => state.invites.find(invite => invite.iri === inviteIri);
    }
  }

  public actions: ActionTree<InviteStoreState, any> = {
    loadInvites(context: ActionContext<InviteStoreState, any>) {
      InviteService.getInvites().then(invites => context.commit('invites', invites));
    },
    addInvite: (context: ActionContext<InviteStoreState, any>, invite: Invite) => {
      InviteService.addinvite(invite).then(() => {
        context.dispatch('loadInvites');
        context.dispatch('table/loadTables', {}, { root: true });
      });
    },
    updateInvite: (context: ActionContext<InviteStoreState, any>, invite: Invite) => {
      InviteService.updateInvite(invite).then(() => {
        context.dispatch('loadInvites');
        context.dispatch('table/loadTables', {}, { root: true });
      })
    },
    deleteInvite: (context: ActionContext<InviteStoreState, any>, invite: Invite) => {
      InviteService.deleteInvite(invite).then(() => {
        context.dispatch('loadInvites');
        context.dispatch('table/loadTables', {}, { root: true });
      })
    },
  }
}