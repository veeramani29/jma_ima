var href = window.location.href.split('/');
require.config({
	
  baseUrl : (location.hostname == "localhost")?"http://localhost/jma/ima_laravel":'',
   shim: {
		'spectrum': {
            deps: ['jquery']
        },
		'jqueryCookieBar': {
            deps: ['jquery']
        },
		'jqueryEasing': {
            deps: ['jquery']
        },
		'jqueryValidate': {
            deps: ['jquery']
        },
		'bootstrap': {
            deps: ['jquery']
        },
        'mobileDetect' : {
        	deps: ['jquery']
        },
		'Jma': {
            deps: ['jquery']
        },
		'clipboard': {
            deps: ['jquery']
        },
		'datepicker': {
			deps: ['jquery']
		},
   },
  paths: {
	'Highcharts' : 'assets/js/chartsNew',  
	'jquery' : 'assets/js/jquery.min',
	'spectrum' : 'assets/plugins/spectrum/spectrum',
	'jqueryCookieBar' : 'assets/js/jquery.cookiebar',
    'jqueryValidate' : 'assets/js/jquery.validate',
	'bootstrap' : 'assets/js/bootstrap.min',
	'jqueryEasing' : 'assets/js/jquery.easing-1.3.pack',
	'mobiledetect' : 'assets/plugins/MobileDetect/mobile-detect',
	'Jma' : 'assets/js/jma',
	'clipboard': ['assets/js/clipboard.min'],
	'datepicker' : 'assets/plugins/jquery-ui/jquery-ui.min',
	'custom' : 'assets/js/custom',
	'electionmap' : 'assets/electionmap',
		'coronamap' : 'assets/js/coronamap'
  }
});


define(['module','require','Highcharts','jquery','spectrum','jqueryCookieBar','jqueryValidate','bootstrap','jqueryEasing', 'mobiledetect','Jma','clipboard',/*'datepicker'*/], function(module,require,Highcharts,$,spectrum,jqueryCookie,jqueryValidate,bootstrap,jqueryEasing,MobileDetect,JmaCla,Clipboard,/*datepicker*/){
	$.ajaxSetup({
        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	});
	var Jma = require('Jma');
	 JMA = new Jma(module.config().baseURLs,module.config().controller,module.config().action,module.config().parameter,module.config().hosts,module.config().mychartObj);
	 JMA.userDetails = module.config().sessionUser;
	// console.log(JMA);
	 $('.clipboard_copy').tooltip({
  trigger: 'click',
  placement: 'bottom'
});
    

	 // this code will come all indicator page 
	var clipboard = new Clipboard('.clipboard_copy');
	clipboard.on('success', function(e) {
	  setTooltip('Copied!');
	  hideTooltip();
	});
	clipboard.on('error', function(e) {
	  setTooltip('Failed!');
	  hideTooltip();
	});

	 if(module.config().parameter.match(/yield-curve/g)){
require(['datepicker'], function(datepicker){
     });
}
	 
	 if(module.config().parameter=='reports/modi-20-structural-reforms-can-wait'){
require(['custom','electionmap'], function(custom,electionmap){
     });
}else{
require(['custom','coronamap'], function(custom,coronamap){
     });
}
	 return  JMA;
});


 