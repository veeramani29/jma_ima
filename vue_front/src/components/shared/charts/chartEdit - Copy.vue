<template>
  <v-content class="chartContainer">
  
    <div class="chartArea">
      <div class="caHead">
        <v-menu bottom left offset-y content-class="caVmenu">
          <template v-slot:activator="{ on }">
            <v-btn icon v-on="on">
              <v-icon>share</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item v-for="(item, i) in shareChart" :key="i" @click="shareChart">
              <v-list-item-title>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
        <v-menu bottom left offset-y content-class="caVedit">
          <template v-slot:activator="{ on }">
            <v-btn icon v-on="on">
              <v-icon>mdi-square-edit-outline</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item v-for="(item, i) in editChart" :key="i" @click="editChart">
              <v-list-item-title>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-title>
            </v-list-item>
            <v-list-item class="cavNotes">
              <v-list-item-title>
                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <span v-on="on">Drag</span>
                  </template>
                  <span>Select and Drag</span>
                </v-tooltip>
                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <span v-on="on">Delete</span>
                  </template>
                  <span>Select and Double click</span>
                </v-tooltip>
                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <span v-on="on">Size control</span>
                  </template>
                  <span>Click hold and drag</span>
                </v-tooltip>
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
        <v-menu
          bottom
          left
          offset-y
          :close-on-content-click="closeOnContentClick"
          content-class="caVdown"
        >
          <template v-slot:activator="{ on }">
            <v-btn icon v-on="on">
              <v-icon>mdi-download</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item>
              <form action>
                <v-select :items="downloadChart" label="Download Data" class="caSelect"></v-select>
                <div class="caDbtns">
                  <v-btn small color="primary">Export</v-btn>
                  <v-btn small color="primary">Print</v-btn>
                </div>
              </form>
            </v-list-item>
          </v-list>
        </v-menu>
        <v-btn icon @click.stop="toggleModal()">
          <v-icon>mdi-content-save-outline</v-icon>
        </v-btn>
      </div>

      <v-tabs v-model="chartSwitch" class="caChaSwi">
      <v-tabs-slider></v-tabs-slider>
        <v-tab-item value="search">
          <v-card flat>
            <v-card-text>
              <div class="animationDiv"></div>
                  :constructor-type="'stockChart'"  :options="chartOptions" :callback="someFunction" {{name}} 
              <highcharts {{name}}   ></highcharts>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item value="searchs">
          <v-card flat>
            <v-card-text>table</v-card-text>
          </v-card>
        </v-tab-item>
      
      
        <v-tab href="#search">
          <v-icon>mdi-chart-bell-curve-cumulative</v-icon>Chart
        </v-tab>
        <v-tab href="#searchs">
          <v-icon>mdi-table-large</v-icon>Table
        </v-tab>
      </v-tabs>
    </div>
    <div class="chartEditArea">
      <v-tabs v-model="chartEdit">
        <v-tab>Series</v-tab>
        <v-tab>Share</v-tab>
      </v-tabs>
      <v-tabs-items v-model="chartEdit">
        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <v-form>
                <div class="ceaAddCon" v-for="(item, index) in addSeries" :key="index">
                  <div class="ceaAddSea">
                    <v-menu
                      bottom
                      offset-y
                      :close-on-content-click="colorPicker"
                      content-class="vmColSwa"
                    >
                      <template v-slot:activator="{ on }">
                        <v-btn v-on="on">
                          <v-icon :color="chartColor" @click="changeColor()">mdi-format-color-fill</v-icon>
                        </v-btn>
                      </template>
                      <v-list>
                        <v-list-item>
                          <v-color-picker
                            v-model="chartColor"
                            class="ma-2"
                            :swatches="swatches"
                            show-swatches
                            width="150px"
                            hide-mode-switch
                            canvas-height="70px"
                          ></v-color-picker>
                        </v-list-item>
                      </v-list>
                    </v-menu>
                    <v-select
                      :items="states"
                      menu-props="auto"
                      hide-details
                      label="Select"
                      outlined
                      dense
                    ></v-select>
                  </div>
                  <v-select
                    :items="states"
                    menu-props="auto"
                    hide-details
                    label="Select"
                    outlined
                    dense
                  ></v-select>
                </div>
                <div class="ceaRemEdi">
                  <v-btn small text @click="deleteRow(itemRemove)" class="cre-rembtn">Remove series</v-btn>
                  <v-menu offset-y content-class="indDropdown">
                    <template v-slot:activator="{ on }">
                      <v-btn small v-on="on" :disabled="asDisable" class="cre-admobt">
                        <v-icon color="primary">mdi-chart-multiple</v-icon>Add more series
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item
                        v-for="(item, index) in indicatorTitle"
                        :key="index"
                        class="mainIndicator"
                      >
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                        <v-list class="dropdownList">
                          <v-list-item
                            class="subDropList"
                            v-for="(item, index) in item.indDrop"
                            :key="index"
                          >
                            <v-list-item-title>{{ item.dropOne }}</v-list-item-title>
                            <v-list class="dropdownList">
                              <v-list-item v-for="(item, index) in item.lastChild" :key="index">
                                <v-list-item-title @click="addRow">{{ item.title }}</v-list-item-title>
                              </v-list-item>
                            </v-list>
                          </v-list-item>
                        </v-list>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>
                <div class="ceaCheBox">
                  <v-checkbox v-model="multipleYAxis" label="Multiple yAxis"></v-checkbox>
                  <v-checkbox v-model="barChart" label="Bar chart"></v-checkbox>
                  <div v-if="multipleYAxis == false">
                    <v-checkbox v-model="reverseYAxis" label="Reverse Y axis"></v-checkbox>
                  </div>
                  <div v-else class="ccbMulRev">
                    <label class="v-label">Reverse Y axis</label>
                    <v-checkbox v-model="reverseYAxis1" color="primary"></v-checkbox>
                    <v-checkbox v-model="reverseYAxis2"></v-checkbox>
                    <v-checkbox v-model="reverseYAxis3"></v-checkbox>
                  </div>
                </div>
              </v-form>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <h5>Share on Social Media</h5>
              <div class="socialIcons">
                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <v-btn icon to="#" v-on="on">
                      <v-icon>mdi-facebook</v-icon>
                    </v-btn>
                  </template>
                  <span>Share on Facebook</span>
                </v-tooltip>
                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <v-btn icon to="#" v-on="on">
                      <v-icon>mdi-twitter</v-icon>
                    </v-btn>
                  </template>
                  <span>Share on Twitter</span>
                </v-tooltip>
                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <v-btn icon to="#" v-on="on">
                      <v-icon>mdi-linkedin</v-icon>
                    </v-btn>
                  </template>
                  <span>Share on Linkedin</span>
                </v-tooltip>
              </div>
              <h5>Share Link</h5>
              <v-text-field label="Solo" solo v-model="socialLink" dense></v-text-field>
              <v-btn
                small
                color="primary"
                v-clipboard:copy="socialLink"
                v-clipboard:success="onCopy"
                v-clipboard:error="onError"
              >{{ clipboardText }}</v-btn>
            </v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </div>
  </v-content>
</template>
<script>
/* eslint-disable */
import { Chart } from "highcharts-vue";

export default {
  components: {
    highcharts: Chart
  },
  data() {
    return {
    veera:false,
      shareChart: [
        { icon: "mdi-facebook" },
        { icon: "mdi-twitter" },
        { icon: "mdi-linkedin" }
      ],
      editChart: [
        { icon: "mdi-format-text" },
        { icon: "mdi-crop-square" },
        { icon: "/" },
        { icon: "mdi-checkbox-blank-circle-outline" }
      ],
      downloadChart: [
        "Data (CSV)",
        "Image (JPEG)",
        "Image (PNG)",
        "Document (PDF)",
        "PowerPoint (PPTX)"
      ],
      closeOnContentClick: false,
      chartOptions: {},
      chartEdit: null,
      chartSwitch: null,
      text:
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
      states: [
        "Alabama",
        "Alaska",
        "American Samoa",
        "Arizona",
        "Arkansas",
        "California",
        "Colorado",
        "Connecticut",
        "Delaware"
      ],
      swatches: [
        ["#FF0000", "#AA0000", "#550000"],
        ["#FFFF00", "#AAAA00", "#555500"],
        ["#00FF00", "#00AA00", "#005500"],
        ["#00FFFF", "#00AAAA", "#005555"],
        ["#0000FF", "#0000AA", "#000055"]
      ],
      chartColor: "#26ade4",
      colorPicker: false,
      addSeries: ["one"],
      asDisable: false,
      multipleYAxis: "",
      barChart: "",
      reverseYAxis: "",
      reverseYAxis1: "",
      reverseYAxis2: "",
      reverseYAxis3: "",
      indicatorTitle: [
        {
          title: "Click Me",
          indDrop: [
            {
              dropOne: "i am here",
              lastChild: [
                {
                  title: "title here"
                }
              ]
            },
            { dropOne: "i am here" },
            { dropOne: "i am here" },
            { dropOne: "i am here" },
            { dropOne: "i am here" }
          ]
        },
        { title: "Click Me" },
        { title: "Click Me" },
        { title: "Click Me 2" }
      ],
      socialLink: "Copy This Text",
      clipboardText: "Copy Url",
      on: false
    };
  },
  mounted (){ 
  IMA.IMAChart.initiateChart(0,{"chart_actual_code":"{graph_narrow 116-0,116-1|116,116-01|2019-3-24,2019-5-05}","chart_config":{"chartType":"line","ViewOption":"chart","isMultiaxis":false,"isChartTypeSwitchable":"Y","chartLayout":"narrow","isNavigator":true,"chartExport":{"image_size_available":{"small":400,"medium":800,"large":1200},"types_available":{"jpeg":"image\/jpeg","png":"image\/png","pdf":"application\/pdf"}},"dataType":"monthly"},"isPremiumData":true,"charts_available":{"116":"BJP versus Congress: A Twitter Analysis"},"charts_codes_available":["116"],"chart_data_type":"monthly","charts_fields_available":{"116":{"Congress":{"Total number of Tweets":"116-0"},"BJP":{"Total number of Tweets":"116-1"}}},"current_chart_codes":["116-0","116-1"],"chart_labels_available":{"116-0":"Congress - Total number of Tweets","116-1":"BJP - Total number of Tweets"},"navigator_date_from":"1-3-2019","navigator_date_to":"1-5-2019","share_page_url":"http:\/\/laravel.indiamacroadvisors.com\/","sources":"Twitter API, IMA","chart_data":{"116-0":[["14-2-2019","44490"],["15-2-2019","29500"],["16-2-2019","30473"],["17-2-2019","21989"],["18-2-2019","25268"],["19-2-2019","23301"],["20-2-2019","17303"],["21-2-2019","20864"],["22-2-2019","53588"],["23-2-2019","49775"],["24-2-2019","26064"],["25-2-2019","17469"],["26-2-2019","31194"],["27-2-2019","34566"],["28-2-2019","44043"],["1-3-2019","43144"],["2-3-2019","40334"],["3-3-2019","36883"],["4-3-2019","30556"],["5-3-2019","33305"],["6-3-2019","32342"],["7-3-2019","46828"],["8-3-2019","38555"],["9-3-2019","31920"],["10-3-2019","31753"],["11-3-2019","32597"],["12-3-2019","57500"],["13-3-2019","77946"],["14-3-2019","56996"],["15-3-2019","42243"],["16-3-2019","35211"],["17-3-2019","43752"],["18-3-2019","41747"],["19-3-2019","62477"],["20-3-2019","49079"],["21-3-2019","28369"],["22-3-2019","24979"],["23-3-2019","39484"],["24-3-2019","33333"],["25-3-2019","49133"],["26-3-2019","58307"],["27-3-2019","51519"],["28-3-2019","32311"],["29-3-2019","35124"],["30-3-2019","34872"],["31-3-2019","42708"],["1-4-2019","39478"],["2-4-2019","36999"],["3-4-2019","35800"],["4-4-2019","43196"],["5-4-2019","36654"],["6-4-2019","31405"],["7-4-2019","29878"],["8-4-2019","28338"],["9-4-2019","25374"],["10-4-2019","31379"],["11-4-2019","31100"],["12-4-2019","23595"],["13-4-2019","37461"],["14-4-2019","24085"],["15-4-2019","21491"],["16-4-2019","22645"],["17-4-2019","24438"],["18-4-2019","16506"],["19-4-2019","24024"],["20-4-2019","20743"],["21-4-2019","19403"],["22-4-2019","22633"],["23-4-2019","30677"],["24-4-2019","22781"],["25-4-2019","21865"],["26-4-2019","19483"],["27-4-2019","27560"],["28-4-2019","22418"],["29-4-2019","24141"],["30-4-2019","24064"],["1-5-2019","18540"],["2-5-2019","18599"],["3-5-2019","20100"],["4-5-2019","26461"],["5-5-2019","20052"]],"116-1":[["14-2-2019","53862"],["15-2-2019","45346"],["16-2-2019","28269"],["17-2-2019","19885"],["18-2-2019","19564"],["19-2-2019","28998"],["20-2-2019","27860"],["21-2-2019","34112"],["22-2-2019","34306"],["23-2-2019","35764"],["24-2-2019","49276"],["25-2-2019","42428"],["26-2-2019","39133"],["27-2-2019","51050"],["28-2-2019","53999"],["1-3-2019","53010"],["2-3-2019","50234"],["3-3-2019","48623"],["4-3-2019","33104"],["5-3-2019","60321"],["6-3-2019","48204"],["7-3-2019","34343"],["8-3-2019","33426"],["9-3-2019","53988"],["10-3-2019","43702"],["11-3-2019","41630"],["12-3-2019","31528"],["13-3-2019","28425"],["14-3-2019","23618"],["15-3-2019","23996"],["16-3-2019","33644"],["17-3-2019","52591"],["18-3-2019","31833"],["19-3-2019","35682"],["20-3-2019","36679"],["21-3-2019","21819"],["22-3-2019","43721"],["23-3-2019","47940"],["24-3-2019","49707"],["25-3-2019","33936"],["26-3-2019","35643"],["27-3-2019","38380"],["28-3-2019","37359"],["29-3-2019","38792"],["30-3-2019","39843"],["31-3-2019","37246"],["1-4-2019","33939"],["2-4-2019","29736"],["3-4-2019","36078"],["4-4-2019","39159"],["5-4-2019","26862"],["6-4-2019","43158"],["7-4-2019","36839"],["8-4-2019","36018"],["9-4-2019","39189"],["10-4-2019","38657"],["11-4-2019","31893"],["12-4-2019","34591"],["13-4-2019","28293"],["14-4-2019","24594"],["15-4-2019","21850"],["16-4-2019","22194"],["17-4-2019","23346"],["18-4-2019","27096"],["19-4-2019","24245"],["20-4-2019","25399"],["21-4-2019","15186"],["22-4-2019","25712"],["23-4-2019","44334"],["24-4-2019","27999"],["25-4-2019","23257"],["26-4-2019","33678"],["27-4-2019","33481"],["28-4-2019","23781"],["29-4-2019","31114"],["30-4-2019","30160"],["1-5-2019","21043"],["2-5-2019","15150"],["3-5-2019","12132"],["4-5-2019","16702"],["5-5-2019","23688"]]}})
 setTimeout(function(){IMA.IMAChart.drawAllCharts();  }, -0);
this.veera=true;
  //this.chartOptions=IMA.IMAChart.Charts[0].chart_object;
  //window.console.log(IMA.IMAChart.Charts[0]);
  },
  methods: {
    changeColor() {
      alert(this.chartOptions);
      // return this.chartOptions.series[1][0].update({
      //   color: this.chartColor
      // });
      // return (this.chartOptions.series.color = this.chartColor);
    },
    alertHai() {
      alert("hai");
    },
    toggleModal() {
      this.$store.state.signInModal = !this.$store.state.signInModal;
    },
    addRow() {
      this.addSeries.push({
        one: "",
        two: ""
      });
      if (this.addSeries.length == 3) {
        return (this.asDisable = true);
      }
    },
    deleteRow(itemRemove) {
      this.addSeries.splice(itemRemove, 1);
      if (this.addSeries.length != 3) {
        return (this.asDisable = false);
      }
    },
    onCopy: function() {
      this.clipboardText = "Url Copied";
    },
    onError: function() {
      alert("Failed to copy texts");
    }
  },
  watch: {
    seriesColor() {
      alert(this.chartOptions);
      this.chartOptions.series[0].color = this.chartColor;
    }
  }
};
</script>
<style lang="scss">
@import "@/assets/_variables.scss";
@import "@/assets/_common.scss";
.chartContainer .v-content__wrap {
  display: flex;
}
.chartEditArea {
  width: 30%;
  .v-tabs-bar {
    height: 37px;
  }
  .ceaCheBox {
    .v-input__slot {
      flex-direction: row-reverse;
      margin-bottom: 0;
    }
    .v-label {
      width: 130px;
    }
    .ccbMulRev {
      display: flex;
      align-items: center;
      margin-top: 16px;
      .v-input--selection-controls {
        margin-top: 0;
      }
    }
    .v-messages {
      display: none;
    }
  }
  .ceaAddCon {
    margin-bottom: 15px;
    .v-text-field--outlined.v-input--dense.v-text-field--outlined
      > .v-input__control
      > .v-input__slot {
      min-height: 36px;
    }
    .v-select.v-text-field--outlined:not(.v-text-field--single-line).v-input--dense
      .v-select__selections {
      padding: 0;
    }
    .v-label {
      font-size: 14px;
      top: 9px;
    }
    .v-select__selection--comma {
      font-size: 14px;
    }
    .v-icon {
      font-size: 22px;
    }
  }
  .ceaRemEdi {
    .cre-rembtn {
      padding: 0;
      text-transform: capitalize;
    }
    .cre-admobt {
      font-size: 12px;
      text-transform: capitalize;
    }
    .mdi-chart-multiple {
      font-size: 15px;
      padding-right: 6px;
    }
  }
}
.vmColSwa {
  .v-list-item,
  .v-list {
    padding: 0;
  }
  .v-color-picker__controls {
    padding: 10px;
  }
  .v-color-picker__dot {
    height: 17px;
    width: 17px;
    margin-right: 10px;
  }
  .v-color-picker__edit {
    margin-top: 10px;
  }
  .v-color-picker__input input {
    height: 20px;
    font-size: 11px;
    margin-bottom: 0;
  }
  .v-color-picker__color {
    height: 18px;
    width: 18px;
  }
  .v-color-picker__swatches {
    overflow: hidden;
  }
}
.mainIndicator {
  position: relative;
  .dropdownList {
    position: absolute;
    top: 0;
    right: 100%;
    display: none;
  }
  &:hover > .dropdownList,
  .subDropList:hover > .dropdownList {
    display: block;
  }
}
.indDropdown {
  overflow-y: visible;
  overflow-x: visible;
  contain: unset;
  .v-list {
    padding: 0 0 5px;
    border: 1px solid $lGray-c;
  }
  .v-list-item {
    min-height: 28px;
    &:first-child {
      padding-top: 5px;
    }
  }
  .v-list-item__title {
    font-size: 14px;
  }
}
.caChaSwi.v-tabs {
  > .v-tabs-bar {
    background-color: $lGray-d;
    height: 37px;
  }
  .v-slide-group__content {
    justify-content: flex-end;
  }
  .v-tab {
    text-transform: capitalize;
  }
  .v-icon {
    font-size: 16px;
    padding-right: 5px;
  }
}
</style>
<style lang="scss" scoped>
@import "@/assets/_variables.scss";
.chartContainer {
  margin-top: 25px;
  .chartArea {
    width: 70%;
  }
}
.chartArea {
  .caHead {
    background-color: $lGray;
    text-align: right;
    border: 1px solid $lGray-d;
    border-width: 1px 0 0 1px;
    border-radius: 5px 0 0;
    position: relative;
    padding-right: 5px;
    > .v-btn--icon.v-size--default .v-icon {
      font-size: 17px;
    }
  }
}
.caVmenu,
.caVedit {
  .v-list {
    display: flex;
  }
  .v-list-item {
    min-height: 32px;
    padding: 0 12px;

    .v-icon {
      font-size: 17px;
    }
    .mdi-facebook {
      color: #3b5998;
    }

    .mdi-twitter {
      color: #00acee;
    }

    .mdi-google-plus {
      color: #dd4b39;
    }

    .mdi-linkedin {
      color: #0e76a8;
    }
  }
  .cavNotes {
    span {
      font-size: 10px;
      color: $color-red;
      padding-right: 8px;
    }
  }
}
.caVedit {
  .v-list {
    flex-wrap: wrap;
    width: 154px;
    padding-bottom: 3px;
  }
  .v-list-item {
    flex: none;
  }
}
.caVdown {
  .caSelect {
    width: 200px;
  }
  .caDbtns {
    text-align: right;
    button {
      margin-left: 10px;
    }
  }
}
.chartEditArea {
  .v-tab {
    text-transform: capitalize;
  }
  .v-tabs-bar {
    height: 37px;
  }
  .ceaRemEdi {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
}
.ceaAddSea {
  display: flex;
  margin-bottom: 15px;
  > .v-btn.v-size--default {
    height: 35px;
    border-radius: 0;
    padding: 0 9px;
    min-width: unset;
  }
}
</style>