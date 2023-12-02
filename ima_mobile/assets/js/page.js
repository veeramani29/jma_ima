require.config({
  baseUrl : (location.hostname == "localhost")?"http://localhost/jma/ima_mobile/":'',
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
		'Jma': {
            deps: ['jquery']
        },
		'clipboard': {
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
	'Jma' : 'assets/js/jma',
	'clipboard': ['assets/js/clipboard.min'],
	'custom' : 'assets/js/custom'
  }
});


define(['module','require','Highcharts','jquery','spectrum','jqueryCookieBar','jqueryValidate','bootstrap','jqueryEasing','Jma','clipboard',], function(module,require,Highcharts,$,spectrum,jqueryCookie,jqueryValidate,bootstrap,jqueryEasing,JmaCla,Clipboard){
	$.ajaxSetup({
        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	});
	var Jma = require('Jma');
	 JMA = new Jma(module.config().baseURLs,module.config().controller,module.config().action,module.config().parameter,module.config().hosts,module.config().mychartObj);
	 JMA.userDetails = module.config().sessionUser;
	 console.log(JMA);
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
	 
	 require(['custom'], function(custom){
     });
	 return  JMA;
});


 