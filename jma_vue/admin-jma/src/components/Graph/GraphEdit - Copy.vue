<template>
  <div>
    <v-card>
      <v-card-title>Graph Edit</v-card-title>
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
                  v-model="graphSource"
                  label="Source"
                  :rules="[v => !!v || 'Please enter Media Text']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="graphTitle"
                  label="Title"
                  :rules="[v => !!v || 'Please enter Graph Title.']"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-textarea
                  label="Text"
                  v-model="graphText"
                  auto-grow
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="4">
                <v-file-input
                  :hint="permiumHint"
                  persistent-hint
                  v-model="graphFile"
                  :placeholder="oldFilename"
                  label="Graph File"
                ></v-file-input>
              </v-col>
              <v-col cols="12" sm="4">
                <v-text-field
                  v-model="updatedPage"
                  label="In which page is updated"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="2">
                <v-switch
                  v-model="premiumSwitch"
                  :label="`Is Premium`"
                ></v-switch>
              </v-col>
              <v-col cols="12" sm="2">
                <v-switch
                  v-model="mapSwitch"
                  label="Is Map"
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
    mapSwitch : false,
    oldFilename: "",
    valid: true,
    premiumSwitch: false,
    graphFile: [],
    graphSource: "",
    test: "",
    graphTitle: "",
    graphText: "",
    filePath: "",
    insert: "",
    oldFilepath: "",
    updatedPage:"",
    permiumHint:
      "Note: Please use .xls file, The file should contain dates as first coloumn."
  }),
  created() {
    const editComponent = {
      graph_id: this.$route.params.id
    };
    this.axios
      .post(this.nodejsServer + "media/getEditGraph", editComponent)
      .then(response => {
        if (!response.data.err_code) {
          this.oldFilename = response.data[0].filepath;
          (this.graph_id = this.$route.params.id),
            (this.graphSource = response.data[0].source);
          this.graphTitle = response.data[0].title;
          this.graphText = response.data[0].description;
          this.oldFilepath = response.data[0].filepath;
          this.mediaSortOrder = response.data[0].media_sort;
          this.updatedPage = response.data[0].updated_page;
          if (response.data[0].type == "Map") {
            this.mapSwitch = true;
          } else {
            this.mapSwitch = false;
          }
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
        var isMap = "";
         if (this.mapSwitch == true) {
            isMap = "Map";
          } else {
            isMap = "Graph";
          }
        if (this.premiumSwitch == true) {
          this.premiumSwitch = "y";
        } else {
          this.premiumSwitch = "n";
        }
        if (this.graphFile.name) {
          const graphDetails = {
            id: this.graph_id
          };
          this.axios
            .post(this.nodejsServer + "graph/deleteGraphvalues", graphDetails)
            .then(() => {});
          const upload = new FormData();
          upload.append("UploadFiles", this.graphFile, this.graphFile.name);
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
            const graphDetails = {
              id: this.graph_id,
              filepath: data
            };
            if (this.mapSwitch == true) {
              this.axios.post(this.nodejsServer + "map/xlstojsonMap", graphDetails).then(response => {
                if (!response.data.err_code) {
                  this.$router.push("/GraphList");
                } else {
                  this.notification = response.data.message;
                  this.snackbar = true;
                }
              });
            } else {
              this.axios.post(this.nodejsServer + "graph/xlstojson", graphDetails).then((response)=> {
                if(!response.data.err_code){
                  this.$router.push("/GraphList");
                } else {
                  this.notification = response.data.message;
                  this.snackbar = true;
                }
              })
            }
          }
          const graphData = {
            gid: this.graph_id,
            source: this.graphSource,
            title: this.graphTitle,
            description: this.graphText,
            filepath: data,
            isPremium: this.premiumSwitch,
            updated_page:this.updatedPage,
            type : isMap
          };
          this.axios
            .post(this.nodejsServer + "graph/updateGraph", graphData)
            .then(response => {
              if (!response.data.err_code) {
                this.$router.push("/GraphList");
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
