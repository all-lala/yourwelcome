<template>
  <div>
    <p v-for="(message, index) in value" :key="index" class="ma-0">{{ message }}</p>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop} from 'vue-property-decorator'

/**
 * Composant d'affichage dse message en Array 
 */
@Component({
  name: 'Messages'
})
export default class Messages extends Vue {
  @Prop({default: () => []})
  value!: string[]
}
</script>
