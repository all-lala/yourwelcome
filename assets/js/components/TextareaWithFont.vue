<template>
  <div>
    <v-input :hint="hint" persistent-hint>
      <template>
        <div class="fullWidht">
          <v-label :for="id">{{ label }}</v-label>
          <div class="elevation-2" :id="id">
            <v-btn-toggle borderless>
              <v-btn value="left" @click="textAddValue('%table%')">
                <span class="hidden-sm-and-down">{{ $t('tableName') }}</span>
              </v-btn>
              <v-btn value="center" @click="textAddValue('%nom%')">
                <span class="hidden-sm-and-down">{{
                  $t('guestFistname')
                }}</span>
              </v-btn>
              <v-btn value="right" @click="textAddValue('%prenom%')">
                <span class="hidden-sm-and-down">{{
                  $t('guestLastname')
                }}</span>
              </v-btn>
            </v-btn-toggle>
            <v-textarea
              ref="textareaWithFont"
              v-model="text"
              id
              rows="4"
              hide-details
              solo
              flat
              dense
              :placeholder="$t('placeholder')"
              class="textareaWithFont"
              @keyup="getLastPosition"
              @mouseup="getLastPosition"
              @blur="getLastPosition"
              :style="{ fontFamily: font }"
            ></v-textarea>
          </div>
        </div>
      </template>
    </v-input>
    <v-select
      v-if="withFont"
      v-model="selectedFont"
      :items="listOfFonts"
      :label="$t('fontSelect')"
      append-icon="mdi-plus"
    >
    </v-select>
  </div>
</template>

<i18n>
{
  "fr": {
    "tableName": "Nom de la table",
    "guestFistname": "Nom de l'invité",
    "guestLastname": "Prénom de l'invité",
    "placeholder": "BRAVO %nom% %prenom%\nVous avez gagné une place\nà la table %table%",
    "fontSelect": "Choix de la police de caratére",
    "fontAdd": "Ajouter une police"
  }
}
</i18n>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { Prop } from 'vue-property-decorator';

/**
 * Composant d'affichage d'une textearéa avec boutons pour ajouer table/utilisateur
 * Permet de définir une police
 * 
 * TODO : A remplacer par un wysiwyg
 * TODO : Ajouter des polices personnalisés
 */
@Component({
  name: 'TextareaWithFont',
})
export default class TextareaWithFont extends Vue {
  @Prop({ default: '' })
  value!: string;

  @Prop({ default: '' })
  label!: string;

  @Prop({ default: '' })
  name!: string;

  @Prop({
    default: ``,
  })
  hint!: string;

  @Prop({ default: () => 3 })
  rows!: number;

  @Prop({
    default: () => [],
  })
  fonts!: string[];

  @Prop({ default: () => 'serif' })
  private font!: string;

  @Prop({ default: true })
  private withFont!: boolean;

  private lastTextPosition: number = 0;

  private lastTextNodeValue: string = '';

  private lastTextNodeIndex: number = 0;

  private readonly baseFonts = [
    'serif',
    'sans-serif',
    'monospace',
    'cursive',
    'fantasy',
    'Great Vibes',
  ];
  
  private readonly id: string =
    'Textarea' + Math.floor(Math.random() * 100000).toString();

  /**
   * Le texte affiché
   */
  get text() {
    return this.value;
  }

  set text(text: string) {
    this.$emit('input', text);
  }

  /**
   * Récupére la dernière position du curseur
   */
  getLastPosition() {
    const ref = this.$refs.textareaWithFont as Vue;
    const textarea =
      ref &&
      ref.$el &&
      ref.$el.getElementsByTagName('textarea') &&
      ref.$el.getElementsByTagName('textarea')[0];
    this.lastTextPosition = textarea.selectionStart;
  }

  /**
   * Ajoute du texte à la dernière position du curseur
   */
  textAddValue(value: string) {
    const beforeValue = this.text.substring(0, this.lastTextPosition);
    const middleValue = value;
    const afterValue = this.text.substring(this.lastTextPosition);
    this.text = `${beforeValue}${middleValue}${afterValue}`;
    this.lastTextPosition += value.length;
  }

  /**
   * Retourne la liste des polices
   */
  get listOfFonts() {
    return [...this.baseFonts, ...this.fonts];
  }

  /**
   * La police sélectionné
   */
  get selectedFont() {
    if (!this.font) {
      this.$emit('onChangeFont', 'serif');
    }
    return this.font;
  }

  set selectedFont(font: string) {
    this.$emit('onChangeFont', font);
  }

  /**
   * Retourne le style pour appliquer la police
   */
  get style() {
    return {
      fontFamily: this.selectedFont,
    };
  }
}
</script>

<style scoped>
.fullWidht {
  width: 100%;
}
.inputFile {
  display: none;
}
</style>

<style>
.textareaWithFont {
  font-size: 1.75rem;
}
.textareaWithFont textarea {
  line-height: 2.5rem !important;
}
</style>
