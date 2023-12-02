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
	'mobiledetect' : 'assets/plugins/MobileDetect/mobile-detect',
	'Jma' : 'assets/js/jma',
	'slickMin': ['assets/plugins/slick/slick.min'],
	'readmore': ['assets/plugins/readmore/readmore'],
	'custom' : 'assets/js/custom'
  }
});


define(['module','require','jquery','jqueryCookieBar','jqueryValidate','bootstrap', 'mobiledetect' ,'Jma','slickMin','readmore',], function(module,require,$,jqueryCookie,jqueryValidate,bootstrap,MobileDetect,JmaCla,slick,readmore){
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
	    $('.ot_readmore').readmore({
			speed: 500,
			collapsedHeight: 65
		});
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
		// console.log('jquery console');
	 require(['custom'], function(custom){
     });
	 return  JMA;
});


 