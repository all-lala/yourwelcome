<template>
  <div class="bordered" :color="color">
    <input
      :placeholder="label"
      type="text"
      :value="data"
      @input="updateState"
      @focus="$event.target.select()"
      class="input-large"
    />
  </div>
</template>

<script lang="ts">
import Vue from 'vue';
import { Component, Prop, Watch } from 'vue-property-decorator';

/**
 * Composant d'input pour lecture de badge
 * Conversion des caractéres en numérique
 */
@Component({
  name: 'BadgeReaderField',
})
export default class BadgeReaderField extends Vue {
  @Prop() value!: string;

  @Prop() label!: string;

  @Prop() color!: string;

  private data: string = '';

  @Watch('value')
  updateData(value: string) {
    this.data = this.value;
  }

  /**
  * Met à jour le numéro de badge pour une saisie décimale uniquement
  */
  updateState(event: any) {
    let newValue = event.target.value;
    if (!newValue) {
      newValue = '';
    }
    const numbers = ['à', '&', 'é', '"', "'", '(', '-', 'è', '_', 'ç'];
    numbers.forEach(
      (val, index) => (newValue = newValue.replace(val, index.toString())),
    );
    newValue = newValue.replace(/[^0-9]+/g, '');
    this.data = newValue;
    this.$forceUpdate();
    this.$emit('input', newValue);
  }
}
</script>

<style scoped>
.bordered {
  border: 1px solid grey;
  padding: 10px;
  border-radius: 5px;
}
.input-large {
  width: 100%;
}
</style>
