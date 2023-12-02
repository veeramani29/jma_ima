<template>
  <v-content>
    <div class="areaMyChart">
      <v-tabs-items v-model="tab" class>
        <v-tab-item value="charts">
          <highcharts :options="chartOptions"></highcharts>
        </v-tab-item>
        <v-tab-item value="table">Table</v-tab-item>
      </v-tabs-items>
      <div class="mcHead">
        <v-menu
          top
          right
          offset-y
          :close-on-content-click="closeOnContentClick"
          content-class="caMdown"
        >
          <template v-slot:activator="{ on }">
            <v-btn text v-on="on">
              <v-icon>mdi-menu</v-icon>Menu
            </v-btn>
          </template>
          <v-list dense>
            <v-list-item>
              <v-icon>mdi-content-copy</v-icon>Duplicate
            </v-list-item>
            <v-list-item>
              <v-icon>mdi-note-outline</v-icon>Make a note
            </v-list-item>
            <v-list-item>
              <v-icon>mdi-close-outline</v-icon>Delete
            </v-list-item>
            <v-list-item>
              <v-icon>mdi-briefcase-download-outline</v-icon>Download data
            </v-list-item>
            <v-list-item>
              <v-icon>mdi-file-export-outline</v-icon>Export
            </v-list-item>
            <v-list-item>
              <v-icon>mdi-aaa</v-icon>Duplicate
            </v-list-item>
          </v-list>
        </v-menu>
        <v-btn text @click.stop="toggleModal()">
          <v-icon>mdi-vector-polyline-edit</v-icon>Edit
        </v-btn>
        <v-tabs v-model="tab" text right class="mychTabs">
          <v-tabs-slider></v-tabs-slider>
          <v-tab href="#charts">
            <v-icon>mdi-chart-areaspline</v-icon>Charts
          </v-tab>
          <v-tab href="#table">
            <v-icon>mdi-table</v-icon>Table
          </v-tab>
        </v-tabs>
      </div>
    </div>
  </v-content>
</template>
<script>
import { Chart } from "highcharts-vue";
export default {
  components: {
    highcharts: Chart
  },
  data() {
    return {
      downloadChart: [
        "Data (CSV)",
        "Image (JPEG)",
        "Image (PNG)",
        "Document (PDF)",
        "PowerPoint (PPTX)"
      ],
      closeOnContentClick: false,
      chartOptions: {
        chart: {
          type: "spline"
        },
        title: {
          text: "Sin chart"
        },
        series: [
          {
            data: [10, 0, 8, 2, 6, 4, 5, 5],
            color: "#6fcd98"
          }
        ]
      },
      tab: null
    };
  },
  methods: {
    toggleModal() {
      this.$store.state.signInModal = !this.$store.state.signInModal;
    }
  }
};
</script>
<style lang="scss" scoped>
@import "@/assets/_variables.scss";
.areaMyChart {
  .mcHead {
    background-color: $lGray;
    border: 1px solid $lGray-d;
    border-width: 1px 0 0 1px;
    border-radius: 5px 0 0;
    position: relative;
    padding-right: 5px;
    display: flex;
    > .v-btn--flat.v-size--default .v-icon {
      font-size: 17px;
    }
  }
}
.caVmenu,
.caVedit {
  .v-list {
    display: flex;
  }
  .v-list-item {
    min-height: 32px;
    padding: 0 12px;

    .v-icon {
      font-size: 17px;
    }
    .mdi-facebook {
      color: #3b5998;
    }

    .mdi-twitter {
      color: #00acee;
    }

    .mdi-google-plus {
      color: #dd4b39;
    }

    .mdi-linkedin {
      color: #0e76a8;
    }
  }
  .cavNotes {
    span {
      font-size: 10px;
      color: $color-red;
      padding-right: 8px;
    }
  }
}
.caVedit {
  .v-list {
    flex-wrap: wrap;
    width: 154px;
    padding-bottom: 3px;
  }
  .v-list-item {
    flex: none;
  }
}
.caMdown {
  .v-list-item {
    min-height: 28px;
    padding: 0 9px;
    font-size: 0.8rem;
  }
  .v-icon {
    padding-right: 7px;
    font-size: 1rem;
  }
}
</style>
