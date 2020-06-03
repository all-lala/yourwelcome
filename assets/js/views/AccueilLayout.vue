<template>
  <v-app id="accueil">
    <v-app-bar app color="white" height="100">
      <v-toolbar-title class="font-weight-black font-accueil">{{
        $t('siteName')
      }}</v-toolbar-title>
      <v-spacer />
      <div class="hidden-md-and-up">
        <v-menu left bottom>
          <template v-slot:activator="{ on }">
            <v-btn icon v-on="on">
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item v-if="user" :to="{ name: 'configAccueil' }" exact>
              <v-list-item-title>
                <v-list-item-icon>
                  <v-icon color="success">mdi-play</v-icon> </v-list-item-icon
                >{{ $t('home.layout.enter') }}
              </v-list-item-title>
            </v-list-item>
            <v-list-item v-if="user" @click.prevent="disconnect" color="red">
              <v-list-item-title>
                <v-list-item-icon>
                  <v-icon color="warning"
                    >mdi-account-off</v-icon
                  > </v-list-item-icon
                >{{ $t('home.layout.disconnect') }}
              </v-list-item-title>
            </v-list-item>
            <v-list-item
              v-if="!user && $route.name !== 'accueil'"
              :to="{ name: 'accueil' }"
              exact
            >
              <v-list-item-title>
                <v-list-item-icon>
                  <v-icon color="secondary"
                    >mdi-rewind</v-icon
                  > </v-list-item-icon
                >{{ $t('home.layout.back') }}
              </v-list-item-title>
            </v-list-item>
            <v-list-item
              v-if="!user && $route.name === 'accueil'"
              :to="{ name: 'login' }"
              exact
            >
              <v-list-item-title>
                <v-list-item-icon>
                  <v-icon color="primary"
                    >mdi-account</v-icon
                  > </v-list-item-icon
                >{{ $t('home.layout.connect') }}
              </v-list-item-title>
            </v-list-item>
            <v-list-item
              v-if="!user && $route.name === 'accueil'"
              :to="{ name: 'register' }"
              exact
            >
              <v-list-item-title>
                <v-list-item-icon>
                  <v-icon color="success">mdi-plus</v-icon> </v-list-item-icon
                >{{ $t('home.layout.subscribe') }}
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
      <v-btn-toggle group class="hidden-sm-and-down">
        <v-btn text v-if="user" :to="{ name: 'configAccueil' }" exact>{{
          $t('home.layout.enter')
        }}</v-btn>
        <v-btn text v-if="user" @click.prevent="disconnect" color="red">{{
          $t('home.layout.disconnect')
        }}</v-btn>
        <v-btn
          text
          v-if="!user && $route.name !== 'accueil'"
          :to="{ name: 'accueil' }"
          exact
          >{{ $t('home.layout.back') }}</v-btn
        >
        <v-btn
          text
          v-if="!user && $route.name === 'accueil'"
          :to="{ name: 'login' }"
          exact
          >{{ $t('home.layout.connect') }}</v-btn
        >
        <v-btn
          text
          v-if="!user && $route.name === 'accueil'"
          :to="{ name: 'register' }"
          exact
          >{{ $t('home.layout.subscribe') }}</v-btn
        >
      </v-btn-toggle>
    </v-app-bar>
    <v-content>
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </v-content>
  </v-app>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { namespace } from 'vuex-class';
import User from '../models/user.model';

const userStore = namespace('user');

@Component({
  name: 'AccueilLayout',
})
export default class AccueilLayout extends Vue {
  @userStore.State('user') user?: User;

  @userStore.Action('disconnect') disconnect!: () => void;
}
</script>

<style scoped>
.font-accueil {
  font-size: 2.75rem;
  letter-spacing: initial !important;
  font-family: 'Great Vibes', cursive !important;
  padding: 1rem;
}

.fade-enter {
  opacity: 0;
}

.fade-enter-active {
  transition: opacity 0.25s ease;
}

.fade-leave-active {
  transition: opacity 0.25s ease;
  opacity: 0;
}
</style>
