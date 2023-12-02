<template>
  <div>
    <v-card>
      <v-card-title>Category List</v-card-title>
      <v-snackbar v-model="snackbar">
        {{ notification }}
        <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
      </v-snackbar>
      <v-card-actions>
        <v-data-table
          calculate-widths
          :headers="headers"
          :items="categoryList"
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
          <template v-slot:item.action="{ item }">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <router-link :to="/CategoryEdit/ + item.post_category_id"
                  ><v-icon small class="mr-2" v-on="on"
                    >edit</v-icon
                  ></router-link
                >
              </template>
              <span>Edit</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <span v-if="item.post_category_status === 'Y'" v-on="on">
                  <v-checkbox
                    class="inline-checkbox"
                    :id="'categoryStatus' + item.post_category_id"
                    @change="categoryStatusChange(item)"
                    :input-value="true"
                    :value="true"
                  ></v-checkbox>
                </span>
                <span v-else v-on="on">
                  <v-checkbox
                    class="inline-checkbox"
                    :id="'categoryStatus' + item.post_category_id"
                    @change="categoryStatusChange(item)"
                    :input-value="false"
                    :value="false"
                  ></v-checkbox>
                </span>
              </template>
              <span>Change Status</span>
            </v-tooltip>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-icon small @click="deleteItem(item)" v-on="on"
                  >delete</v-icon
                >
              </template>
              <span>Delete</span>
            </v-tooltip>
          </template>
          <template v-slot:item.category_order="{ item }">
            <v-row>
              <v-col cols="3" :id="'order' + item.post_category_id"
                >{{ item.post_category_parent_id }}.{{
                  item.category_order
                }}</v-col
              >
              <v-col cols="9">
                <v-select
                  :id="'orderChange' + item.post_category_id"
                  v-on:change="changeCategoryOrder(item, $event)"
                  :items="categoryNo"
                  item-text="categoryNo"
                  label="Select"
                ></v-select>
              </v-col>
            </v-row>
          </template>
          <template
            v-slot:item.new_icon_display="{ item }"
            @click="iconStatusChange"
          >
            <v-row v-if="item.new_icon_display === 'Y'">
              <v-col
                cols="12"
                class="iconChange"
                :id="'iconChange' + item.post_category_id"
                @click="iconStatusChange(item)"
                ><i class="material-icons icon green--text">check_circle</i>
                Yes</v-col
              >
            </v-row>
            <v-row v-else>
              <v-col
                cols="12"
                class="iconChange"
                :id="'iconChange' + item.post_category_id"
                @click="iconStatusChange(item)"
                ><i class="material-icons icon red--text">remove_circle</i>
                No</v-col
              >
            </v-row>
          </template>
        </v-data-table>
      </v-card-actions>
    </v-card>
  </div>
</template>
<style lang="scss" scoped>
.iconChange {
  cursor: pointer;
}
</style>
<script>
export default {
  data: () => ({
    category_id: "",
    search: "",
    index: "",
    snackbar: false,
    notification: "Something went wrong",
    dialog: false,
    categoryList: [],
    categoryNo: [0, 1, 2, 3, 4],
    iconStatusList: [
      { text: "Old", value: "N" },
      { text: "New", value: "Y" }
    ],
    headers: [
      { text: "Id", value: "post_category_id" },
      { text: "Category Name", value: "post_category_name" },
      { text: "Parent Name", value: "post_category_parent_id" },
      { text: "Order", value: "category_order" },
      // { text: "Status", value: "post_category_status" },
      { text: "Icon Display", value: "new_icon_display" },
      { text: "Options", value: "action", sortable: false }
    ]
  }),

  methods: {
    changeCategoryOrder(item, event) {
      var orderBox = document.getElementById("order" + item.post_category_id);
      var updateData = {
        post_category_id: item.post_category_id,
        category_order: event
      };
      this.axios
        .post(this.nodejsServer + "category/updateCategoryOrder", updateData)
        .then(response => {
          if (response.data.err_code) {
            this.notification = response.data.message;
            this.snackbar = true;
          } else
            orderBox.innerHTML = item.post_category_parent_id + "." + event;
        });
    },
    iconStatusChange(item) {
      var iconText = document.getElementById(
        "iconChange" + item.post_category_id
      );
      var iconCheck = iconText.textContent.split(" ");
      iconText.removeChild(iconText.childNodes[0]);
      iconText.innerHTML = "";
      var icon = "";
      var iconValue = "";
      var iconChangeText = "";
      if (iconCheck[1] == "Yes") {
        icon = document.createElement("i");
        icon.className = "material-icons icon red--text";
        icon.innerHTML = "remove_circle";
        iconValue = "N";
        iconChangeText = " No";
      } else {
        icon = document.createElement("i");
        icon.className = "material-icons icon green--text";
        icon.innerHTML = "check_circle";
        iconValue = "Y";
        iconChangeText = " Yes";
      }

      var updateData = {
        post_category_id: item.post_category_id,
        new_icon_display: iconValue
      };
      this.axios
        .post(
          this.nodejsServer + "category/updateCategoryIconStatus",
          updateData
        )
        .then(response => {
          if (response.data.err_code) {
            this.notification = response.data.message;
            this.snackbar = true;
          } else {
            iconText.appendChild(icon);
            iconText.innerHTML += iconChangeText;
          }
        });
    },
    categoryStatusChange(item) {
      var checkBox = document.getElementById(
        "categoryStatus" + item.post_category_id
      );
      var categoryStatus = "";
      if (checkBox.checked == true) categoryStatus = "N";
      else categoryStatus = "Y";
      var updateData = {
        post_category_id: item.post_category_id,
        post_category_status: categoryStatus
      };
      this.axios
        .post(this.nodejsServer + "category/updateCategoryStatus", updateData)
        .then(response => {
          if (response.data.err_code) {
            this.notification = response.data.message;
            this.snackbar = true;
          }
        });
    },
    deleteItem(item) {
      this.index = this.categoryList.indexOf(item);
      this.category_id = item.post_category_id;
      this.dialog = true;
    },

    close() {
      this.dialog = false;
    },
    deletedItem() {
      var ind = this.index;
      var delete_id = { id: this.category_id };
      this.axios
        .post(this.nodejsServer + "category/deleteCategory", delete_id)
        .then(response => {
          if (!response.data.err_code) {
            this.categoryList.splice(ind, 1);
            this.dialog = false;
          } else {
            this.notification = response.data.message;
            this.snackbar = true;
          }
        });
    }
  },
  created() {
    this.axios.get(this.nodejsServer + "post/getCategory").then(response => {
      if (!response.data.err_code) {
        this.categoryList = response.data;
      } else {
        this.notification = response.data.message;
        this.snackbar = true;
      }
    });
  }
};
</script>
