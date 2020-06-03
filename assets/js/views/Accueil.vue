<template>
  <div>
    <section id="hero">
      <v-row no-gutters>
        <v-img
          :min-height="'calc(100vh - ' + $vuetify.application.top + 'px)'"
          :src="imgFond"
        >
          <v-theme-provider dark>
            <v-container fill-height>
              <v-row
                align="center"
                class="white--text mx-auto"
                justify="center"
              >
                <v-col class="white--text text-center" cols="12" tag="h1">
                  <span
                    class="font-weight-black font-accueil"
                    :class="[
                      $vuetify.breakpoint.smAndDown
                        ? 'font-accueil-mini'
                        : 'font-accueil',
                    ]"
                    >{{ $t('siteName') }}</span
                  >
                  <br />
                  <span
                    class="font-weight-light"
                    :class="[
                      $vuetify.breakpoint.smAndDown ? 'display-0' : 'display-2',
                    ]"
                    >{{ $t('home.subtitle') }}</span
                  >
                </v-col>
                <v-btn
                  class="align-self-end"
                  fab
                  outlined
                  @click="$vuetify.goTo('#description')"
                >
                  <v-icon>mdi-chevron-double-down</v-icon>
                </v-btn>
              </v-row>
            </v-container>
          </v-theme-provider>
        </v-img>
      </v-row>
    </section>
    <section
      id="description"
      class="white"
      :min-height="'calc(100vh - ' + $vuetify.application.top + 'px)'"
    >
      <div class="py-12"></div>
      <v-container class="text-center">
        <h2 class="font-accueil-mini font-text-accroche">
          {{ $t('home.history.title') }}
        </h2>
        <v-responsive class="mx-auto mb-8" width="56">
          <v-divider class="mb-1"></v-divider>
          <v-divider></v-divider>
        </v-responsive>
        <v-responsive
          class="mx-auto title font-weight-light mb-8"
          max-width="720"
        >
          <p
            color="grey"
            class="ma-0"
            v-for="(message, index) in $t('home.history.message')"
            :key="index"
          >
            {{ message }}
          </p>
        </v-responsive>
        <h3 class="font-accueil-mini font-text-accroche">
          {{ $t('home.history.footer') }}
        </h3>
        <div class="py-8"></div>
        <v-carousel
          cycle
          height="400"
          hide-delimiter-background
          show-arrows-on-hover
          class="elevation-4"
        >
          <v-carousel-item
            v-for="(slide, i) in slides"
            :key="i"
            :src="slide.src"
          ></v-carousel-item>
        </v-carousel>
        <div class="py-12"></div>
        <v-btn
          class="align-self-end"
          fab
          outlined
          @click="$vuetify.goTo('#steps')"
        >
          <v-icon>mdi-chevron-double-down</v-icon>
        </v-btn>
        <div class="py-8"></div>
      </v-container>
    </section>
    <section id="steps" class="red lighten-5">
      <div class="py-12"></div>
      <v-container class="text-center">
        <h2 class="font-accueil-mini">{{ $t('home.features.title') }}</h2>
        <v-responsive class="mx-auto mb-12" width="56">
          <v-divider class="mb-1"></v-divider>
          <v-divider></v-divider>
        </v-responsive>
        <v-row>
          <v-col
            v-for="({ icon, title, text }, i) in $t('home.features.features')"
            :key="i"
            cols="12"
            md="4"
          >
            <v-card class="py-12 px-4" color="lighten-5">
              <div color="primary" size="88">
                <v-avatar color="pink lighten-4" size="88">
                  <v-icon large v-text="icon"></v-icon>
                </v-avatar>
              </div>
              <v-card-title
                class="justify-center font-weight-black text-uppercase"
                v-text="title"
              ></v-card-title>
              <v-card-text class="subtitle-1" v-text="text"></v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
      <div class="py-12"></div>
    </section>
  </div>
</template>

<script lang="ts">
import Component from 'vue-class-component';
import Vue from 'vue';
import { namespace, State } from 'vuex-class';
import User from '../models/user.model';
import vuetify from 'vuetify';

@Component({
  name: 'Accueil',
})
export default class Accueil extends Vue {
  private horizontal = true;

  private slides = [
    {
      src: `images/accueil/exemples/1.jpg`,
    },
    {
      src: `images/accueil/exemples/2.jpg`,
    },
  ];

  created() {
    window.addEventListener('resize', this.windowsResize);
  }

  destroyed() {
    window.removeEventListener('resize', this.windowsResize);
  }

  mounted() {
    this.windowsResize();
  }

  /**
   * Action au changement de taille
   */
  private windowsResize() {
    this.horizontal = window.innerWidth > window.innerHeight;
  }

  /**
   * Image de fond à appliquer
   */
  get imgFond() {
    return this.horizontal
      ? `images/accueil/fond.jpg`
      : `images/accueil/fond_vertical.jpg`;
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Great+Vibes&display=swap');

.font-accueil {
  font-size: 12rem !important;
  line-height: 10rem;
  letter-spacing: initial !important;
  font-family: 'Great Vibes', cursive !important;
  text-shadow: 0 0 5px solid pink;
}

.font-accueil-mini {
  font-size: 3.75rem !important;
  line-height: 3.75rem;
  letter-spacing: initial !important;
  font-family: 'Great Vibes', cursive !important;
}

.font-text-accroche {
  text-shadow: 4px 2px 5px #985662, 0 0 3px black;
  color: #ffbdbd;
}
</style>
