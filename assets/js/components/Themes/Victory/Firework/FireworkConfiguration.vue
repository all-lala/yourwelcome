<template>
  <div>
    <TextareaWithFont :label="$t('labelFireworkText')" v-model="text" :withFont="false" />
  </div>
</template>

<i18n>
{
  "fr": {
    "labelFireworkText": "Texte à afficher"
  }
}
</i18n>

<script lang="ts">
import TemplateVictroryConfiguration from '../Template/TemplateVictoryConfiguration.vue';
import Component from 'vue-class-component';
import TextareaWithFont from '../../../../components/TextareaWithFont.vue';

@Component({
  name: 'FireworkConfiguration',
  components: {
    TextareaWithFont,
  },
})
export default class FireworkConfiguration extends TemplateVictroryConfiguration {
  get text() {
    return this.getConfig('text');
  }

  set text(value: string) {
    this.setConfig('text', value);
  }
}
</script>

<style scoped>
.full-width {
  width: 100%;
}
</style>
