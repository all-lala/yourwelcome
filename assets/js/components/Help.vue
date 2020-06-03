<template>
  <v-expansion-panels focusable accordion tile>
    <h2>{{ $t('help.title') }}</h2>
    <v-expansion-panel key="configuration">
      <v-expansion-panel-header color="grey lighten-4">
        <h3>{{ $t('help.config.title') }}</h3>
      </v-expansion-panel-header>
      <v-expansion-panel-content>
        <p>{{ $t('help.config.subtitle') }}</p>
        <v-expansion-panels focusable accordion tile>
          <v-expansion-panel key="theme">
            <v-expansion-panel-header>
              <h4>{{ $t('help.config.submenu.theme.title') }}</h4>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <div>
                <Messages
                  :value="$t('help.config.submenu.theme.messages')[0]"
                />
                <v-stepper v-model="steppes" vertical>
                  <v-stepper-header>
                    <v-stepper-step
                      :complete="steppes > 1"
                      step="1"
                      editable
                      :edit-icon="1"
                      color="primary"
                    /><v-divider />
                    <v-stepper-step
                      :complete="steppes > 2"
                      step="2"
                      editable
                      :edit-icon="2"
                      color="primary"
                    /><v-divider />
                    <v-stepper-step
                      :complete="false"
                      step="3"
                      editable
                      :edit-icon="3"
                      color="primary"
                    />
                  </v-stepper-header>
                  <v-stepper-items>
                    <v-stepper-content step="1">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="$t('help.config.submenu.theme.messages')[1]"
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}menu.png`"
                            max-width="250px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="success" text @click="steppes = 2"
                            >Suite <v-icon>mdi-fast-forward</v-icon></v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                    <v-stepper-content step="2">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="$t('help.config.submenu.theme.messages')[2]"
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}theme-choix.png`"
                            max-width="400px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-btn color="success" text @click="steppes = 1"
                            ><v-icon>mdi-rewind</v-icon> Retour</v-btn
                          >
                          <v-spacer></v-spacer>
                          <v-btn color="success" text @click="steppes = 3"
                            >Suite <v-icon>mdi-fast-forward</v-icon></v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                    <v-stepper-content step="3">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="$t('help.config.submenu.theme.messages')[3]"
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}theme-config.png`"
                            max-width="400px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-btn color="success" text @click="steppes = 2"
                            ><v-icon>mdi-rewind</v-icon> Retour</v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                  </v-stepper-items>
                </v-stepper>
                <v-alert dense border="left" type="info" outlined>{{
                  $t('help.config.submenu.saveMessage')
                }}</v-alert>
              </div>
            </v-expansion-panel-content>
          </v-expansion-panel>
          <v-expansion-panel key="reussite">
            <v-expansion-panel-header>
              <h4>{{ $t('help.config.submenu.successAnimation.title') }}</h4>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <div>
                <Messages
                  :value="
                    $t('help.config.submenu.successAnimation.messages')[0]
                  "
                />
                <v-stepper v-model="steppes" vertical>
                  <v-stepper-header>
                    <v-stepper-step
                      :complete="steppes > 1"
                      step="1"
                      editable
                      :edit-icon="1"
                      color="primary"
                    /><v-divider />
                    <v-stepper-step
                      :complete="steppes > 2"
                      step="2"
                      editable
                      :edit-icon="2"
                      color="primary"
                    /><v-divider />
                    <v-stepper-step
                      :complete="false"
                      step="3"
                      editable
                      :edit-icon="3"
                      color="primary"
                    />
                  </v-stepper-header>
                  <v-stepper-items>
                    <v-stepper-content step="1">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="
                              $t(
                                'help.config.submenu.successAnimation.messages'
                              )[1]
                            "
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}menu.png`"
                            max-width="250px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="success" text @click="steppes = 2"
                            >Suite <v-icon>mdi-fast-forward</v-icon></v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                    <v-stepper-content step="2">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="
                              $t(
                                'help.config.submenu.successAnimation.messages'
                              )[2]
                            "
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}reussite-choix.png`"
                            max-width="400px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-btn color="success" text @click="steppes = 1"
                            ><v-icon>mdi-rewind</v-icon> Retour</v-btn
                          >
                          <v-spacer></v-spacer>
                          <v-btn color="success" text @click="steppes = 3"
                            >Suite <v-icon>mdi-fast-forward</v-icon></v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                    <v-stepper-content step="3">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="
                              $t(
                                'help.config.submenu.successAnimation.messages'
                              )[3]
                            "
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}reussite-config.png`"
                            max-width="400px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-btn color="success" text @click="steppes = 2"
                            ><v-icon>mdi-rewind</v-icon> Retour</v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                  </v-stepper-items>
                </v-stepper>
                <v-alert dense border="left" type="info" outlined>{{
                  $t('help.config.submenu.saveMessage')
                }}</v-alert>
              </div>
            </v-expansion-panel-content>
          </v-expansion-panel>
          <v-expansion-panel key="invites">
            <v-expansion-panel-header>
              <h4>{{ $t('help.config.submenu.guest.title') }}</h4>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <div>
                <v-stepper v-model="steppes" vertical>
                  <v-stepper-header>
                    <v-stepper-step
                      :complete="steppes > 1"
                      step="1"
                      editable
                      :edit-icon="1"
                      color="primary"
                    /><v-divider />
                    <v-stepper-step
                      :complete="steppes > 2"
                      step="2"
                      editable
                      :edit-icon="2"
                      color="primary"
                    /><v-divider />
                    <v-stepper-step
                      :complete="false"
                      step="3"
                      editable
                      :edit-icon="3"
                      color="primary"
                    />
                  </v-stepper-header>
                  <v-stepper-items>
                    <v-stepper-content step="1">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="$t('help.config.submenu.guest.messages')[0]"
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}menu.png`"
                            max-width="250px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="success" text @click="steppes = 2"
                            >Suite <v-icon>mdi-fast-forward</v-icon></v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                    <v-stepper-content step="2">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="$t('help.config.submenu.guest.messages')[1]"
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}invite-liste.png`"
                            max-width="600px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-btn color="success" text @click="steppes = 1"
                            ><v-icon>mdi-rewind</v-icon> Retour</v-btn
                          >
                          <v-spacer></v-spacer>
                          <v-btn color="success" text @click="steppes = 3"
                            >Suite <v-icon>mdi-fast-forward</v-icon></v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                    <v-stepper-content step="3">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="$t('help.config.submenu.guest.messages')[2]"
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}invite-detail.png`"
                            max-width="400px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-btn color="success" text @click="steppes = 2"
                            ><v-icon>mdi-rewind</v-icon> Retour</v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                  </v-stepper-items>
                </v-stepper>
                <v-alert dense border="left" type="info" outlined>{{
                  $t('help.config.submenu.saveMessage')
                }}</v-alert>
              </div>
            </v-expansion-panel-content>
          </v-expansion-panel>
          <v-expansion-panel key="tables">
            <v-expansion-panel-header>
              <h4>{{ $t('help.config.submenu.table.title') }}</h4>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <div>
                <v-stepper v-model="steppes" vertical>
                  <v-stepper-header>
                    <v-stepper-step
                      :complete="steppes > 1"
                      step="1"
                      editable
                      :edit-icon="1"
                      color="primary"
                    /><v-divider />
                    <v-stepper-step
                      :complete="steppes > 2"
                      step="2"
                      editable
                      :edit-icon="2"
                      color="primary"
                    /><v-divider />
                    <v-stepper-step
                      :complete="false"
                      step="3"
                      editable
                      :edit-icon="3"
                      color="primary"
                    />
                  </v-stepper-header>
                  <v-stepper-items>
                    <v-stepper-content step="1">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="$t('help.config.submenu.table.messages')[0]"
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}menu.png`"
                            max-width="250px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="success" text @click="steppes = 2"
                            >Suite <v-icon>mdi-fast-forward</v-icon></v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                    <v-stepper-content step="2">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="$t('help.config.submenu.table.messages')[1]"
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}table-ajout.png`"
                            max-width="600px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-btn color="success" text @click="steppes = 1"
                            ><v-icon>mdi-rewind</v-icon> Retour</v-btn
                          >
                          <v-spacer></v-spacer>
                          <v-btn color="success" text @click="steppes = 3"
                            >Suite <v-icon>mdi-fast-forward</v-icon></v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                    <v-stepper-content step="3">
                      <v-card>
                        <v-card-title>
                          <Messages
                            :value="$t('help.config.submenu.table.messages')[2]"
                          />
                        </v-card-title>
                        <v-card-text>
                          <v-img
                            :src="`${imgFolder}table-modification.png`"
                            max-width="600px"
                          ></v-img>
                        </v-card-text>
                        <v-card-actions>
                          <v-btn color="success" text @click="steppes = 2"
                            ><v-icon>mdi-rewind</v-icon> Retour</v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </v-stepper-content>
                  </v-stepper-items>
                </v-stepper>
                <v-alert dense border="left" type="info" outlined>{{
                  $t('help.config.submenu.saveMessage')
                }}</v-alert>
              </div>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>
      </v-expansion-panel-content>
    </v-expansion-panel>
    <v-expansion-panel key="apercu">
      <v-expansion-panel-header color="grey lighten-4">
        <h3>{{ $t('help.preview.title') }}</h3>
      </v-expansion-panel-header>
      <v-expansion-panel-content>
        <v-alert dense border="left" type="warning" class="ma-2">{{
          $t('help.preview.warning')
        }}</v-alert>
        <div>
          <v-stepper v-model="steppes" vertical>
            <v-stepper-header>
              <v-stepper-step
                :complete="steppes > 1"
                step="1"
                editable
                :edit-icon="1"
                color="primary"
              /><v-divider />
              <v-stepper-step
                :complete="steppes > 2"
                step="2"
                editable
                :edit-icon="2"
                color="primary"
              /><v-divider />
              <v-stepper-step
                :complete="false"
                step="3"
                editable
                :edit-icon="3"
                color="primary"
              />
            </v-stepper-header>
            <v-stepper-items>
              <v-stepper-content step="1">
                <v-card>
                  <v-card-title>
                    <Messages :value="$t('help.preview.messages')[0]" />
                  </v-card-title>
                  <v-card-text>
                    <v-img
                      :src="`${imgFolder}apercu-go.png`"
                      max-width="250px"
                    ></v-img>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="success" text @click="steppes = 2"
                      >Suite <v-icon>mdi-fast-forward</v-icon></v-btn
                    >
                  </v-card-actions>
                </v-card>
              </v-stepper-content>
              <v-stepper-content step="2">
                <v-card>
                  <v-card-title>
                    <Messages :value="$t('help.preview.messages')[1]" />
                  </v-card-title>
                  <v-card-text>
                    <v-img
                      :src="`${imgFolder}apercu-open-menu.png`"
                      max-width="250px"
                    ></v-img>
                  </v-card-text>
                  <v-card-actions>
                    <v-btn color="success" text @click="steppes = 1"
                      ><v-icon>mdi-rewind</v-icon> Retour</v-btn
                    >
                    <v-spacer></v-spacer>
                    <v-btn color="success" text @click="steppes = 3"
                      >Suite <v-icon>mdi-fast-forward</v-icon></v-btn
                    >
                  </v-card-actions>
                </v-card>
              </v-stepper-content>
              <v-stepper-content step="3">
                <v-card>
                  <v-card-title>
                    <Messages :value="$t('help.preview.messages')[2]" />
                  </v-card-title>
                  <v-card-text>
                    <v-img
                      :src="`${imgFolder}apercu-menu.png`"
                      max-width="250px"
                    ></v-img>
                  </v-card-text>
                  <v-card-actions>
                    <v-btn color="success" text @click="steppes = 2"
                      ><v-icon>mdi-rewind</v-icon> Retour</v-btn
                    >
                  </v-card-actions>
                </v-card>
              </v-stepper-content>
            </v-stepper-items>
          </v-stepper>
        </div>
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';
import Messages from './Messages.vue';

/**
 * Aide de l'application
 */
@Component({
  name: 'Help',
  components: {
    Messages,
  },
})
export default class Help extends Vue {
  @Prop()
  imgFolder!: string;

  private steppes: number = 1;
}
</script>

<style scoped></style>
