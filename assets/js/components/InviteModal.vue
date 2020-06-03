<template>
  <v-dialog :value="show" persistent max-width="400">
    <v-card v-if="localInvite">
      <v-card-title v-if="localInvite.id" class="headline">{{
        $t('guest.modal.title.update')
      }}</v-card-title>
      <v-card-title v-else class="headline">{{
        $t('guest.modal.title.add')
      }}</v-card-title>
      <v-card-text>
        <v-form v-model="valide">
          <v-text-field
            v-model="localInvite.nom"
            validate-on-blur
            :rules="nomRules"
            :label="$t('guest.modal.firstname')"
            required
          ></v-text-field>
          <v-text-field
            v-model="localInvite.prenom"
            validate-on-blur
            :rules="prenomRules"
            :label="$t('guest.modal.lastname')"
            required
          ></v-text-field>
          <BadgeReaderField
            v-model="localInvite.badge"
            :label="$t('guest.modal.badge')"
            :color="errorBadge ? 'error' : 'success'"
          />
          <p v-if="errorBadge" color="error">{{ errorBadge }}</p>
          <v-autocomplete
            :label="$t('guest.modal.table')"
            clearable
            v-model="localInvite.table"
            :items="tables"
            item-text="nom"
            return-object
          ></v-autocomplete>
        </v-form>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="orange darken-1" text @click="$emit('close')">{{
            $t('guest.modal.btn.cancel')
          }}</v-btn>
          <v-btn
            color="green darken-1"
            :disabled="!valide"
            text
            @click="submit"
          >
            <span v-if="localInvite.id">{{
              $t('guest.modal.btn.update')
            }}</span>
            <span v-else>{{ $t('guest.modal.btn.add') }}</span>
          </v-btn>
        </v-card-actions>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Prop, Watch } from 'vue-property-decorator';
import Invite from '@/models/invite.model';
import Table from '@/models/table.model';
import BadgeReaderField from '@/components/BadgeReaderField.vue';

/**
 * Modal d'affichage d'un invité
 */
@Component({
  name: 'InviteModal',
  components: {
    BadgeReaderField,
  },
})
export default class InviteModal extends Vue {
  @Prop()
  show: boolean = false;

  @Prop()
  modalInvite!: boolean;

  @Prop()
  invite!: Invite;

  @Prop()
  errorBadge!: Invite;

  @Prop()
  tables!: Table[];

  private localInvite = new Invite();

  valide = false;

  @Watch('invite')
  changeInvite(invite: Invite) {
    this.localInvite = { ...invite };
  }

  submit() {
    this.$emit('valid', this.localInvite);
  }

  // Rules
  private nomRules = [(v: string) => !!v || 'Nom requis'];

  private prenomRules = [(v: string) => !!v || 'Prénom requis'];
}
</script>
