<template>
  <div>
    <v-card>
      <v-card-title>View Map</v-card-title>
      <v-card-actions>
        <v-snackbar v-model="snackbar">
          {{ notification }}
          <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-data-table
          calculate-widths
          :headers="headers"
          :items="mapView"
          :items-per-page="5"
          class="elevation-1 full-width"
          :search="search"
        >
          <template v-slot:item.y_value="{ item }">
            <v-row>
              <v-col cols="12">{{ item.y_value }}-{{ item.y_sub_value }}</v-col>
            </v-row>
          </template>
          <template v-slot:item.gid="{ item }">
            <v-row>
              <v-col cols="12">
                {{ item.gid }}-
                {{
                  mapView
                    .map(function(x) {
                      return x.vid;
                    })
                    .indexOf(item.vid)
                }}</v-col
              >
            </v-row>
          </template>
        </v-data-table>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  data: () => ({
    pagination: {
      sortBy: "name"
    },
    snackbar: false,
    notification: "Something went wrong",
    mapId: "",
    search: "",
    index: "",
    dialog: false,
    mapView: [],
    headers: [
      { text: "Id", value: "gid" },
      { text: "Column", value: "y_value" }
    ]
  }),

  methods: {},
  created() {
    const ViewComponent = {
      map_id: this.$route.params.id
    };
    this.axios
      .post(this.nodejsServer + "map/getMapView", ViewComponent)
      .then(response => {
        if (!response.data.err_code) {
          this.mapView = response.data;
        } else {
          this.notification = response.data.message;
          this.snackbar = true;
        }
      });
  }
};
</script>
