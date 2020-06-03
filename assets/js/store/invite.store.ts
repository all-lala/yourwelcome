import Vue from 'vue';
import Invite from "@/models/invite.model";
import { Module, MutationTree, GetterTree, ActionTree, ActionContext } from 'vuex';
import Urls from '@/utils/urls';

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
      // eslint-disable-next-line max-len
      return (tableId: number) => state.invites.filter(invite => !invite.table || invite.table.id !== tableId);
    }
  }

  public actions: ActionTree<InviteStoreState, any> = {
    loadInvites(context: ActionContext<InviteStoreState, any>) {
      Vue.$axios.get(`${Urls.INVITE}`).then(invites => context.commit('invites', invites.data));
    },
    addInvite: (context: ActionContext<InviteStoreState, any>, invite: Invite) => {
      Vue.$axios.post(`${Urls.INVITE}`, invite).then((result) => {
        context.dispatch('loadInvites');
        context.dispatch('table/loadTables', {}, { root: true });
      });
    },
    updateInvite: (context: ActionContext<InviteStoreState, any>, inv: Invite) => {
      Vue.$axios.patch(`${Urls.INVITE}/${inv.id}`, { ...inv, ...{ table: inv.table || null } }).then((result) => {
        context.dispatch('loadInvites');
        context.dispatch('table/loadTables', {}, { root: true });
      });
    },
    deleteInvite: (context: ActionContext<InviteStoreState, any>, invite: Invite) => {
      Vue.$axios.delete(`${Urls.INVITE}/${invite.id}`).then((result) => {
        context.dispatch('loadInvites');
        context.dispatch('table/loadTables', {}, { root: true });
      });
    },
  }
}