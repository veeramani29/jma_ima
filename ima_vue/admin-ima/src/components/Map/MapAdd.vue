<template>
  <div>
    <v-card>
      <v-card-title>Map Add</v-card-title>
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
                  :rules="[v => !!v || 'Please enter Map Text']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="mapTitle"
                  label="Title"
                  :rules="[v => !!v || 'Please enter Map Title']"
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
                  label="Map File"
                  :rules="[v => !!v || 'Please select Map File']"
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
    valid: true,
    premiumSwitch: false,
    mapFile: null,
    mapSource: "",
    test: "",
    mapTitle: "",
    mapText: "",
    filePath: "",
    insert: "",
    permiumHint:
      "Note: Please use .xls file, The file should contain dates as first coloumn."
  }),
  created() {
    this.axios.get(this.nodejsServer + "map/getMap").then(response => {
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
        if (this.premiumSwitch == true) {
          this.premiumSwitch = "y";
        } else {
          this.premiumSwitch = "n";
        }
        if (this.mapFile.name) {
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
          const mapData = {
            source: this.mapSource,
            title: this.mapTitle,
            description: this.mapText,
            filepath: data,
            isPremium: this.premiumSwitch
          };
          this.insert = this.axios
            .post(this.nodejsServer + "map/insertmap", mapData)
            .then(function(response) {
              if (!response.data.err_code) {
                return response.data;
              } else {
                this.notification = response.data.message;
                this.snackbar = true;
              }
            });
          this.insert.then(id => {
            const mapDetails = {
              id: id.insertId,
              filepath: data
            };
            this.axios
              .post(this.nodejsServer + "map/xlstojsonMap", mapDetails)
              .then(response => {
                if (!response.data.err_code) {
                  this.$router.push("/mapList");
                } else {
                  this.notification = response.data.message;
                  this.snackbar = true;
                }
              });
          });
        });
      }
    }
  }
};
</script>
