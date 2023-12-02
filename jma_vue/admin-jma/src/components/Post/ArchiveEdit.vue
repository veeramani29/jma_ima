<template>
  <div>
    <v-card>
      <v-card-title>Update Archive</v-card-title>
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
              <v-col cols="12" sm="12">
                <v-text-field
                  v-model="postHeading"
                  label="Post Heading"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="updatedDate"
                  label="Updated Date"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="postReleased"
                  label="Post Released"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="slug"
                  label="Slug"
                  hint="Note : Don't use space here"
                  persistent-hint
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <ejs-richtexteditor
                  v-model="postCms"
                  ref="rteObj"
                  :height="350"
                  :pasteCleanupSettings="pasteCleanupSettings"
                >
                </ejs-richtexteditor>
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
                  v-model="metaDescription"
                  label="Meta Description"
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
<script>
import {
  Toolbar,
  Link,
  Count,
  HtmlEditor,
  QuickToolbar,
  PasteCleanup
} from "@syncfusion/ej2-vue-richtexteditor";
export default {
  data: () => ({
    snackbar: false,
    notification: "Something went wrong",
    valid: true,
    postId: "",
    slug: "",
    postHeading: "",
    updatedDate: "",
    postReleased: "",
    postCms: "",
    metaDescription: "",
    metaTitle: "",
    pasteCleanupSettings: {
      // prompt: true,
      plainText: true,
      // keepFormat: false,
      deniedTags: ["a"],
      deniedAttrs: ["class"],
      allowedStyleProps: ["color", "margin", "font-size"]
    }
  }),
  provide: {
    richtexteditor: [
      Toolbar,
      Link,
      Count,
      HtmlEditor,
      QuickToolbar,
      PasteCleanup
    ]
  },
  created() {
    const editPostId = {
      archive_id: this.$route.params.id
    };
    this.axios
      .post(this.nodejsServer + "archive/getEditArchive", editPostId)
      .then(response => {
        if (!response.data.err_code) {
          this.post_id = response.data[0].post_id;
          this.postHeading = response.data[0].post_heading;
          this.postReleased = response.data[0].post_released;
          this.updatedDate = response.data[0].updated_date;
          this.postCms = response.data[0].post_cms;
          this.metaTitle = response.data[0].meta_title;
          this.metaDescription = response.data[0].meta_description;
          this.slug = response.data[0].slug;
        } else {
          this.notification = response.data.message;
          this.snackbar = true;
        }
      });
  },
  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true;
      }
    },
    reset() {
      this.$refs.form.reset();
    },

    submit() {
      if (this.$refs.form.validate()) {
        const archiveData = {
          id: this.$route.params.id,
          post_id: this.post_id,
          post_heading: this.postHeading,
          post_released: this.postReleased,
          post_cms: this.postCms,
          updated_date: this.updatedDate,
          meta_title: this.metaTitle,
          meta_description: this.metaDescription,
          slug: this.slug
        };
        this.axios
          .post(this.nodejsServer + "archive/updateArchive", archiveData)
          .then(response => {
            if (!response.data.err_code) {
              this.$router.push("/ArchiveList");
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
