<template>
  <v-container>
    <h1>{{ $t('homeSite.welcome.title') }}</h1>
    <div class="blockquote">
      <p
        v-for="(message, index) in $t('homeSite.welcome.message')"
        :key="index"
      >
        {{ message }}
      </p>
    </div>
    <Help :imgFolder="imgFolder" />
  </v-container>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { namespace } from 'vuex-class';
import Mariage from '@/models/mariage.model';
import Help from '@/components/Help.vue';
declare var BASE_URL: any;

const mariageStore = namespace('mariage');

@Component({
  name: 'ConfigurationAccueil',
  components: {
    Help,
  },
})
export default class ConfigurationAccueil extends Vue {
  private readonly imgFolder: string = `${BASE_URL}images/tuto/`;
}
</script>

<style></style>
