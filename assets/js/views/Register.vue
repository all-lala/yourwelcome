<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card class="elevation-12">
          <v-form ref="form" v-model="valid" @keyup.enter.native="submit">
            <v-toolbar color="primary" dark flat>
              <v-toolbar-title>{{ $t('home.register.title') }}</v-toolbar-title>
              <v-spacer />
            </v-toolbar>
            <v-card-text>
              <v-container>
                <h1>{{ $t('home.register.user') }}</h1>
                <v-text-field
                  v-model="user.email"
                  label="e-mail"
                  name="login"
                  prepend-icon="mdi-account"
                  type="text"
                  :rules="emailRules"
                />
                <v-text-field
                  id="password"
                  v-model="user.password"
                  hint="12 caractères requis"
                  label="Mot de passe"
                  name="password"
                  prepend-icon="mdi-lock"
                  type="password"
                  validate-on-blur
                  :rules="passwordRules"
                />
                <v-text-field
                  id="password"
                  v-model="passwordVerification"
                  label="Vérification de mot de passe"
                  name="password"
                  prepend-icon="mdi-lock"
                  type="password"
                  validate-on-blur
                  :rules="passwordVerificationRules"
                />
              </v-container>
              <v-divider></v-divider>
              <v-container>
                <v-spacer></v-spacer>
                <h1>{{ $t('home.register.wedding') }}</h1>
                <v-text-field
                  v-model="user.mariage.nom"
                  label="Nom"
                  name="weddingName"
                  prepend-icon="mdi-account"
                  type="text"
                  validate-on-blur
                  :rules="mariageNameRules"
                />
                <v-dialog
                  ref="dialog"
                  v-model="modalDatePicker"
                  :return-value.sync="user.mariage.date"
                  persistent
                  width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      :value="dateFormated"
                      label="Date prévue"
                      prepend-icon="mdi-calendar"
                      readonly
                      :rules="mariageDateRules"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="user.mariage.date"
                    :min="today.toISOString()"
                    locale="fr"
                    scrollable
                  >
                    <v-btn
                      text
                      color="secondary"
                      @click="modalDatePicker = false"
                      >{{ $t('home.register.btn.cancel') }}</v-btn
                    >
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      color="success"
                      @click="$refs.dialog.save(user.mariage.date)"
                      >{{ $t('home.register.btn.valid') }}</v-btn
                    >
                  </v-date-picker>
                </v-dialog>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-btn color="secondary" :to="{ name: 'accueil' }" outlined>{{
                $t('home.register.btn.cancel')
              }}</v-btn>
              <v-spacer />
              <v-btn ref="validate" color="success" outlined @click="submit">{{
                $t('home.register.btn.valid')
              }}</v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
    <transition-group name="fade" mode="out-in">
      <v-overlay key="loading" :value="loading" align="center" justify="center">
        <h1>{{ $t('home.register.inProgress') }}</h1>
        <h3>{{ $t('home.register.waiting') }}</h3>
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-overlay
        key="created"
        :value="created"
        align="center"
        justify="center"
        color="success"
        opacity="1"
      >
        <h1>{{ $t('home.register.successMsg') }}</h1>
        <h2>{{ $t('home.register.connectMsg') }}</h2>
      </v-overlay>
    </transition-group>
  </v-container>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';
import User from '../models/user.model';
import Mariage from '../models/mariage.model';
import moment from 'moment';
import { Watch } from 'vue-property-decorator';
import Urls from '../utils/urls';
import VueRouter from 'vue-router';

@Component({
  name: 'Register',
})
export default class Register extends Vue {
  private user: User = User.createUser();

  private passwordVerification: string = '';

  private today = new Date();

  private error: boolean = false;

  private modalDatePicker: boolean = false;

  private valid = false;

  private loading = false;

  private created = false;

  /**
   * Retourne la date formaté
   */
  get dateFormated() {
    return this.user && this.user.mariage && this.user.mariage.date
      ? moment(this.user.mariage.date).format('DD/MM/YYYY')
      : '';
  }

  /**
   * Soumet le formulaire
   * TODO : Affichage des erreurs remontés par le serveur
   */
  submit() {
    ((this.$refs.validate as Vue).$el as HTMLElement).focus();
    this.validateForm();
    if (this.valid) {
      this.loading = true;
      this.$axios
        .post(Urls.REGISTER, this.user)
        .then((response) => {
          this.loading = false;
          if (response.data.token) {
            this.created = true;
            sessionStorage.setItem('Authorization', response.data.token);
            this.$axios.defaults.headers.common = {
              Authorization: `Bearer ${response.data.token}`,
            };
            setTimeout(
              () => this.$router.push({ name: 'configAccueil' }),
              5000
            );
          } else {
            this.error = true;
            this.validateForm();
          }
        })
        .catch((error) => {
          console.log(error)
          this.loading = false;
          this.error = true;
          this.validateForm();
        });
    }
  }

  /**
   * Valide le formulaire
   */
  validateForm() {
    (this.$refs.form as Vue & { validate: () => boolean }).validate();
  }

  // Rules
  private emailRules = [
    this.eMailExists,
    this.eMailIsValid,
    this.eMailAlreadyUsed
  ]

  private passwordRules = [this.passwordExists, this.passwordLength]

  private passwordVerificationRules = [this.passwordExists, this.passwordEquals]

  private mariageNameRules = [this.mariageNameExists]

  private mariageDateRules = [this.dateExists, this.dateIsValid]

  private eMailExists(v: string): boolean | string {
    return !!v || this.$t('home.register.error.eMailExists').toString()
  }

  private eMailIsValid(v: string): boolean | string {
    return (
      /.+@.+/.test(v) || this.$t('home.register.error.eMailIsValid').toString()
    )
  }

  private eMailAlreadyUsed(): boolean | string {
    return (
      !this.error || this.$t('home.register.error.eMailAlreadyUsed').toString()
    )
  }

  private passwordExists(v: string): boolean | string {
    return !!v || this.$t('home.register.error.passwordExists').toString()
  }

  private passwordLength(v: string): boolean | string {
    return (
      (!!v && v.length >= 12) ||
      this.$t('home.register.error.passwordLength').toString()
    )
  }

  private passwordEquals(v: string): boolean | string {
    return (
      v === this.user.password ||
      this.$t('home.register.error.passwordEquals').toString()
    )
  }

  private mariageNameExists(v: string): boolean | string {
    return !!v || this.$t('home.register.error.mariageNameExists').toString()
  }

  private dateExists(v: string): boolean | string {
    return !!v || this.$t('home.register.error.dateExists').toString()
  }

  private dateIsValid(v: string): boolean | string {
    return (
      (!!v && moment(v, 'DD/MM/YYYY').isValid()) ||
      this.$t('home.register.error.dateIsValid').toString()
    )
  }
}
</script>

<style></style>
