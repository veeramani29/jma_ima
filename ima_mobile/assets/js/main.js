
 /* require.config({
  baseUrl : 'http://localhost/laravel/'	,
   shim: {
		'jqueryCookieBar': {
            deps: ['jquery']
        },
		'Jma': {
            deps: ['jquery']
        },
        'slickMin': {
            deps: ['jquery']
        },
		'jaueryAlrt': {
            deps: ['jquery']
        },
   },
  paths: {
	'jquery' : 'assets/js/jquery.min',
	'jqueryCookieBar' : 'assets/js/jquery.cookiebar',
    'jqueryValidate' : 'assets/js/jquery.validate',
	'bootstrap' : 'assets/js/bootstrap.min',
	'jqueryEasing' : 'assets/js/jquery.easing-1.3.pack',
	'Sortable' : 'assets/js/Sortable.min',
	'Jma' : 'assets/js/jma',
    'clipboard': ['assets/js/clipboard.min'],
	'slickMin': ['assets/plugins/slick/slick.min'],
	'jaueryAlrt' : 'assets/js/jquery.alerts',
	'custom' : 'assets/js/custom'
  }
});


define(['module','require','jquery','jqueryCookieBar','jqueryValidate','bootstrap','jqueryEasing','Sortable','Jma','clipboard','slickMin','jaueryAlrt'], function(module,require,$,jqueryCookie,jqueryValidate,bootstrap,jqueryEasing,Sortable,JmaCla,Clipboard,slick,jaueryAlrts){
	var Jma = require('Jma');
	 JMA = new Jma(module.config().baseURLs,module.config().controller,module.config().action,module.config().parameter,module.config().hosts,module.config().mychartObj);
	 JMA.userDetails = module.config().sessionUser;
	 console.log(JMA);
	
    // left menu shares
	
	// vertical slide press release
		$('.preres_list').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 3000,
			vertical:true
		});
		// media slide press release
		$('.slick_media').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 3000
		});
		 console.log('jquery console');
	 
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
}); */

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
       
   }, 
  paths: {
	'jquery' : 'assets/js/jquery.min',
	'jqueryCookieBar' : 'assets/js/jquery.cookiebar',
    'jqueryValidate' : 'assets/js/jquery.validate',
	'bootstrap' : 'assets/js/bootstrap.min',
	'Jma' : 'assets/js/jma',
	'custom' : 'assets/js/custom'
  }
});


define(['module','require','jquery','jqueryCookieBar','jqueryValidate','bootstrap','Jma',], function(module,require,$,jqueryCookie,jqueryValidate,bootstrap,JmaCla){
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


 