var href = window.location.href.split('/');
require.config({
  baseUrl : (location.hostname == "localhost")?"http://localhost/jma/ima_laravel":'',
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
	// 'Highcharts' : 'assets/js/chartsNew', 
	'jquery' : 'assets/js/jquery.min',
	'jqueryCookieBar' : 'assets/js/jquery.cookiebar',
	'jqueryValidate' : 'assets/js/jquery.validate',
	'bootstrap' : 'assets/js/bootstrap.min',
	'jqueryEasing' : 'assets/js/jquery.easing-1.3.pack',
	'mobiledetect' : 'assets/plugins/MobileDetect/mobile-detect',
	'Jma' : 'assets/js/jma',
	'slickMin': ['assets/plugins/slick/slick.min'],
	'custom' : 'assets/js/custom',
	//'electionmap' : 'assets/electionmap'
  }
});


define(['module','require','Highcharts','jquery','jqueryCookieBar','jqueryValidate','bootstrap','jqueryEasing', 'mobiledetect', 'Jma','slickMin'], function(module,require,Highcharts,$,jqueryCookie,jqueryValidate,bootstrap,jqueryEasing,MobileDetect,JmaCla,slick){
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
		$('.slick_media_').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 6000
		});
	  require(['custom'], function(custom){
     });
	 return  JMA;
});


 