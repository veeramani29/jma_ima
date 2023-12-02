<template>
  <div>
    <v-card>
      <v-card-title>Add IP Address</v-card-title>
      <v-card-actions>
        <v-snackbar v-model="snackbar">
            {{ notification }}
            <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
        <v-form class="col-12" ref="form" v-model="valid" lazy-validation autocomplete="false">
          <v-container class="grey lighten-5">
            <v-row>
              <v-col cols="12" sm="4">
                <p class="subtitle-1">User1</p>
                <v-card style="padding:15px;">
                    <v-textarea label="IP Address" v-model="user1IP" auto-grow></v-textarea>
                    <v-card-actions>
                        <v-btn color="primary" @click="submit(user1IP,1)">Add</v-btn>
                    </v-card-actions>
                </v-card>
              </v-col>
              <v-col cols="12" sm="4">
                <p class="subtitle-1">User2</p>
                <v-card style="padding:15px;">
                    <v-textarea label="IP Address" v-model="user2IP" auto-grow></v-textarea>
                    <v-card-actions>
                        <v-btn color="primary" @click="submit(user2IP,2)">Add</v-btn>
                    </v-card-actions>
                </v-card>
              </v-col>
              <v-col cols="12" sm="4">
                <p class="subtitle-1">User3</p>
                <v-card style="padding:15px;">
                    <v-textarea label="IP Address" v-model="user3IP" auto-grow></v-textarea>
                    <v-card-actions>
                        <v-btn color="primary" @click="submit(user3IP,3)">Add</v-btn>
                    </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-form>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  data: () => ({
    snackbar: false,
    valid: true,
    newsSwitch: false,
    notification:"Something Went Wrong",
    user1IP:"",
    user2IP:"",
    user3IP:"",
  }),
  created() {
    this.axios.get(this.nodejsServer + "settings/getIPAddress").then(response => {
        if(!response.data.err_code){
            this.user1IP = response.data[0].ip_address;
            this.user2IP = response.data[1].ip_address;
            this.user3IP = response.data[2].ip_address;
        } else {
            this.notification = response.data.message;
            this.snackbar = true;
        }
    });
   
  },
  methods: {
    submit(item,id) {
        const IPData = {
            id: id,
            ip_address: item,
        };
    this.axios.post(this.nodejsServer + "settings/insertIPAddress", IPData).then((response)=>{
        if(!response.data.err_code){
            this.notification = response.data;
            this.snackbar = true;
        } else {
        this.notification = response.data.message;
        this.snackbar = true;
        }
    })
    }
  }
};
</script>