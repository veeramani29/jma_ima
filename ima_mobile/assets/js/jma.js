/**
*@fileOverview jma.js - JMA main script file
*@author Shijo Thomas
*
*/

/**
* Class Jma
**/
define(function () {


function Jma(appURL,appController,appAction,appParams,reqProtocol,objectParams) {
	
	
	this.baseURL = appURL;
	this.requestProtocol = reqProtocol;
	this.controller = appController;
	this.action = appAction;
	this.params = appParams;
	this.application_url = '';
	this.JMAChart = {};	
	this.myChart = {};
	this.userDetails = {};
	var self = this;
	this.flag=true;
	this.flags=true;
	this.linkedInDownload = {};
	
	this.Export_url=(window.location.protocol=='http:')?window.location.protocol+'//export.japanmacroadvisors.com':window.location.protocol+'//export.japanmacroadvisors.com';
	this.__construct = function(appURL,appController,appAction,appParams,objectParams){
		$(window).load(function() {
			$('#overlay_loading').hide();
			if(self.linkedInDownload.chartIndex != null){
				self.JMAChart.downloadChartData(self.linkedInDownload.chartIndex);
			}
		});
		this.myChart_folders = objectParams.myChart.folderList;
		this.initializeAllPlugIns();
		this.baseURL = appURL;
		this.controller = appController;
		this.action = appAction;
		this.params = appParams;
		this.SmalltoLarge = null;
		this.JMAChart = new JMAChart();	
		this.userDetails = new Array();
		/* Menu initializations */
		$(document).ready(function() {
			
			$('#modaladd_folder').on('hide.bs.modal', function() {
				// do something when the modal is shown
				$("#editfolderName").val("");
			});
			
			
			if((self.controller=='page' && self.action=='category') || (self.controller=='reports' && self.action=='view')){
				
				
				$.each($('a.commonShare'),function(elm,elmObject){
					$(elmObject).on('click',(function(event){
						var link_input_id = $(this).attr('link_input_id');
						var sType = $(this).attr('stype');
						var share_href = $('#'+link_input_id).val();
						JMA.JMAChart.showCommonShare(share_href,event,sType);
					}));
				});
			}

			

		
	
	if(self.controller=='mycharts' && self.action=='index'){
	$(window).scroll(sticky_relocate);
    sticky_relocate();
}


			self.myChart = new myChart(objectParams.myChart);
			$( ".sub-nav" ).hide();
			$([ self.baseURL+'assets/images/menu-minus.png', self.baseURL+'assets/images/menu-plus.png' ]).preload();
			/*$("ul.menu > li > a.content_leftside_parent").click(
					function() {
						$(this).parent().toggleClass("minus",
								$(this).siblings("ul").css("display") == "none");
						$(this).siblings("ul").css("padding-top", "2px")
								.slideToggle(200);
						//return false;
					});*/
//Before Feb 22 2018
					//$('li.list-toggle').find('a').first().trigger('click');
					//After Feb 22 2018
$('li.list-toggle').find('a').trigger('click');

$("div.input-group-addon i.fa-minus").trigger('click');

			// Do login for download chart
			$('#pop_login_btn').on('click',function(){
				self.User.submitAjxLogin();
			});


			
			//>>> Login box
			$('.x').click(function(){
				$('.popup').hide();
				overlay.appendTo(document.body).remove();
				$.createCookie("isLoginBox",0);
				return false;
			});
			
			$('.xDev').click(function(){
				$('.popupDev').hide();
				overlay.appendTo(document.body).remove();
				$.createCookie("isLoginBox",0);
				return false;
			});
			if($.readCookie("bse_agree") != 'yes' && window.location.pathname == '/page/category/economic-indicators/financial-markets/bse-stock-indices/')
			{
				$('.bsc_unuser').modal({
						backdrop: 'static',
						keyboard: false
				});
				return false;
			}
			$('#bseAgree').click(function(){
				if($.readCookie("bse_agree") != 'yes' && window.location.pathname != '/page/category/economic-indicators/financial-markets/bse-stock-indices/')
				{
					//$('.bsc_unuser').modal('show');
					$('.bsc_unuser').modal({
						backdrop: 'static',
						keyboard: false
					});
				}
				else{
					if($.readCookie("bse_agree") == 'yes' && window.location.pathname != '/page/category/economic-indicators/financial-markets/bse-stock-indices/')
					{
						window.location.assign('page/category/economic-indicators/financial-markets/bse-stock-indices/');
					}	
				}
				return false;
			});

			$('#sensexAgree').click(function(){
				$.createCookie("bse_agree",'yes');
				window.location.assign('page/category/economic-indicators/financial-markets/bse-stock-indices/');
			});
			
			var overlay = $('<div id="overlay"></div>');
			overlay.show();
			overlay.appendTo(document.body);
			$('.popup').show();	
			//<<< Login box
			
			$('#Dv_flashMessage').find('.close_btn').live('click',function(){
				$('#Dv_flashMessage').hide();
			});
			setTimeout(function() {
				$("#Dv_flashMessage").hide('slow');
			}, 10000);
			
			// Cookie message
		    $.cookieBar({});
			

		    


		    jQuery.validator.addMethod("specialChar", function(value, element) {
		    	return this.optional(element) || /([0-9a-zA-Z\s])$/.test(value);
		    }, "Please Fill Only Text.");

			//$('#signup_frm').validate();
			

			$('#login_frm').validate();
			var roles_form = $('#forgotpasswd_frm');
			var error_roles_form = $('#error-message', roles_form);

			roles_form.validate({errorLabelContainer: error_roles_form});
			$('.cnt223').hide();
			$('.cnt223Dev').hide();
			/* setTimeout( function () {
				$('.cnt223Dev').slideUp( 15000 ).delay( 3000 ).fadeIn( 2000 );}, 500); */
			setTimeout( function () {
				$('.cnt223').slideUp( 15000 ).delay( 3000 ).fadeIn( 2000 );}, 3000);
				
			$('body').on('click', 'div[id^=Jma_chart_container_]' ,function(e) {
				
						var find_id=$(this)[0].id;
						var find_order=$(this)[0].attributes[2].value;
						if(!$('#Chart_Dv_placeholder_'+find_order).find('ul.list_annotations li').hasClass('select')){
						$('#Chart_Dv_placeholder_'+find_order).find('ul.list_annotations').addClass('open')
						$('#Chart_Dv_placeholder_'+find_order).find('ul.list_annotations').show();
							e.stopPropagation()
						}
			});

			$('body').on('click', 'ul.list_annotations li' ,function(e) {
				var chartObj=$(this).closest('ul.list_annotations').data('chartobj');
				var chart=JMA.JMAChart.Charts[chartObj].chart_object;
				if($(this).hasClass('select')){
				$(this).removeClass('select'); 
				var aType=$(this).data('atype');
				
				chart.annotations.allowZoom = true;
				chart.annotations.selected = -1;
				}else{
				$(this).parent().find('li').removeClass('select')
				$(this).addClass('select'); 
				var aType=$(this).data('atype');
				
				chart.annotations.allowZoom = false;
				chart.annotations.selected = aType;
				}
			
				
				
				
			});	
				
			$('body').on('click', '.graph-nav .nav-txt-export, .graph-nav .nav-txt-download, .graph-nav .nav-txt-export-share, .graph-nav .nav-txt-annotation' ,function(e) {

				$('.h_graph_top_area').find('.nav-txt').removeClass('active');
				$('.h_graph_top_area').find('.sub-nav').removeClass('open');
				// $('.h_graph_top_area').find('.sub-nav').hide();


				var that = this;
				var $subnav = $(this).closest('.graph-nav').find( ".sub-nav" ); 

				setTimeout(function() {
					
					if( !$subnav.hasClass('open') ) {
						$(that).removeClass('active');
					}else {
						$(that).addClass('active');
					}
					
				}, 300);
				
				$subnav.toggleClass('open');
				$subnav.slideToggle();
			});


					$(document).on("click", function(e) {

					if ($(e.target).is(".exhibit") === false) {
					$(".exhibit").removeClass("sortable-select");
					$('.ftps_holconmin').removeClass('sortable-select');
					}
					});
			

				

				$('body').on('click', '.exhibit' ,function(e) {
						self.SmalltoLarge=$(this).data('uuid');

				$('.ftps_holconmin').removeClass('sortable-select');
				$('.exhibit').removeClass('sortable-select');
				$(this).addClass('sortable-select');
				 e.stopPropagation()
			});

				/* $('body').on('click', '.ftps_holconmin' ,function(e) {
					$('.ftps_holconmin').removeClass('sortable-select');
				$('.exhibit').removeClass('sortable-select');
				$(this).addClass('sortable-select');
				 e.stopPropagation()
			}); */



			$('body').on('click', '.graph-nav .nav-txt-save' ,function(e) {

				// Check login
				if(JMA.userDetails.hasOwnProperty('id') && JMA.userDetails.id>0) {
					$('.h_graph_top_area').find('.nav-txt').removeClass('active');
					$('.h_graph_top_area').find('.sub-nav').removeClass('open');
					// $('.h_graph_top_area').find('.sub-nav').hide();


					var that = this;
					var $subnav = $(this).closest('.graph-nav').find( ".sub-nav" ); 

					setTimeout(function() {
						
						if( !$subnav.hasClass('open') ) {
							$(that).removeClass('active');
						}else {
							$(that).addClass('active');
						}
						
					}, 300);
					
					$subnav.toggleClass('open');
					$subnav.slideToggle();
				}else{
					JMA.User.showLoginBox('mychart',JMA.baseURL + JMA.controller + "/" + (JMA.action == "index" ? '' : JMA.action + "/")+JMA.params);
					var p_chart_idx = this.id;
					var currentUrl = window.location;
					var str = ""+currentUrl+"";
					var res = str.split('/').join('@'); 
					//var avoid = "@japanmacroadvisors@";
					//var test = res.replace(avoid, '');
					//var linkedInUrl = 'user/linkedinProcess/'+test+'code='+cht_codes_str+'datatype='+JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type;
					if(window.location.hostname == "localhost")
					{
						var href = window.location.href.split('/');
						var linkedInUrl = href[3]+'/user/linkedinProcess/?'+res+'index='+p_chart_idx;
					}
					else
					{
						var linkedInUrl = 'user/linkedinProcess/?'+res+'index='+p_chart_idx;
					}
					$("a.linkedIn").attr("href", linkedInUrl);
				}
			});

$(document).on('click', function(e){

	var container = $(".graph-nav");

			    if (!container.is(e.target) // if the target of the click isn't the container...
			        && container.has(e.target).length === 0) // ... nor a descendant of the container
			    {
			    	$('.graph-nav .nav-txt').removeClass('active');
			    	$( ".graph-nav .sub-nav" ).removeClass('open');
			    	$( ".graph-nav .sub-nav" ).slideUp();
			    }

			  });

			/**
			 * Google Tagmanager code to track user sessions
			 */
			 if(typeof(dataLayer) == 'object' && self.userDetails.hasOwnProperty('id') && self.userDetails.id>0) {
			 	dataLayer.push({
			 		'user_id': self.userDetails.id,
			 		'user_lname': self.userDetails.lname,
			 		'user_type': self.userDetails.user_type
			 	});
			 }

			});
};
this.initializeAllPlugIns = function(){
		// Jquery plug-ins
		(function( $ ) {
			$.fn.serializeObject = function()
			{
				var o = {};
				var a = this.serializeArray();
				$.each(a, function() {
					if (o[this.name] !== undefined) {
						if (!o[this.name].push) {
							o[this.name] = [o[this.name]];
						}
						o[this.name].push(this.value || '');
					} else {
						o[this.name] = this.value || '';
					}
				});
				return o;
			};
		}( jQuery ));
		// Cookie - plug-in
		// Create cookie
		(function( $ ) {
			$.createCookie = function(name,value,days){
				if (days) {
					var date = new Date();
					date.setTime(date.getTime()+(days*24*60*60*1000));
					var expires = "; expires="+date.toGMTString();
				}
				else var expires = "";
				document.cookie = name+"="+value+expires+"; path=/";				
			}
		}( jQuery ));
		// Read cookie
		(function( $ ) {
			$.readCookie = function(name){
				var nameEQ = name + "=";
				var ca = document.cookie.split(';');
				for(var i=0;i < ca.length;i++) {
					var c = ca[i];
					while (c.charAt(0)==' ') c = c.substring(1,c.length);
					if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
				}
				return null;				
			};
		}( jQuery ));
		// Erase cookie
		(function( $ ) {
			$.eraseCookie = function(name){
				$.createCookie(name,"",-1);
			};
		}( jQuery ));		
		
	};
	this.showLoading = function(){
		$('#overlay_loading').show();
	};
	this.hideLoading = function(){
		$('#overlay_loading').hide();
	};
	
	this.UserProfile = {
		showEdit : function() {
			$('#dv_placeholder_view_profile').hide();
			$('#dv_placeholder_change_password').hide();
			$('#dv_placeholder_edit_profile').show();
		},
		closeEdit : function() {
			$('#dv_placeholder_edit_profile').hide();
			$('#dv_placeholder_view_profile').show();
			$('#dv_placeholder_change_password').show();
		}
	};
	
	this.User = {
		showLoginBox : function(type,typeValue) {
			// type == 'download'  || type == 'premium'
			if(type=="premium"){
				$(".download-img,.download,.download-logininfo,.mychart").hide();
				$('.premium-img, .premium, .premium-logininfo').show();
				$('#chart_login_perm_type').val(type);
				$('#chart_login_premium_url').val(typeValue);
			}
			if(type=="download"){
				$('.premium-logininfo,.premium').hide();
				//$('.premium-img').hide();
				$('.mychart').hide();
				$(".download-img,.download").show();
				$('#chart_login_perm_type').val(type);
				$('#chart_login_chart_index').val(typeValue);
			}
			if(type=="mychart"){
				$(".premium, .download, .premium-logininfo").hide();
				$('.premium-img, .download-img, .mychart, .download-logininfo').show();
				$('#chart_login_perm_type').val(type);
				$('#chart_login_premium_url').val(typeValue);
			}
			
			if(type=="LoginOnly"){
				var currentUrl = window.location.href;
				console.log(currentUrl);
				$(".premium, .download, .premium-logininfo").hide();
				$('.premium-img, .download-img, .mychart, .download-logininfo').hide();
				$('#chart_login_perm_type').val(type);
				$('#chart_login_premium_url').val(currentUrl);
			}

			$('#Dv_modal_login').modal('show');

			/*$.fancybox({
				href : '#Dv_modal_login',
				modal : false,
				showCloseButton : false,
				onClosed : function() {
					$('#Dv_modal_login').hide();
				}
			});*/
},
showUpgradeBox : function(type,typeValue) {
			// type == 'download'  || type == 'premium'
			//$('#Dv_modal_upgrade_premium_content').show();
			$('#Dv_modal_upgrade_premium_content').modal('show');
			/*$.fancybox({
				href : '#Dv_modal_upgrade_premium_content',
				modal : false,
				showCloseButton : false,
				onClosed : function() {
					$('#Dv_modal_upgrade_premium_content').hide();
				}
			});*/
},
showUpgradeBoxForPremiumFeature : function(type,typeValue) {
			// type == 'download'  || type == 'premium'
			//$('#Dv_modal_upgrade_premium_feature').show();
			$('#Dv_modal_upgrade_premium_feature').modal('show');
			/*$.fancybox({
				href : '#Dv_modal_upgrade_premium_feature',
				modal : false,
				showCloseButton : false,
				onClosed : function() {
					$('#Dv_modal_upgrade_premium_feature').hide();
				}
			});*/
},
showHideEditprofile : function() {
	$('#Table_user_profile_show').toggle();
	$('#Table_user_profile_edit').toggle();
},

submitAjxLogin : function(){
	var postParams = $('#login_frm_ajx').serializeObject();
	var jq_frm_obj = $('#frm_download_chart_data_'+postParams.chart_login_chart_index);
	$('.login_frm_ajx_login_status').hide();
	var loginUrl = JMA.baseURL+'user/loginbyajx';
	$.ajax({
		url : loginUrl,
		dataType : 'json',
		type : 'POST',
		data : postParams,
				//beforeSend: function() { JMA.showLoading(); },
				success : function(response){
					if(response.status ==1){
						JMA.userDetails = response.result.userdetails;
						//$.fancybox.close();
						$(".modal").modal("hide");
						if(postParams.chart_login_perm_type == 'download'){
							if(JMA.userDetails.hasOwnProperty('id') && JMA.userDetails.id>0) {
								var replaceHtml = '<div style="color: #393939; margin-top: 0px; font-size: 12px">'+
								'<div style="font-size: 14px">'+
								'<i style="color: #EF6F07; font-size: 14px;" class="fa fa-th"></i>&nbsp;<strong>'+JMA.userDetails.fname+' '+JMA.userDetails.lname+'</strong>'+
								'</div>'+	
								'<div style="margin-top: 14px; padding-left: 15px;">';			
								if (JMA.userDetails.user_type == 'corporate') {
									replaceHtml += '<i style="color: #22558F; font-size: 14px" class="fa fa-building fa-lg"></i>&nbsp;<strong>CorporatAccount</strong>';
								}
								if (JMA.userDetails.user_type == 'individual') {
									replaceHtml +=	'<i style="color: #22558F; font-size: 14px; margin: 0 0 0 0;" class="fa fa-user fa-lg"></i>'+
									'<i style="color: #22558F; font-size: 10px; margin: -10px -1px -6px -2px;" class="fa fa-star fa-fw"></i>&nbsp;<strong>Premium Account</strong>';
								} 	
								if (JMA.userDetails.user_type == 'free') {
									replaceHtml += '<i style="color: #6EB92B; font-size: 14px; margin: 8px 0 0;" class="fa fa-user fa-lg"></i>&nbsp;<strong>Individual Free Accounts</strong>';
								} 
								replaceHtml += '</div></div>';
							}	
							var navigationLinks = '<li><a href="user/myaccount" class="top_link_common"><font color="red">'+JMA.userDetails.fname+' '+JMA.userDetails.lname+'</font></a></li>'+
							'<li class="last"><a href="user/logout" class="top_link_common">Signout</a></li>';
							$( '#lnk_client_login' ).replaceWith(navigationLinks);
							$( '.right' ).html(replaceHtml);
							jq_frm_obj.submit();
						}else if(postParams.chart_login_perm_type == 'premium' || postParams.chart_login_perm_type == 'mychart'|| postParams.chart_login_perm_type == 'LoginOnly'){
							window.location=postParams.chart_login_premium_url;
						}
					}else{
						$('.login_frm_ajx_login_status').show().html(response.message);
					}
					//JMA.hideLoading();
				},
				error : function() {
					//JMA.hideLoading();
					JMA.handleError();
				}
			});
}
};

	/**
	 * Function generateUUID()
	 * Generate a random unique uuid
	 */
	 this.generateUUID = function(){
	 	function s4() {
	 		return Math.floor((1 + Math.random()) * 0x10000)
	 		.toString(16)
	 		.substring(1);
	 	}
	 	return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
	 	s4() + '-' + s4() + s4() + s4();
	 };

	/**
	 * Function to handle error 
	 */
	 this.handleError = function(){
	 	function checkCountDown(refreshTime_count){
	 		var refreshTime_count_new = refreshTime_count-1;
	 		setTimeout(function(){
	 			$("#error_page_refresh_countdown").text(refreshTime_count_new);
	 			if(refreshTime_count_new == 0){
	 				location.reload();
	 			}else{
	 				checkCountDown(refreshTime_count_new);
	 			}
	 		},1000);
	 	}
		var refreshTime = 10; // Seconds
		/*$.fancybox({
			href : '#Dv_modal_error_common',
			modal : true,
			showCloseButton : false,
			onStart : function(){
				$('#Dv_modal_error_common').show();
			},
			onClosed : function() {
				$('#Dv_modal_error_common').hide();
			}
		});*/
$('#Dv_modal_error_common').modal('show');
$('#Dv_modal_error_common').on('shown.bs.modal', function () {
	$("#error_page_refresh_countdown").text(refreshTime);
})


checkCountDown(refreshTime);
};

	/**
	 * Handle error with a error message
	 */
	 this.handleErrorWithMessage = function(message){
	/*	$.fancybox({
			href : '#Dv_modal_error_common_with_message',
			modal : false,
			showCloseButton : false,
			onStart : function(){
				$('#Dv_modal_error_common_with_message').show();
				$("#error_page_error_message").text(message);
			},
			onClosed : function() {
				$('#Dv_modal_error_common_with_message').hide();
			}
		});	*/

$('#Dv_modal_error_common_with_message').modal('show');

$('#Dv_modal_error_common_with_message').on('shown.bs.modal', function () {
	$("#error_page_error_message").text(message);
})
};



this.exportPptperPage = function(this_obj,total_chart_len){
	
	var total_chart_len=total_chart_len;
	var this_obj=this_obj;

	var chartArray = [];var chartTitleArray = [];var chartsourceArray = [];var chartNotesArray = [];
	var i=0;

	if($(this_obj).hasClass('small-view')){
		var Eachelm=this_obj.parents('.ftps_holconmin').find('.exhibit');
	}else{
		var Eachelm=this_obj.parents('.col-xs-12').nextUntil(".page2").filter('.exhibit');
	}
	Eachelm.each(function( index, element ) {

		var chart_title =$(this).find('h5.exhibit-title').text();
		chartTitleArray.push(chart_title);


		if(!$(this).hasClass('note')){
			if($(this_obj).hasClass('small-view')){
				var chartOrder=$(this).data('order');
			}else{

				var chartOrder=$(this).find('ul.exhibit-tab li').data('order');
			}


      //var chart_content =$(this).find('div.data-views div.graph-view div.highcharts-container').clone().wrap('<span>').parent().html();

         // var chart_source =$(chart_content).find("span").text();

         chartsourceArray[index]="Source : "+self.myChart.myFolder.currentFolder.charts[chartOrder].data.sources;

         if(!$(this).find('div.data-views div.graph-view').hasClass('hide')){

         	var chart=self.myChart.myFolder.currentFolder.charts[chartOrder].chart_object;


         	if(JMA.myChart.myFolder.currentView=='smallView'){

         		var chartoptins={
         			backgroundColor: '#FFF',
         			width: 680,
         			height: 400
         		};
         	}else{
         		var chartoptins={ backgroundColor: '#FFF'};
         	}



         	var chart_svg = chart.getSVG({
         		chart:chartoptins,
         		credits: {
         			enabled: false
         		},

         		tooltip: { enabled: false },
         		scrollbar : {
         			enabled : false
         		},
         		legend:{
         			width: 350
         		},
         		xAxis: {
         			scrollbar: {
         				enabled: false
         			}
         		}
         	});
          //
          var find_image =$(chart_svg).find("image").remove().clone().wrap('<div>').parent().html();
          chart_svg = chart_svg.replace(find_image, '');
          var exp_data = {
          	svg: chart_svg,
          	type: 'png',
          	width: 900,
          	height: 400,
          	async: true,
          	cache:true,
          };

      // Local sertver
      exportUrl = JMA.baseURL+'chart/exportChartpptx';
       /* // Highchart sertver
        if (window.location.protocol != "https:"){
         exportUrl=chart.options.exporting.url;
    }else{
       exportUrl='https://export.highcharts.com/';
     }*/




     $.ajax({
     	type: "POST",
     	url: exportUrl,
     	data: exp_data,
     	cache:false,
     	async:true,
     	crossDomain:true,
     	success: function (data) {

     		chartArray[index]=({"chart":data});
     	},
     	error: function(data) {
     		console.log(data.statusText+data.status);
     		chartArray[index]=({"chart":data.status});

     	}
     });

     chartNotesArray[index]='';

   }else{
   	var chartOrder=$(this).find('ul.exhibit-tab li').data('order');
   	var Datas=self.myChart.myFolder.currentFolder.charts[chartOrder];

   	var each_tbl_row_len=$(this).find('div.data-views div.table-view table tbody tr').length;
   	var each_tbl_content = $(this).find('div.data-views div.table-view');






   	var $add_tr=0; 

   	if(($.browser.mozilla || $.browser.msie) && Datas.chart_data_type != 'daily') { 
              //if (window.location.protocol == "https:"){
              	if(Datas.chart_data_type == 'monthly'){
              		$add_tr=3; 
              	}
              //}
            } 



            if(Datas.chart_data_type == 'daily' && ($.browser.mozilla || $.browser.msie)){

            	var winscrollTop     = $(window).scrollTop();
            	var elementOffset = each_tbl_content.offset().top;
            	var elementdistance      = (elementOffset - winscrollTop);
            	$add_tr=Math.floor(elementdistance/30);

            	var firstToprows=isScrolledtopMoz(each_tbl_content);
            	firstToprows=(firstToprows<100)?firstToprows:firstToprows + $add_tr;
            }else{
            	var firstToprows=findTopVisibleRow(each_tbl_content) + $add_tr ;
            }

            var lastrows=firstToprows  + 11;
            
            
            var data_formated = [];var tableArray;var data_heading = [];
            $.each(Datas.data.chartDataSeries,function(order,series){
            	data_heading[order]=series.name;

            	$.each(series.data,function(i_order,dataset){
            		if(i_order>=firstToprows && i_order<=lastrows){
            			if(Array.isArray(data_formated[i_order]) == true){

            				data_formated[i_order].push(dataset[1]);
            			}else{
            				if(Datas.chart_data_type == 'monthly'){
            					var dte = Highcharts.dateFormat('%b',dataset[0])+" "+Highcharts.dateFormat('%Y',dataset[0]);
            				}else if(Datas.chart_data_type == 'quaterly'){
            					if (Highcharts.dateFormat('%b', dataset[0]) == 'Mar') {
            						var dte = "Q1 "+Highcharts.dateFormat('%Y',dataset[0]);
            					}
            					if (Highcharts.dateFormat('%b', dataset[0]) == 'Jun') {
            						var dte = "Q2 "+Highcharts.dateFormat('%Y',dataset[0]);
            					}
            					if (Highcharts.dateFormat('%b', dataset[0]) == 'Sep') {
            						var dte = "Q3 "+Highcharts.dateFormat('%Y',dataset[0]);
            					}
            					if (Highcharts.dateFormat('%b', dataset[0]) == 'Dec') {
            						var dte = "Q4 "+Highcharts.dateFormat('%Y',dataset[0]);
            					}
            				}else if(Datas.chart_data_type == 'anual'){
            					var dte = Highcharts.dateFormat('%Y',dataset[0]);
            				}else if(Datas.chart_data_type == 'daily'){
            					var dte = Highcharts.dateFormat('%e',dataset[0])+" "+Highcharts.dateFormat('%b', dataset[0])+", "+Highcharts.dateFormat('%Y',dataset[0]);
            				}else if((Datas.chart_data_type).match('^yield')){
            					var dte = dataset[0];
            				}	



            				data_formated[i_order] = [dte,dataset[1]];
            			}
            		}
            	});
});
tableArray=({"heading":data_heading,"data":JSON.stringify(data_formated)});
chartArray[index]=({"table":tableArray});

}


}else{
	chartNotesArray[index]=$(this).find('div.noteContent').html();
	chartArray[index]='';
}
i++;
});



if(total_chart_len==0){
  //Just trigger one ajax if it is not atleaet one chart
  $.ajax({
  	type: "POST",
  	url: JMA.baseURL,
  	data: 1,
  	cache:false,
  	async:true,
  	crossDomain:true,
  	success: function (data) {
  	}

  });
}
//If all the ajax is complete it will start to process
$(document).one("ajaxStop", function() {
	$.ajax({
		type: "POST",
		url: JMA.baseURL+"mycharts/power_point",
		data: {data:chartArray,titleArray:chartTitleArray,sourceArray:chartsourceArray,NotesArray:chartNotesArray,title:$('h1#Dv_folder_content_title').text(),page_no: this_obj.parent().clone().children().remove().end().text(),currentView: JMA.myChart.myFolder.currentView},
		dataType: "json",
		beforeSend: function (xhr) {
		},
		success: function(data){
			if(data.msg==true){
				
				$(this_obj).find('i.fa-spinner').remove();
				var hidden_a = document.createElement("a");
				hidden_a.setAttribute("href", JMA.baseURL+data.dir+data.file);
				hidden_a.setAttribute("download", data.file);
				document.body.appendChild(hidden_a);
				if($.browser.safari){
					hidden_a.onclick=function(){
						document.body.removeChild(hidden_a);
					}
					var cle = document.createEvent("MouseEvent");
					cle.initEvent("click", true, true);
					hidden_a.dispatchEvent(cle);
				}else{
					hidden_a.click();
					document.body.removeChild(hidden_a);
				}



			}else{
				alert(data.msg);  
			}
		},
		error: function(data) {
			alert(data.statusText+data.status+' Something went wrong');
		}
	});
});

};


this.exportPPT = function(this_obj,total_chart_len){

	$('.progress_exportfile').show();
	var total_chart_len=total_chart_len;
	var this_obj=this_obj;
	var byprogress=(100/total_chart_len);

	var chartArray = [];var chartTitleArray = [];var chartsourceArray = [];var chartNotesArray = [];
	var i=0;
	$( "div.exhibit" ).each(function( index, element ) {
		var chart_title =$(this).find('h5.exhibit-title').text();
		chartTitleArray.push(chart_title);
		if(!$(this).hasClass('note')){
			var chartOrder=$(this).find('ul.exhibit-tab li').data('order');
			var chart_content =$(this).find('div.data-views div.graph-view div.highcharts-container').clone().wrap('<span>').parent().html();
			var chart_source =$(chart_content).find("span").text();
			chartsourceArray[index]=chart_source;
			if(!$(this).find('div.data-views div.graph-view').hasClass('hide')){
				var chart=self.myChart.myFolder.currentFolder.charts[chartOrder].chart_object;



				var chart_svg = chart.getSVG({
					chart:{
						backgroundColor: '#FFF'
					},
					credits: {
						enabled: false
					},
					tooltip: { enabled: false },
					scrollbar : {
						enabled : false
					},
					xAxis: {
						scrollbar: {
							enabled: false
						}
					},
					legend:{
						width: 350
					}
				});
//
var find_image =$(chart_svg).find("image").remove().clone().wrap('<div>').parent().html();
chart_svg = chart_svg.replace(find_image, '');
var exp_data = {
	svg: chart_svg,
	type: 'png',
	width: 900,
	height: 400,
	async: true
};

// Local sertver
//exportUrl = JMA.baseURL+'chart/exportChartpptx';
// Highchart sertver
if (window.location.protocol != "https:"){
	exportUrl=chart.options.exporting.url;
}else{
	exportUrl='https://export.highcharts.com/';
}
$.ajax({
	type: "POST",
	url: exportUrl,
	data: exp_data,
	cache:false,
	async:true,
	crossDomain:true,
	success: function (data) {

		chartArray[index]=({"chart":data});
		if((index*byprogress)<90){
			$('.progress-bar').css('width', (index*byprogress)+'%').attr('aria-valuenow', (index*byprogress));
		}

	},
	error: function(data) {
		console.log(data.statusText+data.status);
		chartArray[index]=({"chart":data.status});
	}
});
chartNotesArray[index]='';
}else{
	var chartOrder=$(this).find('ul.exhibit-tab li').data('order');
	var Datas=self.myChart.myFolder.currentFolder.charts[chartOrder];
	var each_tbl_row_len=$(this).find('div.data-views div.table-view table tbody tr').length;
	var each_tbl_content = $(this).find('div.data-views div.table-view');
	var $add_tr=0;
	if(($.browser.mozilla || $.browser.msie) && Datas.chart_data_type != 'daily') {
//if (window.location.protocol == "https:"){
	if(Datas.chart_data_type == 'monthly'){
		$add_tr=3;
	}
//}
}
if(Datas.chart_data_type == 'daily' && ($.browser.mozilla || $.browser.msie)){
	var winscrollTop     = $(window).scrollTop();
	var elementOffset = each_tbl_content.offset().top;
	var elementdistance      = (elementOffset - winscrollTop);
	$add_tr=Math.floor(elementdistance/30);
	var firstToprows=isScrolledtopMoz(each_tbl_content);
	firstToprows=(firstToprows<100)?firstToprows:firstToprows + $add_tr;
}else{
	var firstToprows=findTopVisibleRow(each_tbl_content) + $add_tr ;
}
var lastrows=firstToprows  + 11;
var data_formated = [];var tableArray;var data_heading = [];
$.each(Datas.data.chartDataSeries,function(order,series){
	data_heading[order]=series.name;
	$.each(series.data,function(i_order,dataset){
		if(i_order>=firstToprows && i_order<=lastrows){
			if(Array.isArray(data_formated[i_order]) == true){
				data_formated[i_order].push(dataset[1]);
			}else{
				if(Datas.chart_data_type == 'monthly'){
					var dte = Highcharts.dateFormat('%b',dataset[0])+" "+Highcharts.dateFormat('%Y',dataset[0]);
				}else if(Datas.chart_data_type == 'quaterly'){
					if (Highcharts.dateFormat('%b', dataset[0]) == 'Mar') {
						var dte = "Q1 "+Highcharts.dateFormat('%Y',dataset[0]);
					}
					if (Highcharts.dateFormat('%b', dataset[0]) == 'Jun') {
						var dte = "Q2 "+Highcharts.dateFormat('%Y',dataset[0]);
					}
					if (Highcharts.dateFormat('%b', dataset[0]) == 'Sep') {
						var dte = "Q3 "+Highcharts.dateFormat('%Y',dataset[0]);
					}
					if (Highcharts.dateFormat('%b', dataset[0]) == 'Dec') {
						var dte = "Q4 "+Highcharts.dateFormat('%Y',dataset[0]);
					}
				}else if(Datas.chart_data_type == 'anual'){
					var dte = Highcharts.dateFormat('%Y',dataset[0]);
				}else if(Datas.chart_data_type == 'daily'){
					var dte = Highcharts.dateFormat('%e',dataset[0])+" "+Highcharts.dateFormat('%b', dataset[0])+", "+Highcharts.dateFormat('%Y',dataset[0]);
				}else if((Datas.chart_data_type).match('^yield')){
					var dte = dataset[0];
				}


				data_formated[i_order] = [dte,dataset[1]];
			}
		}
	});
});
tableArray=({"heading":data_heading,"data":JSON.stringify(data_formated)});
chartArray[index]=({"table":tableArray});

}
}else{
	chartNotesArray[index]=$(this).find('div.noteContent').html();

	chartArray[index]='';
}
i++;
});
if(total_chart_len==0){
	$('.progress-bar').css('width', 95+'%').attr('aria-valuenow', 95); 
//Just trigger one ajax if it is not atleaet one chart
$.ajax({
	type: "POST",
	url: JMA.baseURL,
	data: 1,
	cache:false,
	async:true,
	crossDomain:true,
	success: function (data) {
	}
});
}
//If all the ajax is complete it will start to process
$(document).one("ajaxStop", function() {
	$.ajax({
		type: "POST",
		url: JMA.baseURL+"mycharts/power_point",
		data: {data:chartArray,titleArray:chartTitleArray,sourceArray:chartsourceArray,NotesArray:chartNotesArray,title:$('h1#Dv_folder_content_title').text()},
		dataType: "json",
		beforeSend: function (xhr) {
			$('.progress-bar').css('width', 98+'%').attr('aria-valuenow', 98); 
		},
		success: function(data){
			if(data.msg==true){

				$('i.ppt-spin').hide();
				var hidden_a = document.createElement("a");
				hidden_a.setAttribute("href", JMA.baseURL+data.dir+data.file);
				hidden_a.setAttribute("download", data.file);
				document.body.appendChild(hidden_a);
				if($.browser.safari){
					hidden_a.onclick=function(){
						document.body.removeChild(hidden_a);
					}
					var cle = document.createEvent("MouseEvent");
					cle.initEvent("click", true, true);
					hidden_a.dispatchEvent(cle);
				}else{
					hidden_a.click();
					document.body.removeChild(hidden_a);
				}
				$('.progress_exportfile').hide();
				$('.ppt-mycharts').removeAttr("disabled");
			}else{
				alert(data.msg);
				$('.ppt-mycharts').removeAttr("disabled");
			}
		},
		error: function(data) {
			$('.ppt-mycharts').removeAttr("disabled");
			alert(data.statusText+data.status+' Something went wrong');
		}
	});
});

};






(function(appURL,appController,appAction,appParams,objectParams){
	self.__construct(appURL, appController, appAction, appParams, objectParams);
})(appURL,appController,appAction,appParams,objectParams);
}

// Class map Common
function mapCommon(p_chartIndex, chartDetails){

	this.Conf = {
		categories : {},
		mapdata : {},
		stateJsonData : {},
		mapTitle : '',
		mapSource : '',
		selectStateKeys : '',
		chartIndex :'',
		chartType : '',
		chartIndex : null,
		isChartTypeSwitchable : 'Y',
		isPremiumData : false,
		chartLayout : 'normal',
		isNavigator : true,
		chartExport : {},
		chart_actual_code : '',
		chart_data_type : '',
		current_chart_codes : [],
		chart_labels_available : [],
		charts_available : [],
		charts_codes_available : [],
		charts_fields_available : [],
		navigator_date_from : '',
		navigator_date_to : '',
		share_chart : {
			share_page_url : '',
			dateRange_from : '',
			dateRange_to : ''
		}
	};
	
	this.chart_object = null;
	this.chartLayoutData = {'chart_details' : {}, 'series_details' : {}, 'mychart_details' : {}};
	
	
	this.formatData = function(ap_data){
		var out_data = {};
		$.each(ap_data,function(graph_code,data_rows){
			var p_data_rows = new Array();
			$.each(data_rows,function(ky,row){
				$.each(row,function(kye,rowe){
					var datetimeVal = kye.split('-');
					var utcTime = Date.UTC(datetimeVal[2],datetimeVal[1]-1,datetimeVal[0]);
					var float_value = rowe == null ? null : parseFloat(rowe);
				    p_data_rows[ky] = [utcTime,float_value];
					
				});
				
				/* var datetimeVal = row[0].split('-');
				var utcTime = Date.UTC(datetimeVal[2],datetimeVal[1]-1,datetimeVal[0]);
				var float_value = row[1] == null ? null : parseFloat(row[1]); 
				p_data_rows[ky] = [utcTime,float_value];*/
			});
			out_data[graph_code] = p_data_rows;
		});
		
		return out_data;
	}
	
	this.setAllConfigurationsForMap = function(p_chartIndex,p_configs){
		this.Conf.categories = p_configs.categories;
		this.Conf.mapdata = p_configs.MapData;
		this.Conf.lastYearData = p_configs.lastYearData;
		this.Conf.stateJsonData = p_configs.stateJsonData;
		this.Conf.mapTitle = p_configs.mapTitle;
		this.Conf.mapSource = p_configs.mapSource;
		this.Conf.chartIndex = p_chartIndex;
		this.Conf.chartType = p_configs.map_config.chartType;
		
		
		this.Conf.isPremiumData = p_configs.isPremiumData;
		this.Conf.chartLayout = p_configs.map_config.chartLayout;
		this.Conf.isNavigator = p_configs.map_config.isNavigator;
		this.Conf.chart_actual_code = p_configs.chart_actual_code;
		this.Conf.chart_data_type = p_configs.chart_data_type;
		this.Conf.current_chart_codes = p_configs.current_chart_codes;
		this.Conf.chart_labels_available = p_configs.chart_labels_available;
		this.Conf.charts_codes_available = p_configs.charts_codes_available;
		this.Conf.charts_available = p_configs.charts_available;
		this.Conf.charts_fields_available = p_configs.charts_fields_available;
		this.Conf.share_chart.share_page_url = p_configs.share_page_url;
		this.Conf.share_chart.dateRange_from = p_configs.navigator_date_from;
		this.Conf.share_chart.dateRange_to = p_configs.navigator_date_to;
		var js_dateRange_from = p_configs.navigator_date_from.split('-');
		var js_dateRange_to = p_configs.navigator_date_to.split('-');
		this.Conf.navigator_date_from = Date.UTC(js_dateRange_from[2],js_dateRange_from[1]-1,js_dateRange_from[0]);
		this.Conf.navigator_date_to = Date.UTC(js_dateRange_to[2],js_dateRange_to[1]-1,js_dateRange_to[0]);
		this.Conf.selectStateKeys = '';
		
		
	};
	
	
	
	
	// Create chart layout data sets
	this.createChartLayoutData = function(mobileView){
		var mychart_folder_list = Object.create(JMA.myChart_folders);
		var folderList = [];
		try{
			if(typeof(JMA.userDetails.user_permissions)=='object'){
				folderList = typeof(mychart_folder_list) == 'object' ? mychart_folder_list.splice(0,JMA.userDetails.user_permissions.mychart.totalFolders) : [];
			}
		}catch (e){
			
		}
		this.chartLayoutData['chart_details'] = {
			chartIndex : this.Conf.chartIndex,
			isRightPannel : (this.Conf.chartLayout == 'narrow') ? false : true
			
		};
		if(JMA.controller == "mycharts"){
			this.chartLayoutData['mychart_details'] = {
				'isMyChart' : true,
				'folderList' : folderList
			};
		}else{
			this.chartLayoutData['mychart_details'] = {
				'isMyChart' : false,
				'folderList' : folderList
			};
		}
	};
	
	// Draw chart Layout
	this.drawChartLayout = function(){
		this.createChartLayoutData();
		var chart_placeholder = "Chart_Dv_placeholder_"+this.Conf.chartIndex;
		var chart_template_object = Handlebars.compile($('#template_Map_full').html());
		var chart_template = chart_template_object(this.chartLayoutData);
		$('#'+chart_placeholder).html(chart_template);
	};
	
	
	/**
	 * Function - createChartCodeFromConfig
	 * Function to create chart code from configuration items. It accomodates all changes done on chart
	 */
	 this.createChartCodeFromConfig = function(){
		 
	 	var date_from = new Date(this.Conf.navigator_date_from);
	 	var date_to = new Date(this.Conf.navigator_date_to);
	 	var chartCode = "{map "+this.Conf.current_chart_codes.toString()+"|"+this.Conf.charts_codes_available.toString()+"|";
	 	if(this.Conf.chart_data_type != 'anual'){
			
	 		chartCode+=date_from.getFullYear()+"-"+(date_from.getMonth()+1)+","+date_to.getFullYear()+"-"+(date_to.getMonth()+1);
	 	}else{
	 		chartCode+=date_from.getFullYear()+","+date_to.getFullYear();
	 	}
	 	var chartConfigurations = "{chartLayout:'"+this.Conf.chartLayout+"',chartType:'"+this.Conf.chartType+"',dataType:'"+this.Conf.chart_data_type+"',isMultiaxis:"+(this.Conf.chartType == 'multiaxisline' ? true : false)+",isChartTypeSwitchable:'"+this.Conf.isChartTypeSwitchable+"',isNavigator:"+this.Conf.isNavigator+"}";
	 	return chartCode+chartConfigurations+"}";
	 };
	 
	 
	 // Update chart share url
	this.updateChartShareURL = function(min,max){
		var js_min_date = new Date(min);
		var js_max_date = new Date(max);
		this.Conf.share_chart.dateRange_from = js_min_date.getDate()+'-'+(js_min_date.getMonth()+1)+'-'+js_min_date.getFullYear();
		this.Conf.share_chart.dateRange_to = js_max_date.getDate()+'-'+(js_max_date.getMonth()+1)+'-'+js_max_date.getFullYear();
		var new_url = this.Conf.share_chart.share_page_url+'?gids='+this.Conf.current_chart_codes.join('|')+'&graph_index='+this.Conf.chartIndex+'&graph_type='+this.Conf.chartType+'&graph_data_from='+this.Conf.share_chart.dateRange_from+'&graph_data_to='+this.Conf.share_chart.dateRange_to;
		$('#graph_share_url_'+this.Conf.chartIndex).val(new_url);
	};
	
	

}


//Class mapsChart
function mapsChart(p_chartIndex, chartDetails) 
{
	
				var mapCommon = this;
				var chart_object_object = null;
									
				this.createHighChart = function() 
				{
				
				
									var cateArray =  mapCommon.Conf.categories;
									var cateNewArray = new Array();
									for(z=0; z < cateArray.length; z++ )
									{
										
										var datetimeCat = cateArray[z].split('-');
										var utcTimeCat = Date.UTC(datetimeCat[2],datetimeCat[1]-1,datetimeCat[0]);
										cateNewArray.push(utcTimeCat);
										
									}
									
									var mapDataJson = mapCommon.Conf.MapData;
									
									var latestTopVal = mapCommon.Conf.mapdata[0].value;
									var diveSceColor = latestTopVal/10;
									
									var diveSceColors = Math.ceil(Object.keys(mapCommon.Conf.mapdata).length*10/100);
									
									var limitVari = diveSceColors-1;
									
									var diveSceColorsFst = mapCommon.Conf.lastYearData.slice(0, diveSceColors);
									var diveSceColorsSec = mapCommon.Conf.lastYearData.slice(diveSceColors, diveSceColors*2);
									var diveSceColorsTrd = mapCommon.Conf.lastYearData.slice(diveSceColors*2, diveSceColors*3);
									var diveSceColorsFth = mapCommon.Conf.lastYearData.slice(diveSceColors*3, diveSceColors*4);
									var diveSceColorsFiv = mapCommon.Conf.lastYearData.slice(diveSceColors*4, diveSceColors*5);
									
									var diveSceColorsSix = mapCommon.Conf.lastYearData.slice(diveSceColors*5, diveSceColors*6);
									var diveSceColorsSev = mapCommon.Conf.lastYearData.slice(diveSceColors*6, diveSceColors*7);
									var diveSceColorsEigt = mapCommon.Conf.lastYearData.slice(diveSceColors*7, diveSceColors*8);
									var diveSceColorsNin = mapCommon.Conf.lastYearData.slice(diveSceColors*8, diveSceColors*9);
									
									var parsed = mapCommon.Conf.stateJsonData;
		
		
									var countries = {},
									mapChart,
									countryChart,
									numRegex = /^[0-9\.]+$/,
									quoteRegex = /\"/g,
									categories = cateNewArray;
					
					
									var mapData = Highcharts.geojson(Highcharts.maps['countries/in/custom/in-all-disputed']);
									$.each(mapData, function () {
										this.id = this.properties['hc-key'];
									});
					             

					       
									 mapChart = Highcharts.mapChart('mapchartView_'+mapCommon.Conf.chartIndex, 
									 {
												
													title : {
														
														text : mapCommon.Conf.mapTitle
													},
													/* subtitle : {
														text : 'Source map: '+ mapCommon.Conf.mapSource
													},  */
													exporting: { 
													   enabled: false 
													},

													mapNavigation: {
														enabled: true,
														buttonOptions: {
															verticalAlign: 'top'
														}
													},
													credits: {
														enabled: false
														},

													colorAxis: {
														min: 1,
														max: 1000,
														type: 'logarithmic',
														gridLineWidth: 2,
														gridLineColor: 'white',
														minorTickInterval: 0.1,
														minorGridLineColor: 'white',
														tickLength: 0,
															dataClasses: [{
																to: Math.floor(diveSceColorsNin[0].value),
																color: "#e6fcff"
															},{
																from: Math.floor(diveSceColorsNin[0].value),
																to: Math.ceil(diveSceColorsEigt[0].value),
																color: "#e6f2ff"
															},{
																from: Math.floor(diveSceColorsSev[limitVari].value),
																to: Math.ceil(diveSceColorsSev[0].value),
																color: "#cce6ff"
															} ,{
																from: Math.floor(diveSceColorsSix[limitVari].value),
																to: Math.ceil(diveSceColorsSix[0].value),
																color: "#b3d9ff"
															},{
																from: Math.floor(diveSceColorsFiv[limitVari].value),
																to: Math.ceil(diveSceColorsFiv[0].value),
																color: "#99ccff"
															},{
																from: Math.floor(diveSceColorsFth[limitVari].value),
																to: Math.ceil(diveSceColorsFth[0].value),
																color: "#80bfff"
															},{
																from: Math.floor(diveSceColorsTrd[limitVari].value),
																to: Math.ceil(diveSceColorsTrd[0].value),
																color: "#66b3ff"
															},{
																from: Math.floor(diveSceColorsSec[limitVari].value),
																to: Math.ceil(diveSceColorsSec[0].value),
																color: "#4da6ff"
															},{
																from: Math.floor(diveSceColorsFst[limitVari].value),
																to: Math.ceil(diveSceColorsFst[0].value),
																color: "#0080ff"
															} ]
													},
													legend: {
														
														 align: 'left',
														verticalAlign: 'bottom',
														floating: true,
														layout: 'vertical',
														valueDecimals: 0,
														y: -80,
														symbolRadius: 0,
														symbolHeight: 14
													},
													series : [{
														data : mapCommon.Conf.mapdata,
														mapData: mapData,
														color : 'red',
														/* joinBy: 'hc-key', */
														joinBy: ['hc-key', 'hc-key'],
														name: mapCommon.Conf.mapTitle,
														allowPointSelect: true,
														cursor: 'pointer',
														states: {
															 select: {
																	color: '#a4edba',
																	borderColor: 'black',
																	dashStyle: 'shortdot'
																}
															
														},
														dataLabels: {
															 enabled: true,
															 color: '#000000',
															 format: '{point.name}'
															
														},
														tooltip: {
															    valueDecimals: 0,
																//pointFormat: '{point.name}: {point.Datavalue}'
																pointFormat: '{point.name}: {point.value}'
															}
													}]
												
								   }, function(mapChart) 
								   { // on complete
										mapChart.renderer.image(JMA.baseURL+'assets/images/favicon.png',mapChart.chartWidth-75, 495, 45, 12).add(); 

										mapChart.renderer.text('Source: '+mapCommon.Conf.mapSource, 2, 515)
											.css({
												/* color: '#4572A7', */
												fontSize: '12px'
											})
											.add();
										
									});
					
					
					
					var statenamevale = [];
					var statenamevale1 = [];
					var statenamevaleMore = [];
					var energy = "";
					var stateCodeIDs = "";
				     var defaultSelectSate = "";
					$.each(mapCommon.Conf.stateJsonData, function (j, line) {
						  
									var popData = line.data;
									var dataKey = new Array();
									var dataVal = new Array();

									$.each(line.data, function(keys1,data1) {
										var datetimeVal1 = keys1.split('-');
										var utcTime = Date.UTC(datetimeVal1[2],datetimeVal1[1]-1,datetimeVal1[0]);
										dataKey.push(parseInt(utcTime));
										dataVal.push(parseFloat(data1));
										
									});
								
								  var codeVal = line.features["hc-key"];
								  if(j===0)
								  {
									  defaultSelectSate = line.features["hc-key"];
								  }
								
									countries[codeVal] = {
											code3: codeVal,
											data: dataVal,
											dataKey: dataKey
									};
									
									var data = [];
									for (var code3 in countries) {
										if (countries.hasOwnProperty(code3)) {
										
											var value = null,
												year,
												itemData = countries[code3].data,
												itemKey = countries[code3].dataKey,
												i = itemData.length;
												
											while (i--) {
												if (typeof itemData[i] === 'float' || typeof itemData[i] === 'number') {
													value = itemData[i];
													year = categories[i];
													break;
												}
											}
											data.push({
												name: countries[code3].name,
												code3: code3,
												value: value,
												year: year
											});
										}
									}

                                     $('.highcharts-tracker').on('click', function(e){
											 console.log("Testing...");
											$(".spc_mapcon .nav_editab").addClass("active");
										    $("#info").addClass("active");
										  });									
					
					            
									Highcharts.wrap(Highcharts.Point.prototype, 'select', function (proceed) {
									
									proceed.apply(this, Array.prototype.slice.call(arguments, 1));
									
									var points = mapChart.getSelectedPoints();
									
								    var v ;
								    if (points.length)
									{
									
									         var statename = "";
									
									        var lenPoints = points.length;
									
											if (points.length === 1) {
												
												var gris_id = mapCommon.Conf.current_chart_codes[0].split("-");
												mapCommon.Conf.current_chart_codes = [];
												var gridStateId = mapCommon.Conf.current_chart_codes[0] = gris_id[0]+"-"+points[0].index;
												
												 statename = points[0].name;
												 stateData = statename;
												 $('#frm_input_download_map_state_'+mapCommon.Conf.chartIndex).attr('value',stateData);
												 $('#title_map_state_'+mapCommon.Conf.chartIndex).attr('value',mapCommon.Conf.mapTitle);
												 if (statenamevaleMore.length >0) {
													  statenamevaleMore = [];
												 }
												 
												$('#info #flag').attr('class', 'flag ' + points[0].flag);
												$('#info h1').html(points[0].name);
												
											}
											else
											{
												   
													var gris_id = mapCommon.Conf.current_chart_codes[0].split("-");
													for(v=0;v < lenPoints; v ++)
													{
														
														
														if(statenamevaleMore.indexOf(points[v].name)< 0)
														{
															// mapCommon.Conf.current_chart_codes[v] = gris_id[0]+"-"+points[v].index;
															 statenamevaleMore.push(points[v].name);
														}
														
														
														if(mapCommon.Conf.current_chart_codes.indexOf(gris_id[0]+"-"+points[v].index)< 0)
														{
															 mapCommon.Conf.current_chart_codes[v] = gris_id[0]+"-"+points[v].index;
														}
														
													}
												
												var stateData = statenamevaleMore.join();
												
												$('#frm_input_download_map_state_'+mapCommon.Conf.chartIndex).attr('value',stateData);
												$('#title_map_state_'+mapCommon.Conf.chartIndex).attr('value',mapCommon.Conf.mapTitle);
												$('#info #flag').attr('class', 'flag');
												$('#info h1').html('Comparing states');

											}
										
										//$('#info .subheader').html('<p><em>Shift + Click on map to compare states</em></p>');
								  
										if (!countryChart) {
											
										var pointIntUnit = "year";
										if(mapCommon.Conf.chart_data_type == "monthly")
										{
											var pointIntUnit = "month";	
										}
										
										
										var isBig  = window.matchMedia( "(min-width: 465px)" );
	
											if(isBig.matches)
											{
												var tooltipstyle={};
												
												var chartWidths = 260;
												var renderX = 93;
												var renderY = 377;
												var renderYsource = 385;
												
											}else{
												var tooltipstyle={ 
												//width: '100px'
												};
												
												var chartWidths = 179;
												
												var renderX = 53;
												var renderY = 277;
												var renderYsource = 285;
											}
																				
											
										 var	countryChart = new Highcharts.chart('state_chart_'+mapCommon.Conf.chartIndex, {
												chart: {
													height: 290,
													width:chartWidths,
													spacingLeft: 0
												},
												credits: {
													enabled: false
													/* href : 'http://indiamacroadviaord.com',
													text : 'indiamacroadvisors.com' */
												},
												title: {
													text: null
												},
												subtitle: {
													text: null
												},	
												xAxis: { 
													tickPixelInterval: 50,
													crosshair: true,
													type: 'datetime',
													labels: {
														style: {
															fontFamily: 'Tahoma'
														},
														rotation: -45
													}
													//categories: cateNewArray 
													/* tickInterval: 3 * 30 * 24 * 3600 * 1000,  */
													
												},
												yAxis: {
													gridLineWidth : 1.5, // The default value, no need to change it
													gridLineDashStyle: 'Dot',
													gridLineColor: '#999999',
													gridZIndex: -10,
													// offset : 10,
													opposite : false,
													labels : {
														align : 'right'
													    // y: 3
												},
												plotLines : [ {
													value : 0,
													color : 'black',
													dashStyle : 'shortdash',
													width : 1.5
												} ],
												title: {
													  text: null
													},
												},
												tooltip: {
													//shared: true
													useHTML: true,
													backgroundColor: null,
													padding:0,
													positioner: function () {
														return { x: 0, y: 205 };
													},
													followTouchMove: false,
													style: {}
												},
												exporting: { 
												enabled: false,
												chartOptions:{
													chart : {
														//	spacingBottom : 85,
														events : {
															load : function(){
																this.renderer.image(JMA.baseURL+'assets/images/logo.png', 10, 385, 150,10).add();
																this.renderer.text("Source : "+mapCommon.Conf.mapSource, 5, 375, 120, 10).css({size:'3px'}).add();
															}
														}
													},
													navigator:{
														enabled:false
													},
													scrollbar:{
														enabled : false
													},
													 tooltip: { enabled: false },
													legend : {
														enabled : true,
														backgroundColor : '#fffde1',
														//align: 'right',
                                                        verticalAlign: 'top',
														//itemWidth : position_legend_width_export,
														//x : position_legend_x_export,
														//align : aliMent,												
														itemStyle : {
															color : '#274b6d'
														},
														 x: 10,
                                                         y: 25
													},
													 title: {
																 text: mapCommon.Conf.mapTitle,
																 align: 'center'
															},
															xAxis: {
																
																type: 'datetime'
															},
															plotOptions: {
																series: {
																	animation: {
																		duration: 500
																	},
																	marker: {
																		enabled: false
																	},
																	pointStart: mapCommon.Conf.navigator_date_from,
																	pointIntervalUnit: pointIntUnit
																	//pointInterval: 24 * 3600 * 1000 * 31 // one day
																}
															}
												}
												},
												legend : {
													backgroundColor : '#fffde1',
														//align: 'right',
                                                        verticalAlign: 'top',
														//itemWidth : position_legend_width_export,
														//x : position_legend_x_export,
														//align : aliMent,												
														itemStyle : {
															color : '#274b6d'
														}
												},
												plotOptions: {
													series: {
														animation: {
															duration: 500
														},
														marker: {
															enabled: false
														},
														pointStart: mapCommon.Conf.navigator_date_from,
														pointIntervalUnit: pointIntUnit
														//pointInterval: 24 * 3600 * 1000 * 31 // one day
													}
												}
											}
										  , function (chart) {	
											//chart.renderer.image(JMA.baseURL+'assets/images/logo.png', 80, 288, 195, 12).add();
											/*  chart.renderer.text(mapCommon.Conf.mapTitle+'<br/> Source: '+mapCommon.Conf.mapSource, 80, 8)
											.css({
												fontSize: '12px'
											})
											 .add(); */
											// chart.setTitle({ text: 'New title '});
											 
											var someMillisecondValuefrom = mapCommon.Conf.navigator_date_from;
											var datefrom = new Date(someMillisecondValuefrom);
											var yearfrom = datefrom.getFullYear();
												 
											var someMillisecondValueto = mapCommon.Conf.navigator_date_to;
											var dateto = new Date(someMillisecondValueto);
											var yearto = dateto.getFullYear();
											
											chart.xAxis[0].setExtremes(
												mapCommon.Conf.navigator_date_from,
												mapCommon.Conf.navigator_date_to);  
										   });
										   
										  
											   
										   
										}
									
									
										$.each(points, function (i,points) {
											
											if (countryChart.series[i]) {
												countryChart.series[i].update({
													name: this.name,
													data: countries[points["hc-key"]].data,
													type: lenPoints > 1 ? 'line' : 'area'
												}, false);
											} else {
													countryChart.addSeries({
													name: this.name,
													data: countries[points["hc-key"]].data,
													type: lenPoints > 1 ? 'line' : 'area'
												}, false);
											}
											
											  
											
										});
										
										 while (countryChart.series.length > points.length) {
											countryChart.series[countryChart.series.length - 1].remove(false);
											
										 } 
									
									 
										  countryChart.redraw();
										 
										  if((j==mapCommon.Conf.stateJsonData.length-2 || j==mapCommon.Conf.stateJsonData.length-1) && typeof countryChart === 'object')
										  {
											  
											   if(j==mapCommon.Conf.stateJsonData.length-1)
											   {
												   JMA.JMAChart.Charts[mapCommon.Conf.chartIndex].chart_object = countryChart;
											   }
											   
											   chart_object_object = countryChart;
											   mapCommon.Conf.chartType = lenPoints > 1 ? 'arealine' : 'area'; 
											   mapCommon.Conf.selectStateKeys = lenPoints > 1 ? statenamevaleMore : statename; 
											   return chart_object_object;
										  }
									   
									
									} 
									else 
									{
										/* $('#info #flag').attr('class', '');
										$('#info h4').html('');
										$('#info .subheader').html('');
										if (countryChart) {
											countryChart = countryChart.destroy();
										} */
									}
								 });
					               
								//mapChart.get(defaultSelectSate).select();
									
					    });
						mapChart.get(defaultSelectSate).select();
		               return chart_object_object;
			}
			
			
			
		    this.drawJmaChart = function(){
				
				this.chart_object = this.createHighChart();
			};
			
			
			
			
			this.drawChart = function() {
				this.drawChartLayout();
				//alert("testchart")
				/* this.drawChartLayout();
				if(this.Conf.chartLayout == 'normal') {
					this.drawSeriesLayout();
				}
				this.drawJmaChart();
				this.initializeGraphDomelements(); */
				
				this.drawJmaChart();
				
			};
}

// Class chartCommon
function chartCommon(p_chartIndex, chartDetails){
		
	this.Conf = {
		chartType : '',
		chartIndex : null,
		view_option : '',
		chartColor : [],
		chartColorSeries : [],
		chartColorSatus : false,
		mychartchartColor : [],
		color_series : [],
		color_status : false,
		commonColorCode : [[],[],[],[],[],[],[],[]],
		mychart_color_code : [[],[],[],[]],
		isChartTypeSwitchable : 'Y',
		isPremiumData : false,
		chartLayout : 'normal',
		isNavigator : true,
		chartExport : {},
		chart_actual_code : '',
		chart_data_type : 'monthly',
		current_chart_codes : [],
		chart_labels_available : [],
		charts_available : [],
		charts_codes_available : [],
		charts_fields_available : [],
		navigator_date_from : '',
		navigator_date_to : '',
		share_chart : {
			share_page_url : '',
			dateRange_from : '',
			dateRange_to : ''
		},
		sources : '',
		chartData : {}
	};
	this.chartConfigs = {
		colors : [ '#316AB4', '#E60013', '#FF9900', '#910000',
		'#1aadce', '#492970', '#f28f43', '#77a1e5',
		'#c42525', '#a6c96a' ]
	};


	this.chart_object = null;
	this.chartLayoutData = {'chart_details' : {}, 'series_details' : {}, 'mychart_details' : {}};
	this.dominitialize = function(){
		
	};
	
	this.formatData = function(ap_data){
		var out_data = {};
		$.each(ap_data,function(graph_code,data_rows){
			var p_data_rows = new Array();
			$.each(data_rows,function(ky,row){
				var datetimeVal = row[0].split('-');
				var utcTime = Date.UTC(datetimeVal[2],datetimeVal[1]-1,datetimeVal[0]);
				var float_value = row[1] == null ? null : parseFloat(row[1]);
				p_data_rows[ky] = [utcTime,float_value];
			});
			out_data[graph_code] = p_data_rows;
		});
		return out_data;
	}
	
	
	
	
	// Set all Chart configurations
	this.setAllConfigurations = function(p_chartIndex,p_configs){
		this.Conf.chartType = p_configs.chart_config.chartType;
		this.Conf.chartIndex = p_chartIndex;
		this.Conf.isPremiumData = p_configs.isPremiumData;
		this.Conf.chartLayout = p_configs.chart_config.chartLayout;
		this.Conf.isNavigator = p_configs.chart_config.isNavigator;
		this.Conf.chartExport = p_configs.chart_config.chartExport;
		this.Conf.chart_actual_code = p_configs.chart_actual_code;
		this.Conf.mychartchartColor = p_configs.color_code;
		this.Conf.color_series = p_configs.color_series;
		this.Conf.color_status = typeof(p_configs.color_status === undefined )? 'true' : p_configs.color_status;
		this.Conf.mychart_color_code = p_configs.mychart_color_code;
		this.Conf.chart_data_type = p_configs.chart_data_type;
		this.Conf.current_chart_codes = p_configs.current_chart_codes;
		this.Conf.chart_labels_available = p_configs.chart_labels_available;
		this.Conf.charts_codes_available = p_configs.charts_codes_available;
		this.Conf.charts_available = p_configs.charts_available;
		this.Conf.charts_fields_available = p_configs.charts_fields_available;
		this.Conf.share_chart.share_page_url = p_configs.share_page_url;
		this.Conf.share_chart.dateRange_from = p_configs.navigator_date_from;
		this.Conf.share_chart.dateRange_to = p_configs.navigator_date_to;
		var js_dateRange_from = p_configs.navigator_date_from.split('-');
		var js_dateRange_to = p_configs.navigator_date_to.split('-');
		this.Conf.navigator_date_from = Date.UTC(js_dateRange_from[2],js_dateRange_from[1]-1,js_dateRange_from[0]);
		this.Conf.navigator_date_to = Date.UTC(js_dateRange_to[2],js_dateRange_to[1]-1,js_dateRange_to[0]);
		this.Conf.sources = p_configs.sources;
		this.Conf.chartData = this.formatData(p_configs.chart_data);
	};
	
	
	
	// Copy configuration sets
	this.copyThisConfigurations = function(p_configs){
		this.Conf = p_configs;
	};
	// Get all configurations
	this.getAllConfigurations = function(){
		return this.Conf;		
	};
	
	
	// All data sets
	this.data = {};
	// Create chart layout data sets
	this.createChartLayoutData = function(mobileView){
		var mychart_folder_list = Object.create(JMA.myChart_folders);
		console.log(mychart_folder_list);
		var folderList = [];
		try{
			if(typeof(JMA.userDetails.user_permissions)=='object'){
				folderList = typeof(mychart_folder_list) == 'object' ? mychart_folder_list.splice(0,JMA.userDetails.user_permissions.mychart.totalFolders) : [];
			}
		}catch (e){
			
		}
		this.chartLayoutData['chart_details'] = {
			chartIndex : this.Conf.chartIndex,
			isRightPannel : (this.Conf.chartLayout == 'narrow') ? false : true,
			mobileResponsive : mobileView ? true : false
		};
		if(JMA.controller == "mycharts"){
			this.chartLayoutData['mychart_details'] = {
				'isMyChart' : true,
				'folderList' : folderList
			};
		}else{
			this.chartLayoutData['mychart_details'] = {
				'isMyChart' : false,
				'folderList' : folderList
			};
		}
	};
	
	// Create consolidated series layout data
	this.createSeriesLayoutData = function(){
		this.chartLayoutData['series_details'] = {
			chartIndex : this.Conf.chartIndex,
			current_series : this.createCurrentSeriesDropdownData(),
			available_series : this.createAvailableSeriesDropdownData(),
			isMultiAxis : this.Conf.chartType == 'multiaxisline' ? true : false,
			isBarChart : this.Conf.chartType == 'bar' ? true : false,
			isAddMoreseries : this.Conf.current_chart_codes.length < 3 ? true : false
		}
	};
	
	// Create Current series dropdown data
	this.createCurrentSeriesDropdownData = function(){
		var thisChart = this;
		var current_series = [];
		$.each(thisChart.Conf.current_chart_codes,function(idx,code){
			var current_label_arr = thisChart.Conf.chart_labels_available[code].split(' - ');
			var current_label_main = current_label_arr[0];
			var current_label_sub = current_label_arr[1];
			var current_chartcode_arr = code.split('-');
			var current_chartcode_main = current_chartcode_arr[0];
			var series = [];
			$.each(thisChart.Conf.charts_fields_available[current_chartcode_main],function(label_main,sub_labels){
				var series_sub = [];
				$.each(sub_labels,function(label_sub,code){
					var isCurrent = false;
					if(label_main == current_label_main && label_sub == current_label_sub){
						isCurrent = true;
					}
					var ser_lab_data_sub = {
						'code' : code,
						'label' : label_sub,
						'isCurrent' : isCurrent
					};
					series_sub.push(ser_lab_data_sub);
				})
				var main_isCurrent = false;
				if(label_main == current_label_main){
					main_isCurrent = true;
				}
				var ser_lab_data = {
					'code' : current_chartcode_main,
					'label' : label_main,
					'series' : series_sub,
					'isCurrent' : main_isCurrent
				};
				series.push(ser_lab_data);
			})
			var current_series_data = {
				'code' : current_chartcode_main,
				'label' : thisChart.Conf.charts_available[current_chartcode_main],
				'series' : series
			}
			current_series.push(current_series_data);
		})
return current_series;
};


	// Pupulate Y-Sub data for y index
	this.populateYSubDropdownData = function(p_code_idx,y_idx){
		var y_sub_array = new Array();
		var thisChart = this;
		$.each(thisChart.chartLayoutData.series_details.current_series[p_code_idx].series[y_idx].series,function(ky,optionArObj){
			var op_dw_obj = {
				'code' : optionArObj.code,
				'label' : optionArObj.label
			};
			y_sub_array.push(op_dw_obj);
		});
		return y_sub_array;
	};
	
	// Create Available series dropdown data
	this.createAvailableSeriesDropdownData = function(){
		var available_series = [];
		var thisChart = this;
		$.each(thisChart.Conf.charts_codes_available,function(c_idx,c_code){
			var series = [];
			$.each(thisChart.Conf.charts_fields_available[c_code],function(label_main,sub_labels){

				var series_sub = [];
				$.each(sub_labels,function(label_sub,code){
					var ser_lab_data_sub = {
						'code' : code,
						'label' : label_sub,
						'isCurrent' : false
					};
					series_sub.push(ser_lab_data_sub);
				})
				var ser_lab_data = {
					'code' : c_code,
					'label' : label_main,
					'series' : series_sub,
					'isCurrent' : false
				}
				
				series.push(ser_lab_data);
			})
			var available_series_data = {
				'code' : c_code,
				'label' : thisChart.Conf.charts_available[c_code],
				'series' : series
			}
			available_series.push(available_series_data);
		})

		return available_series;
	};
	
	// Draw chart Layout
	this.drawChartLayout = function(mobileView){
		
		this.createChartLayoutData(mobileView);		
		var chart_template_object = Handlebars.compile($('#template_graph_full').html());
		var chart_template = chart_template_object(this.chartLayoutData);
		if(mobileView == true && JMA.controller != "mycharts")
		{
			$('.Chart_Dv_placeholder_mobile').html(chart_template);
		}
		else
		{
			$('#Chart_Dv_placeholder_'+this.Conf.chartIndex).html(chart_template);
		}
		
	};
	
	// Draw series layout
	this.drawSeriesLayout = function(){
		this.createSeriesLayoutData();
		var series_placeholder = "Dv_dataseries_"+this.Conf.chartIndex;
		var series_template_object = Handlebars.compile($('#template_graph_section_series').html());
		var series_template = series_template_object(this.chartLayoutData.series_details);
		
		$('#'+series_placeholder).html(series_template);
	};
	
	// replace a chart code
	this.replaceCurrentGraphCode = function(p_code_idx,p_series_code){
		this.Conf.current_chart_codes[p_code_idx] = p_series_code;
	};
	
	// add new chart code
	this.addThisToCurrentGraphCode = function(p_series_code){
		this.Conf.current_chart_codes.push(p_series_code);
	};
	
	// remove chart code by index
	this.removeThisChartCodeByIndex = function(p_chart_code_idx){
		this.Conf.current_chart_codes.splice(p_chart_code_idx,1);
	};
	// Update common share url
	this.updateCommonShareURL = function(){
		var new_url = this.Conf.share_chart.share_page_url;
		$('#common_share_url').val(new_url);
	}
	// Update chart share url
	this.updateChartShareURL = function(min,max){
		var js_min_date = new Date(min);
		var js_max_date = new Date(max);
		this.Conf.share_chart.dateRange_from = js_min_date.getDate()+'-'+(js_min_date.getMonth()+1)+'-'+js_min_date.getFullYear();
		this.Conf.share_chart.dateRange_to = js_max_date.getDate()+'-'+(js_max_date.getMonth()+1)+'-'+js_max_date.getFullYear();
		var new_url = this.Conf.share_chart.share_page_url+'?gids='+this.Conf.current_chart_codes.join('|')+'&graph_index='+this.Conf.chartIndex+'&graph_type='+this.Conf.chartType+'&graph_data_from='+this.Conf.share_chart.dateRange_from+'&graph_data_to='+this.Conf.share_chart.dateRange_to;
		$('#graph_share_url_'+this.Conf.chartIndex).val(new_url);
	};
	
	// initialize / reinitialize all graph dom elements
	this.initializeGraphDomelements = function(){
		
		// initialize graph share
		$.each($('a.share'),function(elm,elmObject){
			$(elmObject).on('click',(function(event){
				var link_input_id = $(this).attr('link_input_id');
				var sType = $(this).attr('stype');
				var share_href = $('#'+link_input_id).val();
				JMA.JMAChart.showGraphShare(share_href,event,sType);
			}));
		});
	};
	
	// Chart Tick positioner
	this.generateChartTickPositions = function(vMin,vMax){
		var positions = [];
		var quarters = [2,5,8,11];
		var min_year = Highcharts.dateFormat('%Y', vMin);
		var max_year = Highcharts.dateFormat('%Y', vMax);
		var max_quarter = Math.floor(Highcharts.dateFormat('%m', vMax)/3);
		var min_quarter = Math.floor(Highcharts.dateFormat('%m', vMin)/3);
		var period_diff = max_year - min_year;
		var new_tick;
	   	 // var utcTime = Date.UTC(datetimeVal[2],datetimeVal[1]-1,datetimeVal[0]);
	   	 if(period_diff <=2){
	   	 	for(var year_count = min_year; year_count<=max_year;year_count++){
	   	 		for(var qu_count=min_quarter;qu_count<4;qu_count++){
	   	 			new_tick = Date.UTC(year_count,quarters[qu_count],1);
	   	 			if(year_count == max_year){
	   	 				if(qu_count<=max_quarter){
	   	 					positions.push(new_tick);
	   	 				}
	   	 			}else{
	   	 				positions.push(new_tick);
	   	 			}
	   	 		}
	   	 		min_quarter = 0;
	   	 	}

	   	 }else if(period_diff<=8){
	   	 	for(var year_count = min_year; year_count<=max_year;year_count++){
	   	 		new_tick = Date.UTC(year_count,1,1);
	   	 		positions.push(new_tick);
	   	 	}
	   	 }else{
	   	 	var interval = (Math.floor(period_diff / 8)) * 31556952000;
	   	 	for(var t_vMin = vMin; t_vMin<=vMax; t_vMin+=interval){
	   	 		new_tick = Date.UTC(Highcharts.dateFormat('%Y', t_vMin),1,1);
	   	 		positions.push(new_tick);
	   	 	}
	   	 }
	   	 return positions;
	   	};

	/**
	 * Function - createChartCodeFromConfig
	 * Function to create chart code from configuration items. It accomodates all changes done on chart
	 */
	 this.createChartCodeFromConfig = function(){
	 	var date_from = new Date(this.Conf.navigator_date_from);
	 	var date_to = new Date(this.Conf.navigator_date_to);
	 	var chartCode = "{graph "+this.Conf.current_chart_codes.toString()+"|"+this.Conf.charts_codes_available.toString()+"|";
	 	if(this.Conf.chart_data_type != 'anual'){
	 		chartCode+=date_from.getFullYear()+"-"+(date_from.getMonth()+1)+","+date_to.getFullYear()+"-"+(date_to.getMonth()+1);
	 	}else{
	 		chartCode+=date_from.getFullYear()+","+date_to.getFullYear();
	 	}
	 	var chartConfigurations = "{chartLayout:'"+this.Conf.chartLayout+"',chartType:'"+this.Conf.chartType+"',dataType:'"+this.Conf.chart_data_type+"',isMultiaxis:"+(this.Conf.chartType == 'multiaxisline' ? true : false)+",isChartTypeSwitchable:'"+this.Conf.isChartTypeSwitchable+"',isNavigator:"+this.Conf.isNavigator+"}";
	 	return chartCode+chartConfigurations+"}";
	 };
	 
	 this.createIndividualColorPicker = function()
	 {
		if(this.Conf.chartColorSatus == 'true' || this.Conf.color_status == 'true')
		{
		   $( ".basicsss1" ).each(function( index ) {
			
			 var $div = $(this);
			 var indexChart = $div.attr('data-param1');
			 var indexChart1 = $div.attr('data-param2');
		  
					$('.basicsss1:eq('+index+')').spectrum({color: '#316AB4',showInput: true,className: 'full-spectrum',clickoutFiresChange: false ,
								showInitial: true,showPalette: true,showSelectionPalette: true,maxSelectionSize: 10,preferredFormat: 'hex',
								move: function (color) {
									
								},
								show: function () {
								
								},
								beforeShow: function () {
								
								},
								hide: function () {
								
								},
								change: function(color) {
									  var codeColor = $('.sp-input:eq('+index+')').val();	
									  //console.log(color.toHexString());
									  var numItems = $('.sp-input').length;
									  JMA.JMAChart.Charts[indexChart].chartConfigs.colors[indexChart1] = color.toHexString();
									  JMA.JMAChart.replaceColorofChartForIndicator(indexChart,color.toHexString(),indexChart1);
								},
								palette: [
									['rgb(0, 0, 0)', 'rgb(67, 67, 67)', 'rgb(102, 102, 102)','rgb(217, 217, 217)','rgb(255, 255, 255)'],
									['rgb(152, 0, 0)', 'rgb(255, 0, 0)', 'rgb(255, 153, 0)', 'rgb(255, 255, 0)', 'rgb(0, 255, 0)'],
									['rgb(0, 255, 255)', 'rgb(74, 134, 232)', 'rgb(0, 0, 255)', 'rgb(153, 0, 255)', 'rgb(255, 0, 255)'],
									['rgb(230, 184, 175)', 'rgb(244, 204, 204)', 'rgb(252, 229, 205)', 'rgb(255, 242, 204)', 'rgb(217, 234, 211)'],
									['rgb(204, 65, 37)', 'rgb(224, 102, 102)', 'rgb(246, 178, 107)', 'rgb(255, 217, 102)', 'rgb(147, 196, 125)'],
									['rgb(118, 165, 175)', 'rgb(109, 158, 235)', 'rgb(111, 168, 220)', 'rgb(142, 124, 195)', 'rgb(194, 123, 160)'],
									['rgb(166, 28, 0)', 'rgb(204, 0, 0)', 'rgb(230, 145, 56)', 'rgb(241, 194, 50)', 'rgb(106, 168, 79)'],
									['rgb(91, 15, 0)', 'rgb(102, 0, 0)', 'rgb(127, 96, 0)', 'rgb(39, 78, 19)','#eecccc']
								]
					  });
				    });
		     }
	 };
	 
	 
	 
	}
	
	
	
	
	
	
function creativeTableOnIndicatorPage(chart_data_series,chartDetails)
{
	
	this.enableSwitchingChartToTable = function()
	{
		$('body').on('click','.exhibit-tab-footer_'+chartDetails.Conf.chartIndex+' li', function(e) {
				e.preventDefault();
				e.stopPropagation();
				var view = $(this).data('view');
			    var chartOrder = $(this).data('order');
				var $exhibit = $(this).closest('.exhtabs_charts');
				
				$exhibit.find('.exhibit-tab-footer_'+chartDetails.Conf.chartIndex+' li').removeClass('selected');

				
				
				if(view == "data")
				{
					$(this).addClass('selected');
					var dataTable_container = '#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex;
					var small_div='';
	 		        var dynamictd=82;
					if(chartDetails.Conf.chartData !=null) {
						
						var myObject = chartDetails.Conf.chartData;
						var count = Object.keys(myObject).length;
                        
						
						var out = '<table cellspacing="0" cellpadding="0" class="mychart_table fixed_headers table table-striped"><thead><tr><th>Date</th>';
						var out_data = '';
						var data_formated = [];
						var column_width = dynamictd/count;
						
						$.each(chartDetails.Conf.chartData,function(order,series){
							
							out+="<th width='"+column_width+"%'>"+chartDetails.Conf.chart_labels_available[order]+"</th>";
							$.each(series,function(i_order,dataset){
								
								datasets = dataset[0];
								if(Array.isArray(data_formated[i_order]) == true){

									data_formated[i_order].push(dataset[1]);
								}
								else
								{
									
									if(chartDetails.Conf.chart_data_type == 'monthly'){
										var dte = Highcharts.dateFormat('%b',datasets)+" "+Highcharts.dateFormat('%Y',datasets);
									}else if(chartDetails.Conf.chart_data_type == 'quaterly'){
										if (Highcharts.dateFormat('%b', datasets) == 'Mar') {
											var dte = "Q1 "+Highcharts.dateFormat('%Y',datasets);
										}
										if (Highcharts.dateFormat('%b', datasets) == 'Jun') {
											var dte = "Q2 "+Highcharts.dateFormat('%Y',datasets);
										}
										if (Highcharts.dateFormat('%b', datasets) == 'Sep') {
											var dte = "Q3 "+Highcharts.dateFormat('%Y',datasets);
										}
										if (Highcharts.dateFormat('%b', datasets) == 'Dec') {
											var dte = "Q4 "+Highcharts.dateFormat('%Y',datasets);
										}
										
										
									}else if(chartDetails.Conf.chart_data_type == 'anual'){
										
										var dte = Highcharts.dateFormat('%Y',datasets);
									}else if(chartDetails.Conf.chart_data_type == 'daily'){
										var dte = Highcharts.dateFormat('%e',datasets)+" "+Highcharts.dateFormat('%b', datasets)+", "+Highcharts.dateFormat('%Y',datasets);
									}
									data_formated[i_order] = [dte,dataset[1]];
								}
								
								
							});
							
							
						
							
						});
						
						
						    out+="</tr></thead><tbody>";
							$.each(data_formated,function(i_order,data_for_table){
								out_data+="<tr>";
								$.each(data_for_table,function(ii_count,data_cell){
									if(ii_count == 0) {
										out_data+="<td>"+(data_cell == null ? '-' : data_cell)+"</td>";
									}else{
										out_data+="<td width='"+column_width+"%'>"+(data_cell == null ? '-' : data_cell)+"</td>";
									}
								});
								out_data+="</tr>";
							});
							out_data+="</tbody>";
							out+=out_data;
						
						
					}
					else
					{
							var out = "";
					}
					$('.h_graph_content_area_'+chartDetails.Conf.chartIndex).hide();
					//$('#footer_chart_dataDoenload_'+chartDetails.Conf.chartIndex).show();
					
					
					$(dataTable_container).html(out);
					$(dataTable_container).find('tbody').animate({
						scrollTop:999999
					}, 50);
					
					
			}
		    else {
				
				    $(this).addClass('selected');
					$('.h_graph_content_area_'+chartDetails.Conf.chartIndex).show();
					$('#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex).empty();
					//$('#footer_chart_dataDoenload_'+chartDetails.Conf.chartIndex).hide();
				}		
		});
		
	    
		
		if($('.h_graph_content_area_'+chartDetails.Conf.chartIndex).css('display') == 'none')
		{ 
	           

                 	var dataTable_container = '#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex;
					var small_div='';
	 		        var dynamictd=82;
					if(chartDetails.Conf.chartData !=null) {
						
						var myObject = chartDetails.Conf.chartData;
						var count = Object.keys(myObject).length;
                        
						
						var out = '<table cellspacing="0" cellpadding="0" class="mychart_table fixed_headers table table-striped"><thead><tr><th>Date</th>';
						var out_data = '';
						var data_formated = [];
						var column_width = dynamictd/count;
						
						$.each(chartDetails.Conf.chartData,function(order,series){
							
							out+="<th width='"+column_width+"%'>"+chartDetails.Conf.chart_labels_available[order]+"</th>";
							$.each(series,function(i_order,dataset){
								
								datasets = dataset[0];
								if(Array.isArray(data_formated[i_order]) == true){

									data_formated[i_order].push(dataset[1]);
								}
								else
								{
									
									if(chartDetails.Conf.chart_data_type == 'monthly'){
										var dte = Highcharts.dateFormat('%b',datasets)+" "+Highcharts.dateFormat('%Y',datasets);
									}else if(chartDetails.Conf.chart_data_type == 'quaterly'){
										if (Highcharts.dateFormat('%b', datasets) == 'Mar') {
											var dte = "Q1 "+Highcharts.dateFormat('%Y',datasets);
										}
										if (Highcharts.dateFormat('%b', datasets) == 'Jun') {
											var dte = "Q2 "+Highcharts.dateFormat('%Y',datasets);
										}
										if (Highcharts.dateFormat('%b', datasets) == 'Sep') {
											var dte = "Q3 "+Highcharts.dateFormat('%Y',datasets);
										}
										if (Highcharts.dateFormat('%b', datasets) == 'Dec') {
											var dte = "Q4 "+Highcharts.dateFormat('%Y',datasets);
										}
										
										
									}else if(chartDetails.Conf.chart_data_type == 'anual'){
										
										var dte = Highcharts.dateFormat('%Y',datasets);
									}else if(chartDetails.Conf.chart_data_type == 'daily'){
										var dte = Highcharts.dateFormat('%e',datasets)+" "+Highcharts.dateFormat('%b', datasets)+", "+Highcharts.dateFormat('%Y',datasets);
									}
									data_formated[i_order] = [dte,dataset[1]];
								}
								
								
							});
							
							
						
							
						});
						
						
						    out+="</tr></thead><tbody>";
							$.each(data_formated,function(i_order,data_for_table){
								out_data+="<tr>";
								$.each(data_for_table,function(ii_count,data_cell){
									if(ii_count == 0) {
										out_data+="<td>"+(data_cell == null ? '-' : data_cell)+"</td>";
									}else{
										out_data+="<td width='"+column_width+"%'>"+(data_cell == null ? '-' : data_cell)+"</td>";
									}
								});
								out_data+="</tr>";
							});
							out_data+="</tbody>";
							out+=out_data;
						
						
					}
					else
					{
							var out = "";
					}
					
					$('.h_graph_content_area_'+chartDetails.Conf.chartIndex).hide();
					//$('#footer_chart_dataDoenload_'+chartDetails.Conf.chartIndex).show();
					
					
					$(dataTable_container).html(out);
					$(dataTable_container).find('tbody').animate({
						scrollTop:999999
					}, 50);
					
					
		}
	}
	
	this.enableSwitchingChartToTableOnDefault = function()
	{
			if(chartDetails.Conf.view_option == 'table'){
			var dataTable_container = '#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex;
			var small_div='';
			var dynamictd=82;
			if(chartDetails.Conf.chartData !=null) {
				
				var myObject = chartDetails.Conf.chartData;
				var count = Object.keys(myObject).length;
				
				
				var out = '<table cellspacing="0" cellpadding="0" class="mychart_table fixed_headers table table-striped"><thead><tr><th>Date</th>';
				var out_data = '';
				var data_formated = [];
				var column_width = dynamictd/count;
				
				$.each(chartDetails.Conf.chartData,function(order,series){
					
					out+="<th width='"+column_width+"%'>"+chartDetails.Conf.chart_labels_available[order]+"</th>";
					$.each(series,function(i_order,dataset){
						
						datasets = dataset[0];
						if(Array.isArray(data_formated[i_order]) == true){

							data_formated[i_order].push(dataset[1]);
						}
						else
						{
							
							if(chartDetails.Conf.chart_data_type == 'monthly'){
								var dte = Highcharts.dateFormat('%b',datasets)+" "+Highcharts.dateFormat('%Y',datasets);
							}else if(chartDetails.Conf.chart_data_type == 'quaterly'){
								if (Highcharts.dateFormat('%b', datasets) == 'Mar') {
									var dte = "Q1 "+Highcharts.dateFormat('%Y',datasets);
								}
								if (Highcharts.dateFormat('%b', datasets) == 'Jun') {
									var dte = "Q2 "+Highcharts.dateFormat('%Y',datasets);
								}
								if (Highcharts.dateFormat('%b', datasets) == 'Sep') {
									var dte = "Q3 "+Highcharts.dateFormat('%Y',datasets);
								}
								if (Highcharts.dateFormat('%b', datasets) == 'Dec') {
									var dte = "Q4 "+Highcharts.dateFormat('%Y',datasets);
								}
								
								
							}else if(chartDetails.Conf.chart_data_type == 'anual'){
								
								var dte = Highcharts.dateFormat('%Y',datasets);
							}else if(chartDetails.Conf.chart_data_type == 'daily'){
								var dte = Highcharts.dateFormat('%e',datasets)+" "+Highcharts.dateFormat('%b', datasets)+", "+Highcharts.dateFormat('%Y',datasets);
							}
							data_formated[i_order] = [dte,dataset[1]];
						}
						
						
					});
					
					
				
					
				});
				
				
					out+="</tr></thead><tbody>";
					$.each(data_formated,function(i_order,data_for_table){
						out_data+="<tr>";
						$.each(data_for_table,function(ii_count,data_cell){
							if(ii_count == 0) {
								out_data+="<td>"+(data_cell == null ? '-' : data_cell)+"</td>";
							}else{
								out_data+="<td width='"+column_width+"%'>"+(data_cell == null ? '-' : data_cell)+"</td>";
							}
						});
						out_data+="</tr>";
					});
					out_data+="</tbody>";
					out+=out_data;
				
				
			}
			else
			{
					var out = "";
			}

			$('.h_graph_content_area_'+chartDetails.Conf.chartIndex).hide();
			//$('#footer_chart_dataDoenload_'+chartDetails.Conf.chartIndex).show();


			$(dataTable_container).html(out);
			$(dataTable_container).find('tbody').animate({
				scrollTop:999999
			}, 50);
		}
	}
	
	this.mobilelegent = function()
	{
		var legendSeries = '<ul class="list-fontawesome">';
		$.each(chart_data_series,function(details, data){
			var seriesData = data['data'];
			var dateTimeOfSeries = "";
			var defaultLegent = false;
			console.log(chartDetails.Conf.chartIndex);
			var result = seriesData.filter(function( obj ) {
				if(obj[0]==chartDetails.Conf.navigator_date_to && obj[1] != null)
				{ 
			        defaultLegent = true;
					var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
					var m = (new Date(obj[0])).getMonth();
					if(chartDetails.Conf.chart_data_type == "anual")
					{
						dateTimeOfSeries = (new Date(obj[0])).getFullYear();
					}
					else
					{
						if (chartDetails.Conf.chart_data_type == 'quaterly') 
						{
							if(monthNames[m] == 'Mar')
							{
								dateTimeOfSeries = " Q1 - " +(new Date(obj[0])).getFullYear();
							}
							else if(monthNames[m] == 'Jun')
							{
								dateTimeOfSeries = "Q2 - " +(new Date(obj[0])).getFullYear();
							}
							else if(monthNames[m] == 'Sep')
							{
								dateTimeOfSeries = "Q3 - " +(new Date(obj[0])).getFullYear();
							}
							else if(monthNames[m] == 'Dec')
							{
								dateTimeOfSeries = "Q4 - " +(new Date(obj[0])).getFullYear();
							}
						}
						else
						{
							dateTimeOfSeries = monthNames[m] + " - " +(new Date(obj[0])).getFullYear();
						}
					}
					
					legendSeries+='<li><span class="hgl_ttl" style="color:'+chartDetails.chartConfigs.colors[details]+';">'+data['name']+'</span> <span><span class="hgl_date legentSeriesDate_'+chartDetails.Conf.chartIndex+'_'+details+'">'+dateTimeOfSeries+'</span></br><span class="legentSeriesDegault_'+chartDetails.Conf.chartIndex+'_'+details+'">'+obj[1]+'</span></span></li>';
					
				}
				
			  
			});
			if(defaultLegent == false)
			{
				var len = seriesData.length;
				var newLastData;
				for(i = 1; i < len; i++)
				{
					var lastData = seriesData.slice(-i)[0];
					if(lastData[1] != null)
					{
						lastData = lastData;
						break;
					}
				}
				
				var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
				var m = (new Date(lastData[0])).getMonth();
				if(chartDetails.Conf.chart_data_type == "anual")
				{
					dateTimeOfSeries = (new Date(lastData[0])).getFullYear();
				}
				else
				{
					if (chartDetails.Conf.chart_data_type == 'quaterly') 
						{
							if(monthNames[m] == 'Mar')
							{
								dateTimeOfSeries = " Q1 - " +(new Date(lastData[0])).getFullYear();
							}
							else if(monthNames[m] == 'Jun')
							{
								dateTimeOfSeries = "Q2 - " +(new Date(lastData[0])).getFullYear();
							}
							else if(monthNames[m] == 'Sep')
							{
								dateTimeOfSeries = "Q3 - " +(new Date(lastData[0])).getFullYear();
							}
							else if(monthNames[m] == 'Dec')
							{
								dateTimeOfSeries = "Q4 - " +(new Date(lastData[0])).getFullYear();
							}
						}
						else
						{
							dateTimeOfSeries = monthNames[m] + " - " +(new Date(lastData[0])).getFullYear();
						}
				}

				legendSeries+='<li> <span class="hgl_ttl" style="color:'+chartDetails.chartConfigs.colors[details]+';">'+data['name']+'</span> <span><span class="hgl_date legentSeriesDate_'+chartDetails.Conf.chartIndex+'_'+details+'">'+dateTimeOfSeries+'</span></br><span class="legentSeriesDegault_'+chartDetails.Conf.chartIndex+'_'+details+'">'+lastData[1]+'</span></span></li>';
			
			}
			
		})
		
		legendSeries+='</ul>';
		
		$('#hgca_legends_'+chartDetails.Conf.chartIndex).html(legendSeries);
	}
	
	
}


//Class LineChart
function LineChart(p_chartIndex, chartDetails) {
	var chartCommon = this;
	this.setConfigurations = function(){
		
	};    

	this.createChartDataSeries = function() {
		var chartDataSeries = [];
		var chart_series_count = 0;
		
		   chartCommon.createIndividualColorPicker();
			 
			var d = 0;
			
			
		  $.each(chartCommon.Conf.chartData, function(chartcode, chart_data_col) {
				
				if(chartCommon.Conf.chartColor.hasOwnProperty(d))
				{
					chartCommon.chartConfigs.colors[d] = chartCommon.Conf.chartColor[d];
				}
				else if(typeof chartCommon.Conf.mychartchartColor !== "undefined")
			    {
					
					   $.each(chartCommon.Conf.chartColor,function(idx){
							
							if(chartCommon.Conf.chartColor[idx] === undefined)
							{
							}
							else
							{
								chartCommon.Conf.mychartchartColor[idx] = chartCommon.Conf.chartColor[idx];
							}
						});
						
						
						if(chartCommon.Conf.mychartchartColor[d])
						{
							chartCommon.chartConfigs.colors[d] = chartCommon.Conf.mychartchartColor[d];
						}
						
				}	
				
				chartDataSeries[chart_series_count] = {
					name : chartCommon.Conf.chart_labels_available[chartcode],
					data : chart_data_col,
					
				}
			
			chart_series_count++;
			d++;
		});
		return chartDataSeries;
	}

this.createHighChart = function(chart_data_series,mobileView) {
    var toolTipYvalue = 205;
	if(chartCommon.Conf.current_chart_codes.length > 1)
	{
		toolTipYvalue = 130;
	}	

	var isBig  = window.matchMedia( "(min-width: 767px)" );
	
	if(isBig.matches)
	{
		var tooltipstyle={};
		
		var chartHeight = 400;
		var renderX = 93;
		var renderY = 377;
		var renderYsource = 385;
		
	}else{
		var tooltipstyle={ 
		//width: '100px'
		};
		
		var chartHeight = 300;
		
		var renderX = 53;
		var renderY = 277;
		var renderYsource = 285;
	}
       
        

		
		var graph_containerID = '#'+graph_container;
		var position_legend_x = 17;
		var position_legend_width = 527;
		var position_legend_x_export = 17;
		var position_legend_width_export = 547;
		if (this.Conf.chart_data_type == 'quaterly') {

			var xAxis = {
				//	ordinal:false,
				minRange: 1,
				gridLineWidth : 0, // New value
				events : {
					setExtremes : function(e) {
						chartCommon.Conf.navigator_date_from = e.min;
						chartCommon.Conf.navigator_date_to = e.max;
						chartCommon.updateChartShareURL(e.min,e.max);
						chartCommon.updateCommonShareURL();
						// changeShare(index);
					}
				},
				labels : {
					showFirstLabel: true,
					showLastLabel: true,
					style: tooltipstyle,
					//format : '{value}'
					formatter : function() {
						var s = "";
						if (Highcharts.dateFormat('%b', this.value) == 'Mar') {
							s = s + "Q1"
						};
						if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
							s = s + "Q2"
						};
						if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
							s = s + "Q3"
						};
						if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
							s = s + "Q4"
						};
						s = s + " " + Highcharts.dateFormat('%Y', this.value);
						return s;
					}
				},
				tickInterval: 3 * 30 * 24 * 3600 * 1000, 
				type: 'datetime',
	          //  startOnTick : true,
	          tickPositioner: function (vMin,vMax) {
	          	return chartCommon.generateChartTickPositions(vMin,vMax);
	          }
	        };

	        var toolTip = {
	        	formatter: function () {
	        		var s = '<b>';
	        		if (Highcharts.dateFormat('%b', this.x) == 'Mar') {
	        			s = s + "Q1"
	        		};
	        		if (Highcharts.dateFormat('%b', this.x) == 'Jun') {
	        			s = s + "Q2"
	        		};
	        		if (Highcharts.dateFormat('%b', this.x) == 'Sep') {
	        			s = s + "Q3"
	        		};
	        		if (Highcharts.dateFormat('%b', this.x) == 'Dec') {
	        			s = s + "Q4"
	        		};
	        		s = s + " " + Highcharts.dateFormat('%Y', this.x) + '</b>';


	        		$.each(this.points, function (i, point) {
	        			var symbol = '<span style="color:' + point.series.color + '">●</span>';
	        			s += '<br/>' +symbol+ point.series.name + ': '+point.y;
	        		});
	        		return s;
	        	},
	        	shared: true,
	        	followTouchMove: false,
	        	useHTML: true,
	        	backgroundColor: null,
	        	borderWidth: 0,
	        	shadow: false,
	        	positioner: function () {
	        		return { x: 37, y: toolTipYvalue };
	        	}
	        };
	      } else {

	      	var xAxis = {
	      		minRange: 1,
				gridLineWidth : 0, // New value
				events : {
					setExtremes : function(e) {
						chartCommon.Conf.navigator_date_from = e.min;
						chartCommon.Conf.navigator_date_to = e.max;
						chartCommon.updateChartShareURL(e.min,e.max);
						chartCommon.updateCommonShareURL();
						// changeShare(index);
					}
				}
			};
			
			var toolTip = {  
			    shared: false,
				useHTML: true,
				backgroundColor: null,
				padding:0,
				/* borderWidth: 0,
                shadow: false, */
				positioner: function () {
            return { x: 37, y: toolTipYvalue };
        },followTouchMove: false,style: tooltipstyle, /*formatter: function () {
				 var s = '';
				  $.each(this.points, function () {
                    s += this.series.name;
                       
                });
                    var match = s.match(/.{1,70}/g);
                    return match.toString().replace(/\,/g,"<br/>");

              
                  }*/
                };
              }
              var yAxis = {
			gridLineWidth : 1.5, // The default value, no need to change it
			gridLineDashStyle: 'Dot',
			gridLineColor: '#999999',
			gridZIndex: -10,
			// offset : 10,
			opposite : false,
			labels : {
				align : 'right',
			// y: 3
		},
		plotLines : [ {
			value : 0,
			color : 'black',
			dashStyle : 'shortdash',
			width : 1.5
		} ]
	};
		// var nav_ser_data = chart_data_series[0];
		// nav_ser_data['color'] = '#DE4623';
		// nav_ser_data['type'] = 'areaspline';
		
		if(mobileView == true)
		{
			var graph_container = 'Jma_chart_containerNew_' + this.Conf.chartIndex;
			
			var scrollbar = {
						enabled : true
					}
			var navigators  = {
				enabled : true,
				maskFill : "rgba(0, 0, 0, 0.10)",
				series : {
					lineColor : '#316AB4'
				}
			  }	

            var legends = {
							enabled: true,
							align: 'center',
							backgroundColor: '#dddddd',
							verticalAlign: 'top',
							layout: 'horizontal',
              //labelFormatter: wordwapF,
              itemStyle: {
              	color: '#274b6d'
              }
            }
			
			var pointEvents= { }

			
		}
		else
		{
			 var graph_container = 'Jma_chart_container_' + this.Conf.chartIndex;
			 var scrollbar = {
						enabled : false
					}
			 var navigators  = {
				enabled : false
			  }	
             var legends = {
							enabled: false
                          }	
              var toolTip = { enabled: false } 	

              var pointEvents= {
							click: function (event) {
								var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
								var m = (new Date(this.category)).getMonth();
								if(chartCommon.Conf.chart_data_type == "anual")
								{
									dateTimeOfSeries = (new Date(this.category)).getFullYear();
								}
								else
								{
									if (chartCommon.Conf.chart_data_type == 'quaterly') 
									{
										if(monthNames[m] == 'Mar')
										{
											dateTimeOfSeries = " Q1 - " +(new Date(this.category)).getFullYear();
										}
										else if(monthNames[m] == 'Jun')
										{
											dateTimeOfSeries = "Q2 - " +(new Date(this.category)).getFullYear();
										}
										else if(monthNames[m] == 'Sep')
										{
											dateTimeOfSeries = "Q3 - " +(new Date(this.category)).getFullYear();
										}
										else if(monthNames[m] == 'Dec')
										{
											dateTimeOfSeries = "Q4 - " +(new Date(this.category)).getFullYear();
										}
									}
									else
									{
										dateTimeOfSeries = monthNames[m] + " - " +(new Date(this.category)).getFullYear();
									}
									
									console.log(dateTimeOfSeries);
								}
								$(".legentSeriesDate_"+chartCommon.Conf.chartIndex+"_"+this.series._i).html(dateTimeOfSeries); 
								$(".legentSeriesDegault_"+chartCommon.Conf.chartIndex+"_"+this.series._i).html(this.y);
							}
						}		  
		}
		

		var cht = new Highcharts.StockChart({
			chart : {
				renderTo : graph_container,
				/* events: {
					click: function (event) {
						console.log(Highcharts.numberFormat(event.yAxis[0].value, 2));
					}
				}, */
				panning:false,
				height:chartHeight,
				//backgroundColor : '#FBFBFB',
				backgroundColor : '#f5f5f5',
				plotBorderColor : '#000000',
				plotBackgroundColor : '#FFFFFF',
				plotBorderWidth : 0.5,
				spacingBottom : 35,
				alignTicks: true
			},

			exporting : {
				enabled : false,
				chartOptions:{
					chart : {
						//	spacingBottom : 85,
						events : {
							load : function(){
								this.renderer.image(JMA.baseURL+'assets/images/logo.png', 385, 300, 195,16).add();
								this.renderer.text("Source : "+chartCommon.Conf.sources, 10, 310, 159, 33).css({size:'3px'}).add();
							}
						}
					},
					navigator:{
						enabled:false
					},
					scrollbar:{
						enabled : false
					},
					tooltip: { enabled: false },
					legend : {
						enabled : true,
						backgroundColor : '#fffde1',
						verticalAlign : 'top',
						align : 'center',						
						itemStyle : {
							color : '#274b6d',
							
						}
					}
				}
			},
			colors : chartCommon.chartConfigs.colors,
			credits : {
				enabled : false,
				href : 'https://www.indiamacroadvisors.com',
				text : 'indiamacroadvisors.com'
			},
			series : chart_data_series,
			rangeSelector : {
				enabled : false,
			},
			plotOptions : {
				line : {

					dataGrouping : {
						enabled : false,
						approximation : 'average',
						dateTimeLabelFormats : {
							month : [ '%B %Y', '%B', '-%B %Y' ]
						}
					}
				},
				 series: {
				 	// allowPointSelect: true,
					connectNulls: true ,
						dataLabels: {
							allowOverlap: true,
						   
						  
						},
						point: {
							events: pointEvents
						},
				},
			},

			responsive: {
				rules: [ {
					condition: {
						minWidth: 500
					},
					chartOptions: {
						legend: legends,
          }
        },{
        	condition: {
        		maxWidth: 439
        	},
        	chartOptions: {
        		legend: legends,
        	}
        } ]
      },


      navigator : navigators,
	 
scrollbar:scrollbar,
      yAxis : yAxis,
      xAxis : xAxis,
      tooltip: toolTip
    }, function(p_chrtObj) {

    	p_chrtObj.renderer.image(JMA.baseURL+'assets/images/favicon.png', (chartCommon.Conf.chartLayout=='narrow' && JMA.controller!='home')?700:p_chrtObj.chartWidth-renderX, renderY, 45,11).add();
    	p_chrtObj.renderer.text("Source : "+chartCommon.Conf.sources, 10, renderYsource, 159, 33).add();this.controller!='home'
    	p_chrtObj.xAxis[0].setExtremes(
    		chartCommon.Conf.navigator_date_from,
    		chartCommon.Conf.navigator_date_to);
    	if(p_chrtObj.xAxis[0].tickPositions.length>12){
    		p_chrtObj.xAxis[0].update({labels:{rotation:-45}});
    	}
    });

return cht;
};



this.drawJmaChart = function(mobileView){
	var chart_data_series = this.createChartDataSeries();
	var tableClass =  new creativeTableOnIndicatorPage(chart_data_series,chartCommon);
	tableClass.enableSwitchingChartToTable();
	tableClass.mobilelegent();
	this.chart_object = this.createHighChart(chart_data_series,mobileView);
	tableClass.enableSwitchingChartToTableOnDefault();
	
};

this.drawChart = function(mobileView) {
	this.drawChartLayout(mobileView);
	if(this.Conf.chartLayout == 'normal' && mobileView == true ) {
		this.drawSeriesLayout();
	}
	this.drawJmaChart(mobileView);
	this.initializeGraphDomelements();
	
};

this.setConfigurations();
}

// Class Multiaxis lineChart
function MultiYaxisLineChart(p_chartIndex, chartDetails){
	
	var isBig  = window.matchMedia( "(min-width: 767px)" );
	
	if(isBig.matches)
	{
		var tooltipstyle={};
		
		var chartHeight = 400;
		var renderX = 93;
		var renderY = 377;
		var renderYsource = 385;
		
	}else{
		var tooltipstyle={ 
		//width: '100px'
		};
		
		var chartHeight = 300;
		
		var renderX = 53;
		var renderY = 277;
		var renderYsource = 285;
	}
	
	var chartCommon = this;
	this.setConfigurations = function(){
		
	};

	this.createMultiYaxisConfigurations = function(chart_data_series){
  var ret_data = {
   yAxis : new Array(),
   dataSeries : new Array()
  };
  $.each(chart_data_series,function(ky,chData){
   var axisConfigs = {
    opposite : ky%2 == 1 ? true : false,
    title: {
     text: chData['name'],
     style: {
                       //fontSize: '8px'
                       color: chartCommon.chartConfigs.colors[ky]
                      }
                    },
                    labels: {
         //align: 'right'
         style: {
          //color: self.chartConfigs.colors[ky]
         } 
        }
       };
       var series_new = chData;
       series_new['yAxis'] = ky,
       ret_data.yAxis[ky] = axisConfigs;
       ret_data.dataSeries[ky] = series_new;
     });
  return ret_data;
 };

	this.createChartDataSeries = function() {
		var chartDataSeries = [];
		var chart_series_count = 0;
		chartCommon.createIndividualColorPicker();
        var d = 0;
		$.each(chartCommon.Conf.chartData, function(chartcode, chart_data_col) {
			
			    if(chartCommon.Conf.chartColor.hasOwnProperty(d))
				{
					chartCommon.chartConfigs.colors[d] = chartCommon.Conf.chartColor[d];
				}
				else if(typeof chartCommon.Conf.mychartchartColor !== "undefined")
			    {
					   $.each(chartCommon.Conf.chartColor,function(idx){
							
							if(chartCommon.Conf.chartColor[idx] === undefined)
							{
							}
							else
							{
								chartCommon.Conf.mychartchartColor[idx] = chartCommon.Conf.chartColor[idx];
							}
						});
						if(chartCommon.Conf.mychartchartColor[d])
						{
							chartCommon.chartConfigs.colors[d] = chartCommon.Conf.mychartchartColor[d];
						}
				}
				
			chartDataSeries[chart_series_count] = {
				name : chartCommon.Conf.chart_labels_available[chartcode],
				data : chart_data_col
			}
			chart_series_count++;
			d++;
		});	
		return chartDataSeries;
	};
	
		this.createHighChart = function(chart_data_series,mobileView) {
			
		var toolTipYvalue = 205;
		if(chartCommon.Conf.current_chart_codes.length > 1)
		{
			toolTipYvalue = 130;
		}	
			
		var isBig  = window.matchMedia( "(min-width: 1025px)" );
		var graph_container = 'Jma_chart_container_' + this.Conf.chartIndex;
		
		

		var formetted_data_series = this.createMultiYaxisConfigurations(chart_data_series);
		var number_of_lines = Object.keys(formetted_data_series.dataSeries).length;
		for(var formetted_data_series_count = 0; formetted_data_series_count<number_of_lines; formetted_data_series_count++){
			if(formetted_data_series.yAxis[formetted_data_series_count].title.text.length>40){
				formetted_data_series.yAxis[formetted_data_series_count].title.text = formetted_data_series.yAxis[formetted_data_series_count].title.text.substring(0,40) + '....';
			}if(isBig.matches)
			{
				if(formetted_data_series.yAxis[formetted_data_series_count].title.text.length>40){
					formetted_data_series.yAxis[formetted_data_series_count].title.text = formetted_data_series.yAxis[formetted_data_series_count].title.text.substring(0,40) + '....';
				}
			}
			else
			{
				if(formetted_data_series.yAxis[formetted_data_series_count].title.text.length>25){
					formetted_data_series.yAxis[formetted_data_series_count].title.text = formetted_data_series.yAxis[formetted_data_series_count].title.text.substring(0,25) + '....';
				}
			}
		}
		var position_legend_x = 30;
		var position_legend_width = 495;
		var position_legend_x_export = 31;
		var position_legend_width_export = 518;
		if(number_of_lines == 3){
			position_legend_x = 30;
			position_legend_width = 375;
			position_legend_x_export = 32;
			position_legend_width_export = 402;
		}else if(number_of_lines == 2){
			position_legend_x = 5;
			position_legend_width = 440;
			position_legend_x_export = 3;
			position_legend_width_export = 457;
		}


		if (this.Conf.chart_data_type == 'quaterly') {
			var xAxis = {
				minRange: 1,
				gridLineWidth : 0, // New value
				events : {
					setExtremes : function(e) {
						chartCommon.Conf.navigator_date_from = e.min;
						chartCommon.Conf.navigator_date_to = e.max;
						chartCommon.updateChartShareURL(e.min,e.max);
						chartCommon.updateCommonShareURL();
						// changeShare(index);
					}
				},
				labels : {
					formatter : function() {
						var s = "";
						if (Highcharts.dateFormat('%b', this.value) == 'Mar') {
							s = s + "Q1"
						};
						if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
							s = s + "Q2"
						};
						if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
							s = s + "Q3"
						};
						if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
							s = s + "Q4"
						};
						s = s + " " + Highcharts.dateFormat('%Y', this.value);
						return s;
					}
				},
				tickInterval: 3 * 30 * 24 * 3600 * 1000,
				type: 'datetime',
				tickPositioner: function (vMin,vMax) {
					return chartCommon.generateChartTickPositions(vMin,vMax);
				}
			};
			
			var toolTip = {
				formatter: function () {
					var s = '<b>';
					if (Highcharts.dateFormat('%b', this.x) == 'Mar') {
						s = s + "Q1"
					};
					if (Highcharts.dateFormat('%b', this.x) == 'Jun') {
						s = s + "Q2"
					};
					if (Highcharts.dateFormat('%b', this.x) == 'Sep') {
						s = s + "Q3"
					};
					if (Highcharts.dateFormat('%b', this.x) == 'Dec') {
						s = s + "Q4"
					};
					s = s + " " + Highcharts.dateFormat('%Y', this.x) + '</b>';
					$.each(this.points, function (i, point) {
						var symbol = '<span style="color:' + point.series.color + '">●</span>';
						s += '<br/>' +symbol+ point.series.name + ': '+point.y;
					});
					return s;
				},
				shared: true,
				followTouchMove: false,
				style: tooltipstyle,
				useHTML: true,
				backgroundColor: null,
				borderWidth: 0,
        shadow: false,
				positioner: function () {
            return { x: 37, y: toolTipYvalue };
        },
			};
		} else {
			var xAxis = {
				minRange: 1,
				gridLineWidth : 0, // New value
				events : {
					setExtremes : function(e) {
						chartCommon.Conf.navigator_date_from = e.min;
						chartCommon.Conf.navigator_date_to = e.max;
						chartCommon.updateChartShareURL(e.min,e.max);
						chartCommon.updateCommonShareURL();
						// changeShare(index);
					}
				}
			};
			


			var toolTip = { useHTML: true,
				backgroundColor: null,
				borderWidth: 0,
        shadow: false,
		shared: false,
				positioner: function () {
            return { x: 37, y: toolTipYvalue };
        },followTouchMove: false,style: tooltipstyle};
		}
		
		if(mobileView == true)
		{
			var graph_container = 'Jma_chart_containerNew_' + this.Conf.chartIndex;
			
			var scrollbar = {
						enabled : true
					}
			var navigators  = {
				enabled : true,
				maskFill : "rgba(0, 0, 0, 0.10)",
				series : {
					lineColor : '#316AB4'
				}
			  }	

            var legends = {
							enabled: true,
							align: 'center',
							backgroundColor: '#dddddd',
							verticalAlign: 'top',
							layout: 'horizontal',
              //labelFormatter: wordwapF,
              itemStyle: {
              	color: '#274b6d'
              }
            }
            var pointEvents= {  }			
		}
		else
		{
			 var graph_container = 'Jma_chart_container_' + this.Conf.chartIndex;
			 var scrollbar = {
						enabled : false
					}
			 var navigators  = {
				enabled : false
			  }	
             var legends = {
							enabled: false
                          }		
             var toolTip = { enabled: false }
             var pointEvents= {
							click: function (event) {
								var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
								var m = (new Date(this.category)).getMonth();
								if(chartCommon.Conf.chart_data_type == "anual")
								{
									dateTimeOfSeries = (new Date(this.category)).getFullYear();
								}
								else
								{
									if (chartCommon.Conf.chart_data_type == 'quaterly') 
									{
										if(monthNames[m] == 'Mar')
										{
											dateTimeOfSeries = " Q1 - " +(new Date(this.category)).getFullYear();
										}
										else if(monthNames[m] == 'Jun')
										{
											dateTimeOfSeries = "Q2 - " +(new Date(this.category)).getFullYear();
										}
										else if(monthNames[m] == 'Sep')
										{
											dateTimeOfSeries = "Q3 - " +(new Date(this.category)).getFullYear();
										}
										else if(monthNames[m] == 'Dec')
										{
											dateTimeOfSeries = "Q4 - " +(new Date(this.category)).getFullYear();
										}
									}
									else
									{
										dateTimeOfSeries = monthNames[m] + " - " +(new Date(this.category)).getFullYear();
									}
									
									console.log(dateTimeOfSeries);
								}
								$(".legentSeriesDate_"+chartCommon.Conf.chartIndex+"_"+this.series._i).html(dateTimeOfSeries); 
								$(".legentSeriesDegault_"+chartCommon.Conf.chartIndex+"_"+this.series._i).html(this.y);
							}
						}    			 
			 
		}

		var cht = new Highcharts.StockChart({
			chart : {
				renderTo : graph_container,
				        height:chartHeight,   
						//backgroundColor : '#FBFBFB',
						backgroundColor : '#f5f5f5',
						plotBorderColor : '#000000',
						plotBackgroundColor : '#FFFFFF',
						plotBorderWidth : 0.5,
						spacingBottom : 35,
						alignTicks: true
					},
					exporting : {
						enabled : false,
						chartOptions:{
							chart : {
							//	spacingBottom : 85,
							events : {
								load : function(){
									this.renderer.image(JMA.baseURL+'assets/images/logo.png', 385, 300, 195,16).add();
								    this.renderer.text("Source : "+chartCommon.Conf.sources, 10, 310, 159, 33).css({size:'3px'}).add();
								}
							}
						},
						navigator:{
							enabled:false
						},
						tooltip: { enabled: false },
						scrollbar:{
							enabled : false
						},
						legend : {
							enabled : true,
							backgroundColor : '#fffde1',
							verticalAlign : 'top',
							

							itemStyle : {
								color : '#274b6d',
									//fontSize : fontSz
								}
							}
						}
					},
					colors : chartCommon.chartConfigs.colors,
					credits : {
						enabled : false,
						href : 'https://www.indiamacroadvisors.com',
						text : 'indiamacroadvisors.com'
					},
					series : formetted_data_series.dataSeries,
					rangeSelector : {
						enabled : false,
					},
					plotOptions: {
						line : {
							dataGrouping: {
								enabled : false,
								approximation : 'average',
								dateTimeLabelFormats : {
									month: ['%B %Y', '%B', '-%B %Y']
								},
								units : [[
								'month',
								[3,6]
								]]
							}
						},
				 series: {
					connectNulls: true ,
					dataLabels: {
						allowOverlap: true,
					   
					  
					},
					point: {
						events: pointEvents
					},
            },
					},
					responsive: {
						rules: [{
							condition: {
								maxWidth: 500
							},
							chartOptions: {
								legend: legends,
							}
						}, {
							condition: {
								minWidth: 500
							},
							chartOptions: {
								legend: legends,
							}
						},{
							condition: {
								maxWidth: 439
							},
							chartOptions: {
								legend: legends,
							}
						} ]
					},
					scrollbar:scrollbar,
					navigator: navigators,
					yAxis: formetted_data_series.yAxis,
					xAxis : xAxis,
					tooltip: toolTip
				},function(p_chrtObj){
					p_chrtObj.renderer.image(JMA.baseURL+'assets/images/favicon.png', (chartCommon.Conf.chartLayout=='narrow' && JMA.controller!='home')?700:p_chrtObj.chartWidth-renderX, renderY, 45,11).add();
					/* p_chrtObj.renderer.image(JMA.baseURL+'assets/images/logo.png', (chartCommon.Conf.chartLayout=='narrow' && JMA.controller!='home')?700:365, 380, 218,17).add(); */
					p_chrtObj.renderer.text("Source : "+chartCommon.Conf.sources, 10, renderYsource, 159, 33).add();
					p_chrtObj.xAxis[0].setExtremes(
						chartCommon.Conf.navigator_date_from,
						chartCommon.Conf.navigator_date_to);
				});
return cht;		
};



this.drawJmaChart = function(mobileView){
	
	var chart_data_series = this.createChartDataSeries();
	var tableClass =  new creativeTableOnIndicatorPage(chart_data_series,chartCommon);
	tableClass.enableSwitchingChartToTable();
	tableClass.mobilelegent();
	this.chart_object = this.createHighChart(chart_data_series,mobileView);
	tableClass.enableSwitchingChartToTableOnDefault();
};

this.drawChart = function(mobileView) {
	this.drawChartLayout(mobileView);
	if(this.Conf.chartLayout == 'normal' && mobileView == true) {
		this.drawSeriesLayout();
	}
	this.drawJmaChart(mobileView);
	this.initializeGraphDomelements();
};

this.setConfigurations();
}

//Class BarChart
function BarChart(p_chartIndex, chartDetails){
	
	var isBig  = window.matchMedia( "(min-width: 767px)" );
	
	if(isBig.matches)
	{
		var tooltipstyle={};
		
		var chartHeight = 400;
		var renderX = 93;
		var renderY = 377;
		var renderYsource = 385;
		
	}else{
		var tooltipstyle={ 
		//width: '100px'
		};
		
		var chartHeight = 300;
		
		var renderX = 53;
		var renderY = 277;
		var renderYsource = 285;
	}

	var chartCommon = this;
	this.setConfigurations = function(){
		
	};
	this.createChartDataSeries = function() {
		var chartDataSeries = [];
		var chart_series_count = 0;
		chartCommon.createIndividualColorPicker();
         var d = 0;
		$.each(chartCommon.Conf.chartData, function(chartcode, chart_data_col) {
			
			if(chartCommon.Conf.chartColor.hasOwnProperty(d))
			{
				chartCommon.chartConfigs.colors[d] = chartCommon.Conf.chartColor[d];
			}
			else if(typeof chartCommon.Conf.mychartchartColor !== "undefined")
			{
				
				   $.each(chartCommon.Conf.chartColor,function(idx){
						
						if(chartCommon.Conf.chartColor[idx] === undefined)
						{
						}
						else
						{
							chartCommon.Conf.mychartchartColor[idx] = chartCommon.Conf.chartColor[idx];
						}
					});
					
					
					if(chartCommon.Conf.mychartchartColor[d])
					{
						chartCommon.chartConfigs.colors[d] = chartCommon.Conf.mychartchartColor[d];
					}
					
			}
			chartDataSeries[chart_series_count] = {
				name : chartCommon.Conf.chart_labels_available[chartcode],
				data : chart_data_col
			}
			chart_series_count++;
			d++;
		});
		return chartDataSeries;
		
	}

this.createHighChart = function(chart_data_series,mobileView) {
	 
	    /* console.log(chartCommon.Conf.current_chart_codes.length);
		var toolTipYvalue = 130;
	    $.each(chartCommon.Conf.current_chart_codes, function(codeIndex, codeValue) {
			
			if(chartCommon.Conf.chart_labels_available[codeValue].length > 55)
			{
				toolTipYvalue = 130;
				return false;
			}	
		}); */
		
		var toolTipYvalue = 205;
		if(chartCommon.Conf.current_chart_codes.length > 1)
		{
			toolTipYvalue = 130;
		}
	
		var position_legend_x = -15;
		var position_legend_width = 530;
		var position_legend_x_export = -15;
		var position_legend_width_export = 552;
		if (this.Conf.chart_data_type == 'quaterly') {

			var xAxis = {

				minRange: 1,
				gridLineWidth : 0, // New value
				events : {
					setExtremes : function(e) {
						chartCommon.Conf.navigator_date_from = e.min;
						chartCommon.Conf.navigator_date_to = e.max;
						chartCommon.updateChartShareURL(e.min,e.max);
						chartCommon.updateCommonShareURL();
						// changeShare(index);
					}
				},
				labels : {
					formatter : function() {
						var s = "";

					
						if (Highcharts.dateFormat('%b', this.value) == 'Mar' || Highcharts.dateFormat('%b', this.value) == 'Jan' || Highcharts.dateFormat('%b', this.value) == 'Feb') {
							s = s + "Q1"
						};
						if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
							s = s + "Q2"
						};
						if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
							s = s + "Q3"
						};
						if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
							s = s + "Q4"
						};
						s = s + " " + Highcharts.dateFormat('%Y', this.value);
						return s;
					}
				},
				tickInterval: 3 * 30 * 24 * 3600 * 1000,
				type: 'datetime',
				tickPositioner: function (vMin,vMax) {
					return chartCommon.generateChartTickPositions(vMin,vMax);
				}
			};
			
			var toolTip = {
				formatter: function () {

					
					var s = '<b>';
					if (Highcharts.dateFormat('%b', this.x) == 'Mar') {
						s = s + "Q1"
					};
					if (Highcharts.dateFormat('%b', this.x) == 'Jun') {
						s = s + "Q2"
					};
					if (Highcharts.dateFormat('%b', this.x) == 'Sep') {
						s = s + "Q3"
					};
					if (Highcharts.dateFormat('%b', this.x) == 'Dec') {
						s = s + "Q4"
					};
					s = s + " " + Highcharts.dateFormat('%Y', this.x) + '</b>';
					$.each(this.points, function (i, point) {
						var symbol = '<span style="color:' + point.series.color + '">●</span>';
						s += '<br/>' +symbol+ point.series.name + ': '+point.y;
					});
					return s;
				},
				shared: true,
				followTouchMove: false,
				style:tooltipstyle,
				useHTML: true,
				backgroundColor: null,
				borderWidth: 0,
                 shadow: false,
				positioner: function () {
					return { x: 37, y: toolTipYvalue };
				}

			};
		} else {
			var xAxis = {
				minRange: 1,
				gridLineWidth : 0, // New value
				events : {
					setExtremes : function(e) {
						chartCommon.Conf.navigator_date_from = e.min;
						chartCommon.Conf.navigator_date_to = e.max;
						chartCommon.updateChartShareURL(e.min,e.max);
						chartCommon.updateCommonShareURL();
						// changeShare(index);
					}
				}
			};
			

			var toolTip = {
				shared: false,
				useHTML: true,
				backgroundColor: null,
				borderWidth: 0,
        shadow: false,
				positioner: function () {
            return { x: 37, y: toolTipYvalue };
        },style:tooltipstyle, followTouchMove: false};
		}
		
		var yAxis = {
				gridLineWidth: 1, // The default value, no need to change it
				gridLineDashStyle: 'ShortDash',
				offset : 30
			};
			
			
		if(mobileView == true)
		{
			var graph_container = 'Jma_chart_containerNew_' + this.Conf.chartIndex;
			
			var scrollbar = {
						enabled : true
					}
			var navigators  = {
				enabled : true,
				maskFill : "rgba(0, 0, 0, 0.10)",
				series : {
					lineColor : '#316AB4'
				}
			  }	

            var legends = {
							enabled: true,
							align: 'center',
							backgroundColor: '#dddddd',
							verticalAlign: 'top',
							layout: 'horizontal',
              //labelFormatter: wordwapF,
              itemStyle: {
              	color: '#274b6d'
              }
            }
            
			var pointEvents= {  }
            			
		}
		else
		{
			 var graph_container = 'Jma_chart_container_' + this.Conf.chartIndex;
			 var scrollbar = {
						enabled : false
					}
			 var navigators  = {
				enabled : false
			  }	
             var legends = {
							enabled: false
                          }	
             var toolTip = { enabled: false } 
             var pointEvents= {
							click: function (event) {
								var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
								var m = (new Date(this.category)).getMonth();
								if(chartCommon.Conf.chart_data_type == "anual")
								{
									dateTimeOfSeries = (new Date(this.category)).getFullYear();
								}
								else
								{
									if (chartCommon.Conf.chart_data_type == 'quaterly') 
									{
										if(monthNames[m] == 'Mar')
										{
											dateTimeOfSeries = " Q1 - " +(new Date(this.category)).getFullYear();
										}
										else if(monthNames[m] == 'Jun')
										{
											dateTimeOfSeries = "Q2 - " +(new Date(this.category)).getFullYear();
										}
										else if(monthNames[m] == 'Sep')
										{
											dateTimeOfSeries = "Q3 - " +(new Date(this.category)).getFullYear();
										}
										else if(monthNames[m] == 'Dec')
										{
											dateTimeOfSeries = "Q4 - " +(new Date(this.category)).getFullYear();
										}
									}
									else
									{
										dateTimeOfSeries = monthNames[m] + " - " +(new Date(this.category)).getFullYear();
									}
									
									console.log(dateTimeOfSeries);
								}
								$(".legentSeriesDate_"+chartCommon.Conf.chartIndex+"_"+this.series._i).html(dateTimeOfSeries); 
								$(".legentSeriesDegault_"+chartCommon.Conf.chartIndex+"_"+this.series._i).html(this.y);
							}
						} 
			 
		}	
			
		

			var cht = new Highcharts.StockChart({
				chart : {
					type: 'column',
					renderTo : graph_container,
					    height:chartHeight,   
						//backgroundColor : '#FBFBFB',
						backgroundColor : '#f5f5f5',
						plotBorderColor : '#000000',
						plotBackgroundColor : '#FFFFFF',
						plotBorderWidth : 0.5,
						spacingBottom : 35,
						alignTicks: true
					},
					exporting : {
						enabled : false,
						chartOptions:{
							chart : {
							//	spacingBottom : 85,
							events : {
								load : function(){
									this.renderer.image(JMA.baseURL+'assets/images/logo.png', 385, 300, 195,16).add();
								    this.renderer.text("Source : "+chartCommon.Conf.sources, 10, 310, 159, 33).css({size:'3px'}).add();
								}
							}
						},
						navigator:{
							enabled:false
						},
						scrollbar:{
							enabled : false
						},
						tooltip: { enabled: false },
						legend : {
							enabled : true,
							backgroundColor : '#fffde1',

							itemStyle : {
								color : '#274b6d',

							}
						}
					}
				},
				colors : chartCommon.chartConfigs.colors,
				credits : {
					enabled : false,
					href : 'http://www.indiamacroadvisors.com',
					text : 'indiamacroadvisors.com'
				},
				series : chart_data_series,
				rangeSelector : {
					enabled : false,
				},
				plotOptions: {
					column : {
						dataGrouping: {
							enabled : false,
							approximation : 'average',
							dateTimeLabelFormats : {
								month: ['%B %Y', '%B', '-%B %Y']
							},
							units : [[
							'month',
							[3,6]
							]]
						}
					},
				 series: {
            connectNulls: true ,
                dataLabels: {
                    allowOverlap: true,
                },
				point: {
					events: pointEvents
				},
            },
				},
				responsive: {
					rules: [{
						condition: {
							maxWidth: 500
						},
						chartOptions: {
							legend: {
								align: 'center',
								backgroundColor: '#dddddd',
								verticalAlign: 'top',
								layout: 'horizontal',
								labelFormatter: function() {
									var legendName = this.name;
									var match = legendName.match(/.{1,70}/g);
									return match.toString().replace(/\,/g,"<br/>");
								},
								itemStyle: {
									width: 350,
									fontSize: 11
								}
							},
						}
					}, {
						condition: {
							minWidth: 500
						},
						chartOptions: {
							legend: legends,
						}
					},{
						condition: {
							maxWidth: 439
						},
						chartOptions: {
							legend: legends,
						}
					} ]
				},
				scrollbar:scrollbar,
				navigator: navigators,
				yAxis: yAxis,
				xAxis : xAxis,
				tooltip: toolTip
			},function(p_chrtObj){
				p_chrtObj.renderer.image(JMA.baseURL+'assets/images/favicon.png', (chartCommon.Conf.chartLayout=='narrow' && JMA.controller!='home')?700:p_chrtObj.chartWidth-renderX, renderY, 45,11).add();
			/* 	p_chrtObj.renderer.image(JMA.baseURL+'assets/images/favicon.png', (chartCommon.Conf.chartLayout=='narrow' && JMA.controller!='home')?700:365, 380, 67,17).add(); */
				p_chrtObj.renderer.text("Source : "+chartCommon.Conf.sources, 10, renderYsource, 159, 33).add();
				p_chrtObj.xAxis[0].setExtremes(
					chartCommon.Conf.navigator_date_from-1,
					chartCommon.Conf.navigator_date_to);
			});


return cht;		
};

function convert(str) {
    var date = new Date(str),
        mnth = ("0" + (date.getMonth()+1)).slice(-2),
        day  = ("0" + date.getDate()).slice(-2);
    return [ date.getFullYear(), mnth, day ].join("-");
}

this.drawJmaChart = function(mobileView){
	var chart_data_series = this.createChartDataSeries();
	var tableClass =  new creativeTableOnIndicatorPage(chart_data_series,chartCommon);
	tableClass.enableSwitchingChartToTable();
	tableClass.mobilelegent();
	this.chart_object = this.createHighChart(chart_data_series,mobileView);
	tableClass.enableSwitchingChartToTableOnDefault();
};

this.drawChart = function(mobileView) {
	this.drawChartLayout(mobileView);
	if(this.Conf.chartLayout == 'normal' && mobileView == true) {
		this.drawSeriesLayout();
	}
	this.drawJmaChart(mobileView);
	this.initializeGraphDomelements();
};

this.setConfigurations();
}


//BarChart.prototype = new chartCommon();
//LineChart.prototype = Object.create(chartCommon.prototype);
//LineChart.prototype.constructor = chartCommon;
//LineChart.inherits(chartCommon);
// Class JMAChart
// All chart related functions here
function JMAChart(){
	var JMAChart = this;
	this.Charts = new Array();
	this.Maps = new Array();
	this.createMapsObject = {
			'maps' : function(p_chartIndex,chartDetails){
				mapsChart.prototype = new mapCommon(p_chartIndex,chartDetails);
				return new mapsChart();
			}
		};
	this.createChartObject = {
		'line' : function(p_chartIndex){
			LineChart.prototype = new chartCommon(p_chartIndex);
			return new LineChart();
		},
		'bar' : function(p_chartIndex,chartDetails){
			BarChart.prototype = new chartCommon(p_chartIndex);
			return new BarChart();
		},
		'multiaxisline' : function(p_chartIndex,chartDetails){
			MultiYaxisLineChart.prototype = new chartCommon(p_chartIndex);
			return new MultiYaxisLineChart();
		}

	};
	
	
	//initiate a new map object
	this.initiateMap = function(chartIndex,chartDetails){
		// alert("dfdsfd");
		this.Charts[chartIndex] = this.createMapsObject[chartDetails.map_config.mapType](chartIndex);
		this.Charts[chartIndex].setAllConfigurationsForMap(chartIndex,chartDetails);	
	};
	
	
	    $('body').on('click', '.lgh_edit' , function(e) {
						
						var chartIndex = $(this).data('id');
					
						chartDetailsObj = JMA.JMAChart.Charts[chartIndex].chart_object;
						
						$('.Chart_Dv_placeholder_mobile').html('');
						$('#indicator_view_charts').modal('show');

						$('#indicator_view_charts').on('shown.bs.modal', function () {
							
		                    JMA.JMAChart.Charts[chartIndex].drawChart(true);
		
						});
		});
		
		
		$('body').on('click', '.edit_chart_close' , function(e) {
						
					e.preventDefault();
					$('#indicator_view_charts').modal('hide');
					var chartIndex = $('.Chart_Dv_placeholder_mobile .chart_index_position').data('id')
					JMA.JMAChart.Charts[chartIndex].drawChart(false);
		});
		
	
	//initiate a new chart object
	this.initiateChart = function(chartIndex,chartDetails){
		
		var old = JSON.stringify(chartDetails).replace(/&amp;/g, '&').replace(/&#039;/g, "'"); //convert to JSON string
        var chartDetails = JSON.parse(old); //convert back to array
		this.Charts[chartIndex] = this.createChartObject[chartDetails.chart_config.chartType](chartIndex);
		this.Charts[chartIndex].setAllConfigurations(chartIndex,chartDetails);	
		
	};
	
	//Switch graphTypes
	this.switchGraph = function(chartIndex,chartType,mobileView){
		var currentConfig = this.Charts[chartIndex].getAllConfigurations();
		currentConfig.chartType = chartType;
		currentConfig.chartColorSatus = 'true';
		this.Charts[chartIndex] = this.createChartObject[chartType](chartIndex);
		this.Charts[chartIndex].copyThisConfigurations(currentConfig);
		this.Charts[chartIndex].drawChart(mobileView);
	};
	
	this.initialize = function(){
		Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {
			switch (operator) {
				case '==':
				return (v1 == v2) ? options.fn(this) : options.inverse(this);
				case '!=':
				return (v1 != v2) ? options.fn(this) : options.inverse(this);
				case '===':
				return (v1 === v2) ? options.fn(this) : options.inverse(this);
				case '<':
				return (v1 < v2) ? options.fn(this) : options.inverse(this);
				case '<=':
				return (v1 <= v2) ? options.fn(this) : options.inverse(this);
				case '>':
				return (v1 > v2) ? options.fn(this) : options.inverse(this);
				case '>=':
				return (v1 >= v2) ? options.fn(this) : options.inverse(this);
				case '&&':
				return (v1 && v2) ? options.fn(this) : options.inverse(this);
				case '||':
				return (v1 || v2) ? options.fn(this) : options.inverse(this);
				default:
				return options.inverse(this);
			}
		});
	}
	
	// Dom initialize
	this.domInitialize = function(){
		$('.Graph_tabset_tab.inactive').live("click",function(){
			var chart_fnd_index = $(this).attr('chart_index');
			var graph_container_obj = $('#h_graph_wrap_'+chart_fnd_index);
			var jqobj = $(this);
			var contentdiv = jqobj.attr('contentdiv');
			graph_container_obj.find('.Graph_tabset_tab').removeClass('active').addClass('inactive');
			jqobj.removeClass('inactive').addClass('active');
			graph_container_obj.find('.Graph_tabset_contentdiv').hide();
			graph_container_obj.find('.Graph_tabset_contentarea').find(contentdiv).show();
		});
	};
	
	//Show share chart
	this.showGraphShare = function(link_href,e,sType){
		e = (e ? e : window.event);
		var Config = {
			Width: 500,
			Height: 500
		};
		// console.log(link_href);
		var share_app_url = '';
		switch (sType){
			
			case 'facebook':
			share_app_url = 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(link_href);
			break;
			case 'twitter':
			share_app_url = 'https://twitter.com/intent/tweet?url='+encodeURIComponent(link_href)+'&hashtags=indiamacroadvisors.com,india';
			break;
			case 'google':
			share_app_url = 'https://plus.google.com/share?url='+encodeURIComponent(link_href);
			break;
			case 'linkedin':
			share_app_url = 'http://www.linkedin.com/shareArticle?mini=true&url='+encodeURIComponent(link_href)+'&source=www.indiamacroadvisors.com';
			break;
		}
        // popup position
        var
        px = Math.floor(((screen.availWidth || 1024) - Config.Width) / 2),
        py = Math.floor(((screen.availHeight || 700) - Config.Height) / 2);

        // open popup
        var popup = window.open(share_app_url, "social",
        	"width="+Config.Width+",height="+Config.Height+
        	",left="+px+",top="+py+
        	",location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1");
        if (popup) {
        	popup.focus();
        	if (e.preventDefault) e.preventDefault();
        	e.returnValue = false;
        }

        return !!popup;
      };
	  
	  
	  	//Show share common
	this.showCommonShare = function(link_href,e,sType){
		e = (e ? e : window.event);
		var Config = {
			Width: 500,
			Height: 500
		};
		var share_app_url = '';
		console.log(sType);
		switch (sType){
			case 'facebook':
			share_app_url = 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(link_href);
			break;
			case 'twitter':
			
			share_app_url = 'https://twitter.com/intent/tweet?url='+encodeURIComponent(link_href)+'&hashtags=indiamacroadvisors.com,india';
			break;
			case 'google':
			share_app_url = 'https://plus.google.com/share?url='+encodeURIComponent(link_href);
			break;
			case 'linkedin':
			share_app_url = 'http://www.linkedin.com/shareArticle?mini=true&url='+encodeURIComponent(link_href)+'&source=www.indiamacroadvisors.com';
			break;
		}
        // popup position
        var
        px = Math.floor(((screen.availWidth || 1024) - Config.Width) / 2),
        py = Math.floor(((screen.availHeight || 700) - Config.Height) / 2);

        // open popup
        var popup = window.open(share_app_url, "social",
        	"width="+Config.Width+",height="+Config.Height+
        	",left="+px+",top="+py+
        	",location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1");
        if (popup) {
        	popup.focus();
        	if (e.preventDefault) e.preventDefault();
        	e.returnValue = false;
        }

        return !!popup;
      };  
	  
	  
	 

	// Draw all charts
	this.drawAllCharts = function(mobileView){
		if(this.Maps.length>0){
			
			$.each(this.Maps,function(idx,chartObj){

				chartObj.drawChart(mobileView);
			});
			
		}
		
		if(this.Charts.length>0){
			
			$.each(this.Charts,function(idx,chartObj){

				chartObj.drawChart(mobileView);
			});
			this.domInitialize();
		}
	};
	
	
	
	
	// Draw a chart by chart index
	this.redrawChart = function(p_chart_idx){

	//	JMA.JMAChart.Charts[p_chart_idx].redrawChart();
	var dataUrl = JMA.baseURL+'chart/getchartdata';
	var data_type = JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type;
	var chartcodes = JMA.JMAChart.Charts[p_chart_idx].Conf.current_chart_codes;
	$.ajax({
		url : dataUrl,
		dataType : 'json',
		type : 'POST',
		data : {'type' : data_type, 'chartcodes' : chartcodes},
		beforeSend: function() { JMA.showLoading(); },
		success : function(data){
			JMA.JMAChart.Charts[p_chart_idx].Conf.chartData = JMA.JMAChart.Charts[p_chart_idx].formatData(data.data);
			JMA.JMAChart.Charts[p_chart_idx].Conf.sources = data.sources;
			JMA.JMAChart.Charts[p_chart_idx].Conf.isPremiumData = data.isPremiumData;
			JMA.JMAChart.Charts[p_chart_idx].drawJmaChart(mobileview = true);
			$("div.input-group-addon i.fa-minus").trigger('click');
			JMA.hideLoading();
		},
		error : function() {
			JMA.hideLoading();
			JMA.handleError();
		}
	});
};



	// Export Chart Tab side
	this.exportTabChart = function(idx,pType,pSize){


		var type = pType == null? $('#tab_export_chart_image_select_format_'+idx).val() : pType;
		var size = pSize == null? $('#tab_export_chart_image_size_'+idx).val() : pSize;
		
		var width_val = JMA.JMAChart.Charts[idx].Conf.chartExport.image_size_available[size];
		
		if(type=='ppt'){
			this.export_ppt_Chart(idx);
		}else if(type=='csv'){
			JMA.JMAChart.downloadChartData(idx);
		}else{
			
			JMA.JMAChart.Charts[idx].chart_object.exportChart({
				type : type,
				sourceWidth : 700,
				sourceHeight : 340,
				filename : 'jma_chart_'+type+'_'+width_val+'_'+idx,
			//url : 'http://testing.indiamacroadvisors.com/chart/exportChart'
		});
		}

		
	};	

	
	// Export Map
	this.exportMap = function(idx,pType,pSize){


		var type = pType == null? $('#export_chart_image_select_format_'+idx).val() : pType;
		
		var width_val = 400;
		
		if(type=='ppt'){
			this.export_ppt_Map(idx);
		}else if(type=='csv'){
			JMA.JMAChart.downloadChartData(idx);
		}else{
			
			/* JMA.JMAChart.Charts[idx].chart_object.exportChart({
				type : type,
				sourceWidth : 700,
				sourceHeight : 340,
				filename : 'ima_chart_'+type+'_'+width_val+'_'+idx,
		       //	url : 'http://indiamacroadvisors.com/chart/exportChart'
	       }); */
		   
			var addWidth=0;
			if(JMA.JMAChart.Charts[idx].chart_object.userOptions.chart.type=='column'){
				addWidth=JMA.JMAChart.Charts[idx].chart_object.marginRight;
			}

			JMA.JMAChart.Charts[idx].chart_object.exportChart({
				type : type,
				scale:4,
				filename : 'ima_chart_'+type+'_'+width_val+'_'+idx,
				url : JMA.Export_url
	         },{
			 chart:{
				width:(JMA.JMAChart.Charts[idx].chart_object.chartWidth+addWidth),
				height:(JMA.JMAChart.Charts[idx].chart_object.chartHeight-JMA.JMAChart.Charts[idx].chart_object.extraBottomMargin),
				
			},
		
			legend: {
				useHTML: true,
				
				width:((JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth<400)?JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth:JMA.JMAChart.Charts[idx].chart_object.legend.maxItemWidth)+10,
			   
				itemStyle: {
				
				 fontSize: '11px'
				}
			},
			yAxis: {
				tickPositions: JMA.JMAChart.Charts[idx].chart_object.yAxis[0].tickPositions
			}

		 });
		   
		   
		   
		}


		
	};
	
	
	// Export Chart
	this.exportChart = function(idx,pType,pSize){


		var type = pType == null? $('#export_chart_image_select_format_'+idx).val() : pType;
		var size = pSize == null? $('#export_chart_image_size_'+idx).val() : pSize;

		
		var width_val = JMA.JMAChart.Charts[idx].Conf.chartExport.image_size_available[size];
		
		if(type=='ppt'){
			this.export_ppt_Chart(idx);
		}else if(type=='csv'){
			JMA.JMAChart.downloadChartData(idx);
		}else{
			

			/*console.log(JMA.JMAChart.Charts[idx].chart_object.userOptions.yAxis.length);//return false;
			if(JMA.JMAChart.Charts[idx].chart_object.userOptions.chart.type=='column'){
				var marginLeft_=50;
			}else{
				var marginLeft_=null;
			}

			if(JMA.JMAChart.Charts[idx].chart_object.userOptions.chart.type!='column'){
				var marginRight_=(JMA.controller!='home')?75:55;
			}else{
				var marginRight_=null;
			}*/

			var addWidth=0;
			if(JMA.JMAChart.Charts[idx].chart_object.userOptions.chart.type=='column'){
				addWidth=JMA.JMAChart.Charts[idx].chart_object.marginRight;
			}

			JMA.JMAChart.Charts[idx].chart_object.exportChart({
				type : type,
				scale:4,
				//sourceWidth : 700,
				//sourceHeight : 350,
				filename : 'ima_chart_'+type+'_'+width_val+'_'+idx,
				url : JMA.Export_url
	},{
					chart:{
			
			//marginRight: marginRight_,
			//marginLeft: marginLeft_,
			width:(JMA.JMAChart.Charts[idx].chart_object.chartWidth+addWidth),
			height:(JMA.JMAChart.Charts[idx].chart_object.chartHeight-JMA.JMAChart.Charts[idx].chart_object.extraBottomMargin),
			
		},
		
		legend: {
			useHTML: true,
			
			width:((JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth<400)?JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth:JMA.JMAChart.Charts[idx].chart_object.legend.maxItemWidth)+10,
           
            itemStyle: {
            
             fontSize: '11px'
            }
        },
		

    yAxis: {
        tickPositions: JMA.JMAChart.Charts[idx].chart_object.yAxis[0].tickPositions
    }

		});
		}

		
	}	
	
	// Print chart
	this.printChart = function(idx){
		JMA.JMAChart.Charts[idx].chart_object.print();
	};

	
	
	
	
	// PPT Export chart Veera Start

	this.export_ppt_Chart = function(idx){
		
		JMA.showLoading();
		var chart=JMA.JMAChart.Charts[idx].chart_object;
		var addWidth=0;
			if(chart.userOptions.chart.type=='column'){
				addWidth=JMA.JMAChart.Charts[idx].chart_object.marginRight;
			}
		var chart_svg = chart.getSVG({
			chart:{
				backgroundColor: '#FFF',
					width:(chart.chartWidth+addWidth),
			height:(chart.chartHeight-chart.extraBottomMargin),
				events : {
							load : function(){
							 /* if(chart.userOptions.isStock!=null){
							    this.renderer.text($('#Jma_chart_container_'+idx+' span:contains("Source")').text(), 10, 310, 159, 33).css({size:'3px'}).add();
							} */
							this.renderer.text($('#Jma_chart_container_'+idx+' span:contains("Source")').text(), 10, 310, 159, 33).css({size:'3px'}).add();
							}
						}
			},
			credits: {
				enabled: false
			},
			scrollbar : {
				enabled : false
			},
			tooltip: { enabled: false },
			navigator: {
				enabled: false
			},
			legend: {
			useHTML: true,
			
			width:((JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth<400)?JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth:JMA.JMAChart.Charts[idx].chart_object.legend.maxItemWidth)+10,
           
            itemStyle: {
            
             fontSize: '11px'
            }
        },
		

    yAxis: {
        tickPositions: JMA.JMAChart.Charts[idx].chart_object.yAxis[0].tickPositions
    },
		});
		var find_image =$(chart_svg).find("image").remove().clone().wrap('<div>').parent().html();
		chart_svg = chart_svg.replace(find_image, '');

 

		var exp_data = {
			svg: chart_svg,
			noDownload:true,
			type: 'jpeg',
			//width : 1400,
			//height : 700,
			scale:4,
			async: true
		
		};

     
        	exportUrl=JMA.Export_url;
       
        
        $.ajax({
        
        	  
        	
        	type: "POST",
        	url: exportUrl,
        	data: exp_data,
        	cache:false,
        	 processData: true,
        	async:true,
        	Origin:exportUrl,
        	crossDomain:true,
        success: function (data) {
        		console.log(data);
        		var datas = {chart: data,title: 'test'};
        		JMA.JMAChart.ppt_ajax_request(datas);

        	},
        	error: function(data) {
        		console.log(data.statusText+data.status);
        		alert(data.statusText+data.status);
        		JMA.hideLoading();

        	}
        });


      };
	// PPt Ajax Request

	this.ppt_ajax_request=function(datas){
		
		single_exportUrl = JMA.baseURL+'mycharts/single_chart_ppt';
		$.ajax({
			type: "POST",
			url: single_exportUrl,
			data: datas,
			cache:false,
			async:true,
			dataType: "json",
			success: function (data) {

				if(data.msg==true){
					var hidden_a = document.createElement("a");
					hidden_a.setAttribute("href", JMA.baseURL+data.dir+data.file);
					hidden_a.setAttribute("download", data.file);
					document.body.appendChild(hidden_a);
					if($.browser.safari){
						hidden_a.onclick=function(){
							document.body.removeChild(hidden_a);
						}
						var cle = document.createEvent("MouseEvent");
						cle.initEvent("click", true, true);
						hidden_a.dispatchEvent(cle);
					}else{
						hidden_a.click();
						document.body.removeChild(hidden_a);
					}

				}else{
					alert(data.msg);	
				}
				JMA.hideLoading();
			},
			error: function(data) {
				console.log(data.statusText+data.status);
				alert(data.statusText+data.status+' Something went wrong');
				JMA.hideLoading();

			}



		});

	};
	// Veera End
	
	
	
	// PPT Export Map Srini Start

	this.export_ppt_Map = function(idx){
		JMA.showLoading();
		var chart=JMA.JMAChart.Charts[idx].chart_object;
		var addWidth=0;
			if(chart.userOptions.chart.type=='column'){
				addWidth=JMA.JMAChart.Charts[idx].chart_object.marginRight;
			}
		var chart_svg = chart.getSVG({
			chart:{
				backgroundColor: '#FFF',
					width:(chart.chartWidth+addWidth),
			height:(chart.chartHeight-chart.extraBottomMargin),
				events : {
							load : function(){
								/* if(chart.userOptions.isStock!=null){
								   this.renderer.text($('#Jma_chart_container_'+idx+' span:contains("Source")').text(), 10, 310, 159, 33).css({size:'3px'}).add();
							    } */
								this.renderer.text("Source : "+JMA.JMAChart.Charts[idx].Conf.mapSource, 10, 395, 159, 33).css({size:'3px'}).add();
							}
						}
			},
			credits: {
				enabled: false
			},
			scrollbar : {
				enabled : false
			},
			tooltip: { enabled: false },
			navigator: {
				enabled: false
			},
			legend: {
			useHTML: true,
			
			width:((JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth<400)?JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth:JMA.JMAChart.Charts[idx].chart_object.legend.maxItemWidth)+10,
           
            itemStyle: {
            
             fontSize: '11px'
            }
        },
		

    yAxis: {
        tickPositions: JMA.JMAChart.Charts[idx].chart_object.yAxis[0].tickPositions
    },
		});
		var find_image =$(chart_svg).find("image").remove().clone().wrap('<div>').parent().html();
		chart_svg = chart_svg.replace(find_image, '');

 

		var exp_data = {
			svg: chart_svg,
			noDownload:true,
			type: 'jpeg',
			//width : 1400,
			//height : 700,
			scale:4,
			async: true
		
		};

     
        	exportUrl=JMA.Export_url;
       
        
        $.ajax({
        
        	  
        	
        	type: "POST",
        	url: exportUrl,
        	data: exp_data,
        	cache:false,
        	 processData: true,
        	async:true,
        	Origin:exportUrl,
        	crossDomain:true,
        success: function (data) {
        		console.log(data);
        		var datas = {chart: data,title: 'test'};
        		JMA.JMAChart.ppt_ajax_request(datas);

        	},
        	error: function(data) {
        		console.log(data.statusText+data.status);
        		alert(data.statusText+data.status);
        		JMA.hideLoading();

        	}
        });


      };
	// PPt Ajax Request

	this.ppt_ajax_request=function(datas){
		
		single_exportUrl = JMA.baseURL+'mycharts/single_chart_ppt';
		$.ajax({
			type: "POST",
			url: single_exportUrl,
			data: datas,
			cache:false,
			async:true,
			dataType: "json",
			success: function (data) {

				if(data.msg==true){
					var hidden_a = document.createElement("a");
					hidden_a.setAttribute("href", JMA.baseURL+data.dir+data.file);
					hidden_a.setAttribute("download", data.file);
					document.body.appendChild(hidden_a);
					if($.browser.safari){
						hidden_a.onclick=function(){
							document.body.removeChild(hidden_a);
						}
						var cle = document.createEvent("MouseEvent");
						cle.initEvent("click", true, true);
						hidden_a.dispatchEvent(cle);
					}else{
						hidden_a.click();
						document.body.removeChild(hidden_a);
					}

				}else{
					alert(data.msg);	
				}
				JMA.hideLoading();
			},
			error: function(data) {
				console.log(data.statusText+data.status);
				alert(data.statusText+data.status+' Something went wrong');
				JMA.hideLoading();

			}



		});

	};
	// Srini End
	
	
	
	
	// Add new graph code to current graph codes
	this.addThisGraphCode = function(p_chart_idx,p_graph_code){
		var series_main_code = $('#select_series_addmore-select_'+p_chart_idx).val();
		// Get previous chart's y-sub text
		var prev_ysub_selected_text = $('#Dv_placeholder_graph_series_section_'+p_chart_idx+' > div').last().find('.Dv_placeholder_graph_currentseries_ysub_select').find('select option:selected').text();
		var arr_available_fields = JMA.JMAChart.Charts[p_chart_idx].Conf.charts_fields_available[series_main_code][Object.keys(JMA.JMAChart.Charts[p_chart_idx].Conf.charts_fields_available[series_main_code])[0]];
		if(arr_available_fields.hasOwnProperty(prev_ysub_selected_text)){
			var series_code = arr_available_fields[prev_ysub_selected_text];
		}else{
			var series_code = series_main_code+'-0';
		}
		JMA.JMAChart.Charts[p_chart_idx].addThisToCurrentGraphCode(series_code);
		JMA.JMAChart.Charts[p_chart_idx].drawSeriesLayout();
		JMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSatus = 'true';
		this.redrawChart(p_chart_idx);
	};	
	// Replace existing graph code
	this.replaceThisGraphCode = function(p_chart_idx,p_code_idx,elm){
		var p_graph_code= $(elm).val();
		JMA.JMAChart.Charts[p_chart_idx].replaceCurrentGraphCode(p_code_idx,p_graph_code);
		JMA.JMAChart.Charts[p_chart_idx].drawSeriesLayout();
		this.redrawChart(p_chart_idx);
	};
	
	
	
	 this.replaceColorofChartForIndicator = function(p_chart_idx,color_code_idx,indexChart1){
	
		JMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSeries.push(indexChart1);
		var colorArr = JMA.JMAChart.Charts[p_chart_idx].Conf.chartColor;
		
		if (typeof colorArr !== 'undefined') 
		{
			JMA.JMAChart.Charts[p_chart_idx].Conf.chartColor[indexChart1] = color_code_idx;
			JMA.JMAChart.Charts[p_chart_idx].Conf.commonColorCode[p_chart_idx][indexChart1] = color_code_idx;
		}
		else
		{
			JMA.JMAChart.Charts[p_chart_idx].Conf.chartColor.push(color_code_idx);
		}
			
		JMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSatus = false;
		this.redrawChart(p_chart_idx);
	};
	
	
	this.replaceThisGraphCodeDirect = function(p_chart_idx,p_code_idx,new_ch_code){
		JMA.JMAChart.Charts[p_chart_idx].replaceCurrentGraphCode(p_code_idx,new_ch_code);
		JMA.JMAChart.Charts[p_chart_idx].drawSeriesLayout();
		JMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSatus = 'true';
		this.redrawChart(p_chart_idx);
	};
	this.removeThisChartCodeByIndex = function(p_chart_idx,p_chart_code_idx){
		JMA.JMAChart.Charts[p_chart_idx].removeThisChartCodeByIndex(p_chart_code_idx);
		JMA.JMAChart.Charts[p_chart_idx].drawSeriesLayout();
		JMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSatus = 'true';
		this.redrawChart(p_chart_idx);
	}
	
	 // Create and populate Y sub select dropdown
	this.changeColorofChartForIndicator = function(p_chart_idx,color_code,indexChart1){
		this.replaceColorofChartForIndicator(p_chart_idx,color_code,indexChart1);
	};
	
	
	// Create and populate Y sub select dropdown
	this.populateYSubDropdown = function(p_chart_idx,p_code_idx,p_element){
		/* var y_idx = $(p_element).val();
		//Find y-sub text
		var ySub_text = $(p_element).next('.Dv_placeholder_graph_currentseries_ysub_select').find('select option:selected').text();
		var array_y_sub_vals = JMA.JMAChart.Charts[p_chart_idx].populateYSubDropdownData(p_code_idx,y_idx);
		var new_ch_code = array_y_sub_vals[0].code; 
		$.each(array_y_sub_vals,function(dd_k,dd_v){
			if(dd_v.label == ySub_text){
				new_ch_code = dd_v.code;
			}
		})
		this.replaceThisGraphCodeDirect(p_chart_idx,p_chart_idx,new_ch_code); */
		
		
		var y_idx = $(p_element).val();
		//Find y-sub text
		
		var ySub_text = $(p_element).parent().next('.Dv_placeholder_graph_currentseries_ysub_select').find('select option:selected').text();

		var array_y_sub_vals = JMA.JMAChart.Charts[p_chart_idx].populateYSubDropdownData(p_code_idx,y_idx);
		var new_ch_code = array_y_sub_vals[0].code; 
		
		$.each(array_y_sub_vals,function(dd_k,dd_v){
			if(dd_v.label == ySub_text){
				new_ch_code = dd_v.code;
			}
		})
		this.replaceThisGraphCodeDirect(p_chart_idx,p_code_idx,new_ch_code);
		
		/*
		var str_option = '<select onChange="JMA.JMAChart.replaceThisGraphCode('+p_chart_idx+','+p_code_idx+',this)">';
		$.each(array_y_sub_vals, function(ky,options_obj){
			str_option+='<option value="'+options_obj.code+'">'+options_obj.label+'</optopn>';
		});
		str_option+='</select>';
		$('#Dv_placeholder_graph_currentseries_select_'+p_chart_idx+'_'+p_code_idx).find('.Dv_placeholder_graph_currentseries_ysub_select').html(str_option);
		*/
	};

	this.SeriesColorDropdown = function(chart_index,series_idx,el){

		var $Seriescolor=JMA.JMAChart.Charts[chart_index].chartConfigs.colors[series_idx];
		var $Seriescolor=($Seriescolor!=null)?$Seriescolor:'red';
		return el.style.color = $Seriescolor;
		
	};
	
	/* this.serialize_each_object = function(obj) {
			return Object.keys(obj).map(function(p) {
				return encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]);
			}).join("&");
	} */
	
   this.All_share = function(idx,shareNetwork){
	   
		var  authWindow;
		var chart = JMA.JMAChart.Charts[idx].chart_object;


		/* var chart_svg = chart.getSVG({
			chart:{
				backgroundColor: '#FFF'
			},
			credits: {
				enabled: false
			},
			scrollbar : {
				enabled : false
			},
			tooltip: { enabled: false },
			navigator: {
				enabled: false
			},
			legend: {
			useHTML: true,
			
			width:((JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth<400)?JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth:JMA.JMAChart.Charts[idx].chart_object.legend.maxItemWidth)+10,
           
            itemStyle: {
            
             fontSize: '11px'
            }
        },
			yAxis: {
			tickPositions: JMA.JMAChart.Charts[idx].chart_object.yAxis[0].tickPositions
		},
		}); */
		
		    var addWidth=0;
			if(chart.userOptions.chart.type=='column'){
				addWidth=JMA.JMAChart.Charts[idx].chart_object.marginRight;
			}

			var chart_svg = chart.getSVG({
				chart:{
					backgroundColor: '#FFF',
					width:(chart.chartWidth+addWidth),
				height:(chart.chartHeight-chart.extraBottomMargin),

				events : {
								load : function(){
									if(chart.userOptions.isStock!=null){
							/* this.renderer.image(JMA.baseURL+'assets/images/logo.png', 385, 300, 195,16).add();
						    this.renderer.text($('#Jma_chart_container_'+idx+' span:contains("Source")').text(), 10, 310, 159, 33).css({size:'3px'}).add(); */
								}
								//this.renderer.image(JMA.baseURL+'assets/images/favicon.png', chart.chartWidth-53, 277, 45,11).add();
						        //this.renderer.text($('#Jma_chart_container_'+idx+' span:contains("Source")').text(), 10, 285, 159, 33).css({size:'3px'}).add();
							}
							}
				},
				credits: {
					enabled: false
				},
				scrollbar : {
					enabled : false
				},
				tooltip: { enabled: false },
				navigator: {
					enabled: false
				},
				legend: {
					useHTML: true,
					
					width:((JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth<400)?JMA.JMAChart.Charts[idx].chart_object.legend.legendWidth:JMA.JMAChart.Charts[idx].chart_object.legend.maxItemWidth)+10,
				   
					itemStyle: {
					
					 fontSize: '11px'
					}
				},
				yAxis: {
						tickPositions: JMA.JMAChart.Charts[idx].chart_object.yAxis[0].tickPositions
					},
			});
		
		
		
		
			//setTimeout(function(){
			/* We pre-open the popup in the submit, since it was generated from a "click" event, so no popup block happens */
			authWindow = window.open(JMA.baseURL+'loading-share', 'Share', 'toolbar=0,status=0,width=626,height=436');
			
			$(authWindow.document.body).html('Loading preview...');
			authWindow.document.write('Loading preview...');
			/* do the AJAX call requesting for the authorize URL */
			//}, 100);
			//console.log(JMA.Export_url);
		$.ajax({
			type: 'POST',
			data: serialize_each_object({
				svg: chart_svg,
				type: 'image/png',
				async: true 
			}),
			async:false,
			
			//context: document.body,
			url: JMA.Export_url,
			beforeSend: function() { JMA.showLoading(); },
			 success: function (datas) {
		var title = $('meta[property="og:title"]').attr("content"),
		 description = $('meta[property="og:description"]').attr("content"),
		 loc = window.location.href;
		
		$.ajax({
			type: 'POST',
			data: {'imageUrl':datas,'title':title,'description':description,'loc':loc},
			url : JMA.baseURL + "socialmedia/saveimage",
			async:false,
			context: document.body,
			success: function (data) {
				
                if(data!='')
				{
					var root_ = location.protocol + '//' + location.hostname+ '/socialmedia/shareSocialmedia/' +data;
					var url = root_;
						switch (shareNetwork)
						{

							case 'facebook':
									authWindow.location.replace('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(url));
									authWindow.focus();
									authWindow.blur();
									//window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(url), '', 'toolbar=0,status=0,width=626,height=436');return false;
							    break;
							case 'twitter':
							authWindow.location.replace('https://twitter.com/share?url=' + encodeURIComponent(url));
									authWindow.focus();
									authWindow.blur();
								//window.open('https://twitter.com/share?url=' + encodeURIComponent(url), 'utm_source=article&utm_medium=tweet-button&utm_campaign=article-tweet', 'toolbar=0,status=0,width=626,height=436'); 
								break;
							case 'google+':	
							authWindow.location.replace('https://plus.google.com/share?url=' + encodeURIComponent(url));
									authWindow.focus();
									authWindow.blur();
								//window.open('https://plus.google.com/share?url=' + encodeURIComponent(url), 'share', 'toolbar=0,status=0,width=626,height=436');
								break;
							case 'linkedin':
								authWindow.location.replace('https://www.linkedin.com/cws/share?url=' + encodeURIComponent(url));
								authWindow.focus();
								authWindow.blur();	
								//window.open('https://www.linkedin.com/cws/share?url=' + encodeURIComponent(url), 'share', 'toolbar=0,status=0,width=626,height=436');
								break;	
						}

				}
				JMA.hideLoading();
     	    },
			error: function(e) 
			{
				JMA.hideLoading();
			  throw e;
			}
		});
			  
     	    }, 
			error: function(e) 
			{
				JMA.hideLoading();
			  throw e;
			}
		});
	
		

   }




	
	
	// Switch to barchart
	this.switchToBarChart = function(p_chart_idx,p_element,mobileView){
		if($(p_element).is(':checked')){
			this.switchGraph(p_chart_idx,'bar',mobileView);
		}else{
			this.switchGraph(p_chart_idx,'line',mobileView);
		}
		$("div.input-group-addon i.fa-minus").trigger('click');
	};
	
	// Switch to multiaxisline
	this.switchToMultiAxisLine = function(p_chart_idx,p_element,mobileView){
		if($(p_element).is(':checked')){
			this.switchGraph(p_chart_idx,'multiaxisline',mobileView);
		}else{
			this.switchGraph(p_chart_idx,'line',mobileView);
		}
		$("div.input-group-addon i.fa-minus").trigger('click');
	};
	
	// Download chart data
	this.downloadChartData = function(p_chart_idx) {
		var jq_frm_obj = $('#frm_download_chart_data_'+p_chart_idx);
		// JMA.JMAChart.Charts[p_chart_idx].Conf.isPremiumData
		var cht_codes_str = JMA.JMAChart.Charts[p_chart_idx].Conf.current_chart_codes.toString();
		
		jq_frm_obj.find('#frm_input_download_chart_codes_'+p_chart_idx).attr('value',cht_codes_str);
		jq_frm_obj.find('#frm_input_download_chart_datatype_'+p_chart_idx).attr('value',JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type);
		
		if(JMA.userDetails.hasOwnProperty('id') && JMA.userDetails.id>0) {
			
			try{
				if(JMA.JMAChart.Charts[p_chart_idx].Conf.isPremiumData == true) {
					if(JMA.userDetails.user_permissions.graph.datadownload.allowpremiumdatadownload == 'Y') {
						jq_frm_obj.submit();
					}
					else {
						JMA.User.showUpgradeBox('premium',JMA.JMAChart.Charts[p_chart_idx].Conf.share_chart.share_page_url);
					}
				}
				else {
					if(JMA.userDetails.user_permissions.graph.datadownload.allowdatadownload == 'Y') {
						jq_frm_obj.submit();
					}else {
						// Show membership upgrade form
						JMA.User.showUpgradeBox('download',p_chart_idx);
					}
				}
			} catch(e){
				JMA.User.showUpgradeBox('download',p_chart_idx);
			}
			
		} else {
			$.createCookie("downloadData",window.location.href);
			// Show log-in box
			JMA.User.showLoginBox('download',p_chart_idx);
			var currentUrl = window.location;
			var str = ""+currentUrl+"";
			var res = str.split('/').join('@'); 
			//var avoid = "@japanmacroadvisors@";
			//var test = res.replace(avoid, '');
			//var linkedInUrl = 'user/linkedinProcess/'+test+'code='+cht_codes_str+'datatype='+JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type;
			if(window.location.hostname == "localhost")
			{
				var href = window.location.href.split('/');
				var linkedInUrl = href[3]+'/user/linkedinProcess/?'+res;
			}
			else
			{
				var linkedInUrl = 'user/linkedinProcess/?'+res;
			}
			//+'index='+p_chart_idx
			$("a.linkedIn").attr("href", linkedInUrl);
		}
	};
	// Chart full screen - toggle
	this.switchChartFullscreen = function(spDvId){
		var elem = document.getElementById(spDvId);
		req = elem.requestFullScreen || elem.webkitRequestFullScreen || elem.mozRequestFullScreen || elem.msRequestFullscreen;
		req.call(elem);
		$( ".highcharts-dd" ).hide();
		
	};
	var nIntervId;
	this.screen=function(){  nIntervId = setInterval(this.flashText, 500);}
	this.flashText=function () {
		if(!(document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement)){
			$( ".highcharts-dd" ).show();
		}
	}
	
	this.initialize();
}

/**
 * Class myChart
 * Class for myChart functionality
 * @author shijo thomas
 */
 function myChart(myChartParams){

 	this.myFolder = {
 		currentView : 'largeView',
 		availableFolders : myChartParams.folderList,
 		currentFolder : {}
 	};
 	this.Config = {
 		flags : {
 			folderclick : false,
 			folserClickTimeout : null
 		}	
 	};
 	var self = this;
 	var SortableList = null;


	/**
	 * Constructor __construct
	 */
	 this.__construct = function(myChartParams){
		 
		    $("#saveFolderName").on("click", function(){
			  
				  $("#errFolderName").html("");
				  if($("#editfolderName").val()=="")
				  {
					   $("#errFolderName").html("Please enter folder name");
					   $("#editfolderName").focus();
					   return false;
				  }
				  else
				  {
						$("#errFolderName").html("");
						var $this = $(this);
						self.createFolder($this,$("#editfolderName").val());
				  }
			  
			});
			
			$(".add-folder").on("click", function(){
				if(!JMA.userDetails.hasOwnProperty('id')) {
					JMA.User.showLoginBox('mychart',JMA.baseURL + JMA.controller + "/" + (JMA.action == "index" ? '' : JMA.action + "/")+JMA.params);
				}
				
				
			});	
		 
		 
		 
		
	 	/* $('body').on('click', '.add-folder', function(e) {

	 		e.preventDefault();
	 		var $this = $(this);
	 		self.createFolder($this);
			//if(self.createFolder($this)){
				//JMA.myChart.myFolder.availableFolders.length
				
			//	}
		}); */
	   
	   
	   
	 	$('body').on('click', 'span.del' ,function(e) {
	 		e.preventDefault();
	 		e.stopPropagation();
	 		var $this = $(this);
	 		self.deleteFolder($this);
	 	});

	 	var 
	 	form = $('#content_midsection'),
	 	cache_width = form.width(),
		 a4  =[ 595.28,  3293];  // for a4 size paper width and height

		 //create pdf
		 function createPDF(){
		 	getCanvas().then(function(canvas){
		 		var 
		 		img = canvas.toDataURL("image/png"),
		 		doc = new jsPDF({
		 			unit:'px', 
		 			format:'a4'
		 		});     
		 		doc.addImage(img, 'JPEG', 20, 20);
		 		doc.save('techumber-html-to-pdf.pdf');
		 		form.width(cache_width);
		 	});
		 }
		 
		// create canvas object
		function getCanvas(){
			form.width((a4[0]*1.33333) -80).css('max-width','none');
			return html2canvas(form,{
				imageTimeout:2000,
				removeContainer:true
			}); 
		}
		
		$('body').on('click', '.print-mycharts' ,function(e) {
			e.preventDefault();
			e.stopPropagation();
			window.print();
			// content_midsection
			// window.print();
			 // doc.fromHTML($('#Dv_folder_content').html(), 15, 15, {
		  //       'width': 170,
		  //       'elementHandlers': specialElementHandlers
		  //   });
		  //   doc.save('sample-file.pdf');
			/*
		  $('body').scrollTop(0);
 			createPDF();
 			*/

 		});

		$('body').on('click', '.folder a', function(e) {

			e.preventDefault();
			e.stopPropagation();
			$this = $(this);

					

			if(self.Config.flags.folderclick == true){
				clearTimeout(self.Config.flags.folserClickTimeout);
				$this.find('span').attr('contentEditable', 'true').focus();
				self.Config.flags.folderclick = false;
				return false;
			}else{
				self.Config.flags.folderclick = true;
				self.Config.flags.folserClickTimeout = setTimeout(function(){
					self.Config.flags.folderclick = false;
					if(JMA.controller == 'mycharts' && JMA.action == 'index'){
						$('.folder').removeClass('selected');
						$this.closest('.folder').addClass('selected');
						var folderId = $this.find('span').data('id');
						self.initiateCurrentFolder(folderId);
						window.location.hash = '#'+folderId;
					}else{
						window.location = $this.attr('href');
					}
					
				},400);
			}
		});

		/*$('body').on('click', '.exhibit-title', function(e){
				alert(12);
			//e.preventDefault();
			//e.stopPropagation();
		});*/

		$('body').on('dblclick', '.exhibit-title', function(e){
			
			e.preventDefault();
			e.stopPropagation();
			$(this).attr('contentEditable', 'true').focus();
		});

		var touchtime = 0;
		$('body').on('click', '.exhibit-title', function(e){
	
    if(touchtime == 0) {
        touchtime = new Date().getTime();
    } else {
        if(((new Date().getTime())-touchtime) < 800) {
        
            $(this).attr('contentEditable', 'true').focus();
            touchtime = 0;
        } else {
        	$('.exhibit-title').attr('contentEditable', 'false');
            touchtime = 0;
        }
    } 
});


		$('body').on('blur', '.exhibit-title', function(e) {
			e.preventDefault();
			e.stopPropagation();
			$this = $(this);
			var title = $this.text();
			var order = $this.parents('.exhibit').data('order');
			var uuid = $this.parents('.exhibit').data('uuid');
			self.saveThisChartTitle(order,uuid,title);

			$(this).attr('contentEditable', 'false');
		});
		

		$('body').on('blur', '.folder span', function(e) {
			e.preventDefault();
			e.stopPropagation();
			if( "" === $(this).text() ) {
				$(this).text("My Folder");
			}
			var $this = $(this);
			self.renameFolder($this);
			$(this).attr('contentEditable', 'false');
		});
		
/**
 * @todo : Fix Chart editing
 */		
 $('body').on('click', '.noteContent', function(e) {
 	$this = $(this);
 	$this.attr('contenteditable', true).focus();
 	self.SortableList.option('disabled',true);
 	var elnId = $this.attr('id');
			//var order = $this.parent('.exhibit').data('order');
			var uuid = $this.parent('.exhibit').data('uuid');
			var order = self.getIndexByUuid(uuid);
			if(self.myFolder.currentFolder.charts[order].note_object == null) {
			//	CKEDITOR.disableAutoInline = true;

			self.myFolder.currentFolder.charts[order].note_object = CKEDITOR.inline( elnId,{
					//startupFocus: true
					removePlugins: 'tabletools,liststyle,contextmenu',
					//autoParagraph : false,
					//enterMode : 'br',
					//ShiftEnterMode : 'br',
					on: {
						blur: function( event ) {
							self.saveThisNoteContent(order,uuid);
							self.SortableList.option('disabled',false);
							$this.attr('contenteditable', false);
						},
						paste:function( event ) {
							return true;
						}
					}
				} );
			e.preventDefault();
			e.stopPropagation();
		}
	});

		// $(window).on('scroll', function(e) {
		// 	//console.log($(this).scrollTop());
		// 	var $leftside = $('.content_leftside');
		// 	var $mychart = $('.mychart-menu-set');
		// 	var targetTop = $leftside.offset().top + $leftside.outerHeight();
		// 	var abtop = $leftside.offset().top + $mychart.outerHeight();

		// 	if($(this).scrollTop() > targetTop) {

		// 		if(!$('.sub-menu.folders').hasClass('active')) {
		// 			$('.sub-menu.folders').addClass('active')
		// 			// $('.sub-menu.folders').css({
		// 			// 	position:'fixed',
		// 			// 	opacity: 0.4
		// 			// });
		// 			$('.sub-menu.folders').css({
		// 				width: '180px',
		// 				top: '10px',
		// 				opacity: '1',
		// 				position:'fixed'
		// 			}, 200);
		// 		}
		// 	} else if($(this).scrollTop() > abtop) {
		// 		if(!$('.sub-menu.folders').hasClass('sactive')) {
		// 			$('.sub-menu.folders').addClass('sactive')
		// 			var newtop = targetTop - abtop;
		// 			$('.sub-menu.folders').css({
		// 				position:'absolute',
		// 				opacity: 0.4
		// 			});
		// 			$('.sub-menu.folders').animate({
		// 				width: '180px',
		// 				top: newtop,
		// 				opacity: '1'
		// 			}, 200);
		// 		}
		// 	} else {
		// 		if($('.sub-menu.folders').hasClass('active') || $('.sub-menu.folders').hasClass('sactive')) {
		// 			$('.sub-menu.folders').removeClass('active');
		// 			$('.sub-menu.folders').removeClass('sactive');
		// 			$('.sub-menu.folders').css('position','static');
		// 			$('.sub-menu.folders').animate({
		// 				width: 'auto',
		// 				top: 'auto'
		// 			}, 200);
		// 		}

		// 	}
		// //	console.log($('.add-folder').offset());

		// });
		
$('body').on('click', 'ul.mobile-export li' , function(e) {
	var chartIndex =  $(this).closest('ul.mobile-export').data('mobileobj');
	var pType =  $(this).data('value');
	JMA.JMAChart.exportChart(chartIndex,pType);
});	

$('body').on('keydown','.exhibit-title',function(e){
	if (e.which != 8 && e.which != 37 && e.which != 39 && e.which != 46 && $(this).text().length > 50) {
		e.preventDefault();
	}
});
$('body').on('keydown','.folder-span-name',function(e){
	if ((e.which == 13) || (e.which != 8 && e.which != 37 && e.which != 39 && e.which != 46 && $(this).text().length > 16)) {
		e.preventDefault();
	}
});	


	//	$('body').on('blur', '.noteContent', function(e) {
			/*
			e.preventDefault();
			e.stopPropagation();
			//	alert("Saved...");
			//self.SortableList.option('disabled',false);
			$(this).attr('contenteditable', false);
			*/
	//	});


$(window).load(function() { 



	
if(JMA.controller == 'mycharts' && JMA.action == 'index'){
			// Event bindings
			// Folder Link
			$('body').on('click','.exhibit-tab li', function(e) {

				e.preventDefault();
				e.stopPropagation();

				var view = $(this).data('view');
				var chartOrder = $(this).data('order');
				var $exhibit = $(this).closest('.exhibit');
				
				$exhibit.find('.exhibit-tab li').removeClass('selected');

				$(this).addClass('selected');

				if('data' == view) {
					self.switchThisChartViewType(view,chartOrder);
					$exhibit.find('.table-view').removeClass('hide');
					$exhibit.find('.graph-view').addClass('hide');
					self.myFolder.currentFolder.charts[chartOrder].drawThisDataOnTable();
				} else {
					self.switchThisChartViewType(view,chartOrder);
					$exhibit.find('.table-view').addClass('hide');
					$exhibit.find('.graph-view').removeClass('hide');
				}
			});
			
			var $prevEx = null;
			$('body').on('click', '.chart_options' , function(e) {

				e.preventDefault();
				e.stopPropagation();
				// var $curEx =  $(this).closest('.exhibit').find('.over-lay-ctrl');
				// var status = $curEx.hasClass('hide');

				// $('.over-lay-ctrl').addClass('hide');
				// if($curEx.is($prevEx)) {

				// 	if(status) {
				// 		$curEx.removeClass('hide');
				// 	} else {
				// 		$curEx.addClass('hide');
				// 	}

				// } else {
				// 	$curEx.toggleClass('hide');
				// }

				$(this).next('.foldercontent-sub-menu').toggle("fast",function(){
					$('.foldercontent-sub-menu').not(this).hide();
				});


				// $prevEx = $curEx;


			});
			$('body').on('click', function(e) {
				var container = $(".foldercontent-sub-menu");

				    if (!container.is(e.target) // if the target of the click isn't the container...
				        && container.has(e.target).length === 0) // ... nor a descendant of the container
				    {
				    	container.hide();
				    }			});

			$('body').on('click', '.chart_edit' , function(e) {
				e.preventDefault();
				e.stopPropagation();
				var $curEx =  $(this).closest('.exhibit');
				var order = $curEx.data('order');
				var uuid = $curEx.data('uuid');
				self.editThisFolderContent('chart',order,uuid);

			});
			
			$('body').on('click', '.mychart_download_data' , function(e) {
				e.preventDefault();
				e.stopPropagation();
				var order =  $(this).closest('.exhibit').data('order');

				self.myFolder.currentFolder.charts[order].downloadChartData();
			});
			
			$('body').on('click', '.mychart_export' , function(e) {
				e.preventDefault();
				e.stopPropagation();
				var order =  $(this).closest('.exhibit').data('order');
					//JMA.myChart.myFolder.currentFolder.charts[order].exportChart();
				self.myFolder.currentFolder.charts[order].exportChart();
			});
			
			
			$('body').on('click', '.over-lay-ctrl' , function(e) {
				$('.over-lay-ctrl').addClass('hide');
				e.preventDefault();
			});

			$('body').on('click', '.duplicate', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$this = $(this);
				self.duplicateThisFolderContent($this);
			});

			$('body').on('click', '.exhibit.note textarea', function(e) {
				e.preventDefault();
				e.stopPropagation();
			});

			$('body').on('click', '.delete-ex', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$this = $(this);
				self.deleteThisFolderContent('chart',$this);
			});

			$('body').on('click', '.make-note-ex', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$this = $(this);
				self.createNewFolderContent('note',$this);
				//var $exhibit = $(this).closest('.exhibit');

				//var note =  '<div class="exhibit note"> <h4 class="exhibit-title" contenteditable="false">Note:</h4> <textarea name="" id="" cols="30" rows="10"></textarea> <div class="over-lay-ctrl hide"> <div class="ctrls"> <ul> <li class="duplicate"><a href="#"><i class="fa fa-copy"></i>Duplicate</a></li><li class="make-note-ex"><a href="#"><i class="fa fa-file-o"></i>Make a note</a></li><li  class="delete-note-ex"><a href="#"><i class="fa fa-remove"></i>Delete</a></li></ul> </div></div></div>';
				//$exhibit.after(note);

			});

			$('body').on('click', '.delete-note-ex', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$this = $(this);
				self.deleteThisFolderContent('note',$this);
			});	

			$('body').on('click', 'li.fpt_list', function(e) {
				//e.preventDefault();
				//e.stopPropagation();
				
			
					$( "div#fpt_list" ).find("div" ).remove();

				
				var folderId = window.location.hash.substring(1);
				
				self.initiateCurrentFolderListView(folderId);
			});

			$('body').on('click', 'li.fpt_large', function(e) {
				//e.preventDefault();
				//e.stopPropagation();
				$('#Dv_folder_content').empty();$('#Dv_folder_content').empty();
				var folderId = window.location.hash.substring(1);
				
				self.initiateCurrentFolder(folderId);




				
			});		

			$('body').on('click', 'li.fpt_small', function(e) {
				//e.preventDefault();
				//e.stopPropagation();
				var folderId = window.location.hash.substring(1);
				$('#Dv_folder_content_smallView').empty();
				self.initiateSmallCurrentFolder(folderId);
			});	
			
			var folderId = window.location.hash.substring(1);
			if(folderId == ""){
				

				var $folder = $('li.sub-menu.folders li.folder').first();
				folderId = $folder.find('a span').data('id');
				$folder.addClass('selected');
				self.initiateCurrentFolder(folderId);
				window.location.hash = '#'+folderId;
			}else{

				var $folder = $('li.sub-menu.folders li.folder [data-id="'+folderId+'"]').parents('li.sub-menu.folders li.folder');
				if($folder.length == 0){
					var $folder_first = $('li.sub-menu.folders li.folder').first();
					var folderId_first = $folder_first.find('a span').data('id');
					$folder_first.addClass('selected');
					self.initiateCurrentFolder(folderId_first);
					window.location.hash = '#'+folderId_first;
				}else{
					$folder.addClass('selected');
					//this.initiateSmallCurrentFolder(folderId);
					
					//this.initiateCurrentFolderListView(folderId);
					self.initiateCurrentFolder(folderId);
				}
				
			}

		}
		
		});
		
	};
	
	/**
	 * Funciton isCreateFolderAllowed
	 * Function to check permission to add folders
	 */
	 this.isCreateFolderAllowed = function(){
	 	try{
	 		if(JMA.myChart.myFolder.availableFolders.length < JMA.userDetails.user_permissions.mychart.totalFolders){
	 			return true;
	 		}else{
	 			return false;
	 		}
	 	}catch(Err){
	 		return false;
	 	}
	 };

	/**
	 * Funciton isAddChartAllowed
	 * Function to check permission to add charts to a specific folder
	 */
	 this.isAddChartAllowed = function(folder_id){
	 	var status = false;
	 	try{
	 		$.each(JMA.myChart.myFolder.availableFolders,function(idx, folderDetails){
	 			if(parseInt(folderDetails['folder_id']) == folder_id && folderDetails['total_charts'] < JMA.userDetails.user_permissions.mychart.totalChartsPerFolder){
	 				status = true;
	 			}
	 		});
	 	}catch(Err){
	 		return false;
	 	}
	 	return status;
	 };

	/**
	 * Function getChartObjectWithThisUuid
	 * Get chart object with specified UUID from chart object array 
	 */
	 this.getChartObjectWithThisUuid = function(uuId){
	 	
	 	for (var i=0; i < self.myFolder.currentFolder.charts.length; i++) {
	 		if (self.myFolder.currentFolder.charts[i].uuid === uuId) {
	 			return self.myFolder.currentFolder.charts[i];
	 		}
	 	}
	 };

	/**
	 * Function getIndexByUuid()
	 * get order (index) by uuid
	 */
	 this.getIndexByUuid = function(uuId){
	 	for (var i=0; i < self.myFolder.currentFolder.charts.length; i++) {
	 		if (self.myFolder.currentFolder.charts[i].uuid === uuId) {
	 			return i;
	 		}
	 	}
	 };

	/**
	 * Function saveLatestFolderContentOrder()
	 * Function to save latest folder content order. Calls on every sort action - drag and drop
	 */
	 this.saveLatestFolderContentOrder = function(){
	 	var new_order_array = [];
	 	var new_chart_object_array = [];

	 	if(self.myFolder.currentView=='largeView'){
	 			var parentDiv="#grids .exhibit";
	 	}else if(self.myFolder.currentView=='smallView'){
var parentDiv="#smallView_grids .exhibit";
	 	}else{
var parentDiv="#fpt_list .exhibit";
	 	}

	 	$.each($(parentDiv),function(i_cnt,elm){
	 			if(self.myFolder.currentView=='listView'){
	 				$('div.exhibit:eq("'+i_cnt+'") ul.list-inline li.serial').text(i_cnt + 1);
	 			}
	 
	 		var uuId = $(elm).data('uuid');	//alert(uuId);
	 		new_order_array.push(uuId);
	 		new_chart_object_array.push(self.getChartObjectWithThisUuid(uuId));
	 	});
	 	self.myFolder.currentFolder.charts = new_chart_object_array;

	 	$.ajax({
	 		url : JMA.baseURL + "mycharts/folder/reorder",
	 		dataType : 'json',
	 		type : 'POST',
	 		data : {'new_order' : new_order_array, 'folder_id' : self.myFolder.currentFolder.id},
	 		beforeSend: function() { JMA.showLoading(); },
	 		success : function(response){
	 			if(response.status!=1){
	 				JMA.handleErrorWithMessage(response.message);
	 			}else{
					// alert("Folder Saved");
				}
				JMA.hideLoading();
			},
			error : function(){
				JMA.showLoading();
				JMA.hideLoading();
			}
		});		
	 };

	/**
	 * Function activateDragAndOrderCharts
	 * Function to activate drag and order charts displayed in a folder
	 */
	 this.activateDragAndOrderCharts = function(){
		// Drag and drop

		if(self.myFolder.currentView=='largeView'){
		var list = document.getElementById("grids");
		if(list){

			var mq = window.matchMedia( "(min-width: 1024px)" );
	 	if (mq.matches) {

	 		self.SortableList = new Sortable(grids,{
				filter : '.noteContent, .abs-menus, .exhibit-tab',
				draggable : '.exhibit',
				scroll : true,
				onEnd: function (evt) {
					console.log($(evt.item).index('.grids .exhibit'));
					JMA.myChart.myFolder.currentView='largeView';
					self.saveLatestFolderContentOrder();
					self.reorderPagination();

					
				}
			}); // That's all.

	 		} 

			
}
}



		// Enable drag and drop for Listwiew

if(self.myFolder.currentView=='listView'){
		var list_view = document.getElementById("fpt_list");
		if(list_view){
		
			self.SortableList = new Sortable(list_view,{
				filter : '.noteContent, .abs-menus, li.abs-parent-menus, .exhibit-tab',
				draggable : '.exhibit',
				//ghostClass: 'sortable-ghost',
				scroll : true,
				onEnd: function (evt) {
				console.log($(evt.item).index('#fpt_list .exhibit'));
				JMA.myChart.myFolder.currentView='listView';
				self.saveLatestFolderContentOrder();
				self.reorderPagination();
				}

				
			}); 
		}

	}




			// Enable drag and drop for SmallView
			if(self.myFolder.currentView=='smallView'){
var container = document.getElementById("smallView_grids");
	if(container){
	// Multi groups
	
		var mq = window.matchMedia( "(min-width: 767px)" );
	 	if (mq.matches) {
self.SortableList = new Sortable(container, {
		animation: 150,
		ghostClass: 'sortable-ghost',
		draggable: '.ftps_holconmin',
		handle: '.page-title',
		scroll : true,
		onEnd: function (evt) {
			//console.log('onAdd.foo:', [evt.item, evt.from]);
					JMA.myChart.myFolder.currentView='smallView';
					self.saveLatestFolderContentOrder();
					$('.ftps_holconmin').each(function(i,el) {
    $(this).find('div.page-title h4').html("PAGE "+(i+1)+" <i class='fa fa-arrows' aria-hidden='true'></i>");

});
					
					}
	});

	[].forEach.call(container.getElementsByClassName('ftps_holcon'), function (el){
self.SortableList = new Sortable(el, {
			group: 'photo',
			ghostClass: 'sortable-ghost',
			group: 'words',
			draggable:  '.exhibit',
			scroll : true,
			animation: 150,
			pull: true,
		put: true,
		onAdd: function (evt){ 
		if((evt.item.parentElement.childElementCount)==5){
		$(evt.item.parentElement.children[4]).prependTo(evt.from);
		
		}

	},
	onEnd: function (evt) {
					JMA.myChart.myFolder.currentView='smallView';
					self.saveLatestFolderContentOrder();
					//self.reorderPagination();
					}

		});
	});

}
}
}
	};
	
	/**
	 * Function deActivateDragAndOrderCharts
	 * Function to de-activate drag and order charts displayed in a folder
	 */
	 this.deActivateDragAndOrderCharts = function(){	
	 	var list = document.getElementById("grids");
	 	if(list){
	 		var sortable = Sortable.create(list,{
	 			disabled : true
			}); // That's all.
	 	}

/*// Disable drag and drop for Listwiew
var list_view = document.getElementById("fpt_list");
if(list_view){
	var sortable = Sortable.create(list,{
		disabled : true
			}); // That's all.
}*/

//sortable.destroy();

};


	/**
	 * Function createFolder
	 */
	 this.createFolder = function($this,folderName){
	 	try{
	 		if(JMA.userDetails.hasOwnProperty('id') && JMA.userDetails.id>0) {
	 			if(self.isCreateFolderAllowed() == true){
	 				var user_id = JMA.userDetails.id;
	 				var folder_name = folderName;
	 				$.ajax({
	 					url : JMA.baseURL + "mycharts/folder/create",
	 					dataType : 'json',
	 					type : 'POST',
	 					data : {'folder_name' : folder_name,'user_id' : user_id},
	 					beforeSend: function() { JMA.showLoading(); },
	 					success : function(response){
							console.log(response.result);
	 						if(response.status!=1){
	 							if(response.status == 1001){
	 								if(JMA.userDetails.user_type == 'individual' || JMA.userDetails.user_type == 'corporate'){
	 									self.showFolderCreationRestricted();
	 								}else{
	 									JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
	 								}
	 							}else{
	 								JMA.handleErrorWithMessage(response.message);
	 							}
	 						}else{
								
								 $('#modaladd_folder').modal('hide');
								//Old
								//var content = '<li class="folder list-group-item"><a href="mycharts/#'+response.result.folder_id+'"><i class="fa fa-folder"></i> <span contentEditable="false" data-foldername="My Folder" data-id="'+response.result.folder_id+'">My Folder</span></a><span class="del">&nbsp;<i class="fa fa-trash"></i></span></li>';
								var content = '<li class="folder"><a href="mycharts/#'+response.result.folder_id+'"><i class="fa fa-folder"></i> <span contentEditable="false" data-foldername="My Folder" data-id="'+response.result.folder_id+'">'+folderName+'</span></a><span class="del">&nbsp;<i class="fa fa-trash"></i></span></li>';
								//$this.before(content);
								$('.add-folder').before(content);
								self.getAndUpdateAllFoldersList(
									function(){
										self.refreshFolderListViewInAllDropDowns();
									}
									);
								//location.reload(); 
							}
							JMA.hideLoading();
						},
						error : function(){
							JMA.hideLoading();
							JMA.handleError();
						}
					});
}else{
	if(JMA.userDetails.user_type == 'individual' || JMA.userDetails.user_type == 'corporate'){
		self.showFolderCreationRestricted();
	}else{
		JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
	}
}
}else{
	JMA.User.showLoginBox('mychart',JMA.baseURL + JMA.controller + "/" + (JMA.action == "index" ? '' : JMA.action + "/")+JMA.params);
}
}catch(Err){

}
};

	/**
	 * Function renameFolder
	 */
	 this.renameFolder = function($this){
	 	try{
	 		var folderId = $this.data('id');
	 		$.ajax({
	 			url : JMA.baseURL + "mycharts/folder/rename",
	 			dataType : 'json',
	 			type : 'POST',
	 			data : { 'folder_name' : $this.text(), 'folder_id': folderId },
	 			beforeSend: function() { JMA.showLoading(); },
	 			success : function(response){
	 				if(response.status!=1){
	 					JMA.handleErrorWithMessage(response.message);
	 				}else{
	 					if(self.myFolder.currentFolder.hasOwnProperty('id')){
	 						if(folderId == self.myFolder.currentFolder.id){
	 							self.initiateCurrentFolder(folderId);
	 						}
	 					}else {
	 						self.getAndUpdateAllFoldersList(
	 							function(){
	 								self.refreshFolderListViewInAllDropDowns();
	 							}
	 							);
	 					}
	 				}
	 				JMA.hideLoading();
	 			},
	 			error : function(){
	 				JMA.hideLoading();
	 				JMA.handleError();
	 			}
	 		});
	 	}catch(Err){

	 	}
	 };

	/**
	 * Function getandUpdateAllFoldersList
	 * Get all folder list from server and update object
	 */
	 this.getAndUpdateAllFoldersList = function(callBack){
	 	try{
	 		$.ajax({
	 			url : JMA.baseURL + "mycharts/folder/getallfolders",
	 			dataType : 'json',
	 			type : 'POST',
	 			data : {},
	 			beforeSend: function() { JMA.showLoading(); },
	 			success : function(response){
	 				self.myFolder.availableFolders = response.result;
	 				if(typeof(callBack) == 'function'){
	 					callBack();
	 				}
	 				JMA.hideLoading();
	 			},
	 			error : function(){
	 				JMA.hideLoading();
	 				JMA.handleError();
	 			}
	 		});
	 	}catch(Err){

	 	}
	 };

	/**
	 * Function refreshFolderListViewInAllDropDowns
	 * This function will refresh folder list in all dropdowns for save graph to.
	 */
	 this.refreshFolderListViewInAllDropDowns = function(){
		// Handle no folder list
		var select_option_content = '';
		if(self.myFolder.availableFolders.length == 0){
			select_option_content+= "";
		}else{
			$.each(self.myFolder.availableFolders,function(idx,folderDetails){
				if(idx<JMA.userDetails.user_permissions.mychart.totalFolders){
					select_option_content+="<option value='"+folderDetails['folder_id']+"'>"+folderDetails['folder_name']+"</option>";
				}
			});
		}
		$('.mychart-select-addto-folder').html(select_option_content);
	};
	
	/**
	 * Functionn deleteFolder
	 */
	 this.deleteFolder = function($this){
	 	try{
	 		var folderId = $this.prev('a').find('span').data('id');
	 		if(typeof(folderId) == 'undefined'){
	 			JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
	 		}else{
	 			$.ajax({
	 				url : JMA.baseURL + "mycharts/folder/delete",
	 				dataType : 'json',
	 				type : 'POST',
	 				data : { folder_id: folderId },
	 				beforeSend: function() { JMA.showLoading(); },
	 				success : function(response){
	 					if(response.status!=1){
	 						JMA.handleErrorWithMessage(response.message);
	 					}else{
	 						$this.closest('.folder').remove();
							//Refresh Folder List
							var $folder = $('li.sub-menu.folders li.folder').first();
							if($folder.hasClass('lnk_inactive')){
								location.reload(); 
							}else{
								self.getAndUpdateAllFoldersList(
									function(){
										self.refreshFolderListViewInAllDropDowns();
									}
									);
								if(self.myFolder.currentFolder.hasOwnProperty('id')){
									if(folderId == self.myFolder.currentFolder.id){
									// Change selected folder
									var $folder = $('li.sub-menu.folders li.folder').first();


									var folder_new_Id = $folder.find('a span').data('id');
									self.initiateCurrentFolder(folder_new_Id);
									window.location.hash = '#'+folder_new_Id;
									$folder.addClass('selected');
								}
							}
						}
					}
					JMA.hideLoading();
				},
				error : function(){
					JMA.hideLoading();
					JMA.handleError();
				}
			});
}
}catch(Err){
	JMA.handleError();
}
};

	/**
	 * Funciton - initiateCurrentFolder
	 * initiates and create current folder details and object
	 */
	 this.initiateCurrentFolder = function(folderId){
     self.myFolder.currentView = 'largeView';
	 	try{
			// Get list of charts for selected folder
			// create array or chart objects
			$.ajax({
				url : JMA.baseURL + "mycharts/folder/getthisfolderdata",
				dataType : 'json',
				type : 'POST',
				data : { folder_id: folderId },
				beforeSend: function() { JMA.showLoading(); },
				success : function(response){
					if(response.status!=1){
						JMA.handleErrorWithMessage(response.message);
					}else{
						// save curent folder values
						var current_folder_values = {
							name : response.result.folderData.name,
							id : response.result.folderData.id,
							status : response.result.folderData.status,
							charts : []
						};

						if(Array.isArray(response.result.folderData.content) == true){
							$.each(response.result.folderData.content,function(order,folderContent){
								current_folder_values.charts[order] = new charts(order,folderContent);
							});
						}

						self.myFolder.currentFolder = current_folder_values; 
						self.writeSelectedFolderName();
						
						// Draw all charts/notes placeholders
						self.drawFolderContents(); 
						// Draw charts/notes on placeholders
						self.drawChartsAndNotesOnPlaceholders();	

						

					}
					JMA.hideLoading();
				},
				error : function(e){
					console.log(e);
					JMA.hideLoading();
					//JMA.handleError();
				}
			});

}catch(Err){
	JMA.handleError();
}
};




/**
	 * Funciton - initiateCurrentFolderListView
	 * initiates and create current folder details and object for list View
	 */
	 this.initiateCurrentFolderListView = function(folderId){
	 	self.myFolder.currentView = 'listView';
	 	try{
			// Get list of charts for selected folder
			// create array or chart objects
			$.ajax({
				url : JMA.baseURL + "chart/getchartListdata",
				dataType : 'json',
				type : 'POST',
				data : { folder_id: folderId },
				beforeSend: function() { JMA.showLoading(); },
				success : function(response){
					if(response.status!=1){
						JMA.handleErrorWithMessage(response.message);
					}else{
					var current_folder_values = {
							name : response.result.folderData.name,
							id : response.result.folderData.id,
							status : response.result.folderData.status,
							charts : []
						};

						if(Array.isArray(response.result.folderData.content) == true){
							$.each(response.result.folderData.content,function(order,folderContent){
							
								current_folder_values.charts[order] = new charts(order,folderContent);

							});
						}

						self.myFolder.currentFolder = current_folder_values;

					self.DrawListContents(response.listView);
					self.drawChartsAndNotesOnPlaceholders();	
					JMA.hideLoading();	
					}
					
				},
				error : function(){
					JMA.hideLoading();
					JMA.handleError();
				}
			});
			
		}catch(Err){
			JMA.handleError();
		}
	};






	/*
	 * Funciton - DrawListContents 
	 * initiates and create current folder details and object
	 */

	 this.DrawListContents = function(response){
	 	var listview_content='';

	 	if(Array.isArray(response) == true && response.length > 0){

	 		var pageCount=0;
	 		$.each(response,function(order,folderContent){
	 			if(order==0){

	 				listview_content+='<div class="main-title page-title"><h1 class="">'+folderContent.folder_name+'</h1><div class="mttl-line"></div></div><div class="right-menus mychart_exppri"> <ul class="top-m list-inline"> <li> <a href="#" class="btn btn-primary print-mycharts"> <i class="fa fa-print"></i> <span>Print</span> </a> </li> </ul> <br/></div>';

	 			}
	 			if(order%4 == 0){
	 				pageCount++;
	 				listview_content+='<div class="page-title"><div class="sec-title"><h1 class="">PAGE '+pageCount+'</h1><div class="sttl-line"></div></div><div  class="table fpt_table list-view"> <ul class="list-inline"> <li>S.No</li> <li>Title</li> <li>Details</li> <li>Edit</li> </ul> </div></div>';
	 			}
	 				var note_conc='';var $edit_menu='';
	 			if(folderContent.chart_view_type=='note'){
	 				var fa_icon="fa-file-text-o";
					
					var note_conc='note-';
	 			}else if(folderContent.chart_view_type=='chart'){
	 				var fa_icon="fa-line-chart";
	 				var $edit_menu='<li><a draggable="false" href="#" class="mychart_download_data"><i class="fa fa-download"></i>Download data</a></li>'+
	 			'<li><a draggable="false" href="#" class="mychart_export"><i class="fa fa-file-photo-o"></i>Export</a></li><li class="mychart-menu-edit"><a draggable="false" href="#" class="chart_edit"><i class="fa fa-cog"></i>Edit</a></li>';
	 			}else if(folderContent.chart_view_type=='map'){
	 				var fa_icon="fa-line-chart";
	 				var $edit_menu='<li><a draggable="false" href="#" class="mychart_download_data"><i class="fa fa-download"></i>Download data</a></li>'+
	 			'<li><a draggable="false" href="#" class="mychart_export"><i class="fa fa-file-photo-o"></i>Export</a></li><li class="mychart-menu-edit"><a draggable="false" href="#" class="chart_edit"><i class="fa fa-cog"></i>Edit</a></li>';
	 			}
				else{
	 				var fa_icon="fa-table";
	 				var $edit_menu='<li><a draggable="false" href="#" class="mychart_download_data"><i class="fa fa-download"></i>Download data</a></li>'+
	 			'<li><a draggable="false" href="#" class="mychart_export"><i class="fa fa-file-photo-o"></i>Export</a></li><li class="mychart-menu-edit"><a draggable="false" href="#" class="chart_edit"><i class="fa fa-cog"></i>Edit</a></li>';
	 			}
	 			listview_content+='<div class="chart_listview exhibit" draggable="false" data-order="'+order+'" data-uuid="'+folderContent.uuid+'" ><ul class="list-inline"> <li class="serial">'+(order+1)+'</li><li><i class="fa '+fa_icon+'" aria-hidden="true"></i> '+folderContent.title+'</li>'+
	 			'<li> <ul class="list-unstyled" >';

	 			if((folderContent.chart_view_type!='note' && Array.isArray(folderContent.charts_fields_available) == true) && (folderContent.chart_view_type!='map' && Array.isArray(folderContent.charts_fields_available) == true)){

	 				$.each(folderContent.charts_fields_available,function(i,charts_fields_available){

	 					listview_content+='<li class="">'+charts_fields_available+'</li>';
	 				});
	 			}else{

	 				listview_content+='<li class="">'+folderContent.note_content+'</li>';
	 			}
	 			listview_content+='</ul></li>';

	 			var Menu='<ul class="abs-menus">'+
	 			'<li class="floatleft"><a draggable="false" href="#" class="chart_options"><i class="fa fa-bars"></i></a>'+
	 			'<ul class="foldercontent-sub-menu" style="display: none;">'+
	 			'<li class="duplicate"><a draggable="false" href="#"><i class="fa fa-copy"></i>Duplicate</a></li>'+
	 			'<li class="delete-'+note_conc+'ex"><a draggable="false" href="#"><i class="fa fa-remove"></i>Delete</a></li>'+$edit_menu+
	 			'</ul>'+
	 			'</li>'+
	 			'</ul>';

	 			listview_content+='<li draggable="false" class="abs-parent-menus">'+Menu+'</li></ul></div>';


	 		});
listview_content+='<div class="main-title page-title page-title-no-line"></div>';

}else{

	listview_content+='<div class="full-width text-center text-danger"><ul class="list-inline"> <li class="col-md-12">Charts , Tables, Note is not found</li></ul></div>';
}

$('table.list-view').after(listview_content);


}


/**
	 * Funciton - initiateSmallCurrentFolder
	 * initiates and create current folder details and object
	 */
	 this.initiateSmallCurrentFolder = function(folderId){
	 	try{
			// Get list of charts for selected folder
			// create array or chart objects
			$.ajax({
				url : JMA.baseURL + "mycharts/folder/getthisfolderdata",
				dataType : 'json',
				type : 'POST',
				data : { folder_id: folderId },
				beforeSend: function() { JMA.showLoading(); },
				success : function(response){
					if(response.status!=1){
						JMA.handleErrorWithMessage(response.message);
					}else{
						// save curent folder values
						var current_folder_values = {
							name : response.result.folderData.name,
							id : response.result.folderData.id,
							status : response.result.folderData.status,
							charts : []
						};
						if(Array.isArray(response.result.folderData.content) == true){
							$.each(response.result.folderData.content,function(order,folderContent){
								current_folder_values.charts[order] = new charts(order,folderContent);
							});
						}
						self.myFolder.currentFolder = current_folder_values;

						self.myFolder.currentView='smallView';



						//self.writeSelectedFolderName();
						// Draw all charts/notes placeholders
						self.drawFolderContents();
						// Draw charts/notes on placeholders
						self.drawChartsAndNotesOnPlaceholders();
					}
					JMA.hideLoading();
				},
				error : function(){
					JMA.hideLoading();
					JMA.handleError();
				}
			});

}catch(Err){
	JMA.handleError();
}
};




	/**
	 * Function -saveThisChartToFolder
	 * Saves selected chart onto a folder.
	 */
	 this.saveThisMapToFolder = function(chartIndex){
	 	try {
	 		var selectedFolder = $('#save_chart_select_folder_'+chartIndex).val();
	 		if(self.isAddChartAllowed(selectedFolder) == true){
	 			var $highchart = $("#Chart_Dv_placeholder" + "_" + chartIndex ).find('.highcharts-container');
	 			var $clonee = $highchart.clone();
	 			var $folder = $('li.sub-menu.folders li.folder [data-id="'+selectedFolder+'"]').parents('li.sub-menu.folders li.folder');


	 			$clonee.css({
	 				position: 'absolute', 
	 				top: $highchart.offset().top, 
	 				left: $highchart.offset().left, 
	 				zIndex: 99999,
	 				border: '1px solid #333'
	 			});

	 			$('body').append($clonee);


	 			$clonee.animate({
	 				left: $folder.offset().left+13,
	 				top: $folder.offset().top+8,
	 				opacity: 0.4,
	 				width: '10px',
	 				height: '10px'
	 			}, 1500,'easeInOutQuint', function() {
	 				$clonee.remove();
	 			});
				// setTimeout(function(){
				// 	$('html,body').animate({ scrollTop: 0 }, 1000);
				// }, 500);

$folder.find('i').removeClass('fa-folder');
$folder.find('i').addClass('fa-folder-open');
$folder.addClass('fontColorOrange');
$folder.animate({
	//'font-size': '15px'
},30);
$folder.animate({
	//'font-size': '12px'
},30);
setTimeout(function(){
	$folder.animate({
		//'font-size': '15px'
	},20);
	$folder.animate({
		//'font-size': '12px'
	},20);
	$folder.find('i').removeClass('fa-folder-open');
	$folder.find('i').addClass('fa-folder');
	$folder.removeClass('fontColorOrange');
}, 1600);


var tmp_first_chart_code = JMA.JMAChart.Charts[chartIndex].Conf.current_chart_codes[0]; 

var chart_uuid = JMA.generateUUID()+"-"+JMA.userDetails.id+selectedFolder;

var postData = {
	folder_id : selectedFolder,
	chart_data : {
		type : 'map',
		chart_view_type : 'map',
		uuid : chart_uuid,
		title : JMA.JMAChart.Charts[chartIndex].Conf.mapTitle,
		chart_code : JMA.JMAChart.Charts[chartIndex].createChartCodeFromConfig(),
		note_content : JMA.JMAChart.Charts[chartIndex].Conf.selectStateKeys,
		chart_data_type : JMA.JMAChart.Charts[chartIndex].Conf.chart_data_type,
		current_chart_codes : JMA.JMAChart.Charts[chartIndex].Conf.current_chart_codes,
		isChartTypeSwitchable : JMA.JMAChart.Charts[chartIndex].Conf.isChartTypeSwitchable,
		navigator_date_from : JMA.JMAChart.Charts[chartIndex].Conf.navigator_date_from,
		navigator_date_to : JMA.JMAChart.Charts[chartIndex].Conf.navigator_date_to,
		chartType : JMA.JMAChart.Charts[chartIndex].Conf.chartType,
		chart_codes_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_codes_available,
		chart_labels_available : JMA.JMAChart.Charts[chartIndex].Conf.chart_labels_available,
		chartLayout : 'normal',
		isMultiaxis : JMA.JMAChart.Charts[chartIndex].Conf.chartType == 'multiaxisline' ? true : false,
		isNavigator : JMA.JMAChart.Charts[chartIndex].Conf.isNavigator,
		charts_fields_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_fields_available,
		charts_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_available,
		statename : JMA.JMAChart.Charts[chartIndex].Conf.selectStateKeys
		/* chart_code : JMA.JMAChart.Charts[chartIndex].createChartCodeFromConfig(),
		note_content : '',
		chart_data_type : JMA.JMAChart.Charts[chartIndex].Conf.chart_data_type,
		current_chart_codes : JMA.JMAChart.Charts[chartIndex].Conf.current_chart_codes,
		isChartTypeSwitchable : JMA.JMAChart.Charts[chartIndex].Conf.isChartTypeSwitchable,
		navigator_date_from : JMA.JMAChart.Charts[chartIndex].Conf.navigator_date_from,
		navigator_date_to : JMA.JMAChart.Charts[chartIndex].Conf.navigator_date_to,
		chartType : JMA.JMAChart.Charts[chartIndex].Conf.chartType,
		chart_codes_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_codes_available,
		chart_labels_available : JMA.JMAChart.Charts[chartIndex].Conf.chart_labels_available,
		chartLayout : 'normal',
		isMultiaxis : JMA.JMAChart.Charts[chartIndex].Conf.chartType == 'multiaxisline' ? true : false,
		isNavigator : JMA.JMAChart.Charts[chartIndex].Conf.isNavigator,
		charts_fields_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_fields_available,
		charts_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_available */
	}
};

               //console.log(postData);  return false;

				// Save data
				$.ajax({
					url : JMA.baseURL + "mycharts/chart/addtofolder",
					dataType : 'json',
					type : 'POST',
					data : postData,
					beforeSend: function() { JMA.showLoading(); },
					success : function(response){
						//console.log(JSON.stringify(response, null, 4));
						if(response.status!=1){
							if(response.status == 1001){
								if(JMA.userDetails.user_type == 'individual' || JMA.userDetails.user_type == 'corporate'){
									self.showFolderCreationRestricted();
								}else{
									JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
								}
							}else{
								JMA.handleErrorWithMessage(response.message);
							}
						}else{
							// alert("Folder Saved");
						}
						JMA.hideLoading();
					},
					error : function(){
						JMA.hideLoading();
						JMA.handleError();
					}
				});
				$('.h_graph_top_area').find('.nav-txt').removeClass('active');
				$('.h_graph_top_area').find('.sub-nav').removeClass('open');
				$('.h_graph_top_area').find('.sub-nav').hide();
			}else{
				JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
			}
		}catch(Err){
			
		}
	};



	/**
	 * Function -saveThisChartToFolder
	 * Saves selected chart onto a folder.
	 */
	 this.saveThisChartToFolder = function(chartIndex){
	 	try {
	 		var selectedFolder = $('#save_chart_select_folder_'+chartIndex).val();
	 		if(self.isAddChartAllowed(selectedFolder) == true){
				
	 			 
				 if($('.h_graph_content_area_'+chartIndex).css('display')== 'none')
				 {
					 var $highchart = $("#Chart_Dv_placeholder" + "_" + chartIndex ).find('#Table_Dv_placeholder_'+ chartIndex);
	 			     var $clonee = $highchart.clone();
				 }
				 else
				 {
					 var $highchart = $("#Chart_Dv_placeholder" + "_" + chartIndex ).find('.highcharts-container');
	 			     var $clonee = $highchart.clone();
				 }
	 			var $clonee = $highchart.clone();
	 			//var $folder = $('li.sub-menu.folders li.folder [data-id="'+selectedFolder+'"]').parents('li.sub-menu.folders li.folder');
				
				var $folder = $('div.menu-wrap div.icon-list i.fa-bar-chart');
				
				


	 			$clonee.css({
	 				position: 'absolute', 
	 				top: $highchart.offset().top, 
	 				left: $highchart.offset().left, 
	 				zIndex: 99999,
	 				border: '1px solid #333'
	 			});

	 			$('body').append($clonee);


	 			$clonee.animate({
	 				left: $folder.offset().left+13,
	 				top: $folder.offset().top+8,
	 				opacity: 0.4,
	 				width: '10px',
	 				height: '10px'
	 			}, 1500,'easeInOutQuint', function() {
	 				$clonee.remove();
	 			});
				// setTimeout(function(){
				// 	$('html,body').animate({ scrollTop: 0 }, 1000);
				// }, 500);
				
				
			

//$folder.find('i');
//$folder.find('i');
//$folder.addClass('fontColorOrange');
$folder.animate({
	//'font-size': '15px'
},30);
$folder.animate({
	//'font-size': '12px'
},30);
setTimeout(function(){
	$folder.animate({
		//'font-size': '15px'
	},20);
	$folder.animate({
		//'font-size': '12px'
	},20);
	//$folder.find('i').removeClass('fa-folder-open');
	//$folder.find('i').addClass('fa-folder');
	//$folder.removeClass('fontColorOrange');
}, 1600);


var tmp_first_chart_code = JMA.JMAChart.Charts[chartIndex].Conf.current_chart_codes[0]; 

var chart_uuid = JMA.generateUUID()+"-"+JMA.userDetails.id+selectedFolder;

 var chartViewType = 'chart';
 if($('.h_graph_content_area_'+chartIndex).css('display')== 'none')
 {
	 chartViewType = 'data';
 }


var Arr = [''];
var postData = {
	folder_id : selectedFolder,
	chart_data : {
		type : 'chart',
		chart_view_type : chartViewType,
		uuid : chart_uuid,
		title : JMA.JMAChart.Charts[chartIndex].Conf.chart_labels_available[tmp_first_chart_code],
		chart_code : JMA.JMAChart.Charts[chartIndex].createChartCodeFromConfig(),
		color_code : (JMA.JMAChart.Charts[chartIndex].Conf.chartColor.length > 0)? JMA.JMAChart.Charts[chartIndex].Conf.chartColor : Arr,
		color_series : (JMA.JMAChart.Charts[chartIndex].Conf.chartColorSeries.length > 0) ? JMA.JMAChart.Charts[chartIndex].Conf.chartColorSeries : Arr,
		color_status : 'true',
		mychart_color_code : (JMA.JMAChart.Charts[chartIndex].Conf.commonColorCode[0] != "") ? JMA.JMAChart.Charts[chartIndex].Conf.commonColorCode : Arr,
		note_content : '',
		chart_data_type : JMA.JMAChart.Charts[chartIndex].Conf.chart_data_type,
		current_chart_codes : JMA.JMAChart.Charts[chartIndex].Conf.current_chart_codes,
		isChartTypeSwitchable : JMA.JMAChart.Charts[chartIndex].Conf.isChartTypeSwitchable,
		navigator_date_from : JMA.JMAChart.Charts[chartIndex].Conf.navigator_date_from,
		navigator_date_to : JMA.JMAChart.Charts[chartIndex].Conf.navigator_date_to,
		chartType : JMA.JMAChart.Charts[chartIndex].Conf.chartType,
		chart_codes_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_codes_available,
		chart_labels_available : JMA.JMAChart.Charts[chartIndex].Conf.chart_labels_available,
		chartLayout : 'normal',
		isMultiaxis : JMA.JMAChart.Charts[chartIndex].Conf.chartType == 'multiaxisline' ? true : false,
		isNavigator : JMA.JMAChart.Charts[chartIndex].Conf.isNavigator,
		charts_fields_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_fields_available,
		charts_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_available
	}
};

				// Save data
				$.ajax({
					url : JMA.baseURL + "mycharts/chart/addtofolder",
					dataType : 'json',
					type : 'POST',
					data : postData,
					beforeSend: function() { JMA.showLoading(); },
					success : function(response){
						console.log(JSON.stringify(response, null, 4));
						if(response.status!=1){
							if(response.status == 1001){
								if(JMA.userDetails.user_type == 'individual' || JMA.userDetails.user_type == 'corporate'){
									self.showFolderCreationRestricted();
								}else{
									JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
								}
							}else{
								JMA.handleErrorWithMessage(response.message);
							}
						}else{
							// alert("Folder Saved");
						}
						JMA.hideLoading();
					},
					error : function(){
						JMA.hideLoading();
						JMA.handleError();
					}
				});
				$('.h_graph_top_area').find('.nav-txt').removeClass('active');
				$('.h_graph_top_area').find('.sub-nav').removeClass('open');
				$('.h_graph_top_area').find('.sub-nav').hide();
			}else{
				JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
			}
		}catch(Err){
			
		}
	};
	
	/**
	 * Function drawFolderContents
	 * Draws all folder content onto view - charts and notes
	 * Create placeholders for charts and notes
	 */
	 this.drawFolderContents = function(){



	 	if(this.myFolder.currentView == 'largeView') {
	 		var folderContentLayout_object = Handlebars.compile($('#template_mychart_folder_content').html());
	 		var folderContentLayout = folderContentLayout_object();
	 		$('#Dv_folder_content').html(folderContentLayout);


	 		var pageCount = 0;
	 		$.each(self.myFolder.currentFolder.charts, function(order,chartDetails){

	 			

	 			if(order%4 == 0){
	 				pageCount++;
	 				if(pageCount ==1){
	 					$(grids).append('<div class="col-xs-12 pad0 page page-title"><div class="sec-title"><h1 class="">PAGE '+(pageCount)+'</h1><div class="sttl-line"></div></div></div>');
	 				}else{
	 					$(grids).append('<div class="col-xs-12 padl0  page2 page-title"><div class="sec-title"><h1 class="page2">PAGE '+(pageCount)+'</h1><div class="sttl-line"></div></div></div>');
	 				}
	 			}
	 			if(chartDetails.type == 'chart' || chartDetails.type == 'map'){



				//  Get chart Data. ajax
				if(order < JMA.userDetails.user_permissions.mychart.totalChartsPerFolder) {
					$(grids).append(chartDetails.getThisChartLayouts(order,false));
				}else{
					$(grids).append(chartDetails.getThisChartLayouts(order,true));
				}
				//chartDetails.drawThisChart(data);
			}else{ // Draw note
				if(order < JMA.userDetails.user_permissions.mychart.totalChartsPerFolder) {
					$(grids).append(chartDetails.getThisNoteLayouts(order,false));
				}else{
					$(grids).append(chartDetails.getThisNoteLayouts(order,true));
				}
			}
		});
	 	if(pageCount == 0)
		{
			//$('.show_How_To_SaveInFolderVedio').show();
			$('.myfolder_wholediv').hide();
		}
		else{
			$('.show_How_To_SaveInFolderVedio').empty();
			$('.myfolder_wholediv').show();
		}
$(grids).append('<div class="col-sm-8 padl0 page-title page-title-no-line"><h4 class=""></h4></div>');

}else if(this.myFolder.currentView =='smallView'){

	var folderContentLayout_object = Handlebars.compile($('#template_mychart_folder_content_smallView').html());
	var folderContentLayout = folderContentLayout_object();

	$('#Dv_folder_content_smallView').html(folderContentLayout);
	var smallviewfolder_title='<div class="main-title"><h1>'+self.myFolder.currentFolder.name+'</h1><div class="mttl-line"></div></div><div class="right-menus mychart_exppri"> <ul class="top-m list-inline"> <li> <a href="#" class="btn btn-primary print-mycharts"> <i class="fa fa-print"></i> <span>Print</span> </a> </li> </ul> <div class="full-width"></div></div>';

	$('#smallView_grids .main-title').html(smallviewfolder_title);


	var pageCount = 0;
	$.each(self.myFolder.currentFolder.charts, function(order,chartDetails){
		if(order%4 == 0){
			pageCount++;

			if(pageCount ==1){
				$('#smallView_grids').append('<div class="col-xs-12 col-sm-6 ftps_holconmin"><div class="col-xs-12 padl0 page-title"><h4 class="">PAGE '+(pageCount)+'<i class="fa fa-arrows" aria-hidden="true"></i></h4></div><div class="ftps_holcon"></div></div>');
			}else{
				$('#smallView_grids').append('<div class="col-xs-12 col-sm-6 ftps_holconmin"><div class="col-xs-12 padl0 page-title"><h4 class="page2">PAGE '+(pageCount)+'<i class="fa fa-arrows" aria-hidden="true"></i></h4></div><div class="ftps_holcon"></div></div>');
			}
		}
		if(chartDetails.type == 'chart' || chartDetails.type == 'map'){

				//  Get chart Data. ajax
				if(order < JMA.userDetails.user_permissions.mychart.totalChartsPerFolder) {
					

					$('#smallView_grids .ftps_holcon:eq("' + (pageCount-1) + '")').append(chartDetails.getThisChartLayouts(order,false));
				}else{
					$('#smallView_grids .ftps_holcon:eq("' + (pageCount-1) + '")').append(chartDetails.getThisChartLayouts(order,true));
				}


				//chartDetails.drawThisChart(data);
			}else{ // Draw note
				if(order < JMA.userDetails.user_permissions.mychart.totalChartsPerFolder) {
					$('#smallView_grids .ftps_holcon:eq("' + (pageCount-1) + '")').append(chartDetails.getThisNoteLayouts(order,false));
				}else{
					$('#smallView_grids .ftps_holcon:eq("' + (pageCount-1) + '")').append(chartDetails.getThisNoteLayouts(order,true));
				}
			}



		});
$('#smallView_grids').append('<div class="col-sm-8 padl0 page-title-no-line"><h4 class=""></h4></div>');
}

};

	/**
	 * Function drawChartsAndNotesOnPlaceholders()
	 * Draws or redraws charts / notes
	 * Draws chat\rts/notes on designated placeholders
	 */
	 this.drawChartsAndNotesOnPlaceholders = function(){
        
	 	$.each(self.myFolder.currentFolder.charts, function(order,chartDetails){
			 
	 		if(chartDetails.type == 'chart' || chartDetails.type == 'map'){
	 			
	 			chartDetails.drawThisChart();
			}else{ // Draw note

				chartDetails.drawThisNote();
			}
		});		

	 	
	 		this.activateDragAndOrderCharts();
	 
	 		//this.deActivateDragAndOrderCharts();
	 	


	 	this.addAllEventsToFolderContent();
	 };

	/**
	 * Function writeSelectedFolderName()
	 * Write folder name on ui as title
	 */
	 this.writeSelectedFolderName = function(){
	 	$('#Dv_folder_content_title').text(self.myFolder.currentFolder.name);
	 };

	/**
	 * Function createNewFolderContent
	 * Create a new content - chart/note and add to folder
	 * Always Note - No chart can be created
	 */
	 this.createNewFolderContent = function(type,$this){
	 	$('.foldercontent-sub-menu').hide();
	 	try{
	 		if(type == 'chart' || type == 'note'){
	 			var newContentIndex = this.myFolder.currentFolder.charts.length;
	 		

	 			var chart_uuid = JMA.generateUUID()+"-"+JMA.userDetails.id+self.myFolder.currentFolder.id;
	 			var folderContent = {
	 				type : 'note',
	 				uuid : chart_uuid,
	 				title : 'Note: New Note',
	 				chart_code : '',
	 				note_content : 'Bullet Point ',
	 				chart_data_type : null,
	 				current_chart_codes : null,
	 				isChartTypeSwitchable : null,
	 				navigator_date_from : null,
	 				navigator_date_to : null,
	 				chartType : null,
	 				chart_codes_available : null,
	 				chart_labels_available : null,	
	 				chartLayout : '',
	 				isMultiaxis : false,
	 				isNavigator : false,
	 				charts_fields_available : null,
	 				charts_available : null
	 			};

	 			var newContentObject = new charts(newContentIndex,folderContent);
	 			var newContentElement = newContentObject.getThisNoteCreated();
				// Save new element
				$.ajax({
					url : JMA.baseURL + "mycharts/folder/createcontent",
					dataType : 'json',
					type : 'POST',
					data : {chart_data : folderContent, folder_id : self.myFolder.currentFolder.id},
					beforeSend: function() { JMA.showLoading(); },
					success : function(response){
						if(response.status!=1){
							if(response.status == 1001){
								if(JMA.userDetails.user_type == 'individual' || JMA.userDetails.user_type == 'corporate'){
									self.showAddContentRestricted();
								}else{
									JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
								}
							}else{
								JMA.handleErrorWithMessage(response.message);
							}
						}else{
							// Insert content 
							var $exhibit = $this.closest('.exhibit');
							$exhibit.after(newContentElement);

							if(JMA.myChart.myFolder.currentView=='smallView'){
							var small_div='small_';
						}else{
							var small_div='';
						}
							$('#Dv_placeholder_noteTitle_'+ small_div +chart_uuid).html(folderContent.title);
							$('#Dv_placeholder_noteContent_'+ small_div +chart_uuid).html('<ul><li>'+folderContent.note_content+' 1</li><li>'+folderContent.note_content+' 2</li></ul>');
							self.myFolder.currentFolder.charts.push(folderContent);
							// Save order
							// Save order
							self.saveLatestFolderContentOrder();
							self.addAllEventsToFolderContent();
							self.reorderPagination();
							
						}
						JMA.hideLoading();
					},
					error : function(){
						JMA.hideLoading();
						JMA.handleError();
					}
				});



}else{
	throw "Error.. Invalid Type";
}
}catch (Err) {
			// TODO: handle exception
			JMA.handleError();
		}
		
	};
	
	/**
	 * Function duplicateThisFolderContent()
	 * Function to duplicate a folder content
	 */
	 this.duplicateThisFolderContent = function($this){

	 

	 	$('.foldercontent-sub-menu').hide();
	 	var $exhibit = $this.closest('.exhibit');

	 	var current_uuid = $exhibit.data('uuid');

	//	var current_order = $('.exhibit').index($exhibit);
	var current_order = self.getIndexByUuid(current_uuid);
	var new_order = self.myFolder.currentFolder.charts.length;
	var new_uuid = JMA.generateUUID()+"-"+JMA.userDetails.id+self.myFolder.currentFolder.id;
	var new_chart_object = new charts(new_order, self.myFolder.currentFolder.charts[current_order]);
	new_chart_object.uuid=new_uuid;
	//	self.myFolder.currentFolder.charts.splice(new_order,0,new_chart_object); // replace
	self.myFolder.currentFolder.charts[new_order] = new_chart_object;
	self.myFolder.currentFolder.charts[new_order].data = self.myFolder.currentFolder.charts[current_order].data;
//		// Save new element
$.ajax({
	url : JMA.baseURL + "mycharts/folder/duplicatecontent",
	dataType : 'json',
	type : 'POST',
	data : {folder_id : self.myFolder.currentFolder.id, currentUuid : current_uuid, newUuid : new_uuid, currentOrder : current_order},
	beforeSend: function() { JMA.showLoading(); },
	success : function(response){
		if(response.status!=1){
			if(response.status == 1001){
				if(JMA.userDetails.user_type == 'individual' || JMA.userDetails.user_type == 'corporate'){
					self.showAddContentRestricted();
				}else{
					JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
				}
			}else{
				JMA.handleErrorWithMessage();
			}
		}else{
					//self.saveLatestFolderContentOrder();
					//self.initiateCurrentFolder(self.myFolder.currentFolder.id);
					var layout = '';

					
				if($exhibit.hasClass('chart_listview')){
					JMA.myChart.myFolder.currentView='listView';
						layout = new_chart_object.getThisChartLayouts(new_order,false);
						$exhibit.after(layout);

						$("div.chart_listview[data-uuid='"+new_uuid+"']").html($exhibit.html());

				

				}else{
					// Now draw chart
					if(new_chart_object.type == 'chart' || new_chart_object.type == 'map'){
						layout = new_chart_object.getThisChartLayouts(new_order,false);
						$exhibit.after(layout);
						new_chart_object.drawThisChart();
					}else{ // Draw note
						layout = new_chart_object.getThisNoteLayouts(new_order,false);
						$exhibit.after(layout);
						new_chart_object.drawThisNote();
					}
				}
				}
				self.addAllEventsToFolderContent();
				self.reorderPagination();
				JMA.hideLoading();
			},
			error : function(){
				JMA.hideLoading();
				JMA.handleError();
			}
		});

//		$exhibit.after($exhibit.clone());

};

	/**
	 * Save note content
	 * 
	 */
	 this.saveThisNoteContent = function(order,pUuid){

	 	var noteContent = self.myFolder.currentFolder.charts[order].note_object.getData();
	 	var chart_index = self.getIndexByUuid(pUuid);
	 	$.ajax({
	 		url : JMA.baseURL + "mycharts/folder/savenotecontent",
	 		dataType : 'json',
	 		type : 'POST',
	 		data : {uuid : pUuid, folder_id : self.myFolder.currentFolder.id, note_content : noteContent},
	 		beforeSend: function() { JMA.showLoading(); },
	 		success : function(response){
	 			if(response.status!=1){
	 				JMA.handleErrorWithMessage(response.message);
	 			}else{
					// Note content saved
					self.myFolder.currentFolder.charts[chart_index].note_content = noteContent;
				}
				JMA.hideLoading();
			},
			error : function(){
				JMA.hideLoading();
				JMA.handleError();
			}
		});

	 };

	/**
	 * Save note content
	 * 
	 */
	 this.saveThisChartTitle = function(order,pUuid,title){

	 	var chart_index = self.getIndexByUuid(pUuid);
	 	$.ajax({
	 		url : JMA.baseURL + "mycharts/folder/savecharttitle",
	 		dataType : 'json',
	 		type : 'POST',
	 		data : {uuid : pUuid, folder_id : self.myFolder.currentFolder.id, title_content : title},
	 		beforeSend: function() { JMA.showLoading(); },
	 		success : function(response){
	 			if(response.status!=1){
	 				JMA.handleErrorWithMessage(response.message);
	 			}else{
					// Note content saved
					self.myFolder.currentFolder.charts[chart_index].title = title;
				}
				JMA.hideLoading();
			},
			error : function(){
				JMA.hideLoading();
				JMA.handleError();
			}
		});

	 };	

	/**
	 * Function editThisContent
	 * Funciton to edit a folder content - Chart / Note
	 */
	 this.editThisFolderContent = function(pType,order,pUuid){
		 //initiateMap
		 
		 //initiateChart
	 	var chart_index = self.getIndexByUuid(pUuid);
		// Create chart details object.
		var chartDetailsObj = {
			chart_actual_code : self.myFolder.currentFolder.charts[chart_index].chart_code,
			color_code : self.myFolder.currentFolder.charts[chart_index].color_code,
			color_series : self.myFolder.currentFolder.charts[chart_index].color_series,
			color_status : self.myFolder.currentFolder.charts[chart_index].color_status,
			mychart_color_code : self.myFolder.currentFolder.charts[chart_index].mychart_color_code,
			chart_data_type : self.myFolder.currentFolder.charts[chart_index].chart_data_type,
			isPremiumData : false,
			navigator_date_from : Highcharts.dateFormat('%d',self.myFolder.currentFolder.charts[chart_index].navigator_date_from)+"-"+Highcharts.dateFormat('%m',self.myFolder.currentFolder.charts[chart_index].navigator_date_from)+"-"+Highcharts.dateFormat('%Y',self.myFolder.currentFolder.charts[chart_index].navigator_date_from),
			navigator_date_to : Highcharts.dateFormat('%d',self.myFolder.currentFolder.charts[chart_index].navigator_date_to)+"-"+Highcharts.dateFormat('%m',self.myFolder.currentFolder.charts[chart_index].navigator_date_to)+"-"+Highcharts.dateFormat('%Y',self.myFolder.currentFolder.charts[chart_index].navigator_date_to),
			share_page_url : '',
			sources : '',
			chart_config : {
				chartLayout : self.myFolder.currentFolder.charts[chart_index].chartLayout,
				chartType : self.myFolder.currentFolder.charts[chart_index].chartType,
				chart_view_type : self.myFolder.currentFolder.charts[chart_index].chart_view_type,
				dataType : self.myFolder.currentFolder.charts[chart_index].chart_data_type,
				isChartTypeSwitchable : self.myFolder.currentFolder.charts[chart_index].isChartTypeSwitchable,
				isMultiaxis : self.myFolder.currentFolder.charts[chart_index].isMultiaxis,
				isNavigator : self.myFolder.currentFolder.charts[chart_index].isNavigator,
				chartExport : {
					image_size_available : {
						large : 1200,
						medium : 800,
						small : 400
					},
					types_available : {
						jpeg : 	"image/jpeg",
						pdf : "application/pdf",
						png : 	"image/png"
					}
				}
			},
			chart_labels_available : self.myFolder.currentFolder.charts[chart_index].chart_labels_available,
			charts_codes_available : self.myFolder.currentFolder.charts[chart_index].chart_codes_available,
			current_chart_codes : self.myFolder.currentFolder.charts[chart_index].current_chart_codes,
			charts_fields_available : self.myFolder.currentFolder.charts[chart_index].charts_fields_available,
			charts_available : self.myFolder.currentFolder.charts[chart_index].charts_available,
			chart_data : null

		};
		
		
		// Get latest chart Data
		$.ajax({
			url : JMA.baseURL+'chart/getchartdata',
			dataType : 'json',
			type : 'POST',
			cache: false,
			data : {'type' : self.myFolder.currentFolder.charts[chart_index].chart_data_type, 'chartcodes' : self.myFolder.currentFolder.charts[chart_index].current_chart_codes,'chartOrder':chart_index},
			beforeSend: function() { JMA.showLoading(); },
			success : function(data){
				chartDetailsObj.sources = data.sources;
				chartDetailsObj.isPremiumData = data.isPremiumData;
				chartDetailsObj.chart_data = data.data;
				JMA.JMAChart.initiateChart(0,chartDetailsObj);
				$('#Dv_modal_edit_folder_content').modal('show');

				$('#Dv_modal_edit_folder_content').on('shown.bs.modal', function () {
					JMA.JMAChart.drawAllCharts(true);
					$(this).attr("data-uuid",pUuid);
					$("#Dv_modal_edit_folder_content").data('uuid',pUuid);
					$("div.input-group-addon i.fa-minus").trigger('click');
				});

				/*$.fancybox({
					href : '#Dv_modal_edit_folder_content',
					modal : false,
					showCloseButton : false,
					onClosed : function() {
						$('#Dv_modal_login').hide();
					}
				});*/

JMA.hideLoading();
},
error : function() {
	JMA.hideLoading();
	JMA.handleError();
}
});
};



	/**
	 * Function switchThisChartViewType()
	 * switches to View type whether chart or data
	 */
	 this.switchThisChartViewType = function(view_type,chartOrder){


	 	try {

	 		var selectedFolder = self.myFolder.currentFolder.id;

	 		var uuid = $('div.exhibit[data-order='+chartOrder+']').data('uuid');

	 		var chart_index = self.getIndexByUuid(uuid);

	 		var v_chart_code = self.myFolder.currentFolder.charts[chart_index].chart_code;

	 		var postData = {
	 			folder_id : selectedFolder,
	 			chart_data : {
	 				chart_view_type : view_type,
	 				uuid : uuid,
	 				chart_code : v_chart_code,
	 				chart_action : 'Switch'

	 			}
	 		};


			// Save data
			$.ajax({
				url : JMA.baseURL + "mycharts/chart/updatethiseditedchart",
				dataType : 'json',
				type : 'POST',
				data : postData,
				beforeSend: function() { JMA.showLoading(); },
				success : function(response){
					if(response.status!=1){
						JMA.handleErrorWithMessage(response.message);
					}else{
						
						console.log(chartOrder+' Its switched to '+view_type);
					}
					JMA.hideLoading();
				},
				error : function(){
					JMA.hideLoading();
					JMA.handleError();
				}
			});
		}catch(Err){

		}
	};

	
	/**
	 * Function updateThisEditedChart()
	 * Updates Edited Chart to myChart
	 */
	 this.updateThisEditedChart = function(){
		 var colors;
		 if(typeof(JMA.JMAChart.Charts[0].Conf.mychartchartColor === undefined) && JMA.JMAChart.Charts[0].Conf.chartColor.length == "0")
		 {
			 // console.log('testttttt123');
			  colors = JMA.JMAChart.Charts[0].Conf.chartColor;
		 }
		 else if(typeof(JMA.JMAChart.Charts[0].Conf.mychartchartColor === undefined) && JMA.JMAChart.Charts[0].Conf.chartColor.filter(Boolean).length > 1 )
		 {
			 colors = JMA.JMAChart.Charts[0].Conf.chartColor;
		 }
		 else if(typeof(JMA.JMAChart.Charts[0].Conf.mychartchartColor === "object"))
		 {
			 //colors = JMA.JMAChart.Charts[0].Conf.mychartchartColor;
			 console.log(JMA.JMAChart.Charts[0].Conf.mychartchartColor);
			 console.log(JMA.JMAChart.Charts[0].Conf.chartColor);
			 if(JMA.JMAChart.Charts[0].Conf.mychartchartColor !== undefined && JMA.JMAChart.Charts[0].Conf.mychartchartColor.filter(Boolean).length > 1)
			 {
				 colors = JMA.JMAChart.Charts[0].Conf.mychartchartColor;
			 }
			 else
			 {
				 colors = JMA.JMAChart.Charts[0].Conf.chartColor;
			 }
		 }
		 else
		 {
			 if(JMA.JMAChart.Charts[0].Conf.mychartchartColor.filter(Boolean).length > 0)
			 {
				 colors = JMA.JMAChart.Charts[0].Conf.mychartchartColor;
			 }
			 else
			 {
				 colors = JMA.JMAChart.Charts[0].Conf.chartColor;
			 }
			  
		 }
	 	try {
	 		var selectedFolder = self.myFolder.currentFolder.id;
	 		var uuid = $('#Dv_modal_edit_folder_content').data('uuid');
	 		var chart_index = self.getIndexByUuid(uuid);
	 		var v_chart_code = JMA.JMAChart.Charts[0].createChartCodeFromConfig();
	 		var v_isMultiaxis = JMA.JMAChart.Charts[0].Conf.chartType == 'multiaxisline' ? true : false;
	 		var postData = {
	 			folder_id : selectedFolder,
	 			chart_data : {
	 				uuid : uuid,
	 				chart_code : v_chart_code,
					color_codes : colors,
					color_series : JMA.JMAChart.Charts[0].Conf.color_series,
					color_status : 'true',
	 				current_chart_codes : JMA.JMAChart.Charts[0].Conf.current_chart_codes,
	 				navigator_date_from : JMA.JMAChart.Charts[0].Conf.navigator_date_from,
	 				navigator_date_to : JMA.JMAChart.Charts[0].Conf.navigator_date_to,
	 				chartType : JMA.JMAChart.Charts[0].Conf.chartType,
	 				isMultiaxis : v_isMultiaxis,
					chart_view_type : 'chart'
	 			}
	 		};
			// Save data
			$.ajax({
				url : JMA.baseURL + "mycharts/chart/updatethiseditedchart",
				dataType : 'json',
				type : 'POST',
				data : postData,
				beforeSend: function() { JMA.showLoading(); },
				success : function(response){
					if(response.status!=1){
						JMA.handleErrorWithMessage(response.message);
					}else{
						self.myFolder.currentFolder.charts[chart_index].chart_code = v_chart_code;
						self.myFolder.currentFolder.charts[chart_index].current_chart_codes = JMA.JMAChart.Charts[0].Conf.current_chart_codes;
						self.myFolder.currentFolder.charts[chart_index].navigator_date_from = JMA.JMAChart.Charts[0].Conf.navigator_date_from;
						self.myFolder.currentFolder.charts[chart_index].navigator_date_to = JMA.JMAChart.Charts[0].Conf.navigator_date_to;
						self.myFolder.currentFolder.charts[chart_index].chartType = JMA.JMAChart.Charts[0].Conf.chartType;
						self.myFolder.currentFolder.charts[chart_index].isMultiaxis = v_isMultiaxis;
						self.myFolder.currentFolder.charts[chart_index].data = {};
						
						self.myFolder.currentFolder.charts[chart_index].color_code = colors;
						self.myFolder.currentFolder.charts[chart_index].color_series = JMA.JMAChart.Charts[0].Conf.color_series;
						self.myFolder.currentFolder.charts[chart_index].color_status = 'true';

						if(JMA.myChart.myFolder.currentView=='smallView'){
							var small_div='small_';
						}else{
							var small_div='';
						}
						var dataTable_container = '#Dv_placeholder_tableView_' + small_div + self.myFolder.currentFolder.charts[chart_index].uuid;
						var chart_container = '#Dv_placeholder_graphView_' + small_div + self.myFolder.currentFolder.charts[chart_index].uuid;
						$(dataTable_container).html('');
						$(dataTable_container).addClass('hide');
						$(chart_container).removeClass('hide');
						$exibit = $(chart_container).closest('.exhibit');
						$exibit.find('[data-view="chart"]').addClass('selected');
						$exibit.find('[data-view="data"]').removeClass('selected');
						//$.fancybox.close();
						$(".modal").modal("hide");
						self.myFolder.currentFolder.charts[chart_index].drawThisChart();
						
						
					//	self.initiateCurrentFolder(selectedFolder);
				}
				JMA.hideLoading();
			},
			error : function(){
				JMA.hideLoading();
				JMA.handleError();
			}
		});
}catch(Err){

}
};

	/**
	 * Function deleteThisFolderContent(element)
	 * To delete selected folder content - chart / note
	 */
	 this.deleteThisFolderContent = function(contentType,$this){
	 	$('.foldercontent-sub-menu').hide();
	 	var $exhibit = $this.closest('.exhibit');
	 	var selectedFolder = self.myFolder.currentFolder.id;
	 	var uuid = $exhibit.data('uuid');
	 	var content_index = self.getIndexByUuid(uuid);
	 	jConfirm('Are you sure you want to delete this '+contentType+' ?', 'Delete '+contentType+' ', function(r) {
	 		if(r) {
		//if(confirm("Are you sure you want to delete this "+contentType+"?")) {
			var postData = {
				folder_id : selectedFolder,
				uuid : uuid
			};
				// Save data
				$.ajax({
					url : JMA.baseURL + "mycharts/chart/deletethisfoldercontent",
					dataType : 'json',
					type : 'POST',
					data : postData,
					beforeSend: function() {
						JMA.showLoading();
					},
					success : function(response){
						if(response.status!=1){
							JMA.handleErrorWithMessage(response.message);
						}else{
							self.myFolder.currentFolder.charts.splice(content_index,1);
							$exhibit.remove();	
							if($exhibit.hasClass('chart_listview')){
							JMA.myChart.myFolder.currentView='listView';
							}
							else
							{
								location.reload();
							}
						
							self.reorderPagination();
						}
						JMA.hideLoading();
					},
					error : function(){
						JMA.hideLoading();
						JMA.handleError();
						
					}
				});
			}

		});
	 };

	/**
	 * Show Folder Creation restriction message
	 */
	 this.showFolderCreationRestricted = function() {
		// type == 'download'  || type == 'premium'
		$('#Dv_modal_createfolder_restricted').modal('show');
		/*$.fancybox({
			href : '#Dv_modal_createfolder_restricted',
			modal : false,
			showCloseButton : false,
			onClosed : function() {
				$('#Dv_modal_createfolder_restricted').hide();
			}
		});*/
};
	/**
	 * Show add content restriction message
	 */
	 this.showAddContentRestricted = function() {
		// type == 'download'  || type == 'premium'
		$('#Dv_modal_addchart_restricted').modal('show');
		/*$.fancybox({
			href : '#Dv_modal_addchart_restricted',
			modal : false,
			showCloseButton : false,
			onClosed : function() {
				$('#Dv_modal_addchart_restricted').hide();
			}
		});*/
};	

	/**
	 * Add all events and handlers to folder content
	 */
	 this.addAllEventsToFolderContent = function(){
	 	$('.foldercontent-sub-menu li').mouseenter(function(e){

	 		$(this).addClass('exhibit-menu-highlight');
	 	})
	 	$('.foldercontent-sub-menu li').mouseleave(function(e){
	 		$(this).removeClass('exhibit-menu-highlight');
	 	})


	 };

	/**
	 * Function to reset and reorder pagination
	 */
	 this.reorderPagination = function(){
	 
		if(JMA.myChart.myFolder.currentView=='largeView'){
	 					var $paging_elements = $('div#grids div.page-title');
	 			}else if(JMA.myChart.myFolder.currentView=='listView'){

	 						var $paging_elements = $('div#fpt_list div.page-title');
	 						var parentDiv="#fpt_list .exhibit";
							$.each($(parentDiv),function(i_cnt,elm){
	
							$(parentDiv+':eq("'+i_cnt+'") ul.list-inline li.serial').text(i_cnt + 1);

							});
	 			}

	 			

	 
	 	$.each($paging_elements,function(elm_cnt,page_element){
	 		
	 		if(elm_cnt !=0){
	 			$page_element = $(page_element);
	 			var elm_length = $page_element.prevUntil('div.page-title').length;
	 			
	 			if(elm_length >4){
	 				if($page_element.hasClass('page-title-no-line')){
	 					
	 					if(JMA.myChart.myFolder.currentView=='largeView'){
	 				$('<div class="col-xs-12 col-lg-8 padl0 page-title page2"><h4 class="page2">PAGE '+(elm_cnt+1)+'</h4></div>').insertBefore($page_element.prev($paging_elements));
	 			}else if(JMA.myChart.myFolder.currentView=='listView'){
	 					$('<div class="page-title"><div class="sec-title page2"><h1 class="page2">PAGE '+(elm_cnt+1)+'</h1><div class="sec-title"></div><div class="table fpt_table list-view"> <ul class="list-inline"> <li>S.No</li> <li>Title</li> <li>Details</li> <li>Edit</li></ul></div></div>').insertBefore($page_element.prev($paging_elements));
	 			}

	 					
	 				}else{
	 						
	 					$page_element.insertBefore($page_element.prev($paging_elements));
	 				}
	 			}else if(elm_length == 0){
	 				
	 				$page_element.prev('div.page-title').remove();
	 			}else if(elm_length <4){
	 				if($page_element.hasClass('page-title-no-line')){
						// do nothing
					}else{
						
						$page_element.insertAfter($page_element.next($paging_elements));
					}
				}
			}
		});

	 };

	 /*this.reorderListViewPagination = function(){
	 	var $paging_elements = $('div#fpt_list div.page-title');

	 	$.each($paging_elements,function(elm_cnt,page_element){
	 		if(elm_cnt !=0){
	 			$page_element = $(page_element);
	 			var elm_length = $page_element.prevUntil('div.page-title').length;
	 			
	 			if(elm_length >4){
	 				if($page_element.hasClass('page-title-no-line')){
	 						
	 					$('<div class="sec-title page-title page2"><h4 class="page2">PAGE '+(elm_cnt+1)+'</h4><div class="sec-title"></div>').insertBefore($page_element.prev($paging_elements));
	 				}else{
	 					
	 					$page_element.insertBefore($page_element.prev($paging_elements));
	 				}
	 			}else if(elm_length == 0){
	 				
	 				$page_element.prev('div.page-title').remove();
	 			}else if(elm_length <4){
	 				if($page_element.hasClass('page-title-no-line')){
						// do nothing
					}else{
						
						$page_element.insertAfter($page_element.next($paging_elements));
					}
				}
			}
		});

	 };*/

	 (function(){
	 	self.__construct(myChartParams);
	 })();
	}

/**
 * Class charts for myCharts
 * Class which holds values and functions for individual charts and notes.
 * @author Shijo Thomas
 */
 function charts(order,folderContent){



 	var self = this;
 	this.order;
 	this.type;
 	this.uuid;
 	this.title;
 	this.chart_code;
	this.color_code;
	this.color_series;
	this.color_status;
 	this.note_content;
 	this.chart_data_type;
 	this.current_chart_codes = [];
 	this.isChartTypeSwitchable;
 	this.isMultiaxis;
 	this.isNavigator;
 	this.navigator_date_from;
 	this.navigator_date_to;
 	this.chartType;
 	this.chart_view_type;
 	this.chartLayout;
 	this.chart_codes_available;
 	this.charts_fields_available;
 	this.charts_available;
 	this.data = {
 		sources : '',
 		isPremiumData : false,
 		chartDataSeries : null
 	};
	/**
	 * Highchart configurations
	 */
	 this.chartConfigs = {
	 	colors : [ '#316AB4', '#E60013', '#FF9900', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a' ]
	 };
	 this.chart_object = null;
	 this.note_object = null;


	/**
	 * Constructor __construct
	 */
	 this.__construct = function(order,folderContent){
	 	this.order = order;
	 	this.type = folderContent.type;
	 	this.uuid = folderContent.uuid;
	 	this.title = folderContent.title;
	 	this.chart_code = folderContent.chart_code;
		this.color_code = folderContent.color_code;
		this.color_series = folderContent.color_series;
		this.color_status = folderContent.color_status;
	 	this.note_content = folderContent.note_content;
	 	this.chart_data_type = folderContent.chart_data_type;
	 	this.current_chart_codes = folderContent.current_chart_codes;
	 	this.isChartTypeSwitchable = folderContent.isChartTypeSwitchable;
	 	this.isMultiaxis = folderContent.isMultiaxis;
	 	this.isNavigator = folderContent.isNavigator;
	 	this.navigator_date_from = folderContent.navigator_date_from;
	 	this.navigator_date_to = folderContent.navigator_date_to;
	 	this.chartType = folderContent.chartType;
	 	this.chart_view_type = folderContent.chart_view_type;
	 	this.chartLayout = folderContent.chartLayout;
	 	this.chart_codes_available = folderContent.chart_codes_available;
	 	this.chart_labels_available = folderContent.chart_labels_available;
	 	this.charts_fields_available = folderContent.charts_fields_available;
	 	this.charts_available = folderContent.charts_available;


	 };


	/**
	 * Function populateChartData()
	 * Function to get chart data populated and cach it.
	 * Get data from server
	 */
	 this.populateChartData = function(){
	 	$.ajax({
	 		url : JMA.baseURL+'chart/getchartdata',
	 		dataType : 'json',
	 		type : 'POST',
	 		cache: false,
	 		data : {'type' : self.chart_data_type, 'chartcodes' : self.current_chart_codes,'chartOrder':self.order,'typeGraph':self.type, 'statename' : self.note_content},
	 		beforeSend: function() { JMA.showLoading(); },
	 		success : function(data){
	 			self.data.sources = data.sources;
	 			self.data.isPremiumData = data.isPremiumData;
	 			self.createChartDataSeries(self.formatData(data.data,self.type),self.color_code);

	 			self.drawThisChart();
	 			//self.drawThisChart();	

	 			if(JMA.myChart.myFolder.currentView=='smallView'){
	 				var small_div='small_';
	 			}else{
	 				var small_div='';
	 			}

				//Veera Start
				if(self.chart_view_type=='chart' || self.chart_view_type=='map'){

					if($('#Dv_placeholder_graphView_'+ small_div + self.uuid).hasClass('hide')){
						$('#Dv_placeholder_graphView_'+ small_div + self.uuid).removeClass('hide');
						$('#Dv_placeholder_tableView_'+ small_div + self.uuid).addClass('hide');
						$('ul.exhibit-tab li[data-view="data"][data-order="'+self.order+'"]').removeClass('selected');
						$('ul.exhibit-tab li[data-view="chart"][data-order="'+self.order+'"]').addClass('selected');
					}
					
				}else{
					$('ul.exhibit-tab li[data-view="chart"][data-order="'+self.order+'"]').removeClass('selected');
					$('ul.exhibit-tab li[data-view="data"][data-order="'+self.order+'"]').addClass('selected');
					if($('#Dv_placeholder_tableView_'+ small_div + self.uuid).hasClass('hide')){
						$('#Dv_placeholder_tableView_'+ small_div + self.uuid).removeClass('hide');
						$('#Dv_placeholder_graphView_'+ small_div + self.uuid).addClass('hide');
					}
					self.drawThisDataOnTable();
				}
				//Veera End

				JMA.hideLoading();
			},
			error : function() {
				JMA.hideLoading();
				JMA.handleError();
			}
		});

		// On success :  self.drawThisChart();
	};
	



	/**
	 * Function populateChartData()
	 * Function to get chart data populated and cach it.
	 * Get data from server
	 */
	 this.populateChartData1 = function(){
	 	$.ajax({
	 		url : JMA.baseURL+'chart/getchartdata',
	 		dataType : 'json',
	 		type : 'POST',
	 		cache: false,
	 		data : {'type' : self.chart_data_type, 'chartcodes' : self.current_chart_codes,'chartOrder':self.order},
	 		beforeSend: function() { JMA.showLoading(); },
	 		success : function(data){
				console.log('New Log Texu');
	 			self.data.sources = data.sources;
	 			self.data.isPremiumData = data.isPremiumData;
	 			self.createChartDataSeries(self.formatData(data.data),self.color_code);
	 			self.drawThisChart();
				JMA.hideLoading();
			},
			error : function() {
				JMA.hideLoading();
				JMA.handleError();
			}
		});

		// On success :  self.drawThisChart();
	};

	this.createMultiYaxisConfigurations = function(chart_data_series){
		var ret_data = {
			yAxis : new Array(),
			dataSeries : new Array()
		};
		$.each(chart_data_series,function(ky,chData){
			
			if(self.chartColor !== undefined)
			{
				if(self.chartColor.hasOwnProperty(ky))
				{
					
					self.chartConfigs.colors[ky] = self.Conf.chartColor[ky] ;
				}
			}
			else if(self.color_code !== undefined)
			{
				if(self.color_code.hasOwnProperty(ky))
				{
					
					if(self.color_code[ky]!=''){
					self.chartConfigs.colors[ky] = self.color_code[ky];
					}
					
				}
			}
			else if(self.mychartchartColor !== undefined)
			{
				if(self.mychartchartColor[ky])
				{
					
					self.chartConfigs.colors[ky] = self.Conf.mychartchartColor[ky];
				}
			}
			
			var axisConfigs = {
				opposite : ky%2 == 1 ? true : false,
				title: {
					text: chData['name'],
					style: {
		                    	//fontSize: '8px'
		                    	color: self.chartConfigs.colors[ky]
		                    }
		                  },
		                  labels: {
			    		//align: 'right'
			    		style: {
			    			color: self.chartConfigs.colors[ky]
			    		}	
			    	}
			    };
			    var series_new = chData;
			    series_new['yAxis'] = ky,
			    ret_data.yAxis[ky] = axisConfigs;
			    ret_data.dataSeries[ky] = series_new;
			  });
		return ret_data;
	};
	
	/**
	 * Function drawThisDataOnTable()
	 * Draw chart data on a table view
	 */
	 this.drawThisDataOnTable =  function(){

	 	if(JMA.myChart.myFolder.currentView=='smallView'){
	 		var small_div='small_';
	 		var dynamictd=75;
	 	}else{
	 		var small_div='';
	 		var dynamictd=82;
	 	}

	 	var dataTable_container = '#Dv_placeholder_tableView_' + small_div + this.uuid;
	 	if($(dataTable_container +' >').length == 0){
	 		if(this.data.chartDataSeries!=null) {
	 			var out = '<table cellspacing="0" cellpadding="0" class="mychart_table fixed_headers table table-striped"><thead><tr><th>Date</th>';
	 			var out_data = '';
	 			var data_formated = [];
	 			var column_width = dynamictd/self.data.chartDataSeries.length;
	 			$.each(self.data.chartDataSeries,function(order,series){
	 				out+="<th width='"+column_width+"%'>"+series.name+"</th>";
	 				$.each(series.data,function(i_order,dataset){
	 					if(Array.isArray(data_formated[i_order]) == true){

	 						data_formated[i_order].push(dataset[1]);
	 					}else{
	 						if(self.chart_data_type == 'monthly'){
	 							var dte = Highcharts.dateFormat('%b',dataset[0])+" "+Highcharts.dateFormat('%Y',dataset[0]);
	 						}else if(self.chart_data_type == 'quaterly'){
	 							if (Highcharts.dateFormat('%b', dataset[0]) == 'Mar') {
	 								var dte = "Q1 "+Highcharts.dateFormat('%Y',dataset[0]);
	 							}
	 							if (Highcharts.dateFormat('%b', dataset[0]) == 'Jun') {
	 								var dte = "Q2 "+Highcharts.dateFormat('%Y',dataset[0]);
	 							}
	 							if (Highcharts.dateFormat('%b', dataset[0]) == 'Sep') {
	 								var dte = "Q3 "+Highcharts.dateFormat('%Y',dataset[0]);
	 							}
	 							if (Highcharts.dateFormat('%b', dataset[0]) == 'Dec') {
	 								var dte = "Q4 "+Highcharts.dateFormat('%Y',dataset[0]);
	 							}
	 						}else if(self.chart_data_type == 'anual'){
								
	 							var dte = Highcharts.dateFormat('%Y',dataset[0]);
	 						}else if(self.chart_data_type == 'daily'){
	 							var dte = Highcharts.dateFormat('%e',dataset[0])+" "+Highcharts.dateFormat('%b', dataset[0])+", "+Highcharts.dateFormat('%Y',dataset[0]);
	 						}						
	 						data_formated[i_order] = [dte,dataset[1]];
	 					}

	 				});

});
out+="</tr></thead><tbody>";
$.each(data_formated,function(i_order,data_for_table){
	out_data+="<tr>";
	$.each(data_for_table,function(ii_count,data_cell){
		if(ii_count == 0) {
			out_data+="<td>"+(data_cell == null ? '-' : data_cell)+"</td>";
		}else{
			out_data+="<td width='"+column_width+"%'>"+(data_cell == null ? '-' : data_cell)+"</td>";
		}
	});
	out_data+="</tr>";
});
out_data+="</tbody>";
out+=out_data;
}else{
	var out = "";
}
$(dataTable_container).html(out);
$(dataTable_container).find('tbody').animate({
	scrollTop:999999
}, 50);
}
};

	/**
	 * Function drawThisChart()
	 * This function draws charts with highchart library with data supplied
	 */
	 this.drawThisChart = function(){
		
	 	if(this.data.chartDataSeries!=null) {
	 		if(JMA.myChart.myFolder.currentView=='smallView'){
	 			var small_div='small_';
	 		}else{
	 			var small_div='';
	 		}

	 		var graph_container = 'Dv_placeholder_graphView_' + small_div + this.uuid;

	 		var graph_containerID = '#'+graph_container;
	 		switch (this.chartType) {
	 			case 'line':
				if(JMA.myChart.myFolder.currentView=='smallView'){
				var mq = window.matchMedia( "(max-width: 1199px)" );
				if (mq.matches) {
				this.chart_object = this.drawLineChart(graph_container,graph_containerID).setSize(425, 200);
				}
				else{
				this.chart_object = this.drawLineChart(graph_container,graph_containerID).setSize(250, 170);
				}
				}else if(JMA.myChart.myFolder.currentView=='largeView'){
				this.chart_object = this.drawLineChart(graph_container,graph_containerID);


				}else{
				this.chart_object = this.drawLineChart(graph_container,graph_containerID);
				//this.chart_object = this.drawLineChart1();
				}
				break;
				
				case 'area':
				if(JMA.myChart.myFolder.currentView=='smallView'){
				var mq = window.matchMedia( "(max-width: 1199px)" );
				if (mq.matches) {
				this.chart_object = this.drawAreaChart(graph_container,graph_containerID).setSize(425, 200);
				}
				else{
				this.chart_object = this.drawAreaChart(graph_container,graph_containerID).setSize(250, 170);
				}
				}else if(JMA.myChart.myFolder.currentView=='largeView'){
				this.chart_object = this.drawAreaChart(graph_container,graph_containerID);


				}else{
				this.chart_object = this.drawAreaChart(graph_container,graph_containerID);
				//this.chart_object = this.drawLineChart1();
				}
	 			break;
				
				
				case 'arealine':
				if(JMA.myChart.myFolder.currentView=='smallView'){
				var mq = window.matchMedia( "(max-width: 1199px)" );
				if (mq.matches) {
				this.chart_object = this.drawMapLineChart(graph_container,graph_containerID).setSize(425, 200);
				}
				else{
				this.chart_object = this.drawMapLineChart(graph_container,graph_containerID).setSize(250, 170);
				}
				}else if(JMA.myChart.myFolder.currentView=='largeView'){
				this.chart_object = this.drawMapLineChart(graph_container,graph_containerID);


				}else{
				this.chart_object = this.drawMapLineChart(graph_container,graph_containerID);
				//this.chart_object = this.drawLineChart1();
				}
	 			break;
				
				
				
	 			case 'bar':
	 			if(JMA.myChart.myFolder.currentView=='smallView'){
				var mq = window.matchMedia( "(max-width: 1199px)" );
				if (mq.matches) {
				this.chart_object = this.drawBarChart(graph_container,graph_containerID).setSize(425, 200);
				}
				else{
				this.chart_object = this.drawBarChart(graph_container,graph_containerID).setSize(250, 170);
				}
				}else if(JMA.myChart.myFolder.currentView=='largeView'){
				this.chart_object = this.drawBarChart(graph_container,graph_containerID);


				}else{
				this.chart_object = this.drawBarChart(graph_container,graph_containerID);
				
				}
				break;
	 			case 'multiaxisline':
	 			if(JMA.myChart.myFolder.currentView=='smallView'){
				var mq = window.matchMedia( "(max-width: 1199px)" );
				if (mq.matches) {
				this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID).setSize(425, 200);
				}
				else{
				this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID).setSize(250, 170);
				}
				}else if(JMA.myChart.myFolder.currentView=='largeView'){
				this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);


				}else{
				this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);
				
				}
	 			
	 			break;
	 		}
	 	}else{
	 
	 			//this.populateChartData1();

	 			this.populateChartData();
	 		
	 		
	 	}

this.SwtichtoScrollChart();


	 };

/**
	 * Function SwtichtoScrollChart
	 * Swtich to Scroll Chart
	 */

	 this.SwtichtoScrollChart = function(){

	 setTimeout(function(){ 

if(JMA.myChart.myFolder.currentView=='largeView' && JMA.SmalltoLarge!=null){
var findDivoffset=$('#Dv_folder_content div.exhibit[data-uuid="'+JMA.SmalltoLarge+'"] div.data-views').offset().top;
$('#Dv_folder_content div.exhibit[data-uuid="'+JMA.SmalltoLarge+'"]').addClass('sortable-select');
$(window).scrollTop( findDivoffset-120 );
}

	  }, 1000);

	};
	
	
		/**
	 * Function drawAreaChart
	 * Draw Line chart
	 */
	 this.drawAreaChart = function(graph_container,graph_containerID){
    
		// ********************************************	
		// draw hoghchart


		if(JMA.myChart.myFolder.currentView=='smallView'){
var Xaxislbl_style={fontSize: 7 } 
}else{
	var Xaxislbl_style={fontSize: 11 } 
}

		var position_legend_x = 17;
		var position_legend_width = 527;
		var position_legend_x_export = 17;
		var position_legend_width_export = 547;
		if (this.chart_data_type == 'quaterly') {
			var xAxis = {
					//	ordinal:false,
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					labels : {
						style: Xaxislbl_style ,
						//format : '{value}'
						/* formatter : function() {
							var s = "";
							if (Highcharts.dateFormat('%b', this.value) == 'Mar') {
								s = s + "Q1"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
								s = s + "Q2"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
								s = s + "Q3"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
								s = s + "Q4"
							};
							s = s + " " + Highcharts.dateFormat('%Y', this.value);
							return s;
						} */
					},
					tickInterval: 3 * 30 * 24 * 3600 * 1000, 
					/* type: 'datetime',  */
		          //  startOnTick : true,
		          tickPositioner: function (vMin,vMax) {
		          	return self.generateChartTickPositions(vMin,vMax);
		          }
		        };

		        var toolTip = {
		        	formatter: function () {
		        		var s = '<b>';
		        		if (Highcharts.dateFormat('%b', this.x) == 'Mar') {
		        			s = s + "Q1"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Jun') {
		        			s = s + "Q2"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Sep') {
		        			s = s + "Q3"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Dec') {
		        			s = s + "Q4"
		        		};
		        		s = s + " " + Highcharts.dateFormat('%Y', this.x) + '</b>';
		        		$.each(this.points, function (i, point) {
		        			s += '<br/>' + point.series.name + ': '+point.y;
		        		});
		        		return s;
		        	},
		        	shared: true
		        };
		      } else {
		      	var xAxis = {
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					labels : {
						style: Xaxislbl_style 
					},
					type: 'datetime',
					labels: {
						style: {
							fontFamily: 'Tahoma'
						},
						rotation: -45
					},
					minPadding: 0,
                    maxPadding: 0
				};
				
				var toolTip = {};
			}
			var yAxis = {
				gridLineWidth : 1.5, // The default value, no need to change it
				title: {
                    text: null
                },
				gridLineDashStyle: 'Dot',
				gridLineColor: '#999999',
				gridZIndex: -10,
				// offset : 10,
				opposite : false,
				labels : {
					align : 'right',
					style: Xaxislbl_style 
				// y: 3
			},
			plotLines : [ {
				value : 0,
				color : 'black',
				dashStyle : 'shortdash',
				width : 1.5
			} ]
		};

			// var nav_ser_data = chart_data_series[0];
			// nav_ser_data['color'] = '#DE4623';
			// nav_ser_data['type'] = 'areaspline';

var isBig  = window.matchMedia( "(min-width: 768px)" );
			var aliMent = '';
var fontSz = '';
var wordwapF = '';

if(isBig.matches)
{
		var legendSub = this.title;
var aliMent = 'center';
var fontSz = '11px';
var wordwapF = function() {
var legendName = legendSub +" - "+ this.name;
/*  var match = legendName.match(/.{1,50}/g);
return match.toString().replace(/\,/g,"<br/>"); */
return legendName;
};
}
else
{
var aliMent = 'left';
var fontSz = '8px !important';
var wordwapF = function() {
var legendName = this.name;
var match = legendName.match(/.{1,70}/g);
return match.toString().replace(/\,/g,"<br/>");
};

}
	       
			
			var pointIntUnit = "year";
			if(self.chart_data_type == "monthly")
			{
				var pointIntUnit = "month";	
			}
			
			
			
			return new Highcharts.Chart({
				chart : {
					
                    type : 'area',    
					renderTo : graph_container,
					//backgroundColor : '#FBFBFB',
					backgroundColor : '#f5f5f5',
					plotBorderColor : '#000000',
					plotBackgroundColor : '#FFFFFF',
					plotBorderWidth : 0.5,
					spacingBottom : 35,
					alignTicks: true,
					spacingLeft: 50
				},

				/*responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        align: 'left',
                        verticalAlign: 'bottom',
                        layout: 'horizontal',
                        backgroundColor : 'red'
                    }
                }
            }]
        },*/

				exporting : {
					enabled : false,
					  scale: 3,
           fallbackToExportServer: false,
					chartOptions:{
						chart : {
							//	spacingBottom : 85,
							events : {
								load : function(){
									this.renderer.image(JMA.baseURL+'assets/images/logo.png', 385, 315, 195,12).add();
									/* this.renderer.image(window.location.protocol+'//content.indiamacroadvisors.com/images/graph-background.png', 385, 315, 195,16).add(); */
									this.renderer.text("Source : "+self.data.sources, 10, 325, 159, 33).css({size:'3px'}).add();
								}
							}
						},
						title : {
										
							text : ''
						},
						navigator:{
							enabled:false
						},
						scrollbar:{
							enabled : false
						},
						legend : {
							enabled : true,
							backgroundColor : '#fffde1',
							verticalAlign : 'top',
							itemWidth : position_legend_width_export,
							x : position_legend_x_export,						
							itemStyle : {
								color : '#274b6d',
								fontSize : '11px'
							}
						}
					}
				},
				title :  false,
						
				colors : self.chartConfigs.colors,
				credits : {
					enabled : false,
					href : 'http://www.indiamacroadvisors.com',
					text : 'indiamacroadvisors.com'
				},
				series : self.data.chartDataSeries,
				rangeSelector : {
					enabled : false,
				},
				plotOptions : {
					line : {
						dataGrouping : {
							enabled : false,
							approximation : 'average',
							dateTimeLabelFormats : {
								month : [ '%B %Y', '%B', '-%B %Y' ]
							}
						}
					},
					pointStart: self.navigator_date_from,
					pointIntervalUnit: pointIntUnit
				},
				/* scrollbar:{
							enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false
						}, */
				legend : {
					enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					backgroundColor : '#fffde1',
					verticalAlign : 'top',
				//	itemWidth : position_legend_width,
				//	x : position_legend_x,						
					/* itemStyle : {
						color : '#274b6d',
						fontSize : '11px'
					} */
					labelFormatter: wordwapF,							
					itemStyle : {
						color : '#274b6d',
						fontSize : fontSz
					}
				},
			navigator : {
				enabled : false,
				maskFill : "rgba(0, 0, 0, 0.10)",
				series : {
					lineColor : '#316AB4'
				}
			},
			
			yAxis : yAxis,
			xAxis : xAxis,
			tooltip: toolTip
		}, function(p_chrtObj) {

			if(JMA.myChart.myFolder.currentView=='largeView'){
			p_chrtObj.renderer.image(JMA.baseURL+'assets/images/ima-logo-80_80_small.png', 450, 380, 60,16).add();
			p_chrtObj.renderer.text("Source : "+self.data.sources, 10, 390, 159, 33).add();
		}
			/* p_chrtObj.xAxis[0].setExtremes(
				self.navigator_date_from-1,
				self.navigator_date_to); */
		});
	    // Drawn Highchart		
		// **************************************************	

	};
	
	
	

	/**
	 * Function drawLineChart
	 * Draw Line chart
	 */
	 this.drawMapLineChart = function(graph_container,graph_containerID){
		// ********************************************	
		// draw hoghchart


		if(JMA.myChart.myFolder.currentView=='smallView'){
var Xaxislbl_style={fontSize: 7 } 
}else{
	var Xaxislbl_style={fontSize: 11 } 
}

		var position_legend_x = 17;
		var position_legend_width = 527;
		var position_legend_x_export = 17;
		var position_legend_width_export = 547;
		if (this.chart_data_type == 'quaterly') {
			var xAxis = {
					//	ordinal:false,
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					labels : {
						style: Xaxislbl_style ,
						//format : '{value}'
						/* formatter : function() {
							var s = "";
							if (Highcharts.dateFormat('%b', this.value) == 'Mar') {
								s = s + "Q1"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
								s = s + "Q2"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
								s = s + "Q3"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
								s = s + "Q4"
							};
							s = s + " " + Highcharts.dateFormat('%Y', this.value);
							return s;
						} */
					},
					scrollbar: {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					},
					//tickInterval: 3 * 30 * 24 * 3600 * 1000, 
					//type: 'datetime',
		          //  startOnTick : true,
		          tickPositioner: function (vMin,vMax) {
		          	return self.generateChartTickPositions(vMin,vMax);
		          }
		        };

		        var toolTip = {
		        	formatter: function () {
		        		var s = '<b>';
		        		if (Highcharts.dateFormat('%b', this.x) == 'Mar') {
		        			s = s + "Q1"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Jun') {
		        			s = s + "Q2"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Sep') {
		        			s = s + "Q3"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Dec') {
		        			s = s + "Q4"
		        		};
		        		s = s + " " + Highcharts.dateFormat('%Y', this.x) + '</b>';
		        		$.each(this.points, function (i, point) {
		        			s += '<br/>' + point.series.name + ': '+point.y;
		        		});
		        		return s;
		        	},
		        	shared: true
		        };
		      } else {
		      	var xAxis = {
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					scrollbar: {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					}
					,
					/* labels : {
						style: Xaxislbl_style 
					}, */
					type: 'datetime',
					labels: {
						style: {
							fontFamily: 'Tahoma'
						},
						rotation: -45
					},
				};
				
				var toolTip = {};
			}
			var yAxis = {
				gridLineWidth : 1.5, // The default value, no need to change it
				title: {
                    text: null
                },
				gridLineDashStyle: 'Dot',
				gridLineColor: '#999999',
				gridZIndex: -10,
				// offset : 10,
				opposite : false,
				labels : {
					align : 'right',
					style: Xaxislbl_style 
				// y: 3
			},
			plotLines : [ {
				value : 0,
				color : 'black',
				dashStyle : 'shortdash',
				width : 1.5
			} ]
		};

			// var nav_ser_data = chart_data_series[0];
			// nav_ser_data['color'] = '#DE4623';
			// nav_ser_data['type'] = 'areaspline';

var isBig  = window.matchMedia( "(min-width: 768px)" );
			var aliMent = '';
var fontSz = '';
var wordwapF = '';



if(isBig.matches)
{
	var legendSub = this.title;
var aliMent = 'center';
var fontSz = '11px';
var wordwapF = function() {
	//console.log(this);
var legendName = legendSub +" - "+ this.name;
/*  var match = legendName.match(/.{1,50}/g);
return match.toString().replace(/\,/g,"<br/>"); */
return legendName;
};
}
else
{
var aliMent = 'left';
var fontSz = '8px !important';
var wordwapF = function() {
var legendName = this.name;
var match = legendName.match(/.{1,70}/g);
return match.toString().replace(/\,/g,"<br/>");
};

}
	
	        var pointIntUnit = "year";
			if(self.chart_data_type == "monthly")
			{
				var pointIntUnit = "month";	
			}
			return new Highcharts.Chart({
				chart : { 
					renderTo : graph_container,
					//backgroundColor : '#FBFBFB',
					backgroundColor : '#f5f5f5',
					plotBorderColor : '#000000',
					plotBackgroundColor : '#FFFFFF',
					plotBorderWidth : 0.5,
					spacingBottom : 35,
					alignTicks: true
				},

				/*responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        align: 'left',
                        verticalAlign: 'bottom',
                        layout: 'horizontal',
                        backgroundColor : 'red'
                    }
                }
            }]
        },*/

				exporting : {
					enabled : false,
					  scale: 3,
           fallbackToExportServer: false,
					chartOptions:{
						chart : {
							//	spacingBottom : 85,
							events : {
								load : function(){
									this.renderer.image(JMA.baseURL+'assets/images/logo.png', 385, 315, 195,12).add();
									/* this.renderer.image(window.location.protocol+'//content.indiamacroadvisors.com/images/graph-background.png', 385, 315, 195,16).add(); */
									this.renderer.text("Source : "+self.data.sources, 10, 325, 159, 33).css({size:'3px'}).add();
								}
							}
						},
						navigator:{
							enabled:false
						},
						scrollbar:{
							enabled : false
						},
						legend : {
							enabled : true,
							backgroundColor : '#fffde1',
							verticalAlign : 'top',
							itemWidth : position_legend_width_export,
							x : position_legend_x_export,						
							itemStyle : {
								color : '#274b6d',
								fontSize : '11px'
							}
						},
						title :  false
					}
				},
				title :  false,
				colors : self.chartConfigs.colors,
				credits : {
					enabled : false,
					href : 'http://www.indiamacroadvisors.com',
					text : 'indiamacroadvisors.com'
				},
				series : self.data.chartDataSeries,
				rangeSelector : {
					enabled : false,
				},
				plotOptions : {
					line : {
						dataGrouping : {
							enabled : false,
							approximation : 'average',
							dateTimeLabelFormats : {
								month : [ '%B %Y', '%B', '-%B %Y' ]
							}
						}
					},
					series: {
							animation: {
								duration: 500
							},
							marker: {
								enabled: false
							},
							pointStart: self.navigator_date_from,
							pointIntervalUnit: pointIntUnit
							//pointInterval: 24 * 3600 * 1000 * 31 // one day
						}
				},	scrollbar: {
					enabled : false ,
				},/* 
				scrollbar:{
							enabled : (JMA.myChart.myFolder.currentView=='largeView') ? false :false
						}, */
				legend : {
					enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					backgroundColor : '#fffde1',
					verticalAlign : 'top',
				//	itemWidth : position_legend_width,
				//	x : position_legend_x,						
					/* itemStyle : {
						color : '#274b6d',
						fontSize : '11px'
					} */
					labelFormatter: wordwapF,							
					itemStyle : {
						color : '#274b6d',
						fontSize : fontSz
					}
				},
				
			navigator : {
				enabled : false,
				maskFill : "rgba(0, 0, 0, 0.10)",
				series : {
					lineColor : '#316AB4'
				}
			},
			
			yAxis : yAxis,
			xAxis : xAxis,
			tooltip: {
				shared: true
			}
			//tooltip: toolTip
		}, function(p_chrtObj) {

			if(JMA.myChart.myFolder.currentView=='largeView'){
			p_chrtObj.renderer.image(JMA.baseURL+'assets/images/ima-logo-80_80_small.png', 450, 380, 60,16).add();
			p_chrtObj.renderer.text("Source : "+self.data.sources, 10, 390, 159, 33).add();
		}
			 p_chrtObj.xAxis[0].setExtremes(
				self.navigator_date_from,
				self.navigator_date_to);
		});
	    // Drawn Highchart		
		// **************************************************	

	};

	/**
	 * Function drawLineChart
	 * Draw Line chart
	 */
	
	this.drawLineChart = function(graph_container,graph_containerID){
		// ********************************************	
		// draw hoghchart


		if(JMA.myChart.myFolder.currentView=='smallView'){
var Xaxislbl_style={fontSize: 7 } 
}else{
	var Xaxislbl_style={fontSize: 11 } 
}

		var position_legend_x = 17;
		var position_legend_width = 527;
		var position_legend_x_export = 17;
		var position_legend_width_export = 547;
		if (this.chart_data_type == 'quaterly') {
			var xAxis = {
					//	ordinal:false,
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					labels : {
						style: Xaxislbl_style ,
						//format : '{value}'
						 formatter : function() {
							var s = "";
							if (Highcharts.dateFormat('%b', this.value) == 'Mar') {
								s = s + "Q1"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
								s = s + "Q2"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
								s = s + "Q3"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
								s = s + "Q4"
							};
							s = s + " " + Highcharts.dateFormat('%Y', this.value);
							return s;
						}
					},
					scrollbar: {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					},
					tickInterval: 3 * 30 * 24 * 3600 * 1000, 
					type: 'datetime',
		          //  startOnTick : true,
		          tickPositioner: function (vMin,vMax) {
		          	return self.generateChartTickPositions(vMin,vMax);
		          }
		        };

		        var toolTip = {
		        	formatter: function () {
		        		var s = '<b>';
		        		if (Highcharts.dateFormat('%b', this.x) == 'Mar') {
		        			s = s + "Q1"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Jun') {
		        			s = s + "Q2"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Sep') {
		        			s = s + "Q3"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Dec') {
		        			s = s + "Q4"
		        		};
		        		s = s + " " + Highcharts.dateFormat('%Y', this.x) + '</b>';
		        		$.each(this.points, function (i, point) {
		        			s += '<br/>' + point.series.name + ': '+point.y;
		        		});
		        		return s;
		        	},
		        	shared: true
		        };
		      } else {
		      	var xAxis = {
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					scrollbar: {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					},
					labels : {
						style: Xaxislbl_style 
					}
				};
				
				var toolTip = {
					useHTML: true,
				backgroundColor: null,
				borderWidth: 0,
        shadow: false,
				positioner: function () {
            return { x: 0, y: 308 };
        }
				};
			}
			var yAxis = {
				gridLineWidth : 1.5, // The default value, no need to change it
				gridLineDashStyle: 'Dot',
				gridLineColor: '#999999',
				gridZIndex: -10,
				// offset : 10,
				opposite : false,
				labels : {
					align : 'right',
					style: Xaxislbl_style 
				// y: 3
			},
			plotLines : [ {
				value : 0,
				color : 'black',
				dashStyle : 'shortdash',
				width : 1.5
			} ]
		};

			// var nav_ser_data = chart_data_series[0];
			// nav_ser_data['color'] = '#DE4623';
			// nav_ser_data['type'] = 'areaspline';

var isBig  = window.matchMedia( "(min-width: 768px)" );
			var aliMent = '';
var fontSz = '';
var wordwapF = '';

if(isBig.matches)
{
var aliMent = 'center';
var fontSz = '11px';
var wordwapF = function() {
var legendName = this.name;
/*  var match = legendName.match(/.{1,50}/g);
return match.toString().replace(/\,/g,"<br/>"); */
return legendName;
};
}
else
{
var aliMent = 'left';
var fontSz = '8px !important';
var wordwapF = function() {
var legendName = this.name;
var match = legendName.match(/.{1,70}/g);
return match.toString().replace(/\,/g,"<br/>");
};

}
	       $(self.color_code).each(function(index ) {
                if(self.color_code[index])
				{
					self.chartConfigs.colors[index] = self.color_code[index];
				}
		   });
			return new Highcharts.StockChart({
				chart : {

					renderTo : graph_container,
					//backgroundColor : '#FBFBFB',
					backgroundColor : '#f5f5f5',
					plotBorderColor : '#000000',
					plotBackgroundColor : '#FFFFFF',
					plotBorderWidth : 0.5,
					spacingBottom : 35,
					alignTicks: true
				},

				/*responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        align: 'left',
                        verticalAlign: 'bottom',
                        layout: 'horizontal',
                        backgroundColor : 'red'
                    }
                }
            }]
        },*/

				exporting : {
					enabled : false,
					  scale: 3,
           fallbackToExportServer: false,
					chartOptions:{
						chart : {
							//	spacingBottom : 85,
							events : {
								load : function(){
									this.renderer.image(JMA.baseURL+'assets/images/favicon.png', 385, 315, 195,12).add();
									/* this.renderer.image(window.location.protocol+'//content.indiamacroadvisors.com/images/graph-background.png', 385, 315, 195,16).add(); */
									this.renderer.text("Source : "+self.data.sources, 10, 325, 159, 33).css({size:'3px'}).add();
								}
							}
						},
						navigator:{
							enabled:false
						},
						scrollbar:{
							enabled : false
						},
						legend : {
							enabled : true,
							backgroundColor : '#fffde1',
							verticalAlign : 'top',
							itemWidth : position_legend_width_export,
							x : position_legend_x_export,						
							itemStyle : {
								color : '#274b6d',
								fontSize : '11px'
							}
						}
					}
				},
				colors : self.chartConfigs.colors,
				credits : {
					enabled : false,
					href : 'http://www.indiamacroadvisors.com',
					text : 'indiamacroadvisors.com'
				},
				series : self.data.chartDataSeries,
				rangeSelector : {
					enabled : false,
				},
				plotOptions : {
					line : {
						dataGrouping : {
							enabled : false,
							approximation : 'average',
							dateTimeLabelFormats : {
								month : [ '%B %Y', '%B', '-%B %Y' ]
							}
						}
					}
				},	scrollbar: {
					enabled : false ,
				},
				/* scrollbar:{
							enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false
						}, */
				legend : {
					enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					backgroundColor : '#fffde1',
					verticalAlign : 'top',
				//	itemWidth : position_legend_width,
				//	x : position_legend_x,						
					/* itemStyle : {
						color : '#274b6d',
						fontSize : '11px'
					} */
					labelFormatter: wordwapF,							
					itemStyle : {
						color : '#274b6d',
						fontSize : fontSz
					}
				},
			navigator : {
				enabled : false,
				maskFill : "rgba(0, 0, 0, 0.10)",
				series : {
					lineColor : '#316AB4'
				}
			},
			
			yAxis : yAxis,
			xAxis : xAxis,
			tooltip: toolTip
		}, function(p_chrtObj) {

			if(JMA.myChart.myFolder.currentView=='largeView'){
			p_chrtObj.renderer.image(JMA.baseURL+'assets/images/ima-logo-80_80_small.png', 450, 380, 60,16).add();
			p_chrtObj.renderer.text("Source : "+self.data.sources, 10, 390, 159, 33).add();
		}
			p_chrtObj.xAxis[0].setExtremes(
				self.navigator_date_from-1,
				self.navigator_date_to);
		});
	    // Drawn Highchart		
		// **************************************************	

	};




	/**
	 * Function drawLineChart
	 * Draw Line chart
	 */
 this.drawLineChart1 = function(){

 	//alert(graph_container)

		// ********************************************	
		// draw hoghchart
		var position_legend_x = 17;
		var position_legend_width = 527;
		var position_legend_x_export = 17;
		var position_legend_width_export = 547;
		if (this.chart_data_type == 'quaterly') {
			var xAxis = {
					//	ordinal:false,
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					labels : {
						//format : '{value}'
						formatter : function() {
							var s = "";
							if (Highcharts.dateFormat('%b', this.value) == 'Mar') {
								s = s + "Q1"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
								s = s + "Q2"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
								s = s + "Q3"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
								s = s + "Q4"
							};
							s = s + " " + Highcharts.dateFormat('%Y', this.value);
							return s;
						}
					},
					scrollbar: {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					},
					tickInterval: 3 * 30 * 24 * 3600 * 1000, 
					type: 'datetime',
		          //  startOnTick : true,
		          tickPositioner: function (vMin,vMax) {
		          	return self.generateChartTickPositions(vMin,vMax);
		          }
		        };

		        var toolTip = {
		        	formatter: function () {
		        		var s = '<b>';
		        		if (Highcharts.dateFormat('%b', this.x) == 'Mar') {
		        			s = s + "Q1"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Jun') {
		        			s = s + "Q2"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Sep') {
		        			s = s + "Q3"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Dec') {
		        			s = s + "Q4"
		        		};
		        		s = s + " " + Highcharts.dateFormat('%Y', this.x) + '</b>';
		        		$.each(this.points, function (i, point) {
		        			s += '<br/>' + point.series.name + ': '+point.y;
		        		});
		        		return s;
		        	},
		        	shared: true
		        };
		      } else {
		      	var xAxis = {
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					scrollbar: {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					}
				};
				
				var toolTip = {};
			}
			var yAxis = {
				gridLineWidth : 1.5, // The default value, no need to change it
				gridLineDashStyle: 'Dot',
				gridLineColor: '#999999',
				gridZIndex: -10,
				// offset : 10,
				opposite : false,
				labels : {
					align : 'right',
				// y: 3
			},
			plotLines : [ {
				value : 0,
				color : 'black',
				dashStyle : 'shortdash',
				width : 1.5
			} ]
		};





           $(self.color_code).each(function(index ) {
                if(self.color_code[index])
				{
					self.chartConfigs.colors[index] = self.color_code[index];
				}
		   });



			
	 var optionsStr = {
				chart : {

					//renderTo : graph_container,
					//backgroundColor : '#FBFBFB',
					backgroundColor : '#f5f5f5',
					plotBorderColor : '#000000',
					plotBackgroundColor : '#FFFFFF',
					plotBorderWidth : 0.5,
					spacingBottom : 35,
					alignTicks: true,
				 events: {
          redraw: function() {
            $('.credits').remove();
            var chart = this,
              width = chart.chartWidth - 105,
              height = chart.chartHeight - 25;
            chart.renderer.image('http://quantlabs.net/blog/wp-content/uploads/2015/12/highcharts-logo.png', width, height, 100, 20).addClass('credits').add();
          }
        }
				},
				exporting : {
					enabled : false,
					chartOptions:{
						chart : {
							//	spacingBottom : 85,
							events : {
								load : function(){
									this.renderer.image(JMA.baseURL+'assets/images/logo.png', 385, 315, 195,16).add();
									this.renderer.text("Source : "+self.data.sources, 10, 325, 159, 33).css({size:'3px'}).add();
								}
							}
						},
						navigator:{
							enabled:false
						},
						scrollbar:{
							enabled : false
						},
						legend : {
							enabled : true,
							backgroundColor : '#fffde1',
							verticalAlign : 'top',
							itemWidth : position_legend_width_export,
							x : position_legend_x_export,						
							itemStyle : {
								color : '#274b6d',
								fontSize : '11px'
							}
						}
					}
				},
				colors : self.chartConfigs.colors,
				credits : {
					enabled : true,
					href : 'http://www.indiamacroadvisors.com',
					text : 'indiamacroadvisors.com',
					style: {
                backgroundImage: 'url('+JMA.baseURL+'assets/images/logo.png)'
            }
				},
				series : self.data.chartDataSeries,
				
				plotOptions : {
					line : {
						dataGrouping : {
							enabled : false,
							approximation : 'average',
							dateTimeLabelFormats : {
								month : [ '%B %Y', '%B', '-%B %Y' ]
							}
						}
					}
				},	scrollbar: {
					enabled : false ,
				},
				legend : {
					enabled : true,
					backgroundColor : '#fffde1',
					verticalAlign : 'top',
				//	itemWidth : position_legend_width,
				//	x : position_legend_x,						
				itemStyle : {
					color : '#274b6d',
					fontSize : '11px'
				}
			},
			navigator : {
				enabled : false,
				maskFill : "rgba(0, 0, 0, 0.10)",
				series : {
					lineColor : '#316AB4'
				}
			},
			yAxis : yAxis,
			xAxis : xAxis,
			tooltip: toolTip

		};



//var chart = new Highcharts.Chart(data).exportChart();
 //var chart1 = new Highcharts.Chart(optionsStr).exportChart();
var optionsStr = JSON.stringify(optionsStr);

	 dataString = encodeURI('async=true&options=' + optionsStr);
   var exportUrl = 'http://export.highcharts.com/';
        /*if (window.XDomainRequest) {
            var xdr = new XDomainRequest();
            xdr.open("post", exportUrl+ '?' + dataString);
            xdr.onload = function () {
               $('#veera').html('<img src="' + exporturl + xdr.responseText + '"/>');
            };
            xdr.send();
        }*/
            $.ajax({
                type: 'POST',
                data: dataString,
                url: exportUrl,
                success: function (data) {
                  var url = exportUrl + data;
					window.open(url);
					// chart.exportChart();
					
                 $('#veera').html('<img src="' + exportUrl + data + '"/>');
                },
                error: function (err) {
                    debugger;
                    console.log('error', err.statusText)
                }
            });
	    // Drawn Highchart		
		// **************************************************			
	};
	
	/**
	 * Function drawLineChart
	 * Draw Bar chart
	 */
	 this.drawBarChart = function(graph_container,graph_containerID){
		// draw highchart
		var position_legend_x = 17;
		var position_legend_width = 527;
		var position_legend_x_export = 17;
		var position_legend_width_export = 547;
			if(JMA.myChart.myFolder.currentView=='smallView'){
var Xaxislbl_style={fontSize: 7 } 
}else{
	var Xaxislbl_style={fontSize: 11 } 
}

		if (this.chart_data_type == 'quaterly') {
			var xAxis = {
					//	ordinal:false,
					minRange: 1,
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					labels : {
						style: Xaxislbl_style ,
						//format : '{value}'
						formatter : function() {
							var s = "";
							if (Highcharts.dateFormat('%b', this.value) == 'Mar') {
								s = s + "Q1"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
								s = s + "Q2"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
								s = s + "Q3"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
								s = s + "Q4"
							};
							s = s + " " + Highcharts.dateFormat('%Y', this.value);
							return s;
						},
						useHTML: true,
				backgroundColor: null,
				borderWidth: 0,
        shadow: false,
				positioner: function () {
            return { x: 37, y: 285 };
        }
					},
					scrollbar: {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					},
					tickInterval: 3 * 30 * 24 * 3600 * 1000, 
					type: 'datetime',
		          //  startOnTick : true,
		          tickPositioner: function (vMin,vMax) {
		          	return self.generateChartTickPositions(vMin,vMax);
		          }
		        };

		        var toolTip = {
		        	formatter: function () {
		        		var s = '<b>';
		        		if (Highcharts.dateFormat('%b', this.x) == 'Mar') {
		        			s = s + "Q1"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Jun') {
		        			s = s + "Q2"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Sep') {
		        			s = s + "Q3"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Dec') {
		        			s = s + "Q4"
		        		};
		        		s = s + " " + Highcharts.dateFormat('%Y', this.x) + '</b>';
		        		$.each(this.points, function (i, point) {
		        			s += '<br/>' + point.series.name + ': '+point.y;
		        		});
		        		return s;
		        	},
		        	shared: true
		        };
		      } else {
		      	var xAxis = {
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					scrollbar: {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					},
					labels : {
						style: Xaxislbl_style 
					}
				};
				
				var toolTip = {
					useHTML: true,
				backgroundColor: null,
				borderWidth: 0,
        shadow: false,
				positioner: function () {
            return { x: 0, y: 308 };
        }
				};
			}
			var yAxis = {
				gridLineWidth : 1.5, // The default value, no need to change it
				gridLineDashStyle: 'Dot',
				gridLineColor: '#999999',
				//gridZIndex: -10,
				// offset : 10,
				opposite : false,
				labels : {
					align : 'right',
					style: Xaxislbl_style 
				// y: 3
			},
			plotLines : [ {
				value : 0,
				color : 'black',
				dashStyle : 'shortdash',
				width : 1.5
			} ]
		};
			// var nav_ser_data = chart_data_series[0];
			// nav_ser_data['color'] = '#DE4623';
			// nav_ser_data['type'] = 'areaspline';


			var isBig  = window.matchMedia( "(min-width: 1025px)" );
		
			var aliMent = '';
			var fontSz = '';
			var wordwapF = '';
			
			if(isBig.matches)
			{
				var aliMent = 'center';
				var fontSz = '11px';
				var wordwapF = function() {
						var legendName = this.name;
						/*  var match = legendName.match(/.{1,50}/g);
						return match.toString().replace(/\,/g,"<br/>"); */
						return legendName;
					};
			}
			else
			{
				var aliMent = 'left';
				var fontSz = '8px !important';
				var wordwapF = function() {
						var legendName = this.name;
						var match = legendName.match(/.{1,70}/g);
						return match.toString().replace(/\,/g,"<br/>");
					};
				
			}
			
			$(self.color_code).each(function(index ) {
                if(self.color_code[index])
				{
					self.chartConfigs.colors[index] = self.color_code[index];
				}
		   });

			return new Highcharts.StockChart({
				chart : {
					type: 'column',
					renderTo : graph_container,
					//backgroundColor : '#FBFBFB',
					backgroundColor : '#f5f5f5',
					plotBorderColor : '#000000',
					plotBackgroundColor : '#FFFFFF',
					plotBorderWidth : 0.5,
					spacingBottom : 35,
					alignTicks: true
				},
				exporting : {
					enabled : false,
					chartOptions:{
						chart : {
							//	spacingBottom : 85,
							events : {
								load : function(){
									this.renderer.image(JMA.baseURL+'assets/images/logo.png', 385, 315, 195,12).add();
									this.renderer.text("Source : "+self.data.sources, 10, 325, 159, 33).css({size:'3px'}).add();
								}
							}
						},
						navigator:{
							enabled:false
						},
						scrollbar:{
							enabled : false
						},
						legend : {
								enabled : true,
								backgroundColor : '#fffde1',
								verticalAlign : 'top',
								/* itemWidth : position_legend_width_export,
								x : position_legend_x_export,						
								itemStyle : {
									color : '#274b6d',
									fontSize : '11px'
								} */
								labelFormatter: wordwapF,							
								itemStyle : {
									color : '#274b6d',
									fontSize : fontSz
								}
							}
					}
				},
				colors : self.chartConfigs.colors,
				credits : {
					enabled : false,
					href : 'http://www.indiamacroadvisors.com',
					text : 'indiamacroadvisors.com'
				},
				series : self.data.chartDataSeries,
				rangeSelector : {
					enabled : false,
				},
				plotOptions : {
					column : {
						dataGrouping : {
							enabled : false,
							approximation : 'average',
							dateTimeLabelFormats : {
								month : [ '%B %Y', '%B', '-%B %Y' ]
							},
							units : [[
							'month',
							[3,6]
							]]
						}
					}
				},
				scrollbar: {
					enabled : false ,
				},
				/* scrollbar:{
							enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false
						}, */
				legend : {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					backgroundColor : '#fffde1',
					verticalAlign : 'top',
				//	itemWidth : position_legend_width,
				//	x : position_legend_x,						
					/* itemStyle : {
						color : '#274b6d',
						fontSize : '11px'
					} */
					labelFormatter: wordwapF,							
					itemStyle : {
						color : '#274b6d',
						fontSize : fontSz
					}
				},
			navigator : {
				enabled : false,
				maskFill : "rgba(0, 0, 0, 0.10)",
				series : {
					lineColor : '#316AB4'
				}
			},
			yAxis : yAxis,
			xAxis : xAxis,
			tooltip: toolTip
		}, function(p_chrtObj) {
			if(JMA.myChart.myFolder.currentView=='largeView'){
			p_chrtObj.renderer.image(JMA.baseURL+'assets/images/ima-logo-80_80_small.png', 450, 380, 60,16).add();
			p_chrtObj.renderer.text("Source : "+self.data.sources, 10, 390, 159, 33).add();
		}
			p_chrtObj.xAxis[0].setExtremes(
				self.navigator_date_from-1,
				self.navigator_date_to);
		});
	    // Drawn Highchart		
		// **************************************************			
	};
	
	/**
	 * Function drawLineChart
	 * Draw Multi-axis chart
	 */
	 this.drawMultiAxisChart = function(graph_container,graph_containerID){

		// ********************************************	
		// draw highchart

		 var isBig  = window.matchMedia( "(min-width: 1025px)" );
		var formetted_data_series = this.createMultiYaxisConfigurations(self.data.chartDataSeries);
		var number_of_lines = Object.keys(formetted_data_series.dataSeries).length;
		for(var formetted_data_series_count = 0; formetted_data_series_count<number_of_lines; formetted_data_series_count++){
			if(isBig.matches)
		        {
					if(formetted_data_series.yAxis[formetted_data_series_count].title.text.length>40){
					formetted_data_series.yAxis[formetted_data_series_count].title.text = formetted_data_series.yAxis[formetted_data_series_count].title.text.substring(0,40) + '....';
				    }
				}
                else
                {
					if(formetted_data_series.yAxis[formetted_data_series_count].title.text.length>20){
					formetted_data_series.yAxis[formetted_data_series_count].title.text = formetted_data_series.yAxis[formetted_data_series_count].title.text.substring(0,20) + '....';
				    }
				}
		}
		var position_legend_x = 17;
		var position_legend_width = 527;
		var position_legend_x_export = 17;
		var position_legend_width_export = 547;
			if(JMA.myChart.myFolder.currentView=='smallView'){
var Xaxislbl_style={fontSize: 7 } 
}else{
	var Xaxislbl_style={fontSize: 11 } 
}
 
		if (this.chart_data_type == 'quaterly') {
			var xAxis = {
					//	ordinal:false,
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					labels : {
						style: Xaxislbl_style,
						//format : '{value}'
						formatter : function() {
							var s = "";
							if (Highcharts.dateFormat('%b', this.value) == 'Mar') {
								s = s + "Q1"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Jun') {
								s = s + "Q2"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Sep') {
								s = s + "Q3"
							};
							if (Highcharts.dateFormat('%b', this.value) == 'Dec') {
								s = s + "Q4"
							};
							s = s + " " + Highcharts.dateFormat('%Y', this.value);
							return s;
						},
					},
					scrollbar: {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					},
					tickInterval: 3 * 30 * 24 * 3600 * 1000, 
					type: 'datetime',
		          //  startOnTick : true,
		          tickPositioner: function (vMin,vMax) {
		          	return self.generateChartTickPositions(vMin,vMax);
		          }
		        };

		        var toolTip = {
		        	formatter: function () {
		        		var s = '<b>';
		        		if (Highcharts.dateFormat('%b', this.x) == 'Mar') {
		        			s = s + "Q1"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Jun') {
		        			s = s + "Q2"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Sep') {
		        			s = s + "Q3"
		        		};
		        		if (Highcharts.dateFormat('%b', this.x) == 'Dec') {
		        			s = s + "Q4"
		        		};
		        		s = s + " " + Highcharts.dateFormat('%Y', this.x) + '</b>';
		        		$.each(this.points, function (i, point) {
		        			s += '<br/>' + point.series.name + ': '+point.y;
		        		});
		        		return s;
		        	},
		        	shared: true
		        };
		      } else {
		      	var xAxis = {
					gridLineWidth : 0, // New value
					events : {
						setExtremes : function(e) {
							self.navigator_date_from = e.min;
							self.navigator_date_to = e.max;
						}
					},
					scrollbar: {
						enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					},
					labels : {
						style: Xaxislbl_style 
					}
				};
				
				var toolTip = {
					useHTML: true,
				backgroundColor: null,
				borderWidth: 0,
        shadow: false,
				positioner: function () {
          return { x: 0, y: 308 }
        }
				};
			}
			// var nav_ser_data = chart_data_series[0];
			// nav_ser_data['color'] = '#DE4623';
			// nav_ser_data['type'] = 'areaspline';


			var aliMent = '';
			var fontSz = '';
			var wordwapF = '';
			
			if(isBig.matches)
			{
				var aliMent = 'center';
				var fontSz = '11px';
				var wordwapF = function() {
						var legendName = this.name;
						/*  var match = legendName.match(/.{1,50}/g);
						return match.toString().replace(/\,/g,"<br/>"); */
						return legendName;
					};
			}
			else
			{
				var aliMent = 'left';
				var fontSz = '8px !important';
				var wordwapF = function() {
						var legendName = this.name;
						var match = legendName.match(/.{1,70}/g);
						return match.toString().replace(/\,/g,"<br/>");
					};
				
			}
			
			$(self.color_code).each(function(index ) {
					if(self.color_code[index])
					{
						self.chartConfigs.colors[index] = self.color_code[index];
					}
		    });	
			
			return new Highcharts.StockChart({
				chart : {
					renderTo : graph_container,
					//backgroundColor : '#FBFBFB',
					backgroundColor : '#f5f5f5',
					plotBorderColor : '#000000',
					plotBackgroundColor : '#FFFFFF',
					plotBorderWidth : 0.5,
					spacingBottom : 35,
					alignTicks: true,
					events: {
						/*
						load: function() {
				          var c = this;
				          console.log(c.xAxis[0]);
				          setTimeout(function(){c.xAxis[0].setExtremes(c.xAxis[0].Min, self.navigator_date_to)}, 10);
				        }
				        */
				      }
				    },
				    exporting : {
				    	enabled : false,
				    	chartOptions:{
				    		chart : {
							//	spacingBottom : 85,
							events : {
								load : function(){
									this.renderer.image(JMA.baseURL+'assets/images/logo.png', 385, 315, 195,12).add();
									this.renderer.text("Source : "+self.data.sources, 10, 325, 159, 33).css({size:'3px'}).add();
								}
							}
						},
						navigator:{
							enabled:false
						},
						scrollbar:{
							enabled : false
						},
						legend : {
								enabled : true,
								backgroundColor : '#fffde1',
								verticalAlign : 'top',
								/* itemWidth : position_legend_width_export,
								x : position_legend_x_export,						
								itemStyle : {
									color : '#274b6d',
									fontSize : '11px'
								} */
								labelFormatter: wordwapF,							
								itemStyle : {
									color : '#274b6d',
									fontSize : fontSz
								}
							}
					}
				},
				colors : self.chartConfigs.colors,
				credits : {
					enabled : false,
					href : 'http://www.indiamacroadvisors.com',
					text : 'indiamacroadvisors.com'
				},
				series : self.data.chartDataSeries,
				rangeSelector : {
					enabled : false,
				},
				plotOptions : {
					line : {
						dataGrouping: {
							enabled : false,
							approximation : 'average',
							dateTimeLabelFormats : {
								month: ['%B %Y', '%B', '-%B %Y']
							},
							units : [[
							'month',
							[3,6]
							]]
						}
					}
				},	scrollbar: {
					enabled : false ,
				},
				/* scrollbar:{
							enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false
						}, */
				legend : {
					enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					backgroundColor : '#fffde1',
					verticalAlign : 'top',
				//	itemWidth : position_legend_width,
				//	x : position_legend_x,						
					/* itemStyle : {
						color : '#274b6d',
						fontSize : '11px'
					} */
					labelFormatter: wordwapF,							
					itemStyle : {
						color : '#274b6d',
						fontSize : fontSz
					}
				},
			navigator : {
				enabled : false,
				maskFill : "rgba(0, 0, 0, 0.10)",
				series : {
					lineColor : '#316AB4'
				}
			},
			yAxis : formetted_data_series.yAxis,
			xAxis : xAxis,
			tooltip: toolTip
		}, function(p_chrtObj) {
			if(JMA.myChart.myFolder.currentView=='largeView'){
			p_chrtObj.renderer.image(JMA.baseURL+'assets/images/ima-logo-80_80_small.png', 450, 380, 60,16).add();
			p_chrtObj.renderer.text("Source : "+self.data.sources, 10, 390, 159, 33).add();
		}
			p_chrtObj.xAxis[0].setExtremes(
				self.navigator_date_from-1,
				self.navigator_date_to);
		});
	    // Drawn Highchart		
		// **************************************************			
	};	
	
	/**
	 * Function createChartDataSeries()
	 * Funciton to create and format chart dara into series format for highchart
	 */
	 this.createChartDataSeries = function(data,colorCode){
	 	var chartDataSeries = [];
	 	var chart_series_count = 0;
		var seriesName = "";
		var d = 0;
	 	$.each(data, function(chartcode, chart_data_col) {
			    var typechart = self.type;
				if(typechart == "map")
				{
					var statestring = self.chart_labels_available[chartcode];
					var stateVal = statestring.split("-");
                    seriesName = stateVal[0];
					
				}
				else
				{
					if(self.color_code !== undefined)
					{
						if(self.color_code[d])
						{
							seriesName = self.chartConfigs.colors[d] = self.color_code[d];
						}
					}
					else
					{
						 seriesName = self.chart_labels_available[chartcode];
					}
					 
					 seriesName = self.chart_labels_available[chartcode];
					 
				}
				chartDataSeries[chart_series_count] = {
					
					name : seriesName,
					data : chart_data_col
				}
				chart_series_count++;
	 	});
	 	self.data.chartDataSeries =  chartDataSeries;
	 };

/**
	 * Funciton drawThisNote()
	 * Function to draw note on note's placeholder layout.
	 */
	 this.drawThisNote = function(){
	 	// Add note content.
	 	if(JMA.myChart.myFolder.currentView=='smallView'){
	 		$('#smallView_grids #Dv_placeholder_noteContent_'+self.uuid).html(self.note_content);
	 		$('#smallView_grids #Dv_placeholder_noteTitle_'+self.uuid).html(self.title);

	 		

	 	}else{
	 		$('#Dv_placeholder_noteContent_'+self.uuid).html(self.note_content);
	 		$('#Dv_placeholder_noteTitle_'+self.uuid).html(self.title);
	 	}



	//	CKEDITOR.disableAutoInline = true;
	//	this.note_object = CKEDITOR.inline( 'Dv_placeholder_noteContent_'+self.order );
};

	/**
	 * Funciton getThisNoteCreated()
	 * Function to get a note created 
	 */
	 this.getThisNoteCreated = function(){
	 	var vars = {
	 		order : this.order,
	 		uuid : this.uuid
	 	};

	 	if(JMA.myChart.myFolder.currentView=='smallView'){
	 		var GettemplateId=$('#template_mychart_folder_content_note_smallView_layout');

	 	}else{
	 		var GettemplateId=$('#template_mychart_folder_content_note_layout');

	 	}

	 	var newNoteContent_object = Handlebars.compile(GettemplateId.html());
	 	var folderContentLayout = newNoteContent_object(vars);
	 	return folderContentLayout;		
	 };

	/**
	 * Function getThisChartLayouts()
	 * Function to draw the chart s layout for small view and large view.
	 */
	 this.getThisChartLayouts = function(pOrder,pIsDisabled){

	 	var chartLayoutData = {
	 		title : this.title,
	 		order : pOrder,
	 		uuid : this.uuid,
	 		isDisabled : pIsDisabled
	 	};
		
	 	if(JMA.myChart.myFolder.currentView=='smallView'){
	 		var GettemplateId=$('#template_mychart_folder_content_chart_smallView_layout'); 

	 	}else if(JMA.myChart.myFolder.currentView=='listView'){
	 		var GettemplateId=$('#template_mychart_folder_content_list_layout');

	 	}else{
			if(this.type == "map")
			{
				var GettemplateId=$('#template_mychart_folder_content_map_layout');
			}
			else
			{
				var GettemplateId=$('#template_mychart_folder_content_chart_layout');
			}
	 		
	 	}

	 	var chartLayout_object = Handlebars.compile(GettemplateId.html());
	 	return chartLayout_object(chartLayoutData);
	 };

	/**
	 * Function getThisNoteLayouts()
	 * Function to draw the note s layout for small view and large view.
	 */
	 this.getThisNoteLayouts = function(pOrder,pIsDisabled){
	 	var vars = {
	 		title : this.title,
	 		order : pOrder,
	 		uuid : this.uuid,
	 		isDisabled : pIsDisabled
	 	};

	 	if(JMA.myChart.myFolder.currentView=='smallView'){
	 		var GettemplateId=$('#template_mychart_folder_content_note_smallView_layout');

	 	}else{
	 		var GettemplateId=$('#template_mychart_folder_content_note_layout');

	 	}

	 	var noteLayout_object = Handlebars.compile(GettemplateId.html());
	 	return noteLayout_object(vars);
	 };

	/**
	 * Function downloadChartData
	 * Download chart data
	 */
	 this.downloadChartData = function(){
		// console.log(this); //return false;
	 	$('.foldercontent-sub-menu').hide();
	 	var jq_frm_obj = $('#form_mychart_download_data');
	 	jq_frm_obj.find('#frm_input_download_chart_codes').attr('value',this.current_chart_codes.toString());
	 	jq_frm_obj.find('#frm_input_download_chart_datatype').attr('value',this.chart_data_type);
		if(this.type == "map")
		{
			jq_frm_obj.find('#frm_input_download_map_state').attr('value',this.note_content);
			jq_frm_obj.find('#title_map_state').attr('value',this.title);
		}
		
	 	jq_frm_obj.submit();
	 };

	/**
	 * Function exportChart
	 * Export chart image
	 */
	 this.exportChart = function(idx,pType,pSize){
	 	$('.foldercontent-sub-menu').hide();
	 	self.chart_object.exportChart({
	 		type : 'jpeg',

	 		sourceWidth : 700,
	 		sourceHeight : 340,
	 		filename : 'mychart-'+self.uuid,
			//url : 'http://localhost/jma/indiamacroadvisors.com/chart/exportChart'
		//	url : 'http://testing.indiamacroadvisors.com/chart/exportChart'


	});
	 };

	/**
	 * Function generateChartTickPositions()
	 * Funciton to generate custom chart tick positions
	 */
	 this.generateChartTickPositions = function(vMin,vMax){
	 	var positions = [];
	 	var quarters = [2,5,8,11];
	 	var min_year = Highcharts.dateFormat('%Y', vMin);
	 	var max_year = Highcharts.dateFormat('%Y', vMax);
	 	var max_quarter = Math.floor(Highcharts.dateFormat('%m', vMax)/3);
	 	var min_quarter = Math.floor(Highcharts.dateFormat('%m', vMin)/3);
	 	var period_diff = max_year - min_year;
	 	var new_tick;
	   	 // var utcTime = Date.UTC(datetimeVal[2],datetimeVal[1]-1,datetimeVal[0]);
	   	 if(period_diff <=2){
	   	 	for(var year_count = min_year; year_count<=max_year;year_count++){
	   	 		for(var qu_count=min_quarter;qu_count<4;qu_count++){
	   	 			new_tick = Date.UTC(year_count,quarters[qu_count],1);
	   	 			if(year_count == max_year){
	   	 				if(qu_count<=max_quarter){
	   	 					positions.push(new_tick);
	   	 				}
	   	 			}else{
	   	 				positions.push(new_tick);
	   	 			}
	   	 		}
	   	 		min_quarter = 0;
	   	 	}

	   	 }else if(period_diff<=8){
	   	 	for(var year_count = min_year; year_count<=max_year;year_count++){
	   	 		new_tick = Date.UTC(year_count,1,1);
	   	 		positions.push(new_tick);
	   	 	}
	   	 }else{
	   	 	var interval = (Math.floor(period_diff / 8)) * 31556952000;
	   	 	for(var t_vMin = vMin; t_vMin<=vMax; t_vMin+=interval){
	   	 		new_tick = Date.UTC(Highcharts.dateFormat('%Y', t_vMin),1,1);
	   	 		positions.push(new_tick);
	   	 	}
	   	 }
	   	 return positions;
	   	};

	/**
	 * Function formatData(row data)
	 * Function to Format chart data
	 */
	 this.formatData = function(ap_data,type){
	 	var out_data = {};
	 	$.each(ap_data,function(graph_code,data_rows){
	 		var p_data_rows = new Array();
	 		$.each(data_rows,function(ky,row){
				if(type != "map")
				{
					
					var datetimeVal = row[0].split('-');
					var utcTime = Date.UTC(datetimeVal[2],datetimeVal[1]-1,datetimeVal[0]);
					var float_value = row[1] == null ? null : parseFloat(row[1]);
					p_data_rows[ky] = [utcTime,float_value];
					//p_data_rows[ky] = [parseInt(datetimeVal[2]),float_value];
				}
				else
				{
					
					var datetimeVal = row[0].split('-');
					var utcTime = Date.UTC(datetimeVal[2],datetimeVal[1]-1,datetimeVal[0]);
					var float_value = row[1] == null ? null : parseFloat(row[1]);
					//p_data_rows[ky] = [parseInt(datetimeVal[2]),float_value];
					p_data_rows[ky] = [utcTime,float_value];
				}
	 			
	 		});
			
	 		out_data[graph_code] = p_data_rows;
	 	});
		
	 	return out_data;
	 };


	 (function(){
	 	self.__construct(order,folderContent);
	 })();

	};


// Image preload
$.fn.preload = function() {
	this.each(function(){
		$('<img/>')[0].src = this;
	});
};

$(document).on('click','.nav_editab',function(e){
  $(this).toggleClass('active');
	$(this).parents("div").siblings('.h_graph_tab_area').toggleClass('active');
	$(this).parents("div").siblings('.spc_chainf').toggleClass('active');
});

/* 

$(document).on('click','li.nav_edittabs',function(){

	

	if(!$(this).parents("div").siblings(".h_graph_tab_area").is(":visible")){
		$(this).parents("div").siblings(".h_graph_tab_area").slideToggle();
		var scrolldiv =$(this).parents("div").siblings(".h_graph_tab_area").offset().top;
		$('html, body').animate({
			scrollTop: scrolldiv-18
		}, 1000);
	}else{
		$(this).parents("div").siblings(".h_graph_tab_area").slideToggle();
	}

		
	});

// stick menu on top using offset
function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var div_top = $('.folnav_stipos').offset().top-20;
    if (window_top > div_top) {
        $('.folnav_stick').addClass('pos-fixed');
    } else {
        $('.folnav_stick').removeClass('pos-fixed');
    }
} */

 function serialize_each_object(obj) {
			return Object.keys(obj).map(function(p) {
				return encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]);
			}).join("&");
	}
	
  window.onload = function intializeColorPicker(){
	  
		$( ".basicsss1" ).each(function( index ) {
				 var $div = $(this);
				 var indexChart = $div.attr('data-param1');
				 var indexChart1 = $div.attr('data-param2');
				  clicked = $(this).hasClass('sp-input');
				 
				$('.basicsss1:eq('+index+')').spectrum({color: '#316AB4',showInput: true,className: 'full-spectrum',clickoutFiresChange: false ,
						showInitial: true,showPalette: true,showSelectionPalette: true,maxSelectionSize: 10,preferredFormat: 'hex',
						move: function (color) {
							
						},
						show: function () {
						
						},
						beforeShow: function () {
						
						},
						hide: function () {
						
						},
						change: function(color) {
							  var codeColor = $('.sp-input:eq('+index+')').val();	
							  var numItems = $('.sp-input').length;
							  JMA.JMAChart.Charts[indexChart].chartConfigs.colors[indexChart1] = codeColor;
							  JMA.JMAChart.replaceColorofChartForIndicator(indexChart,codeColor,indexChart1);
						},
						palette: [
							['rgb(0, 0, 0)', 'rgb(67, 67, 67)', 'rgb(102, 102, 102)','rgb(217, 217, 217)','rgb(255, 255, 255)'],
							['rgb(152, 0, 0)', '#eecccc', 'rgb(255, 153, 0)', 'rgb(255, 255, 0)', 'rgb(0, 255, 0)'],
							['rgb(0, 255, 255)', 'rgb(74, 134, 232)', 'rgb(0, 0, 255)', 'rgb(153, 0, 255)', 'rgb(255, 0, 255)'],
							['rgb(230, 184, 175)', 'rgb(244, 204, 204)', 'rgb(252, 229, 205)', 'rgb(255, 242, 204)', 'rgb(217, 234, 211)'],
							['rgb(204, 65, 37)', 'rgb(224, 102, 102)', 'rgb(246, 178, 107)', 'rgb(255, 217, 102)', 'rgb(147, 196, 125)'],
							['rgb(118, 165, 175)', 'rgb(109, 158, 235)', 'rgb(111, 168, 220)', 'rgb(142, 124, 195)', 'rgb(194, 123, 160)'],
							['rgb(166, 28, 0)', 'rgb(204, 0, 0)', 'rgb(230, 145, 56)', 'rgb(241, 194, 50)', 'rgb(106, 168, 79)'],
							['rgb(91, 15, 0)', 'rgb(102, 0, 0)', 'rgb(127, 96, 0)', 'rgb(39, 78, 19)','rgb(255, 0, 0)']
						]
			  });
		});
				
			
	}


	
	return Jma
 });