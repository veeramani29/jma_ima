<template>
  <div>
    <v-card>
      <v-card-title>Map Edit</v-card-title>
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
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="mapSource"
                  label="Source"
                  :rules="[v => !!v || 'Please enter Media Text']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="mapTitle"
                  label="Title"
                  :rules="[v => !!v || 'Please enter Map Title.']"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-textarea
                  label="Text"
                  v-model="mapText"
                  auto-grow
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-file-input
                  :hint="permiumHint"
                  persistent-hint
                  v-model="mapFile"
                  :placeholder="oldFilename"
                  label="Map File"
                ></v-file-input>
              </v-col>
              <v-col cols="12" sm="4">
                <v-switch
                  v-model="premiumSwitch"
                  :label="`Is Premium`"
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
    snackbar: false,
    notification: "Something went wrong",
    oldFilename: "",
    valid: true,
    premiumSwitch: false,
    mapFile: [],
    mapSource: "",
    test: "",
    mapTitle: "",
    mapText: "",
    filePath: "",
    insert: "",
    oldFilepath: "",
    permiumHint:
      "Note: Please use .xls file, The file should contain dates as first coloumn."
  }),
  created() {
    const editComponent = {
      map_id: this.$route.params.id
    };
    this.axios
      .post(this.nodejsServer + "map/getEditMap", editComponent)
      .then(response => {
        if (!response.data.err_code) {
          this.oldFilename = response.data[0].media_value_img;
          (this.map_id = this.$route.params.id),
            (this.mapSource = response.data[0].source);
          this.mapTitle = response.data[0].title;
          this.mapText = response.data[0].description;
          this.oldFilepath = response.data[0].media_value_img;
          this.mediaSortOrder = response.data[0].media_sort;
          if (response.data[0].isPremium == "y") {
            this.premiumSwitch = true;
          } else {
            this.premiumSwitch = false;
          }
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
        if (this.premiumSwitch == true) {
          this.premiumSwitch = "y";
        } else {
          this.premiumSwitch = "n";
        }
        if (this.mapFile.name) {
          const mapDetails = { id: this.map_id };
          this.axios
            .post(this.nodejsServer + "map/deleteMapvalues", mapDetails)
            .then(() => {});
          const upload = new FormData();
          upload.append("UploadFiles", this.mapFile, this.mapFile.name);
          this.filePath = this.axios
            .post(this.nodejsServer + "post/saveFile", upload)
            .then(response => {
              // headers: {
              //   "Content-Type": "multipart/form-data"
              // }
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
            data = this.oldFilepath;
          } else {
            const mapDetails = {
              id: this.map_id,
              filepath: data
            };
            this.axios
              .post(this.nodejsServer + "map/xlstojsonMap", mapDetails)
              .then(response => {
                if (response.data.err_code) {
                  this.notification = response.data.message;
                  this.snackbar = true;
                }
              });
          }
          const mapData = {
            gid: this.map_id,
            source: this.mapSource,
            title: this.mapTitle,
            description: this.mapText,
            filepath: data,
            isPremium: this.premiumSwitch
          };
          this.axios
            .post(this.nodejsServer + "map/updateMap", mapData)
            .then(response => {
              if (!response.data.err_code) {
                this.$router.push("/mapList");
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
