<script lang="ts">
import Vue from 'vue';
import { Prop } from 'vue-property-decorator';
import Table from '@/models/table.model';
import Invite from '@/models/invite.model';

/**
 * Template de base de création d'un nouveau théme
 */
export default class TemplateTheme extends Vue {
  @Prop({ default: () => [] })
  protected configurations!: [{ code: string; value: string; theme: string }];

  @Prop({ default: () => [] })
  protected tables!: Table[];

  @Prop({ default: () => [] })
  protected invites!: Invite[];

  @Prop({ default: 0 })
  protected cible!: number;

  @Prop({ default: 0 })
  protected lastChange!: number;

  @Prop({ default: '' })
  protected tableImgFolder!: string;

  @Prop({ default: '' })
  protected imgFolder!: string;

  /**
   * Retourne une configuration
   */
  protected getConfig(code: string): string {
    const config = this.configurations.find((val) => val.code === code);
    return (config && config.value) || '';
  }
}
</script>
