<template>
  <div class="ratioBox" :class="{ show }">
    <div class="fullHeight">
      <FireworkAnimation v-if="show" />
      <div class="text">
        <svg class="textsvg" viewBox="0 0 10 20" :class="{ show }">
          <text
            class="title"
            x="50%"
            y="50%"
            dominant-baseline="middle"
            text-anchor="middle"
            font-size="1.5"
          >
            <tspan
              :y="yPosition(index)"
              x="50%"
              :textLength="text.length"
              v-for="(text, index) in texts"
              :key="index"
            >
              {{ text }}
            </tspan>
          </text>
        </svg>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import TemplateVictory from '../Template/TemplateVictory.vue';
import Component from 'vue-class-component';

@Component({
  name: 'Firework',
})
export default class Firework extends TemplateVictory {
  private texts = this.convertedText(this.getConfig('text'));

  yPosition(index: number) {
    if (this.texts.length % 2) {
      return index < (this.texts.length - 1) / 2
        ? 50 - 10 * ((this.texts.length - 1) / 2 - index) + '%'
        : index === (this.texts.length - 1) / 2
        ? '50%'
        : 50 + 10 * (index - (this.texts.length - 1) / 2) + '%';
    } else {
      return index < (this.texts.length - 1) / 2
        ? 50 - 10 * ((this.texts.length - 1) / 2 - index) + '%'
        : 50 + 10 * (index - (this.texts.length - 1) / 2) + '%';
    }
  }
}
</script>

<style lang="scss" scoped>
.ratioBox {
  width: 178vh;
  height: 100vh;
  max-width: 100vw;
  max-height: 56.25vw;
  visibility: hidden;
  position: absolute;
  z-index: 1000;
}

.fullHeight {
  width: 100%;
  height: 100%;
  background-size: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin: auto;
  position: relative;
}

.text {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0px;
  left: 0px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: Ritzflf;
  text-transform: uppercase;
  font-size: '0';
  .textsvg {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 0%;
    width: 0%;
    transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    .title {
      color: rgb(200, 200, 200);
      fill: rgb(200, 200, 200);
      animation: colorchange 2s infinite;
    }
  }
}

.textsvg.show {
  height: 100%;
  width: 100%;
  filter: drop-shadow(0 0 1rem rgb(0, 0136, 255));
}

@keyframes colorchange {
  0% {
    fill: red;
  }
  33% {
    fill: yellow;
  }
  66% {
    fill: green;
  }
  100% {
    fill: red;
  }
}

.show {
  visibility: visible;
}
</style>
