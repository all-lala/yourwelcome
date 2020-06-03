<template>
  <div class="slot" :class="{win}">
    <div class="roue" :style="position" ref="roue" @transitionend="onStop">
      <div
        v-for="(table, index) in list"
        :key="index"
        class="face"
        :style="getStyle(index, table.couleur)"
      >
        <img v-if="table.image" class="image" :src="`${tableImgFolder}${table.image}`" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Prop, Watch } from 'vue-property-decorator';

@Component({
  name: 'SlotMachineCss',
})
export default class SlotMachineCss extends Vue {
  @Prop({ default: () => [] }) list!: [];

  @Prop({ default: 0 }) currentIndex!: number;

  @Prop({ default: 0 }) trigger!: number;

  @Prop({ default: '' }) tableImgFolder!: string;

  private sensRotation = false;

  private time = Date.now();

  private win = false;

  mounted() {
    window.addEventListener('resize', this.handleResize);
    document.addEventListener('fullscreenchange', this.handleResize);
    document.addEventListener('mozfullscreenchange', this.handleResize);
    document.addEventListener('webkitfullscreenchange', this.handleResize);
    document.addEventListener('msfullscreenchange', this.handleResize);
    this.handleResize();
  }

  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize);
    document.removeEventListener('fullscreenchange', this.handleResize);
    document.removeEventListener('mozfullscreenchange', this.handleResize);
    document.removeEventListener('webkitfullscreenchange', this.handleResize);
    document.removeEventListener('msfullscreenchange', this.handleResize);
  }

  private handleResize() {
    if (window) {
      this.time = Date.now();
    }
  }

  private get slotAngle() {
    return 360 / this.list.length;
  }

  private radiusAngle() {
    const roue = this.$refs.roue as { clientWidth: number };
    return Math.round(
      ((roue && roue.clientWidth) || 0) /
        2 /
        Math.tan(Math.PI / this.list.length),
    );
  }

  private getStyle(nb: number, color: string) {
    if (this.time) {
      return {
        background: color,
        transform: `rotateX(${this.slotAngle *
          nb}deg) translateZ(${this.radiusAngle()}px)`,
      };
    }
    return {};
  }

  private get position() {
    this.win = false;
    this.sensRotation = !this.sensRotation;
    const angle = (this.sensRotation ? 1 : 0) * 7200;
    const date = this.trigger;
    return {
      transition: `transform ${5 + Math.random() * 3}s ease-out`,
      transform: `rotateX(-${this.currentIndex * this.slotAngle + angle}deg)`,
    };
  }

  private onStop(): void {
    this.win = true;
    setTimeout(() => {
      this.$emit('onStop');
    }, 500);
  }
}
</script>

<style scoped>
.slot {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  height: 100%;
  width: 100%;
  border-radius: 6%;
  transition: box-shadow 0.5 ease-in-out;
}

.slot:before {
  content: '';
  position: absolute;
  top: 2%;
  left: 3%;
  right: 3%;
  bottom: 2%;
  border-radius: 4%;
  border: 1px solid gray;
  box-shadow: 0 0 40px white;
  background: inherit;
  z-index: 10;
}

.slot.win {
  box-shadow: 0 0 10px 10px yellow;
}

.roue {
  position: relative;
  transform-style: preserve-3d;
  padding-bottom: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.face {
  position: absolute;
  top: 0px;
  left: 0px;
  background: grey;
  width: 100%;
  height: 100%;
  border: 1px solid grey;
  transform-style: preserve-3d;
  display: flex;
  justify-content: center;
  align-items: center;
}

.image {
  width: 100%;
  height: auto;
}
</style>
