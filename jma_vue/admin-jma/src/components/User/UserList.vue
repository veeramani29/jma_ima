<template>
  <div>
    <v-card>
      <v-card-title>User List</v-card-title>
      <v-card-actions>
        <v-data-table
          calculate-widths
          :headers="headers"
          :items="userList"
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
          <template v-slot:item.registered_on="{ item }">
            <v-row>
              <v-col cols="12">{{DateConversion(item.registered_on)}}</v-col>
            </v-row>
          </template>
          <template v-slot:item.action="{ item }">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <router-link :to="/userEdit/ + item.id">
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
          <template v-slot:item.status="{ item }">
            <span v-if="item.user_post_alert === 'Y'">Active</span>
            <span v-else>Deactiveted</span>
          </template>
          <template v-slot:item.type="{ item }">
            <span>{{this.userType(item.user_type_id)}}</span>
          </template>
        </v-data-table>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  data: () => ({
    user_id: "",
    search: "",
    index: "",
    dialog: false,
    userList: [],
    categoryNo: [0, 1, 2, 3, 4],
    headers: [
      { text: "Id", value: "id" },
      { text: "First Name", value: "fname" },
      { text: "Last Name", value: "lname" },
      { text: "Email", value: "email" },
      // { text: "Password", value: "password" },
      { text: "New Post Alert", value: "user_post_alert" },
      { text: "User Type", value: "type_name" },
      { text: "Status", value: "status_name" },
      { text: "Registered date Date", value: "registered_on" },
      { text: "Expiry Date", value: "expiry_on" },
      { text: "Options", value: "action", sortable: false }
      // have to work on user type, status and expiry
    ]
  }),

  methods: {
    DateConversion(item){
      var date = new Date(item*1000);        
      return date.getFullYear() + "-" + ("0"+(date.getMonth() + 1)).slice(-2) + "-"+("0"+date.getDate()).slice(-2);
    },
    deleteItem(item) {
      this.index = this.userList.indexOf(item);
      this.user_id = item.id;
      this.dialog = true;
    },

    close() {
      this.dialog = false;
    },
    deletedItem() {
      var ind = this.index;
      var delete_id = { id: this.user_id };
      this.axios.post(this.nodejsServer + "user/deleteUser", delete_id).then(() => {
        this.userList.splice(ind, 1);
        this.dialog = false;
      });
    }
  },
  created() {
    this.axios.get(this.nodejsServer + "user/getUser").then(response => {
      this.userList = response.data;
    });
  }
};
</script>
