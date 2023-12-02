<template>
  <v-content>
    <v-container>
      <v-row>
        <v-col sm="2">
          <LeftNavigation />
        </v-col>
        <v-col sm="8">
          <div class="main-title">
            <h1>Contact Us</h1>
            <div class="mttl-line"></div>
          </div>
          <h3>General inquiry</h3>
          <p>
            For general inquiry, please send e-mail to
            <a href="mailto:info@indiamacroadvisors.com"
              >info@indiamacroadvisors.com</a
            >
          </p>
          <p>
            For technical assistance and subscription inquiry, please send
            e-mail to
            <a href="mailto:support@indiamacroadvisors.com"
              >support@indiamacroadvisors.com</a
            >
          </p>
          <v-tabs v-model="tab">
            <v-tab v-for="item in items" :key="item">{{ item }}</v-tab>
          </v-tabs>

          <v-tabs-items v-model="tab">
            <v-tab-item>
              <v-card-text>
                <div class="sub-title">
                  <h5>To visit India Macro Advisors</h5>
                  <div class="sttl-line"></div>
                </div>
                <p>
                  We(IMA) are located at #3163, First Floor 12
                  <sup>th</sup> A main, Doopanahalli , Domlur Main Road, HAL II
                  Stage Bangalore – 560038.. <br />Landmark: Opposite to Aaha
                  Andhra
                </p>
                <div class="sub-title">
                  <h5>
                    To reach Doopanahalli 12
                    <sup>th</sup> A main road
                  </h5>
                  <div class="sttl-line"></div>
                </div>
                <v-list-item-title class="mb-1">By Bus</v-list-item-title>
                <p>
                  <b>Get down at "Indranager" bus stop:</b>
                  <br />Walk straight towards 12 <sup>th</sup> main road
                  Doopanahalli for 500m. <br />Destination will be on the left.
                </p>
                <p>
                  <b>Get down at ESI Hospital Bus stop:</b>
                  <br />Walk South-West on 12 <sup>th</sup> main road towards
                  Aaha Andhra/The Baby Shop/Infinitea <br />Destination will be
                  on the right.
                </p>
              </v-card-text>
            </v-tab-item>
            <v-tab-item>
              <v-card-text>
                <p>
                  <strong>Address:</strong>
                </p>
                <p>
                  No.3163. Doopanahalli,
                  <br />1 <sup>st</sup> Floor, 12 <sup>th</sup> A main,
                  <br />Domlur Main Road, HAL II Stage, <br />Indranager Double
                  Rd <br />Bangalore- 560095
                  <br />
                </p>

                <iframe
                  height="500"
                  width="100%"
                  frameborder="0"
                  scrolling="no"
                  marginheight="0"
                  marginwidth="0"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18495.11482867028!2d77.64120231250662!3d12.964240214873456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae144f7e9ce721%3A0x55f6b352400552cc!2sInterMacro%20Associates!5e0!3m2!1sen!2sin!4v1575895638982!5m2!1sen!2sin"
                ></iframe>
              </v-card-text>
            </v-tab-item>
          </v-tabs-items>
        </v-col>
      </v-row>
    </v-container>
  </v-content>
</template>
<script>
import LeftNavigation from "@/components/shared/leftNavigation";
export default {
  components: {
    LeftNavigation
  },
  data() {
    return {
      tab: null,
      items: ["To reach us", "Our mailing address"],
      text:
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
    };
  }
};
</script>
