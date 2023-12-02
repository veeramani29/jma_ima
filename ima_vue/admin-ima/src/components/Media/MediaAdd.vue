<template>
  <div>
    <v-card>
      <v-card-title>Media Add</v-card-title>
      <v-card-actions>
        <v-form
          class="col-12"
          ref="form"
          v-model="valid"
          lazy-validation
          autocomplete="false"
        >
          <v-container>
            <v-row>
              <v-snackbar v-model="snackbar">
                {{ notification }}
                <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
              </v-snackbar>
              <v-col cols="12" sm="4">
                <v-file-input
                  v-model="mediaImage"
                  label="Media Image"
                ></v-file-input>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="mediaText"
                  label="Media Text"
                  :rules="[v => !!v || 'Please enter Media Text']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="mediaLink"
                  label="Media Link"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-menu
                  v-model="menu2"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="mediaDate"
                      label="Picker without buttons"
                      prepend-icon="event"
                      readonly
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="mediaDate"
                    @input="menu2 = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="12" sm="4">
                <v-switch v-model="noticeSwitch" :label="`Notice`"></v-switch>
              </v-col>
              <v-col cols="12" sm="4">
                <v-select
                  v-model="mediaSortOrder"
                  :items="sortOrder"
                  label="Sort Order"
                  :rules="[v => !!v || 'Please enter Number']"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="4"></v-col>
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
    snackbar: false,
    notification: "Something went wrong",
    mediaDate: new Date().toISOString().substr(0, 10),
    menu2: false,
    valid: true,
    noticeSwitch: false,
    sortOrder: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    mediaImage: [],
    mediaText: "",
    mediaLink: "",
    filePath: "",
    mediaSortOrder: null
  }),
  created() {
    this.axios.get(this.nodejsServer + "media/getMedia").then(response => {
      this.category = response.data;
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
        var noticeSwitchValue = "";
        if (this.noticeSwitch == true) {
          noticeSwitchValue = "1";
        } else {
          noticeSwitchValue = "0";
        }
        if (this.mediaImage.name) {
          const upload = new FormData();
          upload.append("UploadFiles", this.mediaImage, this.mediaImage.name);
          this.filePath = this.axios
            .post(this.nodejsServer + "post/saveFile", upload, {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            })
            .then(function(response) {
              return response.data;
            })
            .catch(function(error) {
              return error;
            });
        } else {
          this.filePath = this.axios
            .get(this.nodejsServer + "post/getNull")
            .then(response => {
              return response.data;
            });
        }
        this.filePath.then(data => {
          const mediaData = {
            media_value_img: data,
            media_value_text: this.mediaText,
            media_link: this.mediaLink,
            media_date: this.mediaDate,
            media_sort: this.mediaSortOrder,
            media_notice: noticeSwitchValue
          };
          this.axios
            .post(this.nodejsServer + "media/insertMedia", mediaData)
            .then(response => {
              if (!response.data.err_code) {
                this.$router.push("/mediaList");
              } else {
                this.notification = response.data.message;
                this.snackbar = true;
              }
            })
            .catch(function() {
              this.snackbar = true;
            });
        });
      }
    }
  }
};
</script>
