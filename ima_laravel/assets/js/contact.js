var href = window.location.href.split('/');
require.config({
  baseUrl : (location.hostname == "localhost")?"http://localhost/"+href[3]+"/":'',
   shim: {
		'jqueryCookieBar': {
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
   },
  paths: {
	'jquery' : 'assets/js/jquery.min',
	'jqueryCookieBar' : 'assets/js/jquery.cookiebar',
	'jqueryValidate' : 'assets/js/jquery.validate',
	'bootstrap' : 'assets/js/bootstrap.min',
	'mobiledetect' : 'assets/plugins/MobileDetect/mobile-detect',
	'Jma' : 'assets/js/jma',
	'custom' : 'assets/js/custom'
  }
});


define(['module','require','jquery','jqueryCookieBar','jqueryValidate','bootstrap','Jma', 'mobiledetect',], function(module,require,$,jqueryCookie,jqueryValidate,bootstrap,JmaCla,MobileDetect){
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


 