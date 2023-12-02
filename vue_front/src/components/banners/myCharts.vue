<template>
  <v-content class="mcBanCha">
    <div class="mcbOverlay"></div>
    <v-container class="mbc-con">
      <v-row>
        <v-col sm="6">
          <div class="mbcVideo">
            <div class="mvEmbed">
              <iframe
                src="https://www.youtube.com/embed/7-oDHa4cmmk?rel=0&autoplay=1&loop=1&playlist=7-oDHa4cmmk&iv_load_policy=3&controls=0&showinfo=0"
                frameborder="0"
                allowfullscreen
              ></iframe>
            </div>
          </div>
        </v-col>
        <v-col sm="6">
          <div class="main-title">
            <h1>What you can do in My charts?</h1>
            <div class="mttl-line"></div>
          </div>
          <ul class="mbcPoints">
            <li>
              <v-icon>mdi-hand-pointing-right</v-icon>Interactive charts and unlimited data download
            </li>
            <li>
              <v-icon>mdi-hand-pointing-right</v-icon>Save any chart in Folders
            </li>
            <li>
              <v-icon>mdi-hand-pointing-right</v-icon>Edit the charts-Compare data from different series
            </li>
            <li>
              <v-icon>mdi-hand-pointing-right</v-icon>Make a note- Write down a text you want alongside the charts
            </li>
            <li>
              <v-icon>mdi-hand-pointing-right</v-icon>Arrange them in "List View" and "Small view" according to your need
            </li>
            <li>
              <v-icon>mdi-hand-pointing-right</v-icon>Download the chartbook in Powerpoint
            </li>
          </ul>
        </v-col>
      </v-row>
    </v-container>
  </v-content>
</template>
<style lang="scss">
@import "@/assets/_variables.scss";
.mcBanCha {
  background-image: url("../../assets/banner/mychart.jpg");
  color: $white;
  position: relative;
  .mbc-con {
    padding: 70px 0;
  }
  .mcbOverlay {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    background-color: rgba($color: #000000, $alpha: 0.7);
  }
  .mbcVideo {
    display: block;
    width: 525px;
    height: 419px;
    padding: 20px;
    background-image: url("../../assets/banner/desktop.png");
    background-size: cover;
    background-repeat: no-repeat;
    position: relative;
  }
  .mvEmbed {
    position: relative;
    width: 100%;
    padding-top: 56.25%;
    iframe {
      position: absolute;
      top: 0;
      right: 0;
      width: 100% !important;
      height: 100% !important;
    }
  }
  .main-title h1 {
    font-size: 2rem;
  }
  .mbcPoints {
    list-style: none;
    padding-left: 0;
    font-size: 1.4rem;
    position: relative;
    li {
      margin-bottom: 10px;
    }
    .v-icon {
      padding-right: 10px;
      font-size: 1.9rem;
      color: $white;
    }
  }
}
</style>