import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n);

const baseLanguage = 'fr';

const navigatorLanguage = ((navigator.languages || [])[0] || navigator.language || baseLanguage).substring(0,2);

const languages : string[] = [baseLanguage];
if(navigatorLanguage !== baseLanguage){
  languages.push(navigatorLanguage);
}

const messages: any = {};

languages.forEach(lang => {
  try{
    messages[lang] = require(`./messages-${lang}`)
  } catch(e) {
    console.error('Language does not exists.');
  }
});

export default new VueI18n({
  locale: navigatorLanguage,
  fallbackLocale: baseLanguage,
  messages
})
