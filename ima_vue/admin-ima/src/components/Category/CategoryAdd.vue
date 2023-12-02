<template>
  <div>
    <v-card>
      <v-card-title>Category Add</v-card-title>
      <v-card-actions>
        <v-form class="col-12" ref="form" v-model="valid" lazy-validation autocomplete="false">
         <v-snackbar v-model="snackbar">{{ notification }}
          <v-btn color="pink" text @click="snackbar = false"> Close </v-btn>
         </v-snackbar>
          <v-container>
            <v-row>
              <v-col cols="12" sm="4">
                <v-select  v-model="mainCategory" :items="mainCategoryList" item-text="post_category_name" item-value="post_category_id" v-on:change="getSubCategory()" label="Select Category"></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-select v-model="subCategory" :items="subCategoryList" item-text="post_category_name" item-value="post_category_id" label="Sub category if need"></v-select>
              </v-col>
              <v-col cols="12" sm="4">
                <v-select v-model="pageCategory" :items="pageCategoryList" label="Content Type" ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-text-field
                v-model="categoryName"
                  label="Category Name"
                  :rules="[v => !!v || 'Please enter Category Name']"
                  @keyup="categoryUrlChange"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="8">
                <v-text-field v-model="categoryUrl" id="categoryURL" label="Category URL" hint="Note: Automatically generated. Change only if required."  persistent-hint></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-text-field v-model="metaTitle" label="Meta Title"></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field v-model="metaKeywords" label="Meta Keywords"></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field v-model="metaDescription" label="Meta Description"></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit">Submit</v-btn>
          <v-btn color="error" class="mr-4" @click="reset">Reset Form</v-btn>
        </v-form>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  data: () => ({
    valid: true,
    snackbar: false,
    notification: 'Something went wrong',
    newsSwitch: false,
    subCategoryList:[], 
    subCategory: [],
    metaTitle: "",
    metaKeywords: "",
    categoryName:"",
    metaDescription: "",
    postTitle: "",
    categoryUrl: "",
    select: null,
    mainCategoryList: [],
    mainCategory: [],
    pageCategoryList: ["Page", "News", "Materials", "Link"],
    pageCategory:[]
  }),
   created(){
    this.axios.get(this.nodejsServer+'category/getMainCategory').then((response) => {
      if(!response.data.err_code){
        this.mainCategoryList=response.data;
      } else {
          this.notification = response.data.message;
          this.snackbar = true;
      }  
    })
   
  },

  methods: {
    categoryUrlChange(){
      var urlSlug = this.categoryName.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
      this.categoryUrl = urlSlug;
    },
    getSubCategory() {
      var mainCategory_id= {'id':this.mainCategory};
      this.axios.post(this.nodejsServer+'category/getSubCategory',mainCategory_id).then((response) => {
        if(!response.data.err_code){
          this.subCategoryList=response.data;
        } else {
          this.notification = response.data.message;
          this.snackbar = true;
        }  
      })
    },
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true;
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    
    submit(){
      if (this.$refs.form.validate()) {
        if(typeof this.subCategory == "number"){
          this.parentCategory=this.subCategory;
        } else if (typeof this.mainCategory == "number"){
          this.parentCategory=this.mainCategory;
        } else {
          this.parentCategory=0;
        }
        if(typeof this.pageCategory != "object")
          this.pageCategory=this.pageCategory.charAt(0);
        else
          this.pageCategory="";
        const postData = {
          post_category_parent_id: this.parentCategory,
          category_type: this.pageCategory,
          post_category_name: this.categoryName,
          category_url: this.categoryUrl,
          category_url_key: this.md5(this.categoryUrl),
          category_meta_keywords: this.metaKeywords,
          category_meta_description: this.metaDescription,
          category_meta_title: this.metaTitle, 
         
        };
        this.axios.post(this.nodejsServer+'post/addCategory',postData).then((response) => {
          if(!response.data.err_code){
            this.$router.push('/CategoryList');
          } else {
            this.notification = response.data.message;
            this.snackbar = true;
          }  
        })
      }
    }
  }
};
</script>