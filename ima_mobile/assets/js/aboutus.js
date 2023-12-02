require.config({
  baseUrl : (location.hostname == "localhost")?"http://localhost/ima_mobile/":'',
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
		'slickMin': {
            deps: ['jquery']
        },	
		'readmore': {
            deps: ['jquery']
        },
   },
  paths: {
	'jquery' : 'assets/js/jquery.min',
	'jqueryCookieBar' : 'assets/js/jquery.cookiebar',
	'jqueryValidate' : 'assets/js/jquery.validate',
	'bootstrap' : 'assets/js/bootstrap.min',
	'Jma' : 'assets/js/jma',
  // remove slick
	'slickMin': ['assets/plugins/slick/slick.min'],
	'readmore': ['assets/plugins/readmore/readmore'],
	'custom' : 'assets/js/custom'
  }
});


define(['module','require','jquery','jqueryCookieBar','jqueryValidate','bootstrap','Jma','slickMin','readmore',], function(module,require,$,jqueryCookie,jqueryValidate,bootstrap,JmaCla,slick,readmore){
	$.ajaxSetup({
        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	});
	var Jma = require('Jma');
	 JMA = new Jma(module.config().baseURLs,module.config().controller,module.config().action,module.config().parameter,module.config().hosts,module.config().mychartObj);
	 JMA.userDetails = module.config().sessionUser;
	 console.log(JMA);
	 // read more text
   if (window.matchMedia("(max-width: 991px)").matches) {
	    $('.ot_readmore').readmore({
			speed: 500,
			collapsedHeight: 76
		});
    }
	 
		// console.log('jquery console');
	 require(['custom'], function(custom){
     });
	 return  JMA;
});


 