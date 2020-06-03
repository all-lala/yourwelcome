<template>
  <canvas ref="canvas" class="canvas-full" />
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Prop } from 'vue-property-decorator';

@Component({
  name: 'FireworkAnimation',
})
export default class FireworkAnimation extends Vue {
  @Prop({ default: false })
  show!: boolean;

  private canvas!: HTMLCanvasElement;

  private ctx!: CanvasRenderingContext2D;

  private fireworks: Firework[] = [];

  private frame: number = 0;

  private readonly frameBeforFirework: number = 20;

  private timeout: any;

  mounted() {
    this.canvas = this.$refs.canvas as HTMLCanvasElement;
    if (this.canvas.getContext) {
      // @ts-ignore: Object is possibly 'null'.
      this.ctx = this.canvas.getContext('2d');
      // @ts-ignore: Object is possibly 'null'.
      this.canvas
        .getContext('2d')
        .scale(window.devicePixelRatio, window.devicePixelRatio);
      this.canvas.width = this.canvas.offsetWidth;
      this.canvas.height = this.canvas.offsetHeight;
      this.loop();
    }
  }

  beforeDestroy() {
    clearTimeout(this.timeout);
    this.fireworks = [];
  }

  private loop() {
    this.frame++;
    this.ctx.globalAlpha = 0.1;
    this.ctx.fillStyle = '#000000';
    this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
    this.ctx.globalAlpha = 1;

    this.fireworks = this.fireworks.filter((fire) => {
      const done = fire.update();
      fire.draw(this.ctx);
      return done;
    });

    if (this.frame >= this.frameBeforFirework) {
      this.frame = 0;
      const x =
        Math.random() * (this.canvas.width - this.canvas.width * 0.1) +
        this.canvas.width * 0.05;
      this.fireworks.push(
        new Firework(
          x,
          (Math.random() * this.canvas.height * 4) / 5,
          this.canvas.height,
          true
        )
      );
    }
    this.timeout = setTimeout(this.loop, 100 / 6);
  }
}

class Firework {
  private x: number;
  private y: number;
  private heightMove: number;
  private isBlown = false;
  private blownHeight = 0;
  private colorRgba = {
    r: Math.floor(Math.random() * 256),
    g: Math.floor(Math.random() * 256),
    b: Math.floor(Math.random() * 256),
    a: 255,
  };
  private readonly nbParticule = 60 * Math.ceil(Math.random() * 3);
  private particles: Particle[] = [];

  constructor(x: number, y: number, height: number, blown = false) {
    this.x = x;
    this.y = y;
    this.heightMove = height / 100;
    this.blownHeight = (Math.random() * height * 4) / 5;
    if (blown) {
      this.blown();
    }
  }

  public update() {
    this.y -= this.heightMove;
    if (this.y < this.blownHeight && !this.isBlown) {
      this.blown();
    }
    if (this.isBlown) {
      this.particles = this.particles.filter((part) => {
        return part.update();
      });
    }
    return !this.isBlown || this.particles.length !== 0;
  }

  blown() {
    this.isBlown = true;
    for (let i = 0; i < this.nbParticule; i++) {
      this.particles.push(new Particle(this.x, this.y, this.colorRgba));
    }
  }

  public draw(ctx: CanvasRenderingContext2D) {
    if (!this.isBlown) {
      ctx.fillStyle = `rgba(${this.colorRgba.r},${this.colorRgba.g},${this.colorRgba.b},${this.colorRgba.a})`;
      ctx.fillRect(this.x, this.y, 2, 2);
    } else {
      this.particles.forEach((part) => part.draw(ctx));
    }
  }
}

class Particle {
  private x: number;
  private y: number;
  private colorRgba: {
    r: number;
    g: number;
    b: number;
    a: number;
  };
  private lifetime: number = 0;
  private readonly maxLifetime: number = 100;
  private readonly vel: Velocity = new Velocity(4);
  private prevPart: {
    x: number;
    y: number;
    alpha: number;
  }[] = [];

  public constructor(
    x: number,
    y: number,
    colorRgba: { r: number; g: number; b: number; a: number }
  ) {
    this.x = x;
    this.y = y;
    this.colorRgba = colorRgba;
  }

  public update() {
    this.x += this.vel.x;
    this.y += this.vel.y;
    this.vel.x *= 0.995;
    this.vel.y *= 0.995;
    this.prevPart.push({
      x: this.x,
      y: this.y,
      alpha: 255,
    });
    this.lifetime++;
    return this.lifetime < this.maxLifetime;
  }

  public draw(ctx: CanvasRenderingContext2D) {
    ctx.fillStyle = `rgba(${this.colorRgba.r},${this.colorRgba.g},${this.colorRgba.b},255)`;
    ctx.fillRect(this.x, this.y, 2, 2);

    /*this.prevPart = this.prevPart.filter(prev => {
      ctx.fillStyle = `rgba(${this.colorRgba.r},${this.colorRgba.g},${this.colorRgba.b},${prev.alpha})`;
      ctx.fillRect(prev.x, prev.y, 2, 2);
      prev.alpha -= 22.5;
      return prev.alpha > 0;
    });*/
  }
}

class Velocity {
  public x: number;
  public y: number;

  public constructor(max: number) {
    let dir = Math.random() * Math.PI * 2;
    let spd = Math.random() * max;
    this.x = Math.cos(dir) * spd;
    this.y = Math.sin(dir) * spd;
  }
}
</script>

<style scoped>
.canvas-full {
  width: 100%;
  height: 100%;
}
</style>
