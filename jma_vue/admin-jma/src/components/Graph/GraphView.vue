<template>
  <div>
    <v-card>
      <v-card-title>View Graph</v-card-title>
      <v-card-actions>
        <v-snackbar v-model="snackbar">
          {{ notification }}
          <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-data-table
          calculate-widths
          :headers="headers"
          :items="graphView"
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
                {{ item.gid }}-{{
                  graphView
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
    snackbar: false,
    notification: "Something went wrong",
    search: "",
    index: "",
    dialog: false,
    graphId: "",
    graphView: [],
    headers: [
      { text: "Id", value: "gid" },
      { text: "Column", value: "y_value" }
    ]
  }),

  methods: {},
  created() {
    const ViewComponent = {
      graph_id: this.$route.params.id
    };
    this.axios
      .post(this.nodejsServer + "graph/getGraphView", ViewComponent)
      .then(response => {
        if (!response.data.err_code) {
          this.graphView = response.data;
        } else {
          this.notification = response.data.message;
          this.snackbar = true;
        }
      });
  }
};
</script>
