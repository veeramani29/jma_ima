<template>
  <div>
    <v-card>
      <v-card-title>Company Edit</v-card-title>
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
                  v-model="companyName"
                  label="Company Name"
                  :rules="[v => !!v || 'Please enter Company Name']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select
                  :items="companyStatusList"
                  v-model="companyStatus"
                  label="Company Status"
                  :rules="[v => !!v || 'Please select Company status']"
                ></v-select>
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
    companyName: "",
    notification: "Something went wrong",
    companyText:"", 
    companyStatus: [],
    companyStatusList:[{text:"Active",value:"Y"},{text: "Inactive",value:"N"}]
  }),
  created() {
    const editComponent = {
      company_id: this.$route.params.id
    };
    this.axios.post(this.nodejsServer + "media/getEditCompany", editComponent).then(response => {
      this.companyName = response.data[0].company_name;
      if(response.data[0].company_status == "Y")
        this.companyText = "Active";
      else
        this.companyText = "Inactive";
      this.companyStatus = {"text":this.companyText,"value":response.data[0].company_status};
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
        if(this.companyStatus == "object")
          this.companyStatus = this.companyStatus.value;
        const companyData = {
          id: this.$route.params.id,
          company_name: this.companyName,
          company_status: this.companyStatus
        };
        this.axios.post(this.nodejsServer + "company/updateCompany", companyData).then((response) => {
          if(!response.data.err_code){
            this.$router.push("/CompaniesList");
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