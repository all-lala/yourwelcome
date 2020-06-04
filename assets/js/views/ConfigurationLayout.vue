<template>
  <v-app id="inspire" v-if="mariage">
    <v-app-bar color="deep-purple accent-4" dark app clipped-left>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title>
        <router-link :to="{ name: 'configAccueil' }" class="toolbar-title">
          <v-toolbar-title class="titre-mariage"
            >{{ $t('configLayout.preTitle') }}
            {{ mariage.nom }}</v-toolbar-title
          >
        </router-link>
      </v-toolbar-title>
      <v-spacer />
      <v-menu left bottom>
        <template v-slot:activator="{ on }">
          <v-btn icon v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item-group color="primary">
            <v-list-item
              :to="{ name: 'theme' }"
              :disabled="
                tables.length === 0 ||
                  !getConfig('theme') ||
                  !getConfig('victory')
              "
            >
              <v-list-item-icon>
                <v-icon color="success">mdi-play</v-icon>
              </v-list-item-icon>
              <v-list-item-title>{{
                $t('configLayout.preview')
              }}</v-list-item-title>
            </v-list-item>
            <v-list-item @click="leave" color="purple">
              <v-list-item-icon>
                <v-icon color="warning">mdi-account-off</v-icon>
              </v-list-item-icon>
              <v-list-item-title>{{
                $t('configLayout.disconnect')
              }}</v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </v-menu>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" clipped app left>
      <v-list nav>
        <v-list-item link exact :to="{ name: 'configGenerale' }" two-line>
          <v-list-item-content>
            <v-list-item-title>
              <h2>{{ $t('configLayout.config.title') }}</h2>
            </v-list-item-title>
            <v-list-item-subtitle>{{
              $t('configLayout.config.subtitle')
            }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item link exact :to="{ name: 'tables' }" two-line>
          <v-list-item-content>
            <v-list-item-title>
              <h2>{{ $t('configLayout.guest.title') }}</h2>
            </v-list-item-title>
            <v-list-item-subtitle>{{
              $tc('configLayout.guest.subtitle', invites && invites.length || 0)
            }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item two-line>
          <v-list-item-content>
            <v-list-item-title>
              <h2>{{ $t('configLayout.table.title') }}</h2>
            </v-list-item-title>
            <v-list-item-subtitle>{{ $tc('configLayout.table.subtitle', tables && tables.length || 0) }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item
          v-for="table in tables"
          :key="table.id"
          link
          exact
          :to="{ name: 'tableDetail', params: { id: table.id } }"
        >
          <v-list-item-content>
            <v-list-item-title>{{ table.nom }}</v-list-item-title>
            <v-list-item-subtitle>{{
              $tc('configLayout.guest.subtitle', (table && table.invites && table.invites.length) || 0)
            }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link exact :to="{ name: 'tableDetailNew' }">
          <v-list-item-content>
            <v-list-item-title>{{
              $t('configLayout.table.add')
            }}</v-list-item-title>
            <v-list-item-subtitle></v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-spacer></v-spacer>
        <v-list dense class="py-0">
          <v-list-item></v-list-item>
        </v-list>
      </v-list>
    </v-navigation-drawer>
    <v-content>
      <v-container fluid>
        <router-view />
      </v-container>
    </v-content>
    <v-footer app color="blue-grey" class="white--text">
      <span>&copy; {{ $t('configLayout.trademark') }}</span>
      <v-spacer />
      <span>{{ $t('configLayout.year') }}</span>
    </v-footer>
  </v-app>
</template>

<script lang="ts">
import Vue from 'vue';
import { Component, Watch } from 'vue-property-decorator';
import { State, namespace, Action } from 'vuex-class';
import Table from '@/models/table.model';
import Invite from '@/models/invite.model';
import Mariage from '@/models/mariage.model';

const mariageStore = namespace('mariage');
const userStore = namespace('user');
const tableStore = namespace('table');
const inviteStore = namespace('invite');

@Component({
  name: 'ConfigurationLayout',
})
export default class ConfigurationLayout extends Vue {
  @mariageStore.Action('loadConfigurations')
  loadConfigurations!: () => void;

  @mariageStore.State('mariage') mariage!: Mariage;

  @mariageStore.Getter('getConfig') getConfig!: (code: string) => string;

  @userStore.Action('disconnect') disconnect!: () => void;

  @tableStore.State('tables') tables!: Table[];

  @tableStore.Action('loadTables') loadTables!: () => void;

  @tableStore.Action('setTables') setTables!: (tables: Table[]) => void;

  @inviteStore.Action('loadInvites') loadInvites!: () => void;

  @inviteStore.State('invites') invites!: Invite[];

  private drawer: string | null = null;

  private navigationVisible = true;

  mounted() {
    this.loadConfigurations();
    this.loadTables();
    this.loadInvites();
  }
  
  /**
   * Déconnexion de l'application
   */
  leave() {
    this.disconnect();
    this.$router.push({ name: 'accueil' });
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Great+Vibes&display=swap');
.titre-mariage {
  font-family: 'Great Vibes', cursive;
  font-size: 2em;
}

.toolbar-title {
  color: inherit;
  text-decoration: inherit;
}
</style>
