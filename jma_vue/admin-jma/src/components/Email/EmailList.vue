<template>
  <div>
    <v-card>
      <v-card-title>Email List</v-card-title>
      <v-card-actions>
        <v-snackbar v-model="snackbar">
            {{ notification }}
            <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-data-table
          calculate-widths
          :headers="headers"
          :items="companyList"
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
          <template v-slot:item.action="{ item }">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <router-link :to="/EmailEdit/ + item.email_templates_id">
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
    email_id: "",
    search: "",
    index: "",
    dialog: false,
    companyList: [],
    headers: [
      { text: "Id", value: "email_templates_id" },
      { text: "Email Code", value: "email_templates_code" },
      { text: "Subject", value: "email_templates_subject" },
      { text: "Email Variable", value: "email_templates_variable" },
      { text: "Options", value: "action", sortable: false }
      // have to work on user type, status and expiry
    ]
  }),

  methods: {
    deleteItem(item) {
      this.index = this.companyList.indexOf(item);
      this.email_id = item.email_templates_id;
      this.dialog = true;
    },

    close() {
      this.dialog = false;
    },
    deletedItem() {
      var ind = this.index;
      var delete_id = { id: this.email_id };
      this.axios.post(this.nodejsServer + "emailTemplates/deleteEmailTemplates", delete_id).then((response) => {
        if(!response.data.err_code){
          this.companyList.splice(ind, 1);
          this.dialog = false;
        } else {
          this.notification = response.data.message;
          this.snackbar = true;
        }
      });
    }
  },
  created() {
    this.axios.get(this.nodejsServer + "emailTemplates/getEmailTemplates").then((response) => {
      if(!response.data.err_code){
        this.companyList = response.data;
      } else {
        this.notification = response.data.message;
        this.snackbar = true;
      }
    });
  }
};
</script>
