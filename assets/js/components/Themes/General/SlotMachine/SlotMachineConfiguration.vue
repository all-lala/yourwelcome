<template>
  <div>
    <v-text-field
      v-model="titleLine1"
      :label="$t('line1')"
    ></v-text-field>
    <v-text-field
      v-model="titleLine2"
      :label=" $t('line2')"
    ></v-text-field>
    <v-input :label=" $t('imgFond')">
      <ImageUploader
        :sendUrl="urlImgToSend"
        @onFileLoaded="imgFond"
        :imgUrl="imgUrlLink"
      />
    </v-input>
  </div>
</template>

<i18n>
{
  "fr": {
    "line1": "Titre de la ligne 1",
    "line2": "Titre de la ligne 2",
    "imgFond": "Image de fond"
  }
}
</i18n>

<script lang="ts">
import Vue from 'vue';
import { Component, Mixins } from 'vue-property-decorator';
import ImageUploader from '../../../../components/ImageUploader.vue';
import TemplateThemeConfiguration from '../Template/TemplateThemeConfiguration.vue';
import { mixins } from 'vue-class-component';

@Component({
  name: 'SlotMachineConfiguration',
  components: {
    ImageUploader,
  },
})
export default class SlotMachineConfiguration extends TemplateThemeConfiguration {
  get titleLine1() {
    return this.getConfig('titleLine1');
  }

  set titleLine1(value: string) {
    this.setConfig('titleLine1', value);
  }

  get titleLine2() {
    return this.getConfig('titleLine2');
  }

  set titleLine2(value: string) {
    this.setConfig('titleLine2', value);
  }

  imgFond(img: string) {
    this.setConfig('imgFond', img);
  }

  get imgUrlLink() {
    return (
      this.getConfig('imgFond') &&
      `${this.imgFolder}${this.getConfig('imgFond')}`
    );
  }
}
</script>

<style></style>
