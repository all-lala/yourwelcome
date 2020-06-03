<template>
  <div :class="classZoneAnimation" :style="style">
    <img :src="image" class="image full" />
    <div class="div-text" :style="divTextStyle">
      <p
        v-for="(text, index) in convertedText(getConfig('text'))"
        :key="index"
        class="text"
        :style="textStyle"
      >
        {{ text }}
      </p>
    </div>
  </div>
</template>

<script lang="ts">
import TemplateVictory from '../Template/TemplateVictory.vue';
import Component from 'vue-class-component';

@Component({
  name: 'ImageFixe',
})
export default class ImageFixe extends TemplateVictory {
  get image() {
    return this.getConfig('typeImage') === 'one'
      ? this.getConfig('imgFond')
        ? `${this.imgFolder}${this.getConfig('imgFond')}`
        : ''
      : `${this.tableImgFolder}${this.table.image}`;
  }

  get classZoneAnimation() {
    const myClass: any = {
      zoneAnimation: true,
      full: true,
      visible: this.show || false,
    };

    myClass[this.getConfig('fromDirection')] = true;
    return myClass;
  }

  get style() {
    return {
      transition: `${this.getConfig('transitionTime')}s ease-out`,
    };
  }

  get textStyle() {
    return {
      fontFamily: this.getConfig('font'),
      color: this.getConfig('fontColor'),
    };
  }

  get divTextStyle() {
    let position = '';
    switch (this.getConfig('textAlign')) {
      case 'left':
        position = 'translate(0%, 50%)';
        break;
      case 'center':
        position = 'translate(-50%, 50%)';
        break;
      case 'right':
        position = 'translate(-100%, 50%)';
        break;
    }

    return {
      left: this.getConfig('textPositionH') + '%',
      bottom: this.getConfig('textPositionV') + '%',
      justifyContent: this.getConfig('textAlign'),
      textAlign: this.getConfig('textAlign'),
      transform: position,
    };
  }
}
</script>

<style scoped>
.zoneAnimation {
  position: fixed;
  z-index: 1000;
  visibility: hidden;
}

.image {
  position: absolute;
  top: 0px;
  left: 0px;
}

.fromLeft {
  top: 0px;
  left: -100%;
}

.fromRight {
  top: 0px;
  left: 100%;
}

.fromTop {
  top: -100%;
  left: 0px;
}

.fromBottom {
  top: 100%;
  left: 0px;
}

.full {
  width: 100%;
  height: 100%;
}

.visible {
  visibility: visible;
  top: 0px;
  left: 0px;
}

.div-text {
  position: absolute;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
}

.text {
  font-size: 11em;
  width: 100%;
  text-shadow: 0 0 5px black;
}
</style>
