<template>
  <div>
    <v-card>
      <v-card-title>Homapage Graph (What's New)</v-card-title>
      <v-card-actions>
        <v-container>
          <v-row>
            <v-snackbar v-model="snackbar">
              {{ notification }}
              <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
            </v-snackbar>
            <v-col cols="12">
              <v-simple-table>
                <template v-slot:default>
                  <tbody>
                    <tr>
                      <th>Graph Title</th>
                      <td>{{ graphList.title }}</td>
                    </tr>
                    <tr>
                      <th>Description</th>
                      <td>{{ graphList.description }}</td>
                    </tr>
                    <tr>
                      <th>Graph Code</th>
                      <td>{{ graphCode }}</td>
                    </tr>
                    <tr>
                      <th>Report Link</th>
                      <td>{{ graphList.report_link }}</td>
                    </tr>
                    <tr>
                      <th>Published Date</th>
                      <td>{{ graphList.published_date }}</td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <div class="text-center">
                <v-btn color="primary" to="/IndexGraphEdit">Edit</v-btn>
              </div>
            </v-col>
          </v-row>
        </v-container>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  data: () => ({
    snackbar : false,
    notification:"Something went wrong",
    graphList:[],
    graphCode:"",
  }),
  created(){
    this.axios.get(this.nodejsServer + "graph/getHomePageGraph").then(response => {
      if(!response.data.err_code){
        this.graphList = response.data[0];
         this.graphCode = new Buffer( response.data[0].graph_code, 'binary' ).toString('utf8');
      } else {
        this.notification = response.data.message;
        this.snackbar = true;
      }
    });
  }
};
</script>
<style lang="scss" scoped>
.v-data-table__wrapper {
  tbody {
    tr > td:last-child {
      white-space: normal;
    }
    th {
      border-bottom: 1px solid rgba(0, 0, 0, 0.12);
      white-space: nowrap;
    }
    td {
      border-bottom: 1px solid rgba(0, 0, 0, 0.12);
    }
  }
}
</style>