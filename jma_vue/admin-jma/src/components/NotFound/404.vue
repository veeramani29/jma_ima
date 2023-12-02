<template>
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
              <img src="@/assets/404.png" />
        </v-row>
      </v-container>
    </v-content>
</template>
<script>
export default {
  data: () => ({
    notFound: {
        pic: require("@/assets/404.png")
      },
  }),
  methods: {
    
  }
};
</script>
