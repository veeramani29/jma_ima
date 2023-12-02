<template>
  <div>
    <v-card>
      <v-card-title>Homapage Graph Edit</v-card-title>
      <v-card-actions>
        <v-form class="col-12" ref="form" v-model="valid" lazy-validation autocomplete="false">
          <v-container>
            <v-row>
              <v-snackbar v-model="snackbar">
                {{ notification }}
              <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
            </v-snackbar>
              <v-col cols="12">
                <v-text-field
                  v-model="title"
                  label="Title"
                  :rules="[v => !!v || 'Please enter Company Name']"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  label="Description"
                  v-model="description"
                  :rules="[v => !!v || 'Please enter short Description.']"
                  auto-grow
                  required
                ></v-textarea>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="graphCode"
                  label="Graph Code"
                  :rules="[v => !!v || 'Please enter Company Name']"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="reportLink"
                  label="Report Link"
                  :rules="[v => !!v || 'Please enter Company Name']"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="publishedDate"
                  label="Published Date"
                  :rules="[v => !!v || 'Please enter Company Name']"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit">Submit</v-btn>
        </v-form>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  data: () => ({
    snackbar : false,
    notification:"Something went wrong",
    publishedDate: "",
    menu2: false,
    valid: true,
    title:"",
    description:"",
    graphCode: "",
    reportLink:"",
    graphId:""
  }),
  created(){
    this.axios.get(this.nodejsServer + "graph/getHomePageGraph").then(response => {
      if(!response.data.err_code){
        this.graphId = response.data[0].id;
        this.title = response.data[0].title;
        this.description = response.data[0].description;
        this.graphCode = new Buffer( response.data[0].graph_code, 'binary' ).toString('utf8');
        this.reportLink = response.data[0].report_link;
        this.publishedDate = response.data[0].published_date;
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

        const updateData = {
          id:this.graphId,
          title: this.title,
          description:this.description,
          graph_code:this.graphCode,
          report_link:this.reportLink,
          published_date:this.publishedDate,
        };
        this.axios.post(this.nodejsServer + "graph/updateHomePageGraph", updateData).then(response => {
          if(!response.data.err_code){
            this.$router.push("/indexGraph");
          } else {
            this.notification = response.data.message;
            this.snackbar = true;
          }
          this.category = response.data;
        });
      }
    }
  }
};
</script>