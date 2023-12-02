<template>
  <div>
    <v-card>
      <v-card-title>Edit email template</v-card-title>
      <v-card-actions>
        <v-snackbar v-model="snackbar">
            {{ notification }}
            <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-form class="col-12" ref="form" v-model="valid" lazy-validation autocomplete="false">
          <v-container>
            <v-row>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="emailCode"
                  label="Email Code"
                  :rules="[v => !!v || 'Please enter Email Code']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="subject"
                  label="Subject"
                  :rules="[v => !!v || 'Please enter Subject']"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <p>Message</p>
                <ejs-richtexteditor
                  :insertImageSettings="insertImageSettings"
                  v-model="editorData"
                  ref="rteObj"
                ></ejs-richtexteditor>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-textarea
                  label="Variables"
                  v-model="variables"
                  :rules="[v => !!v || 'Please enter variables.']"
                  auto-grow
                  required
                ></v-textarea>
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
import {
  // RichTextEditorPlugin,
  Toolbar,
  Link,
  Image,
  Count,
  HtmlEditor,
  QuickToolbar
} from "@syncfusion/ej2-vue-richtexteditor";
export default {
  data: () => ({
    snackbar: false,
    notification: "Something went wrong",
    valid: true,
    insertImageSettings: {
      width: "100px",
      saveUrl: "http://localhost:5000/post/saveFile"
    },
    emailCode: "",
    subject: "",
    variables: "",
    editorData:""
  }),
  provide: {
    richtexteditor: [Toolbar, Link, Image, Count, HtmlEditor, QuickToolbar]
  },
  created() {
    const editComponent = {
      email_id: this.$route.params.id
    };
    this.axios.post(this.nodejsServer + "emailTemplates/getEditEmailTemplates", editComponent).then(response => {
        if(!response.data.err_code){
            this.emailCode = response.data[0].email_templates_code;
            this.subject = response.data[0].email_templates_subject;
            this.variables = response.data[0].email_templates_variable;
            this.editorData = response.data[0].email_templates_message;
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
        const updateData = {
          email_templates_id:this.$route.params.id,
          email_templates_code:this.emailCode,
          email_templates_subject: this.subject,
          email_templates_message:this.editorData,
          email_templates_variable:this.variables
        };
        this.axios.post(this.nodejsServer + "emailTemplates/updateEmailTemplates", updateData).then((response) => {
          if(!response.data.err_code){
            this.$router.push("/EmailList");
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