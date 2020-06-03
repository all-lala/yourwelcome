<template>
  <div>
    <v-card>
      <v-toolbar color="deep-green" dark>
        <v-toolbar-title class="hidden-sm-and-down">
          <h2 v-if="table.id">
            {{ $t('table.title.update', { name: table.nom }) }}
          </h2>
          <h2 v-else>{{ $t('table.title.add') }}</h2>
        </v-toolbar-title>
        <v-spacer class="hidden-sm-and-down"></v-spacer>
        <v-toolbar-items>
          <v-btn
            v-if="table.id"
            color="red darken-1"
            hover
            ripple
            text
            @click="removeTable"
          >
            {{ $t('table.btn.delete') }}
            <v-icon color="warning">mdi-window-close</v-icon>
          </v-btn>
          <v-btn
            v-if="table.id"
            hover
            ripple
            text
            color="white"
            @click="updateRoute(table.id)"
            class="hidden-sm-and-down"
          >
            {{ $t('table.btn.reload') }}
            <v-icon color="warning">mdi-reload</v-icon>
          </v-btn>
          <v-spacer class="hidden-md-and-up"></v-spacer>
          <v-btn
            v-if="table.id"
            hover
            ripple
            text
            color="white"
            @click="saveTable"
          >
            {{ $t('table.btn.save') }}
            <v-icon color="success">mdi-check</v-icon>
          </v-btn>
          <v-btn v-else hover ripple text color="white" @click="saveTable">
            {{ $t('table.btn.add') }}
            <v-icon color="success">mdi-check</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-form>
        <v-card-text>
          <v-row>
            <v-col>
              <v-text-field
                v-model="table.nom"
                :label="$t('table.name')"
                required
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-input :label="$t('table.img')">
                <ImageUploader
                  :bgcolor="color"
                  class="elevation-2"
                  :sendUrl="urlImgToSend"
                  @onFileLoaded="setImgFond"
                  :imgUrl="imageUrl"
                />
              </v-input>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-input :label="$t('table.color')">
                <v-color-picker
                  v-model="color"
                  hide-canvas
                  hide-inputs
                  hide-mode-switch
                  show-swatches
                  mode="hexa"
                  width="100%"
                  class="full-width"
                ></v-color-picker>
              </v-input>
            </v-col>
          </v-row>
        </v-card-text>
      </v-form>
    </v-card>
    <v-card v-if="table.id">
      <v-toolbar>
        <v-toolbar-title>{{ $t('table.guest.title') }}</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-simple-table>
        <thead>
          <tr>
            <th>{{ $t('guest.table.firstname') }}</th>
            <th>{{ $t('guest.table.lastname') }}</th>
            <th>{{ $t('guest.table.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="invite in table.invites" :key="invite.id">
            <td>{{ invite.nom }}</td>
            <td>{{ invite.prenom }}</td>
            <td>
              <v-icon small @click="deleteInviteTable(invite)"
                >mdi-delete</v-icon
              >
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <v-autocomplete
                :label="$t('table.guest.add')"
                v-model="newInvite"
                :items="invites"
                item-text="nom"
                item-value="id"
                return-object
                :no-data-text="$t('table.guest.empty')"
              >
                <template slot="item" slot-scope="data">
                  <!-- eslint-disable-next-line max-len -->
                  {{ data.item.nom }} {{ data.item.prenom }}
                  {{
                    data.item.table
                      ? $t('table.guest.atTable', { name: data.item.table.nom })
                      : ''
                  }}
                </template>
                <template slot="selection" slot-scope="data">
                  <!-- eslint-disable-next-line max-len -->
                  {{ data.item.nom }} {{ data.item.prenom }}
                  {{
                    data.item.table
                      ? $t('table.guest.atTable', { name: data.item.table.nom })
                      : ''
                  }}
                </template>
              </v-autocomplete>
            </td>
            <td>
              <v-icon
                @click="addInviteTable"
                :disabled="!newInvite"
                color="green"
                >mdi-plus</v-icon
              >
            </td>
          </tr>
        </tbody>
      </v-simple-table>
    </v-card>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import { Component, Prop, Watch } from 'vue-property-decorator';
import { State, Action, Getter, namespace } from 'vuex-class';
import Table from '@/models/table.model';
import Invite from '@/models/invite.model';
import Urls from '@/utils/urls';
import ImageUploader from '@/components/ImageUploader.vue';
import VueRouter from 'vue-router';
declare var BASE_URL: any;

const mariageStore = namespace('mariage');
const tableStore = namespace('table');
const inviteStore = namespace('invite');

@Component({
  name: 'TableView',
  components: {
    ImageUploader,
  },
})
export default class TableView extends Vue {
  @tableStore.State('tables') tables!: Table[];

  @tableStore.Action('addTable') addTable!: (table: Table) => Promise<Table>;

  @tableStore.Action('updateTable') updateTable!: (table: Table) => void;

  @tableStore.Action('deleteTable') deleteTable!: (table: Table) => void;

  @inviteStore.Action('updateInvite') updateInvite!: (invite: Invite) => void;

  @mariageStore.Getter('tableImgFolder') tableImgFolder!: string;

  @inviteStore.Getter
  public invitesNotInTable!: (tableId: number) => Invite[];

  private table: Table = new Table();

  private tableId: number = 0;

  private newInvite: Invite | null = null;

  headers = [
    { text: 'Nom', value: 'nom' },
    { text: 'Prenom', value: 'prenom' },
    { text: 'Actions', value: 'action' },
  ];

  mounted() {
    this.updateRoute(Number(this.$route.params.id));
  }

  /**
   * Retoune les invités à la table
   */
  get invites() {
    return this.invitesNotInTable
      ? this.invitesNotInTable(this.table.id || 0)
      : [];
  }

  /**
   * Retourne l'url de l'imag de la table
   */
  get imageUrl() {
    return this.table.realImg
      ? this.table.realImg.toDataURL()
      : this.table.image && `${this.tableImgFolder}${this.table.image}`;
  }

  /**
   * Url d'upload de l'image
   */
  get urlImgToSend() {
    return `${Urls.SAVE_IMAGE}/table`;
  }

  /**
   * Couleur de fond
   */
  get color() {
    return this.table.couleur;
  }

  set color(color: any) {
    this.table.couleur = color['hexa'] || color;
  }

  /**
   * Gestion du changement de table sans changer de route
   */
  @Watch('$route.params.id')
  updateRoute(id: number) {
    // Si l'on charge une table existante
    if (!isNaN(id)) {
      // Conversion de l'id string en number
      this.tableId = Number(id);
      this.findTable();
    } else {
      // Sinon on crée une nouvelle table
      this.table = new Table();
    }
  }

  @Watch('tables')
  updateTableData() {
    // Si l'on ajoute une table on redirige vers la dernière table
    if (!this.$route.params.id) {
      const tableDest = this.tables.slice(-1);
      if (tableDest && tableDest[0] && tableDest[0].id) {
        this.$router.push({
          name: 'tableDetail',
          params: { id: tableDest[0].id.toString() },
        });
      }
    } else if (this.$route.params.id && !this.table.id) {
      // si la liste des table à changé mais que la table recherché n'a pas été trouvé on la recharge
      this.updateRoute(Number(this.$route.params.id));
    } else {
      // mise à jours des invités
      this.updateInvitesTable();
    }
  }

  /**
   * ouvre une table dans la liste des tables déjà chargé
   */
  findTable() {
    this.table = Object.assign(
      new Table(),
      this.tables.find((tb) => tb.id === this.tableId)
    );
  }

  /**
   * Met a jourt la liste d'invités
   */
  updateInvitesTable() {
    const table = this.tables.find((tb) => tb.id === this.tableId);
    this.table.invites = table ? table.invites : [];
  }

  /**
   * MEt a jour l'image de la table
   */
  setImgFond(image: string) {
    this.table.image = image;
  }

  /**
   * Action de sauvegarde des données
   */
  saveTable() {
    if (this.table.id) {
      this.updateTable(this.table);
    } else {
      this.addTable(this.table);
    }
  }
  
  /**
   * Supprime un invité
   */
  deleteInviteTable(invite: Invite) {
    this.updateInvite({ ...invite, ...{ table: undefined } });
  }

  /**
   * Ajoute un invité
   */
  addInviteTable() {
    if (this.newInvite) {
      this.newInvite.table = this.table;
      this.updateInvite(this.newInvite);
    }
  }

  /**
   * Supprime la table
   */
  removeTable() {
    if (confirm(this.$t('table.deleteConfirm').toString())) {
      this.deleteTable(this.table);
      this.$router.push({
        name: 'configAccueil',
      });
    }
  }
}
</script>

<style scoped>
.full-width {
  width: 100%;
}
</style>
