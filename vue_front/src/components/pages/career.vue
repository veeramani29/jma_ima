<template>
  <v-content>
    <v-container class="career-page">
      <v-row>
        <v-col sm="2">
          <LeftNavigation />
        </v-col>
        <v-col sm="10">
          <v-card outlined raised>
            <v-list-item>
              <v-list-item-content>
                <v-card-text>
                  <p>Are you passionate about economics? Like the idea of being part of a dynamic startup culture? If you are an aspiring young economist looking to combine analytical skills and entrepreneurial spirit, then join us.</p>
                  <p>
                    Job Description PDF
                    <v-btn text color="primary">click here</v-btn>
                  </p>

                  <v-list-item-subtitle>
                    <div class="main-title">
                      <h1>Send us your resume</h1>
                      <div class="mttl-line"></div>
                    </div>
                  </v-list-item-subtitle>
                  <v-list-item-subtitle>We will get back to you if we find your profile suitable</v-list-item-subtitle>
                  <v-form ref="form" v-model="resumeForm" :lazy-validation="lazy">
                    <v-file-input
                      v-model="resumeFile"
                      :rules="fileSize"
                      show-size
                      accept=".pdf, .doc"
                      chips
                      label="File input"
                    ></v-file-input>
                    <v-btn :disabled="!resumeForm" @click="submit" color="primary" class="ml-4">Submit</v-btn>
                  </v-form>
                </v-card-text>
              </v-list-item-content>
            </v-list-item>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-content>
</template>
<script>
import LeftNavigation from "@/components/shared/leftNavigation.vue";
export default {
  components: {
    LeftNavigation
  },
  data: () => ({
    resumeFile:[],
    fileSize: [
      value =>
        !value ||
        value.size < 2000000 ||
        "Avatar size should be less than 2 MB!"
    ],
    resumeForm: true,
    lazy: false
  }),
  methods:{
    submit(){
      const upload = new FormData();
          upload.append("UploadFiles", this.resumeFile, this.resumeFile.name);
          this.axios.post(this.nodejsServer + "saveFile", upload).then(response => {
            const file = {path : response.data.path,name:response.data.originalname};
              this.axios.post(this.nodejsServer + "sendResume", file).then(response => {
                window.console.log(response);
                return response.data;
              });
          });
    }
  },
};
</script>
<style lang="scss">
.career-page {
  .v-form {
    display: flex;
    width: 55%;
    align-items: center;
    margin-top: 15px;
  }
}
</style>