<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="2">
        <LeftNavigation />
      </v-col>
      <v-col cols="12" sm="10">
        <div class="userLogin">
          <v-row>
            <v-col cols="12" sm="6">
              <v-card>
                <div class="main-title">
                  <h1>Login</h1>
                  <div class="mttl-line"></div>
                </div>
                <div class="socList">
                  <v-btn class="loginLin" @click="linkedin">
                    <v-icon>mdi-linkedin</v-icon>Sign in
                  </v-btn>
                  <v-btn class="loginFac" @click="facebook">
                    <v-icon>mdi-facebook</v-icon>Sign in
                  </v-btn>
                </div>
                <div class="socOr">
                  <p>OR</p>
                </div>
                <v-form ref v-model="logIn" :lazy-validation="lazy">
                  <v-text-field v-model="email" :rules="emailRules" :maxlength="maxEmail" label="E-mail" required></v-text-field>
                  <v-text-field
                    v-model="password"
                    type="password"
                    :rules="[v => !!v || 'Password is required']"
                    label="Password"
                    :maxlength="maxPassword"
                    required
                  ></v-text-field>
                  <v-checkbox v-model="checkbox" value="yes" label="Keep me signed in"></v-checkbox>
                  <v-btn text color="primary" to="/forgot_password">Forgot Password</v-btn>
                  <br />
                  <v-btn :disabled="!logIn" color="success" class="mr-4" @click="validate">Submit</v-btn>
                </v-form>
              </v-card>
            </v-col>
            <v-col cols="12" sm="6">
              <v-card>
                <div class="main-title">
                  <h1>Register</h1>
                  <div class="mttl-line"></div>
                </div>
                <v-form ref v-model="register" :lazy-validation="lazy">
                  <v-text-field v-model="regEmail" :rules="emailRules" label="E-mail" required></v-text-field>
                  <p>Sign up for a free account.</p>
                  <v-btn :disabled="!register" color="success" class="mt-4" @click="validate">Continue</v-btn>
                </v-form>
                
              </v-card>
            </v-col>
          </v-row>
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
    return {
      logIn: false,
      register: false,
      lazy: false,
      password: "",
      email: "",
      maxEmail: 50,
      maxPassword: 15,
      emailRules: [
        v => !!v || "E-mail is required",
        v => /.+@.+/.test(v) || "E-mail must be valid"
      ],
      checkbox: "",
      regEmail: ""
    };
  },
    methods: {
      linkedin(){
        window.location.href=this.nodejsServer + "linkedin";
      },
      facebook(){
        window.location.href=this.nodejsServer + "facebook";
      },
      validate () {
          if (this.$refs.form.validate()) {
                const postData = {   
                                      'email':this.email,
                                      'password': this.password,
                                      'remember_me': this.checkbox
                                  };
                this.axios.post('http://localhost:5000/login-submit/',postData)
                           .then(
                                 response => {
                                      this.data = response.data;
                                      this.text = response.data;
                                      //this.snackbar = true;

                                     })
                            .catch(e => {
                              this.errors.push(e)
                            }) 
            }
      }
    }
};
</script>
<style lang="scss">
@import "@/assets/_variables.scss";
.userLogin {
  .socOr {
    text-align: center;
    p {
      display: inline-block;
      background: $lGray-d;
      padding: 11px;
      border-radius: 50%;
      font-size: 12px;
      margin: 15px auto 0;
    }
  }
  .v-card {
    padding: 25px;
  }
}
</style>
