(function ($) {
  'use strict';

  window.app = {
    name: 'Flatkit',
    version: '1.1.0',
// for chart colors
color: {
  'primary':      '#0cc2aa',
  'accent':       '#a88add',
  'warn':         '#fcc100',
  'info':         '#6887ff',
  'success':      '#6cc788',
  'warning':      '#f77a99',
  'danger':       '#f44455',
  'white':        '#ffffff',
  'light':        '#f1f2f3',
  'dark':         '#2e3e4e',
  'black':        '#2a2b3c'
},
setting: {
  theme: {
    primary: 'primary',
    accent: 'accent',
    warn: 'warn'
  },
  color: {
    primary:      '#0cc2aa',
    accent:       '#a88add',
    warn:         '#fcc100'
  },
  folded: true,
  boxed: false,
  container: false,
  themeID: 1,
  bg: ''
}
};

var setting = 'jqStorage-'+app.name+'-Setting',
storage = $.localStorage;

if( storage.isEmpty(setting) ){
  storage.set(setting, app.setting);
}else{
  app.setting = storage.get(setting);
}
var v = window.location.search.substring(1).split('&');
for (var i = 0; i < v.length; i++)
{
  var n = v[i].split('=');
  app.setting[n[0]] = (n[1] == "true" || n[1]== "false") ? (n[1] == "true") : n[1];
  storage.set(setting, app.setting);
}

// init
function setTheme(){

  $('body').removeClass($('body').attr('ui-class')).addClass(app.setting.bg).attr('ui-class', app.setting.bg);
  app.setting.folded ? $('#aside').addClass('folded') : $('#aside').removeClass('folded');
  app.setting.boxed ? $('body').addClass('container') : $('body').removeClass('container');

  $('.switcher input[value="'+app.setting.themeID+'"]').prop('checked', true);
  $('.switcher input[value="'+app.setting.bg+'"]').prop('checked', true);

  $('[data-target="folded"] input').prop('checked', app.setting.folded);
  $('[data-target="boxed"] input').prop('checked', app.setting.boxed);

}

// click to switch
$(document).on('click.setting', '.switcher input', function(e){
  var $this = $(this), $target;
  $target = $this.parent().attr('data-target') ? $this.parent().attr('data-target') : $this.parent().parent().attr('data-target');
  app.setting[$target] = $this.is(':checkbox') ? $this.prop('checked') : $(this).val();
  ($(this).attr('name')=='color') && (app.setting.theme = eval('[' +  $(this).parent().attr('data-value') +']')[0]) && setColor();
  storage.set(setting, app.setting);
  setTheme(app.setting);
});

function setColor(){
  app.setting.color = {
    primary: getColor( app.setting.theme.primary ),
    accent: getColor( app.setting.theme.accent ),
    warn: getColor( app.setting.theme.warn )
  };
};

function getColor(name){
  return app.color[ name ] ? app.color[ name ] : palette.find(name);
};

function init(){
  $('[ui-jp]').uiJp();
  $('body').uiInclude();
}

$(document).on('pjaxStart', function() {
  $('#aside').modal('hide');
  $('body').removeClass('modal-open').find('.modal-backdrop').remove();
  $('.navbar-toggleable-sm').collapse('hide');
});

init();
setTheme();

// only number
$(document).ready(function(){
  $('[id=Vnumber], .Onumber').keypress(validateNumber);
});

function validateNumber(event) {
  var key = window.event ? event.keyCode : event.which;
  if (event.keyCode === 8 || event.keyCode === 46) {
    return true;
  } else if ( key < 48 || key > 57 ) {
    return false;
  } else {
    return true;
  }
};

$(document).ready(function(){
 $( ".txtOnly" ).keypress(function(e) {

                    var key = e.keyCode;
                    if (key >= 48 && key <= 57) {
                        e.preventDefault();
                    }
                });
                });

// input file show img
function readURL(input,ext) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {  
     if(ext=="pdf"){
       $('img.Simg_'+input.id).hide();
        $('embed.Simg_'+input.id).attr('src', e.target.result);
     }else{
        $('img.Simg_'+input.id).show();
        $('img.Simg_'+input.id).attr('src', e.target.result);
     }
    
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$(".Uimg").change(function(){
   var myfile= $( this ).val();
   var ext = myfile.split('.').pop();
   if(ext=="pdf" || ext=="gif" || ext=="jpg" || ext=="png" || ext=="jpeg"){
     readURL(this,ext);
   } else{
    $('.Simg_'+this.id).attr('src', WEB_URL+'assets/images/placeholder.jpg');
    $( this ).val('');
    alert('Please upload image or pdf file');
   }
 
});

// toggle menu
$(".menu-toggle").click(function(){   
    $("#aside").toggleClass("folded");
});

// added by designer
$( function() {
  var availableTags = [
  "ActionScript",
  "AppleScript",
  "Asp",
  "BASIC",
  "C",
  "C++",
  "Clojure",
  "COBOL",
  "ColdFusion",
  "Erlang",
  "Fortran",
  "Groovy",
  "Haskell",
  "Java",
  "JavaScript",
  "Lisp",
  "Perl",
  "PHP",
  "Python",
  "Ruby",
  "Scala",
  "Scheme"
  ];
  $( "#Vtype, .Tautcom" ).autocomplete({
    source: availableTags,
    open: function() {
      $("ul.ui-menu").width( $(this).innerWidth() );
    }
  });
} );
$(window).load(function() {
    if(WEB_METHOD=='add_vehicles' || WEB_CLASS=='cabs' || WEB_METHOD=='add_vehicle_category'){
    var script = document.createElement('script');
    script.src = WEB_URL+"libs/jquery/parsleyjs/dist/parsley.min.js";
    //document.script.appendChild(script);
    $( "body" ).after( script);
  }
});
$(document).ready(function(){
  if(WEB_METHOD=='add_vehicles' || WEB_CLASS=='cabs' || WEB_METHOD=='add_vehicle_category'){
      loadStyleSheet('libs/jquery/parsleyjs/dist/parsley.css');
  }

});

$(document).keydown(function(event) { 
  if (event.keyCode == 27) { 
    $('#animate').hide();
  }
});
function loadStyleSheet(src) {
  var ga = document.createElement('link'); ga.type = 'text/css'; ga.rel = 'stylesheet';
  
  ga.href =  WEB_URL+src;
  var s = document.getElementsByTagName('meta')[0]; s.parentNode.insertBefore(ga, s);
};
})(jQuery);