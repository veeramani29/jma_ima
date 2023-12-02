<template>
  <v-content>
    <v-row justify="center">
      <v-dialog v-model="modalData" persistent max-width="690">
        <v-card>
          <v-card-title class="headline">
            Introduction to IMA
            <v-spacer></v-spacer>
            <v-btn text @click="stop">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <youtube
            ref="youtube"
              video-id="lG0Ys-2d4MA"
              :player-vars="{ autoplay: 1 }"
            ></youtube>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="toggleModal()"
              >Agree</v-btn
            >
            <!-- https://github.com/anteriovieira/vue-youtube#installation -->
            <!-- https://www.npmjs.com/package/vue-youtube -->
            <!-- https://www.npmjs.com/package/youtube-vue https://github.com/kaorun343/vue-youtube-embed -->
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </v-content>
</template>
<script>
export default {
  computed: {
    modalData() {
      return this.$store.state.introVideo;
    }
  },
  // updated(){
  //   this.$refs.youtube.player.playVideo()
  // },
  methods: {
    toggleModal() {
      this.$store.state.introVideo = !this.$store.state.introVideo;
      this.$refs.youtube.player.stopVideo()
      // this.player.stopVideo();
    },
    stop() {
      this.$refs.youtube.player.stopVideo()
      this.$store.state.introVideo = !this.$store.state.introVideo;
    }
  }
};
</script>
