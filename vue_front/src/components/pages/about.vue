<template>
  <v-content>
    <v-container>
      <v-row>
        <v-col md="2">
          <LeftNavigation />
        </v-col>
        <v-col md="7">
          <div class="main-title">
            <h1>About India Macro Advisors</h1>
            <div class="mttl-line"></div>
          </div>
          <p>
            The official Indian macroeconomic data is spread over many
            government websites in an unstructured format. Indian economy has
            always faced a problem of inadequacy of structured and "easy to use"
            accessible data. We (IMA) feel that an economy should have an open
            data policy where the data should be easily available. We believe
            that the access to data should not just be available to corporates,
            researchers or policy makers, but for everyone.
          </p>
          <p>
            We aim to provide well-structured interactive online database portal
            for the Indian economy along with a concise and insightful analysis
            on the data. This would facilitate research across various sectors
            of the Indian economy. We hope such open and easy access to data
            would lead to a better understanding of the Indian economy among the
            general public, businesses, researchers and help them make better
            and informed decisions.
          </p>
          <p>
            Our competitors may include various incumbent database companies and
            other economic analysis web-platforms. However, we distinguish
            ourselves from the other players by providing data in a more
            accessible and easy to understand structure through the use of our
            charts and various other user-friendly features. Additionally, our
            motto is make IMA an effective portal for anybody to understand,
            learn and know about the Indian economy. Building a comprehensive
            dataset is the first step towards that goal followed by a concise
            and easy to understand analysis.
          </p>
          <p>
            India Macro Advisors (IMA) is a privately owned affiliate of the
            "Japan Macro Advisors" (JMA) group.
          </p>
          <p class="opaFifty">IMA Team</p>
          <div class="abtSocial">
            <h5>Follow Us</h5>
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
          </div>
          <div class="main-title">
            <h1>Our Team</h1>
            <div class="mttl-line"></div>
          </div>
          <div class="otCon">
            <v-row>
              <v-col sm="3">
                <img src="@/assets/images/Rijutha_raj.jpg" alt="Rijutha Raj" />
              </v-col>
              <v-col sm="9">
                <h4>Rijutha B Raj</h4>
                <p class="ocDes">Economist</p>
                <truncate
                  class="otcTru"
                  clamp="Show More"
                  :length="247"
                  less="Show Less"
                  text="Prior to joining IMA, she has interned at NIAS, Bangalore in 2017, with a team from the RBI Programme on Interdisciplinary Approaches to Economic Issues. She was involved in a project titled Financial Inclusion in Karnataka, a study conducted for Vijaya Bank. She holds a bachelor’s degree and a post graduate degree in Economics from St. Joseph’s College, Bangalore. Apart from work she enjoys hiking, photography and cooking."
                ></truncate>
              </v-col>
            </v-row>
            <v-row>
              <v-col sm="3">
                <img src="@/assets/images/Hema_kumari.jpg" alt="Hema Kumari" />
              </v-col>
              <v-col sm="9">
                <h4>Hema Kumari</h4>
                <p class="ocDes">Junior Economist</p>
                <truncate
                  class="otcTru"
                  clamp="Show More"
                  :length="250"
                  less="Show Less"
                  text="Before joining IMA, she has completed her post-graduation in Economics from University of Hyderabad in 2018. She holds a B.com(H) degree from University of Delhi. Apart from work she enjoys sketching and dancing."
                ></truncate>
              </v-col>
            </v-row>
            <v-row>
              <v-col sm="3">
                <img
                  src="@/assets/images/about_takuji.png"
                  alt="Takuji Okubo"
                />
              </v-col>
              <v-col sm="9">
                <h4>Takuji Okubo</h4>
                <p class="ocDes">Managing Director and Chief Economist</p>
                <truncate
                  class="otcTru"
                  clamp="Show More"
                  :length="236"
                  less="Show Less"
                  text="Prior to founding IMA, he worked as Chief Economist for Societe Generale in Tokyo, covering the Japanese and South Korean economy. His previous positions includes Senior Economist at Merrill Lynch and at Goldman Sachs. Apart from work, he enjoys motor-cycling, scuba-diving, cooking as well as worrying about the future of the Japanese economy. Takuji holds B.A in Economics from Tokyo University, MBA from INSEAD and post graduate degrees in Economics from UPF in Barcelona."
                ></truncate>
              </v-col>
            </v-row>
          </div>
        </v-col>
        <v-col md="3"><RightSideBar /> </v-col>
      </v-row>
    </v-container>
  </v-content>
</template>
<script>
import LeftNavigation from "@/components/shared/leftNavigation";
import RightSideBar from "@/components/shared/rightSideBar";
import truncate from "vue-truncate-collapsed";
export default {
  components: {
    LeftNavigation,
    truncate,
    RightSideBar
  }
};
</script>
<style lang="scss" scoped>
@import "@/assets/_variables.scss";
li.fs_linkedin {
  background: #007bb6;
}
li.fs_twitter {
  background: #4099ff;
}
li.fs_facebook {
  background: #3b5998;
}
a {
      width: 35px;
      height: 35px;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
    }
     i {
      font-size: 21px;
    }
    a:hover .v-icon {
      color: $white;
    }
    .v-icon {
      color: white;
    }
p {
  text-align: justify;
}
.opaFifty {
  color: $gray;
  font-weight: 700;
}
.abtSocial {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  border: 1px solid $lGray-d;
  border-width: 1px 0;
  padding: 5px 0px;
  margin-bottom: 20px;
  h5 {
    font-size: 17px;
    margin-right: 10px;
  }
  .v-icon {
    font-size: 18px;
  }
}
.otCon {
  .ocDes {
    color: $gray;
  }
  .otcTru {
    a {
      display: block;
    }
  }
}
</style>
<style lang="scss">
.otCon {
  .otcTru {
    span {
      text-align: justify;
      display: inline-block;
    }
    a {
      display: block;
      text-align: right;
    }
  }
}
</style>
