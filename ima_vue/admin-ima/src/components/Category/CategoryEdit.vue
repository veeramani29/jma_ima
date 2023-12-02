<template>
  <div>
    <v-card>
      <v-card-title>Category Edit</v-card-title>
      <v-card-actions>
        <v-form
          class="col-12"
          ref="form"
          v-model="valid"
          lazy-validation
          autocomplete="false"
        >
          <v-snackbar v-model="snackbar"
            >{{ notification }}
            <v-btn color="pink" text @click="snackbar = false"> Close </v-btn>
          </v-snackbar>
          <v-container>
            <v-row>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="categoryName"
                  label="Category Name"
                  @keyup="categoryUrlChange"
                  :rules="[v => !!v || 'Please enter Category Name']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-select
                  v-model="pageCategory"
                  :items="pageCategoryList"
                  label="Content Type"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="categoryUrl"
                  label="Category URL"
                  hint="Note: Automatically generated. Change only if required."
                  persistent-hint
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="metaTitle"
                  label="Meta Title"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="metaKeywords"
                  label="Meta Keywords"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="metaDescription"
                  label="Meta Description"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-switch
                  @change="showDefaultMailAlert"
                  v-model="emailAlert"
                  label="Is this email alert?"
                ></v-switch>
              </v-col>
              <v-col cols="12" sm="4" v-show="visibleDefaultMailAlert">
                <v-switch
                  v-model="defaultEmailAlert"
                  label="Is this defaul email alert?"
                ></v-switch>
              </v-col>
            </v-row>
          </v-container>
          <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit"
            >Submit</v-btn
          >
          <v-btn color="error" class="mr-4" @click="reset">Reset Form</v-btn>
        </v-form>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  data: () => ({
    visibleDefaultMailAlert: false,
    emailAlert: false,
    defaultEmailAlert: false,
    valid: true,
    snackbar: false,
    notification: "Something went wrong",
    newsSwitch: false,
    metaTitle: "",
    metaKeywords: "",
    categoryName: "",
    metaDescription: "",
    categoryUrl: "",
    select: null,
    pageCategoryList: ["Page", "News", "Materials", "Link"],
    pageCategory: []
  }),
  created() {
    const editCategoryId = {
      category_id: this.$route.params.id
    };
    this.axios
      .post(this.nodejsServer + "post/getEditCategoryData", editCategoryId)
      .then(response => {
        if (!response.data.err_code) {
          this.metaTitle = response.data[0].category_meta_title;
          this.metaKeywords = response.data[0].category_meta_keywords;
          this.categoryName = response.data[0].post_category_name;
          this.metaDescription = response.data[0].category_meta_description;
          this.categoryUrl = response.data[0].category_url;
          if (response.data[0].email_alert == "Y") {
            if (response.data[0].default_email_alert == "Y")
              this.defaultEmailAlert = true;
            else this.defaultEmailAlert = false;
            this.emailAlert = true;
            this.visibleDefaultMailAlert = true;
          } else {
            this.emailAlert = false;
            this.visibleDefaultMailAlert = false;
          }
          if (response.data[0].category_type == "P") this.pageCategory = "Page";
          else if (response.data[0].category_type == "N")
            this.pageCategory = "News";
          else if (response.data[0].category_type == "M")
            this.pageCategory = "Material";
          else if (response.data[0].category_type == "L")
            this.pageCategory = "Link";
        } else {
          this.notification = response.data.message;
          this.snackbar = true;
        }
      });
  },

  methods: {
    showDefaultMailAlert() {
      if (this.emailAlert == true) {
        this.visibleDefaultMailAlert = true;
      } else {
        this.visibleDefaultMailAlert = false;
      }
    },
    categoryUrlChange() {
      var urlSlug = this.categoryName
        .toLowerCase()
        .replace(/[^\w ]+/g, "")
        .replace(/ +/g, "-");
      this.categoryUrl = urlSlug;
    },
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true;
      }
    },
    reset() {
      this.$refs.form.reset();
    },

    submit() {
      this.pageCategory = this.pageCategory.charAt(0);
      if (this.$refs.form.validate()) {
        var email_alert = "";
        var default_email_alert = "";
        if (this.emailAlert == true) {
          if (this.defaultEmailAlert == true) {
            default_email_alert = "Y";
          } else {
            default_email_alert = "N";
          }
          email_alert = "Y";
        } else {
          default_email_alert = "N";
          email_alert = "N";
        }
        const postData = {
          post_category_id: this.$route.params.id,
          category_type: this.pageCategory,
          post_category_name: this.categoryName,
          category_url: this.categoryUrl,
          category_meta_keywords: this.metaKeywords,
          category_meta_description: this.metaDescription,
          category_meta_title: this.metaTitle,
          email_alert: email_alert,
          category_url_key: this.md5(this.categoryUrl),
          default_email_alert: default_email_alert
        };
        this.axios
          .post(this.nodejsServer + "post/updateCategory", postData)
          .then(response => {
            if (!response.data.err_code) {
              this.$router.push("/CategoryList");
            } else {
              this.notification = response.data.message;
              this.snackbar = true;
            }
          });
      }
    }
  }
};
</script>
