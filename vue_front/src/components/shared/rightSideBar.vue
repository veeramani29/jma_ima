<template>
  <v-content>
    <div class="sub-title">
			<h5>IMA in the media</h5>
			<div class="sttl-line"></div>
		</div>
    <v-carousel>
      <v-carousel-item v-for="(color, i) in colors" :key="color" :vertical-delimiters="vSlider">
        <v-sheet :color="color" height="100%" tile>
          <v-row class="fill-height" align="center" justify="center">
            <div class="display-3">Slide {{ i + 1 }}</div>
          </v-row>
        </v-sheet>
      </v-carousel-item>
    </v-carousel>
  </v-content>
</template>
<script>
export default {
  data() {
    return {
      colors: ["primary", "secondary", "yellow darken-2", "red", "orange"],
      vSlider: true
    };
  }
};
</script>