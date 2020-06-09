<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card class="elevation-12">
          <v-form @keyup.enter.native="valid">
            <v-toolbar color="primary" dark flat>
              <v-toolbar-title>{{ $t('home.login.title') }}</v-toolbar-title>
              <v-spacer />
            </v-toolbar>
            <v-card-text>
              <v-text-field
                v-model="user.username"
                :label="$t('home.login.email')"
                name="login"
                prepend-icon="mdi-account"
                type="text"
              />
              <v-text-field
                id="password"
                v-model="user.password"
                :label="$t('home.login.password')"
                name="password"
                prepend-icon="mdi-lock"
                type="password"
              />
              <div v-if="error" class="error-text font-weight-bold red--text">
                {{ $t('home.login.error') }}
              </div>
            </v-card-text>
            <v-card-actions>
              <v-spacer />
              <v-btn outlined color="success" @click="valid">{{
                $t('home.login.btn.valid')
              }}</v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import Vue from 'vue';
import { Prop, Component } from 'vue-property-decorator';
import Urls from '@/utils/urls';
import User from '@/models/user.model';
import AuthUtils from '@/utils/auth.utils';

@Component({
  name: 'Login',
})
export default class Login extends Vue {
  private user: User = new User();

  private redirection!: any;

  private error = false;

  mounted() {
    // eslint-disable-next-line no-mixed-operators
    this.redirection = (this.$route.params && this.$route.params.source) || {
      name: 'configAccueil',
    };
  }

  /**
   * Validation de l'utilisarteur
   */
  valid() {
    this.$axios
      .post(Urls.AUTH, this.user)
      .then((response) => {
        if (response && response.data && response.data.token) {
          AuthUtils.setToken(response.data.token);
          this.$router.push(this.redirection);
        } else {
          console.error('Response error!')
          this.error = true;
        }
      })
      .catch((error) => {
        console.log(error.response);
        this.error = true;
      });
  }
}
</script>
