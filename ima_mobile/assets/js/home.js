require.config({
  baseUrl : (location.hostname == "localhost")?"http://localhost/jma/ima_mobile/":'',
   shim: {
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
        'slickMin': {
            deps: ['jquery']
        }
   },
  paths: {
	 'Highcharts' : 'assets/js/mapStock', 
	'jquery' : 'assets/js/jquery.min',
	'jqueryCookieBar' : 'assets/js/jquery.cookiebar',
	'jqueryValidate' : 'assets/js/jquery.validate',
	'bootstrap' : 'assets/js/bootstrap.min',
	'jqueryEasing' : 'assets/js/jquery.easing-1.3.pack',
	'Jma' : 'assets/js/jma',
  // remove slick
	'slickMin': ['assets/plugins/slick/slick.min'],
	'custom' : 'assets/js/custom'
  }
});


define(['module','require','Highcharts','jquery','jqueryCookieBar','jqueryValidate','bootstrap','jqueryEasing','Jma','slickMin'], function(module,require,Highcharts,$,jqueryCookie,jqueryValidate,bootstrap,jqueryEasing,JmaCla,slick){
	$.ajaxSetup({
        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	});
	var Jma = require('Jma');
	 JMA = new Jma(module.config().baseURLs,module.config().controller,module.config().action,module.config().parameter,module.config().hosts,module.config().mychartObj);
	 JMA.userDetails = module.config().sessionUser;
	 console.log(JMA);
	 require(['custom'], function(custom){
     });
	 return  JMA;
});


 