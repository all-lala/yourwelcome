<template>
  <div :style="styleGlobal" class="imageUploader" @click="onClickFile" :title="title || label || $t('selectImg')">
    <input type="file" ref="file" accept="image/*" @change="saveImg" class="inputFile" />
    <p v-if="!imgUrl && !isOnUpload">{{ label || $t('selectImg') }}</p>
    <img
      v-if="imgUrl && !isOnUpload"
      :src="imgUrl"
      :alt="label || $t('selectImg')"
      :class="{imageUploaded: true, imageNotLoaded: !imageLoaded}"
      @load="onImgLoad"
    />
    <v-progress-circular
      v-if="imgUrl && !imageLoaded && !isOnUpload"
      :size="70"
      :width="7"
      color="purple"
      indeterminate
    ></v-progress-circular>
    <v-progress-circular
      v-if="isOnUpload"
      :rotate="360"
      :size="100"
      :width="15"
      :value="progress"
      color="teal"
    >{{ progress }}</v-progress-circular>
  </div>
</template>

<i18n>
{
  "fr": {
    "selectImg": "Choisir une image.",
    "notSupported": "Type de fichier non supporté."
  }
}
</i18n>

<script lang="ts">
import { Vue, Component, Prop, Watch } from 'vue-property-decorator';

/**
 * Composant d'upload d'image
 */
@Component({
  name: 'ImageUploader',
})
export default class ImageUploader extends Vue {

  @Prop({ default: `/` })
  private sendUrl!: string;

  @Prop({ default: '100%' })
  private width!: string;

  @Prop({ default: '15em' })
  private height!: string;

  @Prop()
  private imgUrl!: string;

  @Prop({ default: '' })
  private label!: string;

  @Prop({ default: '' })
  private title!: string;

  @Prop({ default: '#00000000' })
  private bgcolor!: string;

  private imageTmp: string = '';

  private progress: number = 0;

  private isOnUpload: boolean = false;

  private loadingError: boolean = false;

  private imageLoaded: boolean = false;

  /**
   * Retourne le style de la page
   */
  get styleGlobal() {
    return {
      width: this.width,
      height: this.height,
      background: this.bgcolor,
    };
  }

  /**
   * Action au clic sur la sélection de fichier (input file)
   */
  onClickFile() {
    (this.$refs.file as Vue & { click: () => void }).click();
  }

  /**
   * Evenement déclenché à la fin du chargement de l'image
   */
  onImgLoad() {
    this.imageLoaded = true;
  }

  /**
   * Action de sauvegarde de l'image
   */
  saveImg(event: any) {
    const image = event.target.files[0];
    if (image && image.type && image.type.indexOf('image/') === -1) {
      alert(this.$t('notSupported').toString());
      this.loadingError = true;
      return;
    }
    if (image) {
      this.imageLoaded = false;
      this.loadingError = false;
      this.isOnUpload = true;
      this.progress = 0;
      const formData = new FormData();
      formData.append('image', image);
      this.$axios
        .post(this.sendUrl, formData, {
          onUploadProgress: this.uplaodProgress,
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(response => {
          this.progress = 100;
          if (response.data) {
            this.$emit('onFileLoaded', response.data);
          }
          this.isOnUpload = false;
        })
        .catch(error => {
          this.loadingError = true;
          console.error(error);
        });
    }
  }

  /**
   * Evenement de progression de l'upload
   */
  uplaodProgress(progressEvent: ProgressEvent) {
    this.progress = Math.round(
      (progressEvent.loaded * 100) / progressEvent.total,
    );
  }
}
</script>

<style scope>
.imageUploader {
  border: 1px solid grey;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  overflow: hidden;
}

.imageNotLoaded {
  display: none;
}

.imageUploaderContainer {
  width: 100%;
  height: 100%;
}

.imageUploader:hover {
  background: rgb(180, 180, 180);
}

.imageUploaded {
  width: auto;
  max-width: 100%;
  height: auto;
  max-height: 100%;
}

.inputFile {
  display: none;
}
</style>
