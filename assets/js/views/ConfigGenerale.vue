<template>
  <v-card>
    <v-form ref="form">
      <v-toolbar color="deep-purple" dark>
        <v-toolbar-title>
          <h2>{{ $t('config.title') }}</h2>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items class="hidden-sm-and-down">
          <v-btn hover ripple text color="white" @click="abortChanges">
            {{ $t('config.btn.reload') }}
            <v-icon color="warning">mdi-reload</v-icon>
          </v-btn>
          <v-btn hover ripple text color="white" @click="saveChanges">
            {{ $t('config.btn.save') }}
            <v-icon color="success">mdi-check</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-expansion-panels focusable accordion tile flat v-model="opened">
        <v-expansion-panel key="mariage">
          <v-expansion-panel-header color="red lighten-4">
            <h3>{{ $t('config.submenu.mariage.title') }}</h3>
            <v-spacer></v-spacer>
            <span>{{ mariage.nom }}</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-text-field
              :label="$t('config.submenu.mariage.form.name')"
              name="weddingName"
              prepend-icon="mdi-account"
              type="text"
              v-model="nom"
              validate-on-blur
              :rules="mariageNameRules"
            />
            <v-dialog
              ref="dialog"
              v-model="modalDatePicker"
              :return-value.sync="date"
              persistent
              width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  :value="dateFormated"
                  :label="$t('config.submenu.mariage.form.date')"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-on="on"
                  :rules="mariageDateRules"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="date"
                :min="today.toISOString()"
                :locale="$i18n.locale"
                scrollable
              >
                <v-btn
                  text
                  color="secondary"
                  @click="modalDatePicker = false"
                  >{{
                    $t('config.submenu.mariage.form.dateModal.btn.cancel')
                  }}</v-btn
                >
                <v-spacer></v-spacer>
                <v-btn text color="success" @click="$refs.dialog.save(date)">{{
                  $t('config.submenu.mariage.form.dateModal.btn.valid')
                }}</v-btn>
              </v-date-picker>
            </v-dialog>
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel key="theme">
          <v-expansion-panel-header>
            <h3>{{ $t('config.submenu.themeChoice.title') }}</h3>
            <v-spacer></v-spacer>
            <span>{{ selectedTheme && selectedTheme.label }}</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-container>
              <v-row justify="start" dense>
                <v-col cols="auto" v-for="theme in themes" :key="theme.name">
                  <v-card
                    :class="{ selectedCard: getConfig('theme') === theme.name }"
                    :width="theme.orientation === 'v' ? '180' : '320'"
                    hover
                    ripple
                    @click="selectTheme(theme.name)"
                  >
                    <v-img
                      class="align-end"
                      :height="theme.orientation === 'v' ? '320px' : '180px'"
                      :src="
                        theme.image &&
                          `${getBaseUrl}images/theme/${theme.image}`
                      "
                    >
                      <v-card-title class="inverted--text">{{
                        theme.label
                      }}</v-card-title>
                    </v-img>
                  </v-card>
                </v-col>
              </v-row>
            </v-container>
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel
          key="themeConfig"
          v-if="selectedTheme && selectedTheme.configuration"
        >
          <v-expansion-panel-header color="blue lighten-5">
            <h4>{{ $t('config.submenu.themeConfig.title') }}</h4>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-form>
              <component
                :is="getThemeConfig"
                :imgFolder="imgFolderTheme"
                :urlImgToSend="urlImgToSendTheme"
                :theme="selectedTheme"
                v-model="configurationsTheme"
              />
            </v-form>
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel key="victory">
          <v-expansion-panel-header>
            <h3>{{ $t('config.submenu.successAnimationChoice.title') }}</h3>
            <v-spacer></v-spacer>
            <span>{{ selectedVictory && selectedVictory.label }}</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-container>
              <v-row justify="start" dense>
                <v-col
                  cols="auto"
                  v-for="victory in victories"
                  :key="victory.name"
                >
                  <v-card
                    :class="{
                      selectedCard: getConfig('victory') === victory.name,
                    }"
                    :width="victory.orientation === 'v' ? 180 : 320"
                    hover
                    outlined
                    ripple
                    @click="selectVictory(victory.name)"
                  >
                    <v-img
                      class="align-end"
                      :height="victory.orientation === 'v' ? '320px' : '180px'"
                      :src="
                        victory.image &&
                          `${getBaseUrl}images/victoire/${victory.image}`
                      "
                    >
                      <v-card-title class="inverted--text">{{
                        victory.label
                      }}</v-card-title>
                    </v-img>
                  </v-card>
                </v-col>
              </v-row>
            </v-container>
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel
          key="victoryConfig"
          v-if="selectedVictory && selectedVictory.configuration"
          value="true"
        >
          <v-expansion-panel-header color="blue lighten-5">
            <h4>{{ $t('config.submenu.successAnimationConfig.title') }}</h4>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <component
              :is="getVictoryConfig"
              :imgFolder="imgFolderVictory"
              :urlImgToSend="urlImgToSendVictory"
              :victory="selectedVictory"
              v-model="configurationsVictoire"
            />
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
      <v-card-actions class="hidden-md-and-up">
        <v-btn text large ripple color="warning" @click="abortChanges">
          <span>{{ $t('config.btn.reload') }}</span>
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn text large rigth ripple color="success" @click="saveChanges">
          <span>{{ $t('config.btn.save') }}</span>
        </v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import { State, namespace } from 'vuex-class';
import { Watch } from 'vue-property-decorator';
import Configuration from '@/models/configuration.model';
import Urls from '@/utils/urls';
import Mariage from '@/models/mariage.model';
import Theme from '@/models/theme.model';
import Victory from '@/models/victory.model';
import moment from 'moment';
import ConfigurationsVictoire from '@/models/configurationsVictoire.model';
import ConfigurationsTheme from '@/models/configurationsTheme.model';
declare var BASE_URL: any;

const userStore = namespace('user');
const mariageStore = namespace('mariage');
const themeStore = namespace('theme');
const victoryStore = namespace('victory');

@Component({
  name: 'configGenerale',
  components: {},
})
export default class ConfigGenerale extends Vue {
  @mariageStore.State('mariage') mariage!: Mariage;

  @mariageStore.Mutation('nom') mariageNom!: (nom: string) => void;

  @mariageStore.Mutation('date') mariageDate!: (date: string) => void;

  @mariageStore.Getter('getConfig') getConfig!: (code: string) => string;

  @mariageStore.Action('loadConfigurations')
  loadConfigurations!: () => void;

  @mariageStore.Action('save')
  save!: () => void;

  @mariageStore.Action('setConfigurationTheme')
  setConfigurationTheme!: (configurationsTheme: ConfigurationsTheme[]) => void;

  @mariageStore.Action('setConfigurationVictory')
  setConfigurationVictory!: (
    configurationsVictoire: ConfigurationsVictoire[]
  ) => void;

  @mariageStore.Action('setConfig') setConfig!: (newValue: {
    code: string;
    value: string;
  }) => void;

  @mariageStore.Getter('getConfigurationsTheme')
  getConfigurationsTheme!: ConfigurationsTheme[];

  @mariageStore.Getter('getConfigurationsVictory')
  getConfigurationsVictory!: ConfigurationsVictoire[];

  @mariageStore.Getter('imgFolderTheme') imgFolderTheme!: string;

  @mariageStore.Getter('imgFolderVictory') imgFolderVictory!: string;

  @themeStore.Action('loadThemes') loadThemes!: () => void;

  @themeStore.State('themes') themes!: Theme[];

  @themeStore.Getter('getTheme') getTheme!: (name: string) => Theme;

  @victoryStore.Action('loadVictories') loadVictories!: () => void;

  @victoryStore.State('victories') victories!: Victory[];

  @victoryStore.Getter('getVictory') getVictory!: (name: string) => Victory;

  private valid: boolean = true;

  private modalDatePicker: boolean = false;

  private today: Date = new Date();

  private opened: number = 0;

  public mounted() {
    if (!Array.isArray(this.themes) || !this.themes.length) {
      this.loadThemes();
    }
    if (!Array.isArray(this.victories) || !this.victories.length) {
      this.loadVictories();
    }
  }

  /**
   * retourne l'URL de base du server
   */
  get getBaseUrl() {
    return BASE_URL;
  }

  /**
   * Nom du mariage
   */
  get nom() {
    return this.mariage.nom || '';
  }

  set nom(nom: string) {
    this.mariageNom(nom);
  }

  /**
   * Date du mariage
   */
  get date() {
    return moment(this.mariage.date).format('YYYY-MM-DD') || '';
  }

  set date(date: string) {
    this.mariageDate(date);
  }

  /**
   * Configurations du theme
   */
  get configurationsTheme() {
    return this.getConfigurationsTheme;
  }

  set configurationsTheme(configurationsTheme: any) {
    this.setConfigurationTheme(configurationsTheme);
  }

  /**
   * Configurations de l'animation de victoire
   */
  get configurationsVictoire() {
    return this.getConfigurationsVictory;
  }

  set configurationsVictoire(configurationsVictoire: any) {
    this.setConfigurationVictory(configurationsVictoire);
  }

  /**
   * Thème sélectionné
   */
  get selectedTheme(): Theme | null {
    return this.getConfig('theme')
      ? this.getTheme(this.getConfig('theme'))
      : null;
  }

  /**
   * Animation de victoire sélectionné
   * */
  get selectedVictory(): Victory | null {
    return this.getConfig('victory')
      ? this.getVictory(this.getConfig('victory'))
      : null;
  }

  /**
   * Url d'envois d'image pour le thème
   */
  get urlImgToSendTheme() {
    return `${Urls.SAVE_IMAGE}/theme`;
  }

  /**
   * Url d'envois d'image pour l'animation de victoire
   */
  get urlImgToSendVictory() {
    return `${Urls.SAVE_IMAGE}/victoire`;
  }

  /**
   * Retourne le composant de configuration du thème
   */
  get getThemeConfig() {
    const theme = this.getConfig('theme');
    const themeConfiguration = `${theme}Configuration`;

    if (theme && this.selectedTheme && this.selectedTheme.configuration) {
      const newComponent = require(`@/components/Themes/General/${theme}/${themeConfiguration}.vue`);
      if (
        this.$options &&
        this.$options.components &&
        !this.$options.components[themeConfiguration]
      ) {
        this.$options.components[themeConfiguration] =
          newComponent.default || newComponent;
      }

      return themeConfiguration;
    }

    return '';
  }

  /**
   * Retourne le composant de configuration de l'animation de victoire
   */
  get getVictoryConfig() {
    const victory = this.getConfig('victory');
    const victoryConfiguration = `${victory}Configuration`;

    if (victory && this.selectedVictory && this.selectedVictory.configuration) {
      const newComponent = require(`@/components/Themes/Victory/${victory}/${victoryConfiguration}.vue`);
      if (
        this.$options &&
        this.$options.components &&
        !this.$options.components[victoryConfiguration]
      ) {
        this.$options.components[victoryConfiguration] =
          newComponent.default || newComponent;
      }

      return victoryConfiguration;
    }

    return '';
  }

  /**
   * Retourne la date formaté
   */
  get dateFormated() {
    return this.mariage && this.mariage.date
      ? moment(this.mariage.date).format('DD/MM/YYYY')
      : '';
  }

  /**
   * Le thème sélectionné
   */
  selectTheme(theme: string) {
    this.setConfig({ code: 'theme', value: theme });
  }

  /**
   * l'animation de victoire sélectionné
   */
  selectVictory(victory: string) {
    this.setConfig({ code: 'victory', value: victory });
  }

  /**
   * Action d'annulation des changements
   */
  abortChanges() {
    this.loadConfigurations();
  }

  /**
   * Sauvegarde des configurations
   */
  saveChanges() {
    this.validateForm();
    if (this.valid) {
      this.save();
    }
  }

  /**
   * Valide le formulaire
   */
  validateForm() {
    (this.$refs.form as Vue & { validate: () => boolean }).validate();
  }

  // Rules
  private mariageNameRules = [this.mariageNameExists];

  private mariageDateRules = [this.dateExists, this.dateIsValid];

  private mariageNameExists(v: string): boolean | string {
    return !!v ||
    this.$t('home.register.error.mariageNameExists').toString()
  }

  private dateExists(v: string): boolean | string {
    return (
      !!v ||
      this.$t('home.register.error.dateExists').toString()
    );
  }

  private dateIsValid(v: string): boolean | string {
    return (
      (!!v && moment(v, 'DD/MM/YYYY').isValid()) ||
      this.$t('home.register.error.dateIsValid').toString()
    );
  }
}
</script>

<style scoped>
.selectedCard {
  box-shadow: 0 0 15px purple;
}
.inverted--text {
  color: white;
  text-shadow: 0px 0px 2px black, 0 0 1em white, 0 0 0.2em black;
  -webkit-text-stroke: 1px black;
}
</style>
