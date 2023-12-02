var href = window.location.href.split('/');
require.config({
  baseUrl : (location.hostname == "localhost")?"http://localhost/ima-ind/":'',
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
        'slickMin': {
            deps: ['jquery']
        },
		'jaueryAlrt': {
            deps: ['jquery']
        },'ckeditor': {
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
	'jqueryEasing' : 'assets/js/jquery.easing-1.3.pack',
	'mobiledetect' : 'assets/plugins/MobileDetect/mobile-detect',
	'Jma' : 'assets/js/jma',
	'slickMin': ['assets/plugins/slick/slick.min'],
	'jaueryAlrt' : 'assets/js/jquery.alerts',
	'ckeditor': ['assets/js/ckeditor/ckeditor'],
	'custom' : 'assets/js/custom'
  }
});


define(['module','require','Highcharts','jquery','spectrum','jqueryCookieBar','jqueryValidate','bootstrap','jqueryEasing','mobiledetect','Jma','slickMin','jaueryAlrt','ckeditor'], function(module,require,Highcharts,$,spectrum,jqueryCookie,jqueryValidate,bootstrap,jqueryEasing,MobileDetect,JmaCla,slick,jaueryAlrts,ckeditor){
	$.ajaxSetup({
        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	});
	var Jma = require('Jma');
	 JMA = new Jma(module.config().baseURLs,module.config().controller,module.config().action,module.config().parameter,module.config().hosts,module.config().mychartObj);
	 JMA.userDetails = module.config().sessionUser;
	 console.log(JMA);
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
	 require(['custom'], function(custom){
     });
	 return  JMA;
});


 