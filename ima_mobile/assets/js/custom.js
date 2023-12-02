// clipboard

function setTooltip(message) {
  $('.clipboard_copy').tooltip('hide')
  .attr('data-original-title', message)
  .tooltip('show');
}
function hideTooltip() {
  setTimeout(function() {
    $('.clipboard_copy').tooltip('hide');
  }, 1000);
}




$(document).ready(function(){
  $('.mft_ttl').on('click', function(e){
    e.preventDefault();
    $('.myfol_toggle .mtf_content').toggleClass('active');
    $(this).toggleClass('active');
  });
})


// mobile edit chart toggle
$(document).on('click', '.mcem_toggle', function(e){
  e.preventDefault();
  $('.h_graph_tab_area').toggleClass('active');
  $(this).toggleClass('active');
});

// modal video play script (introduction to ima)
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var player;
function onYouTubeIframeAPIReady() {
  player = new YT.Player('ytplayer', {
    events: {
      'onReady': onPlayerReady
    }
  });
}
function onPlayerReady() {
  player.setVolume(10);
}

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

function removeallEmail()
	{
		$('#update_success').html('');
		$('#errEmailAlert').html(''); 
		$("#thematic_report").removeAttr("checked");
		$("#checkAllemailAlert").removeAttr("checked");
		$("#checkDefaultemailAlert").removeAttr("checked");
		$(".email_alert").removeAttr("checked");
		document.getElementById("alert_value").value = 0;
		document.getElementById("is_thematic").value = "N";
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


function onsubmitResume()
{
  $('#err_careers_resume').html('');
  if($('#careers_resume').val() == "")
  {
    $('#err_careers_resume').html('Please upload your resume');
    $('#careers_resume').focus();
    return false;
  }
}

function CheckResumefiles()
{
	$('#err_careers_resume').html('');
	var fup = document.getElementById('careers_resume');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	var size = fup.files[0].size;
	if(ext == "pdf" || ext == "PDF")
	{
		return true;
	} 
	else
	{
		$('#err_careers_resume').html('Upload pdf file only');
		fup.focus();
		return false;
	}
	if(size > MAX_SIZE){
		$('#err_careers_resume').html("Maximum file size exceeds");
		fup.focus();
		return false;

	}else{
		return true;
	}	
}

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
}

// footer toggle
$(document).on('click','.ft_btn',function(){
  $(".footer_container").slideToggle();
  $(".ft_btn").toggleClass("active");
  $("html, body").animate({ scrollTop: $(document).height() }, "slow");
});

$(document).on('click','.ips_shaico',function(){
  $(".ips_soc").slideToggle();
});
$(document).ready(function() {
  $("#user-login").click(function(e) {
    $(".user_dropdown").toggleClass('active');
    e.stopPropagation();
  });

  $(document).click(function(e) {
    if (!$(e.target).is('.user_dropdown, .user_dropdown *')) {
      $(".user_dropdown").removeClass('active');
    }
  });
});



// Bootstrap tooltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})