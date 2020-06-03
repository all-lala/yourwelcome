<template>
  <div class="ratioBox">
    <div id="app" class="fullHeight" :style="imgFondStyle">
      <div class="top">
        <div class="logo">
          <svg class="sign" viewBox="0 0 10 20">
            <text
              class="title"
              x="50%"
              y="45%"
              dominant-baseline="baseline"
              text-anchor="middle"
              :font-size="fontSize"
              textLength="60"
            >
              {{ getConfig('titleLine1') }}
            </text>
            <defs>
              <filter x="1%" y="0" width="98%" height="77%" id="solid">
                <feFlood flood-color="#08acd1" />
              </filter>
            </defs>
            <text
              filter="url(#solid)"
              class="subTilteBackground"
              x="50%"
              y="62%"
              dominant-baseline="hanging"
              text-anchor="middle"
              :font-size="fontSize"
              textLength="60"
            >
              {{ getConfig('titleLine1') }}
            </text>
            <text
              class="subtitleShadow"
              x="56%"
              y="64%"
              dominant-baseline="hanging"
              text-anchor="middle"
              :font-size="fontSize"
              textLength="30"
            >
              {{ getConfig('titleLine2') }}
            </text>
            <text
              class="subtitle"
              x="50%"
              y="60%"
              dominant-baseline="hanging"
              text-anchor="middle"
              :font-size="fontSize"
              textLength="30"
            >
              {{ getConfig('titleLine2') }}
            </text>
          </svg>
        </div>
      </div>
      <div class="bottom">
        <div class="machine">
          <div class="slotMachine">
            <SlotMachineCss
              :list="tablesMin"
              :currentIndex="cible"
              :trigger="lastChange"
              :tableImgFolder="tableImgFolder"
              @onStop="onSlotStop"
            />
          </div>
          <div class="slotMachine">
            <SlotMachineCss
              :list="tablesMin"
              :currentIndex="cible"
              :trigger="lastChange"
              :tableImgFolder="tableImgFolder"
              @onStop="onSlotStop"
            />
          </div>
          <div class="slotMachine">
            <SlotMachineCss
              :list="tablesMin"
              :currentIndex="cible"
              :trigger="lastChange"
              :tableImgFolder="tableImgFolder"
              @onStop="onSlotStop"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Component from 'vue-class-component'
import { Watch } from 'vue-property-decorator'
import TemplateTheme from '../Template/TemplateTheme.vue'
import SlotMachineCss from './SlotMachineCss.vue'

@Component({
  name: 'SlotMachine',
  components: {
    SlotMachineCss,
  },
})
export default class SlotMachine extends TemplateTheme {
  private slotStoped: number = 0;

  private fontSize = 7;

  get imgFondStyle() {
    return {
      backgroundImage: this.getConfig('imgFond')
        ? `url('${this.imgFolder}${this.getConfig('imgFond')}')`
        : '',
    };
  }

  get tablesMin() {
    const tables = [...this.tables];
    let i = 0;
    while (tables.length < 8 && tables.length !== 0) {
      tables.push(tables[i]);
      i++;
    }
    return tables;
  }

  @Watch('lastChange')
  resetSlots() {
    this.slotStoped = 0;
  }

  onSlotStop() {
    this.slotStoped++;
    if (this.slotStoped === 3) {
      this.$emit('onAnimationEnded');
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
}

.top {
  height: 35%;
  width: 100%;
}

.bottom {
  width: 100%;
  height: 65%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.machine {
  width: 65%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.slotMachine {
  width: 30%;
  height: 95%;
  margin: 0 4px 0 4px;
}

@font-face {
  font-family: 'Limelight';
  src: url('~@/assets/fonts/Limelight-1XzM.ttf');
}

@font-face {
  font-family: 'Rightbankflf';
  src: url('~@/assets/fonts/Rightbankflf-9Yon.ttf');
}

@font-face {
  font-family: 'Ritzflf';
  src: url('~@/assets/fonts/Ritzflf-lgd0.ttf');
}

$black: #222222;
$white: #fdfcfa;
$blue: #08acd1;
$pink: #e97db1;
$purple: #433c8a;

.logo {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  font-family: Ritzflf;
  text-transform: uppercase;
  .sign {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    .title {
      color: $blue;
      fill: $blue;
      animation: flicker 3s infinite alternate;
    }
    .subtitle {
      fill: $pink;
      border-radius: 5px;
      display: block;
      animation: flicker 3s infinite alternate;
    }
    .subtitleShadow {
      fill: $purple;
      border-radius: 5px;
      display: block;
    }
    .subtitleBackground {
      flood-color: $blue;
    }
  }
}

@keyframes flicker {
  0%,
  19%,
  21%,
  23%,
  25%,
  54%,
  56%,
  100% {
    text-shadow: 0 0 1rem #fff, 0 0 5rem #08f;
    box-shadow: 0 0 1rem #fff, 0 0 5rem #08f;
  }

  20%,
  24%,
  55% {
    text-shadow: none;
    box-shadow: none;
  }
}
</style>
