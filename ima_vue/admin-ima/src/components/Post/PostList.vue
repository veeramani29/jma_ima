<template>
  <div>
    <v-card>
      <v-card-title>Post List</v-card-title>
      <v-card-actions>
        <v-snackbar v-model="snackbar">
          {{ notification }}
          <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-data-table
          calculate-widths
          :headers="headers"
          :items="postList"
          :items-per-page="5"
          class="elevation-1 full-width"
          :search="search"
        >
          <template v-slot:top>
            <v-dialog v-model="dialogEmail" max-width="500px">
              <v-card>
                <v-card-title>
                  <span class="headline">Email Alert</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <h3>Are You Sure to Send Email</h3>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn color="blue darken-1" text @click="close"
                    >Cancel</v-btn
                  >
                  <v-btn color="blue darken-1" text @click="sendEmail()"
                    >Send</v-btn
                  >
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog v-model="dialogStatus" max-width="500px">
              <v-card>
                <v-card-title>
                  <span class="headline">Publish</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <h3>Are You Sure to Publish This Post</h3>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <div class="flex-grow-1"></div>
                  <v-btn color="blue darken-1" text @click="close"
                    >Cancel</v-btn
                  >
                  <v-btn color="blue darken-1" text @click="postStatusChange"
                    >Publish</v-btn
                  >
                </v-card-actions>
              </v-card>
            </v-dialog>
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
                  <v-btn color="blue darken-1" text @click="close"
                    >Cancel</v-btn
                  >
                  <v-btn color="blue darken-1" text @click="deletedItem"
                    >Delete</v-btn
                  >
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-text-field
              v-model="search"
              label="Search Key word"
              class="mx-4"
            ></v-text-field>
          </template>
          <template v-slot:item.post_publish_status="{ item }">
            <v-row>
              <v-col cols="3" :id="'postStatus' + item.post_id">{{
                item.post_publish_status
              }}</v-col>
              <v-col cols="2" :id="'postStatusCheckBox' + item.post_id">
                <span
                  v-if="
                    item.post_publish_status == 'N'
                  "
                >
                  <v-checkbox
                    class="inline-checkbox"
                    @change="changeStatusConfirmation(item)"
                    :input-value="false"
                    :value="false"
                  ></v-checkbox>
                </span>
              </v-col>
            </v-row>
          </template>
          <template v-slot:item.action="{ item }">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-icon
                  small
                  class="mr-2"
                  @click="emailConfirmation(item)"
                  v-on="on"
                  >email</v-icon
                >
              </template>
              <span>Send Email</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <router-link :to="/PostEdit/ + item.post_id">
                  <v-icon small class="mr-2" v-on="on">edit</v-icon>
                </router-link>
              </template>
              <span>Edit</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-icon small @click="deleteConfirmation(item)" v-on="on"
                  >delete</v-icon
                >
              </template>
              <span>Delete</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-icon small @click="viewPost(item)">remove_red_eye</v-icon>
              </template>
              <span>View</span>
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
    postId: "",
    postStatus: "",
    postType: "",
    dialog: false,
    dialogStatus: false,
    dialogEmail: false,
    postList: [],
    headers: [
      { text: "Id", value: "post_id" },
      { text: "Post Title", value: "post_title" },
      { text: "Post Category Name", value: "post_category_name" },
      { text: "Copy Writer", value: "copywriter_user" },
      { text: "Post Type", value: "post_type" },
      { text: "Copy writer status", value: "copywriter_status" },
      { text: "Post publish status", value: "post_publish_status" },
      { text: "Options", value: "action", sortable: false }
    ]
  }),

  methods: {
    emailConfirmation(item) {
      this.postId = item.post_id;
      this.postType = item.post_type;

      this.dialogEmail = true;
    },
    viewPost(item) {
      window.open(
        this.websiteURL +"reports/preview/"+ item.post_url,
        "_blank" // <- This is what makes it open in a new window.
      );
    },
    changeStatusConfirmation(item) {
      this.postId = item.post_id;
      this.postStatus = item.post_publish_status;
      this.dialogStatus = true;
      this.postType = item.post_type;
    },
    deleteConfirmation(item) {
      this.index = this.postList.indexOf(item);
      this.postId = item.post_id;
      this.dialog = true;
    },
    editItem() {
      window.location.href = "PostEdit.js";
    },

    close() {
      this.dialog = false;
      this.dialogStatus = false;
      this.dialogEmail = false;
    },
    sendEmail() {
      this.axios
        .get(
          this.nodejsServer +
            "post/send-email-alert/" +
            this.postId +
            "/" +
            this.postType
        )
        .then(response => {
          if (response.data.err_code) {
            this.notification = response.data.message;
            this.snackbar = true;
          } else {
            this.notification = response.data.message;
            this.dialogEmail = false;
          }
        });
    },
    postStatusChange() {
      // var checkBox = document.getElementById("postStatus"+this.post_id);
      var postStatus = "Y";
      // var updateData = { post_id : this.postId, post_publish_status : postStatus };
      // this.axios.post(this.nodejsServer + "post/updatePostStatus", updateData).then((response)=>{
      //   if(response.data.err_code){
      //     this.notification = response.data.message;
      //     this.snackbar = true;
      //   } else {
      //     this.dialogStatus = false;
      //     document.getElementById("postStatusCheckBox"+this.postId).style.display = "none";
      //     document.getElementById("postStatus"+this.postId).innerHTML = postStatus;

      //   }
      // })

      this.axios
        .get(
          this.nodejsServer +
            "post/publish-the-post/" +
            this.postId +
            "/" +
            this.postStatus +
            "/" +
            this.postType
        )
        .then(response => {
          if (response.data.err_code) {
            this.notification = response.data.message;
            this.snackbar = true;
          } else {
            this.notification = response.data.message;
            this.dialogStatus = false;
            document.getElementById(
              "postStatusCheckBox" + this.postId
            ).style.display = "none";
            document.getElementById(
              "postStatus" + this.postId
            ).innerHTML = postStatus;
          }
        });
    },
    deletedItem() {
      var ind = this.index;
      var delete_id = { id: this.postId };
      this.axios
        .post(this.nodejsServer + "post/deletePost", delete_id)
        .then(response => {
          if (!response.data.err_code) {
            this.postList.splice(ind, 1);
            this.dialog = false;
          } else {
            this.notification = response.data.message;
            this.snackbar = true;
          }
        });
    }
  },
  created() {
    // console.log(localStorage.getItem("id"));
    // console.log(localStorage.getItem("user"));
    // console.log(localStorage.getItem("email"));
    // localStorage.clear();
    this.axios.get(this.nodejsServer + "post/getPost").then(response => {
      if (!response.data.err_code) {
        this.postList = response.data;
      } else {
        this.notification = response.data.message;
        this.snackbar = true;
      }
    });
  }
};
</script>
