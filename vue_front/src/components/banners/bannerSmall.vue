<template>
  <v-content>
    <div class="indexBanner">
      <img src="@/assets/banner/smallslider.jpg" alt="main banner" />
      <div class="ibContent">
        <v-container>
          <v-row justify="center">
            <v-col sm="6" class="icAutCon">
              <v-autocomplete
                v-model="select"
                :items="items"
                :search-input.sync="search"
                cache-items
                flat
                hide-no-data
                hide-details
                label="What state are you from?"
                solo
              ></v-autocomplete>
              <v-btn color="primary">Search</v-btn>
            </v-col>
          </v-row>
          <v-row justify="center">
            <v-col sm="8">
              <h1>CONCISE AND INSIGHTFUL ANALYSIS ON THE INDIAN ECONOMY</h1>
            </v-col>
          </v-row>
          <v-row class="icBtns">
            <v-col sm="6">
              <v-btn color="primary" to="/registration">
                <v-icon>mdi-account-plus-outline</v-icon>Register for a Free
                account
              </v-btn>
              <v-btn color="primary" @click="toggleModal()">
                <v-icon>mdi-information-outline</v-icon>Introduction to IMA
              </v-btn>
            </v-col>
          </v-row>
        </v-container>
      </div>
    </div>
    <IntroductionVideo />
  </v-content>
</template>
<script>
import IntroductionVideo from "@/components/shared/modals/introductionVideo";
export default {
  components: {
    IntroductionVideo
  },
  data() {
    return {
      items: [],
      search: null,
      select: null,
      states: [
        "Alabama",
        "Alaska",
        "American Samoa",
        "Arizona",
        "Arkansas",
        "California",
        "Colorado",
        "Connecticut",
        "Delaware",
        "District of Columbia",
        "Federated States of Micronesia",
        "Florida",
        "Georgia",
        "Guam",
        "Hawaii",
        "Idaho",
        "Illinois",
        "Indiana",
        "Iowa",
        "Kansas",
        "Kentucky",
        "Louisiana",
        "Maine",
        "Marshall Islands",
        "Maryland",
        "Massachusetts",
        "Michigan",
        "Minnesota",
        "Mississippi",
        "Missouri",
        "Montana",
        "Nebraska",
        "Nevada",
        "New Hampshire",
        "New Jersey",
        "New Mexico",
        "New York",
        "North Carolina",
        "North Dakota",
        "Northern Mariana Islands",
        "Ohio",
        "Oklahoma",
        "Oregon",
        "Palau",
        "Pennsylvania",
        "Puerto Rico",
        "Rhode Island",
        "South Carolina",
        "South Dakota",
        "Tennessee",
        "Texas",
        "Utah",
        "Vermont",
        "Virgin Island",
        "Virginia",
        "Washington",
        "West Virginia",
        "Wisconsin",
        "Wyoming"
      ]
    };
  },
  watch: {
    search(val) {
      val && val !== this.select && this.querySelections(val);
    }
  },
  methods: {
    querySelections(v) {
      this.loading = true;
      // Simulated ajax query
      setTimeout(() => {
        this.items = this.states.filter(e => {
          return (e || "").toLowerCase().indexOf((v || "").toLowerCase()) > -1;
        });
        this.loading = false;
      }, 500);
    },
    toggleModal() {
      this.$store.state.introVideo = !this.$store.state.introVideo;
    }
  }
};
</script>
<style lang="scss">
.indexBanner {
  .icAutCon {
    .v-input__append-inner {
      display: none;
    }
  }
}
</style>
<style lang="scss" scoped>
.indexBanner {
  width: 100%;
  height: 318px;
  margin: 0 auto;
  overflow: hidden;
  position: relative;
  img {
    max-width: unset;
    position: absolute;
  }
  // @-webkit-keyframes move {
  //   from {
  //     transform: scale(0.9);
  //     -ms-transform: scale(0.9);
  //     -webkit-transform: scale(0.9);
  //     -o-transform: scale(0.9);
  //     -moz-transform: scale(0.9);
  //   }
  //   to {
  //     transform: scale(1);
  //     -ms-transform: scale(1);
  //     -webkit-transform: scale(1);
  //     -o-transform: scale(1);
  //     -moz-transform: scale(1);
  //   }
  // }
  .icAutCon {
    display: flex;
    .v-input {
      border-radius: 0;
    }
    .v-btn {
      height: 100%;
      border-radius: 0;
      width: 107px;
    }
  }
  .ibContent {
    padding: 25px 0;
    h1 {
      text-align: center;
      position: relative;
      font-weight: 700;
      color: #ffffff;
      text-shadow: 2px 3px 4px #333333;
    }
  }
  .icBtns {
    justify-content: center;
    text-align: center;
    .v-btn {
      height: 34px;
      font-size: 13px;
      margin: 0 5px;
    }
    .v-icon {
      font-size: 17px;
      margin-right: 7px;
    }
  }
}
</style>
