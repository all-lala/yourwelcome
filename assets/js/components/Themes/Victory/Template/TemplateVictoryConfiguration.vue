<script lang="ts">
import Vue from 'vue';
import { Prop } from 'vue-property-decorator';
import Victory from '@/models/victory.model';

/**
 * Template de base de création d'une nouvelle configuration d'animation de victoire
 */
export default class TemplateVictroryConfiguration extends Vue {
  @Prop({ default: '' })
  protected imgFolder!: string;

  @Prop({ default: '' })
  protected urlImgToSend!: string;

  @Prop({ default: '' })
  protected victory!: Victory;

  @Prop()
  protected value!: [{ code: string; value: string; victoire?: Victory }];

  /**
   * Retourne une configuration
   */
  protected getConfig(code: string): string {
    const config = this.value.find(val => val.code === code);
    return (config && config.value) || '';
  }

  /**
   * Met a jour la configuration
   */
  protected setConfig(code: string, value: string) {
    const newValue = [...this.value];
    const index = newValue.findIndex(val => val.code === code);
    if(index !== -1) {
      if(newValue.find(val => val.code === code && val.value !== value)) {
        newValue.splice(index, 1, { code, value, victoire : this.victory });
      }
    } else {
      newValue.push({ code, value, victoire : this.victory })
    }    
    this.$emit('input', newValue);
  }
}
</script>

<style>
</style>