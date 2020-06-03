<template>
  <div>
    <v-card>
      <v-toolbar>
        <v-toolbar-title>{{ $t('guest.title') }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon color="blue" dark @click="newInvite">
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </v-toolbar>
      <v-data-table
        :headers="headers"
        :items="invites"
        item-key="id"
        fixed-header
      >
        <template v-slot:item.action="{ item }">
          <v-icon small class="mr-2" @click="editInvite(item)">mdi-pen</v-icon>
          <v-icon small @click="removeInvite(item)">mdi-delete</v-icon>
        </template>
      </v-data-table>
    </v-card>
    <InviteModal
      :show="modalInvite"
      :errorBadge="errorBadge"
      :invite="invite"
      :tables="tables"
      @close="closeModal"
      @valid="validModal"
    />
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { State, Action, namespace } from 'vuex-class';
import Invite from '@/models/invite.model';
import Table from '@/models/table.model';
import InviteModal from '@/components/InviteModal.vue';

const tableStore = namespace('table');
const inviteStore = namespace('invite');

@Component({
  name: 'InvitesView',
  components: {
    InviteModal,
  },
})
export default class InvitesView extends Vue {
  @tableStore.State('tables') tables!: Table[];

  @Action('updateTable') updateTable!: (table: Table) => void;

  @inviteStore.State('invites') invites!: Invite[];

  @inviteStore.Action('addInvite') addInvite!: (invite: Invite) => void;

  @inviteStore.Action('updateInvite') updateInvite!: (invite: Invite) => void;

  @inviteStore.Action('deleteInvite') deleteInvite!: (invite: Invite) => void;

  private modalInvite = false;

  private invite: Invite | null = null;

  private prevTable: Table | null = null;

  private errorBadge: string = '';

  /**
   * Entêtes de la table
   */
  get headers() {
    return [
      { text: this.$t('guest.table.firstname').toString(), value: 'nom' },
      { text: this.$t('guest.table.lastname').toString(), value: 'prenom' },
      { text: this.$t('guest.table.table').toString(), value: 'table.nom' },
      { text: this.$t('guest.table.badge').toString(), value: 'badge' },
      { text: this.$t('guest.table.actions').toString(), value: 'action' },
    ];
  }

  /**
   * Ajoute un invité
   */
  newInvite() {
    this.modalInvite = true;
    this.invite = new Invite();
  }

  /**
   * Edite un invité
   */
  editInvite(invite: Invite) {
    this.modalInvite = true;
    this.invite = { ...invite };
  }

  /**
   * Supprime un invité
   */
  removeInvite(invite: Invite) {
    this.deleteInvite(invite);
  }

  /**
   * Action à la validation de la modal invité
   */
  validModal(invite: Invite) {
    if (invite) {
      const otherInviteBadge =
        !!invite.badge && this.chercheBadgeInvite(invite.badge);
      if (otherInviteBadge && otherInviteBadge.id !== invite.id) {
        this.errorBadge = this.$t('guest.modal.badgeError', {
          firstname: otherInviteBadge.nom,
          lastname: otherInviteBadge.prenom,
        }).toString();
      } else if (invite.id) {
        this.updateInvite(invite);
        this.closeModal();
      } else {
        this.addInvite(invite);
        this.closeModal();
      }
    }
  }

  /**
   * Retourne un invité pour un numéro de badge
   */
  chercheBadgeInvite(numBadge: string) {
    return this.invites.find((invite) => invite.badge === numBadge);
  }

  /**
   * Actions à la fermeture de la modale
   */
  closeModal() {
    this.errorBadge = '';
    this.modalInvite = false;
    this.invite = null;
  }
}
</script>
