<template>
  <div>
    <v-card>
      <v-card-title>Graph Add</v-card-title>
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
                  v-model="graphSource"
                  label="Source"
                  :rules="[v => !!v || 'Please enter Media Text']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field v-model="graphTitle" label="Title" :rules="[v => !!v || 'Please enter Graph Title.']"></v-text-field>
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
                  label="Graph File"
                   :rules="[v => !!v || 'Please select graph file']"
                ></v-file-input>
              </v-col>
              <v-col cols="12" sm="4">
                <v-switch v-model="premiumSwitch" :label="`Is Premium`"></v-switch>
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
    snackbar: false,
    notification: "Something went wrong",
    valid: true,
    premiumSwitch: false,
    graphFile: null,
    graphSource: "",
    test:"",
    graphTitle: "",
    graphText: "",
    filePath: "",
    insert: "",
    permiumHint:
      "Note: Please use .xls file, The file should contain dates as first coloumn."
  }),
  created() {
    this.axios.get(this.nodejsServer + "graph/getGraph").then(response => {
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
        if (this.graphFile.name) {
          const upload = new FormData();
          upload.append("UploadFiles", this.graphFile, this.graphFile.name);
          this.filePath=this.axios
            .post(this.nodejsServer + "post/saveFile", upload).then((response) => {
              // headers: {
              //   "Content-Type": "multipart/form-data"
              // }
              return response.data;
            });
            
        } else {
          this.filePath=this.axios
            .get(this.nodejsServer + "post/getNull").then((response) => {
              return response.data;
            });
        }
        this.filePath.then(data => { 
          const graphData = {
            source: this.graphSource,
            title: this.graphTitle,
            description: this.graphText,
            filepath: data,
            isPremium: this.premiumSwitch
          };
          this.insert = this.axios
            .post(this.nodejsServer + "graph/insertGraph", graphData).then((response) => {
              if(!response.data.err_code){
                return response.data;
              } else {
                this.notification = response.data.message;
                this.snackbar = true;
              }
            })
          this.insert.then(id => {
            const graphDetails = {
                id: id.insertId,
                filepath: data,
            };
            this.axios
            .post(this.nodejsServer + "graph/xlstojson", graphDetails).then((response)=> {
              if(!response.data.err_code){
                this.$router.push("/GraphList");
              } else {
                this.notification = response.data.message;
                this.snackbar = true;
              }
            })
          });
        
        })
      }
    }
  }
};
</script>