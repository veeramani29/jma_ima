<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="2">
        <LeftNavigation />
      </v-col>
      <v-col cols="12" sm="10">
        <div class="regSuccessfull">
          <v-card>
            <div class="main-title">
              <h1>Registration Successful</h1>
              <div class="mttl-line"></div>
            </div>
            <p>
              Dear
              <b>{{fname}} {{lname}},</b>
            </p>
            <p>
              Thank you for signing up with India Macro Advisors. A validation message was sent to your email address, {{email}}. If you do not receive it in the next 10 minutes, please email
              <a
                href="mailto:support@indiamacroadvisors.com."
              >support@indiamacroadvisors.com.</a>
            </p>
            <v-simple-table>
              <template>
                <tbody>
                  <tr>
                    <td>Given name</td>
                    <td>{{fname}}</td>
                  </tr>
                  <tr>
                    <td>Surname</td>
                    <td>{{lname}}</td>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td>{{email}}</td>
                  </tr>
                  <tr>
                    <td>Account Type</td>
                    <td>{{accountType}}</td>
                  </tr>
                  <tr>
                    <td>Account status</td>
                    <td>{{accountStatus}}</td>
                  </tr>
                  <tr>
                    <td>Account expiry date</td>
                    <td>N/A</td>
                  </tr>
                  <tr>
                    <td>Subscription Amount</td>
                    <td>N/A</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-card>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import LeftNavigation from "@/components/shared/leftNavigation";
export default {
  components: {
    LeftNavigation
  },
  data() {
    //window.console.log(this.$store.state.dynamicData );
    return {
      fname: '',
      lname: '',
      email: '',
      accountType: '',
      accountStatus: '',
      accountExpiry: '',
      subscriptionAmount: '',
    };
  },
  created(){
      if(typeof this.$store.state.dynamicData === 'number'){
          this.axios.get(this.nodejsServer + "registeredData/"+this.$store.state.dynamicData).then(response => {
          this.fname = response.data[0].fname;
          this.lname = response.data[0].lname;
          this.email = response.data[0].email;
          if(response.data[0].user_type_id == 1){
            this.accountType = 'free';
          }
          else{
            this.accountType = 'Premium';
          }
          if(response.data[0].user_status_id == 4){
            this.accountStatus = 'Inactive';
          }
          else{
            this.accountStatus = '';
          }
          this.accountExpiry = response.data[0].expiry_on;
          this.subscriptionAmount = 'N/A';
          //window.console.log(response.data[0].fname);
        });
      } 
  }
};
</script>
<style lang="scss">
@import "@/assets/_variables.scss";
.regSuccessfull {
  .v-card {
    padding: 25px;
  }
}
</style>
