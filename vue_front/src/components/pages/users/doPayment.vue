<template>
  <v-container>
    <v-row>
      <v-col sm="8">
        <div class="main-title">
          <h1>Payment</h1>
          <div class="mttl-line"></div>
        </div>
        <div class="sub-title">
          <h5>
            <v-icon>mdi-account-star</v-icon>PREMIUM Subscription plan
          </h5> 
          <div class="sttl-line"></div>
        </div>
        <v-card outlined>
          <v-card-title class="headline doPayAgree">
            Pay with your debit or credit card:
            <img src="@/assets/images/stripe-logo.png" alt />
          </v-card-title>
          <v-card-text>
            <v-form ref="form" v-model="valid" :lazy-validation="lazy">
              <div class="doPaychebox">
                <v-checkbox
                  :value="agreeData"
                  :rules="[v => !!v || 'You must agree to continue!']"
                  label="I accept the"
                  required
                ></v-checkbox>
                <v-btn text @click="toggleModal()">terms of use</v-btn>
              </div>
              <v-btn :disabled="!valid" color="primary">Continue</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col sm="4">
        <div class="sub-title">
          <h5>Your payment information are secure with us</h5>
          <div class="sttl-line"></div>
        </div>
        <div class="doPayRazcom">
          <img src="@/assets/images/razorpay-gate.png" alt="razorpay payment gateway" />
          <img src="@/assets/images/trusted-site-seal.png" alt="Trusted Site Seal" />
        </div>
        <div class="doPaySecure">
          <img src="@/assets/images/safe-checkout.png" alt="Comodo secure" />
        </div>
      </v-col>
    </v-row>
    <Condition />
  </v-container>
</template>
<script>
import Condition from "@/components/shared/modals/condition";
export default {
  components: {
    Condition
  },
  data: () => ({
    valid: true,
    lazy: false
  }),
  computed: {
    agreeData() {
      return this.$store.state.agreeTerm;
    }
  },
  methods: {
    toggleModal() {
      this.$store.state.termConModal = !this.$store.state.termConModal;
    }
  }
};
</script>
<style lang="scss">
@import "@/assets/_variables.scss";
.doPayRazcom {
  display: flex;
  justify-content: space-around;
  align-items: center;
  border-bottom: 1px solid $lGray;
  padding-bottom: 30px;
  margin-bottom: 20px;
  img {
    width: 130px;
  }
}
.doPayAgree {
  display: flex;
  justify-content: space-between;
  flex-direction: row;
  flex-wrap: nowrap;
  img {
    height: 35px;
  }
}
.doPaychebox {
  display: flex;
  align-items: center;
  .v-btn:not(.v-btn--round).v-size--default {
    min-height: auto;
    height: auto;
    padding-bottom: 8px;
    padding-left: 7px;
    font-size: 15px;
  }
}
</style>