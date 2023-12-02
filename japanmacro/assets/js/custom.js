//script
if ( !("placeholder" in document.createElement("input")) ) {
  $("input[placeholder], textarea[placeholder]").each(function() {
    var val = $(this).attr("placeholder");
    if ( this.value == "" ) {
      this.value = val;
    }
    $(this).focus(function() {
      if ( this.value == val ) {
        this.value = "";
      }
    }).blur(function() {
      if ( $.trim(this.value) == "" ) {
        this.value = val;
      }
    });
  });
  // Clear default placeholder values on form submit
  $('form').submit(function() {
    $(this).find("input[placeholder], textarea[placeholder]").each(function() {
      if ( this.value == $(this).attr("placeholder") ) {
        this.value = "";
      }
    });
  });
}
$(document).ready(function(){
  if (window.matchMedia("(max-width: 991px)").matches) {
    $(window).scroll(function(){
      if ($(this).scrollTop() > 70) {
        $('nav').addClass('navbar-fixed-top');
      } else {
        $('nav').removeClass('navbar-fixed-top');
      }
    });
  }
  $('.mft_ttl').on('click', function(e){
    e.preventDefault();
    $('.myfol_toggle .mtf_content').toggleClass('active');
    $(this).toggleClass('active');
  });
})
$(document).on('click', '.mcem_toggle', function(e){
  e.preventDefault();
  $('.h_graph_tab_area').toggleClass('active');
  $(this).toggleClass('active');
});
// dropdown indide dropdown script //
$(document).ready(function(){
  $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).parent().siblings().removeClass('open');
    $(this).parent().toggleClass('open');
  });
  $('.navbar-toggle').on('click', function(event) {
    $('body').toggleClass('overflow-hidden');
    $('.myfol_toggle').toggleClass('hide');
    $('.mob_menubgoverlay').toggleClass('show');
  });
});
// Login Page Validation
$(document).ready(function(){
  $("#login_frm").validate({
    submitHandler: function(form) {
      $('html, body').animate({scrollTop : 0},800);
      form.submit();
    }
  });
  $("#register_pre_frm").validate({
    submitHandler: function(form) {
      $('html, body').animate({scrollTop : 0},800);
      form.submit();
    }
  });
  $("#oxford-economics").validate({
    submitHandler: function(form) {
      $('html, body').animate({scrollTop : 0},800);
      form.submit();
    }
  });
});
// Left side Toggle menu
$('.list-toggle > .content_leftside_parent').on('click', function(e) {
  $(this).toggleClass("minus"); //you can list several class names
  e.preventDefault();
});
// Jma Right Side Php
$(document).ready(function(){
  $(".jmaVideo").attr('src', '');
  $(".yt_videos").on('click',function(event){
    event.preventDefault();
    event.stopPropagation();
    var url = $(this).attr('href')+'?autoplay=1';
    var title = $(this).text();
    $(".jma_modvid").modal('show');
    $(".jma_modvid").on('shown.bs.modal', function(){
      $(".jma_modvid h4.modal-title").text(title);
      $(".jmaVideo").attr('src', url);
    });
  });
  $(".jma_modvid").on('hide.bs.modal', function(){
    $(".jmaVideo").attr('src', '');
  });
  // intro video
  $(".int-jmaVideo").attr('src', '');
  $(".int-ytvideos").on('click',function(event){
    event.preventDefault();
    event.stopPropagation();
    var url = $(this).attr('href')+'?autoplay=1';
    var title = $(this).text();
    $(".int-jmamodvid").modal('show');
    $(".int-jmamodvid").on('shown.bs.modal', function(){
      $(".int-jmamodvid h4.modal-title").text(title);
      $(".int-jmaVideo").attr('src', url);
    });
  });
  $(".int-jmamodvid").on('hide.bs.modal', function(){
    $(".int-jmaVideo").attr('src', '');
  });

});
//Dont Forgot To Call this functions drawing all the charts
$(window).load(function() {
  if(typeof JMA != "undefined") {
    if(JMA.JMAChart.Charts.length>0){
      JMA.JMAChart.drawAllCharts();
    }
  }
  $("div.input-group-addon i.fa-minus").trigger('click');
});
// Default Chart line color
$(document).ready(function(){
  loadStyleSheet('print_page.css');
});
function loadStyleSheet(src) {
  var ga = document.createElement('link'); ga.type = 'text/css'; ga.rel = 'stylesheet';
  if(src=='print_page.css'){
    ga.media="print"
  }
  ga.href = THIS_ASSETS+'css/'+ src;
  var s = document.getElementsByTagName('meta')[0]; s.parentNode.insertBefore(ga, s);
};
// Sign Up Script
$(function() {
  if(JMA.action=='signup' || JMA.action=='myaccount' || JMA.action=='dopayment')
    $('[name="country_code"]').intlTelInput({
      allowDropdown: true,
      autoHideDialCode: true,
      autoPlaceholder: true,
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
      utilsScript: 'js/utils.js',
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
  var last = theHref.substring(theHref.lastIndexOf("/") + 1, theHref.length);
  $('a.reg_linkedin').attr("href", (theHref.replace(last,sub_type)));
  jqO.find('span.fa-check').show();
});
$(function() {
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
  $("#signup_frm").validate({
    submitHandler: function(form) {
      $('.payloder').show();
      $('html, body').animate({scrollTop : 0},800);
      form.submit();
    }
  });
  function FirstName(){
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
  function LastName(){
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
  $('#signup_frm').on('submit', function() {
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
});
// clipboard
$('.clipboard_copy').tooltip({
  trigger: 'click',
  placement: 'bottom'
});
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
var clipboard = new Clipboard('.clipboard_copy');
clipboard.on('success', function(e) {
  setTooltip('Copied!');
  hideTooltip();
});
clipboard.on('error', function(e) {
  setTooltip('Failed!');
  hideTooltip();
});
// manage email alerts
$('.emaale_ttl').on('click', function(e) {
  $(this).toggleClass("minus");
  e.preventDefault();
});
if (window.matchMedia("(max-width: 991px)").matches) {
  $('#leftmenu_col1,#leftmenu_col2,#leftmenu_col3').removeClass('in');
  $('.lmc_trigger').on('click', function(e) {
    $(this).toggleClass("minus");
    e.preventDefault();
  });
}
// banner scroll up
if( (typeof (JMA.userDetails) === "object") && (JMA.userDetails).length!=0){
  if(JMA.controller=='page'){
    if (window.matchMedia("(max-width: 991px)").matches) {
      window.scroll(0, 170);
    }if (window.matchMedia("(max-width: 767px)").matches) {
      window.scroll(0, 100);
    }if (window.matchMedia("(max-width: 465px)").matches) {
      window.scroll(0, 130);
    }else {
      window.scroll(0, 450);
    }
  }else if(JMA.controller=='home'){
    if (window.matchMedia("(max-width: 991px)").matches) {
      window.scroll(0, 290);
    }else{
      window.scroll(0, 670);
    }
  }else if(JMA.controller=='aboutus' || JMA.controller=='contact'){
    if (window.matchMedia("(max-width: 991px)").matches) {
      window.scroll(0, 170);
    }else{
      window.scroll(0, 450);
    }
  }
}
// Bootstrap tooltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
// kenburns effect for home
$(function ($) {
  /*-----------------------------------------------------------------*/
  /* ANIMATE SLIDER CAPTION
  /* Demo Scripts for Bootstrap Carousel and Animate.css article on SitePoint by Maria Antonietta Perna
  /*-----------------------------------------------------------------*/
  "use strict";
  function doAnimations(elems) {
    //Cache the animationend event in a variable
    var animEndEv = 'webkitAnimationEnd animationend';
    elems.each(function () {
      var $this = $(this),
      $animationType = $this.data('animation');
      $this.addClass($animationType).one(animEndEv, function () {
        $this.removeClass($animationType);
      });
    });
  }
  //Variables on page load
  var $immortalCarousel = $('.animate_text'),
  $firstAnimatingElems = $immortalCarousel.find('.item:first').find("[data-animation ^= 'animated']");
  //Initialize carousel
  $immortalCarousel.carousel();
  //Animate captions in first slide on page load
  doAnimations($firstAnimatingElems);
});
// footer
$('.fc_readmore').readmore({
  speed: 500,
  collapsedHeight: 62
});
