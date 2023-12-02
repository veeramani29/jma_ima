<template>
  <div>
    <v-card>
      <v-card-title>Media List</v-card-title>
        <v-snackbar v-model="snackbar">
          {{ notification }}
          <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
      <v-card-actions>
        <v-data-table
          calculate-widths
          :headers="headers"
          :items="mediaList"
          :items-per-page="5"
          class="elevation-1 full-width"
          :search="search"
        >
          <template v-slot:top>
            <v-dialog v-model="dialog" max-width="500px">
              <v-card>
                <v-card-title>
                  <span class="headline">Delete Item</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <h3>Are You Sure to delete This Item</h3>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="deletedItem">Delete</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-text-field v-model="search" label="Search Key word" class="mx-4"></v-text-field>
          </template>
          <template v-slot:item.mediaLink="{ item }">
            <v-btn small :href="item.media_link" target="_blank" color="primary">View File</v-btn>
          </template>
          <template v-slot:item.action="{ item }">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <router-link :to="/MediaEdit/+item.media_id">
                  <v-icon small class="mr-2" v-on="on">edit</v-icon>
                </router-link>
              </template>
              <span>Edit</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-icon small @click="deleteItem(item)" v-on="on">delete</v-icon>
              </template>
              <span>Delete</span>
            </v-tooltip>
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
    mediaId: "",
    mediaList: [],
    headers: [
      { text: "Id", value: "media_id" },
      { text: "Notice", value: "media_notice" },
      { text: "Sort", value: "media_sort" },
      { text: "Media text", value: "media_value_text" },
      { text: "Media Image", value: "post_category_parent_id" },
      { text: "Media Link", value: "mediaLink" },
      { text: "Date", value: "media_date" },
      { text: "Options", value: "action", sortable: false }
    ]
  }),

  methods: {
    deleteItem(item) {
      this.index = this.mediaList.indexOf(item);
      this.mediaId = item.media_id;
      this.dialog = true;
    },
    editItem() {
      window.location.href = "MediaEdit.js";
    },
    close() {
      this.dialog = false;
    },
    deletedItem() {
      var ind = this.index;
      var delete_id = { id: this.mediaId };
      this.axios.post(this.nodejsServer +'map/deleteMedia',delete_id).then((response) => {
        if(!response.data.err_code){
          this.mediaList.splice(ind, 1);
          this.dialog = false;
        } else {
          this.notification = response.data.message;
          this.snackbar = true;
        }
      });
      
    }
  },
  created() {
    this.axios.get(this.nodejsServer + "media/getMedia").then(response => {
      if(!response.data.err_code){
      this.mediaList = response.data;
      } else {
          this.notification = response.data.message;
          this.snackbar = true;
      }
    })
    .catch(function() {
      this.snackbar = true;
    });
  }
};
</script> 