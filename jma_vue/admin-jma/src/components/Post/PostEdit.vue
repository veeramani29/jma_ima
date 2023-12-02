<template>
  <div>
    <v-card>
      <v-card-title>Update Post</v-card-title>
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
                  :items="categoryList"
                  item-text="post_category_name"
                  item-value="post_category_id"
                  label="Category"
                  persistent-hint
                  return-object
                  :rules="[v => !!v || 'Please Select Category']"
                  required
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="postTitle"
                  :rules="[v => !!v || 'Please Write Post Title']"
                  label="Post Title"
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
                  :fontSize="fontSize"
                  v-model="editorData"
                  :pasteCleanupSettings="pasteCleanupSettings"
                  ref="rteObj"
                  :height="350"
                >
                </ejs-richtexteditor>
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
                  :placeholder="oldFilename"
                  label="Post Image"
                ></v-file-input>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="metaTitle"
                  label="Meta Title"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="shareTitle"
                  label="Share Title"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="shareDescription"
                  label="Share Description"
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
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-select
                  v-model="postType"
                  :items="postTypeList"
                  item-text="post_type_text"
                  item-value="post_type_value"
                  @change="showNewsOption()"
                  label="postType"
                  persistent-hint
                  return-object
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
              <v-col cols="12" sm="6"><h3>Suggested Pages</h3></v-col>
                <v-col cols="12" sm="4" v-show="addButton"><h3><v-btn color="success" class="mr-4" @click="add">Add More +</v-btn></h3></v-col>

            </v-row>
            <v-row class="suggestBox" v-show="page1">
              <v-col cols="11" sm="11"><v-subheader>Suggested Page1</v-subheader></v-col>
              <v-col cols="1" sm="1"><v-icon class="closeIcon" small @click="closeSuggest()">close</v-icon></v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageTitle1"
                  label="Title"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageDescription1"
                  label="Short Description"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageLink1"
                  label="Link"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row class="suggestBox" v-show="page2">
              <v-col cols="11" sm="11"><v-subheader>Suggested Page2</v-subheader></v-col>
              <v-col cols="1" sm="1"><v-icon class="closeIcon" small @click="closeSuggest()">close</v-icon></v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageTitle2"
                  label="Title"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageDescription2"
                  label="Short Description"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageLink2"
                  label="Link"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row class="suggestBox" v-show="page3">
              <v-col cols="11" sm="11"><v-subheader>Suggested Page3</v-subheader></v-col>
              <v-col cols="1" sm="1"><v-icon class="closeIcon" small @click="closeSuggest()">close</v-icon></v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageTitle3"
                  label="Title"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageDescription3"
                  label="Short Description"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageLink3"
                  label="Link"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row class="suggestBox" v-show="page4">
              <v-col cols="11" sm="11"><v-subheader>Suggested Page4</v-subheader></v-col>
              <v-col cols="1" sm="1"><v-icon class="closeIcon" small @click="closeSuggest()">close</v-icon></v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageTitle4"
                  label="Title"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageDescription4"
                  label="Short Description"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="pageLink4"
                  label="Link"
                ></v-text-field>
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
<style>
  .suggestBox{border-style: groove; margin-bottom: 12px;}
  .closeIcon{font-size: 30px !important;}
</style>
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
    addButton : true,
    page1 : false,
    page2 : false,
    page3 : false,
    page4 : false,
    snackbar: false,
    newsHideButton: true,
    pageTitle1 : "",
    pageDescription1 : "",
    pageLink1 : "",
    pageTitle2 : "",
    pageDescription2 : "",
    pageLink2 : "",
    pageTitle3 : "",
    pageDescription3 : "",
    pageLink3 : "",
    pageTitle4 : "",
    pageDescription4 : "",
    pageLink4 : "",
    notification: "Something went wrong",
    oldFilename: "",
    insertImageSettings: "",
    valid: true,
    recentSwitch:false,
    newsSwitch: false,
    name: "",
    postTitle: "",
    postTitleHint: "Note: Automatically generated. Change only if required.",
    postUrl: "",
    postHeading: "",
    postSubHeading: "",
    postReleased: "",
    shortDescription: "",
    postImage: [],
    oldPostImage: "",
    filePath: "",
    metaKeywords: "",
    metaDescription: "",
    shareDescription: "",
    metaTitle: "",
    shareTitle: "",
    hint: "hai",
    titleRules: [
      v => v.length <= 250 || "Meta Title must be less than 70 characters"
    ],
    shareRules: [
      v => v.length <= 350 || "Share Title must be less than 70 characters"
    ],
    shareDisRules: [
      v => v.length <= 1000 || "Share Discription be less than 125 characters"
    ],
    descriptionRules: [
      v => v.length <= 1000 || "Meta Discription be less than 125 characters"
    ],
    keywordRules: [
      v => v.length <= 1000 || "Meta Keyword be less than 125 characters"
    ],
    select: null,
    category_id: "",
    category: null,
    categoryList: [],
    editPostData: [],
    postType: [],
    postTypetext: "",
    postTypeList: [
      { post_type_value: "N", post_type_text: "News" },
      { post_type_value: "P", post_type_text: "Page" }
    ],
    pasteCleanupSettings: {
      // prompt: true,
      plainText: true,
      // keepFormat: false,
      deniedTags: ["a"],
      deniedAttrs: ["class"],
      allowedStyleProps: ["color", "margin", "font-size"]
    },
    editorData: "",
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
    const editPostId = {
      post_id: this.$route.params.id
    };

    this.axios
      .post(this.nodejsServer + "post/getEditPostData", editPostId)
      .then(response => {
        if (!response.data.err_code) {
          if (response.data[0].post_type == "P") {
            this.postTypeText = "Page";
            this.newsHideButton = false;
          } else {
            this.newsHideButton = true;
            this.postTypeText = "News";
          }
          if (response.data[0].recent_data == "N") {
            this.recentSwitch = false;
          } else {
            this.recentSwitch = true;
          }
          if (response.data[0].premium_news == "Y") this.newsSwitch = true;
          else this.newsSwitch = false;
          if(response.data[0].sugPageTitle1)
            this.page1 = true;
          if(response.data[0].sugPageTitle2)
          this.page2 = true;
          if(response.data[0].sugPageTitle3)
          this.page3 = true;
          if(response.data[0].sugPageTitle4){
          this.page4 = true;
          this.addButton = false;
          } 
          
          this.pageTitle1 = response.data[0].sugPageTitle1;
          this.pageDescription1 = response.data[0].sugPageDesc1;
          this.pageLink1 = response.data[0].sugPageLink1;
           this.pageTitle2 = response.data[0].sugPageTitle2;
          this.pageDescription2 = response.data[0].sugPageDesc2;
          this.pageLink2 = response.data[0].sugPageLink2;
           this.pageTitle3 = response.data[0].sugPageTitle3;
          this.pageDescription3 = response.data[0].sugPageDesc3;
          this.pageLink3 = response.data[0].sugPageLink3;
           this.pageTitle4 = response.data[0].sugPageTitle4;
          this.pageDescription4 = response.data[0].sugPageDesc4;
          this.pageLink4 = response.data[0].sugPageLink4;
          this.oldFilename = response.data[0].post_image;
          this.category_id = response.data[0].post_category_id;
          this.category = {
            post_category_id: response.data[0].post_category_id,
            post_category_name: response.data[0].post_category_name
          };
          this.postType = {
            post_type_value: response.data[0].post_type,
            post_type_text: this.postTypeText
          };
          this.postTitle = response.data[0].post_title;
          this.postUrl = response.data[0].post_url;
          this.postHeading = response.data[0].post_heading;
          this.postSubHeading = response.data[0].post_subheading;
          this.postReleased = response.data[0].post_released;
          this.shortDescription = response.data[0].post_cms_small;
          this.oldPostImage = response.data[0].post_image;
          this.metaKeywords = response.data[0].post_meta_keywords;
          this.metaDescription = response.data[0].post_meta_description;
          this.shareDescription = response.data[0].post_share_description;
          this.metaTitle = response.data[0].post_meta_title;
          this.shareTitle = response.data[0].post_share_title;
          this.editorData = response.data[0].post_cms;
          this.axios
            .get(this.nodejsServer + "post/getPostMainCategory")
            .then(response1 => {
              const rows = response1.data;
              const mainCategory = [];
              const subCategory = [];
              const grandSubCategory = [];
              for (var i = 0; i < rows.length; i++) {
                if (rows[i].post_category_parent_id == 0) {
                  mainCategory.push({
                    post_category_id: rows[i].post_category_id,
                    post_category_name: rows[i].post_category_name
                  });
                }
              }
              for (var j = 0; j < mainCategory.length; j++) {
                for (var k = 0; k < rows.length; k++) {
                  if (
                    mainCategory[j].post_category_id ==
                    rows[k].post_category_parent_id
                  ) {
                    subCategory.push({
                      post_category_id: rows[k].post_category_id,
                      post_category_name:
                        mainCategory[j].post_category_name +
                        "-" +
                        rows[k].post_category_name
                    });
                  }
                }
              }
              for (var l = 0; l < subCategory.length; l++) {
                for (var m = 0; m < rows.length; m++) {
                  if (
                    subCategory[l].post_category_id ==
                    rows[m].post_category_parent_id
                  ) {
                    grandSubCategory.push({
                      post_category_id: rows[m].post_category_id,
                      post_category_name:
                        subCategory[l].post_category_name +
                        "-" +
                        rows[m].post_category_name
                    });
                  }
                }
              }
              var twoLists = mainCategory.concat(subCategory);
              this.categoryList = twoLists.concat(grandSubCategory);
            });
        } else {
          this.notification = response.data.message;
          this.snackbar = true;
        }
      });
  },
  methods: {
    add(){
      if(this.page1 != true){
       this.page1 = true;
      } else {
        if(this.page2 != true){
          this.page2 = true;
        } else {
          if(this.page3 != true){
            this.page3 = true;
          } else {
            if(this.page4 != true){
              this.page4 = true;
              this.addButton = false;
            }
          }
        }
      }
    },
    closeSuggest(){
      if(this.page4 != false){
        this.addButton = true;
        this.page4 = false;
      } else {
        this.addButton = true;
        if(this.page3 != false){
          this.page3 = false;
        } else {
          if(this.page2 != false){
            this.page2 = false;
          } else {
            if(this.page1 != false){
              this.page1 = false;
            }
          }
        }
      }
    },
    showNewsOption() {
     
      if (this.postType.post_type_text == "News") this.newsHideButton = true;
      else this.newsHideButton = false;
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
      if (this.editorData == null) {
        document.getElementById("textEditorError").style.display =
          "inline-block";
      }
      var premiumNews = "";
      var postRecent = "";
         if (this.recentSwitch == true) {
            postRecent = "Y";
          } else if (this.newsSwitch == false) {
            postRecent = "N";
          }
      if (this.$refs.form.validate() && this.editorData != "") {
        if (this.newsHideButton == true) {
          if (this.newsSwitch == true) {
            premiumNews = "Y";
          } else if (this.newsSwitch == false) {
            premiumNews = "N";
          }
        } else premiumNews = "";
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
          if (data == " ") {
            data = this.oldPostImage;
          }
          const postData = {
            post_id: this.$route.params.id,
            post_category_id: this.category.post_category_id,
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
            post_type: this.postType.post_type_value,
            post_image: data,
            post_cms: this.editorData,
            post_url_key: this.md5(this.postUrl),
            premium_news: premiumNews,
            recent_data : postRecent,
            sugPageTitle1 : this.pageTitle1,
            sugPageDesc1 : this.pageDescription1,
            sugPageLink1 : this.pageLink1,
            sugPageTitle2 : this.pageTitle2,
            sugPageDesc2 : this.pageDescription2,
            sugPageLink2 : this.pageLink2,
            sugPageTitle3 : this.pageTitle3,
            sugPageDesc3 : this.pageDescription3,
            sugPageLink3 : this.pageLink3,
            sugPageTitle4 : this.pageTitle4,
            sugPageDesc4 : this.pageDescription4,
            sugPageLink4 : this.pageLink4,
          };
          this.axios
            .post(this.nodejsServer + "post/updatePost", postData)
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
