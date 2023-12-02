require.config({
  baseUrl : (location.hostname == "localhost")?"http://localhost/ima_mobile/":'',
   shim: {
	   'spectrum': {
            deps: ['jquery']
        },
		'jqueryCookieBar': {
            deps: ['jquery']
        },
		'jqueryValidate': {
            deps: ['jquery']
        },
		'Jma': {
            deps: ['jquery']
        },
		'ckeditor': {
            deps: ['jquery']
        },
		'jaueryAlrt': {
            deps: ['jquery']
        },
		
   },
  paths: {
	'Highcharts' : 'assets/js/mapStock',
	'jquery' : 'assets/js/jquery.min',
	'spectrum' : 'assets/plugins/spectrum/spectrum',
	'jqueryCookieBar' : 'assets/js/jquery.cookiebar',
    'jqueryValidate' : 'assets/js/jquery.validate',
	'bootstrap' : 'assets/js/bootstrap.min',
	'Jma' : 'assets/js/jma',
	'jaueryAlrt' : 'assets/js/jquery.alerts',
	'ckeditor': ['assets/js/ckeditor/ckeditor'],
	'custom' : 'assets/js/custom'
  }
});


define(['module','require','Highcharts','jquery','spectrum','jqueryCookieBar','jqueryValidate','bootstrap','Jma','jaueryAlrt','ckeditor'], function(module,require,Highcharts,$,spectrum,jqueryCookie,jqueryValidate,bootstrap,JmaCla,jaueryAlrts,ckeditor){
	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
	var Jma = require('Jma');
	 JMA = new Jma(module.config().baseURLs,module.config().controller,module.config().action,module.config().parameter,module.config().hosts,module.config().mychartObj);
	 JMA.userDetails = module.config().sessionUser;
	 console.log(JMA);
	 
	 require(['custom'], function(custom){
     });
	 return  JMA;
});


 