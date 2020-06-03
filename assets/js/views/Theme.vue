<template>
  <div class="fullPage">
    <v-icon
      v-if="!showMenu"
      @click.stop="showMenu = true"
      large
      class="fixed-top-left color-grey"
    >mdi-view-list</v-icon>
    <v-navigation-drawer v-model="showMenu" fixed temporary class="devant">
      <v-list>
        <v-list-item :to="{name: 'configAccueil'}" ripple>
          <v-list-item-title>
            <h3>Sortir</h3>
          </v-list-item-title>
        </v-list-item>
        <v-list-item>
          <v-list-item-title>
            <h3>Tables</h3>
          </v-list-item-title>
        </v-list-item>
        <v-list-group no-action value="true" v-for="table in tables" :key="table.id">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title ripple>{{table.nom}}</v-list-item-title>
            </v-list-item-content>
          </template>
          <v-list-item v-for="invite in table.invites" :key="invite.id" link>
            <v-list-item-title @click="selectInvite(invite, table)">{{invite.nom}} {{invite.prenom}}</v-list-item-title>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>
    <component
      v-bind:is="theme"
      :configurations="getConfigurationsTheme"
      :tables="tables"
      :invites="invites"
      :tableImgFolder="tableImgFolder"
      :imgFolder="imgFolderTheme"
      :cible="cible"
      :lastChange="time"
      @onAnimationEnded="animationEnded"
    ></component>
    <component
      v-if="table && invite && victory"
      v-bind:is="victory"
      :configurations="getConfigurationsVictory"
      :table="table"
      :invite="invite"
      :tableImgFolder="tableImgFolder"
      :imgFolder="imgFolderVictory"
      :show="showVictory"
    ></component>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { namespace } from 'vuex-class';
import Table from '@/models/table.model';
import Invite from '@/models/invite.model';
import Mariage from '@/models/mariage.model';
import { TimeInterval } from 'rxjs';

const mariageStore = namespace('mariage');
const tableStore = namespace('table');
const inviteStore = namespace('invite');

@Component({
  name: 'Theme'
})
export default class Theme extends Vue {
  @mariageStore.Action('loadConfigurations')
  loadConfigurations!: () => void;

  @mariageStore.State('mariage') mariage!: Mariage;

  @mariageStore.Getter('getConfigurationsTheme') getConfigurationsTheme!: [
    { code: string; value: string; theme?: string },
  ];

  @mariageStore.Getter('getConfigurationsVictory') getConfigurationsVictory!: [
    { code: string; value: string; victory?: string },
  ];

  @mariageStore.Getter('tableImgFolder') tableImgFolder!: string;

  @mariageStore.Getter('imgFolderTheme') imgFolderTheme!: string;

  @mariageStore.Getter('imgFolderVictory') imgFolderVictory!: string;

  @mariageStore.Getter('getConfig') getConfig!: (code: string) => string;

  @tableStore.Action('loadTables') loadTables!: () => Table[];

  @tableStore.State('tables') tables!: Table[];

  @inviteStore.Action('loadInvites') loadInvites!: () => Invite[];

  @inviteStore.State('invites') invites!: Invite[];

  private invite: Invite | null = null;

  private table: Table | null = null;

  private cible: number = 0;

  private time: number = 0;

  private cibleAttente: string = '';

  private showVictory: boolean = false;

  private delayVictory: any = null;

  private showMenu = false;

  private static baseBodyClassName = document.body.className;

  mounted() {
    document.addEventListener('keydown', this.keyPressActions);
    this.loadConfigurations();
    this.loadTables();
    this.loadInvites();
    if (document.body && document.body.parentElement) {
      document.body.parentElement.classList.add('overflowHidden');
    }
  }

  beforeDestroy() {
    document.removeEventListener('keydown', this.keyPressActions);
    if (document.body && document.body.parentElement) {
      document.body.parentElement.classList.remove('overflowHidden');
    }
  }

  /**
   * Retourne le composant de theme à afficher
   */
  get theme() {
    const theme = this.getConfig('theme')

    if (theme) {
      const newComponent = require(`@/components/Themes/General/${theme}/${theme}.vue`);
      if (
        newComponent &&
        this.$options &&
        this.$options.components &&
        !this.$options.components[theme]
      ) {
        this.$options.components[theme] =
          newComponent.default || newComponent
      }

      return theme
    }

    return ''
  }

  /**
   * Retourne le composant d'animation de victoire à afficher
   */
  get victory() {
    const victory = this.getConfig('victory')

    if (victory) {
      const newComponent = require(`@/components/Themes/Victory/${victory}/${victory}.vue`);
      if (
        this.$options &&
        this.$options.components &&
        !this.$options.components[victory]
      ) {
        this.$options.components[victory] =
          newComponent.default || newComponent
      }

      return victory
    }

    return ''
  }

  /**
   * Action de sélection d'un invité
   */
  selectInvite(invite: Invite, table: Table) {
    this.clearDelayVictory();
    this.sendValueTheme(invite, table);
  }

  /**
   * Ecoute du clavier
   * gestion du badge
   */
  keyPressActions(event: KeyboardEvent) {
    this.clearDelayVictory();
    switch (event.keyCode) {
      case 27: // Escape
        this.$router.push({ name: 'configAccueil' });
        break;
      case 13: // Enter
        this.sendValueTheme();
        break;
      default:
        // eslint-disable-next-line no-console
        if (event.code.match(/Digit([0-9]+)/i)) {
          this.cibleAttente += event.code.substr(5, 6);
        } else if (event.code.match(/Numpad([0-9]+)/i)) {
          this.cibleAttente += event.code.substring(6, 7);
        }
        // Badge de plus 10 caractéres
        if (this.cibleAttente && this.cibleAttente.length > 9) {
          this.sendValueTheme();
        }
        break;
    }
  }

  /**
   * Envoie l'action de sélection d'un invitré au thème
   */
  sendValueTheme(invite: Invite | null = null, table: Table | null = null) {
    if (table) {
      this.invite = invite;
      this.table = table;
    } else {
      this.table = this.findTableByBadge(this.cibleAttente);
    }
    if (this.table) {
      this.cible = this.tables.findIndex(
        tab => tab.id === (this.table && this.table.id),
      );
      this.time = Date.now();
      console.log(this.cible, this.table.id, this.table.nom);
    }
    this.cibleAttente = '';
  }

  /**
   * Retourne la table pour un badge
   */
  findTableByBadge(numBadge: string) {
    this.invite = this.invites.find(inv => inv.badge === numBadge) || null;
    return (this.invite && this.invite.table) || null;
  }

  /**
   * Action à la fin de l'animation du thème
   */
  animationEnded() {
    this.showVictory = true;
    this.setDelayVictory();
  }

  /**
   * Delai avant de supprimer l'animation de victoire
   */
  setDelayVictory() {
    this.delayVictory = setTimeout(this.clearDelayVictory, 10000);
  }

  /**
   * Suppression de l'animation de victoire
   */
  clearDelayVictory() {
    this.showVictory = false;
    clearTimeout(this.delayVictory);
  }
}
</script>

<style>
.overflowHidden {
  overflow: hidden;
}
</style>

<style scoped>
.devant {
  z-index: 100001;
}

.fullPage {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.menu {
  position: fixed;
  background: white;
  border: 1px solid grey;
}

.menu > ul {
  list-style: none;
  padding-left: 0px;
}

.menuElement {
  padding: 5px;
}

.menuElement:hover {
  background: grey;
  color: white;
  cursor: pointer;
}

.fixed-top-left {
  padding: 0.5em;
  position: fixed;
  top: 0px;
  left: 0px;
  z-index: 100000;
}

.color-grey {
  color: grey;
}
</style>
