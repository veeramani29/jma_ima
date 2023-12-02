<template>
  <div>
    <v-card>
      <v-card-title>Post Add</v-card-title>
      <v-card-actions>
        <v-snackbar v-model="snackbar">
          {{ notification }}
          <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-form
          class="col-12"
          ref="form"
          v-model="valid"
          lazy-validation
          autocomplete="false"
        >
          <v-container>
            <v-row>
              <v-col cols="12" sm="4">
                <v-select
                  v-model="category"
                  name="post_category_name"
                  id="post_category_id"
                  :items="categoryList"
                  item-text="post_category_name"
                  item-value="post_category_id"
                  @change="getSubCategory()"
                  :rules="[v => !!v || 'Please Select Category']"
                  label="Select Category"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4" v-show="postSubCatgoryShow">
                <v-select
                  v-model="subCategory"
                  :items="subCategoryList"
                  item-text="post_category_name"
                  item-value="post_category_id"
                  @change="getGrandSubCategory()"
                  label="Sub category if need"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4" v-show="postGrandSubCatgoryShow">
                <v-select
                  v-model="grandSubCategory"
                  :items="grandSubCategoryList"
                  item-text="post_category_name"
                  item-value="post_category_id"
                  label="post_grand_sub_category_name"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="postTitle"
                  :rules="[v => !!v || 'Please Write Post Title']"
                  label="Post Title"
                  @keyup="postUrlChange"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="postUrl"
                  :hint="postTitleHint"
                  persistent-hint
                  label="Post URL's"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="postHeading"
                  label="Post Heading"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="postSubHeading"
                  label="Post Sub heading"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="postReleased"
                  label="Post Released"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-textarea
                  label="Short Description"
                  v-model="shortDescription"
                  :rules="[v => !!v || 'Please enter short Description.']"
                  auto-grow
                  required
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <ejs-richtexteditor
                  :insertImageSettings="insertImageSettings"
                  :toolbarSettings="toolbarSettings"
                  v-model="editorData"
                  :rules="titleRules"
                  :height="350"
                  :fontSize="fontSize"
                  :pasteCleanupSettings="pasteCleanupSettings"
                  auto-grow
                  required
                ></ejs-richtexteditor>
                <div
                  class="v-messages theme--light error--text"
                  style="display:none"
                  id="textEditorError"
                >
                  <div class="v-messages__wrapper">
                    <div class="v-messages__message">
                      Please enter Post Content.
                    </div>
                  </div>
                </div>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-file-input
                  v-model="postImage"
                  label="Post Image"
                ></v-file-input>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="metaTitle"
                  label="Meta Title"
                  :rules="titleRules"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="shareTitle"
                  label="Share Title"
                  :rules="shareRules"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="shareDescription"
                  label="Share Description"
                  :rules="shareDisRules"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="metaKeywords"
                  label="Meta Keywords"
                  :rules="keywordRules"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="metaDescription"
                  label="Meta Description"
                  :rules="descriptionRules"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-select
                  :items="postType"
                  v-model="postTypeValue"
                  @change="showNewsOption()"
                  label="Post Type"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4" v-show="newsHideButton">
                <v-switch
                  v-model="newsSwitch"
                  label="News hide to free user"
                ></v-switch>
              </v-col>
              <v-col cols="12" sm="4">
                <v-switch
                  v-model="recentSwitch"
                  label="Recent data hide to free user"
                ></v-switch>
              </v-col>
          </v-row>
          </v-container>
          <v-col cols="12" sm="6"></v-col>
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
import {
  // RichTextEditorPlugin,
  Toolbar,
  Link,
  Image,
  Count,
  HtmlEditor,
  QuickToolbar,
  PasteCleanup,
  Table
} from "@syncfusion/ej2-vue-richtexteditor";

export default {
  data: () => ({
    postGrandSubCatgoryShow: false,
    postSubCatgoryShow: false,
    newsHideButton: true,
    snackbar: false,
    notification: "Something went wrong",
    insertImageSettings: "",
    valid: true,
    // location : require('../assets/'),
    newsSwitch: false,
    recentSwitch:false,
    postTypeValue: "News",
    name: "",
    postTitle: "",
    postTitleHint: "Note: Automatically generated. Change only if required.",
    postUrl: "",
    postHeading: "",
    postSubHeading: "",
    postReleased: "",
    shortDescription: "",
    postImage: [],
    metaKeywords: "",
    metaDescription: "",
    shareDescription: "",
    metaTitle: "",
    filePath: "",
    shareTitle: "",
    hint: "hai",
    titleRules: [
      v => v.length <= 70 || "Meta Title must be less than 70 characters"
    ],
    shareRules: [
      v => v.length <= 70 || "Share Title must be less than 70 characters"
    ],
    shareDisRules: [
      v => v.length <= 125 || "Share Discription be less than 125 characters"
    ],
    descriptionRules: [
      v => v.length <= 125 || "Meta Discription be less than 125 characters"
    ],
    keywordRules: [
      v => v.length <= 125 || "Meta Keyword be less than 125 characters"
    ],
    select: null,
    grandSubCategory: null,
    pasteCleanupSettings: {
      // prompt: true,
      plainText: true,
      // keepFormat: false,
      deniedTags: ["a"],
      deniedAttrs: ["class"],
      allowedStyleProps: ["color", "margin", "font-size"]
    },
    toolbarSettings: {
      type: "Expand",
      items: [
        "Bold",
        "Italic",
        "Underline",

        "FontSize",
        "FontColor",
        "BackgroundColor",
        "|",
        "Formats",
        "Alignments",
        "OrderedList",
        "UnorderedList",
        "Outdent",
        "Indent",
        "|",
        "CreateLink",
        "Image",
        "CreateTable",
        "|",
        "SourceCode",
        "FullScreen",
        "|",
        "Undo",
        "Redo"
      ]
    },
    subCategory: null,
    category: null,
    categoryList: [],
    grandSubCategoryList: [],
    subCategoryList: [],
    postType: ["Page", "News"],
    content: "",
    editorData: "",
    fontSize: {
      items: []
    }
  }),
  provide: {
    richtexteditor: [
      Toolbar,
      Link,
      Image,
      Count,
      HtmlEditor,
      QuickToolbar,
      PasteCleanup,
      Table
    ]
  },
  created() {
    for (var i = 9; i < 25; i++) {
      this.fontSize.items.push({ text: i + " pt", value: i + "pt" });
    }
    this.insertImageSettings = {
      width: "100px",
      saveUrl: this.nodejsServer + "post/saveFile"
    };
    // document.getElementById("textEditorError").style.display = "none";
    this.axios
      .get(this.nodejsServer + "category/getMainCategory")
      .then(response => {
        if (!response.data.err_code) {
          this.categoryList = response.data;
        } else {
          this.notification = response.data.message;
          this.snackbar = true;
        }
      });
  },
  methods: {
    showNewsOption() {
      if (this.postTypeValue == "News") this.newsHideButton = true;
      else this.newsHideButton = false;
    },
    getSubCategory() {
      var mainCategory_id = { id: this.category };
      this.axios
        .post(this.nodejsServer + "category/getSubCategory", mainCategory_id)
        .then(response => {
          if (!response.data.err_code) {
            this.postSubCatgoryShow = true;
            this.postGrandSubCatgoryShow = false;
            this.subCategoryList = response.data;
          } else {
            this.notification = response.data.message;
            this.snackbar = true;
          }
        });
    },
    getGrandSubCategory() {
      var Category_id = { id: this.subCategory };
      this.axios
        .post(this.nodejsServer + "category/getSubCategory", Category_id)
        .then(response => {
          if (!response.data.err_code) {
            this.postGrandSubCatgoryShow = true;
            this.grandSubCategoryList = response.data;
          } else {
            this.notification = response.data.message;
            this.snackbar = true;
          }
        });
    },
    postUrlChange() {
      var removeSpace = this.postTitle.trim();
      var urlSlug = removeSpace
        .toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");
      this.postUrl = urlSlug;
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
      if (this.editorData == "") {
        document.getElementById("textEditorError").style.display =
          "inline-block";
      }
      if (this.$refs.form.validate() && this.editorData != "") {
        if (typeof this.grandSubCategory == "number") {
          this.category = this.grandSubCategory;
        } else if (typeof this.subCategory == "number") {
          this.category = this.subCategory;
        }
        var premiumNews = "";
        if (this.newsSwitch == true) {
          premiumNews = "Y";
        } else  {
          premiumNews = "N";
        }
        var postTypeShort = "";
        var postRecent = "";
         if (this.recentSwitch == true) {
            postRecent = "Y";
          } else if (this.newsSwitch == false) {
            postRecent = "N";
          }
        if (this.newsHideButton == true) {
          postTypeShort = "N";
          
        } else {
          postTypeShort = "P";
        }
        if (this.postImage.name) {
          const upload = new FormData();
          upload.append("UploadFiles", this.postImage, this.postImage.name);
          this.filePath = this.axios
            .post(this.nodejsServer + "post/saveFile", upload)
            .then(response => {
              return response.data;
            });
        } else {
          this.filePath = this.axios
            .get(this.nodejsServer + "post/getNull")
            .then(response => {
              return response.data;
            });
        }
        this.filePath.then(data => {
          const postData = {
            post_category_id: this.category,
            post_title: this.postTitle,
            post_url: this.postUrl,
            post_heading: this.postHeading,
            post_subheading: this.postSubHeading,
            post_released: this.postReleased,
            post_cms_small: this.shortDescription,
            post_meta_keywords: this.metaKeywords,
            post_meta_description: this.metaDescription,
            post_share_description: this.shareDescription,
            post_meta_title: this.metaTitle,
            post_share_title: this.shareTitle,
            post_type: postTypeShort,
            post_image: data,
            copywriter_id: 1,
            post_cms: this.editorData,
            post_url_key: this.md5(this.postUrl),
            premium_news: premiumNews,
            recent_data : postRecent
          };
          this.axios
            .post(this.nodejsServer + "post/addPost", postData)
            .then(response => {
              if (!response.data.err_code) {
                this.$router.push("/PostList");
              } else {
                this.notification = response.data.message;
                this.snackbar = true;
              }
            });
        });
      }
    }
  }
};
</script>
<style>
@import "../../../node_modules/@syncfusion/ej2-base/styles/material.css";
@import "../../../node_modules/@syncfusion/ej2-inputs/styles/material.css";
@import "../../../node_modules/@syncfusion/ej2-lists/styles/material.css";
@import "../../../node_modules/@syncfusion/ej2-popups/styles/material.css";
@import "../../../node_modules/@syncfusion/ej2-buttons/styles/material.css";
@import "../../../node_modules/@syncfusion/ej2-navigations/styles/material.css";
@import "../../../node_modules/@syncfusion/ej2-splitbuttons/styles/material.css";
@import "../../../node_modules/@syncfusion/ej2-vue-richtexteditor/styles/material.css";
</style>
