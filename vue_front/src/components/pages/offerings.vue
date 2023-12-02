<template>
  <v-content>
    <ksvuefp :options="options" :sections="sections">
      // Where options is an object of options, and sections an array containing
      our sections datas

      <ksvuefp-section
        class="whatever"
        v-for="(s, index) in sections"
        :section="s"
        :key="s.id"
        :section-index="index"
        :background-image="'url(' + s.img_url + ')'"
        :background-color="'#123456'"
      >
        <h2>{{ s.any_data }}</h2>
      </ksvuefp-section>
    </ksvuefp>
  </v-content>
</template>
<script>
export default {
  data() {
    return {
      sections: [
        {
          id: 1,
          any_data: "I'm section 1",
          img_url: "./images/whatever01.jpg"
        },
        {
          id: 2,
          any_data: "I'm section 2",
          img_url: "./images/whatever02.jpg"
        },
        {
          id: 3,
          any_data: "I'm section 3",
          img_url: "./images/whatever03.jpg"
        }
      ],
      // See below for a list of default options
      options: {
        duration: 800,
        easing: [1, 0, 0, 1],
        loopBottom: true
      }
    };
  }
};
</script>
