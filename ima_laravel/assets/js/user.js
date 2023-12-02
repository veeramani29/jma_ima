var href = window.location.href.split('/');

require.config({
  baseUrl : (location.hostname == "localhost")?"http://localhost/jma/ima_laravel/":'',
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
        'mobileDetect' : {
        	deps: ['jquery']
        },
		'intlTelInputMin': {
            deps: ['jquery']
        },
        'slickMin': {
            deps: ['jquery']
        },
   },
  paths: {
	'jquery' : 'assets/js/jquery.min',
	'jqueryCookieBar' : 'assets/js/jquery.cookiebar',
    'jqueryValidate' : 'assets/js/jquery.validate',
	'bootstrap' : 'assets/js/bootstrap.min',
	'Jma' : 'assets/js/jma',
	'mobiledetect' : 'assets/plugins/MobileDetect/mobile-detect',
	'intlTelInputMin' : 'assets/js/intlTelInput.min',
	'slickMin': ['assets/plugins/slick/slick.min'],
	'custom' : 'assets/js/custom'
  }
});


define(['module','require','jquery','jqueryCookieBar','jqueryValidate','bootstrap','mobiledetect','Jma','intlTelInputMin','slickMin',], function(module,require,$,jqueryCookie,validate,bootstrap,MobileDetect,JmaCla,intlTelInput,slick){
	$.ajaxSetup({
        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	});
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
		// console.log('jquery console');
		


	
		 
		 // login process
		if(module.config().controller == "user" ||  module.config().action == "login")
		{
			$("#login_frm").validate({
			  submitHandler: function(form) {
				$('.payloder').show();
				$('html, body').animate({scrollTop : 0},800);
				form.submit();
			  }
			});
			$("#register_pre_frm").validate({
			  submitHandler: function(form) {
				$('.payloder').show();
				$('html, body').animate({scrollTop : 0},800);
				form.submit();
			  }
			});
		}			
		 
		 // country code  sign up page code
		if(module.config().controller == "user" &&  module.config().action == "signup")
		{
			
		    var iti= $('[name="country_code"]').intlTelInput({
			
				formatOnDisplay: true,
				allowDropdown: true,
				autoHideDialCode: false,
				autoPlaceholder: true,
				separateDialCode: true,
				initialCountry: "auto",
				nationalMode: true,
				numberType: "MOBILE",
				
				preferredCountries: ['in'],
				utilsScript: module.config().baseURLs+'assets/js/utils.js',
				geoIpLookup: function(callback) {
					
				  $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
					var countryCode = (resp && resp.country) ? resp.country : "";
					callback(countryCode);
					var sel_dial_code =$('ul.country-list li.country[data-country-code="'+(countryCode.toLowerCase())+'"]').data('dial-code');
				
						if($('#country_code').data('old')=='+91')
						 $('#country_code').val(sel_dial_code);
		
					 });
				},
				
				
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
		  
		      $('.signup_request_select').on('click',function(event){

				  var jqO = $(this);
				  var target = $(event.target);
				  $('.signup_request_select').removeClass( "activepro" );
				  jqO.addClass('activepro');
				  $('.signup_request_select').find('.signup_product').prop('checked',false);
				  $('.signup_request_select').find('span.fa-check').hide();
				  jqO.find('.signup_product').prop('checked',true);
				  var sub_type=jqO.find('.signup_product').prop('checked',true).val();
				  var theHref = $('a.reg_linkedin').attr("href");
				  //var last = theHref.substring(theHref.lastIndexOf("/") + 1, theHref.length);
				 	var last='free';
				 	if(sub_type=='free'){
				 		var last='premium';
				 	}
				  $('a.reg_linkedin').attr("href", (theHref.replace(last,sub_type)));
				    var theHref_fb = $('a.reg_fb').attr("href");
				  if(theHref_fb != undefined)
				   $('a.reg_fb').attr("href", (theHref_fb.replace(last,sub_type)));
				  jqO.find('span.fa-check').show();
				});
		
		
				$('.signup_product').on('click',function(event){
					$('.signup_product').parent('div').removeClass( "activepro" );
					$('.signup_product').prop('checked',false);
					$(this).parent('div').addClass('activepro');
					$(this).prop('checked',true);
			   });
			  if ($('#user_title_id').val() == "Other") {
				$("#other").show();
			  }else{$("#other").hide();}
			  $('#user_title_id').change(function(){
				if ($(this).val() == "Other") {
				  $("#other").show();
				}else if ($(this).val() != "Other") {
				  $("#other").hide();
				}
			  });
			  $("#check").removeClass('fa fa-check');
			  
			  
			  
			  $("#signup_frm").validate({
				// Specify the validation rules
				ignore: [],
				rules: {
				  fname: "required",
				  lname: "required",
				  email: {
					required: true,
					email: true
				  },
				   agree: "required",
				  country_id: "required",
				  agree: {
					required: function(){
					  if($("input[name=agreeButton]").val() != 'y'){
						return true;
					  }
					  else
					  {
						$("label[for=agreeButton]").hide();
						return false;
					  }
					}
				  }
				},
				// Specify the validation error messages
				messages: {
				  fname: "Please enter your first name",
				  lname: "Please enter your last name",
				  email: "Please enter a valid email address",
				  country_id: "Please select country",
				  agree: "Please accept our terms and conditions"
				},
				submitHandler: function(form) {
				 // $('.payloder').show();
				  //$('html, body').animate({scrollTop : 0},800);
				 if(ValidateCaptcha()){
				    	  form.submit();
				    }
				}
			  });

			   function ValidateCaptcha(){
   var $captcha = $( '#g-recaptcha' ),
  response = grecaptcha.getResponse();
 
  if (response.length === 0) {
    $( '.msg-error').text( "reCAPTCHA is mandatory" );
    $( '.msg-error').show();
   
    return false;
    } else {
    $( '.msg-error' ).text('');
   
    return true;
     }
  }
			  // Update the value of "agree" input when clicking the Agree/Disagree button
			  $('#agreeButton, #disagreeButton').on('click', function() {
				var whichButton = $(this).attr('id');
				$('#signup_frm')
				.find('[name="agree"]')
				.val(whichButton === 'agreeButton' ? 'yes' : '')
				.end();
				if($('#signup_frm').find('[name="agree"]').val() == 'yes'){
				  $("label[for=agree]").hide();
				  $("#check").addClass('fa fa-check');
				}else{
				  $("label[for=agree]").show();
				  $("#check").removeClass('fa fa-check');
				}
			 });
	        
		}
		
		if(module.config().controller == "user" &&  module.config().action == "myaccount")
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
				  preferredCountries:['in'],
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
			  
			//  module.config().countryCode=(module.config().countryCode=='')?'+91':module.config().countryCode;
			
				if( $('#isd_code').val() != '')
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
				
				
				 $('#dosubscripe_btt_submit').click(function(){
				if($('.signup_request_select.activepro').length >0){
					
					
				  if(location.hostname == "localhost")
				  {
					  var corp_url = location.protocol + '//' + location.hostname+ '/laravel/user/user_request_info/';
					  var pay_url = location.protocol + '//' + location.hostname+ '/laravel/user/user_type_upgrade/';
				  }
                  else
				  {
					  var corp_url = location.protocol + '//' + location.hostname+ '/user/user_request_info/';
					  var pay_url = location.protocol + '//' + location.hostname+ '/user/user_type_upgrade/';
				  }	
				  
				  if($('.signup_request_select.activepro').attr('id')=='premium'){
					$('#form_submit_subscription_request').attr('action',pay_url)
				  }else{
					$('#form_submit_subscription_request').attr('action',corp_url);
				  }
				  $('.payloder').show();
				  $('html, body').animate({scrollTop : 0},800);
				  $('#form_submit_subscription_request').submit();
				}
			  })
				
				$('.Alanee_tabset_tab.inactive').live("click",function(){
				var jqobj = $(this);
				var contentdiv = jqobj.attr('contentdiv');
				$('.Alanee_tabset_tab').removeClass('active').addClass('inactive');
				jqobj.removeClass('inactive').addClass('active');
				$('.Alanee_tabset_contentdiv').hide();
				$('.Alanee_tabset_contentarea').find(contentdiv).show();
			  });
			  
			  
			  $("#Table_user_profile_edit").validate({
			  submitHandler: function(form) {
				$('.payloder').show();
				$('html, body').animate({scrollTop : 0},800);
				form.submit();
			  }
			});
			$('.Alanee_tabset_tab ').on('click',function() {
			  $('#alertMsg').html('');
			  $('#Form_user_profile_changepassword')[0].reset();
			  $('#Form_user_profile_changepassword :input').removeClass('error');
			  $('#Form_user_profile_changepassword label').remove();
			});
			$("#Form_user_profile_changepassword").validate({
			  rules: {
				currentpassword:{
				  equalTo: "#old_password"
				}  ,
				confirm_newpassword:{
				  equalTo: "#newpassword"
				}
			  },
			  messages: {
				currentpassword :" Please enter current password",
				confirm_newpassword :" Enter confirm password same as new password"
			  },
			  submitHandler: function(form) {
				$.ajax({
				  type: 'POST',
				  url: $('#Form_user_profile_changepassword').attr('action'),
				  async: true,
				  dataType: 'json',
				  beforeSend: function() {
					//$('.payloder').show();
					$('html, body').animate({scrollTop : 0},800);
				  },
				  data: $('#Form_user_profile_changepassword').serializeArray(),
				  success: function(data) {
					//$('.payloder').hide();
					$('#Form_user_profile_changepassword')[0].reset();
					if(data.success!=null){
					  $('#alertMsg').addClass('text-success');
					  $('#alertMsg').html(data.success);
					}else{
					  $('#alertMsg').addClass('text-danger');
					  $('#alertMsg').html(data.success);
					}
				  }
				});
				return false;
			//form.submit();
			}
			});
			//$( "#Table_user_profile_edit" ).validate();
			function FirstName() {
			  var str = $("#reg_first_name").val();
			  if((/^[a-zA-Z0-9- ]*$/.test(str) == false) || ($.isNumeric(str))) {
				$(".First_name").show();
				$("#reg_first_name").addClass("errors");
				JMA.flags=false;
			  }if((/^[a-zA-Z0-9- ]*$/.test(str) == true)&& (!$.isNumeric(str))) {
				$(".First_name").hide();
				$("#reg_first_name").removeClass("errors");
				JMA.flags=true;
			  }
			}
			
			
			
			function LastName() {
			  var str = $("#reg_last_name").val();
			  if((/^[a-zA-Z0-9- ]*$/.test(str) == false) || ($.isNumeric(str))){
				$(".Last_name").show();
				$("#reg_last_name").addClass("errors");
				JMA.flag=false;
			  }if((/^[a-zA-Z0-9- ]*$/.test(str) == true)&& (!$.isNumeric(str))) {
				$(".Last_name").hide();
				$("#reg_last_name").removeClass("errors");
				JMA.flag=true;
			  }
			}
			$("#reg_first_name").keyup(function() {
			  FirstName();
			});
			$("#reg_last_name").keyup(function() {
			  LastName();
			});
			$('#Table_user_profile_edit').on('submit', function() {
			  FirstName();
			  LastName();
			  if (JMA.flag == true && JMA.flags == true) {
				return true;
			  } if (JMA.flags == false) {
				$( "#reg_first_name" ).focus();
				return false;
			  } else if (JMA.flag == false) {
				$( "#reg_last_name" ).focus();
				return false;
			  }
			}); 
		}
        if(module.config().controller == "user" &&  module.config().action == "myaccount")
		{  
				/*$('[name="isd_code"]').intlTelInput({
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
				preferredCountries: ['in'],
				separateDialCode: true,
				utilsScript: module.config().baseURLs+'assets/js/utils.js',
			  });*/
			  
			  
        }
		
		if(module.config().controller == "user" &&  module.config().action == "registercompetition")
		{
			
			$("#competition_frm_login").validate({
				  ignore: [],
				  rules: {
				  user_group: "required",
				  groupname: "required",
				  Collegename: "required"
				  
				},
				// Specify the validation error messages
				messages: {
				user_group: "Please select your group",
				groupname: "Please enter your group name",
				Collegename: "Please enter your colloege name"			
				},
				submitHandler: function(form) {
				  $('.payloder').show();
				  $('html, body').animate({scrollTop : 0},800);
				  form.submit();
				}
				
			  });
			 $("#competition_frm").validate({
				  ignore: [],
				  rules: {
				  user_group: "required",
				  groupname: "required",
				  Collegename: "required",
				  fname: "required",
				  lname: "required",
				  email: {
					required: true,
					email: true
				  },
				  agree: {
					required: function(){
					  if($("input[name=agree]").val() != 'yes'){
						return true;
					  }
					  else
					  {
						$("label[for=agree]").hide();
						return false;
					  }
					}
				  }
				},
				// Specify the validation error messages
				messages: {
				user_group: "Please select your group",
				groupname: "Please enter your group name",
				Collegename: "Please enter your colloege name",
				fname: "Please enter your first name",
				lname: "Please enter your last name",
				email: "Please enter a valid email address",
				agree: "Please accept our terms and conditions"
				},
				submitHandler: function(form) {
				  $('.payloder').show();
				  $('html, body').animate({scrollTop : 0},800);
				  form.submit();
				}
				
			  });
			  
			   $('#agreeButton, #disagreeButton').on('click', function() {
				var whichButton = $(this).attr('id');
				$('#competition_frm')
				.find('[name="agree"]')
				.val(whichButton === 'agreeButton' ? 'yes' : '')
				.end();
				if($('#competition_frm').find('[name="agree"]').val() == 'yes'){
				  $("label[for=agree]").hide();
				  $("#check").addClass('fa fa-check');
				}else{
				  $("label[for=agree]").show();
				  $("#check").removeClass('fa fa-check');
				}
				
			 });
			 
			 
			 
			 
		}

	 require(['custom'], function(custom){
     });
	 return  JMA;
});


 