<template>
  <div>
    <TextareaWithFont
      :label="$t('labelText')"
      v-model="text"
      :font="font"
      @onChangeFont="setFont"
    />
    <v-divider class="mb-4"></v-divider>
    <v-label for="fontColor">{{ $t('colorLabel') }}</v-label>
    <v-color-picker
      id="fontColor"
      v-model="fontColor"
      hide-canvas
      hide-inputs
      hide-mode-switch
      show-swatches
      mode="hexa"
      width="100%"
      class="full-width"
    ></v-color-picker>
    <v-radio-group v-model="textAlign" :label="$t('textAlign.label')">
      <v-radio :label="$t('textAlign.left')" value="left" key="left"></v-radio>
      <v-radio :label="$t('textAlign.center')" value="center" key="center"></v-radio>
      <v-radio :label="$t('textAlign.rigth')" value="right" key="right"></v-radio>
    </v-radio-group>
    <v-label for="textPositionH"
      >{{ $t('hPosLabel') }}</v-label
    >
    <v-slider
      id="textPositionH"
      v-model="textPositionH"
      thumb-label="always"
      min="0"
      max="100"
      step="5"
    >
      <template v-slot:thumb-label="{ value }">{{ value }}%</template>
    </v-slider>
    <v-label for="textPositionV"
      >{{ $t('vPosLabel') }}</v-label
    >
    <v-slider
      id="textPositionV"
      v-model="textPositionV"
      thumb-label="always"
      min="0"
      max="100"
      step="5"
      vertical
    >
      <template v-slot:thumb-label="{ value }">{{ value }}%</template>
    </v-slider>
    <v-radio-group v-model="typeImage" :label="$t('typeImg.label')">
      <v-radio :label="$t('typeImg.img')" value="one" key="one"></v-radio>
      <v-radio :label="$t('typeImg.table')" value="table" key="table"></v-radio>
    </v-radio-group>
    <div v-if="typeImage === 'one'">
      <v-label for="urlImgToSend">{{ $t('imgBackLabel') }}</v-label>
      <ImageUploader
        id="urlImgToSend"
        :sendUrl="urlImgToSend"
        @onFileLoaded="imgFond"
        :imgUrl="imgUrlLink"
      />
    </div>
    <v-radio-group
      v-model="fromDirection"
      :label="$t('imgOrign.label')"
    >
      <v-radio :label="$t('imgOrign.fromTop')" value="fromTop" key="fromTop"></v-radio>
      <v-radio :label="$t('imgOrign.frombBttom')" value="frombBttom" key="frombBttom"></v-radio>
      <v-radio :label="$t('imgOrign.fromLeft')" value="fromLeft" key="fromLeft"></v-radio>
      <v-radio :label="$t('imgOrign.fromRight')" value="fromRight" key="fromRight"></v-radio>
    </v-radio-group>
    <v-slider
      v-model="transitionTime"
      :label="$t('transitionTime')"
      thumb-label="always"
      min="0.5"
      max="10"
      step="0.5"
    ></v-slider>
  </div>
</template>

<i18n>
{
  "fr": {
    "labelText": "Texte à afficher",
    "colorLabel": "Couleur du texte",
    "textAlign": {
      "label": "Alignement du texte",
      "left": "Gauche",
      "center": "Centre",
      "rigth": "Droite"
    },
    "hPosLabel": "Position horizontale du texte sur la page (depuis la gauche)",
    "vPosLabel": "Position verticale du texte sur la page (depuis le bas)",
    "typeImg": {
      "label": "Type d'image à utiliser",
      "img": "Une image",
      "table": "Image de la table"
    },
    "imgBackLabel": "Image de fond",
    "imgOrign": {
      "label": "Glissement de l'image depuis le bord",
      "fromTop": "Haut",
      "frombBttom": "Bas",
      "fromLeft": "Gauche",
      "fromRight": "Droit"
    },
    "transitionTime" : "Temps de transition (en secondes)"
  }
}
</i18n>

<script lang="ts">
import TemplateVictroryConfiguration from '../Template/TemplateVictoryConfiguration.vue';
import Component from 'vue-class-component';
import ImageUploader from '@/components/ImageUploader.vue';
import TextareaWithFont from '@/components/TextareaWithFont.vue';

@Component({
  name: 'ImageFixeConfiguration',
  components: {
    ImageUploader,
    TextareaWithFont,
  },
})
export default class ImageFixeConfiguration extends TemplateVictroryConfiguration {
  get text() {
    return this.getConfig('text');
  }

  set text(value: string) {
    this.setConfig('text', value);
  }

  get font() {
    return this.getConfig('font');
  }

  setFont(value: string) {
    this.setConfig('font', value);
  }

  get fontColor() {
    if (!this.getConfig('fontColor')) {
      this.fontColor = '#FFFFFFFF';
    }
    return this.getConfig('fontColor');
  }

  set fontColor(value: string) {
    this.setConfig('fontColor', value);
  }

  get textAlign() {
    if (!this.getConfig('textAlign')) {
      this.textAlign = 'center';
    }
    return this.getConfig('textAlign');
  }

  set textAlign(value: string) {
    this.setConfig('textAlign', value);
  }

  get textPositionH() {
    if (!this.getConfig('textPositionH')) {
      this.textPositionH = 50;
    }
    return Number(this.getConfig('textPositionH'));
  }

  set textPositionH(value: number) {
    this.setConfig('textPositionH', value.toString());
  }

  get textPositionV() {
    if (!this.getConfig('textPositionV')) {
      this.textPositionV = 50;
    }
    return Number(this.getConfig('textPositionV'));
  }

  set textPositionV(value: number) {
    this.setConfig('textPositionV', value.toString());
  }

  get typeImage() {
    if (!this.getConfig('typeImage')) {
      this.typeImage = 'one';
    }
    return this.getConfig('typeImage');
  }

  set typeImage(value: string) {
    this.setConfig('typeImage', value);
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

  get fromDirection() {
    if (!this.getConfig('fromDirection')) {
      this.fromDirection = 'fromTop';
    }
    return this.getConfig('fromDirection');
  }

  set fromDirection(value: string) {
    this.setConfig('fromDirection', value);
  }

  get transitionTime(): number {
    if (!this.getConfig('transitionTime')) {
      this.transitionTime = 2;
    }
    return Number(this.getConfig('transitionTime'));
  }

  set transitionTime(value: number) {
    this.setConfig('transitionTime', value.toString());
  }
}
</script>

<style scoped>
.full-width {
  width: 100%;
}
</style>
