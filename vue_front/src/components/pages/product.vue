<template>
  <v-content>
    <div class="main-title">
      <h1>IMA Subscription Package</h1>
      <div class="mttl-line"></div>
    </div>
    <p class="priConTtl">To enjoy our services please register with us using the options below</p>
    <v-row>
      <v-col sm="6">
        <div class="pricing pricing_free">
          <div class="thumbnail">
            <v-icon>mdi-account</v-icon>
          </div>
          <div class="titlefree title">Free Subscription</div>
          <div class="content">
            <div class="sub-title">No fee at all!</div>
            <ul>
              <li class="price_innttl">Data and Chartbook creation</li>
              <li>
                <v-icon>mdi-check-bold</v-icon>Download macroeconomic statistics
              </li>
              <li>
                <v-icon>mdi-close</v-icon>Download proprietary statistics
              </li>
              <li>
                <v-icon>mdi-check-bold</v-icon>Save your charts/tables (*1)
              </li>
              <li class="price_innttl">Published Research</li>
              <li>
                <v-icon>mdi-check-bold</v-icon>Regular commentary on data/policy change
              </li>
              <li>
                <v-icon>mdi-close</v-icon>Thematic Reports
              </li>
              <li class="price_innttl">Support and consulting services</li>
              <li>
                <v-icon>mdi-close</v-icon>Data request/inquiry (*2)
              </li>
              <li>
                <v-icon>mdi-close</v-icon>Research request (*3)
              </li>
            </ul>
            <v-btn @click="register" color="primary">REGISTER</v-btn>
          </div>
        </div>
      </v-col>
      <v-col sm="6">
        <div class="pricing pricing_premium">
          <div class="thumbnail">
            <span>
              <v-icon>mdi-account-star</v-icon>
              <!-- <i class="fa fa-user"></i>
              <sup>
                <i class="fa fa-star fa-fw"></i>
              </sup>-->
            </span>
          </div>
          <div class="title">Premium Subscription</div>
          <div class="content">
            <div class="sub-title">Monthly fee of INR 799</div>
            <ul>
              <li class="price_innttl">Data and Chartbook creation</li>
              <li>
                <v-icon>mdi-check-bold</v-icon>Download macroeconomic statistics
              </li>
              <li>
                <v-icon>mdi-check-bold</v-icon>Download our proprietary statistics
              </li>
              <li>
                <v-icon>mdi-check-bold</v-icon>Save your charts/tables (up to 2000 charts)
              </li>
              <li class="price_innttl">Published Research</li>
              <li>
                <v-icon>mdi-check-bold</v-icon>Regular commentary on data/policy change
              </li>
              <li>
                <v-icon>mdi-check-bold</v-icon>Thematic Reports
              </li>
              <li class="price_innttl">Support and consulting services</li>
              <li>
                <v-icon>mdi-check-bold</v-icon>Data request/inquiry (*2)
              </li>
              <li>
                <v-icon>mdi-check-bold</v-icon>Research request (*3)
              </li>
            </ul>
              <v-btn @click="register" color="primary">REGISTER</v-btn>
          </div>
        </div>
      </v-col>
    </v-row>
    <v-card outlined class="priConNote">
      <v-list-item three-line>
        <v-list-item-content>
          <div class="overline mb-4">__ Note</div>
          <v-list-item-subtitle>*1: We currently allow free users to save up to 4 charts/tables</v-list-item-subtitle>
          <v-list-item-subtitle>*2: Our research assistants are happy to help our Premium account users where to find data they are looking for.</v-list-item-subtitle>
          <v-list-item-subtitle>*3: Our research assistants can help locate and prepare data for our Premium account users</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </v-card>
  </v-content>
</template>
<script>
export default {
  methods:{
    register(){
      this.$router.push("registration")
    }
  }
}
</script>
<style lang="scss">
@import "@/assets/_variables.scss";
.pricing {
  background: $lGray;
  padding: 40px 0 20px;
  color: $white;
  -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
  box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
  .thumbnail {
    background: $white;
    display: block;
    width: 90px;
    height: 90px;
    margin: 0 auto;
    -webkit-border-radius: 100%;
    -moz-border-radius: 100%;
    border-radius: 100%;
    line-height: 80px;
    text-align: center;
    .v-icon {
      font-size: 43px;
      color: #6eb92b;
    }
  }
  .title {
    cursor: pointer;
    background: $primari-color;
    margin: 40px 0 0;
    padding: 10px;
    font-size: 18px;
    text-align: center;
    text-transform: uppercase;
  }
  .titlefree {
    background: #6eb92b;
  }
  .content {
    .sub-title {
      background: $lGray;
      padding: 10px;
      color: $dark-gray;
      font-size: 14px;
      text-align: center;
    }
    ul {
      list-style: none;
      background: $white;
      margin: 0;
      padding: 0;
      color: $dark-gray;
      font-size: 13px;
      li {
        padding: 10px 20px;
        &:nth-child(2n) {
          background: #f3f3f3;
        }
      }
      .v-icon {
        width: 16px;
        margin-right: 10px;
        text-align: center;
        margin-bottom: 7px;
        float: left;
        font-size: 14px;
      }
      .mdi-check-bold {
        color: #2ecc71;
      }
      .mdi-close {
        color: #e74c3c;
      }
    }
    button {
      display: block;
      width: 80%;
      margin: 0 auto;
      margin-top: 20px;
      padding: 7px 15px;
      color: #fff;
      font-size: 18px;
      text-align: center;
      text-decoration: none;
      -webkit-transition: 0.2s linear;
      -moz-transition: 0.2s linear;
      -ms-transition: 0.2s linear;
      -o-transition: 0.2s linear;
      transition: 0.2s linear;
      text-transform: uppercase;
    }
    .price_innttl {
      font-weight: bold;
    }
    .price_innsubs {
      font-weight: bold;
      text-align: center;
      font-size: 17px;
      font-family: "Lato";
    }
  }
}
.priConTtl {
  margin-bottom: 30px;
  color: $primari-color;
  font-size: 17px;
  text-align: center;
}
.priConNote {
  margin-top: 30px;
}
</style>