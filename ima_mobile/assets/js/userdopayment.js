var href = window.location.href.split('/');
require.config({
  baseUrl : (location.hostname == "localhost")?"http://localhost/jma/"+href[4]+"/":'',
   shim: {
		'jqueryCookieBar': {
            deps: ['jquery']
        },
		'jqueryValidate': {
            deps: ['jquery']
        },
		'jqueryPayments': {
            deps: ['jquery']
        },
		'creditCardValidator': {
            deps: ['jquery']
        },
		'bootstrap': {
            deps: ['jquery']
        },
		'Jma': {
            deps: ['jquery']
        },
		'intlTelInputMin': {
            deps: ['jquery']
        },
   },
  paths: {
	'jquery' : 'assets/js/jquery.min',
	'jqueryCookieBar' : 'assets/js/jquery.cookiebar',
    'jqueryValidate' : 'assets/js/jquery.validate',
	//'stripe' : 'assets/js/stripe',
	//'jqueryPayments' : 'assets/plugins/payment/jquery.payment',
	//'creditCardValidator' : 'assets/plugins/cc-validator/creditCardValidator',
	'bootstrap' : 'assets/js/bootstrap.min',
	'Jma' : 'assets/js/jma',
	'intlTelInputMin' : 'assets/js/intlTelInput.min',
	'custom' : 'assets/js/custom'
  }
});

//'stripe','jqueryPayments','creditCardValidator',
//stripe,payment,creditCardValidator,
define(['module','require','jquery','jqueryCookieBar','jqueryValidate','bootstrap','Jma','intlTelInputMin',], function(module,require,$,jqueryCookie,validate,bootstrap,JmaCla,intlTelInput){
	var Jma = require('Jma');
	 JMA = new Jma(module.config().baseURLs,module.config().controller,module.config().action,module.config().parameter,module.config().hosts,module.config().mychartObj);

	 JMA.userDetails = module.config().sessionUser;
	 console.log(JMA);
	 console.log(module.config().StripKeys)



	 $(document).keydown(function (event) {
if (event.keyCode == 123) { // Prevent F12
return false;
} else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
return false;
}else if (event.ctrlKey &&  event.keyCode === 85) { // Prevent Ctrl+Shift+I        
return false;
}
});
$(document).on("contextmenu", function (e) {        
e.preventDefault();
});


$(function() {
  $('.panel-collapse').on('show.bs.collapse', function () {

    $(this).siblings('.panel-heading').find('a.accordion-toggle').addClass('collapsed');
  });

  $('.panel-collapse').on('hide.bs.collapse', function () {
     $(this).siblings('.panel-heading').find('a.accordion-toggle').removeClass('collapsed');
  
  });

  $('#cc-option').on('show.bs.collapse', function () {
  $('#paypal').collapse('hide')
});

   $('#cc-option').on('hidden.bs.collapse', function () {
  $('#paypal').collapse('show')
});

   $('#paypal').on('show.bs.collapse', function () {
  $('#cc-option').collapse('hide')
});


   $('#paypal').on('hidden.bs.collapse', function () {
  $('#cc-option').collapse('show')
});
   });
	
		 
	    //Stripe.setPublishableKey(module.config().StripKeys);	
	 
	   // $('#card_number').payment('formatCardNumber');
	 function submit_(form) {
		rzp1.open();
		return false;
		e.preventDefault();
		}
		$("#payment-form_").validate({
		submitHandler: submit_
		});
		$('[name="isd_code"]').intlTelInput({
		allowDropdown: true,
		autoHideDialCode: true,
		autoPlaceholder: true,
		//dropdownContainer: "body",
		geoIpLookup: function(callback) {
		$.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
		var countryCode = (resp && resp.country) ? resp.country : "";
		callback(countryCode);
		});
		},
		initialCountry: "auto",
		nationalMode: true,
		numberType: "MOBILE",
		preferredCountries: ['jp', 'us', 'in'],
		separateDialCode: true,
		utilsScript: 'assets/js/utils.js',
		});
		
		 $(document).ready(function() {
			  function addInputNames() {
				// Not ideal, but jQuery's validate plugin requires fields to have names
				// so we add them at the last possible minute, in case any javascript
				// exceptions have caused other parts of the script to fail.
				$(".card-number").attr("name", "card-number")
				$(".card-cvc").attr("name", "card-cvc")
				$(".card-expiry-year").attr("name", "card-expiry-year")
			  }
			  function removeInputNames() {
				$(".card-number").removeAttr("name")
				$(".card-cvc").removeAttr("name")
				$(".card-expiry-year").removeAttr("name")
			  }
			  function submit(form) {
				var cardType = $.payment.cardType($('#card_number').val());
				// remove the input field names for security
				// we do this *before* anything else which might throw an exception
				removeInputNames(); // THIS IS IMPORTANT!
				// given a valid form, submit the payment details to stripe
				$(form['submit-button']).attr("disabled", "disabled")
				Stripe.createToken({
				  name: $('.card-name').val(),
				  number: $('.card-number').val(),
				  cvc: $('.card-cvc').val(),
				  exp_month: $('.card-expiry-month').val(),
				  exp_year: $('.card-expiry-year').val(),
				  address_line1: $('.card-address').val(),
				  address_zip: $('.card-zipCode').val(),
				  address_country: $('.card-country').val(),
				  address_state: $('.card-state').val(),
				  address_city: $('.card-city').val()
				},
				function(status, response) {
				  if (response.error) {
					// re-enable the submit button
					$(form['submit-button']).removeAttr("disabled")
					switch (response.error.type) {
					  case 'card_error':
					  // A declined card error
					  response.error.message = 'your card is declined'; // => e.g. "Your card's expiration year is invalid."
					  break;
					  case 'invalid_request_error':
					  // Invalid parameters were supplied to Stripe's API
					  response.error.message = 'Sorry! Something went wrong. Please try again later.';
					  break;
					  case 'api_error':
					  // An error occurred internally with Stripe's API
					  response.error.message = 'Sorry! Something went wrong. Please try again later.';
					  break;
					  case 'api_connection_error':
					  // Some kind of error occurred during the HTTPS communication
					  response.error.message = 'Sorry! Something went wrong. Please try again later.';
					  break;
					  case 'authentication_error':
					  // You probably used an incorrect API key
					  response.error.message = 'Sorry! Something went wrong. Please try again later.';
					  break;
					  case 'rate_limit_error':
					  // You probably used an incorrect API key
					  response.error.message = 'Sorry! Something went wrong. Please try again later.';
					  break;
					}
					// show the error
					$(".dopayment_errorcon").html(response.error.message);
					// we add these names back in so we can revalidate properly
					addInputNames();
				  } else {
					// token contains id, last4, and card type
					var token = response['id'];
					// insert the stripe token
					var input = $("<input name='stripeToken' value='" + token + "' style='display:none;' />");
					form.appendChild(input[0])
					// and submit
					form.submit();
				  }
				});
			return false;
			}
			// add custom rules for credit card validating
			//jQuery.validator.addMethod("cardNumber", Stripe.validateCardNumber, "Please enter a valid card number");
		//	jQuery.validator.addMethod("cardCVC", Stripe.validateCVC, "Please enter a valid security code");
			jQuery.validator.addMethod("cardExpiry", function() {
			  return Stripe.validateExpiry($(".card-expiry-month").val(),
			   $(".card-expiry-year").val())
			}, "Please enter a valid expiration");
			// We use the jQuery validate plugin to validate required params on submit
			$("#payment-form").validate({
			submitHandler: submit,
			rules: {
			  "card-cvc" : {
				cardCVC: true,
				required: true
			  },
			  "card-number" : {
				cardNumber: true,
				required: true
			  },
			  "card-expiry-month" : {
				required: true
			  },
				"card-expiry-year" : "cardExpiry" // we don't validate month separately
			  },
			});
			// adding the input field names is the last step, in case an earlier step errors
			  addInputNames();
			});
			
			/*$('#card_number').validateCreditCard(function(result) {
				if(result.card_type == null)
				{
				  // $('#card_number').removeClass();
				}
				else
				{
				  $('#card_number').addClass(result.card_type.name);
				}

				if(!result.valid)
				{
				  $('#card_number').removeClass("valid");
				}
				else
				{
				  $('#card_number').addClass("valid");
				}

			});*/
			
		if(module.config().controller == "user" ||  module.config().action == "login")
		{
		     $('[name="country_code"]').intlTelInput({
				allowDropdown: true,
				autoHideDialCode: true,
				autoPlaceholder: true,
				geoIpLookup: function(callback) {
				  $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
					var countryCode = (resp && resp.country) ? resp.country : "";
					callback(countryCode);
				  });
				},
				initialCountry: "auto",
				nationalMode: true,
				numberType: "MOBILE",
				preferredCountries: ['jp', 'us', 'in'],
				separateDialCode: true,
				utilsScript: module.config().baseURLs+'assets/js/utils.js',
			  });
			  $('ul.country-list li.country').on('click', function() {
				var option1 = $(this).data('dial-code');
				$('#country_code').val("+"+option1);
			  });
			  $('#country_id').on('change', function() {
					var option = $('option:selected', this).attr('code').toLowerCase();
					var country_code = $('ul.country-list li.country.active').data('country-code');
					var country_name = $('ul.country-list li.country.active span.country-name').text();
					var dial_code = $('ul.country-list li.country.active').data('dial-code');
					$('div.selected-flag div.iti-flag').removeClass(country_code).addClass(option);
					$('ul.country-list li.country').removeClass('highlight');
					$('ul.country-list li.country').removeClass('active');
					$('ul.country-list li.country[data-country-code="'+option+'"]').addClass('highlight active');
					var sel_country_name =$('ul.country-list li.country[data-country-code="'+option+'"] span.country-name').text();
					var sel_dial_code =$('ul.country-list li.country[data-country-code="'+option+'"]').data('dial-code');
					$('div.selected-flag div.selected-dial-code').text("+"+sel_dial_code);
					$('div.selected-flag').attr("title",(sel_country_name+': '+"+"+sel_dial_code));
					$('#country_code').val("+"+sel_dial_code);
			  });
		  
		}
		
		if(module.config().controller == "user" ||  module.config().action == "myaccount")
		{
			   $('[name="phone"]').intlTelInput({
				allowDropdown: true,
				autoHideDialCode: true,
				autoPlaceholder: true,
				  //dropdownContainer: "body",
				  geoIpLookup: function(callback) {
					$.get("//ipinfo.io", function() {}, "jsonp").always(function(resp) {
					  var countryCode = (resp && resp.country) ? resp.country : "";
					  callback(countryCode);
					});
				  },
				  initialCountry: "auto",
				  nationalMode: true,
				  numberType: "MOBILE",
				  preferredCountries: ['jp', 'us', 'in'],
				  separateDialCode: true,
				  utilsScript: module.config().baseURLs+'assets/js/utils.js',
				});
			  $('ul.country-list li.country').on('click', function() {
				var option1 = $(this).data('dial-code');
				$('#isd_code').val("+"+option1);
			  });
			  $('#country_id').on('change', function() {
				var option = $('option:selected', this).attr('code').toLowerCase();
				var country_code = $('ul.country-list li.country.active').data('country-code');
				var country_name = $('ul.country-list li.country.active span.country-name').text();
				var dial_code = $('ul.country-list li.country.active').data('dial-code');
				$('div.selected-flag div.iti-flag').removeClass(country_code).addClass(option);
				$('ul.country-list li.country').removeClass('active');
				$('ul.country-list li.country[data-country-code="'+option+'"]').addClass('active');
				var sel_country_name =$('ul.country-list li.country[data-country-code="'+option+'"] span.country-name').text();
				var sel_dial_code =$('ul.country-list li.country[data-country-code="'+option+'"]').data('dial-code');
				$('div.selected-flag').attr("title",(sel_country_name+': '+"+"+sel_dial_code));
				$('#isd_code').val("+"+sel_dial_code);
			  });
			  
			  
				if( module.config().countryCode != '')
				{
					var isdCode = $('#isd_code').val();
					var edit_option = isdCode.replace(new RegExp("\\+","g"),' ');
					$('ul.country-list li.country').removeClass('active');
					var oldclass=$('div.selected-flag div.iti-flag').attr('class');
					$( "ul.country-list li.country" ).each(function( index ) {
						if($( this ).data('dial-code')==edit_option){
							$( this ).addClass('active');
							$('div.selected-flag div.iti-flag').removeClass(oldclass.substr(-2)).addClass($( this ).data('country-code'));
						}
					});
				}
				
				
				
		}
        if(module.config().controller == "user" ||  module.config().action == "myaccount")
		{
				$('[name="isd_code"]').intlTelInput({
				allowDropdown: true,
				autoHideDialCode: true,
				autoPlaceholder: true,
				//dropdownContainer: "body",
				geoIpLookup: function(callback) {
				  $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
					var countryCode = (resp && resp.country) ? resp.country : "";
					callback(countryCode);
				  });
				},
				initialCountry: "auto",
				nationalMode: true,
				numberType: "MOBILE",
				preferredCountries: ['jp', 'us', 'in'],
				separateDialCode: true,
				utilsScript: module.config().baseURLs+'assets/js/utils.js',
			  });
			  
			  
        }
	
	 require(['custom'], function(custom){
     });
	 return  JMA;
});


 