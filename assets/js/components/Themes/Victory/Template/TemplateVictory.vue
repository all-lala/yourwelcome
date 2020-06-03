<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Prop } from 'vue-property-decorator';
import Table from '@/models/table.model';
import Invite from '@/models/invite.model';

/**
 * Template de base de création d'une nouvelle animation de victoire
 */
export default class TemplateVictory extends Vue {
  @Prop({ default: false })
  protected show!: boolean;

  @Prop({ default: () => [] })
  protected configurations!: [{ code: string; value: string; victory: string }];

  @Prop({ default: () => [] })
  protected table!: Table;

  @Prop({ default: () => [] })
  protected invite!: Invite;

  @Prop({ default: '' })
  protected tableImgFolder!: string;

  @Prop({ default: '' })
  protected imgFolder!: string;

  /**
   * Retourne une configuration
   */
  protected getConfig(code: string): string {
    const config = this.configurations.find(val => val.code === code);
    return (config && config.value) || '';
  }

  /**
   * Methode de remplacement de textes prédéfinis
   */
  protected convertedText(text: string): string[] {
    text = text.replace('%table%', this.table.nom || '');
    text = text.replace('%nom%', this.invite.nom || '');
    text = text.replace('%prenom%', this.invite.prenom || '');
    return text.split(/(?:\r\n|\r|\n)/g);
  }
}
</script>

<style>
</style>