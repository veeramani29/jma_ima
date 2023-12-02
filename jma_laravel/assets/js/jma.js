/**
*@fileOverview jma.js - JMA main script file
*@author Shijo Thomas (20016)
*/

/**
* Class Jma
**/

$(window).load(function() {
	$('body').tooltip({
		selector: '[data-toggle=tooltip]'
	});
});
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
	this.captcha=true;
	this.linkedInDownload = {};
	//this.Export_url=(window.location.protocol=='http:')?window.location.protocol+'//52.6.41.234:8080':window.location.protocol+'//export.japanmacroadvisors.com';
	this.Export_url=(window.location.protocol=='http:')?window.location.protocol+'//export.japanmacroadvisors.com':window.location.protocol+'//export.japanmacroadvisors.com';
	this.__construct = function(appURL,appController,appAction,appParams,objectParams){
		$(window).load(function() {
			$('#overlay_loading').hide();
			if(self.linkedInDownload.chartIndex != null){
				self.JMAChart.downloadChartData(self.linkedInDownload.chartIndex);
			}
		});
		this.myChart_folders = objectParams.myChart.folderList;
		this.myChart_chartBook_inactive = objectParams.myChart.chartBookListInactive;
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

			$(window).load(function () {
				JMA.JMAChart.Load_YieldDatePicker();
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
			$([ 'assets/images/menu-minus.png', 'assets/images/menu-plus.png' ]).preload();
			/*$("ul.menu > li > a.content_leftside_parent").click(
					function() {
						$(this).parent().toggleClass("minus",
								$(this).siblings("ul").css("display") == "none");
						$(this).siblings("ul").css("padding-top", "2px")
								.slideToggle(200);
						//return false;
					});*/
$('li.list-toggle').find('a').first().trigger('click');

$("div.input-group-addon i.fa-minus").trigger('click');

			// Do login for download chart
			/*$('#pop_login_btn').on('click',function(){
				self.User.submitAjxLogin();
			});*/

			
			


			//>>> Login box
			$('.x').click(function(){
				$('.popup').hide();
				overlay.appendTo(document.body).remove();
				$.createCookie("isLoginBox",0);
				return false;
			});
			var overlay = $('<div id="overlay"></div>');
			overlay.show();
			overlay.appendTo(document.body);
			$('.popup').show();	
			//<<< Login box
			
			$('#Dv_flashMessage').find('.close_btn').on('click',function(){
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



		     $.validator.addMethod("emailunique", function(value, element) {
    var response;
    
    jQuery.ajax({
      type: "POST",
      url: JMA.baseURL+"/user/check_email",
      data: {'user_email':value},
      dataType:"json",
      cache: false,
      async:false,
      success: function (data) {
        response=$.trim(data);

      }
    });

    if(response == 'false')
    {
      return true;
    }
    else
    {
      return false;
    }
  }, "A user already registered with this email id, If you are already a JMA subscriber please <a href='"+JMA.baseURL+"user/login'>login</a>");

			//$('#signup_frm').validate();


			
			 $('#login_frm_ajx').validate();

					$('#pop_login_btn').on('click , ontouchstart',function(){
					if($("#login_frm_ajx").valid()){
					self.User.submitAjxLogin();
					$('p.login_frm_ajx_login_status').show();

					}else{
					$('p.login_frm_ajx_login_status').hide();
					}

					});
			
			
			$('#login_frm,#login_frm_,#login_frm_ajx').validate();
			var roles_form = $('#forgotpasswd_frm');
			var error_roles_form = $('#error-message', roles_form);

			roles_form.validate({errorLabelContainer: error_roles_form});
			$('.cnt223').hide();
			setTimeout( function () {
				$('.cnt223').slideUp( 15000 ).delay( 3000 ).fadeIn( 2000 );}, 3000);



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
			$('body').on('click', '.graph-nav .nav-txt-export, .graph-nav .nav-txt-download,.graph-nav .nav-txt-annotation,.graph-nav .nav-txt-export-share' ,function(e) {

				$('.h_graph_top_area').find('.nav-txt').removeClass('active');
				//$('.h_graph_top_area').find('.sub-nav').removeClass('open');
				$('.h_graph_top_area').find('.sub-nav').hide();


				var that = this;

				var $subnav = $(this).closest('.graph-nav').find( ".sub-nav" ); 

				//setTimeout(function() {
					
					if( !$subnav.hasClass('open') ) {
					
						$(that).removeClass('active');
						$subnav.addClass('open')
						$subnav.show()
					}else {
						$(that).addClass('active');
							$subnav.removeClass('open')
							$subnav.hide()
					}
					
				//}, 300);
				
				//$subnav.toggleClass('open');
				//$subnav.slideToggle();
			});



			


var mqsort = window.matchMedia( "(min-width: 1024px)" );
        if (mqsort.matches) {
			$('body').on('click', '.exhibit' ,function(e) {
				self.SmalltoLarge=$(this).data('uuid');
				$(".foldercontent-sub-menu").hide();
				$('.ftps_holconmin').removeClass('sortable-select');
				$('.exhibit').removeClass('sortable-select');
				$(this).addClass('sortable-select');
				e.stopPropagation()
			});

			$('body').on('click', '.ftps_holconmin' ,function(e) {

			$('.ftps_holconmin').removeClass('sortable-select');
				$('.exhibit').removeClass('sortable-select');
				$(this).addClass('sortable-select');
			
			});

$("body").on('click',  function (e) {

if(!$(e.target).parents().hasClass('ftps_holconmin')){
$(".exhibit").removeClass("sortable-select");
					$(".foldercontent-sub-menu").hide();
					$('.ftps_holconmin').removeClass('sortable-select');
}
});
		}
		/*	$('body').on("click", function(e) {
				
				if ($(e.target).is(".exhibit") === false) {

					$(".exhibit").removeClass("sortable-select");
					$(".foldercontent-sub-menu").hide();
					$('.ftps_holconmin').removeClass('sortable-select');
				}
			});*/



			$('body').on('click', '.graph-nav .nav-txt-save' ,function(e) {

				// Check login
				if(JMA.userDetails.hasOwnProperty('id') && JMA.userDetails.id>0) {
					$('.h_graph_top_area').find('.nav-txt').removeClass('active');
					//$('.h_graph_top_area').find('.sub-nav').removeClass('open');
					$('.h_graph_top_area').find('.sub-nav').hide();


					var that = this;
					var $subnav = $(this).closest('.graph-nav').find( ".sub-nav" ); 

					setTimeout(function() {


						if( !$subnav.hasClass('open') ) {
					
						$(that).removeClass('active');
						$subnav.addClass('open')
						$subnav.show()
					}else {
						$(that).addClass('active');
							$subnav.removeClass('open')
							$subnav.hide()
					}

						
					
						
					}, 300);
					
					//$subnav.toggleClass('open');
					//$subnav.slideToggle();
				}else{
					JMA.User.showLoginBox('mychart',JMA.baseURL + JMA.controller + "/" + (JMA.action == "index" ? '' : JMA.action + "/")+JMA.params);
					var p_chart_idx = this.id;
					var currentUrl = window.location;
					var str = ""+currentUrl+"";
					var res = str.split('/').join('@'); 
					//var avoid = "@japanmacroadvisors@";
					//var test = res.replace(avoid, '');
					//var linkedInUrl = 'user/linkedinProcess/'+test+'code='+cht_codes_str+'datatype='+JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type;
					var linkedInUrl = 'user/linkedinProcess/?'+res+'index='+p_chart_idx;
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
				var currentUrl = window.location;
					var str = ""+currentUrl+"";
					var res = str.split('/').join('@'); 
					var linkedInUrl = 'user/linkedinProcess/?'+res;
					$("a.linkedIn").attr("href", linkedInUrl);
				$(".download-img,.download,.download-logininfo,.mychart").hide();
				$('.premium-img, .premium, .premium-logininfo').show();
				$('#chart_login_perm_type').val(type);
				$('#chart_login_premium_url').val(typeValue);
			}
			if(type=="download"){
				$('.premium').show();
				//$('.premium-img').hide();
					$(".download-img,.download,.download-logininfo,.mychart").hide();
				$('#chart_login_perm_type').val(type);
				$('#chart_login_chart_index').val(typeValue);
			}
			if(type=="mychart"){
					var currentUrl = window.location;
					var str = ""+currentUrl+"";
					var res = str.split('/').join('@'); 
					var linkedInUrl = 'user/linkedinProcess/?'+res;
					$("a.linkedIn").attr("href", linkedInUrl);
				$(".premium, .download, .premium-logininfo").hide();
				$('.premium-img, .download-img, .mychart, .download-logininfo').show();
				$('#chart_login_perm_type').val(type);
				$('#chart_login_premium_url').val(typeValue);
			}
if(type=="premiumm"){
			$('#Dv_modal_loginn').modal('show');
		}else{
			$('#Dv_modal_login').modal('show');
		}

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

			if(type=='premium'){
			$('#Dv_modal_upgrade_premium_content h4.premium').hide();
			}
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
			if(type=='premium'){
				$('#Dv_modal_upgrade_premium_feature h4.premium').hide();
			}
			
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
									'<i style="color: #22558F; font-size: 10px; margin: -10px -1px -6px -2px;" class="fa fa-star fa-fw"></i>&nbsp;<strong>Standard Account</strong>';
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
								$(".popup").hide();
							jq_frm_obj.submit();
						}else if(postParams.chart_login_perm_type == 'premium' || postParams.chart_login_perm_type == 'mychart'){
							
							window.location=postParams.chart_login_premium_url;
						}
					}else{
						if(postParams.login_email!='' && postParams.login_password!='')
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
         			plotBorderWidth: 0,
         			backgroundColor: '#FFF',
         			width: 680,
         			height: 400
         		};
         	}else{
         		var chartoptins={ plotBorderWidth: 0,backgroundColor: '#FFF',};
         	}



         	// This Code By SVG Content
         var chart_svg = chart.getSVG({
         		chart:chartoptins,
         	
         		credits: {
         			enabled: false
         		},

         		tooltip: { enabled: false },
         		scrollbar : {
         			enabled : false
         		},
         		legend: {
			useHTML: true,
			
			width:((chart.legend.legendWidth<400)?chart.legend.legendWidth:chart.legend.maxItemWidth)+10,
           
            itemStyle: {
            
             fontSize: '11px'
            }
        },
		

    yAxis: {
        tickPositions: chart.yAxis[0].tickPositions
    },
         		xAxis: {
         			scrollbar: {
         				enabled: false
         			}
         		}
         	});
       
          var find_image =$(chart_svg).find("image").remove().clone().wrap('<div>').parent().html();
          chart_svg = chart_svg.replace(find_image, '');


          var exp_data = {
          	svg: chart_svg,
          	noDownload:true,
          	type: 'png',
          	width : 1400,
			height : 700,
          
          	async: true,
          	cache:true,
          };

      // Local server
  //  if (window.location.hostname != "localhost"){
       //  exportUrl = JMA.baseURL+'chart/exportBulkChart';
   // }else{
        exportUrl = JMA.Export_url;
   //  }




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
	$('.progress-bar').css('width', '50%').attr('aria-valuenow', 50);
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

if(JMA.myChart.myFolder.currentView=='smallView'){

         		var chartoptins={
         			plotBorderWidth: 0,
         			backgroundColor: '#FFF',
         			width: 680,
         			height: 400
         		};
         	}else{
         		var chartoptins={ plotBorderWidth: 0,backgroundColor: '#FFF',};
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
					xAxis: {
						scrollbar: {
							enabled: false
						}
					},
					legend: {
			useHTML: true,
			
			width:((chart.legend.legendWidth<400)?chart.legend.legendWidth:chart.legend.maxItemWidth)+10,
           
            itemStyle: {
            
             fontSize: '11px'
            }
        },
		

    yAxis: {
        tickPositions: chart.yAxis[0].tickPositions
    },
				});
//
var find_image =$(chart_svg).find("image").remove().clone().wrap('<div>').parent().html();
chart_svg = chart_svg.replace(find_image, '');
var exp_data = {
	svg: chart_svg,
	noDownload:true,
	type: 'png',
	width : 1400,
	height : 700,

	async: true
};

  // Local server
   // if (window.location.hostname != "localhost"){
        // exportUrl = JMA.baseURL+'chart/exportBulkChart';
  //  }else{
        exportUrl = JMA.Export_url;
   //  }

$.ajax({
	type: "POST",
	url: exportUrl,
	data: exp_data,
	cache:false,
	async:true,
	crossDomain:true,
	success: function (data) {

		chartArray[index]=({"chart":data});
		/*if((index*byprogress)<90){
			$('.progress-bar').css('width', (index*byprogress)+'%').attr('aria-valuenow', (index*byprogress));
		}*/

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
	$('.progress-bar').css('width', 75+'%').attr('aria-valuenow', 75); 
	$.ajax({
		type: "POST",
		url: JMA.baseURL+"mycharts/power_point",
		data: {data:chartArray,titleArray:chartTitleArray,sourceArray:chartsourceArray,NotesArray:chartNotesArray,title:$('h1#Dv_folder_content_title').text()},
		dataType: "json",
		beforeSend: function (xhr) {
			$('.progress-bar').css('width', 95+'%').attr('aria-valuenow', 95); 
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



// Class chartCommon
function chartCommon(p_chartIndex, chartDetails){

	this.Conf = {
		chartType : '',
		chartIndex : null,
		view_option : '',
		reverseYAxis:false,
		reversedAxis_:[],
		default_year:null,
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
		isMultiaxis : false,
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
		colors : [ '#DE4622', '#3366CC', '#FF9900', '#910000',
		'#1aadce', '#492970', '#f28f43', '#77a1e5',
		'#c42525', '#a6c96a' ]
	};


	this.chart_object = null;
	this.chartLayoutData = {'chart_details' : {}, 'series_details' : {}, 'mychart_details' : {}};
	this.dominitialize = function(){
		
	};



	
	this.formatData = function(ap_data){

		var out_data = {};
		if(ap_data !==undefined){
		$.each(ap_data,function(graph_code,data_rows){


			var p_data_rows = new Array();
			$.each(data_rows,function(ky,row){

				var dateReg = /^\d{1,2}([./-])\d{1,2}\1\d{4}$/



				if (dateReg.test(row[0])) {

					var datetimeVal = row[0].split('-');
					var utcTime = Date.UTC(datetimeVal[2],datetimeVal[1]-1,datetimeVal[0]);
					var float_value = row[1] == null ? null : parseFloat(row[1]);
					p_data_rows[ky] = [utcTime,float_value];
				}else{

					var float_value = row[1] == null ? null : parseFloat(row[1]);
					p_data_rows[ky] = [($.isNumeric( row[0] ))?parseFloat(row[0]):row[0],float_value];	

				}
				
			});

			//console.log(p_data_rows);
			
			out_data[graph_code] = p_data_rows;
		});
	}
return out_data;
}

	// Set all Chart configurations
	this.setAllConfigurations = function(p_chartIndex,p_configs){

		this.Conf.chartType = p_configs.chart_config.chartType;
		this.Conf.chartIndex = p_chartIndex;
		this.Conf.view_option = p_configs.chart_config.ViewOption;
		this.Conf.reverseYAxis =(typeof(p_configs.chart_config.reverseYAxis) === 'undefined' )? false : JSON.parse(p_configs.chart_config.reverseYAxis);
		this.Conf.reversedAxis_ =(typeof(p_configs.chart_config.reversedAxis_) === 'undefined' )? [] : p_configs.chart_config.reversedAxis_;
		this.Conf.default_year =(typeof(p_configs.chart_config.default_year) === 'undefined' )? null : p_configs.chart_config.default_year;
		this.Conf.isPremiumData = p_configs.isPremiumData;
		this.Conf.chartLayout = p_configs.chart_config.chartLayout;
		this.Conf.isMultiaxis = p_configs.chart_config.isMultiaxis;
		this.Conf.isNavigator = p_configs.chart_config.isNavigator;
		this.Conf.chartExport = p_configs.chart_config.chartExport;
		this.Conf.chart_actual_code = p_configs.chart_actual_code;
		this.Conf.mychartchartColor = p_configs.color_code;
		this.Conf.color_series = p_configs.color_series;
		this.Conf.color_status = (typeof(p_configs.color_status) === 'undefined' )? 'true' : p_configs.color_status;
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

		if(!((this.Conf.chartType).match("^yield_"))){

			var js_dateRange_from = p_configs.navigator_date_from.split('-');

			this.Conf.navigator_date_from = Date.UTC(js_dateRange_from[2],js_dateRange_from[1]-1,js_dateRange_from[0]);
		}else{
			this.Conf.navigator_date_from = (p_configs.navigator_date_from!='')?p_configs.navigator_date_from:null;
		}


		if(!((this.Conf.chartType).match("^yield_"))){
			var js_dateRange_to = p_configs.navigator_date_to.split('-');
			this.Conf.navigator_date_to = Date.UTC(js_dateRange_to[2],js_dateRange_to[1]-1,js_dateRange_to[0]);
		}else{
			this.Conf.navigator_date_to = (p_configs.navigator_date_to!='')?p_configs.navigator_date_to:null;
		}
	
		
		
		this.Conf.sources = p_configs.sources;
		this.Conf.chartData = (this.Conf.chartType=='map')?p_configs.chart_data:this.formatData(p_configs.chart_data);
		
		
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
	this.createChartLayoutData = function(){

		var mychart_folder_list = Object.create(JMA.myChart_folders);
		
		var mychart_chartbook_list = Object.create(JMA.myChart_chartBook_inactive);
		
		
		
		
		
		var folderList = [];
		var chartBookLists = [];
		try{
			if(typeof(JMA.userDetails.user_permissions)=='object'){
				folderList = typeof(mychart_folder_list) == 'object' ? mychart_folder_list.splice(0,JMA.userDetails.user_permissions.mychart.totalFolders) : [];
				chartBookLists = typeof(mychart_chartbook_list) == 'object' ? mychart_chartbook_list.splice(0,JMA.userDetails.user_permissions.mychart.totalFolders) : [];
			}
		}catch (e){
			
		}
		this.chartLayoutData['chart_details'] = {
			chartIndex : this.Conf.chartIndex,
			isRightPannel : (this.Conf.chartLayout == 'narrow') ? false : true,
			graphChartOption : (this.Conf.view_option == 'chart') ? true : false,
			graphTableOption : (this.Conf.view_option == 'table') ? true : false,
		};
		
		//console.log(mychart_chartbook_list);
		if(JMA.controller == "mycharts")
		{
			
			if(JMA.userDetails.isAuthor == "Y")
			{
				this.chartLayoutData['mychart_details'] = {
				'isMyChart' : true,
				'isAuthor' : true,
				'folderList' : folderList,
				'chartBookLists' : chartBookLists
			   };
			}
			else
			{
				this.chartLayoutData['mychart_details'] = {
				'isMyChart' : true,
				'isAuthor' : false,
				'folderList' : folderList,
				'chartBookLists' : chartBookLists
			   };
			}
			
		}
		else
		{
			
			if(JMA.userDetails.isAuthor == "Y")
			{
				this.chartLayoutData['mychart_details'] = {
				'isMyChart' : false,
				'isAuthor' : true,
				'folderList' : folderList,
				'chartBookLists' : chartBookLists
			    };
			}
			else
			{
				this.chartLayoutData['mychart_details'] = {
				'isMyChart' : false,
				'isAuthor' : false,
				'folderList' : folderList,
				'chartBookLists' : chartBookLists
			    };
			}
			
		}
	};
	
	// Create consolidated series layout data
	this.createSeriesLayoutData = function(){

		
		/*var colorScript = [];
		var indexNum = this.Conf.chartIndex;
		 var seriesCode = this.createCurrentSeriesDropdownData();
		$.each(seriesCode,function(idx,code){}); */

				var YearRangeformap = [];
				if(this.Conf.chartType=='map'){
					var getCrurr=this.Conf.current_chart_codes[0];
					var getStr=this.Conf.chart_labels_available[getCrurr];
					var findYr_ = new Date(this.Conf.navigator_date_from);var StartYrr=findYr_.getFullYear();
					
				var findYrr__ = new Date(this.Conf.navigator_date_to);var EndYrr=findYrr__.getFullYear();
				if(this.Conf.chart_data_type=='daily'){
				var Difference_In_Time = findYrr__.getTime() - findYr_.getTime(); 
      			var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 
      				if(Difference_In_Days>0){
					for (var i = 0; i <= Difference_In_Days; i++) {
					var myDate = (findYr_.getTime()+(i*24*60*60*1000));
					var iscurrent_=(Highcharts.dateFormat('%Y/%m/%d', myDate)==this.Conf.default_year)?true:false;
					YearRangeformap.push({'yr':Highcharts.dateFormat('%Y/%m/%d', myDate),'isCurrent':iscurrent_});
					
					}
				    }
					}else{
					if(getStr.match(/10yr Change,/gi)){
					StartYrr=1930;
					}
					for (var y = StartYrr; y <= EndYrr; y++) {
					var iscurrent_=(y==this.Conf.default_year)?true:false;
					YearRangeformap.push({'yr':y,'isCurrent':iscurrent_});
					}	
					}
					
			}
			// this.chartLayoutData['series_details'] = {
		
var md = new MobileDetect(window.navigator.userAgent).mobile();
		var tb = new MobileDetect(window.navigator.userAgent).tablet();
		if(md || tb)
			var desktop=true;
		else
			var desktop=false;
		this.chartLayoutData['series_details'] = {
			chartIndex : this.Conf.chartIndex,
			current_series : this.createCurrentSeriesDropdownData(),
			available_series : this.createAvailableSeriesDropdownData(),
			isMultiAxis : ((this.Conf.chartType).match("multiaxis")) ? true : false ,
			isBarChart : ((this.Conf.chartType).match("bar$")) ? true : false ,
			isReverseY : JSON.parse(this.Conf.reverseYAxis),
			reversedAxisAr:this.Conf.reversedAxis_.map(Number),
			isDesktop : desktop,
			chartType : this.Conf.chartType,
			YearRangeformap:YearRangeformap,
			graphChartOption : (this.Conf.view_option == 'chart') ? true : false,
			graphTableOption : (this.Conf.view_option == 'table') ? true : false,
			chart_data_type : this.Conf.chart_data_type,
			isYieldDailyChart : ((this.Conf.chart_data_type).match('^yield_')) ? true : false ,
			isAddMoreseries : this.Conf.current_chart_codes.length < 3 ? true : false
		}

		

		
	};
	// Create Current series dropdown data
	this.createCurrentSeriesDropdownData = function(){


		var thisChart = this;
		var current_series = [];

		

		$.each(thisChart.Conf.current_chart_codes,function(idx,code){
		
			if(thisChart.Conf.chart_labels_available[code]!=undefined && (thisChart.Conf.chart_labels_available[code]).match("-")){
				var current_label_arr = thisChart.Conf.chart_labels_available[code].split(' - ');
				var current_label_main = current_label_arr[0];
				var current_label_sub = current_label_arr[1];

			}else{
			var current_label_main = '';
			var current_label_sub = '';	
			return current_series;

		}

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
	this.drawChartLayout = function(){
		this.createChartLayoutData();
		var chart_placeholder = "Chart_Dv_placeholder_"+this.Conf.chartIndex;

		var chart_template_object = Handlebars.compile($('#template_graph_full').html());

		var chart_template = chart_template_object(this.chartLayoutData);

		$('#'+chart_placeholder).html(chart_template);
		
		$("#switch_to_tabble_indicator_"+this.Conf.chartIndex).empty();
		var series_template_object = Handlebars.compile($('#template_chart_footer_layout').html());
		var series_template = series_template_object(this.chartLayoutData);
		
		$('#'+chart_placeholder).after(series_template);
		// add more series script
    var md = new MobileDetect(window.navigator.userAgent);
    if (md.mobile() || md.tablet()) {
      $('.addmor-menu').dlmenu();
    } else {
      $('a.btn-admor').unbind('click').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).parent().siblings().removeClass('dropdown-clicked');
        $(this).parent().children('.dropdown-menu').children('.dropdown-clicked').removeClass('dropdown-clicked');
        $(this).parent().toggleClass('dropdown-clicked');
      });
      $(document).on('click', 'body', function(e) {
        if (!$(e.target).is('.dropdown-clicked'))
          $('.dropdown-clicked').removeClass('dropdown-clicked');
      });
    }
	}; 
	
	// Draw series layout
	this.drawSeriesLayout = function(){
		this.createSeriesLayoutData();
		var series_placeholder = "Dv_dataseries_"+this.Conf.chartIndex;
var series_template_object = Handlebars.compile($('#template_graph_section_series').html());

		var series_template = series_template_object(this.chartLayoutData.series_details);

		$('#'+series_placeholder).html(series_template);
		var seriesHeight = $('#Dv_placeholder_graph_series_section_'+this.Conf.chartIndex).height();
			$('#Chart_Dv_placeholder_'+this.Conf.chartIndex).find(".addser-drpbtn").css('top',seriesHeight + 40);
			if(seriesHeight > 150){
				$('#Chart_Dv_placeholder_'+this.Conf.chartIndex).find(".addser-drpbtn").addClass('asdb-upper');
			} else {
				$('#Chart_Dv_placeholder_'+this.Conf.chartIndex).find(".addser-drpbtn").removeClass('asdb-upper');
			}
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

		


		if(!((this.Conf.chartType).match("^yield_"))){
			var js_min_date = new Date(min);
			var js_max_date = new Date(max);
			this.Conf.share_chart.dateRange_from = js_min_date.getDate()+'-'+(js_min_date.getMonth()+1)+'-'+js_min_date.getFullYear();
			this.Conf.share_chart.dateRange_to = js_max_date.getDate()+'-'+(js_max_date.getMonth()+1)+'-'+js_max_date.getFullYear();
		}else{
			var js_min_date = new Date(min);
			var js_max_date = new Date(max);
			this.Conf.share_chart.dateRange_from = (min!=null)?min:'';
			this.Conf.share_chart.dateRange_to = (max!=null)?max:'';
		}
		
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
	   	 	for(var year_count = min_year; year_count<=max_year;year_count++){
	   	 		new_tick = Date.UTC(year_count,1,1);
	   	 		positions.push(new_tick);
	   	 	}
	   	 	/*var interval = (Math.floor(period_diff / 8)) * 31556952000;
	   	 	for(var t_vMin = vMin; t_vMin<=vMax; t_vMin+=interval){
	   	 		new_tick = Date.UTC(Highcharts.dateFormat('%Y', t_vMin),1,1);
	   	 		positions.push(new_tick);
	   	 	}*/
	   	 }
	   	 return positions;
	   	};

	/**
	 * Function - createChartCodeFromConfig
	 * Function to create chart code from configuration items. It accomodates all changes done on chart
	 */
	 this.createChartCodeFromConfig = function(){

	 	
	 	var chartCode = "{graph "+this.Conf.current_chart_codes.toString()+"|"+this.Conf.charts_codes_available.toString()+"|";
	 	


	 	if(!((this.Conf.chartType).match("^yield_"))){

	 		var date_from = new Date(this.Conf.navigator_date_from);
	 		var date_to = new Date(this.Conf.navigator_date_to);

	 		if(this.Conf.chart_data_type != 'anual'){
	 			chartCode+=date_from.getFullYear()+"-"+(date_from.getMonth()+1)+","+date_to.getFullYear()+"-"+(date_to.getMonth()+1);
	 		}else{
	 			chartCode+=date_from.getFullYear()+","+date_to.getFullYear();
	 		}

	 	}else{
	 		var _navigator_date_from = (this.Conf.navigator_date_from!='')?this.Conf.navigator_date_from:null;
	 		var _navigator_date_to = (this.Conf.navigator_date_to!='')?this.Conf.navigator_date_to:null;
	 		chartCode+=_navigator_date_from+","+_navigator_date_to;

	 	}

	 	
	 	var chartConfigurations = "{chartLayout:'"+this.Conf.chartLayout+"',chartType:'"+this.Conf.chartType+"',dataType:'"+this.Conf.chart_data_type+"',isMultiaxis:"+(((this.Conf.chartType).match('multiaxis')) ? true : false)+",isChartTypeSwitchable:'"+this.Conf.isChartTypeSwitchable+"',isNavigator:"+this.Conf.isNavigator+"}";
	 	return chartCode+chartConfigurations+"}";
	 };
	 
	 this.createIndividualColorPicker = function(){
		 
		if(this.Conf.chartColorSatus == 'true' || this.Conf.color_status == 'true')
		{
		$( ".basicsss1" ).each(function( index ) {
			
			 var $div = $(this);
			 var indexChart = $div.attr('data-param1');
			 var indexChart1 = $div.attr('data-param2');
		  
						$('.basicsss1:eq('+index+')').spectrum({color: '#ECC',showInput: true,className: 'full-spectrum',
								showInitial: true,showPalette: true,showSelectionPalette: true,maxSelectionSize: 10,preferredFormat: 'hex',localStorageKey: 'spectrum.demo',
								move: function (color) {
								},
								show: function () {
								},
								beforeShow: function () {
								},
								hide: function () {
								},
								change: function(color) {
									$('.basicsss1:eq('+index+')').each(function(idx) {
										var codeColor = $(this).val();
										//var newSettingColor = this.chartConfigs.colors[indexChart1] = color.toHexString();
										JMA.JMAChart.Charts[indexChart].chartConfigs.colors[indexChart1] = color.toHexString();
									    changeColorofCharts_(indexChart,color.toHexString(),indexChart1);
									});
									
								},
								palette: [
									['rgb(0, 0, 0)', 'rgb(67, 67, 67)', 'rgb(102, 102, 102)','rgb(217, 217, 217)','rgb(255, 255, 255)'],
									['rgb(152, 0, 0)', 'rgb(255, 0, 0)', 'rgb(255, 153, 0)', 'rgb(255, 255, 0)', 'rgb(0, 255, 0)'],
									['rgb(0, 255, 255)', 'rgb(74, 134, 232)', 'rgb(0, 0, 255)', 'rgb(153, 0, 255)', 'rgb(255, 0, 255)'],
									['rgb(230, 184, 175)', 'rgb(244, 204, 204)', 'rgb(252, 229, 205)', 'rgb(255, 242, 204)', 'rgb(217, 234, 211)'],[ 
									'rgb(204, 65, 37)', 'rgb(224, 102, 102)', 'rgb(246, 178, 107)', 'rgb(255, 217, 102)', 'rgb(147, 196, 125)'],[ 
									'rgb(118, 165, 175)', 'rgb(109, 158, 235)', 'rgb(111, 168, 220)', 'rgb(142, 124, 195)', 'rgb(194, 123, 160)'],[
									'rgb(166, 28, 0)', 'rgb(204, 0, 0)', 'rgb(230, 145, 56)', 'rgb(241, 194, 50)', 'rgb(106, 168, 79)'],[
									'rgb(91, 15, 0)', 'rgb(102, 0, 0)', 'rgb(127, 96, 0)', 'rgb(39, 78, 19)']
								]
							});
				    });
		     }
	 };
	 

	 
		
	 
	 
	}

function creativeTableOnIndicatorPage(p_chartIndex,chartDetails)
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
				
				//chartDetails.Conf.view_option='table';
				//By Veera SVG Table
				
				if(view == "data")
				{
					$("#multiaxis_checkbox__"+chartDetails.Conf.chartIndex).removeAttr("checked");
					$("#barchart_checkbox__"+chartDetails.Conf.chartIndex).removeAttr("checked");
					$("#reverse_checkbox__"+chartDetails.Conf.chartIndex).removeAttr("checked");
					$.each($("input[name='reverse_checkbox']"), function(){            
				$(this).removeAttr("checked");
				});
					chartDetails.Conf.view_option = 'table';
					$('#Chart_Dv_placeholder_'+chartDetails.Conf.chartIndex+' ul.list_graphhead').find('li:first,li:nth-child(2)').hide();
					$('[data-toggle="tooltip"]').tooltip();
					$('#Chart_Dv_placeholder_'+chartDetails.Conf.chartIndex+' ul.list_graphhead').find('li:nth-child(3) div i').attr('data-original-title','Export Table');
					
					$(this).addClass('selected');
					$('#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex).show();
						enableSwitchingChartToTable_by_SVG(p_chartIndex,chartDetails);
						//DrawHTMLTable(p_chartIndex,chartDetails);
						$('.h_graph_content_area_'+chartDetails.Conf.chartIndex).hide();
					$exhibit.find('.ecs_table').prop("disabled", true);
					
				}
		    	else {
				
					chartDetails.Conf.view_option = 'chart';
					
					if((chartDetails.Conf.chartType).match('bar$'))
					{
						$("#barchart_checkbox__"+chartDetails.Conf.chartIndex).attr("checked","checked");
					}

					if((chartDetails.Conf.chartType).match('multiaxis'))
					{
						$("#multiaxis_checkbox__"+chartDetails.Conf.chartIndex).attr("checked","checked");
					}

					if(chartDetails.Conf.reverseYAxis){
						$("#reverse_checkbox__"+chartDetails.Conf.chartIndex).attr("checked","checked");
						$.each($("input[name='reverse_checkbox']"), function(){            
							if($.inArray(parseInt($(this).val()),chartDetails.Conf.reversedAxis_)!=-1){
								$(this).attr("checked","checked");
							}
						});
						
					}
					
				$('#Chart_Dv_placeholder_'+chartDetails.Conf.chartIndex+' ul.list_graphhead').find('li:first,li:nth-child(2)').show();
				$('[data-toggle="tooltip"]').tooltip();
					$('#Chart_Dv_placeholder_'+chartDetails.Conf.chartIndex+' ul.list_graphhead').find('li:nth-child(3) div i').attr('data-original-title','Export  Chart');
				    $(this).addClass('selected');
					$('.h_graph_content_area_'+chartDetails.Conf.chartIndex).show();
					$('#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex).empty();
					$('#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex).removeAttr('style');
					$('#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex).hide();
					
					$exhibit.find('.ecs_table').prop("disabled", false);
				}		
		});
		
	    
		
		if($('.h_graph_content_area_'+chartDetails.Conf.chartIndex).css('display') == 'none')
		{ 
	           
	           enableSwitchingChartToTable_by_SVG(p_chartIndex,chartDetails);
	           //DrawHTMLTable(p_chartIndex,chartDetails);	
				$('.h_graph_content_area_'+chartDetails.Conf.chartIndex).hide();
				
                 
					
					
		}

	};

	
	this.enableSwitchingChartToTableOnDefault = function()
	{
			   if(chartDetails.Conf.view_option == 'table'){
			   
					enableSwitchingChartToTable_by_SVG(p_chartIndex,chartDetails);
					//DrawHTMLTable(p_chartIndex,chartDetails); Table_Dv_placeholder_0
					$('.h_graph_content_area_'+chartDetails.Conf.chartIndex).hide();

				}
				
	};

	//By Veera 



	DrawHTMLTable = function(p_chartIndex,chartDetails)
	{

		var dataTable_container = '#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex;
			var small_div='';
			var dynamictd=82;
			if(chartDetails.Conf.chartData !=null) {
				
				var myObject = chartDetails.Conf.chartData;
				var count = Object.keys(myObject).length;
				
				if((chartDetails.Conf.chart_data_type).match('^yield')){
	 				var first_th_title = 'Maturity';
	 			}else{
	 				var first_th_title = 'Date';
	 			}
				var out = '<table cellspacing="0" cellpadding="0" class="mychart_table fixed_headers table table-striped"><thead><tr><th>'+first_th_title+'</th>';
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
							}else if((chartDetails.Conf.chart_data_type).match('^yield')){
	 							var dte = dataset[0];
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

		


			$(dataTable_container).html(out);
			$(dataTable_container).find('tbody').animate({
				scrollTop:999999
			}, 50);

	};


	enableSwitchingChartToTable_by_SVG = function(p_chartIndex,chartDetails)
	{



		if(chartDetails.Conf.chartData !=null) 
		{				var dynamictd=82;
						var dataTable_container = '#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex;
						$('#Table_Dv_placeholder_'+chartDetails.Conf.chartIndex).css({'height':'400px'});
						var myObject = chartDetails.Conf.chartData;
						var count = Object.keys(myObject).length;
                        
						var data_formated = [];
						var column_width = dynamictd/count;

						 var tableHead = [];var jsonObj = [];var findChartType = [];
					$.each(chartDetails.Conf.chartData,function(order,series_){
					var last=series_.length-1;
					var lastBfr=series_.length-2;
					var diffTime = Math.abs(parseInt(series_[last][0]) - parseInt(series_[lastBfr][0]));
					var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

					if(diffDays>=90 && diffDays<=92){
						var r=(findChartType['quaterly']==undefined)?0:findChartType['quaterly'];
						 findChartType['quaterly']=r+1;
					}else if(diffDays>=28 && diffDays<=32){
						var r=(findChartType['monthly']==undefined)?0:findChartType['monthly'];
						 findChartType['monthly']=r+1;
					}else if(diffDays>=360 && diffDays<=365){
						var r=(findChartType['anual']==undefined)?0:findChartType['anual'];
						 findChartType['anual']=r+1;
					}else if(diffDays==1){
						var r=(findChartType['daily']==undefined)?0:findChartType['daily'];
						 findChartType['daily']=r+1;
					}else{

						var r=(findChartType[chartDetails.Conf.chart_data_type]==undefined)?0:findChartType[chartDetails.Conf.chart_data_type];
						 findChartType[chartDetails.Conf.chart_data_type]=r+1;
					}
					
				});
				console.log(findChartType);
				$.each(chartDetails.Conf.chartData,function(order,series){
							tableHead.push(chartDetails.Conf.chart_labels_available[order])
							if(chartDetails.Conf.current_chart_codes.length>1 && !(chartDetails.Conf.chart_data_type).match('^yield')){ //console.log(series);
							var StartYr=series[0][0];var findSYr = new Date(StartYr);StartYr=findSYr.getFullYear();
							var EndYr=series[series.length-1][0]; var findEYr = new Date(EndYr);EndYr=findEYr.getFullYear();
							var quat='%b ';
								if(findChartType['quaterly']!=undefined && chartDetails.Conf.current_chart_codes.length==findChartType['quaterly']){
								var Month_=4;
								var Month_Q=3;
							}
							if(findChartType['anual']!=undefined && chartDetails.Conf.current_chart_codes.length==findChartType['anual']){
								var Month_=1;
								var Month_Q=3;
								var quat='';
							}
							if(findChartType['quaterly']!=undefined && findChartType['quaterly']>0){
								var Month_=4;
								var Month_Q=3;
							}
							if(findChartType['monthly']!=undefined && findChartType['monthly']>0){
							var Month_=12;
							var Month_Q=1;
							}if(findChartType['daily']!=undefined && findChartType['daily']>0){
							var Month_=12;
							var Month_Q=1;
							}
								var tt=0;
								for (var Yr = StartYr; Yr <= EndYr; Yr++) { var t=tt;
									if(Highcharts.dateFormat('%Y', parseInt(findEYr.getTime()))==Yr){
										if(Month_==4){
											Month_=Math.ceil(Highcharts.dateFormat('%m', parseInt(findEYr.getTime()))/3);
										}else if(Month_==1){
											Month_=Math.ceil(Highcharts.dateFormat('%m', parseInt(findEYr.getTime()))/12);
										}else{
											Month_=Highcharts.dateFormat('%m', parseInt(findEYr.getTime()));
										}//console.log(findEYr.getTime());

									}
								for (var Mo = 1; Mo <= Month_; Mo++) {
									var utcTime = Date.UTC(Yr,(Month_Q*Mo)-1,1);
									if(Array.isArray(data_formated[t]) == true){
											var current_=null;
								
									 for (var i = 0; i < series.length; i++) {
									 if (series[i][0]==utcTime) {
										current_=series[i][1];
									}
									 }	
                                 data_formated[t].push(current_);
									
								}else{
									
								var current_=null;
								var item = {};
							if(chartDetails.Conf.chart_data_type == 'quaterly' || (findChartType['quaterly']!=undefined && findChartType['quaterly']>0)){
								        if (Highcharts.dateFormat('%b', utcTime) == 'Mar') {
											var quat = "Q1 ";
										}else if (Highcharts.dateFormat('%b', utcTime) == 'Jun') {
											var quat = "Q2 ";
										}else if (Highcharts.dateFormat('%b', utcTime) == 'Sep') {
											var quat = "Q3 ";
										}else if (Highcharts.dateFormat('%b', utcTime) == 'Dec') {
											var quat = "Q4 ";
										}else{
												var quat='%b ';
										}
										
									}
									//console.log(quat);
									var dte = Highcharts.dateFormat(quat+'%Y',utcTime);
									
							 for (var i = 0; i < series.length; i++) {
									 if (series[i][0]==utcTime) {
										current_=series[i][1];
									  }
							 }
							
									data_formated[t] = [dte,current_];
									item ["title"] = dte;
                                    item ["val"] = current_;
									item ["valses"] = data_formated[t];
									jsonObj.push(item);
								}

								t++;tt=t;
								}
								}
								}else{ 
								$.each(series,function(i_order,dataset){
								var datasets = (chartDetails.Conf.chartType=='map')?dataset['hc-key']:dataset[0];
								var INDEX=(chartDetails.Conf.chartType=='map')?'value':1;
								var item = {};
								if(Array.isArray(data_formated[i_order]) == true){
                                 data_formated[i_order].push(dataset[INDEX]);
									
								}
								else
								{
									if(chartDetails.Conf.chart_data_type == 'monthly'){
										var dte = Highcharts.dateFormat('%b %Y',datasets);
									}else if(chartDetails.Conf.chart_data_type == 'quaterly'){
										 if (Highcharts.dateFormat('%b', datasets) == 'Mar') {
											var quat = "Q1 ";
										}else if (Highcharts.dateFormat('%b', datasets) == 'Jun') {
											var quat = "Q2 ";
										}else if (Highcharts.dateFormat('%b', datasets) == 'Sep') {
											var quat = "Q3 ";
										}else if (Highcharts.dateFormat('%b', datasets) == 'Dec') {
											var quat = "Q4 ";
										}else{
												var quat='%b ';
										}
									var dte = Highcharts.dateFormat(quat+'%Y',datasets);
									}else if(chartDetails.Conf.chart_data_type == 'anual'){
										if(chartDetails.Conf.chartType=='map')
										var dte = datasets;
									    else
									    var dte = Highcharts.dateFormat('%Y',datasets);
									}else if(chartDetails.Conf.chart_data_type == 'daily'){
										if(chartDetails.Conf.chartType=='map')
										var dte = datasets;
									    else
									    var dte = Highcharts.dateFormat('%Y',datasets);
									}else if((chartDetails.Conf.chart_data_type).match('^yield')){
	 									var dte = datasets;
	 								}
										data_formated[i_order] = [dte,dataset[INDEX]];
									
									item ["title"] = dte;
                                    item ["val"] = dataset[INDEX];
									item ["valses"] = data_formated[i_order];
									jsonObj.push(item);
									
								}
							});
							}
							
							});


						var tableHeadCount = tableHead.length;
							var tableTspanCount = data_formated[0].length;
							var countOFTotal = data_formated.length;
						  	//var colorScale = d3.scale.category20();
						   $(dataTable_container).empty();
				var scrollSVG = d3.select(dataTable_container).append("svg")
								.attr("class", "scroll-svg").attr("version", "1.1").attr("xmlns","http://www.w3.org/2000/svg").attr("width","600").attr("style","font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Arial, Helvetica, sans-serif;font-size:12px;");

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
var style='g.svg-header g.tick text tspan {font-size:7px;word-break: break-word;width:200px; word-spacing: 1px;}g.chartGroup g.row text tspan {font-size:10px;}';
				scrollSVG.append("style").text(style);
}
				
			
							
							 var chartGroup = scrollSVG.append("g").attr("class", "chartGroup")
								


								
						
								var rowEnter = function(rowSelection) {
										rowSelection.append("rect")
										.attr("rx", 0)
										.attr("ry", 0)
										.attr("width", "100%")
										.attr("height", "30")
										.attr("fill-opacity", 0.15)
										.attr("stroke", "#ddd")
										.attr("stroke-width", "0px");
										rowSelection.append("line")
										.attr("stroke", "#ddd").attr("stroke-width", 0.5).attr("x2", 1000); 	
										rowSelection.append("text")
										.attr("transform", "translate(10,15)");
								};
								var rowUpdate = function(rowSelection) {

									/*rowSelection.select("rect")
										.attr("fill", function(d) {
											return colorScale(d.title);
										});*/

									
										var cWidth;
										for(i=0;i<tableTspanCount; i++)
										{

										
											
											if(i==0)
											{
												cWidth = i
											}
											else
											{
												countDid = $(".scroll-svg").width()/tableTspanCount
												cWidth = i*countDid
											}
											


											
											rowSelection.select("text").append("tspan",":first-child")
											.attr("x", cWidth)
												.text(function (d) {

													
													if(d.valses[i]==null || d.valses[i]===undefined)
													{
														var renVals = "-";
													}else{
														var renVals = d.valses[i];
													}
													
												
												return renVals;
											});
										}
									
								};


								var headerSvg = scrollSVG.insert("g").attr("class", "svg-header").attr("id","svg-header-"+chartDetails.Conf.chartIndex).attr("transform","translate(0 0)");
				headerSvg.append("rect").attr("rx", 0).attr("ry", 0).attr("height", "30").attr("width", "100%").attr("fill-opacity", 1).attr("style","fill:#ddd;");
							for(i=0;i<=tableHeadCount; i++)
							{
								var thvalues;
								var tWidth;
								 if(i==0)
								 {
									 
									tWidth = 0
									if((chartDetails.Conf.chart_data_type).match('^yield')){
	 				var thvalues = 'Maturity';
	 			}else{
	 				var thvalues = 'Date';
	 			}
								
									if(chartDetails.Conf.chartType=='map')
										var thvalues = 'States';

								 }
								 else
								 {
									countDidt = $(".scroll-svg").width()/tableTspanCount
									tWidth = i*countDidt 
									if(chartDetails.Conf.chartType=='map')
									thvalues = tableHead[i-1]+' ('+chartDetails.Conf.default_year+')';
									else
									thvalues = tableHead[i-1]
								 }
									var temp= headerSvg.insert("g")
									.attr("class", 'tick').attr("transform", "translate("+(tWidth+30)+",0)");
									 temp.insert("text").attr("style", "text-anchor: middle;color:#274b6d;font-size:12px;font-family:'Oswald';cursor:pointer;fill:#274b6d;").attr("text-anchor", "middle").attr("x", tWidth)
									.text(thvalues).call(svg_word_wrap, 150);

								
									

							}	
								
								headerSvg.insert("image")
									.attr("x", 500).attr("y", 370).attr("width", 100).attr("height", 20).attr("xlink:href", 'https://content.japanmacroadvisors.com/images/favicon.png');
								var rowExit = function(rowSelection) {
								};
								
								var virtualScroller = d3.VirtualScroller()
									.rowHeight(28)
									.enter(rowEnter)
									.update(rowUpdate)
									.exit(rowExit)
									.svg(scrollSVG)
									.totalRows(countOFTotal)
									.viewport(d3.select(dataTable_container));
								virtualScroller.data(jsonObj, function(d) { return d.title; }); 
								chartGroup.call(virtualScroller);

								$(dataTable_container).animate({
						scrollTop:999999
					}, 50);


						 

$(dataTable_container).on("scroll", function(event){



 var fixed = document.getElementById($(this).find('.svg-header').attr('id'));
 if(fixed!=null){
var b = fixed.querySelector("rect"); 
 var ua = window.navigator.userAgent;

if(Math.ceil(fixed.getBoundingClientRect().height)>30){
	
	b.setAttribute("height", Math.ceil(b.getBoundingClientRect().height));
	 if(ua.indexOf('Edge/')>0 || ua.indexOf('MSIE')>0 || ua.indexOf('Trident')>0){
	 b.setAttribute("height", 35);
	 }
	}else{
	b.setAttribute("height", 25);
}

var tfm = fixed.transform.baseVal.getItem(0);
 tfm.setTranslate(0, event.target.scrollTop);
}
	
});


		}

	}
	
	
}


//Class YieldChart not stockchart
function YieldChart(p_chartIndex, chartDetails) {
	var isBig  = window.matchMedia( "(min-width: 1025px)" );

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




	this.createMultiYaxisConfigurations = function(chart_data_series){
		var ret_data = {
			yAxis : new Array(),
			dataSeries : new Array()
		};
		$.each(chart_data_series,function(ky,chData){
			
			
			if(chartCommon.Conf.chartColor.hasOwnProperty(ky))
			{
				chartCommon.chartConfigs.colors[ky] = chartCommon.Conf.chartColor[ky] ;
			}
			else if(chartCommon.Conf.mychartchartColor !== undefined)
			{
				if(chartCommon.Conf.mychartchartColor[ky])
				{
					chartCommon.chartConfigs.colors[ky] = chartCommon.Conf.mychartchartColor[ky];
				}
			}
				
			
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
			    			color: chartCommon.chartConfigs.colors[ky]
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



	this.createHighChart = function(chart_data_series) {
 if((chartCommon.Conf.chartType).match('multiaxis')){
		
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
		}


		var graph_container = 'Jma_chart_container_' + this.Conf.chartIndex;
		var graph_containerID = '#'+graph_container;
		var position_legend_x = 17;
		var position_legend_width = 527;
		var position_legend_x_export = 17;
		var position_legend_width_export = 547;

		var xAxis = {
			type: 'category',
				gridLineWidth : 0, // New value
				events : {
					setExtremes : function(e) {
						chartCommon.Conf.navigator_date_from = e.min;
						chartCommon.Conf.navigator_date_to = e.max;
						chartCommon.updateChartShareURL(e.min,e.max);
						chartCommon.updateCommonShareURL();

					}
				},

				title: {
					text: "Maturity (Years)"
				},
				scrollbar: {
					enabled: true,

					margin: 30

				},
				tickInterval: 1, 
			//tickPixelInterval: 1


			
		};

		if(isBig.matches)
		{
			var tooltipstyle={};
		}else{
			var tooltipstyle={ width: '100px'};
		}

		var toolTip = { //padding:5,    
				//backgroundColor: null,
				// borderWidth: 0,
    //     shadow: false,
    useHTML: true,
    crosshairs: {
            width: 0.5,
            color: 'gray',
            zIndex: 5
           
        },
				positioner: function () {
            return { x: 37, y: 285 };
        },followTouchMove: false,shared: true,split:false,style: tooltipstyle, };


 var yAxis = {
			gridLineWidth : 1.5, // The default value, no need to change it
			gridLineDashStyle: 'Dot',
			gridLineColor: '#999999',
			//gridZIndex: -1,
			// offset : 10,
			opposite : false,
			labels : {
				align : 'right',
			// y: 3
		},
		title: {
			text: "Yield (%)"
		},
		plotLines : [ {
			value : 0,
			color : 'black',
			dashStyle : 'shortdash',
			width : 1.5
		} ]
	};

	var aliMent = '';
	var fontSz = '';
	var wordwapF = '';

	if(isBig.matches)
	{
		
		var aliMent = 'center';
		var fontSz = '11px';
		var wordwapF = function() {
			var legendName = this.name;
                 
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
               var chart_type=null;var plotOptions={			line: {
               	marker: {
               		enabled: false
               	}
               },
				 series: {
            connectNulls: true ,
                dataLabels: {
                    allowOverlap: true,
                   
                  
                }
            },};
               if((chartCommon.Conf.chartType).match('bar$')){
               	var chart_type='column';

               	var plotOptions={

               		column: {
               			pointPadding: 0.5,
               			borderWidth: 3
               		},
				 series: {
            connectNulls: true ,
                dataLabels: {
                    allowOverlap: true,
                   
                  
                }
            },
               	}


               }
              var copy = Object.assign({}, Highcharts);
			if(((chartCommon.Conf.current_chart_codes[0]).toString()).startsWith("6") || ((chartCommon.Conf.current_chart_codes[0]).toString()).startsWith("304")){
			copy.Axis.prototype.log2lin = function (num) {
			return Math.log(num) / Math.LN2;
			};

			copy.Axis.prototype.lin2log = function (num) {
			return Math.pow(2, num);
			};
			}
               var cht = new copy.Chart({
               	chart : {
               		type: chart_type,
				  //zoomType: 'xy',
				  renderTo : graph_container,
				  backgroundColor : '#f5f5f5',
				  plotBorderColor : '#000000',
				  plotBackgroundColor : '#FFFFFF',
				  plotBorderWidth : 0.5,
				  spacingBottom : 35,
				  alignTicks: true,
				  events:{
					click: function(e) {
						if(!$('#'+graph_container).find('ul.list_annotations li').hasClass('select')){
						$('#'+graph_container).find('ul.list_annotations').addClass('open')
						$('#'+graph_container).find('ul.list_annotations').show();
							e.stopPropagation()

						}
					}
				}
				},
				title:{
				text: null
				},
				exporting : {
					enabled : false,
					chartOptions:{
						chart : {
						//	spacingBottom : 85,
						events : {
							load : function(){
								//this.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-export.png', 385, 315, 195,16).add();
								//this.renderer.text("Source : "+chartCommon.Conf.sources, 10, 325, 159, 33).css({size:'3px'}).add();
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
				href : 'http://japanmacroadvisors.com',
				text : 'japanmacroadvisors.com'
			},
			

			responsive: {
				rules: [{
					condition: {
						maxWidth: 500
					},
					chartOptions: {
						legend: {
							enabled: true,
							align: 'center',
							backgroundColor: '#dddddd',
							verticalAlign: 'top',
							layout: 'horizontal',
							labelFormatter: function() {
								var legendName = this.name;
							 legendName = (legendName.match('^Series '))?'No data to display':legendName;
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
						legend: {
							labelFormatter: function() {
								var legendName = this.name;

								var match = (legendName.match('^Series '))?'No data to display':legendName;
								return match.toString().replace(/\,/g,"<br/>");
							},
							enabled: true,
							align: 'center',
							backgroundColor: '#dddddd',
							verticalAlign: 'top',
							layout: 'horizontal',
							itemStyle: {
								color: '#274b6d'
							}
						},
					}
				},{
					condition: {
						maxWidth: 439
					},
					chartOptions: {
						legend: {
							labelFormatter: function() {
								var legendName = this.name;

								var match = (legendName.match('^Series '))?'No data to display':legendName;
								return match.toString().replace(/\,/g,"<br/>");
							},
							
							enabled : true,
							align: 'center',
							backgroundColor : '#dddddd',
							verticalAlign: 'top',
							layout: 'horizontal',
							itemStyle : {
								width: 190,
								fontSize : 11
							}
						},
					}
				} ]
			},
			plotOptions:plotOptions,
			series : ((chartCommon.Conf.chartType).match('multiaxis')) ? formetted_data_series.dataSeries:chart_data_series,
			yAxis : ((chartCommon.Conf.chartType).match('multiaxis')) ? formetted_data_series.yAxis:yAxis,
			xAxis : xAxis,
			tooltip: toolTip,

			
		}, function(p_chrtObj) {

			p_chrtObj.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', (chartCommon.Conf.chartLayout=='narrow' && JMA.controller!='home')?700:365, 380, 218,17).add();
			p_chrtObj.renderer.text("Source : "+chartCommon.Conf.sources, 10, 388, 159, 33).add();
			 //p_chrtObj.xAxis[0].setExtremes(null, null);
			 if(chartCommon.Conf.navigator_date_from!=''){


			 	p_chrtObj.xAxis[0].setExtremes(
			 		chartCommon.Conf.navigator_date_from,
			 		chartCommon.Conf.navigator_date_to);
			 }

			 if(chartCommon.Conf.reversedAxis_.length>0){
						chartCommon.Conf.reversedAxis_=chartCommon.Conf.reversedAxis_.map(Number);
					}
			 	//console.log(p_chrtObj);
			 for(var yX=0; yX<p_chrtObj.yAxis.length; yX++) {
					if($.inArray(yX,chartCommon.Conf.reversedAxis_) != -1 && chartCommon.Conf.reverseYAxis==true){
					p_chrtObj.yAxis[yX].update({reversed: chartCommon.Conf.reverseYAxis });
					}
				    }

				    ManualChartUpdate(p_chrtObj,chartCommon.Conf);
			});

return cht;




};
this.drawJmaChart = function(){

	var chart_data_series = this.createChartDataSeries();

	var tableClass =  new creativeTableOnIndicatorPage(p_chartIndex,chartCommon);
	tableClass.enableSwitchingChartToTable();

	this.chart_object = this.createHighChart(chart_data_series);
	tableClass.enableSwitchingChartToTableOnDefault();
};

this.drawChart = function() {

	this.drawChartLayout();

	if(this.Conf.chartLayout == 'normal') {
		this.drawSeriesLayout();
	}
	this.drawJmaChart();

	if((this.Conf.chart_data_type).match('^yield_')){
			JMA.JMAChart.Load_YieldDatePicker();
		}

	
	this.initializeGraphDomelements();
	var md = new MobileDetect(window.navigator.userAgent);
  if (md.mobile() || md.tablet()) {
    $('.addmor-menu').dlmenu();
  } else {
    $('a.btn-admor').unbind('click').on('click', function(event) {
      event.preventDefault();
      event.stopPropagation();
      $(this).parent().siblings().removeClass('dropdown-clicked');
      $(this).parent().children('.dropdown-menu').children('.dropdown-clicked').removeClass('dropdown-clicked');
      $(this).parent().toggleClass('dropdown-clicked');
    });
    $(document).on('click', 'body', function(e) {
      if (!$(e.target).is('.dropdown-clicked'))
        $('.dropdown-clicked').removeClass('dropdown-clicked');
    });
  }


};

this.setConfigurations();
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

	this.createHighChart = function(chart_data_series) {



		var isBig  = window.matchMedia( "(min-width: 1025px)" );

		
		if(isBig.matches)
		{
			var tooltipstyle={};
		}else{
			var tooltipstyle={ width: '100px'};
		}


		var graph_container = 'Jma_chart_container_' + this.Conf.chartIndex;
		var graph_containerID = '#'+graph_container;
		var position_legend_x = 17;
		var position_legend_width = 527;
		var position_legend_x_export = 17;
		var position_legend_width_export = 547;
			var quaterly_Extra = {};
		if (this.Conf.chart_data_type == 'quaterly') {

			var quaterly_Extra = {
				
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
	    }


	    
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
				
	        };
	        $.extend( true, xAxis, quaterly_Extra );
			//Object.assign(xAxis, quaterly_Extra)

			//console.log(Object.assign(xAxis, quaterly_Extra));

	        var toolTip = {
	        	formatter: function () {
	        
	        		var s = '<b>';
	        		var ss = '';
	        			var _Inside_data_Type;
	        		$.each(this.points, function (i, point) {
	        			
						var eachSeriesData=point.series.userOptions.data;
						var graph_code__=chartCommon.Conf.current_chart_codes[point.series.colorIndex];
						var res = graph_code__.match(/163/gi);
						if(res!=null){
						if(eachSeriesData.length==(point.point.index+1)){
							var eachSeriesDataLast=point.point.index-1;
						}else{
							var eachSeriesDataLast=point.point.index+1;
						}
						var eachSeriesDataQuat=point.point.index;
						}else{
						var eachSeriesDataLast=eachSeriesData.length-1;
						var eachSeriesDataQuat=eachSeriesData.length-2;
						}
//var Second_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataLast][0]));
//var First_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffTime = Math.abs(parseInt(eachSeriesData[eachSeriesDataLast][0]) - parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
//console.log(diffDays);
					if(diffDays>=90 && diffDays<=92){
						 _Inside_data_Type='quaterly';
					}else if(diffDays>=28 && diffDays<=32){
					 _Inside_data_Type='monthly';
					}else if(diffDays>=360 && diffDays<=365){
					 _Inside_data_Type='anual';
					}else if(diffDays==1){
					 _Inside_data_Type='daily';
					}else{
						_Inside_data_Type=chartCommon.Conf.chart_data_type;
					}
					var s = '<b>';
                   if (_Inside_data_Type == 'quaterly') {
                   
					if (Highcharts.dateFormat('%b', point.x) == 'Mar') {
						s = s + "Q1"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Jun') {
						s = s + "Q2"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Sep') {
						s = s + "Q3"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Dec') {
						s = s + "Q4"
					}else{
						s = s +Highcharts.dateFormat('%b', point.x);
					}
					}else if(_Inside_data_Type == 'monthly'){
						s = s +Highcharts.dateFormat('%b', point.x);
	        		}else if(_Inside_data_Type == 'daily'){
						s = s +Highcharts.dateFormat('%a %b %e,', point.x);
	        		}
	        		// console.log(_Inside_data_Type);
					s = s + " " + Highcharts.dateFormat('%Y', point.x) + '</b>';
					var symbol = '<span style="color:' + point.series.color + '">●</span>';
						ss += symbol+ point.series.name +' ('+s+'): '+point.y+'<br/>';
					});
					ss=ss.slice(0,-5);
					return ss;
	        	},
	        
	        	followTouchMove: false,
	        	useHTML: true,
	        	//backgroundColor: null,
	        	//padding:10,

	        	split: false,
	            shared: true,
	            positioner: function () {
	        		return { x: 37, y: 285 };
	        	}
	        };
	        	
	        if (this.Conf.chart_data_type == 'quaterly') {
					Object.assign(toolTip, {//borderWidth: 0,//shadow: false
					});
				}else{
					Object.assign(toolTip, {style: {}});
				}
	     
              var yAxis = {
			gridLineWidth : 1.5, // The default value, no need to change it
			gridLineDashStyle: 'Dot',
			gridLineColor: '#999999',
			//gridZIndex: -10,
			 offset : 30,
			opposite : false,
			labels : {
				align : 'left',
			 x: 0
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


		
		
		



                        var copy = Object.assign({}, Highcharts);
                        if(chartCommon.Conf.chartIndex==1 && (((chartCommon.Conf.current_chart_codes[0]).toString()).startsWith("307") || ((chartCommon.Conf.current_chart_codes[0]).toString()).startsWith("16"))){
                        copy.Axis.prototype.log2lin = function (num) {
                        return Math.log(num) / Math.LN2;
                        };

                        copy.Axis.prototype.lin2log = function (num) {
                        return Math.pow(2, num);
                        };
                        }

		var cht = new copy.StockChart({
			chart : {
				renderTo : graph_container,
				//backgroundColor : '#FBFBFB',
				backgroundColor : '#f5f5f5',
				plotBorderColor : '#000000',
				plotBackgroundColor : '#FFFFFF',
				plotBorderWidth : 0.5,
				spacingBottom : 35,
				alignTicks: true,
				events:{
					click: function(e) {
						if(!$('#'+graph_container).find('ul.list_annotations li').hasClass('select')){
						$('#'+graph_container).find('ul.list_annotations').addClass('open')
						$('#'+graph_container).find('ul.list_annotations').show();
							e.stopPropagation()

						}
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
								//this.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', 385, 300, 195,16).add();
								//this.renderer.text("Source : "+chartCommon.Conf.sources, 10, 310, 159, 33).css({size:'3px'}).add();
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
				href : 'http://japanmacroadvisors.com',
				text : 'japanmacroadvisors.com'
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
                   
                  
                }
            },
			},

			responsive: {
				rules: [{
					condition: {
						maxWidth: 500
					},
					chartOptions: {
						legend: {
							enabled: true,
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
						legend: {
							enabled: true,
							align: 'center',
							backgroundColor: '#dddddd',
							verticalAlign: 'top',
							layout: 'horizontal',
              //labelFormatter: wordwapF,
              itemStyle: {
              	color: '#274b6d'
              }
            },
          }
        },{
        	condition: {
        		maxWidth: 439
        	},
        	chartOptions: {
        		legend: {
        			enabled : true,
        			align: 'center',
        			backgroundColor : '#dddddd',
        			verticalAlign: 'top',
        			layout: 'horizontal',
        			itemStyle : {
        				width: 190,
        				fontSize : 11
        			}
        		},
        	}
        } ]
      },


      navigator : {
      	enabled : chartCommon.Conf.isNavigator,
      	maskFill : "rgba(0, 0, 0, 0.10)",
      	series : {
      		color:'rgba(51,92,173,0.05)',
      		lineColor : '#DE4622'
      	}
      },

      yAxis : yAxis,
      xAxis : xAxis,
      tooltip: toolTip
    }, function(p_chrtObj) {

    	p_chrtObj.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', (chartCommon.Conf.chartLayout=='narrow' && JMA.controller!='home')?700:365, 380, 218,17).add();
    	p_chrtObj.renderer.text("Source : "+chartCommon.Conf.sources, 10, 388, 159, 33).add();this.controller!='home'
    	p_chrtObj.xAxis[0].setExtremes(
    		chartCommon.Conf.navigator_date_from,
    		chartCommon.Conf.navigator_date_to);
    	if(p_chrtObj.xAxis[0].tickPositions!== undefined && p_chrtObj.xAxis[0].tickPositions.length>12){
    		p_chrtObj.xAxis[0].update({labels:{rotation:-45}});
    	}   
			if(chartCommon.Conf.reversedAxis_.length>0){
			chartCommon.Conf.reversedAxis_=chartCommon.Conf.reversedAxis_.map(Number);
			}
			for(var yX=0; yX<p_chrtObj.yAxis.length; yX++) {
			if($.inArray(yX,chartCommon.Conf.reversedAxis_) != -1){
			p_chrtObj.yAxis[yX].update({reversed: chartCommon.Conf.reverseYAxis });
			}
			}

			 ManualChartUpdate(p_chrtObj,chartCommon.Conf);
    });

return cht;
};

this.drawJmaChart = function(){
	var chart_data_series = this.createChartDataSeries();
	var tableClass =  new creativeTableOnIndicatorPage(p_chartIndex,chartCommon);
	tableClass.enableSwitchingChartToTable();
	this.chart_object = this.createHighChart(chart_data_series);
	tableClass.enableSwitchingChartToTableOnDefault();

};

this.drawChart = function() {


	this.drawChartLayout();
	if(this.Conf.chartLayout == 'normal') {
		this.drawSeriesLayout();
	}

	this.drawJmaChart();
	
	this.initializeGraphDomelements();
	var md = new MobileDetect(window.navigator.userAgent);
  if (md.mobile() || md.tablet()) {
    $('.addmor-menu').dlmenu();
  } else {
    $('a.btn-admor').unbind('click').on('click', function(event) {
      event.preventDefault();
      event.stopPropagation();
      $(this).parent().siblings().removeClass('dropdown-clicked');
      $(this).parent().children('.dropdown-menu').children('.dropdown-clicked').removeClass('dropdown-clicked');
      $(this).parent().toggleClass('dropdown-clicked');
    });
    $(document).on('click', 'body', function(e) {
      if (!$(e.target).is('.dropdown-clicked'))
        $('.dropdown-clicked').removeClass('dropdown-clicked');
    });
  }
};

this.setConfigurations();
}

// Class Multiaxis lineChart
function MultiYaxisLineChart(p_chartIndex, chartDetails){
	
	var isBig  = window.matchMedia( "(min-width: 1025px)" );


	if(isBig.matches)
	{
		var tooltipstyle={};
	}else{
		var tooltipstyle={ width: '100px'};
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
	};
	
	this.createMultiYaxisConfigurations = function(chart_data_series){
		var ret_data = {
			yAxis : new Array(),
			dataSeries : new Array()
		};
		$.each(chart_data_series,function(ky,chData){
			
			
			if(chartCommon.Conf.chartColor.hasOwnProperty(ky))
			{
				chartCommon.chartConfigs.colors[ky] = chartCommon.Conf.chartColor[ky] ;
			}
			else if(chartCommon.Conf.mychartchartColor !== undefined)
			{
				if(chartCommon.Conf.mychartchartColor[ky])
				{
					chartCommon.chartConfigs.colors[ky] = chartCommon.Conf.mychartchartColor[ky];
				}
			}
									
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
			    			color: chartCommon.chartConfigs.colors[ky]
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

	this.createHighChart = function(chart_data_series) {
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

	var quaterly_Extra = {};
		if (this.Conf.chart_data_type == 'quaterly') {
			var quaterly_Extra = {
			
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
		}
			
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
				
			};
			$.extend( true, xAxis, quaterly_Extra );
			//Object.assign(xAxis, quaterly_Extra)

			//console.log(Object.assign(xAxis, quaterly_Extra));
			var toolTip = {
				formatter: function () {
					var s = '<b>';
					var ss='';
					var _Inside_data_Type;
					$.each(this.points, function (i, point) {
						var eachSeriesData=point.series.userOptions.data;
						var graph_code__=chartCommon.Conf.current_chart_codes[point.series.colorIndex];
						var res = graph_code__.match(/163/gi);
						if(res!=null){
						if(eachSeriesData.length==(point.point.index+1)){
							var eachSeriesDataLast=point.point.index-1;
						}else{
							var eachSeriesDataLast=point.point.index+1;
						}
						var eachSeriesDataQuat=point.point.index;
						}else{
						var eachSeriesDataLast=eachSeriesData.length-1;
						var eachSeriesDataQuat=eachSeriesData.length-2;
						}

//var Second_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataLast][0]));
//var First_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffTime = Math.abs(parseInt(eachSeriesData[eachSeriesDataLast][0]) - parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
//console.log(diffDays);
					if(diffDays>=90 && diffDays<=92){
						 _Inside_data_Type='quaterly';
					}else if(diffDays>=28 && diffDays<=32){
					 _Inside_data_Type='monthly';
					}else if(diffDays>=360 && diffDays<=365){
					 _Inside_data_Type='anual';
					}else if(diffDays==1){
					 _Inside_data_Type='daily';
					}else{
						_Inside_data_Type=chartCommon.Conf.chart_data_type;
					}
					var s = '<b>';
                   if (_Inside_data_Type == 'quaterly') {
                   
					if (Highcharts.dateFormat('%b', point.x) == 'Mar') {
						s = s + "Q1"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Jun') {
						s = s + "Q2"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Sep') {
						s = s + "Q3"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Dec') {
						s = s + "Q4"
					}else{
						s = s +Highcharts.dateFormat('%b', point.x);
					}
					}else if(_Inside_data_Type == 'monthly'){
						s = s +Highcharts.dateFormat('%b', point.x);
	        		}else if(_Inside_data_Type == 'daily'){
						s = s +Highcharts.dateFormat('%a %b %e,', point.x);
	        		}
	        		// console.log(_Inside_data_Type);
					s = s + " " + Highcharts.dateFormat('%Y', point.x) + '</b>';
					var symbol = '<span style="color:' + point.series.color + '">●</span>';
						ss += symbol+ point.series.name +' ('+s+'): '+point.y+'<br/>';
					});
					ss=ss.slice(0,-5);
					return ss;
				},
				
				followTouchMove: false,
				style: tooltipstyle,
				useHTML: true,
				//backgroundColor: null,
				//padding:10,
				split: false,
	            shared: true,
				//borderWidth: 0,
                //shadow: false,
				positioner: function () {
            return { x: 37, y: 285 };
               }
			};
		

				if (this.Conf.chart_data_type == 'quaterly') {
				Object.assign(toolTip, {shared: true});
				}
				var cht = new Highcharts.StockChart({
			chart : {
				type:((this.Conf.chartType=='multiaxisbar')?'column':''),
				renderTo : graph_container,
						//backgroundColor : '#FBFBFB',
						backgroundColor : '#f5f5f5',
						plotBorderColor : '#000000',
						plotBackgroundColor : '#FFFFFF',
						plotBorderWidth : 0.5,
						spacingBottom : 35,
						alignTicks: true,
						events:{
					click: function(e) {
						if(!$('#'+graph_container).find('ul.list_annotations li').hasClass('select')){
						$('#'+graph_container).find('ul.list_annotations').addClass('open')
						$('#'+graph_container).find('ul.list_annotations').show();
							e.stopPropagation()

						}
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
									//this.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', 385, 300, 195,16).add();
									//this.renderer.text("Source : "+chartCommon.Conf.sources, 10, 310, 159, 33).css({size:'3px'}).add();
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
						href : 'http://japanmacroadvisors.com',
						text : 'japanmacroadvisors.com'
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
                   
                  
                }
            },
					},
					responsive: {
						rules: [{
							condition: {
								maxWidth: 500
							},
							chartOptions: {
								legend: {
									enabled: true,
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
								legend: {
									enabled: true,
									align: 'center',
									backgroundColor: '#dddddd',
									verticalAlign: 'top',
									layout: 'horizontal',
									itemStyle: {
										color: '#274b6d'
									}
								},
							}
						},{
							condition: {
								maxWidth: 439
							},
							chartOptions: {
								legend: {
									enabled : true,
									align: 'center',
									backgroundColor : '#dddddd',
									verticalAlign: 'top',
									layout: 'horizontal',
									itemStyle : {
										width: 190,
										fontSize : 11
									}
								},
							}
						} ]
					},
					navigator: {
						enabled: chartCommon.Conf.isNavigator,
						maskFill: "rgba(0, 0, 0, 0.10)",
						series: {
								color:'rgba(51,92,173,0.05)',
							lineColor: '#FFFFFF'
						}
					},
					yAxis: formetted_data_series.yAxis,
					xAxis : xAxis,
					tooltip: toolTip
				},function(p_chrtObj){
					p_chrtObj.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', (chartCommon.Conf.chartLayout=='narrow' && JMA.controller!='home')?700:365, 380, 218,17).add();
					p_chrtObj.renderer.text("Source : "+chartCommon.Conf.sources, 10, 388, 159, 33).add();
					p_chrtObj.xAxis[0].setExtremes(
						chartCommon.Conf.navigator_date_from,
						chartCommon.Conf.navigator_date_to);
					if(chartCommon.Conf.reversedAxis_.length>0){
						chartCommon.Conf.reversedAxis_=chartCommon.Conf.reversedAxis_.map(Number);
					}
					for(var yX=0; yX<p_chrtObj.userOptions.series.length; yX++) { 
						if($.inArray(yX,chartCommon.Conf.reversedAxis_) != -1){ 
					p_chrtObj.yAxis[yX].update({reversed: chartCommon.Conf.reverseYAxis });
				}
				    }
				     ManualChartUpdate(p_chrtObj,chartCommon.Conf);
				    
				});
return cht;		
};

this.drawJmaChart = function(){
	var chart_data_series = this.createChartDataSeries();
    var tableClass =  new creativeTableOnIndicatorPage(p_chartIndex,chartCommon);
	tableClass.enableSwitchingChartToTable();
	this.chart_object = this.createHighChart(chart_data_series);
	tableClass.enableSwitchingChartToTableOnDefault();
};

this.drawChart = function() {
	this.drawChartLayout();
	if(this.Conf.chartLayout == 'normal') {
		this.drawSeriesLayout();
	}
	this.drawJmaChart();
	this.initializeGraphDomelements();
	var md = new MobileDetect(window.navigator.userAgent);
  if (md.mobile() || md.tablet()) {
    $('.addmor-menu').dlmenu();
  } else {
    $('a.btn-admor').unbind('click').on('click', function(event) {
      event.preventDefault();
      event.stopPropagation();
      $(this).parent().siblings().removeClass('dropdown-clicked');
      $(this).parent().children('.dropdown-menu').children('.dropdown-clicked').removeClass('dropdown-clicked');
      $(this).parent().toggleClass('dropdown-clicked');
    });
    $(document).on('click', 'body', function(e) {
      if (!$(e.target).is('.dropdown-clicked'))
        $('.dropdown-clicked').removeClass('dropdown-clicked');
    });
  }
};

this.setConfigurations();
}

//Class BarChart
function BarChart(p_chartIndex, chartDetails){

	var isBig  = window.matchMedia( "(min-width: 1025px)" );

	if(isBig.matches)
	{
		var tooltipstyle={};
	}else{
		var tooltipstyle={ width: '100px'};
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






	this.createHighChart = function(chart_data_series) {

		var graph_container = 'Jma_chart_container_' + this.Conf.chartIndex;
		var position_legend_x = -15;
		var position_legend_width = 530;
		var position_legend_x_export = -15;
		var position_legend_width_export = 552;
		var quaterly_Extra = {};
		if (this.Conf.chart_data_type == 'quaterly') {

			var quaterly_Extra = {
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
		}
			
		
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
				
				
			};
			$.extend( true, xAxis, quaterly_Extra );
			//Object.assign(xAxis, quaterly_Extra)

			//console.log(Object.assign(xAxis, quaterly_Extra));
			var toolTip = {
				formatter: function () {
				        var ss = "";
						var _Inside_data_Type;
					$.each(this.points, function (i, point) {
						var eachSeriesData=point.series.userOptions.data;
						var graph_code__=chartCommon.Conf.current_chart_codes[point.series.colorIndex];
						var res = graph_code__.match(/163/gi);
						if(res!=null){
						if(eachSeriesData.length==(point.point.index+1)){
							var eachSeriesDataLast=point.point.index-1;
						}else{
							var eachSeriesDataLast=point.point.index+1;
						}
						var eachSeriesDataQuat=point.point.index;
						}else{
						var eachSeriesDataLast=eachSeriesData.length-1;
						var eachSeriesDataQuat=eachSeriesData.length-2;
						}

//var Second_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataLast][0]));
//var First_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffTime = Math.abs(parseInt(eachSeriesData[eachSeriesDataLast][0]) - parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
//console.log(diffDays);
					if(diffDays>=90 && diffDays<=92){
						 _Inside_data_Type='quaterly';
					}else if(diffDays>=28 && diffDays<=32){
					 _Inside_data_Type='monthly';
					}else if(diffDays>=360 && diffDays<=365){
					 _Inside_data_Type='anual';
					}else if(diffDays==1){
					 _Inside_data_Type='daily';
					}else{
						_Inside_data_Type=chartCommon.Conf.chart_data_type;
					}
					var s = '<b>';
                   if (_Inside_data_Type == 'quaterly') {
                   
					if (Highcharts.dateFormat('%b', point.x) == 'Mar') {
						s = s + "Q1"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Jun') {
						s = s + "Q2"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Sep') {
						s = s + "Q3"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Dec') {
						s = s + "Q4"
					}else{
						s = s +Highcharts.dateFormat('%b', point.x);
					}
					}else if(_Inside_data_Type == 'monthly'){
						s = s +Highcharts.dateFormat('%b', point.x);
	        		}else if(_Inside_data_Type == 'daily'){
						s = s +Highcharts.dateFormat('%a %b %e,', point.x);
	        		}
	        		// console.log(_Inside_data_Type);
					s = s + " " + Highcharts.dateFormat('%Y', point.x) + '</b>';
					var symbol = '<span style="color:' + point.series.color + '">●</span>';
						ss += symbol+ point.series.name +' ('+s+'): '+point.y+'<br/>';
					});
					ss=ss.slice(0,-5);
					return ss;
				},
				
				followTouchMove: false,
				style:tooltipstyle,
				useHTML: true,
				//padding:10,
				//backgroundColor: null,
				split: false,
	            shared: true,
				//borderWidth: 0,
               // shadow: false,
				positioner: function () {
            return { x: 37, y: 285 };
        }

			};

				if (this.Conf.chart_data_type == 'quaterly') {
					Object.assign(toolTip, {shared: true});
					
				}
		
		var yAxis = {
				gridLineWidth: 1, // The default value, no need to change it
				gridLineDashStyle: 'ShortDash',
				offset : 30
			};

			var cht = new Highcharts.StockChart({
				chart : {
					type: 'column',
					renderTo : graph_container,
						//backgroundColor : '#FBFBFB',
						backgroundColor : '#f5f5f5',
						plotBorderColor : '#000000',
						plotBackgroundColor : '#FFFFFF',
						plotBorderWidth : 0.5,
						spacingBottom : 35,
						alignTicks: true,
						events:{
					click: function(e) {
						if(!$('#'+graph_container).find('ul.list_annotations li').hasClass('select')){
						$('#'+graph_container).find('ul.list_annotations').addClass('open')
						$('#'+graph_container).find('ul.list_annotations').show();
							e.stopPropagation()

						}
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
									//this.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', 385, 300, 195,16).add();
									//this.renderer.text("Source : "+chartCommon.Conf.sources, 10, 310, 159, 33).css({size:'3px'}).add();
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
					href : 'http://japanmacroadvisors.com',
					text : 'japanmacroadvisors.com'
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
                   
                  
                }
            },
				},
				responsive: {
					rules: [{
						condition: {
							maxWidth: 500
						},
						chartOptions: {
							legend: {
								enabled: true,
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
							legend: {
								enabled: true,
								align: 'center',
								backgroundColor: '#dddddd',
								verticalAlign: 'top',
								layout: 'horizontal',
								itemStyle: {
									color: '#274b6d'
								}
							},
						}
					},{
						condition: {
							maxWidth: 439
						},
						chartOptions: {
							legend: {
								enabled : true,
								align: 'center',
								backgroundColor : '#dddddd',
								verticalAlign: 'top',
								layout: 'horizontal',
								itemStyle : {
									width: 190,
									fontSize : 11
								}
							},
						}
					} ]
				},
				navigator: {
					enabled: chartCommon.Conf.isNavigator,
					maskFill: "rgba(0, 0, 0, 0.10)",
					series: {
							color:'rgba(51,92,173,0.05)',
						lineColor: '#DE4622'
					}
				},
				yAxis: yAxis,
				xAxis : xAxis,
				tooltip: toolTip
			},function(p_chrtObj){


				p_chrtObj.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', (chartCommon.Conf.chartLayout=='narrow' && JMA.controller!='home')?700:365, 380, 218,17).add();
				p_chrtObj.renderer.text("Source : "+chartCommon.Conf.sources, 10, 388, 159, 33).add();
				p_chrtObj.xAxis[0].setExtremes(
					chartCommon.Conf.navigator_date_from-1,
					chartCommon.Conf.navigator_date_to);
				if(chartCommon.Conf.reversedAxis_.length>0){
						chartCommon.Conf.reversedAxis_=chartCommon.Conf.reversedAxis_.map(Number);
					}
				 for(var yX=0; yX<p_chrtObj.yAxis.length; yX++) {
					if($.inArray(yX,chartCommon.Conf.reversedAxis_) != -1){
					p_chrtObj.yAxis[yX].update({reversed: chartCommon.Conf.reverseYAxis });
					}
				    }
				    	 ManualChartUpdate(p_chrtObj,chartCommon.Conf);
				//p_chrtObj.yAxis[0].update({reversed: chartCommon.Conf.reverseYAxis });
			});


return cht;		
};

	this.drawJmaChart = function()
	{
		var chart_data_series = this.createChartDataSeries();
		var tableClass =  new creativeTableOnIndicatorPage(p_chartIndex,chartCommon);
		tableClass.enableSwitchingChartToTable();
		this.chart_object = this.createHighChart(chart_data_series);
		tableClass.enableSwitchingChartToTableOnDefault();				
	
	};

this.drawChart = function() {
	this.drawChartLayout();
	if(this.Conf.chartLayout == 'normal') {
		this.drawSeriesLayout();
	}
	this.drawJmaChart();
	this.initializeGraphDomelements();
	var md = new MobileDetect(window.navigator.userAgent);
  if (md.mobile() || md.tablet()) {
    $('.addmor-menu').dlmenu();
  } else {
    $('a.btn-admor').unbind('click').on('click', function(event) {
      event.preventDefault();
      event.stopPropagation();
      $(this).parent().siblings().removeClass('dropdown-clicked');
      $(this).parent().children('.dropdown-menu').children('.dropdown-clicked').removeClass('dropdown-clicked');
      $(this).parent().toggleClass('dropdown-clicked');
    });
    $(document).on('click', 'body', function(e) {
      if (!$(e.target).is('.dropdown-clicked'))
        $('.dropdown-clicked').removeClass('dropdown-clicked');
    });
  }
};

this.setConfigurations();
}






//Class MapChart not stockchart
function MapChart(p_chartIndex, chartDetails) {
	var isBig  = window.matchMedia( "(min-width: 1025px)" );
	var chartCommon = this;
	this.setConfigurations = function(){ };
	this.createChartDataSeries = function() {
		var chartDataSeries = [];
		var chart_series_count = 0;
		   
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
			var map_type='map';
			chartDataSeries[chart_series_count] = {
				type:map_type,
				
				name : chartCommon.Conf.chart_labels_available[chartcode],
				data : chart_data_col
			}
			chart_series_count++;
			d++;
		});
		return chartDataSeries;
	}

	this.createHighChart = function(chart_data_series) {
var graph_container = 'Jma_chart_container_' + this.Conf.chartIndex;
		
				var Series_=[{
					name: 'States',
					showInLegend: false,
					//data:chart_data_series[0].data,
					//type: 'map',
					enableMouseTracking: true
				},
				{
				name: 'State borders',
				showInLegend: false,
				color: 'silver',
				type: 'mapline',
				enableMouseTracking: true
				}
			];
			Series_=Series_.concat(chart_data_series);
 var Unit=chartCommon.Conf.chart_labels_available[chartCommon.Conf.current_chart_codes[0]];

					Unit=$.trim(Unit.split('-')[1]);
					if (Unit.indexOf(',') > -1) {  var Unit_=$.trim(Unit.split(',')[1]); }else var Unit_=Unit;


					if($.trim(Unit)=='Persons'){
					var Stops=[
					[0, '#d6d4d4'],
					[0.1, '#b3b3b3'],
					[0.2, '#9a9a9a'],
					[0.3, '#b73f3f'],
					[0.4, '#af3333'],
					[0.5, '#ad2626'],
					[0.6, '#a51a1a'],
					[0.7, '#9a1010'],
					[0.8, '#890707'],
					[0.9, '#710808'],
					[1, '#5d0505']
					];
  						
  					}else{
  						var Stops=[
				[0, '#011f38'],
				[0.1, '#0560a3'],
				[0.2, '#5eb6f7'],
				[0.3, '#ff7075'],
				[0.4, '#ff545a'],
				[0.5, '#fc353c'],
				[0.6, '#f5020b'],
				[0.7, '#d1000b'],
				[0.8, '#9e0209'],
				[0.9, '#800308'],
				[1, '#4f0104']
				];
  					}

  					if(chartCommon.Conf.chart_data_type=='daily'){

						var Stops= [
                    [0, '#ffffff'],
                    [0.02, '#ffd6cc'],
                    [0.04, '#ffad99'],
                    [0.06, '#ff704d'],
                    [0.08, '#ff471a'],
                    [0.1, '#e62e00'],
                    [0.2, '#cc2900'],
                    [0.3, '#b32400'],
                    [0.4, '#991f00'],[0.5, '#991f00'],[0.6, '#801a00'],[0.7, '#801a00'],[0.8, '#661400'],[0.9, '#661400'],
                    [1, '#4d0f00']
                ];
  					}

			var map_chart=new Highcharts.mapChart({
				chart: {
					
				spacingBottom : 35,
				alignTicks: true,
				renderTo : graph_container,
				map: 'countries/jp/jp-all-custom'
			   },
				exporting : {
				enabled : false,
				chartOptions:{
				chart : {
				//	spacingBottom : 85,
				
				},
				tooltip: { enabled: false },
				legend : {
				enabled : true,
				backgroundColor : '#fff',
				itemStyle : {
				color : '#274b6d',
				}
				}
				}
				},
				credits : {
					enabled : false,
					href : 'http://japanmacroadvisors.com',
					text : 'Japanmacroadvisors.com'
				},
				title: {

				text: chart_data_series[0].name+' ('+chartCommon.Conf.default_year+')',
				useHTML: true,
				  style: {
				  	 'height': '29px',
				  	 'padding':'6px',
				    'color': '#274b6d',
				    'background-color': '#dddddd',
				    'fontWeight': 'bold',
				    'fontSize': '12px'
				  }
				
						
				},

				mapNavigation: {
				    enabled: true,
				    enableDoubleClickZoomTo: true,
				    buttonOptions: {
				      verticalAlign: 'top'
				    }
				 },
				legend: {
					 enabled: true,
				/*y: -80,title: {
				text: chart_data_series[0].name,
				},*/
				//backgroundColor : '#dddddd',
				align: 'right',
				verticalAlign: 'middle',
				y: 50,
				x: -20,
				floating: true,

				layout: 'vertical',
				valueDecimals: 0,
				symbolRadius: 0,
				
				},

				colorAxis: {
					gridLineWidth: 1,
					gridLineColor: 'white',
					minorTickInterval: 1,
					tickAmount: ((chartCommon.Conf.chart_data_type=='anual')?10:null),
					reversed: false,
					className: 'highcharts-colorAxis-'+$.trim((chartCommon.Conf.current_chart_codes[0]).split('-')[1]),

					//tickPositions:[1500000,3000000,4500000,6000000,7500000,9000000,10500000,12000000,13500000],
					//tickInterval: 5000,
					//alignTicks: false,
					 /*showLastLabel: true,*/
					// showFirstLabel: false,
					// startOnTick: true,*/
					/*endOnTick: false,e6ebf5*/
					/*stops: [[0.34, '#011f38'], [0.67, '#FF0000'], [1, '#8a0404']],*/
					/*minColor: '#e6ebf5',
            		maxColor: '#FF0000',*/

					stops:Stops,
					marker: {
					color: 'green'
					},
					//type:'linear',
					dataClasses: undefined
					
				},

				 plotOptions: {
				 	map: {
            	allAreas: true,
            	//nullColor: 'red',
				mapData: Highcharts.maps['countries/jp/jp-all-custom'],
				joinBy: 'hc-key',
				showInLegend: false,
				/*displayNegative: true,
				 threshold: 0,
            negativeColor: '#CCCCCC'  ,*/
           
				states: {
				hover: {
				color: '#BADA55'//BADA55
				}
				},
				dataLabels: {
				enabled: 0,
				format: '{point.name}'
				}
				},
				mapbubble: {
				allAreas: true,
				//nullColor: 'red',
				mapData: Highcharts.maps['countries/jp/jp-all-custom'],
				joinBy: 'hc-key',
				color: '#3366CC',
				showInLegend: false,
				minSize: 4, maxSize: '12%',
				states: {
				hover: {
				color: 'red'//BADA55
				}
				},
				dataLabels: {
				enabled: 0,
				format: '{point.name}'
				}
				}
				
       		 },
				series:Series_,
				tooltip: {
				//valueSuffix: 'k',	
				useHTML: !0,
				borderWidth: 1,
				borderColor: '#E60013',
				shadow: !0,
				shared: true,
				followTouchMove: false,
				formatter: function() {
						var mul=1;var conc_='';
				if((chartCommon.Conf.chart_labels_available[chartCommon.Conf.current_chart_codes[0]]).indexOf("Population")>=0){
					var mul=1000;conc_='k';
				}
				return '<b>' + this.point.name + '</b> <br> ' + $.trim(this.series.name.split('-')[0]) + ': <b>' + ((this.point.value==undefined)?this.point.z:(($.trim(Unit_)=='%')?this.point.value:(this.point.value)/ 1*mul + conc_))+ '</b>,' + $.trim(Unit) + '<br/>Year: <b>'+chartCommon.Conf.default_year+'<b>';
				}
				}
  				},function(p_chrtObj){ 
var coloraxisLabel={useHTML:true,enabled:true};
var min_=p_chrtObj.colorAxis[0].dataMin;
  						var max_=p_chrtObj.colorAxis[0].dataMax;
  						
  					if((chartCommon.Conf.chart_labels_available[chartCommon.Conf.current_chart_codes[0]]).indexOf("Population")>=0){

  					if($.trim(Unit_)=='Persons' || $.trim(Unit_)=='%'){ 
  						coloraxisLabel= {
					formatter: function () {
						if(this.value==5000000){
							return '>'+(this.value)/ 1000 + 'k';
						}else if(this.value==140){
							return '>'+this.value;
						}else if(this.value==3500000 && $.trim(Unit)=='10yr Change, Persons'){
							return '>'+(this.value)/ 1000 + 'k';
						}else if(this.value==-1000000){
							return '<'+(this.value)/ 1000 + 'k';
						}else if(this.value==-40){
							return '<'+this.value;
						}else{
							return ($.trim(Unit_)=='%')?this.value:(this.value)/ 1000 + 'k';
						}
						//return (this.value*1000)/ 1000 + 'k'; //return (this.value=='13500000')?'> '+this.value:this.value; 
				}  
			};
  					}
  					if($.trim(Unit)=='Persons'){
  						var min_=500000;
  						var max_=5000000;
  					}else if($.trim(Unit)=='10yr Change, Persons'){
  						var min_=-1000000;
  						var max_=3000000;
  					}else if($.trim(Unit)=='10yr Change, %'){
  						var min_=-40;
  						var max_=140;
  					}else{
  						var min_=p_chrtObj.colorAxis[0].dataMin;
  						var max_=p_chrtObj.colorAxis[0].dataMax;
  					}
  					}
  						/*if($.trim(Unit_)=='%'){
  							var tickInterval=undefined;
  						}else{
  							var tickInterval=undefined;

  						}*/
  					
			//tickPositions:[-45.2,-30,0,30,60,90,120,134.4]
// console.log(p_chrtObj.colorAxis[0].dataMin+'-'+p_chrtObj.colorAxis[0].dataMax);
//  console.log($.trim(Unit)+p_chrtObj.colorAxis[0].tickPositions);
			//
			  p_chrtObj.colorAxis[0].update({ //type: 'logarithmic',
				min: min_,max: max_,labels:coloraxisLabel
			});

			/*   p_chrtObj.colorAxis[0].update({labels:coloraxisLabel,tickPositioner:function(min, max) {
            // specify an interval for ticks or use max and min to get the interval
            var interval = Math.round((max_ - min_)/8);
             console.log(Math.round(max_ - min_));
            console.log(interval);
            var dataMin = min_;
            var dataMax = max_;
            // push the min value at beginning of array
            var positions = [dataMin];
            var defaultPositions = [];
            var defaultPositions = this.getLinearTickPositions(1500000, dataMin, dataMax);
                 console.log(defaultPositions);
             for (var v = 0; v < 10; v++) {
            defaultPositions.push(v*interval);
        }
       // console.log(defaultPositions);
        var defaultPositions = defaultPositions.map(function (defaultPositions) {
			return Math.round(defaultPositions/100000)*100000;
			});
			 // var defaultPositions = p_chrtObj.colorAxis[0].tickPositions;
           // console.log(p_chrtObj.colorAxis[0].tickPositions);
            console.log(defaultPositions);
            //push all other values that fall between min and max
            for (var i = 0; i < defaultPositions.length; i++) {
                if (defaultPositions[i] > dataMin && defaultPositions[i] < dataMax) {
                    positions.push(defaultPositions[i]);
                }
            }
             // push the max value at the end of the array
           		// positions.push(dataMax);
              if(Math.sign(positions[0])==-1){ if($.inArray(0, positions) === -1) positions.push(0);}
               positions.sort(function(a, b){return a-b});
             console.log(positions);
            return positions;
        }});*/
			p_chrtObj.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', (chartCommon.Conf.chartLayout=='narrow' && JMA.controller!='home')?700:365, 380, 218,17).add();
				p_chrtObj.renderer.text("Source : "+chartCommon.Conf.sources, 10, 388, 159, 33).add();
				$('.selectpicker').selectpicker();
				if((chartCommon.Conf.chart_data_type).match('^daily')){
				JMA.JMAChart.Load_YieldDatePicker();
				updateMaptickPositions(p_chrtObj,chartCommon);
				}
			});



			return map_chart;
};
	this.drawJmaChart = function(){
	var chart_data_series = this.createChartDataSeries();
	var tableClass =  new creativeTableOnIndicatorPage(p_chartIndex,chartCommon);
	tableClass.enableSwitchingChartToTable();
	this.chart_object = this.createHighChart(chart_data_series);
	tableClass.enableSwitchingChartToTableOnDefault();
};

this.drawChart = function() {
	this.drawChartLayout();
	if(this.Conf.chartLayout == 'normal') {
		this.drawSeriesLayout();
	}
	this.drawJmaChart();
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
	this.createChartObject = {
		'line' : function(p_chartIndex){
			LineChart.prototype = new chartCommon(p_chartIndex);
			return new LineChart();
		},
		'yield_line' : function(p_chartIndex){

			YieldChart.prototype = new chartCommon(p_chartIndex);
			return new YieldChart();
		},
		'yield_bar' : function(p_chartIndex){
			YieldChart.prototype = new chartCommon(p_chartIndex);
			return new YieldChart();
		},
		'yield_multiaxisline' : function(p_chartIndex,chartDetails){
			YieldChart.prototype = new chartCommon(p_chartIndex);
			return new YieldChart();
		},
		'yield_multiaxisbar' : function(p_chartIndex,chartDetails){
			YieldChart.prototype = new chartCommon(p_chartIndex);
			return new YieldChart();
		},
		'bar' : function(p_chartIndex,chartDetails){
			BarChart.prototype = new chartCommon(p_chartIndex);
			return new BarChart();
		},
		'map' : function(p_chartIndex,chartDetails){
			MapChart.prototype = new chartCommon(p_chartIndex);
			return new MapChart();
		},
		'multiaxisline' : function(p_chartIndex,chartDetails){
			MultiYaxisLineChart.prototype = new chartCommon(p_chartIndex);
			return new MultiYaxisLineChart();
		},
		'multiaxisbar' : function(p_chartIndex,chartDetails){
			MultiYaxisLineChart.prototype = new chartCommon(p_chartIndex);
			return new MultiYaxisLineChart();
		}


	};
	
	//initiate a new chart object
	this.initiateChart = function(chartIndex,chartDetails){
		this.Charts[chartIndex] = this.createChartObject[chartDetails.chart_config.chartType](chartIndex);
		this.Charts[chartIndex].setAllConfigurations(chartIndex,chartDetails);	
	};
	
	//Switch graphTypes
	this.switchGraph = function(chartIndex,chartType){
		
		var currentConfig = this.Charts[chartIndex].getAllConfigurations();

		chartType=((currentConfig.chartType).match("^yield_")) ? "yield_"+chartType : chartType;
		currentConfig.chartType = chartType;
		currentConfig.view_option = 'chart';
		currentConfig.chartColorSatus = 'true';
		currentConfig.reverseYAxis = JMA.JMAChart.Charts[chartIndex].Conf.reverseYAxis;
		if(JMA.JMAChart.Charts[chartIndex].Conf.reverseYAxis==true && JMA.JMAChart.Charts[chartIndex].Conf.reversedAxis_.length==0){
			//if(JMA.JMAChart.Charts[chartIndex].Conf.reversedAxis_.length==0){
				currentConfig.reversedAxis_ = Array.from({length: JMA.JMAChart.Charts[chartIndex].Conf.current_chart_codes.length}, (v, i) => i);
			/*}else{
				currentConfig.reversedAxis_ = JMA.JMAChart.Charts[chartIndex].Conf.reversedAxis_;
			}*/
			
		}else
		currentConfig.reversedAxis_ = JMA.JMAChart.Charts[chartIndex].Conf.reversedAxis_.map(Number);
		
		this.Charts[chartIndex] = this.createChartObject[chartType](chartIndex);
		this.Charts[chartIndex].copyThisConfigurations(currentConfig);

		this.Charts[chartIndex].drawChart();
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
				case '=^':
				return (v1.match(v2)) ? options.fn(this) : options.inverse(this);
				default:
				return options.inverse(this);
			}
		});
	}
	
	// Dom initialize
	this.domInitialize = function(){
		$('.Graph_tabset_tab.inactive').on("click",function(){
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
		var share_app_url = '';
		switch (sType){
			case 'facebook':
			share_app_url = 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(link_href);
			break;
			case 'twitter':
			share_app_url = 'https://twitter.com/intent/tweet?url='+encodeURIComponent(link_href)+'&hashtags=japanmacroadvisors.com,japan';
			break;
			case 'google':
			share_app_url = 'https://plus.google.com/share?url='+encodeURIComponent(link_href);
			break;
			case 'linkedin':
			share_app_url = 'http://www.linkedin.com/shareArticle?mini=true&url='+encodeURIComponent(link_href)+'&source=www.japanmacroadvisors.com';
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
		switch (sType){
			case 'facebook':
			share_app_url = 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(link_href);
			break;
			case 'twitter':
			
			share_app_url = 'https://twitter.com/intent/tweet?url='+encodeURIComponent(link_href)+'&hashtags=japanmacroadvisors.com,japan';
			break;
			case 'google':
			share_app_url = 'https://plus.google.com/share?url='+encodeURIComponent(link_href);
			break;
			case 'linkedin':
			share_app_url = 'http://www.linkedin.com/shareArticle?mini=true&url='+encodeURIComponent(link_href)+'&source=www.japanmacroadvisors.com';
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
	this.drawAllCharts = function(){

		if(this.Charts.length>0){
			$.each(this.Charts,function(idx,chartObj){

				chartObj.drawChart();

			});
			this.domInitialize();
		}

	};
	
	// Draw a chart by chart index
	this.redrawChart = function(p_chart_idx){
		var md = new MobileDetect(window.navigator.userAgent);
	  if (md.mobile() || md.tablet()) {
	    $('.addmor-menu').dlmenu();
	  } else {
	    $('a.btn-admor').unbind('click').on('click', function(event) {
	      event.preventDefault();
	      event.stopPropagation();
	      $(this).parent().siblings().removeClass('dropdown-clicked');
	      $(this).parent().children('.dropdown-menu').children('.dropdown-clicked').removeClass('dropdown-clicked');
	      $(this).parent().toggleClass('dropdown-clicked');
	    });
	    $(document).on('click', 'body', function(e) {
	      if (!$(e.target).is('.dropdown-clicked'))
	        $('.dropdown-clicked').removeClass('dropdown-clicked');
	    });
	  }

	//	JMA.JMAChart.Charts[p_chart_idx].redrawChart();
	var dataUrl = JMA.baseURL+'chart/getchartdata';
	var data_type = JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type;
	var chartcodes = JMA.JMAChart.Charts[p_chart_idx].Conf.current_chart_codes;
	var chartcolor = JMA.JMAChart.Charts[p_chart_idx].Conf.chartColor ? JMA.JMAChart.Charts[p_chart_idx].Conf.chartColor : null;
	var default_year = JMA.JMAChart.Charts[p_chart_idx].Conf.default_year;
	//if((data_type).match('^yield_') || JMA.controller == 'mycharts'){
	
	$.ajax({
		url : dataUrl,
		dataType : 'json',
		type : 'POST',
		data : {'type' : data_type, 'chartcodes' : chartcodes, 'chartColor' : chartcolor,'chartOrder':p_chart_idx,'default_year':default_year},
		beforeSend: function() { JMA.showLoading(); },
		success : function(data){
			JMA.JMAChart.Charts[p_chart_idx].Conf.chartData = JMA.JMAChart.Charts[p_chart_idx].formatData(data.data);
			JMA.JMAChart.Charts[p_chart_idx].Conf.sources = data.sources;
			JMA.JMAChart.Charts[p_chart_idx].Conf.isPremiumData = data.isPremiumData;
			JMA.JMAChart.Charts[p_chart_idx].drawJmaChart();
			$("div.input-group-addon i.fa-minus").trigger('click');
            $('[data-placement="top"]').tooltip();
			var seriesHeight = $('#Dv_placeholder_graph_series_section_'+p_chart_idx).height();
			$('#Chart_Dv_placeholder_'+p_chart_idx).find(".addser-drpbtn").css('top',seriesHeight + 40);
			if(seriesHeight > 150){
				$('#Chart_Dv_placeholder_'+p_chart_idx).find(".addser-drpbtn").addClass('asdb-upper');
			} else {
				$('#Chart_Dv_placeholder_'+p_chart_idx).find(".addser-drpbtn").removeClass('asdb-upper');
			}
			JMA.hideLoading();
		},
		error : function() {
			JMA.hideLoading();
			JMA.handleError();
		}
	});
/*}else{

	var dateObj = new Date();
var month = ("0" + (dateObj.getUTCMonth() + 1)).slice(-2); 
var year = dateObj.getUTCFullYear();
var tempappParams=JMA.params;
var _tempappParams=tempappParams.replace(/\//g,'_');
var GetsJsonUrl="storage/json_logs/"+(year.toString())+(month.toString())+_tempappParams+'-'+p_chart_idx+'.json';

	$.getJSON(JMA.baseURL+GetsJsonUrl, function(data) {
		var chart_data = {};
		chartcodes.forEach(function(element) {
		chart_data[element] = data.datas[element];
		});
		var dataV = {};
		dataV['data']=chart_data;
		dataV['isPremiumData']=data.isPremiumData;
		dataV['sources']=data.sources;
  JMA.JMAChart.Charts[p_chart_idx].Conf.chartData = JMA.JMAChart.Charts[p_chart_idx].formatData(chart_data);
            JMA.JMAChart.Charts[p_chart_idx].Conf.sources = data.sources;
            JMA.JMAChart.Charts[p_chart_idx].Conf.isPremiumData = data.isPremiumData;
            JMA.JMAChart.Charts[p_chart_idx].drawJmaChart();
            $("div.input-group-addon i.fa-minus").trigger('click');
 

});

}*/
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
				scale:4,
				sourceWidth : 700,
				//sourceHeight : 350,
				filename : 'jma_chart_'+type+'_'+width_val+'_'+idx,
				url : JMA.Export_url
		},
			{
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
		}

		
	};	

	
	// Export Chart
	this.exportChart = function(idx,pType,pSize){


		var type = pType == null? $('#export_chart_image_select_format_'+idx).val() : pType;
		var size = pSize == null? $('#export_chart_image_size_'+idx).val() : pSize;

		
		var width_val = JMA.JMAChart.Charts[idx].Conf.chartExport.image_size_available[size];

if(type=='ppt' && $('.exhibit-tab-footer_'+idx+' li.selected').data('view') != 'data'){
			this.export_ppt_Chart(idx);
		}else if(type=='csv'){
			JMA.JMAChart.downloadChartData(idx);
		}else{
			
			if($('.exhibit-tab-footer_'+idx+' li.selected').data('view') == 'data'){
			this.exportTable(idx,type,pSize);return false;
		}
			

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
				filename : 'jma_chart_'+type+'_'+width_val+'_'+idx,
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

		
	};	
	
	this.exportTable = function(idx,pType,pSize){
		var mobile_ =false;
			JMA.showLoading();
           var data_table=document.getElementById('Table_Dv_placeholder_'+idx);
            if(data_table.lastElementChild.innerHTML==undefined){
			var svg = data_table.innerHTML;
            }else{
            var svg=data_table.lastElementChild.innerHTML;
            }
         
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
mobile_ =true;
}

				var hidden_elm = document.createElement("div");
				hidden_elm.innerHTML=svg;
				hidden_elm.style.display='none';
				document.body.appendChild(hidden_elm);
				hidden_elm.getElementsByClassName('chartGroup')[0].removeAttribute('transform');
				hidden_elm.getElementsByClassName('svg-header')[0].removeAttribute('transform');
				if(data_table.lastElementChild.innerHTML==undefined){
				hidden_elm.getElementsByClassName('scroll-svg')[0].removeAttribute('style');
            	hidden_elm.getElementsByClassName('scroll-svg')[0].removeAttribute('height');
				}
				if(mobile_){
					hidden_elm.removeChild(hidden_elm.childNodes[0]);
				}
				 
				
				var find_image =hidden_elm.innerHTML;
				find_image = find_image.replace(/font-size:12px;/g, "font-size:10px;");
				if(pType=='ppt'){
				find_image = find_image.replace(/img/g, "");
			    }else{
			    find_image = find_image.replace(/img/g, "image");
				find_image = find_image.replace(/favicon.png">/g, 'favicon.png"></image>');	
			    }
				
				 
				
				document.body.removeChild(hidden_elm);			
		var ua = window.navigator.userAgent;
		if(ua.indexOf('Edge/')>0){
		
		if(mobile_){
	 find_image=$(svg).slice(1).find("g.chartGroup,g.svg-header").removeAttr('transform style').end().html();
		}else{
		find_image=$(svg).find("g.chartGroup,g.svg-header").removeAttr('transform style').end().html();	
		}
		
		}
		
		var fill='';
			var Bckgrnd="";
			if(pType=='png'){
				 fill='fill="#282828"';
				 Bckgrnd="background:#fff;";
			}
			 //<text x="460" y="400" font-family="Verdana" font-size="20" fill="red" stroke="red" stroke-width="0.5"> JMA</text>
		
		var chart_svg = '<svg class="scroll-svg" version="1.1" '+fill+' xmlns="http://www.w3.org/2000/svg" width="600" style="font-size:12px;'+Bckgrnd+'"  height="415">'+find_image+'</svg>';
		

		//console.log(chart_svg);return false;

			if(pType=='pdf'){
				var tabletype='application/pdf';
			}else{
				if(pType=='ppt'){
					var pType_='jpeg';
				}else{
					var pType_=pType;
				}
				
				var tabletype='image/'+pType_;
			}
			var exp_data = {
			svg: chart_svg,
			type: tabletype,
			width: 1200,
			height: 400
			};

				if(pType=='ppt'){
					 $.extend( true, exp_data, {async:true});
				}else{
					 $.extend( true, exp_data, {b64:true});
				}

					$.ajax({
						type: "POST",
						url: JMA.Export_url,
						data: exp_data,
						cache:false,
						async:true,
						crossDomain:true,
						success: function (data) {
							//console.log(data);
							var datas = {chart: data,title: 'JMA Table Powerpoint'};
							if(pType=='ppt'){
							JMA.JMAChart.ppt_ajax_request(datas);
							return false;
							}

							
								var hidden_a = document.createElement("a");
									hidden_a.setAttribute("href", 'data:application/octet-stream;base64,'+data);
									//window.location.href = 'data:application/octet-stream;base64,' + data;
									hidden_a.setAttribute("download", 'JMA_Table_Download.'+pType);
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
										JMA.hideLoading();
									}

						},
						error: function(data) {
							alert(data.statusText+data.status);
							JMA.hideLoading();

						}
					});
				
	};
	// Print chart
	this.printChart = function(idx){

if($('.exhibit-tab-footer_'+idx+' li.selected').data('view') != 'data'){
	JMA.JMAChart.Charts[idx].chart_object.print();
			
		}else{
this.printTable(idx);
		}

		
	};

	this.printTable = function(idx){
			var data_table = $('#Table_Dv_placeholder_'+idx).html();
			var find_image =$(data_table).find("g.chartGroup,g.svg-header").removeAttr('transform style').end().html();
			find_image = find_image.replace(/font-size:12px;/g, "font-size:10px;");
			
chart_svg = '<svg class="scroll-svg" version="1.1" charset="utf-8"  xmlns="http://www.w3.org/2000/svg" width="600" style="font-family:&amp;quot;Lucida Grande&amp;quot;, &amp;quot;Lucida Sans Unicode&amp;quot;, Arial, Helvetica, sans-serif;font-size:12px;"  height="410">'+find_image+'</svg>';
	var mywindow = window.open('', 'PRINT', 'height=400,width=600');
	mywindow.document.write('<html><head><title>dfg</title>');
	mywindow.document.write('</head><body >');
	mywindow.document.write(chart_svg);
	mywindow.document.write('</body></html>');
	mywindow.document.close(); // necessary for IE >= 10
	mywindow.focus(); // necessary for IE >= 10*/

	mywindow.print();
	mywindow.close();
	return true;

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
					if(chart.userOptions.isStock!=null){
					this.renderer.text($('#Jma_chart_container_'+idx+' span:contains("Source")').text(), 10, 310, 159, 33).css({size:'3px'}).add();
							}
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
	this.get_chart_fields_labels = function(p_chart_idx,p_graph_code){

	try{
			// Get list of charts for selected folder
			// create array or chart objects
			$.ajax({
				url : JMA.baseURL + "chart/get_chart_fields_labels",
				dataType : 'json',
				type : 'POST',
				data : { p_graph_code: p_graph_code },
				beforeSend: function() { JMA.showLoading(); },
				success : function(response){
					if(response.status!=1){
						JMA.handleErrorWithMessage(response.message);
					}else{
						$.extend( JMA.JMAChart.Charts[p_chart_idx].Conf.charts_fields_available, response.charts_fields_available);
						$.extend( JMA.JMAChart.Charts[p_chart_idx].Conf.chart_labels_available, response.chart_labels_available);
						//JMA.hideLoading();	
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
	// Add new graph code to current graph codes
	this.addThisGraphCode = function(p_chart_idx,p_graph_code){
		var SetTime=0;
		if(arguments.length==2 && typeof p_graph_code=='object'){
			var series_main_code = $('a#'+p_graph_code.id).attr('value');
			if(!(JMA.JMAChart.Charts[p_chart_idx].Conf.charts_codes_available).includes(series_main_code)){
				var SetTime=1500;
			var series_main_code_text = $('a#'+p_graph_code.id).text();
			(JMA.JMAChart.Charts[p_chart_idx].Conf.charts_codes_available).push(series_main_code);
			$.extend(JMA.JMAChart.Charts[p_chart_idx].Conf.charts_available, {series_main_code: series_main_code_text} );
			this.get_chart_fields_labels(p_chart_idx,series_main_code);
			}
		}else{
		var series_main_code = $('#select_series_addmore-select_'+p_chart_idx).val();
		}
		// Get previous chart's y-sub text
		var prev_ysub_selected_text = $('#Dv_placeholder_graph_series_section_'+p_chart_idx+' > div').last().find('.Dv_placeholder_graph_currentseries_ysub_select').find('select option:selected').text();
		var thing = this;
		setTimeout(function() {
		var arr_available_fields = JMA.JMAChart.Charts[p_chart_idx].Conf.charts_fields_available[series_main_code][Object.keys(JMA.JMAChart.Charts[p_chart_idx].Conf.charts_fields_available[series_main_code])[0]];
		if(arr_available_fields.hasOwnProperty(prev_ysub_selected_text)){
			var series_code = arr_available_fields[prev_ysub_selected_text];
		}else{
			var series_code = series_main_code+'-0';
		}
		JMA.JMAChart.Charts[p_chart_idx].addThisToCurrentGraphCode(series_code);
		JMA.JMAChart.Charts[p_chart_idx].drawSeriesLayout();
		JMA.JMAChart.Charts[p_chart_idx].Conf.chartColorSatus = 'true';
		thing.redrawChart(p_chart_idx);
		}, SetTime);
	};	
	// Replace existing graph code
	this.replaceThisGraphCode = function(p_chart_idx,p_code_idx,elm){
		
		if((JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type).match('^yield_')){
			var curchart_type=JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type;
			if(curchart_type=='yield_monthly'){
var curfield_date = new Date($(elm).val().split('/')[0],($(elm).val().split('/')[1]-1));

$(elm).val(curfield_date.yyyymmdd(curchart_type));
			}else{
		var curfield_date = new Date($(elm).val());
		$(elm).val(curfield_date.yyyymmdd(curchart_type));
			}
			
			var p_graph_code=this.FindCodeByLabel_Yield(p_chart_idx,elm);
		}else{
			var p_graph_code= $(elm).val();
		}

		if(p_code_idx!='map'){
			
			
			JMA.JMAChart.Charts[p_chart_idx].replaceCurrentGraphCode(p_code_idx,p_graph_code);
			
		}else{

		
			JMA.JMAChart.Charts[p_chart_idx].Conf.default_year=$(elm).val();
			var p_graph_code=$('#Dv_placeholder_graph_series_section_0').find('select:last option:selected').val();
		}
		
		if(p_graph_code!=''){
			
			JMA.JMAChart.Charts[p_chart_idx].drawSeriesLayout();
		}
		
		this.redrawChart(p_chart_idx);
		/*if(p_code_idx!='map' && $(elm).find('option:selected').text()=='10yr Change, %'){
				$('#default_year_'+p_chart_idx).hide();
			}*/
		
		
	};


	this.FindCodeByLabel_Yield = function(p_chart_idx,elm){
		var p_graph_code_= $(elm).data('value');
		var _p_graph_code='';
		var current_chartcode_arr = p_graph_code_.split('-');
		var current_chartcode_main = current_chartcode_arr[0];
		$.each(JMA.JMAChart.Charts[p_chart_idx].Conf.charts_fields_available[current_chartcode_main],function(label_main,sub_labels){
			$.each(sub_labels,function(label_sub,code){
				if(label_sub==$(elm).val()){
					_p_graph_code=code;
				}
				

			})
		})
		return _p_graph_code;

	};
	this.Load_YieldDatePicker = function(){






$(".yield_monthly_datepicker").each(function(){			
			$(this).datepicker({
				showOn: "button",
				buttonImage: "assets/images/calendar.png",
				buttonImageOnly: true,
				buttonText: "Select date",
				showAnim: 'slide',
				changeYear: true,
				changeMonth: true,
				dateFormat: 'yy/mm',
				defaultDate: new Date($(this).val()+'/01'),
				showMonthAfterYear: true,
			 	showButtonPanel: true,

				yearRange: $(this).data('first').split('/')[0]+':'+$(this).data('last').split('/')[0],
				beforeShow: function(input, inst) {

			
					
					$(inst.dpDiv).addClass('yeimon_calendar');
					
				},
				onClose: function(dateText, inst) { 
					
     		var month = $(inst.dpDiv).find(".ui-datepicker-month :selected").val();
            var year = $(inst.dpDiv).find(".ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month));
            
           
        },
        /*onChangeMonthYear: function() {
             alert('dd');
        }*/
			}).focus(function(event) {
					
				var thisCalendar = $(this);
						event.stopPropagation();event.preventDefault();
						event.stopImmediatePropagation();
					$('.ui-datepicker-buttonpane .ui-datepicker-close').on('click',function() {
						$('.ui-datepicker-calendar').detach();
						thisCalendar.trigger('change');
						
					
						
		});
			});
		});

		

		$(".yield_daily_datepicker").each(function(){			
			$(this).datepicker({
				showOn: "button",
				buttonImage: "assets/images/calendar.png",
				buttonImageOnly: true,
				buttonText: "Select date",
				showAnim: 'slide',
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy/mm/dd',
				minDate:$(this).data('first'),
				maxDate: $(this).data('last'),
				yearRange: $(this).data('first').split('/')[0]+':'+$(this).data('last').split('/')[0],
				beforeShowDay:($(this).data('type')=='map')?null:DisableSpecificDates,
				beforeShow: function(input, inst) {

					$(inst.dpDiv).removeClass(function() {
					return $(this).attr('class').split(' ').pop() 
					});

					if($(inst.dpDiv).hasClass('yeimon_calendar')){
						
						$(inst.dpDiv).removeClass('yeimon_calendar');
					}
				
					$(inst.dpDiv).addClass($(this).attr('class').split(' ').pop());
				}
			});
		});
	};

/*this.UpdateDaily_Yield_Date = function(elm,value){
	if(JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type=='yield_daily'){
			this.UpdateDaily_Yield_Date(elm,$(elm).val());
		
		}
setTimeout(function(){ $('.yield_daily_datepicker').val(value);}, 1000);

       
};*/

function DisableSpecificDates(date) {
var current_chartcode_arr = $(this).data('value').split('-');
		var current_chartcode_main = current_chartcode_arr[0];
		var disableddates = [];

		$.each(JMA.JMAChart.Charts[$(this).data('chartindex')].Conf.charts_fields_available[current_chartcode_main],function(label_main,sub_labels){
			$.each(sub_labels,function(label_sub,code){
				disableddates.push(label_sub);
				

			});
		});

var m = (date.getMonth()+1).toString();
 var d = date.getDate().toString();
 var y = date.getFullYear();
var currentdate = y + '/' + (m[1]?m:"0"+m[0]) + '/' + (d[1]?d:"0"+d[0]) ;
for (var i = 0; i < disableddates.length; i++) {
 if ($.inArray(currentdate, disableddates) != -1 ) {
 return [true];
 }else{
return [false];
 } 
 }
var weekenddate = $.datepicker.noWeekends(date);
return weekenddate; 
 }
 
 
 
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


        //$('.exhibit-tab-footer').addClass('tab_footer_series');  
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

		if((JMA.JMAChart.Charts[chart_index].Conf.chart_data_type).match('^yield_')){
			JMA.JMAChart.Load_YieldDatePicker();
			if(series_idx==0){
				var clr="dynamic_red";
			}else if(series_idx==1){
				var clr="dynamic_blue";
			}else if(series_idx==2){
				var clr="dynamic_orange";
			}
			$('.yield_daily_datepicker:eq('+series_idx+')').addClass(clr);
			$('.yield_monthly_datepicker:eq('+series_idx+')').addClass(clr);
		}


		
		return el.style.color = $Seriescolor;
		
	};





	
	this.reverseYAxis = function(p_chart_idx,idx){
				var reversedAxis_=[];
				if($('#reverse_checkbox__'+p_chart_idx).is(':checked')){
				JMA.JMAChart.Charts[p_chart_idx].Conf.reverseYAxis=true;
				}else{
				JMA.JMAChart.Charts[p_chart_idx].Conf.reverseYAxis=false;
				}

				$.each($("input[name='reverse_checkbox']:checked"), function(){            
				reversedAxis_.push(parseInt($(this).val()));
				});

				JMA.JMAChart.Charts[p_chart_idx].Conf.reversedAxis_=reversedAxis_;

				//localStorage.setItem("reversedAxis", reversedAxis);
				//console.log(localStorage.getItem("reversedAxis"));

if(idx==undefined){
idx=0;
var reversed = JMA.JMAChart.Charts[p_chart_idx].chart_object.yAxis[idx].reversed;
//if((JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type).match('^yield_')){
for(var idx=0; idx<JMA.JMAChart.Charts[p_chart_idx].chart_object.yAxis.length; idx++) {
JMA.JMAChart.Charts[p_chart_idx].chart_object.yAxis[idx].update({ reversed: !reversed });
}	
}else{
var reversed = JMA.JMAChart.Charts[p_chart_idx].chart_object.yAxis[idx].reversed;
JMA.JMAChart.Charts[p_chart_idx].chart_object.yAxis[idx].update({ reversed: !reversed });
}
reversed = !reversed;
	};
	
	// Switch to barchart
	this.switchToBarChart = function(p_chart_idx,p_element){
		if($(p_element).is(':checked') && !$('#multiaxis_checkbox__'+p_chart_idx).is(':checked')){
		this.switchGraph(p_chart_idx,'bar');
		}else if($(p_element).is(':checked') && $('#multiaxis_checkbox__'+p_chart_idx).is(':checked')){
			this.switchGraph(p_chart_idx,'multiaxisbar');
		}else if(!$(p_element).is(':checked') && $('#multiaxis_checkbox__'+p_chart_idx).is(':checked')){
			this.switchGraph(p_chart_idx,'multiaxisline');
		}else{
			this.switchGraph(p_chart_idx,'line');
		}
		var isBig  = window.matchMedia( "(max-width: 991px)" );
		if(isBig.matches){
			$('#Chart_Dv_placeholder_'+p_chart_idx).find('.h_graph_tab_area, .nav_editab').addClass('active');
		}
		$("div.input-group-addon i.fa-minus").trigger('click');
	};
	
	// Switch to multiaxisline
	this.switchToMultiAxisLine = function(p_chart_idx,p_element){
		if($(p_element).is(':checked') && !$('#barchart_checkbox__'+p_chart_idx).is(':checked')){
			this.switchGraph(p_chart_idx,'multiaxisline');
		}else if($(p_element).is(':checked') && $('#barchart_checkbox__'+p_chart_idx).is(':checked')){
			this.switchGraph(p_chart_idx,'multiaxisbar');
		}else if(!$(p_element).is(':checked') && $('#barchart_checkbox__'+p_chart_idx).is(':checked')){
			this.switchGraph(p_chart_idx,'bar');
		}else{
			this.switchGraph(p_chart_idx,'line');
		}
		var isBig  = window.matchMedia( "(max-width: 991px)" );
		if(isBig.matches){
			$('#Chart_Dv_placeholder_'+p_chart_idx).find('.h_graph_tab_area, .nav_editab').addClass('active');
		}
		$("div.input-group-addon i.fa-minus").trigger('click');
	};
	
	// Download chart data
	this.downloadChartData = function(p_chart_idx) {

		var jq_frm_obj = $('#frm_download_chart_data_'+p_chart_idx);
		// JMA.JMAChart.Charts[p_chart_idx].Conf.isPremiumData
		var cht_codes_str = JMA.JMAChart.Charts[p_chart_idx].Conf.current_chart_codes.toString();
		if(JMA.JMAChart.Charts[p_chart_idx].Conf.chartType=='map'){
			var $default_year=$('#default_year_'+p_chart_idx).find('option:selected').val();
			jq_frm_obj.append('<input type="hidden" name="default_year" value="'+$default_year+'">');
		}
		jq_frm_obj.find('#frm_input_download_chart_codes_'+p_chart_idx).attr('value',cht_codes_str);
		jq_frm_obj.find('#frm_input_download_chart_datatype_'+p_chart_idx).attr('value',JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type);
		var timeStamp = Math.floor(new Date().getTime() / 1000);

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
			//var currentUrl = $('#graph_share_url_'+p_chart_idx).val();
			//var str = ""+currentUrl+"";
			//var res = str.split('/').join('@'); 
			//var avoid = "@japanmacroadvisors@";
			//var test = res.replace(avoid, '');
			//var linkedInUrl = 'user/linkedinProcess/'+test+'code='+cht_codes_str+'datatype='+JMA.JMAChart.Charts[p_chart_idx].Conf.chart_data_type;
			//var linkedInUrl = 'user/linkedinProcess/'+res+'index='+p_chart_idx;
			//var linkedInUrl = 'user/linkedinProcess/'+str;
			var currentUrl;
			if($('#graph_share_url_'+p_chart_idx).val()){
				currentUrl = $('#graph_share_url_'+p_chart_idx).val();
			}
			else{
				currentUrl = window.location;
			}
			var str = ""+currentUrl+"";
			var linkedInUrl = 'user/linkedinProcess/?'+str;
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
		availableChartBooks : myChartParams.chartBookList,
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
	 	$('body').on('click', '.add-folder', function(e) {

	 		e.preventDefault();
	 		var $this = $(this);
	 		
	 		
	 		if(JMA.userDetails.hasOwnProperty('id') && JMA.userDetails.id>0) {
	 			$('#add-folder-name').val('');
	 			$('#modaladd_folder').modal('show');
	 		}else{
	 			JMA.User.showLoginBox('mychart',JMA.baseURL + JMA.controller + "/" + (JMA.action == "index" ? '' : JMA.action + "/")+JMA.params);
	 		}
	 		


	 		return false;
	 		
	 		

	 	});


	 	$('body').on('click', '.add-folder-name', function(e) {

	 		if ($("#add-folder-name").val().replace(/^\s+|\s+$/g, "").length != 0){

	 			var $this = $('.add-folder');
	 			self.createFolder($this,$('#add-folder-name').val());
	 			$('#modaladd_folder').modal('hide');
	 			return false;
	 		}
	 		
	 		
	 		
	 	
	});
	
	
		 	$('body').on('click', '.add-chartbook-name', function(e) {
				if ($("#add-chartbook-name").val().replace(/^\s+|\s+$/g, "").length != 0){
			
					var $this = $('.cbcadd_book');
					self.createChartBook($this,$('#add-chartbook-name').val());
					$('#modaladd_chaboo').modal('hide');
					//window.reload();
					return false;
				}
	         });
		   
		   $('body').on('click', '.del-chartbook-name' ,function(e) {
			   
				e.preventDefault();
				e.stopPropagation();
				var $this = $(this);
				var folderId = $this.data('id');
				self.deleteChartBook($this);
				$('#del_chartbook_'+folderId).modal('hide');
	 	   });
		   
		   
		   $('body').on('click', '.status-chartbook-name' ,function(e) {
			   
				e.preventDefault();
				e.stopPropagation();
				var $this = $(this);

				var bookstatus = $this.data('id');
				var strStatus = bookstatus.toString();
				var defEmail = strStatus.split('-');
				self.statusOfChartBook($this);
				//parent.window.location.reload();
				$('#status_chartbook_'+defEmail[1]).modal('hide');
	 	   });
		   

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

/*var tblclick=false;
$('body').on('click', '.exhibit-title', function(e) {


	
		if(tblclick == true){
				$(this).attr('contentEditable', 'true').focus();
				tblclick = false;
				return false;
		}else{
			tblclick = true;
		}
	});*/
	
	$('body').on('click', '.newclassforcb a', function(e) {
				
			    e.preventDefault();
				e.stopPropagation();
				$this = $(this);
				
				if(self.Config.flags.folderclick == true)
				{
					clearTimeout(self.Config.flags.folserClickTimeout);
					$this.find('span').attr('contentEditable', 'true').focus();
					self.Config.flags.folderclick = false;
					return false;
				}
				else
				{
					self.Config.flags.folderclick = true;
					self.Config.flags.folserClickTimeout = setTimeout(function(){
						self.Config.flags.folderclick = false;
						if(JMA.controller == 'mycharts' && JMA.action == 'listChartBook')
						{
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

		/*$('body').on('dblclick', '.exhibit-title', function(e){
			
			e.preventDefault();
			e.stopPropagation();
			$(this).attr('contentEditable', 'true').focus();
		});*/

		


        if(JMA.controller == 'mycharts' && JMA.action == 'listChartBook')
		{
			 if(JMA.userDetails.isAuthor == 'Y')
			 {
				var touchtime = 0;
				$('body').on('touchstart click tap', '.exhibit-title', function(e){

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
					self.saveThisChartBookTitle(order,uuid,title);

					$(this).attr('contentEditable', 'false');
				});
				
				$('body').on('click', '.description-chartbook-single', function(e) {
					
					e.preventDefault();
					e.stopPropagation();
					if($('#text_chartbook_desc').val() == "")
					{
						//$('#err_desc_cb').html("Please enter chart book description");
						$('#text_chartbook_desc').focus();
						return false;
					}
					
					var desc = $('#text_chartbook_desc').val();
					var folderId = window.location.hash.substring(1);
					self.updatehisChartBookDesc(desc,folderId);
					$('#chaboo_desc').modal('hide');
				});
				
				
			 } 
		}
        else
        {
			
			var touchtime = 0;
			$('body').on('touchstart click tap', '.exhibit-title', function(e){

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
		}  			
  
		
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

		$('body').on('blur', '.newclassforcb span', function(e) {
				
			    e.preventDefault();
				e.stopPropagation();
				var $this = $(this);
				self.renameChartBook($this);
				$(this).attr('contentEditable', 'false');
				//return false;
		});
		
		
		
		if(JMA.controller == 'mycharts' && JMA.action == 'listChartBook')
		{
			
			  /**
			 * @todo : Fix Chart editing
			 */	
			 
			/* $('a.content_leftside_parent span').click(function(e)
			{
				console.log("dgghdghgh");
				 e.preventDefault();
				 e.stopPropagation();
				 alert("tersrrrt");
				 
			}); */
			
             if(JMA.userDetails.isAuthor == 'Y')
			 {
				 
				
			 $('body').on('touchstart click tap', '.noteContent', function(e) {
				$this = $(this);
				$this.attr('contenteditable', true).focus();
				self.SortableList.option('disabled',true);
				var elnId = $this.attr('id');
						//var order = $this.parent('.exhibit').data('order');
						var uuid = $this.parent('.exhibit').data('uuid');
						var order = self.getIndexByUuid(uuid);
						self.myFolder.currentFolder.charts[order].note_object = null;
						if(self.myFolder.currentFolder.charts[order].note_object == null) {
						//	CKEDITOR.disableAutoInline = true;
						self.myFolder.currentFolder.charts[order].note_object = new tinymce.Editor(elnId, {
																				//theme: 'inlite',
													  //plugins: 'image table link paste contextmenu textpattern autolink',
													  //insert_toolbar: 'quickimage quicktable',
													  //selection_toolbar: 'bold italic | quicklink h2 h3 blockquote',
													  //inline: true,
													  //paste_data_images: true,
													  plugins: "lists advlist paste",
													  advlist_bullet_styles: "disc",
													  theme_advanced_toolbar_align : "left",
													  menubar:false,
													  statusbar: false,
													  branding: false,
													  paste_as_text: true,
													  //fixed_toolbar_container: '#mytoolbar',
													  font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;', 
                                                      fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 20pt',
													  toolbar: 'bold underline | bullist | fontselect fontsizeselect | alignleft aligncenter alignright alignjustify',
													  setup: function(editor) {
														        editor.on('init', function() 
																{
																	this.getDoc().body.style.fontSize = '16pt';
																	this.getDoc().body.style.fontFamily = 'arial';
																	editor.focus();
																	
																});
															   function characterCount() {
																	 var txt = tinyMCE.activeEditor.getContent();
																	 var strip = (tinyMCE.activeEditor.getContent()).replace(/(<([^>]+)>)/ig,"");
                                                                     var text =  strip.length + "Characters"
																	 tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id), text);

                                                                     id_txt = tinyMCE.activeEditor.id;
																	 txt = txt.replace(/(<([^>]+)>)/ig,"");
                                                                     txt = txt.replace(/&nbsp;/g,"");
																	 if(txt.length>600)
																	 {
																		 console.log(txt.length);
																		 alert('You have exceeded the character limits.');
																		 //preventDefault();
																		 return false;
																	 }
																}
														    editor.on('keypress',function(event) {
																characterCount(); 
															});	
															editor.on('blur', function(event) {
															//console.log(tinymce.activeEditor.getContent());
															    //characterCount(); 
																self.saveThisNoteContent(order,uuid);
																self.SortableList.option('disabled',false);
																//$this.attr('contenteditable', false);
																editor.remove();
																return false;
																//tinymce.remove(tinyMCE.activeEditor.id);
																//tinymce.execCommand('mceRemoveEditor', false, tinyMCE.activeEditor.id);
																//$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").hide();
																//window.location.reload();
															});	
															/*editor.on('focus', function(event) {
																alert(1);
																//self.myFolder.currentFolder.charts[order].note_object.render();	
																editor.show();
															});*/	
														}
													}, tinymce.EditorManager);
									
									self.myFolder.currentFolder.charts[order].note_object.render();			
						e.preventDefault();
						e.stopPropagation();
					}
				});
				
			 }
		}
		else
		{
			
			
			
			/**
			 * @todo : Fix Chart editing
			 */		
			 $('body').on('touchstart click tap', '.noteContent', function(e) {
				 var ImageUploadUrl;
				 var pluginUrl;
				 if(location.hostname == "localhost")
				 {
					 ImageUploadUrl = window.location.origin+"://JMA-LIVE/admin/postAcceptor.php";
					 pluginUrl = window.location.origin+"://JMA-LIVE/admin/js/tinymce-line-height-plugin-master/lineheight/plugin.min.js";
				 }
				 else
				 {
					 ImageUploadUrl = window.location.origin+"://admin/postAcceptor.php";
					 pluginUrl = window.location.origin+"://admin/js/tinymce-line-height-plugin-master/lineheight/plugin.min.js";
				 }
				$this = $(this);
				$this.attr('contenteditable', true).focus();
				self.SortableList.option('disabled',true);
				var elnId = $this.attr('id');
						//var order = $this.parent('.exhibit').data('order');
						var uuid = $this.parent('.exhibit').data('uuid');
						var order = self.getIndexByUuid(uuid);
						self.myFolder.currentFolder.charts[order].note_object = null;
						if(self.myFolder.currentFolder.charts[order].note_object == null) {
						//	CKEDITOR.disableAutoInline = true;
						self.myFolder.currentFolder.charts[order].note_object = new tinymce.Editor(elnId, {
														
													    paste_data_images: true,
														plugins: [
															"advlist autolink lists link image charmap print preview hr anchor pagebreak lineheight",
															"searchreplace wordcount visualblocks visualchars code fullscreen",
															"insertdatetime media nonbreaking save table contextmenu directionality",
															"emoticons template paste textcolor colorpicker textpattern"
														],
														
                                                      
													 /*  plugins: "lists advlist paste",*/
													  advlist_bullet_styles: "disc",
													  theme_advanced_toolbar_align : "left",
													  menubar:false,
													  statusbar: false,
													  branding: false, 
													  paste_as_text: true, 
													  //fixed_toolbar_container: '#mytoolbar',
													  font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;', 
                                                      fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 20pt',
														toolbar: "bold underline | bullist | fontselect fontsizeselect | alignleft aligncenter alignright alignjustify | image",

													automatic_uploads: true,  
													image_advtab: true,
													image_title: true, 
													images_upload_url: ImageUploadUrl,
													file_picker_types: 'image', 
													 external_plugins: {
														'lineheight': pluginUrl
													},

													 setup: function(editor) {
														        editor.on('init', function() 
																{
																	this.getDoc().body.style.fontSize = '16pt';
																	this.getDoc().body.style.fontFamily = 'arial';
																	editor.focus();
																	
																});
																
																
															    function characterCount() {
																   
																	var txt = tinyMCE.activeEditor.getContent();
																	
																	var regex = /<img.*?src="(.*?)"/gi, result, indicesNew = [];

																	while ((result = regex.exec(txt))) {
																		indicesNew.push(result[1]);
																	}
																	 
																	 var strip = (tinyMCE.activeEditor.getContent()).replace(/(<([^>]+)>)/ig,"");
                                                                     var text =  strip.length + "Characters"
																	 tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id), text);

                                                                     id_txt = tinyMCE.activeEditor.id;
																	 txt = txt.replace(/(<([^>]+)>)/ig,"");
                                                                     txt = txt.replace(/&nbsp;/g,"");
																	 if(indicesNew.length == 1 &&  txt.length>400)
																	 {
																	    console.log(txt.length);
																		alert('You have exceeded the character limits.');
																		event.preventDefault();
																		event.stopPropagation();
																		event.stopImmediatePropagation();
																	 }
																	
																	 if(indicesNew.length == 0 &&  txt.length>600)
																	 {
																		console.log(txt.length);
																		alert('You have exceeded the character limits.');
																		event.preventDefault();
																		event.stopPropagation();
																		event.stopImmediatePropagation();
																	 }
																	
																	if(indices.length==3 && txt.length> 0)
																	{
																		 alert('You have exceeded the character limit. Please delete an image to add text.');
																		 event.preventDefault();
																		 event.stopPropagation();
																		 event.stopImmediatePropagation();
																	}
																	 
																	 
																}
																editor.on('click',function(event) {
																	var rawString = tinyMCE.activeEditor.getContent();

															        var regex = /<img.*?src="(.*?)"/gi, result, indices = [];

																	while ((result = regex.exec(rawString))) {
																		indices.push(result[1]);
																	}
																	
																	if(indices.length > 4)
																	{
																		 alert('You have exceeded the image upload limits. Please remove one of the images.');
																		 event.preventDefault();
																		 event.stopPropagation();
																		 event.stopImmediatePropagation();
																	}
																	
																	
																	
																});
														    editor.on('keypress',function(event) {
																
																/* var rawString = '<a>This is sample</a><img src="example1.com" /></br><img src="example2.com" /><p>String ends.</p>'; */
																
																
																characterCount(); 
															});	
															editor.on('blur', function(event) {
															//console.log(tinymce.activeEditor.getContent());
															    //characterCount(); 
																self.saveThisNoteContent(order,uuid);
																self.SortableList.option('disabled',false);
																//$this.attr('contenteditable', false);
																editor.remove();
																return false;
																//tinymce.remove(tinyMCE.activeEditor.id);
																//tinymce.execCommand('mceRemoveEditor', false, tinyMCE.activeEditor.id);
																//$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").hide();
																//window.location.reload();
															});	
															/*editor.on('focus', function(event) {
																alert(1);
																//self.myFolder.currentFolder.charts[order].note_object.render();	
																editor.show();
															});*/	
														}
													}, tinymce.EditorManager);
									
									self.myFolder.currentFolder.charts[order].note_object.render();	
									//console.log(self.myFolder.currentFolder.charts[order].note_object);
						e.preventDefault();
						e.stopPropagation();
					}
				});
		}
		


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
$('body').on('keydown','.folder-span-name ,#add-folder-name',function(e){
	if ((e.which == 13) || (e.which != 8 && e.which != 37 && e.which != 39 && e.which != 46 && $(this).text().length > 16)) {
		e.preventDefault();
	}
});	


$('body').on('keydown','.folder-span-name ,#add-chartbook-name',function(e){
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



if(JMA.controller == 'mycharts' && JMA.action == 'index'){
			// Event bindings
			// Folder Link
			
			
			$('body').on('click','.latest_update_chart', function(e) {
				  
                  e.preventDefault();
				  e.stopPropagation();
				  $('.update_modal_charts').modal('hide');
				  var folderId = window.location.hash.substring(1);
				  
				  self.updateThisFolderLatestData(folderId);
				  
				  return false;
				  
				  //self.editThisFolderContent('chart',order,uuid);
				  
				 // self.updateThisFolderLatestData(folderId);
			});
			
			
			$('body').on('click','.exhibit-tab li', function(e) {

				e.preventDefault();
				e.stopPropagation();

				var view = $(this).data('view');
				var chartOrder = $(this).data('order');
				var $exhibit = $(this).closest('.exhibit');
				$(".foldercontent-sub-menu").hide();
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

				$(this).next('.foldercontent-sub-menu').slideToggle("fast",function(){
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
				this.initiateCurrentFolder(folderId);
				window.location.hash = '#'+folderId;
			}else{

				var $folder = $('li.sub-menu.folders li.folder [data-id="'+folderId+'"]').parents('li.sub-menu.folders li.folder');
				if($folder.length == 0){
					var $folder_first = $('li.sub-menu.folders li.folder').first();
					var folderId_first = $folder_first.find('a span').data('id');
					$folder_first.addClass('selected');
					this.initiateCurrentFolder(folderId_first);
					window.location.hash = '#'+folderId_first;
				}else{
					$folder.addClass('selected');
					
					//this.initiateSmallCurrentFolder(folderId);
					
					//this.initiateCurrentFolderListView(folderId);
					this.initiateCurrentFolder(folderId);
				}
				
			}

		}
		
		if(JMA.controller == 'mycharts' && JMA.action == 'listChartBook'){
			
			
			
			$('body').on('click','.exhibit-tab li', function(e) {

				e.preventDefault();
				e.stopPropagation();

				var view = $(this).data('view');
				var chartOrder = $(this).data('order');
				var $exhibit = $(this).closest('.exhibit');
					$(".foldercontent-sub-menu").hide();
				$exhibit.find('.exhibit-tab li').removeClass('selected');

				$(this).addClass('selected');

				if('data' == view) {
					self.switchThisChartBooksViewType(view,chartOrder);
					$exhibit.find('.table-view').removeClass('hide');
					$exhibit.find('.graph-view').addClass('hide');
					self.myFolder.currentFolder.charts[chartOrder].drawThisDataOnTable();
				} else {
					self.switchThisChartBooksViewType(view,chartOrder);
					$exhibit.find('.table-view').addClass('hide');
					$exhibit.find('.graph-view').removeClass('hide');
				}
			});
			
			
			$('body').on('click', '.chart_edit' , function(e) {
				e.preventDefault();
				e.stopPropagation();
				var $curEx =  $(this).closest('.exhibit');
				var order = $curEx.data('order');
				var uuid = $curEx.data('uuid');
				self.editThisFolderContent('chart',order,uuid);

			});
			
			var folderId = window.location.hash.substring(1);
			this.initiateCurrentChart(folderId);
			
			$('body').on('click', '.save_to_chart_chart' , function(e) {
				$.ajax({
					url : JMA.baseURL + "mycharts/saveChartBookToMychart",
					dataType : 'json',
					type : 'POST',
					data : {'folder_id' : folderId},
					beforeSend: function() { JMA.showLoading(); },
					success : function(response){
						console.log(response.result);
						/* return false; */
						if(response.status!=1){
							JMA.handleErrorWithMessage(response.message);
						}else{
							 $("#save_chartbook_to_mychart").modal("show");
							var content = '<li class="folder"><a href="mycharts/#'+response.result.id+'"><i class="fa fa-folder"></i> <span contentEditable="false" data-foldername="'+response.result.name+'" data-id="'+response.result.id+'">'+response.result.name+'</span></a><span class="del">&nbsp;<i class="fa fa-trash"></i></span></li>'; 
							 
							 $('.add-folder').before(content);
							 
						}
						JMA.hideLoading();
					},
					error : function(){
						JMA.showLoading();
						JMA.hideLoading();
					}
				});	
				
				
			});
			
			

			
			
			
			
			
			var $prevEx = null;
			$('body').on('touchstart click', '.chart_options' , function(e) {

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
			
			
			$('body').on('click', function(e) {
				var container = $(".foldercontent-sub-menu");

				    if (!container.is(e.target) // if the target of the click isn't the container...
				        && container.has(e.target).length === 0) // ... nor a descendant of the container
				    {
				    	container.hide();
				    }			
				});
				
				
			
			$('body').on('click', '.duplicate', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$this = $(this);
				self.duplicateThischartBookContent($this);
			   });
			   
			   
			 $('body').on('click', '.delete-ex', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$this = $(this);
				self.deleteThisChartBookContent('chart',$this);
			});  
			
			$('body').on('click', '.make-note-ex', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$this = $(this);
				self.createNewChartBooksContent('note',$this);
				//var $exhibit = $(this).closest('.exhibit');

				//var note =  '<div class="exhibit note"> <h4 class="exhibit-title" contenteditable="false">Note:</h4> <textarea name="" id="" cols="30" rows="10"></textarea> <div class="over-lay-ctrl hide"> <div class="ctrls"> <ul> <li class="duplicate"><a href="#"><i class="fa fa-copy"></i>Duplicate</a></li><li class="make-note-ex"><a href="#"><i class="fa fa-file-o"></i>Make a note</a></li><li  class="delete-note-ex"><a href="#"><i class="fa fa-remove"></i>Delete</a></li></ul> </div></div></div>';
				//$exhibit.after(note);

			});
			
			$('body').on('click', '.delete-note-ex', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$this = $(this);
				self.deleteThisChartBookContent('note',$this);
			});	
			
			
			$('body').on('click', 'li.fpt_list', function(e) {
				//e.preventDefault();
				//e.stopPropagation();
				

				$( "div#fpt_list" ).find("div" ).remove();

				
				var folderId = window.location.hash.substring(1);
				
				self.initiateCurrentChartBookListView(folderId);
			});

			$('body').on('click', 'li.fpt_large', function(e) {
				//e.preventDefault();
				//e.stopPropagation();
				$('#Dv_folder_content').empty();$('#Dv_folder_content').empty();
				var folderId = window.location.hash.substring(1);
				
				self.initiateCurrentChart(folderId);
			});		

			$('body').on('click', 'li.fpt_small', function(e) {
				//e.preventDefault();
				//e.stopPropagation();
				var folderId = window.location.hash.substring(1);
				$('#Dv_folder_content_smallView').empty();
				self.initiateSmallCurrentChartBook(folderId);
			});	

			
		}
		
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
	 		//beforeSend: function() { JMA.showLoading(); },
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
	 * Function saveLatestChartBookContentOrder()
	 * Function to save latest folder content order. Calls on every sort action - drag and drop
	 */
	 this.saveLatestChartBookContentOrder = function(){
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
	 		url : JMA.baseURL + "mycharts/chartbook/reorder",
	 		dataType : 'json',
	 		type : 'POST',
	 		data : {'new_order' : new_order_array, 'folder_id' : self.myFolder.currentFolder.id},
	 		//beforeSend: function() { JMA.showLoading(); },
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
			sort: true,
			onEnd: function (evt) {
			//console.log('onAdd.foo:', [evt.item, evt.from]);
			JMA.myChart.myFolder.currentView='smallView';
			self.saveLatestFolderContentOrder();
			self.reorderSmallView();
			$('.ftps_holconmin').each(function(i,el) {
				$(this).find('div.page-title h4').html("PAGE "+(i+1)+" <i class='fa fa-arrows' aria-hidden='true'></i><b class='page_downseparate small-view'><i class='fa fa-download'></i> Download page "+(i+1)+" to Powerpoint</b>");

			});

		}
	});

		[].forEach.call(container.getElementsByClassName('ftps_holcon'), function (el){
			self.SortableList = new Sortable(el, {
				group: 'photo',
				ghostClass: 'sortable-ghost',
				group: 'words',
				sort: true,
				draggable:  '.exhibit',
				scroll : true,
				animation: 150,
				pull: true,
				put: true,

				onAdd: function (evt){ 


			/*if ((evt.oldIndex % 2)!=0) { 
				if(evt.newIndex==0){
			$(evt.item.nextSibling).appendTo(evt.from);	
				
			}
			}else{
				if(evt.newIndex==0){
			$(evt.item.nextSibling).appendTo(evt.from);	
				
			}	
		}*/



		


			/*if((evt.item.parentElement.childElementCount)==5){
			console.log(evt);
		if(evt.from.children.length==3){
			if(evt.newIndex==0){
			$(evt.item.nextSibling).appendTo(evt.from);	
				console.log('g');
			}else if(evt.newIndex==1){
			$(evt.item.previousElementSibling).appendTo(evt.from);	
				console.log('gg');
			}else {
			$(evt.item.parentElement.children[0]).appendTo(evt.from);
			console.log('ggg');
			}
			
		}
		//$(evt.item.parentElement.children[4]).prependTo(evt.item.offsetParent.offsetParent.nextSibling.lastChild);
		//old $(evt.item.parentElement.children[4]).prependTo(evt.from);
		
		}else{
			//alert(evt.oldIndex);
			//alert(evt.newIndex);
			//var findindex=(evt.newIndex==0)?1:(evt.newIndex-1);
			//	$(evt.item.parentElement.children[findindex]).appendTo(evt.from);
			
		}*/

	},
	onEnd: function (evt) {
		JMA.myChart.myFolder.currentView='smallView';
		if(JMA.controller == "mycharts" &&  JMA.action == "listChartBook")
		{
			self.saveLatestChartBookContentOrder();
		}
        else
		{
			self.saveLatestFolderContentOrder();
		}
		self.reorderSmallView();


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
	 this.createFolder = function($this,folder_name){

	 	try{
	 		if(JMA.userDetails.hasOwnProperty('id') && JMA.userDetails.id>0) {
	 			if(self.isCreateFolderAllowed() == true){
	 				var user_id = JMA.userDetails.id;
	 				var folder_name =(folder_name!='')?folder_name:"My Folder";
	 				
	 				$.ajax({
	 					url : JMA.baseURL + "mycharts/folder/create",
	 					dataType : 'json',
	 					type : 'POST',
	 					data : {'folder_name' : folder_name,'user_id' : user_id},
	 					beforeSend: function() { JMA.showLoading(); },
	 					success : function(response){
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
								//Old
								//var content = '<li class="folder list-group-item"><a href="mycharts/#'+response.result.folder_id+'"><i class="fa fa-folder"></i> <span contentEditable="false" data-foldername="My Folder" data-id="'+response.result.folder_id+'">My Folder</span></a><span class="del">&nbsp;<i class="fa fa-trash"></i></span></li>';
								var content = '<li class="folder"><a href="mycharts/#'+response.result.folder_id+'"><i class="fa fa-folder"></i> <span contentEditable="false" data-foldername="'+folder_name+'" data-id="'+response.result.folder_id+'">'+folder_name+'</span></a><span class="del">&nbsp;<i class="fa fa-trash"></i></span></li>';
								$this.before(content);
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
	 * Function createChartBook
	 */
	 this.createChartBook = function($this,folder_name){
	 	try{
	 		if(JMA.userDetails.hasOwnProperty('id') && JMA.userDetails.id>0) {
	 			if(self.isCreateFolderAllowed() == true){
	 				var user_id = JMA.userDetails.id;
	 				var folder_name =(folder_name!='')?folder_name:"My Folder";
	 				
	 				$.ajax({
	 					url : JMA.baseURL + "mycharts/chartbook/create",
	 					dataType : 'json',
	 					type : 'POST',
	 					data : {'book_name' : folder_name,'user_id' : user_id},
	 					beforeSend: function() { JMA.showLoading(); },
	 					success : function(response){
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
								
								var content = '<li class="submenu_leftside list-group-item newclassforcb"><i id = "change_status_icon_'+response.result.folder_id+'" class="fa fa-book" aria-hidden="true"  data-toggle="modal" data-target="#status_chartbook_'+response.result.folder_id+'"></i><a data-id="'+response.result.folder_id+'" href="mycharts/listChartBook/#'+response.result.folder_id+'" class=" content_leftside_parent"><span data-id = "'+response.result.folder_id+'" contenteditable="false">'+folder_name+'</span></a><i class="fa fa-trash" aria-hidden="true" data-toggle="modal" data-target="#del_chartbook_'+response.result.folder_id+'"></i> </li><div class="modal fade" id="del_chartbook_'+response.result.folder_id+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog modal-sm" role="document"><div class="modal-content"> <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel">Delete Chart Book</h4></div><div class="modal-body">Click on the delete button to delete the chartbook.</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" data-id="'+response.result.folder_id+'" class="btn btn-primary del-chartbook-name">Delete</button> </div></div></div></div><div class="modal fade" id="status_chartbook_'+response.result.folder_id+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-sm" role="document"><div class="modal-content"> <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel">Status Chart Book</h4> </div><div class="modal-body">Click on the ACTIVE button to ACTIVE the chartbook.</div> <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" data-id="ACTIVE-'+response.result.folder_id+'" class="btn btn-primary status-chartbook-name">ACTIVE</button></div></div></div></div>'
								
								//$this.before(content);
								
								$('.list-chartbook').prepend(content);
								
								if(document.getElementsByClassName('newclassforcb').length>3)
								{
									var lis = $("#list-bookforchart li.newclassforcb");
									if(lis.length >0) {
									   lis.eq(lis.length - 1).remove();
									}
									
									$('#showViewMoreCBlist').append('<a href="mycharts/list_chartbook" class="cbt_more"><img src="images/more-list.png"></a>');
									
								}
									
								if(JMA.controller == 'mycharts' && JMA.action ==  'list_chartbook')
								{
									window.location.reload();
								}
								else
								{
									self.getandUpdateAllChartBookList(
									function(){
										self.refreshChartBookListViewInAllDropDowns();
									  }
									);
								}
								
									
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
	 * Function renameFolder
	 */
	 this.renameChartBook = function($this){
	 	try{
	 		var folderId = $this.data('id');
	 		$.ajax({
	 			url : JMA.baseURL + "mycharts/chartbook/rename",
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
	 						self.getandUpdateAllChartBookList(
									function(){
										self.refreshChartBookListViewInAllDropDowns();
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
	 * Function getandUpdateLastBookList
	 * Get all folder list from server and update object
	 */
	 this.getAllCahrtBookList = function(){
	 	try{
	 		$.ajax({
	 			url : JMA.baseURL + "mycharts/collectAllchartbook",
	 			dataType : 'json',
	 			type : 'POST',
	 			data : {},
	 			beforeSend: function() { JMA.showLoading(); },
	 			success : function(response){
					
					var arr = [], len;
					$.each(response.result, function(key, value){
						 arr.push(key);
					});
					len = arr.length;
					if(len == 3)
					{
						$('#showViewMoreCBlist').empty();
					}

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
	 * Function getandUpdateLastBookList
	 * Get all folder list from server and update object
	 */
	 this.getandUpdateLastBookList = function(){
	 	try{
	 		$.ajax({
	 			url : JMA.baseURL + "mycharts/chartbook/getLatestCb",
	 			dataType : 'json',
	 			type : 'POST',
	 			data : {},
	 			beforeSend: function() { JMA.showLoading(); },
	 			success : function(response){
					$.each(response.result, function(key, value){
						
						var content = '<li class="submenu_leftside list-group-item newclassforcb"><i id = "change_status_icon_'+value.folder_id+'" class="fa fa-book ';
						if(value.status == 'ACTIVE')
						{
							content+= ' active';
						}
						content+= '" aria-hidden="true"  data-toggle="modal" data-target="#status_chartbook_'+value.folder_id+'"></i><a data-id="'+value.folder_id+'" href="mycharts/listChartBook/#'+value.folder_id+'" class=" content_leftside_parent">'+value.folder_name+'</a><i class="fa fa-trash" aria-hidden="true" data-toggle="modal" data-target="#del_chartbook_'+value.folder_id+'"></i> </li><div class="modal fade" id="del_chartbook_'+value.folder_id+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog modal-sm" role="document"><div class="modal-content"> <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel">Delete Chart Book</h4></div><div class="modal-body">Click on the delete button to delete the chartbook</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" data-id="'+value.folder_id+'" class="btn btn-primary del-chartbook-name">Delete</button> </div></div></div></div><div class="modal fade" id="status_chartbook_'+value.folder_id+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog modal-sm" role="document"><div class="modal-content"> <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel">Delete Chart Book</h4> </div><div class="modal-body">Click on the '+value.status+' button to '+value.status+' the chartbook.</div> <div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" data-id="'+value.status+'-'+value.folder_id+'" class="btn btn-primary status-chartbook-name">'+value.status+'</button></div></div></div></div>';
						
						$('.cbcadd_book').before(content);
						
						
					});
					
	 				/* self.myFolder.availableChartBooks = response.result;
	 				if(typeof(callBack) == 'function'){
	 					callBack();
	 				} */
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
	 * Function getandUpdateAllChartBookList
	 * Get all folder list from server and update object
	 */
	 this.getandUpdateAllChartBookList = function(callBack){
	 	try{
	 		$.ajax({
	 			url : JMA.baseURL + "mycharts/chartbook/getallfolders",
	 			dataType : 'json',
	 			type : 'POST',
	 			data : {},
	 			beforeSend: function() { JMA.showLoading(); },
	 			success : function(response){
	 				self.myFolder.availableChartBooks = response.result;
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
	 * Function refreshChartBookListViewInAllDropDowns
	 * This function will refresh folder list in all dropdowns for save graph to.
	 */
	 this.refreshChartBookListViewInAllDropDowns = function(){
		// Handle no folder list
		var select_option_content = '';
		if(self.myFolder.availableChartBooks.length == 0){
			select_option_content+= "";
		}else{
			$.each(self.myFolder.availableChartBooks,function(idx,folderDetails){
				/* if(idx<JMA.userDetails.user_permissions.mychart.totalFolders){
					select_option_content+="<option value='"+folderDetails['folder_id']+"'>"+folderDetails['folder_name']+"</option>";
				} */
				select_option_content+="<option value='"+folderDetails['folder_id']+"'>"+folderDetails['folder_name']+"</option>";
			});
		}
		$('.chartBook-select-addto-folder').html(select_option_content);
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
	 * Functionn deleteChart Book
	 */
	 this.deleteChartBook = function($this){
	 	try{
			
			
			var folderId = $this.data('id');
			
	 		if(typeof(folderId) == 'undefined'){
	 			JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
	 		}else{
	 			$.ajax({
	 				url : JMA.baseURL + "mycharts/chartbook/delete",
	 				dataType : 'json',
	 				type : 'POST',
	 				data : { folder_id: folderId },
	 				beforeSend: function() { JMA.showLoading(); },
	 				success : function(response){
	 					if(response.status!=1){
	 						JMA.handleErrorWithMessage(response.message);
	 					}else{
							
							if(JMA.controller == 'mycharts' && JMA.action ==  'list_chartbook')
							{
								window.location.reload();
							}
							
							$('#change_status_icon_'+folderId).parent().remove();
							
							self.getandUpdateAllChartBookList(
									function(){
										self.refreshChartBookListViewInAllDropDowns();
									}
							);
							
							console.log(document.getElementsByClassName('newclassforcb').length);
							
							if(document.getElementsByClassName('newclassforcb').length>1)
							{
								self.getandUpdateLastBookList();
								
								self.getAllCahrtBookList();
								
							}
							
							
							/* 
							
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
						} */
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
	 * Functionn Change status Chart Book
	 */
	 this.statusOfChartBook = function($this){
	 	try{
			
			   
			
			    var bookstatus = $this.data('id');
				var strStatus = bookstatus.toString();
				var defEmail = strStatus.split('-');
				
				var folderId = defEmail[1];
				
				var folderStatus = defEmail[0];
			
	 		if(typeof(folderId) == 'undefined'){
	 			JMA.User.showUpgradeBoxForPremiumFeature('premium',0);
	 		}else{
	 			$.ajax({
	 				url : JMA.baseURL + "mycharts/chartbook/status",
	 				dataType : 'json',
	 				type : 'POST',
	 				data : { folder_id: folderId , folder_status: folderStatus },
	 				beforeSend: function() { JMA.showLoading(); },
	 				success : function(response){
	 					if(response.status!=1){
	 						JMA.handleErrorWithMessage(response.message);
	 					}else{
							console.log(folderId);
							var folderIdssss = $('#status_chartbook_'+folderId).empty();
							
							var satus = 'ACTIVE';
							var newStatus = 'ACTIVATE';
							var originalStatus = 'ACTIVE';
							
							if(folderStatus == 'ACTIVE')
							{
								var originalStatus = 'INACTIVE';
								var satus = 'DEACTIVE';
								var newStatus = 'DEACTIVATE';
							}
							
							var content = '<div class="modal-dialog modal-sm" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel">Status Chart Book</h4> </div><div class="modal-body">Click on the '+satus+' button to '+newStatus+' the chartbook.</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" data-id="'+originalStatus+'-'+folderId+'" class="btn btn-primary status-chartbook-name">'+newStatus+'</button> </div></div> </div>';
							
							$('#status_chartbook_'+folderId).append(content);
							
							if(satus == 'ACTIVE')
							{
								$('#change_status_icon_'+folderId).removeClass("active");								
							}
							else
							{
								$('#change_status_icon_'+folderId).addClass("active");
							}
							
							self.getandUpdateAllChartBookList(
									function(){
										self.refreshChartBookListViewInAllDropDowns();
									}
							);
							
							
							if(JMA.controller == "mycharts" && JMA.action == "list_chartbook")
							{
								window.location.reload();
							}
							
							//$('[data-id=' + folderId + ']').remove();
							/* return false;
							$this.prev('a').find('span').data('id');
							
							  .children("button.second").data('id')
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
						} */
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
	 * Funciton - initiateCurrentChart
	 * initiates and create current chaer book details and object
	 */
	 this.initiateCurrentChart = function(folderId){
		 
		self.myFolder.currentView = 'largeView';
	 	try{
			// Get list of charts for selected folder
			// create array or chart objects
			$.ajax({
				url : JMA.baseURL + "mycharts/chartbook/getthisfolderdata",
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



/**
	 * Funciton - initiateCurrentFolderListView
	 * initiates and create current folder details and object for list View
	 */
	 this.initiateCurrentChartBookListView = function(folderId){
	 	self.myFolder.currentView = 'listView';
	 	try{
			// Get list of charts for selected folder
			// create array or chart objects
			$.ajax({
				url : JMA.baseURL + "chart/getchartBookListdata",
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

	 				listview_content+='<div class="main-title list_minttl"><h1 class="">'+folderContent.folder_name+'</h4><div class="mttl-line"></div></div><div class="right-menus mychart_exppri"> <ul class="top-m list-inline"> <li> <a href="#" class="btn btn-primary print-mycharts"> <i class="fa fa-print"></i> <span>Print</span> </a> </li> </ul> <br/></div>';
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
	 			}else{
	 				var fa_icon="fa-table";
	 				var $edit_menu='<li><a draggable="false" href="#" class="mychart_download_data"><i class="fa fa-download"></i>Download data</a></li>'+
	 				'<li><a draggable="false" href="#" class="mychart_export"><i class="fa fa-file-photo-o"></i>Export</a></li><li class="mychart-menu-edit"><a draggable="false" href="#" class="chart_edit"><i class="fa fa-cog"></i>Edit</a></li>';
	 			}
	 			listview_content+='<div class="chart_listview exhibit" draggable="false" data-order="'+order+'" data-uuid="'+folderContent.uuid+'" ><ul class="list-inline"> <li class="serial">'+(order+1)+'</li><li><i class="fa '+fa_icon+'" aria-hidden="true"></i> '+folderContent.title+'</li>'+
	 			'<li> <ul class="list-unstyled" >';

	 			if(folderContent.chart_view_type!='note' && Array.isArray(folderContent.charts_fields_available) == true){

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

$('#fpt_list').html(listview_content);


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
	 * Funciton - initiateSmallCurrentChartBook
	 * initiates and create current folder details and object
	 */
	 this.initiateSmallCurrentChartBook = function(folderId){
	 	try{
			// Get list of charts for selected folder
			// create array or chart objects
			$.ajax({
				url : JMA.baseURL + "mycharts/chartbook/getthisfolderdata",
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
	'font-size': '15px'
},30);
$folder.animate({
	'font-size': '12px'
},30);
setTimeout(function(){
	$folder.animate({
		'font-size': '15px'
	},20);
	$folder.animate({
		'font-size': '12px'
	},20);
	$folder.find('i').removeClass('fa-folder-open');
	$folder.find('i').addClass('fa-folder');
	$folder.removeClass('fontColorOrange');
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
		reverseYAxis : JMA.JMAChart.Charts[chartIndex].Conf.reverseYAxis,
		reversedAxis_:JMA.JMAChart.Charts[chartIndex].Conf.reversedAxis_.map(Number),
		default_year : JMA.JMAChart.Charts[chartIndex].Conf.default_year,
		isMultiaxis :  ((JMA.JMAChart.Charts[chartIndex].Conf.chartType).match("multiaxis")) ? true : false ,
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
	 * Function -saveThisChartToBook
	 * Saves selected chart onto a monthly chart book.
	 */
	 this.saveThisChartToBook = function(chartIndex){
	 	try {
	 		var selectedFolder = $('#save_chartbook_select_folder_'+chartIndex).val();
			
	 		//if(self.isAddChartAllowed(selectedFolder) != true){
				
	 			var $highchart = $("#Chart_Dv_placeholder" + "_" + chartIndex ).find('.highcharts-container');
	 			var $clonee = $highchart.clone();
	 			//var $folder = $('li.submenu_leftside a [data-id="'+selectedFolder+'"]').parents('li.submenu_leftside');
				
				//var $folder = $('li.sub-menu.folders li.folder [data-id="'+selectedFolder+'"]').parents('li.sub-menu.folders li.folder');
				
				var $folder = $('li.chartbook_con li.submenu_leftside  [data-id="'+selectedFolder+'"]').parents('li.chartbook_con li.submenu_leftside');
				var newFolde =  $folder.offset();
				
	 			$clonee.css({
	 				position: 'absolute', 
	 				top: $highchart.offset().top, 
	 				left: $highchart.offset().left, 
	 				zIndex: 99999,
	 				border: '1px solid #333'
	 			});

	 			$('body').append($clonee);
				
				
                if(typeof  newFolde == 'undefined')
				{
					var topfixel  = 810;
					
					var leftFixel = 108;
				}
                else
                {
						if($folder.offset().top>1000)
						{
							var leftFixel = $folder.offset().left+4;
							var topfixel = ($folder.offset().top - 1000)+25;
						}
						else
						{
							var leftFixel = $folder.offset().left+4;
							var topfixel = $folder.offset().top;
						}
				}    					
				
				
				
	 			$clonee.animate({
	 				left: leftFixel,
	 				top: topfixel+8,
	 				opacity: 0.4,
	 				width: '10px',
	 				height: '10px'
	 			}, 1500,'easeInOutQuint', function() {
	 				$clonee.remove();
	 			});
				
				// setTimeout(function(){
				// 	$('html,body').animate({ scrollTop: 0 }, 1000);
				// }, 500);
$folder.find('#change_status_icon_'+selectedFolder).removeClass('fa-book');
$folder.find('#change_status_icon_'+selectedFolder).addClass('fa-book-open');
$folder.addClass('fontColorOrange');
$folder.animate({
	'font-size': '15px'
},30);
$folder.animate({
	'font-size': '12px'
},30);
setTimeout(function(){
	$folder.animate({
		'font-size': '15px'
	},20);
	$folder.animate({
		'font-size': '12px'
	},20);
	$folder.find('#change_status_icon_'+selectedFolder).removeClass('fa-book-open');
	$folder.find('#change_status_icon_'+selectedFolder).addClass('fa-book');
	$folder.removeClass('fontColorOrange');
}, 1600);



var tmp_first_chart_code = JMA.JMAChart.Charts[chartIndex].Conf.current_chart_codes[0];
var chart_uuid = JMA.generateUUID()+"-"+JMA.userDetails.id+selectedFolder;
var postData = {
	folder_id : selectedFolder,
	chart_data : {
		type : 'chart',
		chart_view_type : 'chart',
		uuid : chart_uuid,
		title : JMA.JMAChart.Charts[chartIndex].Conf.chart_labels_available[tmp_first_chart_code],
		chart_code : JMA.JMAChart.Charts[chartIndex].createChartCodeFromConfig(),
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
        reverseYAxis : JMA.JMAChart.Charts[chartIndex].Conf.reverseYAxis,
        reversedAxis_ : JMA.JMAChart.Charts[chartIndex].Conf.reversedAxis_.map(Number),
        default_year : JMA.JMAChart.Charts[chartIndex].Conf.default_year,
		isMultiaxis :  ((JMA.JMAChart.Charts[chartIndex].Conf.chartType).match("multiaxis")) ? true : false ,
		isNavigator : JMA.JMAChart.Charts[chartIndex].Conf.isNavigator,
		charts_fields_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_fields_available,
		charts_available : JMA.JMAChart.Charts[chartIndex].Conf.charts_available
	}
};

/* console.log(postData);

return false; */
				// Save data
				$.ajax({
					url : JMA.baseURL + "mycharts/chartbookList/addtofolder",
					dataType : 'json',
					type : 'POST',
					data : postData,
					beforeSend: function() { JMA.showLoading(); },
					success : function(response){
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
			// }
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
	 					$(grids).append('<div class="col-xs-12 pad0 page page-title"><div class="sec-title"><h1 class="">PAGE '+(pageCount)+'<b  class="page_downseparate"><i class="fa fa-download"></i> Download page '+(pageCount)+' to Powerpoint</b></h1><div class="sttl-line"></div></div></div>');
	 				}else{
	 					$(grids).append('<div class="col-xs-12 padl0  page2 page-title"><div class="sec-title"><h1 class="page2">PAGE '+(pageCount)+'<b  class="page_downseparate"><i class="fa fa-download"></i> Download page '+(pageCount)+' to Powerpoint</b></h1><div class="sttl-line"></div></div></div>');

	 				}
	 			}
	 			if(chartDetails.type == 'chart'){



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

	$('.show_How_To_SaveInFolderVedio').show();
	$('.myfolder_wholediv').hide();
}else{
	$('.show_How_To_SaveInFolderVedio').hide();
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
				$('#smallView_grids').append('<div class="col-xs-12 col-sm-6 ftps_holconmin"><div class="col-xs-12 padl0 page-title"><h4 class="">PAGE '+(pageCount)+'<i class="fa fa-arrows" aria-hidden="true"></i><b class="page_downseparate small-view"><i class="fa fa-download"></i> Download page '+(pageCount)+' to Powerpoint</b></h4></div><div class="ftps_holcon"></div></div>');
			}else{
				$('#smallView_grids').append('<div class="col-xs-12 col-sm-6 ftps_holconmin"><div class="col-xs-12 padl0 page-title"><h4 class="page2">PAGE '+(pageCount)+'<i class="fa fa-arrows" aria-hidden="true"></i><b class="page_downseparate small-view"><i class="fa fa-download"></i> Download page '+(pageCount)+' to Powerpoint</b></h4></div><div class="ftps_holcon"></div></div>');
			}
		}
		if(chartDetails.type == 'chart'){

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
	 		if(chartDetails.type == 'chart'){
	 			
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
	 this.createNewChartBooksContent = function(type,$this){

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
	 				reverseYAxis : false,
	 				reversedAxis_:[],
	 				default_year : null,
	 				isMultiaxis : false,
	 				isNavigator : false,
	 				charts_fields_available : null,
	 				charts_available : null
	 			};

	 			var newContentObject = new charts(newContentIndex,folderContent);
	 			var newContentElement = newContentObject.getThisNoteCreated();
				// Save new element
				$.ajax({
					url : JMA.baseURL + "mycharts/chartbook/createcontent",
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
							self.saveLatestChartBookContentOrder();
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
	 				reverseYAxis : false,
	 				reversedAxis_:[],
	 				default_year :null,
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
						var layout_ = new_chart_object.getThisChartLayouts_ListviewDUB(new_order,false);
						
						//$("#grids div.exhibit").find("[data-order='" + current_order + "']").after(layout_);
						$("#grids div.exhibit[data-order='"+current_order+"']").after(layout_);
						new_chart_object.drawThisChart();
						
						

				}else{
					// Now draw chart
					if(new_chart_object.type == 'chart'){
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
	 * Function duplicateThischartBookContent()
	 * Function to duplicate a chart book content
	 */
	 this.duplicateThischartBookContent = function($this){

	 

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
	url : JMA.baseURL + "mycharts/chartbook/duplicatecontent",
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
					if(new_chart_object.type == 'chart'){
						layout = new_chart_object.getThisChartLayouts(new_order,false);
						$exhibit.after(layout);
						new_chart_object.drawThisChart();
					}else{ // Draw note
					console.log(new_chart_object)
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

	 this.getStats = function(id){
		// console.log('return false'); return false;
		var body = tinymce.get(id).getBody(), 
		text = tinymce.trim(body.innerText || body.textContent);

		return {
			chars: text.length,
			words: text.split(/[\w\u2019\'-]+/).length
		};
	}
	/**
	 * Save note content
	 * 
	 */
	 this.saveThisNoteContent = function(order,pUuid){

	 	var noteContent = self.myFolder.currentFolder.charts[order].note_object.getContent();
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
	 this.saveThisNoteContentForChartBook = function(order,pUuid){

	 	var noteContent = self.myFolder.currentFolder.charts[order].note_object.getData();
	 	var chart_index = self.getIndexByUuid(pUuid);
	 	$.ajax({
	 		url : JMA.baseURL + "mycharts/chartbook/savenotecontent",
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
	 * Save note content
	 * 
	 */
	 this.saveThisChartBookTitle = function(order,pUuid,title){

	 	var chart_index = self.getIndexByUuid(pUuid);
	 	$.ajax({
	 		url : JMA.baseURL + "mycharts/chartbook/savecharttitle",
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
	 * Save note content
	 * 
	 */
	 this.updatehisChartBookDesc = function(desc,folderId){

	 	
	 	$.ajax({
	 		url : JMA.baseURL + "mycharts/chartbook/updatechartbookdesc",
	 		dataType : 'json',
	 		type : 'POST',
	 		data : {desc : desc, folderId : folderId},
	 		beforeSend: function() { JMA.showLoading(); },
	 		success : function(response){
	 			if(response.status!=1){
	 				JMA.handleErrorWithMessage(response.message);
	 			}else{
					// Note content saved
					
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
	 * Function updateThisFolderLatestData
	 * Funciton to update a folder latest content - Chart 
	 */
	 this.updateThisFolderLatestData = function(fid){
		 
		 
		 // Get latest chart Data
		try{
			// Get list of charts for selected folder
			// create array or chart objects
			$.ajax({
				url : JMA.baseURL + "mycharts/folder/getthisfolderdata",
				dataType : 'json',
				type : 'POST',
				async: false,
				data : { folder_id: fid },
				beforeSend: function() { JMA.showLoading(); },
				success : function(response){
					if(response.status!=1){
						JMA.handleErrorWithMessage(response.message);
					}else{
						
						console.log(response.result.folderData.content);
						
						 $.each(response.result.folderData.content,function(order,series){
							 
							 
							 if(series.chart_view_type=='chart' && series.chart_data_type=="monthly")
							 {
								   var stringJson = "'"+series.chart_code+"'";
								   
									var res = stringJson.split("|");
									var dataValue = res[2].split("{");
									var sYear = dataValue[0].split(",");
									var lYear = sYear[1].split(",");
									var yandm = lYear[0].split("-");
									//console.log(sYear);
									
									var datetimeVal = sYear[1].split('-');
									
					                var utcTime_to_date = Date.UTC(datetimeVal[0],datetimeVal[1]-1,1);
									
									 $.each(series.current_chart_codes,function(order,series1){
										 var postId = series1.split("-");
										 
										  var d = new Date();
                                          var cMear = d.getMonth();
										  var cYear = d.getFullYear();
										  
										  var rangeYear = yandm[0]
										  
										  if(yandm[0] < cYear)
										  {
											  var rangeYear = cYear;
										  }
									
									
									var postcode = series.current_chart_codes[0].split("-");
									
									if(series.chart_data_type=="monthly")
									{
								        var i= yandm[1];  
										var j= Number(cMear)-Number(yandm[1]);  
										var curMonth = Number(i) + Number(j); // 5  
										var xRangeVal = rangeYear+"/0"+curMonth;
									}
									
									//console.log(xRangeVal);
									
									var splitLatestPostData = xRangeVal.split("/");
									var replces =  yandm[0]+"-"+yandm[1];
									var replcement =  splitLatestPostData[0]+"-"+ parseInt(splitLatestPostData[1]);
									var udpateStr = series.chart_code.replace(replces,replcement);
									
									 var utcTime_to_date = Date.UTC(splitLatestPostData[0],parseInt(splitLatestPostData[1]),1);
									 
									

									var postData = {
											folder_id : fid,
											chart_data : {
												uuid : series.uuid,
												chart_code : udpateStr,
												
												current_chart_codes : series.current_chart_codes,
												navigator_date_from : series.navigator_date_from,
												navigator_date_to : utcTime_to_date,
												chartType : series.chartType,
												isMultiaxis : series.isMultiaxis,
												reverseYAxis : JSON.parse(series.reverseYAxis),
												reversedAxis_ : series.reversedAxis_.map(Number),
												default_year : series.default_year,
												chart_view_type : series.chart_view_type
											}
										};
										
										
										
										 $.ajax({
											url : JMA.baseURL + "mycharts/chart/updatethiseditedchart",
											dataType : 'json',
											type : 'POST',
											data : postData,
											async: false,
											beforeSend: function() { JMA.showLoading(); },
											success : function(response)
											{
											}
											
										});
									 
									 
									 
									
									
									
							   });
									
									
							 }
							 else if(series.chart_view_type=='chart' && series.chart_data_type=="quaterly")
							 {
								 
								   // console.log('find out issue for quaterly data')
								 
								   var stringJson = "'"+series.chart_code+"'";
								   
									var res = stringJson.split("|");
									var dataValue = res[2].split("{");
									var sYear = dataValue[0].split(",");
									var lYear = sYear[1].split(",");
									var yandm = lYear[0].split("-");
									//console.log(yandm); 
									
									
									
							    $.each(series.current_chart_codes,function(order,series1){
										 var postId = series1.split("-");
										 console.log(postId);
										
										  var d = new Date();
                                          var cMear = d.getMonth();
										  
										  var cYear = d.getFullYear();
										  
										  var findQuat = cMear%3;
										  
										  var rangeYear = yandm[0]
										  
										  if(yandm[0] < cYear)
										  {
											  var rangeYear = cYear;
										  }
										  
										  
										 
										if(series.chart_data_type=="quaterly")
										{
											
											var curMonth=3*Number(findQuat);  
											//var curMonth = Number(i) + Number(j);
											var xRangeVal = rangeYear+"/0"+curMonth;
											if(cMear > 8)
											{
												var xRangeVal = rangeYear+"/"+curMonth;
											}
											
										}
										
										
										//console.log(xRangeVal);
										// return false;
										
										var splitLatestPostData = xRangeVal.split("/");
										
										var replces =  yandm[0]+"-"+yandm[1];
										var replcement =  splitLatestPostData[0]+"-"+ parseInt(splitLatestPostData[1]);
										var udpateStr = series.chart_code.replace(replces,replcement);
										
										var utcTime_to_date = Date.UTC(splitLatestPostData[0],parseInt(splitLatestPostData[1]),1);
										
										var postData = {
												folder_id : fid,
												chart_data : {
													uuid : series.uuid,
													chart_code : udpateStr,
													
													current_chart_codes : series.current_chart_codes,
													navigator_date_from : series.navigator_date_from,
													navigator_date_to : utcTime_to_date,
													chartType : series.chartType,
													isMultiaxis : series.isMultiaxis,
													reverseYAxis : JSON.parse(series.reverseYAxis),
													reversedAxis_: series.reversedAxis_.map(Number),
													default_year : series.default_year,
													chart_view_type : series.chart_view_type
												}
											};
											
											
											
											 $.ajax({
												url : JMA.baseURL + "mycharts/chart/updatethiseditedchart",
												dataType : 'json',
												type : 'POST',
												data : postData,
												async: false,
												beforeSend: function() { JMA.showLoading(); },
												success : function(response)
												{
												}
												
											});
										 
										 
								});
								 
							 }
							 else if(series.chart_view_type=='chart' && series.chart_data_type=="anual")
							 {
								 
								 
								    var stringJson = "'"+series.chart_code+"'";
								   
									var res = stringJson.split("|");
									var dataValue = res[2].split("{");
									var sYear = dataValue[0].split(",");
									
									var lYear = sYear[1].split(",");
									var yandm = lYear[0].split("-");
									
									//console.log(sYear); 
									
					                var utcTime_to_date = Date.UTC(sYear[1],0,1);
									
									 $.each(series.current_chart_codes,function(order,series1){
										 var postId = series1.split("-");
										 //console.log(postId);
										 
										 var d = new Date();
										  
										  var cYear = d.getFullYear();
										  
										  var rangeYear = sYear[1];
										  
										  if(sYear[1] < cYear)
										  {
											  var rangeYear = cYear;
										  }
										 
										if(series.chart_data_type=="anual")
										{
											
											var curYear = rangeYear;
											var xRangeVal = curYear;
											
										}
										
										//console.log(xRangeVal); 
										
										var splitLatestPostData = xRangeVal;
														
										var utcTime_to_date = Date.UTC(splitLatestPostData,0,1);
										
										var replces =  sYear[1];
										var replcement =  splitLatestPostData;
										var udpateStr = series.chart_code.replace(replces,replcement);
										
										
										var postData = {
												folder_id : fid,
												chart_data : {
													uuid : series.uuid,
													chart_code : udpateStr,
													
													current_chart_codes : series.current_chart_codes,
													navigator_date_from : series.navigator_date_from,
													navigator_date_to : utcTime_to_date,
													chartType : series.chartType,
													isMultiaxis : series.isMultiaxis,
													reverseYAxis : JSON.parse(series.reverseYAxis),
													reversedAxis_ :series.reversedAxis_.map(Number),
													default_year : series.default_year,
													chart_view_type : series.chart_view_type
												}
											};
											
											
											
											 $.ajax({
												url : JMA.baseURL + "mycharts/chart/updatethiseditedchart",
												dataType : 'json',
												type : 'POST',
												data : postData,
												async: false,
												beforeSend: function() { JMA.showLoading(); },
												success : function(response)
												{
												}
												
											});
										
										
										
											
									 });
									
									
									
							 }
							 else if(series.chart_view_type=='chart' && series.chart_data_type=="daily")
							 {
								    var stringJson = "'"+series.chart_code+"'";
								   
									var res = stringJson.split("|");
									var dataValue = res[2].split("{");
									var sYear = dataValue[0].split(",");
									var lYear = sYear[1].split(",");
									var yandm = lYear[0].split("-");
									//console.log(sYear);
									
									
									var datetimeVal = sYear[1].split('-');
									
					                var utcTime_to_date = Date.UTC(datetimeVal[0],datetimeVal[1]-1,1);
									
									 $.each(series.current_chart_codes,function(order,series1){
										 var postId = series1.split("-");
										 
										  var d = new Date();
                                          var cMear = d.getMonth();
										  var cYear = d.getFullYear();
										  
										  var rangeYear = yandm[0]
										  
										  if(yandm[0] < cYear)
										  {
											  var rangeYear = cYear;
										  }
									
									
									var postcode = series.current_chart_codes[0].split("-");
									
									if(series.chart_data_type=="daily")
									{
								        var i= yandm[1];  
										var j= Number(cMear)-Number(yandm[1]);  
										var curMonth = Number(i) + Number(j); // 5  
										var xRangeVal = rangeYear+"/0"+curMonth;
									}
									
									//console.log(xRangeVal); //return false;
									
									var splitLatestPostData = xRangeVal.split("/");
									var replces =  yandm[0]+"-"+yandm[1];
									var replcement =  splitLatestPostData[0]+"-"+ parseInt(splitLatestPostData[1]);
									var udpateStr = series.chart_code.replace(replces,replcement);
									
									 var utcTime_to_date = Date.UTC(splitLatestPostData[0],parseInt(splitLatestPostData[1]),1);


									var postData = {
											folder_id : fid,
											chart_data : {
												uuid : series.uuid,
												chart_code : udpateStr,
												
												current_chart_codes : series.current_chart_codes,
												navigator_date_from : series.navigator_date_from,
												navigator_date_to : utcTime_to_date,
												chartType : series.chartType,
												isMultiaxis : series.isMultiaxis,
												reverseYAxis : JSON.parse(series.reverseYAxis),
												reversedAxis_:series.reversedAxis_.map(Number),
												default_year : series.default_year,
												chart_view_type : series.chart_view_type
											}
										};
										
										
										
										 $.ajax({
											url : JMA.baseURL + "mycharts/chart/updatethiseditedchart",
											dataType : 'json',
											type : 'POST',
											data : postData,
											async: false,
											beforeSend: function() { JMA.showLoading(); },
											success : function(response)
											{
											}
											
										});
									 
									
									
									
							   });
									
									
									
							 }
							 
						 });
						 
						 
						
					}
					JMA.hideLoading();
				},
				error : function(){
					JMA.hideLoading();
					JMA.handleError();
				}
			});
            location.reload(); 
}catch(Err){
	JMA.handleError();
}
            
     };	


	 

	/**
	 * Function editThisContent
	 * Funciton to edit a folder content - Chart / Note
	 */
	 this.editThisFolderContent = function(pType,order,pUuid){


	 	var chart_index = self.getIndexByUuid(pUuid);
		// Create chart details object.

		if(((self.myFolder.currentFolder.charts[chart_index].chartType).match("^yield_"))){
			var navigator_date_from_ =self.myFolder.currentFolder.charts[chart_index].navigator_date_from;
			var navigator_date_to_ =self.myFolder.currentFolder.charts[chart_index].navigator_date_to;
		}else{
			var navigator_date_from_ = Highcharts.dateFormat('%d-%m-%Y',parseInt(self.myFolder.currentFolder.charts[chart_index].navigator_date_from));
			var navigator_date_to_ = Highcharts.dateFormat('%d-%m-%Y',parseInt(self.myFolder.currentFolder.charts[chart_index].navigator_date_to));
		}

		var chartDetailsObj = {
			chart_actual_code : self.myFolder.currentFolder.charts[chart_index].chart_code,
			color_code : self.myFolder.currentFolder.charts[chart_index].color_code,
			color_series : self.myFolder.currentFolder.charts[chart_index].color_series,
			color_status : self.myFolder.currentFolder.charts[chart_index].color_status,
			mychart_color_code : self.myFolder.currentFolder.charts[chart_index].mychart_color_code,
			chart_data_type : self.myFolder.currentFolder.charts[chart_index].chart_data_type,
			isPremiumData : false,
			navigator_date_from : navigator_date_from_,
			navigator_date_to : navigator_date_to_,
			share_page_url : '',
			sources : '',
			chart_config : {
				chartLayout : self.myFolder.currentFolder.charts[chart_index].chartLayout,
				chartType : self.myFolder.currentFolder.charts[chart_index].chartType,
				chart_view_type : self.myFolder.currentFolder.charts[chart_index].chart_view_type,
				dataType : self.myFolder.currentFolder.charts[chart_index].chart_data_type,
				isChartTypeSwitchable : self.myFolder.currentFolder.charts[chart_index].isChartTypeSwitchable,
				isMultiaxis : self.myFolder.currentFolder.charts[chart_index].isMultiaxis,
				reverseYAxis : JSON.parse(self.myFolder.currentFolder.charts[chart_index].reverseYAxis),
				reversedAxis_:self.myFolder.currentFolder.charts[chart_index].reversedAxis_,
				default_year : self.myFolder.currentFolder.charts[chart_index].default_year,
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


		var ajaxData={ 'type' : self.myFolder.currentFolder.charts[chart_index].chart_data_type, 
						'chartcodes' : self.myFolder.currentFolder.charts[chart_index].current_chart_codes,
						'chartOrder':chart_index};
					if(self.myFolder.currentFolder.charts[chart_index].chartType=='map'){
						Object.assign(ajaxData,{'default_year':self.myFolder.currentFolder.charts[chart_index].default_year});
					}
		
		
		// Get latest chart Data
		$.ajax({
			url : JMA.baseURL+'chart/getchartdata',
			dataType : 'json',
			type : 'POST',
			cache: false,
			data : ajaxData,
			beforeSend: function() { JMA.showLoading();},
			success : function(data){
				chartDetailsObj.sources = data.sources;
				chartDetailsObj.isPremiumData = data.isPremiumData;
				chartDetailsObj.chart_data = data.data;
				JMA.JMAChart.initiateChart(0,chartDetailsObj);

				$('#Dv_modal_edit_folder_content .modal-body #Chart_Dv_placeholder_0').empty(); 
				$('#Dv_modal_edit_folder_content').modal({show: true,backdrop: 'static',keyboard: true});

				$('#Dv_modal_edit_folder_content').on('shown.bs.modal', function () {
					JMA.JMAChart.drawAllCharts();
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
	 * Function switchThisChartBooksViewType()
	 * switches to View type whether chart or data
	 */
	 this.switchThisChartBooksViewType = function(view_type,chartOrder){


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
				url : JMA.baseURL + "mycharts/chartbookList/updatethiseditedchart",
				dataType : 'json',
				type : 'POST',
				data : postData,
				beforeSend: function() { JMA.showLoading(); },
				success : function(response){
					if(response.status!=1){
						JMA.handleErrorWithMessage(response.message);
					}else{
						self.myFolder.currentFolder.charts[chart_index].chart_view_type='chart';
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

	 		var v_isMultiaxis = ((JMA.JMAChart.Charts[0].Conf.chartType).match("multiaxis")) ? true : false ;
	 		var v_isReverseY = JMA.JMAChart.Charts[0].Conf.reverseYAxis;
	 		var postData = {
	 			folder_id : selectedFolder,
	 			chart_data : {
	 				uuid : uuid,
	 				chart_code : v_chart_code,
	 				color_codes : colors,
					color_series : JMA.JMAChart.Charts[0].Conf.color_series,
					color_status : 'true',
					chart_labels_available : JMA.JMAChart.Charts[0].Conf.chart_labels_available,
					charts_fields_available : JMA.JMAChart.Charts[0].Conf.charts_fields_available,
	 				current_chart_codes : JMA.JMAChart.Charts[0].Conf.current_chart_codes,
	 				navigator_date_from : JMA.JMAChart.Charts[0].Conf.navigator_date_from,
	 				navigator_date_to : JMA.JMAChart.Charts[0].Conf.navigator_date_to,
	 				chartType : JMA.JMAChart.Charts[0].Conf.chartType,
	 				isMultiaxis : v_isMultiaxis,
	 				reverseYAxis:JSON.parse(v_isReverseY),
	 				reversedAxis_:JMA.JMAChart.Charts[0].Conf.reversedAxis_,
	 				default_year:JMA.JMAChart.Charts[0].Conf.default_year,
					chart_view_type : 'chart'
	 			}
	 		};
			
			//console.log(postData); //return false;
	 		
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
						self.myFolder.currentFolder.charts[chart_index].chart_view_type = 'chart';
						self.myFolder.currentFolder.charts[chart_index].isMultiaxis = v_isMultiaxis;
						self.myFolder.currentFolder.charts[chart_index].reverseYAxis = v_isReverseY;
						self.myFolder.currentFolder.charts[chart_index].reversedAxis_ = JMA.JMAChart.Charts[0].Conf.reversedAxis_.map(Number);
						self.myFolder.currentFolder.charts[chart_index].default_year =JMA.JMAChart.Charts[0].Conf.default_year;
						self.myFolder.currentFolder.charts[chart_index].data = {};
						
						self.myFolder.currentFolder.charts[chart_index].color_code = colors;
						self.myFolder.currentFolder.charts[chart_index].color_series = JMA.JMAChart.Charts[0].Conf.color_series;
						self.myFolder.currentFolder.charts[chart_index].color_status = 'true';
						self.myFolder.currentFolder.charts[chart_index].chart_labels_available =JMA.JMAChart.Charts[0].Conf.chart_labels_available;
					    self.myFolder.currentFolder.charts[chart_index].charts_fields_available =JMA.JMAChart.Charts[0].Conf.charts_fields_available;

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
						
						
						//console.log(dataTable_container);
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
	 * Function updateThisEditedChartBook()
	 * Updates Edited Chart to myChart
	 */
	 this.updateThisEditedChartBook = function(){
	 	try {
	 		var selectedFolder = self.myFolder.currentFolder.id;
	 		var uuid = $('#Dv_modal_edit_folder_content').data('uuid');
	 		var chart_index = self.getIndexByUuid(uuid);
	 		var v_chart_code = JMA.JMAChart.Charts[0].createChartCodeFromConfig();

	 		var v_isMultiaxis = ((JMA.JMAChart.Charts[0].Conf.chartType).match("multiaxis")) ? true : false ;
	 		var v_isReverseY = JMA.JMAChart.Charts[0].Conf.reverseYAxis;
	 		var postData = {
	 			folder_id : selectedFolder,
	 			chart_data : {
	 				uuid : uuid,
	 				chart_code : v_chart_code,
	 				current_chart_codes : JMA.JMAChart.Charts[0].Conf.current_chart_codes,
	 				navigator_date_from : JMA.JMAChart.Charts[0].Conf.navigator_date_from,
	 				navigator_date_to : JMA.JMAChart.Charts[0].Conf.navigator_date_to,
	 				chartType : JMA.JMAChart.Charts[0].Conf.chartType,
	 				isMultiaxis : v_isMultiaxis,
	 				reverseYAxis:JSON.parse(v_isReverseY),
	 				reversedAxis_:JMA.JMAChart.Charts[0].Conf.reversedAxis_.map(Number),
	 				default_year:JMA.JMAChart.Charts[0].Conf.default_year,
					chart_view_type : 'chart'
	 			}
	 		};
			// Save data
			$.ajax({
				url : JMA.baseURL + "mycharts/chartbookList/updatethiseditedchart",
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
						self.myFolder.currentFolder.charts[chart_index].reverseYAxis = JSON.parse(v_isReverseY);
						self.myFolder.currentFolder.charts[chart_index].reversedAxis_ = JMA.JMAChart.Charts[0].Conf.reversedAxis_.map(Number);
						self.myFolder.currentFolder.charts[chart_index].default_year =JMA.JMAChart.Charts[0].Conf.default_year;
						
						self.myFolder.currentFolder.charts[chart_index].data = {};

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
						
						
						//console.log(dataTable_container);
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
							
							if(self.myFolder.currentFolder.charts.length == 0)
							{
								$('.show_How_To_SaveInFolderVedio').show();
								$('.myfolder_wholediv').hide(); 
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
	 * Function deleteThisChartBookContent(element)
	 * To delete selected folder content - chart / note
	 */
	 this.deleteThisChartBookContent = function(contentType,$this){
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
					url : JMA.baseURL + "mycharts/chartbookList/deletethisfoldercontent",
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

	 		$.each($('#grids .exhibit'),function(i_cnt,elm){
	 			
			$('#grids .exhibit:eq("'+i_cnt+'") ul.exhibit-tab li').data('order',i_cnt);

	 		});

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
	 						$('<div class="col-xs-12 col-lg-8 padl0 page-title page2"><h1 class="page2">PAGE '+(elm_cnt+1)+'</h1></div>').insertBefore($page_element.prev($paging_elements));
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

this.reorderSmallView = function(){
	var $paging_elements = $('div#smallView_grids div.ftps_holconmin div.exhibit');
	var pageCount = 0;
	$.each($paging_elements, function(order,chartDetails){
		if(order%4 == 0){
			pageCount++;
		}
//console.log(pageCount);
$('#smallView_grids .ftps_holcon:eq("' + (pageCount-1) + '")').append(chartDetails);

});



};

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
 	this.reverseYAxis;
 	this.reversedAxis_;
 	this.default_year;
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
	 	colors : [ '#DE4622', '#3366CC', '#FF9900', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a' ]
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
	 	this.reverseYAxis =(typeof(folderContent.reverseYAxis) === 'undefined' )? false : JSON.parse(folderContent.reverseYAxis);
		this.reversedAxis_ =(typeof(folderContent.reversedAxis_) === 'undefined' )? [] : folderContent.reversedAxis_;
		this.default_year =(typeof(folderContent.default_year) === 'undefined' )? null : folderContent.default_year;
		this.chartType = folderContent.chartType;
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


	var ajaxData={ 'type' : self.chart_data_type, 
						'chartcodes' : self.current_chart_codes,
						'chartOrder':self.order};
					if(self.chartType=='map'){
						Object.assign(ajaxData,{'default_year':self.default_year});
					}
	 	$.ajax({
	 		url : JMA.baseURL+'chart/getchartdata',
	 		dataType : 'json',
	 		type : 'POST',
	 		cache: false,
	 		data : ajaxData,
	 		beforeSend: function() { JMA.showLoading(); },
	 		success : function(data){
	 			self.data.sources = data.sources;
	 			self.data.isPremiumData = data.isPremiumData;
	 			if(self.chartType=='map')
	 				self.createChartDataSeries(data.data);
	 			else
	 			self.createChartDataSeries(self.formatData(data.data),self.color_code);
	 			

	 			self.drawThisChart();
	 			//self.drawThisChart();	

	 			if(JMA.myChart.myFolder.currentView=='smallView'){
	 				var small_div='small_';
	 			}else{
	 				var small_div='';
	 			}


				//Veera Start
				if(self.chart_view_type=='chart'){

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

				$(document).one("ajaxStop", function() {

					JMA.hideLoading();
				});




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


	 			if((self.chart_data_type).match('^yield')){
	 				var first_th_title = 'Maturity';
	 			}else{
	 				var first_th_title = (self.chartType=='map')?'States':'Date';
	 			}
	 			var out = '<table cellspacing="0" cellpadding="0" class="mychart_table fixed_headers table table-striped"><thead><tr><th>'+first_th_title+'</th>';
	 			var out_data = '';
	 			var data_formated = [];
	 			var column_width = dynamictd/self.data.chartDataSeries.length;
	 			var findChartType = [];
					$.each(self.data.chartDataSeries,function(order,series_){
						var series__=series_.data;
					var last=series__.length-1;
					var lastBfr=series__.length-2;
					var diffTime = Math.abs(parseInt(series__[last][0]) - parseInt(series__[lastBfr][0]));
					var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

					if(diffDays>=90 && diffDays<=92){
						var r=(findChartType['quaterly']==undefined)?0:findChartType['quaterly'];
						 findChartType['quaterly']=r+1;
					}else if(diffDays>=28 && diffDays<=32){
						var r=(findChartType['monthly']==undefined)?0:findChartType['monthly'];
						 findChartType['monthly']=r+1;
					}else if(diffDays>=360 && diffDays<=365){
						var r=(findChartType['anual']==undefined)?0:findChartType['anual'];
						 findChartType['anual']=r+1;
					}else if(diffDays==1){
						var r=(findChartType['daily']==undefined)?0:findChartType['daily'];
						 findChartType['daily']=r+1;
					}else{
						var r=(findChartType[self.chart_data_type]==undefined)?0:findChartType[self.chart_data_type];
						 findChartType[self.chart_data_type]=r+1;
					}
					
				});
	 			$.each(self.data.chartDataSeries,function(order,series){
	 				var yr='';
					if(self.chartType=='map'){
					yr=' ('+self.default_year+')';
					}
					
	 				out+="<th width='"+column_width+"%'>"+series.name+yr+"</th>";
	 			var series=series.data;
	 						//console.log(self.current_chart_codes);
	 					if(self.current_chart_codes.length>1 && !(self.chart_data_type).match('^yield')){ //console.log(series);
							var StartYr=series[0][0];var findYr = new Date(StartYr);StartYr=findYr.getFullYear();
							var EndYr=series[series.length-1][0]; var findEYr = new Date(EndYr);EndYr=findEYr.getFullYear();
									var quat='%b ';
									if(findChartType['quaterly']!=undefined && self.current_chart_codes.length==findChartType['quaterly']){
									var Month_=4;
									var Month_Q=3;
									}
									if(findChartType['anual']!=undefined && self.current_chart_codes.length==findChartType['anual']){
									var Month_=1;
									var Month_Q=3;
									var quat='';
									}
									if(findChartType['quaterly']!=undefined && findChartType['quaterly']>0){
									var Month_=4;
									var Month_Q=3;
									}
									if(findChartType['monthly']!=undefined && findChartType['monthly']>0){
									var Month_=12;
									var Month_Q=1;
									}if(findChartType['daily']!=undefined && findChartType['daily']>0){
									var Month_=12;
									var Month_Q=1;
									}
									var tt=0;
									for (var Yr = StartYr; Yr <= EndYr; Yr++) { var t=tt;
										if(Highcharts.dateFormat('%Y', parseInt(findEYr.getTime()))==Yr){
										if(Month_==4){
											Month_=Math.ceil(Highcharts.dateFormat('%m', parseInt(findEYr.getTime()))/3);
										}else if(Month_==1){
											Month_=Math.ceil(Highcharts.dateFormat('%m', parseInt(findEYr.getTime()))/12);
										}else{
											Month_=Highcharts.dateFormat('%m', parseInt(findEYr.getTime()));
										}//console.log(findEYr.getTime());

									}
									for (var Mo = 1; Mo <= Month_; Mo++) {
									var utcTime = Date.UTC(Yr,(Month_Q*Mo)-1,1);
									if(Array.isArray(data_formated[t]) == true){
											var current_=null;
								
									 for (var i = 0; i < series.length; i++) {
									 if (series[i][0]==utcTime) {
										current_=series[i][1];
									}
									 }	
                                 data_formated[t].push(current_);
									
								}else{
									
								var current_=null;
								var item = {};
						if(self.chart_data_type == 'quaterly' || (findChartType['quaterly']!=undefined && findChartType['quaterly']>0)){
								        if (Highcharts.dateFormat('%b', utcTime) == 'Mar') {
											var quat = "Q1 ";
										}else if (Highcharts.dateFormat('%b', utcTime) == 'Jun') {
											var quat = "Q2 ";
										}else if (Highcharts.dateFormat('%b', utcTime) == 'Sep') {
											var quat = "Q3 ";
										}else if (Highcharts.dateFormat('%b', utcTime) == 'Dec') {
											var quat = "Q4 ";
										}else{
												var quat='%b ';
										}
										
									}
									//console.log(quat);
									var dte = Highcharts.dateFormat(quat+'%Y',utcTime);
									 for (var i = 0; i < series.length; i++) {
										 if (series[i][0]==utcTime) {
											current_=series[i][1];
										  }
							        }
							
									data_formated[t] = [dte,current_];
									
								}

								
								
								t++;tt=t;
								}
								}
								}else{ 
								$.each(series,function(i_order,dataset){
								var datasets = (self.chartType=='map')?dataset['hc-key']:dataset[0];
								var INDEX=(self.chartType=='map')?'value':1;
								var item = {};
								if(Array.isArray(data_formated[i_order]) == true){
                                 data_formated[i_order].push(dataset[INDEX]);
									
								}
								else
								{
									if(self.chart_data_type == 'monthly'){
										var dte = Highcharts.dateFormat('%b %Y',datasets);
									}else if(self.chart_data_type == 'quaterly'){
										 if (Highcharts.dateFormat('%b', datasets) == 'Mar') {
											var quat = "Q1 ";
										}else if (Highcharts.dateFormat('%b', datasets) == 'Jun') {
											var quat = "Q2 ";
										}else if (Highcharts.dateFormat('%b', datasets) == 'Sep') {
											var quat = "Q3 ";
										}else if (Highcharts.dateFormat('%b', datasets) == 'Dec') {
											var quat = "Q4 ";
										}else{
												var quat='%b ';
										}
									var dte = Highcharts.dateFormat(quat+'%Y',datasets);
									}else if(self.chart_data_type == 'anual'){
										if(self.chartType=='map')
										var dte = datasets;
									    else
									    var dte = Highcharts.dateFormat('%Y',datasets);
									}else if(self.chart_data_type == 'daily'){
										var dte = Highcharts.dateFormat('%e %b %Y',datasets);
									}else if((self.chart_data_type).match('^yield')){
	 									var dte = datasets;
	 								}
										data_formated[i_order] = [dte,dataset[INDEX]];
									
									
									
								}
							});
							}

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
        
        case 'yield_line':
          

      if(JMA.myChart.myFolder.currentView=='smallView'){
        var mq = window.matchMedia( "(max-width: 1199px) and (min-width: 992px)" ); 
        var mqs = window.matchMedia( "(max-width: 991px)" );
        if (mq.matches) {
        this_chart_object_resize =this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(407, 200);
        
        }       
        else if(mqs.matches){         
          this_chart_object_resize =this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
          this_chart_object_resize.setSize(298, 200);         
        }
        else{
        this_chart_object_resize = this.chart_object= this.drawYieldChart(graph_container,graph_containerID);

        this_chart_object_resize.setSize(250, 170);
      
        }
        }else if(JMA.myChart.myFolder.currentView=='largeView'){
        this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        

        }else{
        this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        
        //this.chart_object = this.drawLineChart1();
        }

        
        
        break;
        case 'yield_bar':
          

      if(JMA.myChart.myFolder.currentView=='smallView'){
        var mq = window.matchMedia( "(max-width: 1199px) and (min-width: 992px)" ); 
        var mqs = window.matchMedia( "(max-width: 991px)" );
        if (mq.matches) {
          this_chart_object_resize =this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
          this_chart_object_resize.setSize(407, 200);       
        }       
        else if(mqs.matches){         
          this_chart_object_resize =this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
          this_chart_object_resize.setSize(298, 200);         
        }
        else{
        this_chart_object_resize = this.chart_object= this.drawYieldChart(graph_container,graph_containerID);

        this_chart_object_resize.setSize(250, 170);
      
        }
        }else if(JMA.myChart.myFolder.currentView=='largeView'){
        this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        

        }else{
        this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        
        //this.chart_object = this.drawLineChart1();
        }

        
        
        break;
        case 'yield_multiaxisline':
         if(JMA.myChart.myFolder.currentView=='smallView'){
        var mq = window.matchMedia( "(max-width: 1199px) and (min-width: 992px)" ); 
        var mqs = window.matchMedia( "(max-width: 991px)" );
        if (mq.matches) {
        this_chart_object_resize =this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(407, 200);
        
        }       
        else if(mqs.matches){         
          this_chart_object_resize =this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
          this_chart_object_resize.setSize(298, 200);         
        }
        else{
        this_chart_object_resize = this.chart_object= this.drawYieldChart(graph_container,graph_containerID);

        this_chart_object_resize.setSize(250, 170);
      
        }
        }else if(JMA.myChart.myFolder.currentView=='largeView'){
        this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        

        }else{
        this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        
        //this.chart_object = this.drawLineChart1();
        }
         break;
        case 'yield_multiaxisbar':
          if(JMA.myChart.myFolder.currentView=='smallView'){
        var mq = window.matchMedia( "(max-width: 1199px) and (min-width: 992px)" ); 
        var mqs = window.matchMedia( "(max-width: 991px)" );
        if (mq.matches) {
        this_chart_object_resize =this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(407, 200);
        
        }       
        else if(mqs.matches){         
          this_chart_object_resize =this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
          this_chart_object_resize.setSize(298, 200);         
        }
        else{
        this_chart_object_resize = this.chart_object= this.drawYieldChart(graph_container,graph_containerID);

        this_chart_object_resize.setSize(250, 170);
      
        }
        }else if(JMA.myChart.myFolder.currentView=='largeView'){
        this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        

        }else{
        this.chart_object = this.drawYieldChart(graph_container,graph_containerID);
        
        //this.chart_object = this.drawLineChart1();
        }
        break;
        case 'line':
        if(JMA.myChart.myFolder.currentView=='smallView'){
        var mq = window.matchMedia( "(max-width: 1199px) and (min-width: 992px)" ); 
        var mqs = window.matchMedia( "(max-width: 991px)" );
        if (mq.matches) {
        this_chart_object_resize =this.chart_object = this.drawLineChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(407, 200);
        
        }       
        else if(mqs.matches){         
          this_chart_object_resize =this.chart_object = this.drawLineChart(graph_container,graph_containerID);
          this_chart_object_resize.setSize(298, 200);         
        }
        else{
        this_chart_object_resize = this.chart_object= this.drawLineChart(graph_container,graph_containerID);

        this_chart_object_resize.setSize(250, 170);
      
        }
        }else if(JMA.myChart.myFolder.currentView=='largeView'){

        this.chart_object = this.drawLineChart(graph_container,graph_containerID);
        

        }else{
        	
        this.chart_object = this.drawLineChart(graph_container,graph_containerID);
        
        //this.chart_object = this.drawLineChart1();
        }


        break;
        case 'bar':
        if(JMA.myChart.myFolder.currentView=='smallView'){
        var mq = window.matchMedia( "(max-width: 1199px) and (min-width: 992px)" ); 
        var mqs = window.matchMedia( "(max-width: 991px)" );
        if (mq.matches) {
        this_chart_object_resize =this.chart_object = this.drawBarChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(407, 200);
        }       
        else if(mqs.matches){         
          this_chart_object_resize =this.chart_object = this.drawBarChart(graph_container,graph_containerID);
          this_chart_object_resize.setSize(298, 200);         
        }
        else{
        this_chart_object_resize =this.chart_object = this.drawBarChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(250, 170);
        }
        }else if(JMA.myChart.myFolder.currentView=='largeView'){
        this.chart_object = this.drawBarChart(graph_container,graph_containerID);


        }else{
        this.chart_object = this.drawBarChart(graph_container,graph_containerID);
        
        }
        break;
        case 'multiaxisline':
        if(JMA.myChart.myFolder.currentView=='smallView'){
        var mq = window.matchMedia( "(max-width: 1199px) and (min-width: 992px)" ); 
        var mqs = window.matchMedia( "(max-width: 991px)" );
        if (mq.matches) {
        this_chart_object_resize =this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(407, 200);
        }       
        else if(mqs.matches){         
          this_chart_object_resize =this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);
          this_chart_object_resize.setSize(298, 200);         
        }
        else{
        this_chart_object_resize =this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(250, 170);
        }
        }else if(JMA.myChart.myFolder.currentView=='largeView'){
        this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);


        }else{
        this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);
        
        }
        break;
        case 'multiaxisbar':
        if(JMA.myChart.myFolder.currentView=='smallView'){
        var mq = window.matchMedia( "(max-width: 1199px) and (min-width: 992px)" ); 
        var mqs = window.matchMedia( "(max-width: 991px)" );
        if (mq.matches) {
        this_chart_object_resize =this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(407, 200);
        }       
        else if(mqs.matches){         
          this_chart_object_resize =this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);
          this_chart_object_resize.setSize(298, 200);         
        }
        else{
        this_chart_object_resize =this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(250, 170);
        }
        }else if(JMA.myChart.myFolder.currentView=='largeView'){
        this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);


        }else{
        this.chart_object = this.drawMultiAxisChart(graph_container,graph_containerID);
        
        }
         break;
        case 'map':
        if(JMA.myChart.myFolder.currentView=='smallView'){
        var mq = window.matchMedia( "(max-width: 1199px) and (min-width: 992px)" ); 
        var mqs = window.matchMedia( "(max-width: 991px)" );
        if (mq.matches) {
        this_chart_object_resize =this.chart_object = this.drawMapChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(407, 200);
        }       
        else if(mqs.matches){         
          this_chart_object_resize =this.chart_object = this.drawMapChart(graph_container,graph_containerID);
          this_chart_object_resize.setSize(298, 200);         
        }
        else{
        this_chart_object_resize =this.chart_object = this.drawMapChart(graph_container,graph_containerID);
        this_chart_object_resize.setSize(250, 170);
        }
        }else if(JMA.myChart.myFolder.currentView=='largeView'){
        this.chart_object = this.drawMapChart(graph_container,graph_containerID);


        }else{
        this.chart_object = this.drawMapChart(graph_container,graph_containerID);
        
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
	 			var findDivoffset=$('#Dv_folder_content div.exhibit[data-uuid="'+JMA.SmalltoLarge+'"] div').offset().top;
	 			$('#Dv_folder_content div.exhibit[data-uuid="'+JMA.SmalltoLarge+'"]').addClass('sortable-select');
	 			$(window).scrollTop( findDivoffset-120 );
	 		}

	 	}, 1000);

	 };







//Class drawYieldChart not stockchart

this.drawYieldChart = function(graph_container,graph_containerID){



	var isBig  = window.matchMedia( "(min-width: 1025px)" );

	if((self.chartType).match('multiaxis')){


		var formetted_data_series = this.createMultiYaxisConfigurations(self.data.chartDataSeries);
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
	}




	if(isBig.matches)
	{
		var tooltipstyle={};
	}else{
		var tooltipstyle={ width: '100px'};
	}

	if(JMA.myChart.myFolder.currentView=='smallView'){
		var Xaxislbl_style={fontSize: 7 } 
	}else{
		var Xaxislbl_style={fontSize: 11 } 
	}

	var xAxis = {
		type: 'category',
				gridLineWidth : 0, // New value
				title: {
					text: "Maturity (Years)"
				},
				labels : {
					style: Xaxislbl_style ,

				},
				scrollbar: {
					enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
					margin: 30 

				},
				tickInterval:1,

			};


			
			var toolTip = {  
				useHTML: true,
				//backgroundColor: null,
				// borderWidth: 0,
    //     shadow: false,
     crosshairs: {
            width: 0.5,
            color: 'gray',
            zIndex: 5
           
        },
			split: false,
			shared: true,
				positioner: function () {
            return { x: 37, y: 285 };
        },followTouchMove: false,style: tooltipstyle,enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false  };


			var yAxis = {
			gridLineWidth : 1.5, // The default value, no need to change it
			gridLineDashStyle: 'Dot',
			gridLineColor: '#999999',
			//gridZIndex: -10,
			// offset : 10,
			opposite : false,
			labels : {
				align : 'right',
			// y: 3
		},
		title: {
			text: "Yield (%)"
		},
		plotLines : [ {
			value : 0,
			color : 'black',
			dashStyle : 'shortdash',
			width : 1.5
		} ]
	};




	if(JMA.myChart.myFolder.currentView=='largeView'){
		var responsive={
			rules: [
			{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						enabled: ((JMA.myChart.myFolder.currentView =='largeView') ? true : false),
						backgroundColor: '#dddddd',
						verticalAlign: 'top',
						labelFormatter: function() {
							var legendName = this.name;
							 legendName = (legendName.match('^Series '))?'No data to display':legendName;
								var match = legendName.match(/.{1,70}/g);
								return match.toString().replace(/\,/g,"<br/>");

						},
						layout: 'horizontal',
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
					legend: {
						labelFormatter: function() {
								var legendName = this.name;

								var match = (legendName.match('^Series '))?'No data to display':legendName;
								return match.toString().replace(/\,/g,"<br/>");
							},
						enabled: (JMA.myChart.myFolder.currentView =='largeView') ? true : false,
						backgroundColor: '#dddddd',
						verticalAlign: 'top',
						layout: 'horizontal',
						itemStyle: {
							color: '#274b6d'
						}
					},
				}
			},{
					condition: {
						maxWidth: 439
					},
					chartOptions: {
						legend: {
							labelFormatter: function() {
								var legendName = this.name;

								var match = (legendName.match('^Series '))?'No data to display':legendName;
								return match.toString().replace(/\,/g,"<br/>");
							},
							
							enabled: (JMA.myChart.myFolder.currentView =='largeView') ? true : false,
							
							backgroundColor : '#dddddd',
							verticalAlign: 'top',
							layout: 'horizontal',
							itemStyle : {
								width: 190,
								fontSize : 11
							}
						},
					}
				}  ]
		};

		var legend= {
			labelFormatter: function() {
								var legendName = this.name;

								var match = (legendName.match('^Series '))?'No data to display':legendName;
								return match.toString().replace(/\,/g,"<br/>");
							},
			enabled: ((JMA.myChart.myFolder.currentView =='largeView') ? true : false)

		};
	}else{
		var responsive=null;
		var legend= {
			labelFormatter: function() {
								var legendName = this.name;

								var match = (legendName.match('^Series '))?'No data to display':legendName;
								return match.toString().replace(/\,/g,"<br/>");
							},
			enabled: ((JMA.myChart.myFolder.currentView =='largeView') ? true : false)

		};
	}





	var plotOptions={			line: {
		marker: {
			enabled: false
		}

	},
				 series: {
            connectNulls: true ,
                dataLabels: {
                    allowOverlap: true,
                   
                  
                }
            },};
	var chart_type=null;
	if(self.chartType=='yield_bar'){
		var chart_type='column';

		var plotOptions={
			column: {
				pointPadding: 0.5,
				borderWidth: 3
			},
				 series: {
            connectNulls: true ,
                dataLabels: {
                    allowOverlap: true,
                   
                  
                }
            },
		}


	}
	
	$(self.color_code).each(function(index ) {
		if(self.color_code[index])
		{
			self.chartConfigs.colors[index] = self.color_code[index];
		}
   });	
	
	return new Highcharts.Chart({
		chart : {
			type: chart_type,
				  //zoomType: 'x',
				  renderTo : graph_container,
				  backgroundColor : '#f5f5f5',
				  plotBorderColor : '#000000',
				  plotBackgroundColor : '#FFFFFF',
				  plotBorderWidth : 0.5,
				  spacingBottom : 35,
				  alignTicks: true
				},
				title:{
					text:''
				},
				exporting : {
					enabled : false,
					scale: 3,
					fallbackToExportServer: false,
					chartOptions:{
						chart : {
						//	spacingBottom : 85,
						events : {
							load : function(){
								//this.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-export.png', 385, 315, 195,16).add();
								//this.renderer.text("Source : "+self.data.sources, 10, 325, 159, 33).css({size:'3px'}).add();
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
						//itemWidth : position_legend_width_export,
						//x : position_legend_x_export,
						align : 'center',						
						itemStyle : {
							color : '#274b6d',
							fontSize : 11
						}
					},
					xAxis: {
						scrollbar: {
							enabled: false
						}
					},
				}
			},
			colors : self.chartConfigs.colors,
			credits : {
				enabled : false,
				href : 'http://japanmacroadvisors.com',
				text : 'japanmacroadvisors.com'
			},
			legend :legend,
			responsive: responsive,

			
			plotOptions:plotOptions,
			series : (self.chartType).match('multiaxis') ? formetted_data_series.dataSeries:self.data.chartDataSeries,
			yAxis : (self.chartType).match('multiaxis') ? formetted_data_series.yAxis:yAxis,
			xAxis : xAxis,
			tooltip: toolTip,

			
		}, function(p_chrtObj) {
if(JMA.myChart.myFolder.currentView=='largeView'){
			p_chrtObj.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', 325, 380, 170,14).add();
			p_chrtObj.renderer.text("Source : "+self.data.sources, 10, 390, 159, 33).add();
}
			if(self.navigator_date_from!=''){

				p_chrtObj.xAxis[0].setExtremes(
					self.navigator_date_from-1,
					self.navigator_date_to);
			}

			p_chrtObj.yAxis[0].update({reversed: self.reverseYAxis });


			
		});






};








	/**
	 * Function drawLineChart
	 * Draw Line chart
	 */
	 this.drawLineChart = function(graph_container,graph_containerID){


		// ********************************************	
		// draw hoghchart
		var isBig  = window.matchMedia( "(min-width: 1025px)" );

		if(isBig.matches)
		{
			var tooltipstyle={};
		}else{
			var tooltipstyle={ width: '100px'};
		}

		if(JMA.myChart.myFolder.currentView=='smallView'){
			var Xaxislbl_style={fontSize: 7 } 
		}else{
			var Xaxislbl_style={fontSize: 11 } 
		}

		var position_legend_x = 17;
		var position_legend_width = 527;
		var position_legend_x_export = 17;
		var position_legend_width_export = 547;
		var quaterly_Extra = {};
		if (this.chart_data_type == 'quaterly') {
			var quaterly_Extra = {
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

		          //  startOnTick : true,
		          tickPositioner: function (vMin,vMax) {
		          	return self.generateChartTickPositions(vMin,vMax);
		          }
		        };
		    }
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

				 $.extend( true, xAxis, quaterly_Extra );
				 if (this.chart_data_type == 'quaterly') {
		        var toolTip = {
		        	formatter: function () {
		        		var s = '<b>';
	        		var ss = '';	 var _Inside_data_Type;
	        		$.each(this.points, function (i, point) {
						var eachSeriesData=point.series.userOptions.data;
						var graph_code__=self.current_chart_codes[point.series.colorIndex];
						var res = graph_code__.match(/163/gi);
						if(res!=null){
						if(eachSeriesData.length==(point.point.index+1)){
							var eachSeriesDataLast=point.point.index-1;
						}else{
							var eachSeriesDataLast=point.point.index+1;
						}
						var eachSeriesDataQuat=point.point.index;
						}else{
						var eachSeriesDataLast=eachSeriesData.length-1;
						var eachSeriesDataQuat=eachSeriesData.length-2;
						}

//var Second_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataLast][0]));
//var First_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffTime = Math.abs(parseInt(eachSeriesData[eachSeriesDataLast][0]) - parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
//console.log(diffDays);
					if(diffDays>=90 && diffDays<=92){
						 _Inside_data_Type='quaterly';
					}else if(diffDays>=28 && diffDays<=32){
					 _Inside_data_Type='monthly';
					}else if(diffDays>=360 && diffDays<=365){
					 _Inside_data_Type='anual';
					}else if(diffDays==1){
					 _Inside_data_Type='daily';
					}else{
						_Inside_data_Type=self.chart_data_type;
					}
					var s = '<b>';
                   if (_Inside_data_Type == 'quaterly') {
                   
					if (Highcharts.dateFormat('%b', point.x) == 'Mar') {
						s = s + "Q1"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Jun') {
						s = s + "Q2"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Sep') {
						s = s + "Q3"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Dec') {
						s = s + "Q4"
					}else{
						s = s +Highcharts.dateFormat('%b', point.x);
					}
					}else if(_Inside_data_Type == 'monthly'){
						s = s +Highcharts.dateFormat('%b', point.x);
	        		}else if(_Inside_data_Type == 'daily'){
						s = s +Highcharts.dateFormat('%a %b %e,', point.x);
	        		}
	        		// console.log(_Inside_data_Type);
					s = s + " " + Highcharts.dateFormat('%Y', point.x) + '</b>';
					var symbol = '<span style="color:' + point.series.color + '">●</span>';
						ss += symbol+ point.series.name +' ('+s+'): '+point.y+'<br/>';
					});
					ss=ss.slice(0,-5);
					return ss;
		        	},
		        	shared: true,
		        	style:tooltipstyle,
		        	followTouchMove: false,
		        	enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
		        	useHTML: true,
				//backgroundColor: null,//padding:10,
				// borderWidth: 0,
    //     shadow: false,
    			split: false,
	           
				positioner: function () {
            return { x: 0, y: 308 };
               }
		        };
		        
		      } else {
		      	
				var toolTip = {
					useHTML: true,padding:10,
				//backgroundColor: null,
				// borderWidth: 0,
    //     shadow: false,
    split: false,shared: true,
				positioner: function () {
            return { x: 0, y: 308 };
        },followTouchMove: false,style:tooltipstyle,enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false };
				
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
				colors : self.chartConfigs.colors,
				credits : {
					enabled : false,
					href : 'http://japanmacroadvisors.com',
					text : 'japanmacroadvisors.com'
				},
				exporting : {
					enabled : false,
					scale: 3,
					fallbackToExportServer: false,
					chartOptions:{
						chart : {
							//	spacingBottom : 85,
							events : {
								load : function(){
									//this.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-export.png', 385, 315, 195,16).add();
									//this.renderer.text("Source : "+self.data.sources, 10, 325, 159, 33).css({size:'3px'}).add();
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
							itemWidth : position_legend_width_export,
							x : position_legend_x_export,						
							itemStyle : {
								color : '#274b6d',
								fontSize : '11px'
							}
						},
						xAxis: {
							scrollbar: {
								enabled: false
							}
						},
					}
				},
				responsive: {
					rules: [{
						condition: {
							maxWidth: 500
						},
						chartOptions: {
							legend: {
								enabled: (JMA.myChart.myFolder.currentView ==
									'largeView') ? true : false,
								align: 'center',
								backgroundColor: '#dddddd',
								verticalAlign: 'top',
								labelFormatter: function() {
									var legendName = this.name;
									var match = legendName.match(/.{1,70}/g);
									return match.toString().replace(/\,/g,"<br/>");
								},
								layout: 'horizontal',
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
							legend: {
								enabled: (JMA.myChart.myFolder.currentView ==
									'largeView') ? true : false,
								align: 'center',
								backgroundColor: '#dddddd',
								verticalAlign: 'top',
								layout: 'horizontal',
								itemStyle: {
									color: '#274b6d'
								}
							},
						}
					}, ]
				},
				navigator : {
					enabled : false,
					maskFill : "rgba(0, 0, 0, 0.10)",
					series : {
						color:'rgba(51,92,173,0.05)',
						lineColor : '#DE4622'
					}
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
				},
				rangeSelector: {
					enabled : false,

				},
				scrollbar: {
					enabled : false ,
				},
				series : self.data.chartDataSeries,
				tooltip: toolTip,
				xAxis : xAxis,
				yAxis : yAxis
			}, function(p_chrtObj) {

				if(JMA.myChart.myFolder.currentView=='largeView'){
					p_chrtObj.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', 325, 380, 167,13).add();
					p_chrtObj.renderer.text("Source : "+self.data.sources, 10, 390, 159, 33).add();

				}

				p_chrtObj.xAxis[0].setExtremes(
					self.navigator_date_from-1,
					self.navigator_date_to);
			
					p_chrtObj.yAxis[0].update({reversed: JSON.parse(self.reverseYAxis) });
				    


			});





};

	/**
	 * Function drawLineChart
	 * Draw Bar chart
	 */
	 this.drawBarChart = function(graph_container,graph_containerID){

	 	var isBig  = window.matchMedia( "(min-width: 1025px)" );

	 	if(isBig.matches)
	 	{
	 		var tooltipstyle={};
	 	}else{
	 		var tooltipstyle={ width: '100px'};
	 	}

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
		var quaterly_Extra = {};
		if (this.chart_data_type == 'quaterly') {
			var quaterly_Extra = {
					
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
		          //  startOnTick : true,
		          tickPositioner: function (vMin,vMax) {
		          	return self.generateChartTickPositions(vMin,vMax);
		          }
		        };
		    }


		    var xAxis = {
		    	minRange: 1,
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

					 $.extend( true, xAxis, quaterly_Extra );

		        if (this.chart_data_type == 'quaterly') {
		        var toolTip = {
		        	formatter: function () {
		        	var ss = "";
						var _Inside_data_Type;
					$.each(this.points, function (i, point) {
						var eachSeriesData=point.series.userOptions.data;
						var graph_code__=self.current_chart_codes[point.series.colorIndex];
						var res = graph_code__.match(/163/gi);
						if(res!=null){
						if(eachSeriesData.length==(point.point.index+1)){
							var eachSeriesDataLast=point.point.index-1;
						}else{
							var eachSeriesDataLast=point.point.index+1;
						}
						var eachSeriesDataQuat=point.point.index;
						}else{
						var eachSeriesDataLast=eachSeriesData.length-1;
						var eachSeriesDataQuat=eachSeriesData.length-2;
						}

//var Second_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataLast][0]));
//var First_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffTime = Math.abs(parseInt(eachSeriesData[eachSeriesDataLast][0]) - parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
//console.log(diffDays);
					if(diffDays>=90 && diffDays<=92){
						 _Inside_data_Type='quaterly';
					}else if(diffDays>=28 && diffDays<=32){
					 _Inside_data_Type='monthly';
					}else if(diffDays>=360 && diffDays<=365){
					 _Inside_data_Type='anual';
					}else if(diffDays==1){
					 _Inside_data_Type='daily';
					}else{
						_Inside_data_Type=self.chart_data_type;
					}
					var s = '<b>';
                   if (_Inside_data_Type == 'quaterly') {
                   
					if (Highcharts.dateFormat('%b', point.x) == 'Mar') {
						s = s + "Q1"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Jun') {
						s = s + "Q2"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Sep') {
						s = s + "Q3"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Dec') {
						s = s + "Q4"
					}else{
						s = s +Highcharts.dateFormat('%b', point.x);
					}
					}else if(_Inside_data_Type == 'monthly'){
						s = s +Highcharts.dateFormat('%b', point.x);
	        		}else if(_Inside_data_Type == 'daily'){
						s = s +Highcharts.dateFormat('%a %b %e,', point.x);
	        		}
	        		// console.log(_Inside_data_Type);
					s = s + " " + Highcharts.dateFormat('%Y', point.x) + '</b>';
					var symbol = '<span style="color:' + point.series.color + '">●</span>';
						ss += symbol+ point.series.name +' ('+s+'): '+point.y+'<br/>';
					});
					ss=ss.slice(0,-5);
					return ss;
		        	},
		        	shared: true,
		        	style:tooltipstyle,
		        	followTouchMove: false,
		        	useHTML: true,
				   // backgroundColor: null,
				   // padding:10,
				   split: false,
	           
				// borderWidth: 0,
                //     shadow: false,
				positioner: function () {
                 return { x: 0, y: 308 };
                },
                enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false 
		        };
		        	
		      } else {
		      	
				
				var toolTip = { 
					useHTML: true,padding:10,
				//backgroundColor: null,
				// borderWidth: 0,
    //     shadow: false,
			split: false,
			shared: true,
				positioner: function () {
            return { x: 0, y: 308 };
        },followTouchMove: false,style:tooltipstyle,enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false };
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
									//this.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-export.png', 385, 315, 195,16).add();
									//this.renderer.text("Source : "+self.data.sources, 10, 325, 159, 33).css({size:'3px'}).add();
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

							itemStyle : {
								color : '#274b6d',

							}
						},
						xAxis: {
							scrollbar: {
								enabled: false
							}
						},
					}
				},
				colors : self.chartConfigs.colors,
				credits : {
					enabled : false,
					href : 'http://japanmacroadvisors.com',
					text : 'japanmacroadvisors.com'
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

				/*scrollbar:{
							enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false ,
						},*/
						responsive: {
							rules: [{
								condition: {
									maxWidth: 500
								},
								chartOptions: {
									legend: {
										enabled: (JMA.myChart.myFolder.currentView ==
											'largeView') ? true : false,
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
									legend: {
										enabled: (JMA.myChart.myFolder.currentView ==
											'largeView') ? true : false,
										align: 'center',
										backgroundColor: '#dddddd',
										verticalAlign: 'top',
										layout: 'horizontal',
										itemStyle: {
											color: '#274b6d'
										}
									},
								}
							}, ]
						},
						navigator : {
							enabled : false,
							maskFill : "rgba(0, 0, 0, 0.10)",
							series : {
								color:'rgba(51,92,173,0.05)',
								lineColor : '#DE4622'
							}
						},
						yAxis : yAxis,
						xAxis : xAxis,
						tooltip: toolTip
					}, function(p_chrtObj) {
						if(JMA.myChart.myFolder.currentView=='largeView'){
							p_chrtObj.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', 325, 380, 167,13).add();
							p_chrtObj.renderer.text("Source : "+self.data.sources, 10, 390, 159, 33).add();
						}
						p_chrtObj.xAxis[0].setExtremes(
							self.navigator_date_from-1,
							self.navigator_date_to);
						p_chrtObj.yAxis[0].update({reversed: JSON.parse(self.reverseYAxis) });
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
		if(isBig.matches)
		{
			var tooltipstyle={};
		}else{
			var tooltipstyle={ width: '100px'};
		}
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
		var quaterly_Extra = {};
		if (this.chart_data_type == 'quaterly') {
			var quaterly_Extra = {
					
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
					
					tickInterval: 3 * 30 * 24 * 3600 * 1000, 
					type: 'datetime',
		          //  startOnTick : true,
		          tickPositioner: function (vMin,vMax) {
		          	return self.generateChartTickPositions(vMin,vMax);
		          }
		        };
		    }


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
		$.extend( true, xAxis, quaterly_Extra );

if (this.chart_data_type == 'quaterly') {
		  var toolTip = {
		        	formatter: function () {
		        		var s = '<b>';
					var ss='';
					var _Inside_data_Type;
					$.each(this.points, function (i, point) {
						var eachSeriesData=point.series.userOptions.data;
						var graph_code__=self.current_chart_codes[point.series.colorIndex];
						var res = graph_code__.match(/163/gi);
						if(res!=null){
						if(eachSeriesData.length==(point.point.index+1)){
							var eachSeriesDataLast=point.point.index-1;
						}else{
							var eachSeriesDataLast=point.point.index+1;
						}
						var eachSeriesDataQuat=point.point.index;
						}else{
						var eachSeriesDataLast=eachSeriesData.length-1;
						var eachSeriesDataQuat=eachSeriesData.length-2;
						}

//var Second_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataLast][0]));
//var First_Point=Highcharts.dateFormat('%m', parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffTime = Math.abs(parseInt(eachSeriesData[eachSeriesDataLast][0]) - parseInt(eachSeriesData[eachSeriesDataQuat][0]));
var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
//console.log(diffDays);
					if(diffDays>=90 && diffDays<=92){
						 _Inside_data_Type='quaterly';
					}else if(diffDays>=28 && diffDays<=32){
					 _Inside_data_Type='monthly';
					}else if(diffDays>=360 && diffDays<=365){
					 _Inside_data_Type='anual';
					}else if(diffDays==1){
					 _Inside_data_Type='daily';
					}else{
						_Inside_data_Type=self.chart_data_type;
					}

					var s = '<b>';
                   if (_Inside_data_Type == 'quaterly') {
                   
					if (Highcharts.dateFormat('%b', point.x) == 'Mar') {
						s = s + "Q1"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Jun') {
						s = s + "Q2"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Sep') {
						s = s + "Q3"
					}else if (Highcharts.dateFormat('%b', point.x) == 'Dec') {
						s = s + "Q4"
					}else{
						s = s +Highcharts.dateFormat('%b', point.x);
					}
					}else if(_Inside_data_Type == 'monthly'){
						s = s +Highcharts.dateFormat('%b', point.x);
	        		}else if(_Inside_data_Type == 'daily'){
						s = s +Highcharts.dateFormat('%a %b %e,', point.x);
	        		}
	        		// console.log(_Inside_data_Type);
					s = s + " " + Highcharts.dateFormat('%Y', point.x) + '</b>';
					var symbol = '<span style="color:' + point.series.color + '">●</span>';
						ss += symbol+ point.series.name +' ('+s+'): '+point.y+'<br/>';
					});
					ss=ss.slice(0,-5);
					return ss;
		        	},
		        	shared: true,
		        	style:tooltipstyle,
		        	followTouchMove: false,
		        	useHTML: true,
		        	//backgroundColor: null,
		        	split: false,
	           
		        	//padding:10,
		        	// borderWidth: 0,
		        	// shadow: false,
		        	positioner: function () {
		        		return { x: 0, y: 308 };
		        	},
		        	enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false 
		        };
		      } else {
		      	
				
				var toolTip = {useHTML: true,padding:10,
				//backgroundColor: null,
				// borderWidth: 0,
    //     shadow: false,
				split: false,
				shared: true,
				positioner: function () {
            return { x: 0, y: 308 };
        },followTouchMove: false,style:tooltipstyle,enabled : (JMA.myChart.myFolder.currentView=='largeView') ? true :false };
			}
			


			
			$(self.color_code).each(function(index ) {
					if(self.color_code[index])
					{
						self.chartConfigs.colors[index] = self.color_code[index];
					}
		    });	
			
			
			return new Highcharts.StockChart({
				chart : {
					type:((self.chartType=='multiaxisbar')?'column':''),
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
									//this.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-export.png', 385, 315, 195,16).add();
									//this.renderer.text("Source : "+self.data.sources, 10, 325, 159, 33).css({size:'3px'}).add();
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

							itemStyle : {
								color : '#274b6d',
								fontSize : 11
							}
						},
						xAxis: {
							scrollbar: {
								enabled: false
							}
						},
					}
				},
				colors : self.chartConfigs.colors,
				credits : {
					enabled : false,
					href : 'http://japanmacroadvisors.com',
					text : 'japanmacroadvisors.com'
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
				},
				scrollbar: {
					enabled : false ,
				},
				responsive: {
					rules: [{
						condition: {
							maxWidth: 500
						},
						chartOptions: {
							legend: {
								enabled: (JMA.myChart.myFolder.currentView ==
									'largeView') ? true : false,
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
							legend: {
								enabled: (JMA.myChart.myFolder.currentView ==
									'largeView') ? true : false,
								align: 'center',
								backgroundColor: '#dddddd',
								verticalAlign: 'top',
								layout: 'horizontal',
								itemStyle: {
									color: '#274b6d'
								}
							},
						}
					}, ]
				},
				navigator : {
					enabled : false,
					maskFill : "rgba(0, 0, 0, 0.10)",
					series : {
						color:'rgba(51,92,173,0.05)',
						lineColor : '#DE4622'
					}
				},
				yAxis : formetted_data_series.yAxis,
				xAxis : xAxis,
				tooltip: toolTip
			}, function(p_chrtObj) {
				if(JMA.myChart.myFolder.currentView=='largeView'){
					p_chrtObj.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', 325, 380, 167,13).add();
					p_chrtObj.renderer.text("Source : "+self.data.sources, 10, 390, 159, 33).add();
				}
				p_chrtObj.xAxis[0].setExtremes(
					self.navigator_date_from-1,
					self.navigator_date_to);

				for(var yX=0; yX<p_chrtObj.userOptions.series.length; yX++) {
					if($.inArray(yX,self.reversedAxis_.map(Number)) != -1 && JSON.parse(self.reverseYAxis)==true){ 
					p_chrtObj.yAxis[yX].update({reversed: JSON.parse(self.reverseYAxis) });
				}
				    }
			});
	    // Drawn Highchart		
		// **************************************************			
	};	




//Class MapChart not stockchart

this.drawMapChart = function(graph_container,graph_containerID){
	var isBig  = window.matchMedia( "(min-width: 1025px)" );
			
				var Series_=[{
				
				name: 'States',
				showInLegend: false,
				type: 'map',
				enableMouseTracking: true
				},{
				
				name: 'State borders',
				showInLegend: false,
				color: 'silver',
				type: 'mapline',
				enableMouseTracking: true
				}//,mapbubble
			];

			
 Series_=Series_.concat(self.data.chartDataSeries);
  var Unit=self.chart_labels_available[self.current_chart_codes[0]];
Unit=$.trim(Unit.split('-')[1]);
if (Unit.indexOf(',') > -1) {  var Unit_=$.trim(Unit.split(',')[1]); }else var Unit_=Unit;

if($.trim(Unit)=='Persons'){
					var Stops=[
					[0, '#d6d4d4'],
					[0.1, '#b3b3b3'],
					[0.2, '#9a9a9a'],
					[0.3, '#b73f3f'],
					[0.4, '#af3333'],
					[0.5, '#ad2626'],
					[0.6, '#a51a1a'],
					[0.7, '#9a1010'],
					[0.8, '#890707'],
					[0.9, '#710808'],
					[1, '#5d0505']
					];
  						
  					}else{
  						var Stops=[
				[0, '#011f38'],
				[0.1, '#0560a3'],
				[0.2, '#5eb6f7'],
				[0.3, '#ff7075'],
				[0.4, '#ff545a'],
				[0.5, '#fc353c'],
				[0.6, '#f5020b'],
				[0.7, '#d1000b'],
				[0.8, '#9e0209'],
				[0.9, '#800308'],
				[1, '#4f0104']
				];
  					}
	var map_chart=new Highcharts.mapChart({
				chart: {
				//height: 550,
				/*backgroundColor : '#fff',
				plotBorderColor : '#000000',
				plotBackgroundColor : '#FFFFFF',
				plotBorderWidth : 0.5,*/
				spacingBottom : 35,
				alignTicks: true,
				renderTo : graph_container,
				map: 'countries/jp/jp-all-custom'
			   },
				exporting : {
				enabled : false,
				chartOptions:{
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
				credits : {
					enabled : false,
					href : 'http://japanmacroadvisors.com',
					text : 'Japanmacroadvisors.com'
				},
				title: {
				text: self.title+' ('+self.default_year+')',
				 useHTML: true,
				  style: {
				  	 'height': '29px',
				  	 'padding':'6px',
				    'color': '#274b6d',
				    'background-color': '#dddddd',
				    'fontWeight': 'bold',
				    'fontSize': '12px'
				  }
				},
				mapNavigation: {
				    enabled: true,
				    enableDoubleClickZoomTo: true,
				    buttonOptions: {
				      verticalAlign: 'top'
				    }
				 },
				legend: {
					 enabled: true,
				/*y: -80,title: {
				text: self.title,
				},*/
				align: 'right',
				verticalAlign: 'bottom',
				//y: 50,
				x: -20,
				floating: true,
				layout: 'vertical',
				valueDecimals: 0,
				symbolRadius: 0,
				},
				colorAxis: {
					gridLineWidth: 2,
					gridLineColor: 'white',
					minorTickInterval: 1,
					tickAmount: 10,
					reversed: false,
  					/*minColor: '#f5dfdf',
            		maxColor: '#FF0000',*/
            		//minColor: 'lightpink',
            		//maxColor: 'red',
            		stops: Stops,
					dataClasses: undefined,
					marker: {
					color: 'green'
					},
					type:'linear',
					
				},
				plotOptions: {
            	map: {
				allAreas: true,
				mapData: Highcharts.maps['countries/jp/jp-all-custom'],
				joinBy: 'hc-key',
				showInLegend: false,
				states: {
				hover: {
				color: '#BADA55'//BADA55
				}
				},
				dataLabels: {
				enabled: 0,
				format: '{point.name}'
				}
				},
				mapbubble: {
				allAreas: true,
				mapData: Highcharts.maps['countries/jp/jp-all-custom'],
				joinBy: 'hc-key',
				color: '#FF0088',
				showInLegend: false,
				minSize: 4, maxSize: '12%',
				states: {
				hover: {
				color: '#3366CC'//BADA55
				}
				},
				dataLabels: {
				enabled: 0,
				format: '{point.name}'
				}
				}
        },
				series: Series_,
				tooltip: {
				//valueSuffix: '%'	
				useHTML: !0,
				borderWidth: 1,
				borderColor: '#E60013',
				shadow: !0,
				formatter: function() {
				
				return '<b>' + this.point.name + '</b> <br> ' + $.trim(this.series.name.split('-')[0]) + ': <b>' + ((this.point.value==undefined)?this.point.z:this.point.value) + '</b>,' +  $.trim(Unit) + '<br/>Year: <b>'+self.default_year+'<b>';
				}
				}
  				},function(p_chrtObj){
  					var coloraxisLabel={enabled:true};
  					if($.trim(Unit_)=='Persons'){ coloraxisLabel= {
					formatter: function () {
					return (this.value); }  };
  					}
			p_chrtObj.colorAxis[0].update({ //type: 'logarithmic', // minColor: '#bada55', //maxColor: '#ff0000'
				min: p_chrtObj.colorAxis[0].dataMin,max: p_chrtObj.colorAxis[0].dataMax,labels:coloraxisLabel
			});
				p_chrtObj.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', 325, 380, 167,13).add();
					p_chrtObj.renderer.text("Source : "+self.data.sources, 10, 390, 159, 33).add();
				
			});

			return map_chart;
};



	
	/**
	 * Function createChartDataSeries()
	 * Funciton to create and format chart dara into series format for highchart
	 */
	 this.createChartDataSeries = function(data,colorCode){
	 	var chartDataSeries = [];
	 	var chart_series_count = 0;
		var d = 0;
	 	$.each(data, function(chartcode, chart_data_col) {
			
			if(self.color_code !== undefined)
			{
				if(self.color_code[d])
				{
					self.chartConfigs.colors[d] = self.color_code[d];
				}
			}
			
			chartDataSeries[chart_series_count] = {
					name : self.chart_labels_available[chartcode],
					data : chart_data_col
			}
			
	 		chart_series_count++;
			d++;
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
		
		
		if(JMA.controller == "mycharts" &&  JMA.action == "listChartBook")
		{
			
			if(JMA.userDetails.isAuthor == "Y")
			{
				var vars = {
					order : this.order,
					uuid : this.uuid,
					editOption : true
				};
			}
            else
            {
				var vars = {
					order : this.order,
					uuid : this.uuid
				};
			}  				

		}
        else
        {
			var vars = {
				order : this.order,
				uuid : this.uuid,
				editOption : true
			};

		}	
	 	
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
		
		if(JMA.controller == "mycharts" &&  JMA.action == "listChartBook")
		{
			
			if(JMA.userDetails.isAuthor == "Y")
			{
				var chartLayoutData = {
					title : this.title,
					order : pOrder,
					uuid : this.uuid,
					isDisabled : pIsDisabled,
					editOption : true
	 	        };
			}
			else
			{
				var chartLayoutData = {
					title : this.title,
					order : pOrder,
					uuid : this.uuid,
					isDisabled : pIsDisabled,
					editOption : false
	 	        };
			} 
			
		}
		else
		{
			var chartLayoutData = {
				title : this.title,
				order : pOrder,
				uuid : this.uuid,
				isDisabled : pIsDisabled,
				editOption : true
	 	    };
		}

	 	
	 	if(JMA.myChart.myFolder.currentView=='smallView'){
	 		var GettemplateId=$('#template_mychart_folder_content_chart_smallView_layout');

	 	}else if(JMA.myChart.myFolder.currentView=='listView'){
	 			
	 			var GettemplateId=$('#template_mychart_folder_content_list_layout');
		}else{
	 		var GettemplateId=$('#template_mychart_folder_content_chart_layout');
	 	}

	 	var chartLayout_object = Handlebars.compile(GettemplateId.html());
	 	return chartLayout_object(chartLayoutData);
	 };




	  this.getThisChartLayouts_ListviewDUB = function(pOrder,pIsDisabled){
		
		
			var chartLayoutData = {
				title : this.title,
				order : pOrder,
				uuid : this.uuid,
				isDisabled : pIsDisabled,
				editOption : true
	 	    };
		var GettemplateId=$('#template_mychart_folder_content_chart_layout');
	 	var chartLayout_object = Handlebars.compile(GettemplateId.html());
	 	return chartLayout_object(chartLayoutData);
	 };

	/**
	 * Function getThisNoteLayouts()
	 * Function to draw the note s layout for small view and large view.
	 */
	 this.getThisNoteLayouts = function(pOrder,pIsDisabled){
		 
		if(JMA.controller == "mycharts" &&  JMA.action == "listChartBook")
		{
			
			if(JMA.userDetails.isAuthor == "Y")
			{
				var vars = {
					title : this.title,
					order : pOrder,
					uuid : this.uuid,
					isDisabled : pIsDisabled,
					editOption : true
				};
			}
            else
            {
				var vars = {
					title : this.title,
					order : pOrder,
					uuid : this.uuid,
					isDisabled : pIsDisabled
				};
			}  				

		}
        else
        {
			var vars = {
				title : this.title,
				order : pOrder,
				uuid : this.uuid,
				isDisabled : pIsDisabled,
				editOption : true
			};

		}		
	 	

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
	 	$('.foldercontent-sub-menu').hide();
	 	var jq_frm_obj = $('#form_mychart_download_data');
	 	if(this.chartType=='map'){
			var $default_year=this.default_year;
			jq_frm_obj.append('<input type="hidden" name="default_year" value="'+$default_year+'">');
		}
	 	jq_frm_obj.find('#frm_input_download_chart_codes').attr('value',this.current_chart_codes.toString());
	 	jq_frm_obj.find('#frm_input_download_chart_datatype').attr('value',this.chart_data_type);
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
	 		scale:4,
	 		sourceWidth : 700,
	 		//sourceHeight : 350,
	 		filename : 'mychart-'+self.uuid,
		 url : JMA.Export_url
		//	url : 'http://testing.japanmacroadvisors.com/chart/exportChart'


	});
	 };

	/**
	 * Function generateChartTickPositions()
	 * Funciton to generate custom chart tick positions
	 */
	 this.generateChartTickPositions = function(vMin,vMax){

	 	var positions = [];
	 	var quarters = [2,5,8,11];
	 	var min_year = Highcharts.dateFormat('%Y', parseInt(vMin));
	 	var max_year = Highcharts.dateFormat('%Y', parseInt(vMax));
	 	var max_quarter = Math.floor(Highcharts.dateFormat('%m', parseInt(vMax))/3);
	 	var min_quarter = Math.floor(Highcharts.dateFormat('%m', parseInt(vMin))/3);
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
	   	 	for(var year_count = min_year; year_count<=max_year;year_count++){
	   	 		new_tick = Date.UTC(year_count,1,1);
	   	 		positions.push(new_tick);
	   	 	}
	   	 	/*var interval = (Math.floor(period_diff / 8)) * 31556952000;
	   	 	for(var t_vMin = vMin; t_vMin<=vMax; t_vMin+=interval){
	   	 		new_tick = Date.UTC(Highcharts.dateFormat('%Y', t_vMin),1,1);
	   	 		positions.push(new_tick);
	   	 	}*/
	   	 }
	   	 return positions;
	   	};

	/**
	 * Function formatData(row data)
	 * Function to Format chart data
	 */
	 this.formatData = function(ap_data){

	 	var out_data = {};
if(ap_data !==undefined){
	 	$.each(ap_data,function(graph_code,data_rows){
	 		var p_data_rows = new Array();
	 		$.each(data_rows,function(ky,row){
	 			var dateReg = /^\d{1,2}([./-])\d{1,2}\1\d{4}$/



	 			if (dateReg.test(row[0])) {
	 				var datetimeVal = row[0].split('-');
	 				var utcTime = Date.UTC(datetimeVal[2],datetimeVal[1]-1,datetimeVal[0]);
	 				var float_value = row[1] == null ? null : parseFloat(row[1]);
	 				p_data_rows[ky] = [utcTime,float_value];
	 			}else{

	 				var float_value = row[1] == null ? null : parseFloat(row[1]);
	 				p_data_rows[ky] = [parseFloat(row[0]),float_value];	

	 			}
	 		});
	 	out_data[graph_code] = p_data_rows;
	 });
	 }
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
});
	
	
	
	
	function selectallEmail(typeofAlert)
	{
		
		$('#update_success').html('');
		$('#errEmailAlert').html(''); 
		if(JMA.controller == "user" && JMA.action == "unsubscribe_user")
		{
			$("#remove_box").removeAttr("checked");
		}
		
		if(typeofAlert == "reports and indicator")
		{
			
			$("#checkDefaultemailAlert").removeAttr("checked");
			$("#remove_box").removeAttr("checked");
			ckeboxStatus = document.getElementById("checkAllemailAlert").checked;
			if(ckeboxStatus == true)
			{
				document.getElementById("update_success").innerHTML = " ";
				$(".email_alert").attr("checked", "checked");
				
				$("#thematic_report").attr("checked", "checked");
					
				document.getElementById("is_thematic").value = "Y";
				
				
			}
			 else
			{
				document.getElementById("update_success").innerHTML = " ";
				$(".email_alert").removeAttr("checked");
				
				$("#thematic_report").removeAttr("checked");
				document.getElementById("is_thematic").value = "N";
			} 
		
		}
		else
		{
			$("#checkDefaultemailAlertOnlyIndicator").removeAttr("checked");
			ckeboxStatus = document.getElementById("checkAllemailAlertOnlyIndicator").checked;
			if(ckeboxStatus == true)
			{
				document.getElementById("update_success").innerHTML = " ";
				$(".email_alert_all").attr("checked", "checked");
				if(JMA.controller == "user" && JMA.action == "unsubscribe_user")
				{
					$("#thematic_report").attr("checked", "checked");
					
					document.getElementById("is_thematic").value = "Y";
				
				}
			}
			 else
			{
				document.getElementById("update_success").innerHTML = " ";
				$(".email_alert_all").removeAttr("checked");
				if(JMA.controller == "user" && JMA.action == "unsubscribe_user")
				{
					$("#thematic_report").removeAttr("checked");
					document.getElementById("is_thematic").value = "N";
				}
			} 
		}
	}

	
	function removeallEmail(freeUserDefat)
	{
		
		$('#update_success').html('');
		$('#errEmailAlert').html(''); 
		$("#thematic_report").removeAttr("checked");
		$("#checkAllemailAlert").removeAttr("checked");
		$("#checkDefaultemailAlert").removeAttr("checked");
		$(".email_alert").removeAttr("checked");
		document.getElementById("alert_value").value = 0;
		document.getElementById("is_thematic").value = "N";
		
		if(freeUserDefat != false && freeUserDefat !='')
		{
			freeUserDefatss = freeUserDefat.split(",");
			freeUserDefatss.forEach(function($key)
			{
				document.getElementById("emailAlert_indicators_"+$key).removeAttribute("disabled");
				
				if(document.getElementById("remove_box").checked==true)
				{
					if (document.getElementById("emailAlert_indicators_"+$key).parentElement.classList.value == "control control--checkbox")
					{
						var $ul = $("#emailAlert_indicators_"+$key).parent();
						$ul.removeClass("control control--checkbox").addClass("control control--checkbox  jma-disable");
						document.getElementById("emailAlert_indicators_"+$key).checked = false;
					}
					else
					{
						console.log("dsadsds");
						var $ul = $("#emailAlert_indicators_"+$key).parent();
						$ul.removeClass("control control--checkbox").addClass("control control--checkbox  jma-disable");
						document.getElementById("emailAlert_indicators_"+$key).checked = false;
					}
					
				}
				else
				{
					if (document.getElementById("emailAlert_indicators_"+$key).parentElement.classList.value == "control control--checkbox jma-disable")
					{
						var $ul = $("#emailAlert_indicators_"+$key).parent();
						$ul.removeClass("control control--checkbox jma-disable").addClass("control control--checkbox");
						document.getElementById("emailAlert_indicators_"+$key).checked = true;
					}
					else
					{
						var $ul = $("#emailAlert_indicators_"+$key).parent();
						$ul.removeClass("control control--checkbox jma-disable").addClass("control control--checkbox");
						document.getElementById("emailAlert_indicators_"+$key).checked = true;
					}
				}
				
			})
		}	
		
	}
	
	function selectdefaultEmail(defaultMails,typeAlert)
	{
		$('#update_success').html('');
		$('#errEmailAlert').html(''); 
		if(typeAlert == "reports and indicator")
		{
			ckeboxStatus = document.getElementById("checkDefaultemailAlert").checked;
			
			noneStatus = document.getElementById("remove_box").checked;
			if(noneStatus == true)
			{
				$("#remove_box").removeAttr("checked");
			}
			
			if(ckeboxStatus == true)
			{
				$("#checkAllemailAlert").removeAttr("checked");
				$("#remove_box").removeAttr("checked");
				$("#thematic_report").removeAttr("checked");
				$("#checkAllemailAlert").removeAttr("checked");
				document.getElementById("is_thematic").value = "N";
				var defEmail = defaultMails.split(',');
			
				$(".email_alert").removeAttr("checked");
				
				for (var i=0, n=defEmail.length;i<n;i++) 
				{
					$("#emailAlert_indicators_"+defEmail[i]).attr("checked", "checked");
					$("#thematic_report").attr("checked", "checked");
					document.getElementById("is_thematic").value = "Y";
					
				}
			}
			else
			{
				document.getElementById("is_thematic").value = "N";
				$(".email_alert").removeAttr("checked");
				if(JMA.controller == "user" && JMA.action == "unsubscribe_user")
				{
					
				}
				
			}
		}
		else
		{
			ckeboxStatus = document.getElementById("checkDefaultemailAlertOnlyIndicator").checked;
			if(ckeboxStatus == true)
			{
				$("#checkAllemailAlertOnlyIndicator").removeAttr("checked");
				if(JMA.controller == "user" && JMA.action == "unsubscribe_user")
				{
					$("#remove_box").removeAttr("checked");
					$("#thematic_report").removeAttr("checked");
					$("#checkAllemailAlertOnlyIndicator").removeAttr("checked");
					document.getElementById("is_thematic").value = "N";
					
				}
				var defEmail = defaultMails.split(',');
			
				$(".email_alert_all").removeAttr("checked");
				
				for (var i=0, n=defEmail.length;i<n;i++) 
				{
					$("#emailAlert_only_indicators_"+defEmail[i]).attr("checked", "checked");
				}
			}
			else
			{
				$(".email_alert_all").removeAttr("checked");
				if(JMA.controller == "user" && JMA.action == "unsubscribe_user")
				{
					
				}
				
			}

		}
		document.getElementById("update_success").innerHTML = " ";
		
	}
	
	function checkDefaultRemove(defaultMails,emailCategory,type)
	{
		
		 
		$('#update_success').html(''); 
		$('#errEmailAlert').html(''); 
		var defEmail = defaultMails.split(',');
		var emailCategoryEmail = emailCategory.split(',');
		  
		
		if(type == "reports and indicator")
		{
			 var arr = [];
			  $('input:checkbox.email_alert').each(function () {
				   var sThisVal = (this.checked ? $(this).val() : "");
				   if(sThisVal !="")
				   {
					   arr.push($(this).val());
				   }
				   
			  });
			  
			  var names = arr;
			var uniqueNames = [];
			$.each(names, function(i, el){
				if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
			});
			
			if(JSON.stringify(defEmail)==JSON.stringify(arr)==true)
			{
				ckeboxDefault = document.getElementById("thematic_report").checked;
				if(ckeboxDefault == true)
				{
					$("#checkDefaultemailAlert").attr("checked", "checked");
				}
				
			}
			else
			{
				$("#checkDefaultemailAlert").removeAttr("checked");
			}
			
			if(JSON.stringify(emailCategoryEmail)==JSON.stringify(uniqueNames)==true)
			{
				
				ckeboxDefault = document.getElementById("thematic_report").checked;
				if(ckeboxDefault == true)
				{
					$("#checkAllemailAlert").attr("checked", "checked");
				}
				
			}
			else
			{
				
				$("#checkAllemailAlert").removeAttr("checked");
			}
		}
		else
		{
			var arr = [];
			  $('input:checkbox.email_alert_all').each(function () {
				   var sThisVal = (this.checked ? $(this).val() : "");
				   if(sThisVal !="")
				   {
					   arr.push($(this).val());
				   }
				   
			  });
			  
			var names = arr;
			var uniqueNames = [];
			$.each(names, function(i, el){
				if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
			});
			
			console.log(JSON.stringify(emailCategoryEmail));
			console.log(JSON.stringify(uniqueNames)); 
			
			if(JSON.stringify(defEmail)==JSON.stringify(uniqueNames)==true)
			{
				$("#checkDefaultemailAlertOnlyIndicator").attr("checked", "checked");
			}
			else
			{
				$("#checkDefaultemailAlertOnlyIndicator").removeAttr("checked");
			}
			 
			if(JSON.stringify(emailCategoryEmail)==JSON.stringify(uniqueNames)==true)
			{
				
				$("#checkAllemailAlertOnlyIndicator").attr("checked", "checked");
			}
			else
			{
				
				$("#checkAllemailAlertOnlyIndicator").removeAttr("checked");
			}
		}
		 
		  ckeboxfour = document.getElementById("remove_box").checked;
		  if(ckeboxfour == true)
		  {
			  $("#remove_box").removeAttr("checked");
		  }
		  
		 
	}
	
	function hideCollapseBox(type,defltVal)
	{
		$('#update_success').html('');
		$('#errEmailAlert').html(''); 
		defltVal = (typeof defltVal !== 'undefined') ?  defltVal : '';
		document.getElementById("errEmailAlert").innerHTML = "";
		document.getElementById("update_success").innerHTML = " ";
		document.getElementById("alert_type").value = type;
		if(type==2)
		{
			document.getElementById("alert_value").value = "0";
			document.getElementById("is_thematic").value = "Y";
		}
		else if(type==3)
		{
			document.getElementById("is_thematic").value = "Y";
		}
		else if(type==1)
		{
			document.getElementById("is_thematic").value = "N";
		}
		else if(type==4)
		{
			document.getElementById("is_thematic").value = "N";
		}
		
		var statusCollaps = $('#email-custom').hasClass('in');
		
		if(statusCollaps == true)
		{
			$('#email-custom').collapse("hide");
		}
		
		var statusCollaps1 = $('#email-custom1').hasClass('in');
	
		if(statusCollaps1 == true)
		{
			$('#email-custom1').collapse("hide");
		}
		
		
		
	}
	
	function mailAlertUpdate()
	{
		document.getElementById("update_success").innerHTML = " ";
		document.getElementById("errEmailAlert").innerHTML = "";
		
		
		if(document.getElementById("alert_type").value == 3)
		{
			var checkboxes = document.getElementsByName('emailAlert[]');
			var vals = "";
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{
					vals += ","+checkboxes[i].value;
				}
			}
			if (vals) vals = vals.substring(1);
			document.getElementById("alert_value").value = 0;
			if(vals != "")
			{
				document.getElementById("alert_value").value = vals;
			}	
			
			//return false; 
		}
		else if(document.getElementById("alert_type").value == 4)
		{
			var checkboxes = document.getElementsByName('emailAlertOnlyIndicator[]');
			var vals = "";
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{
					vals += ","+checkboxes[i].value;
				}
			}
			if (vals) vals = vals.substring(1);
			document.getElementById("alert_value").value = vals;
		}
		else if(document.getElementById("alert_type").value == 1)
		{
			document.getElementById("alert_value").value = 0;
		}
		
		thematicReport = document.getElementById("thematic_report").checked;
		if(thematicReport == true)
		{
			document.getElementById("is_thematic").value = "Y";
		}
		else
		{
			document.getElementById("is_thematic").value = "N";
		}
		
		
		
		/* ckeboxone = document.getElementById("checkAllemailAlert").checked;
		ckeboxTwo = document.getElementById("checkDefaultemailAlert").checked;
		ckeboxThree = document.getElementById("remove_box").checked;
		console.log(ckeboxone);
		console.log(ckeboxTwo);
		console.log(ckeboxThree);
		
		if(ckeboxone == false && ckeboxTwo == false && ckeboxThree == false && vals == "")
		{
			document.getElementById("errEmailAlert").innerHTML = "Please select atleast one checkbox";
			return false;
		} */
	}
	
	function issetThematicReports(defaultMails,emailCategory)
	{
		
		
		$('#update_success').html('');
		$('#errEmailAlert').html(''); 
		ckeboxStatus = document.getElementById("thematic_report").checked;
		ckeboxDefault = document.getElementById("thematic_report").checked;
		if(ckeboxStatus == true)
		{
			document.getElementById("is_thematic").value = "Y";
			
			var defEmail = defaultMails.split(',');
			var emailCategoryEmail = emailCategory.split(',');
				
		    var arr = [];
			  $('input:checkbox.email_alert').each(function () {
				   var sThisVal = (this.checked ? $(this).val() : "");
				   if(sThisVal !="")
				   {
					   arr.push($(this).val());
				   }
				   
			  });
			  
			  var names = arr;
			var uniqueNames = [];
			$.each(names, function(i, el){
				if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
			});
			
			
			
			if(JSON.stringify(defEmail)==JSON.stringify(arr)==true)
			{
				
				$("#checkDefaultemailAlert").removeAttr("checked");
				if(ckeboxDefault == true)
				{
					$("#checkDefaultemailAlert").attr("checked", "checked");
				}
			}
			
			
			if(JSON.stringify(emailCategoryEmail)==JSON.stringify(uniqueNames)==true)
			{
				ckeboxAllReport = document.getElementById("thematic_report").checked;
				if(ckeboxAllReport == true)
				{
					$("#checkAllemailAlert").attr("checked", "checked");
					$("#checkDefaultemailAlert").removeAttr("checked");
				}
				else
				{
					$("#checkAllemailAlert").removeAttr("checked");
				}
				
			}
			
			
		}
		else
		{
			
			document.getElementById("is_thematic").value = "N";
			
			ckeboxAll = document.getElementById("checkAllemailAlert").checked;
			if(ckeboxAll == true)
			{
				$("#checkAllemailAlert").removeAttr("checked");
			}
			
			
			
			var defEmail = defaultMails.split(',');
			var emailCategoryEmail = emailCategory.split(',');
				
		    var arr = [];
			  $('input:checkbox.email_alert').each(function () {
				   var sThisVal = (this.checked ? $(this).val() : "");
				   if(sThisVal !="")
				   {
					   arr.push($(this).val());
				   }
				   
			  });
			  
			  var names = arr;
			var uniqueNames = [];
			$.each(names, function(i, el){
				if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
			});
			
			
			if(JSON.stringify(defEmail)==JSON.stringify(arr)==true)
			{
				$("#checkDefaultemailAlert").attr("checked", "checked");
				
			
				if(ckeboxDefault == false)
				{
					$("#checkDefaultemailAlert").removeAttr("checked");
				}
			}
			else
			{
				$("#checkDefaultemailAlert").removeAttr("checked");
			}
			
			if(JSON.stringify(emailCategoryEmail)==JSON.stringify(uniqueNames)==true)
			{
				ckeboxAllReport = document.getElementById("thematic_report").checked;
				if(ckeboxAllReport == true)
				{
					$("#checkAllemailAlert").attr("checked", "checked");
				}
				else
				{
					$("#checkAllemailAlert").removeAttr("checked");
				}
				
			}
			
			
			
			
			
			
			
		}
		
		ckeboxfour = document.getElementById("remove_box").checked;
		if(ckeboxfour == true)
		{
		  $("#remove_box").removeAttr("checked");
		}
		
		
		
		
		
	}
	
	function mailWithOutLoginAlertUpdate()
	{
		document.getElementById("update_success").innerHTML = " ";
		ckeboxStatus = document.getElementById("remove_box").checked;
		if(ckeboxStatus == true)
		{
			document.getElementById("alert_value").value = "0";
		}
		else
		{
			var checkboxes = document.getElementsByName('emailAlert[]');
			if(checkboxes.length>0)
			{
				var vals = "";
				for (var i=0, n=checkboxes.length;i<n;i++) 
				{
					if (checkboxes[i].checked) 
					{
						vals += ","+checkboxes[i].value;
					}
				}
				if (vals) vals = vals.substring(1);
			document.getElementById("alert_value").value = vals;
		   }
		}
		
	}
	
	
	

// stick menu on top using offset
function sticky_relocate() {
	var window_top = $(window).scrollTop();
	var div_top = $('.folnav_stipos').offset().top-20;
	if (window_top > div_top) {
		$('.folnav_stick').addClass('pos-fixed');
	} else {
		$('.folnav_stick').removeClass('pos-fixed');
	}
}



$(document).ready(function(){


$("#reg_first_name,#reg_last_name").on('paste', function() {
 
  var regex = /^[a-zA-Z]+$/;

  if (!regex.test(this.value))
 return false;
});

      $("#reg_first_name").on('paste keypress keydown blur keyup', function() {

      
       if(this.value!=''){
         var str=this.value;
         var str1=str.replace(/[^a-z]+/gi,'');
         $(this).val(str1);
           
       }

 });
    });


// allow only character 
function IsCharacter(evt) 
{

		// For Alaphabets
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode != 13 && charCode != 32  && charCode != 9 && charCode != 8 && charCode != 127 && (charCode <= 38 || charCode >= 40)) && (evt.keyCode != 46))

		{
			return false;
		}   
		return true;
	}

	// Allow only for Numbers
	function IsPhoneNumber(evt) 
	{
		
		// For Number
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (((charCode < 48 || charCode > 57)  && charCode != 32   && charCode != 40 && charCode != 41  && charCode != 43 && charCode != 45 && charCode != 8 && charCode != 127 && charCode != 9 && charCode != 17 && charCode != 18 && (charCode < 37 || charCode > 40)) && (evt.keyCode != 46))
		{
			return false;
		}   
		return true;
	}



	// Recalling All The refernce functionalities by veera

	function exportChart_(chartIndex){

		JMA.JMAChart.exportChart(chartIndex);

	}


	function exportTabChart_(chartIndex){

		JMA.JMAChart.exportTabChart(chartIndex);

	}


	function addThisGraphCode_(chartIndex){

		JMA.JMAChart.addThisGraphCode(chartIndex);

	}

	function printChart_(chartIndex){

		JMA.JMAChart.printChart(chartIndex);

	}



	function downloadChartData_(chartIndex){

		JMA.JMAChart.downloadChartData(chartIndex);

	}


	function saveThisChartToFolder_(chartIndex){


		JMA.myChart.saveThisChartToFolder(chartIndex);

	}
	
	
	function saveThisChartToBook_(chartIndex){


	   JMA.myChart.saveThisChartToBook(chartIndex);
	
    }

	function switchToBarChart_(chartIndex,$this){
		
		JMA.JMAChart.switchToBarChart(chartIndex,$this);

	}

	function SeriesColorDropdown_(chartIndex,Index,$this){

		JMA.JMAChart.SeriesColorDropdown(chartIndex,Index,$this);

	}

	function replaceThisGraphCode_(chartIndex,Index,$this){

		JMA.JMAChart.replaceThisGraphCode(chartIndex,Index,$this);

	}

	

	function populateYSubDropdown_(chartIndex,Index,$this){

		JMA.JMAChart.populateYSubDropdown(chartIndex,Index,$this);

	}
	
	
	function changeColorofCharts_(chartIndex,colorCode,indexChart1){
		
		JMA.JMAChart.changeColorofChartForIndicator(chartIndex,colorCode,indexChart1);

	}


	function removeThisChartCodeByIndex_(chartIndex,Index){

		JMA.JMAChart.removeThisChartCodeByIndex(chartIndex,Index);

	}


	function switchToMultiAxisLine_(chartIndex,$this){

		JMA.JMAChart.switchToMultiAxisLine(chartIndex,$this);


	}

	function initiateChart_(chartIndex,chartDetails){

		JMA.JMAChart.initiateChart(chartIndex,chartDetails);

	}

	function drawAllCharts_(){

		JMA.JMAChart.drawAllCharts();

	}


	function afterLinkedinlogindownloadCsv(downloadChartId){

		
var graph_gids = JMA.JMAChart.Charts[downloadChartId].Conf.current_chart_codes.toString();
document.getElementById('frm_input_download_chart_codes_'+downloadChartId).value=graph_gids;
document.getElementById('frm_input_download_chart_datatype_'+downloadChartId).value=(JMA.JMAChart.Charts[downloadChartId].Conf.chart_data_type);
document.getElementById('frm_download_chart_data_'+downloadChartId).submit();

	}
	
	
	function serialize_each_object(obj) {
			return Object.keys(obj).map(function(p) {
				return encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]);
			}).join("&");
	}
	
	function All_share(idx,shareNetwork)
	{
		var  authWindow;
		var chart = JMA.JMAChart.Charts[idx].chart_object;
	
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
						this.renderer.image(window.location.protocol+'//content.japanmacroadvisors.com/images/jma-logo-small.png', 385, 300, 195,16).add();
					this.renderer.text($('#Jma_chart_container_'+idx+' span:contains("Source")').text(), 10, 310, 159, 33).css({size:'3px'}).add();
							}
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
		$.ajax({
			type: 'POST',
			data: serialize_each_object({
				svg: chart_svg,
				scale:4,
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
	
	
	window.onload = function intializeColorPicker(){
	
		$( ".basicsss1" ).each(function( index ) {
		 var $div = $(this);
		 var indexChart = $div.attr('data-param1');
		 var indexChart1 = $div.attr('data-param2');
		  clicked = $(this).hasClass('sp-input');
		  
		 
		$('.basicsss1:eq('+index+')').spectrum({color: '#ECC',showInput: true,className: 'full-spectrum',
				showInitial: true,showPalette: true,showSelectionPalette: true,maxSelectionSize: 10,preferredFormat: 'hex',
				move: function (color) {
					
				},
				show: function () {
				
				},
				beforeShow: function () {
				
				},
				hide: function () {
				
				},
				change: function() {
					 var codeColor = $('.sp-input:eq('+index+')').val();	
					  var numItems = $('.sp-input').length;
					  JMA.JMAChart.Charts[indexChart].chartConfigs.colors[indexChart1] = codeColor;
				      changeColorofCharts_(indexChart,codeColor,indexChart1);
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


//Handlebars Helper added By Veera





Handlebars.registerHelper("last", function(array) {

	return array[array.length-1];
});



Handlebars.registerHelper("get_lastelm", function(array) {

	if(array[array.length-1].hasOwnProperty("yr")){
return (array[array.length-1].yr);
	}else{
		return (array[array.length-1].label);
	}

	return (array[array.length-1].label);

});

Handlebars.registerHelper("find_Currentval", function(array) {
	var CurrVal=(array[0].hasOwnProperty("yr"))?array[0].yr:array[0].label;
	$.each(array,function(idx,series){
		if(series.isCurrent){
			CurrVal=(series.hasOwnProperty("yr"))?series.yr:series.label;
		}

	});

	return CurrVal;
});


Handlebars.registerHelper("subtract", function(a, b) {

	return a-b;
});

Handlebars.registerHelper("in_array", function(a, b) {
return ($.inArray( b, a )!==-1)?true:false;
	
});

Handlebars.registerHelper('var',function(name, value, context){
	this[name] = value;
});




Date.prototype.yyyymmdd = function(type_s) {         
                      
        var yyyy = this.getFullYear().toString();                                    
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
        var dd  = this.getDate().toString();             
                            if(type_s=='yield_monthly'){
                            	return yyyy + '/' + (mm[1]?mm:"0"+mm[0]);
                            }else{
                            	return yyyy + '/' + (mm[1]?mm:"0"+mm[0]) + '/' + (dd[1]?dd:"0"+dd[0]);
                            }
        
   };

// For IE and Safari
if (typeof Object.assign != 'function') {
  Object.assign = function(target) {
    'use strict';
    if (target == null) {
      throw new TypeError('Cannot convert undefined or null to object');
    }

    target = Object(target);
    for (var index = 1; index < arguments.length; index++) {
      var source = arguments[index];
      if (source != null) {
        for (var key in source) {
          if (Object.prototype.hasOwnProperty.call(source, key)) {
            target[key] = source[key];
          }
        }
      }
    }
    return target;
  };
}

//Veera added
function ManualChartUpdate(Obj,OtherObj){
	

	if((OtherObj.current_chart_codes).length>0){
		var getCurrentChartCodes=OtherObj.current_chart_codes[0];
		//var getCurrentChartCodes=getCurrentChartCodes.splice(0,1).shift();
		//console.log(getCurrentChartCodes);
	/*if(((getCurrentChartCodes).toString()).match(/299/g)){
		Obj.yAxis[0].update({type: 'logarithmic',tickInterval:1,min: 10,title:''});Obj.xAxis[0].update({title:''});
	}*/

	if(OtherObj.chartIndex==1 && (((getCurrentChartCodes).toString()).startsWith("307") || ((getCurrentChartCodes).toString()).startsWith("16"))){
		if(!((getCurrentChartCodes).toString()).startsWith("16"))
		Obj.yAxis[0].update({type: 'logarithmic',tickInterval:0.1,min: 2});
	}
	if(((getCurrentChartCodes).toString()).startsWith("304") || ((getCurrentChartCodes).toString()).startsWith("6")){
		Obj.yAxis[0].update({type: 'logarithmic',tickInterval:1,min: 1,title:''});Obj.xAxis[0].update({reversed:0,title:''});
	}

	

	/*	if(((getCurrentChartCodes).toString()).match(/301/g)){
		Obj.yAxis[0].update({type: 'logarithmic',tickInterval:1,min: 10,title:''});
	}*/
}

}

function updateMaptickPositions(Obj,OtherObj){
var Unit=OtherObj.Conf.chart_labels_available[OtherObj.Conf.current_chart_codes[0]];
var Units=Unit.split('-');
if($.trim(Units[0]).startsWith('New') && $.trim(Units[1]).startsWith('Last')){
Obj.colorAxis[0].update({tickAmount:6,tickInterval:1,tickPositions:[0,10,20,30,40,50,60,70,80,90,100]});
}else if($.trim(Units[0]).startsWith('Deaths') && $.trim(Units[1]).startsWith('Daily') || $.trim(Units[0]).startsWith('死亡者数') && $.trim(Units[1]).startsWith('感染者数（新規）')){
Obj.colorAxis[0].update({tickAmount:6,tickInterval:1,tickPositions:[0,1,2,3,4,5,6,7,8,9,10]});
}else if($.trim(Units[0]).startsWith('Deaths') && $.trim(Units[1]).startsWith('Total') || $.trim(Units[0]).startsWith('死亡者数') && $.trim(Units[1]).startsWith('感染者数（累計）')){
	Obj.colorAxis[0].update({tickAmount:6,tickInterval:1,tickPositions:[0,3,6,9,12,15,18,21,24,27,30]});
}else if($.trim(Units[0]).startsWith('Tested') && $.trim(Units[1]).startsWith('Total') || $.trim(Units[0]).startsWith('感染者数') && $.trim(Units[1]).startsWith('感染者数（累計）')){
	Obj.colorAxis[0].update({tickAmount:6,tickInterval:300,tickPositions:[0,300,600,900,1200,1500,1800,2100,2400,2700,3000]});
}else if($.trim(Units[0]).startsWith('Recovered') && $.trim(Units[1]).startsWith('Daily') || $.trim(Units[0]).startsWith('退院者') && $.trim(Units[1]).startsWith('感染者数（新規）')){
	Obj.colorAxis[0].update({tickAmount:6,tickInterval:4,tickPositions:[0,4,8,12,16,20,24,28,32,36,40]});
}else{
	Obj.colorAxis[0].update({tickAmount:6,tickInterval:4,tickPositions:[0,20,40,60,80,100,120,140,160,180,200]});
}



}




