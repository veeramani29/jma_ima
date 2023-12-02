<template>
  <div>
    <v-card>
      <v-card-title>Cache Settings</v-card-title>
      <v-container class="grey lighten-5">
        <v-row>
          <v-col cols="12" sm="4">
            <v-card>
              <v-card-actions>
                <v-btn color="error" @click="clearCache()">Clear Cache</v-btn>
              </v-card-actions>
              <v-list-item three-line>
                <v-list-item-content>
                  <v-list-item-title class="headline mb-1"
                    >List of Cache</v-list-item-title
                  >
                  <v-list class="chcLisIte" dense>
                    <v-list-item v-for="item in items" :key="item">
                      <v-list-item-content>
                        <v-list-item-subtitle
                          v-text="item"
                        ></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </v-list-item-content>
              </v-list-item>
            </v-card>
          </v-col>
          <v-col cols="12" sm="4">
            <v-card>
              <v-list-item three-line>
                <v-list-item-content>
                  <v-list-item-title class="headline mb-1"
                    >Archive Downloads</v-list-item-title
                  >
                  <v-list-item-subtitle
                    >Click download button to get archive data download track
                    history.</v-list-item-subtitle
                  >
                </v-list-item-content>
              </v-list-item>
              <v-card-actions>
                <v-btn color="error"
                  ><a
                    target="_blank"
                    href="https://www.indiamacroadvisors.com/storage/logs/archive_download_track.txt"
                    download
                    >Download</a
                  ></v-btn
                >
              </v-card-actions>
            </v-card>
          </v-col>
          <v-col cols="12" sm="4">
            <v-card>
              <v-list-item three-line>
                <v-list-item-content>
                  <v-list-item-title class="headline mb-1"
                    >Weekly Report</v-list-item-title
                  >
                  <v-list-item-subtitle
                    >Click download button to download weekly report about data
                    downlod Cache Settings.</v-list-item-subtitle
                  >
                </v-list-item-content>
              </v-list-item>
              <v-card-actions>
                <v-btn color="error"
                  ><a href="https://www.indiamacroadvisors.com/storage/logs/chart_download_track.txt" target="_blank" download
                    >Download</a
                  ></v-btn
                >
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </div>
</template>

<script>
export default {
  data: () => ({
    // item: 1,
    archiveURL: "",
    weeklyReportURL: "",
    items: []
  }),
  created() {
    this.archiveURL = this.uploadsURL + "uploads/archive_download_track.txt";
    this.weeklyReportURL = this.uploadsURL + "uploads/chart_download_track.txt";
    this.axios.get(this.nodejsServer + "settings/getallkeys").then(response => {
      if (!response.data.err_code) {
        this.items = response.data;
      } else {
        this.notification = response.data.message;
        this.snackbar = true;
      }
    });
  },
  methods: {
    clearCache() {
      this.axios
        .get(this.nodejsServer + "settings/deleteallkeys")
        .then(response => {
          if (!response.data.err_code) {
            this.items = [];
          } else {
            this.notification = response.data.message;
            this.snackbar = true;
          }
        });
    }
  }
};
</script>
<style lang="scss">
.chcLisIte {
  width: 100%;
  .v-list-item {
    padding: 0;
  }
}
</style>
