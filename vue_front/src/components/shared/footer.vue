<template>
  <v-content>
    <footer>
      <v-container>
        <v-row class="footer_container">
          <v-col cols="12" sm="8">
            <div class="sub-title">
              <h5>About us</h5>
              <div class="sttl-line"></div>
            </div>
            <p class="fc_about">
              India Macro Advisors Inc. ("We") are not an investment advisory and we do not make any offer or solicitation to buy/sell financial securities or other type of assets. The information contained herein has been obtained from, or is based upon, sources believed by us to be reliable, but we do not make any representation or warranty for their accuracy or completeness. The text, numerical data, charts and other graphical contents we provide ("IMA contents") are copyrighted properties of India Macro Advisors ("Us"). While we permit personal non-commercial usage of IMA contents, it should be accompanied by an explicit mention that the contents belong to us. We do not allow any reproduction of IMA contents for other purposes unless specifically authorised by us. Please contact us at
              <a
                href="mailto:info@indiamacroadvisors.com"
              >info@indiamacroadvisors.com</a> to seek our authorization.
            </p>
          </v-col>
          <v-col cols="12" sm="4">
            <div class="sub-title">
              <h5>Follow Us</h5>
              <div class="sttl-line"></div>
            </div>
            <ul class="list_socail">
              <li class="fs_linkedin">
                <a
                  target="_blank"
                  href="https://www.linkedin.com/company/india-macro-advisors"
                  data-original-title="Linked in"
                >
                  <v-icon>mdi-linkedin</v-icon>
                </a>
              </li>
              <li class="fs_twitter">
                <a
                  target="_blank"
                  href="https://twitter.com/IndiaMAdvisors"
                  data-original-title="Twitter"
                >
                  <v-icon>mdi-twitter</v-icon>
                </a>
              </li>
              <li class="fs_facebook">
                <a
                  target="_blank"
                  href="https://www.facebook.com/indiamacroadvisors/"
                  data-original-title="Facebook"
                >
                  <v-icon>mdi-facebook</v-icon>
                </a>
              </li>
            </ul>
            <div class="sub-title">
              <h5>Safe and Secure Payment</h5>
              <div class="sttl-line"></div>
            </div>
            <div class="scrpay_con">
              <img src="@/assets/images/powered_by_razorpay.png" alt="Powered by stripe" />
              <img src="@/assets/images/trusted-site-seal.png" alt="Comodo Trusted Site Seal" />
            </div>
          </v-col>
        </v-row>
      </v-container>
      <div class="footer_copycont">
        <v-container>
          <v-row>
            <v-col cols="12" sm="6">
              <p class="copy_right">Copyright © 2012-2019; INDIA MACRO ADVISORS</p>
            </v-col>
            <v-col cols="12" sm="6">
              <ul class="list-inline">
                <li>
                  <a href>Home</a>
                </li>
                <li>
                  <a href>Terms Of Use</a>
                </li>
                <li>
                  <a href>Our Privacy Policy</a>
                </li>
                <li>
                  <a href>Contact</a>
                </li>
              </ul>
            </v-col>
          </v-row>
        </v-container>
      </div>
    </footer>
  </v-content>
</template>
<style lang="scss" scoped>
.v-application ul {
  padding-left: 0;
}
</style>
<style lang="scss">
@import "../../assets/_variables.scss";
footer {
  background: $dark-gray;
  border-top: 21px solid $lGray-d;
  margin-top: 30px;
  color: $white;
  padding-top: 25px;
  .footer_container {
    padding-bottom: 21px;
    a {
      color: $lGray-c;
      text-decoration: underline;
    }
    a:hover {
      color: $primari-color;
    }
  }
  .list_socail {
    margin-bottom: 21px;
    li.fs_linkedin {
      background: #007bb6;
    }
    li.fs_twitter {
      background: #4099ff;
    }
    li.fs_facebook {
      background: #3b5998;
    }
    i {
      font-size: 21px;
    }
    a {
      width: 41px;
      height: 41px;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    a:hover .v-icon {
      color: $white;
    }
    .v-icon {
      color: $lGray-c;
    }
  }
  .scrpay_con img {
    height: 37px;
    padding-right: 15px;
  }
  .fc_about {
    font-size: 14px;
    text-align: justify;
  }
  .footer_copycont {
    background: $lGray-d;
    color: $dark-gray;
    p {
      margin-bottom: 0;
      font-size: 13px;
      padding-top: 2px;
    }
    .list-inline a {
      padding: 0 10px;
      color: $dark-gray;
      text-decoration: none;
      border-right: 1px solid #2d2d2d;
      &:hover {
        color: $primari-color;
      }
    }
    .list-inline li:last-child a {
      border-right: 0;
    }
    .col-12 {
      padding: 0;
    }
  }
}
</style>