/* eslint-disable */
global.IMAChart =require("./IMAChart");
global.chartCommon =require("./chartCommon");
global.LineChart =require("./LineChart");
function Ima(appURL,appController,appAction,appParams,reqProtocol,objectParams) {

this.baseURL = appURL;
this.requestProtocol = reqProtocol;
this.controller = appController;
this.action = appAction;
this.params = appParams;
this.application_url = '';
this.IMAChart = {};
//this.myChart = {};
this.userDetails = {};
var self = this;
this.flag = true;
this.flags = true;
this.linkedInDownload = {};
this.Export_url = (window.location.protocol == 'http:') ? window.location.protocol + '//export.japanmacroadvisors.com' : window.location.protocol + '//export.japanmacroadvisors.com';
this.__construct = function(appURL, appController, appAction, appParams, objectParams) {
   
    //this.myChart_folders = objectParams.myChart.folderList;
    //this.initializeAllPlugIns();
    this.baseURL = appURL;
    this.controller = appController;
    this.action = appAction;
    this.params = appParams;
    this.SmalltoLarge = null;
    this.IMAChart = new IMAChart();
    this.userDetails = new Array();
   
};

(function(appURL,appController,appAction,appParams,objectParams){
	self.__construct(appURL, appController, appAction, appParams, objectParams);
})(appURL,appController,appAction,appParams,objectParams);
} 
//Ima End

	
	





/*var test = {
  foo () { console.log('foo') },
  bar () { console.log('bar') },
  baz () { console.log('baz') }
}
class veera{
	construct(){

	}
}*/
module.exports=Ima;
//export default test
//module.exports=Ima;
