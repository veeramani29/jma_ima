// CSS 
require("./plugins/font-awesome/css/font-awesome.min.css");
require("./plugins/bootstrap/css/bootstrap.min.css");
require("./plugins/bootstrap-select/css/bootstrap-select.min.css");
require("./plugins/jquery-ui/jquery-ui.min.css");
require("./css/intlTelInput.css");
require("./css/jquery.alerts.css");
require("./plugins/animate/animate.min.css");
require("./css/ken-burns.css");
require("./css/spectrum.css");
require("./plugins/slick/slick.css");
require("./plugins/slick/slick-theme.css");
require("./plugins/ResponsiveMultiLevelMenu/css/component.css");
require("./css/custom-styles.css");
require("./css/media.css");
// Javascripts
require('./js/jquery.min.js');
var Handlebars =require('./js/handlebars-v2.0.0.js');
var Clipboard =require('./js/clipboard.min.js');
var Sortable =require('./js/Sortable.min.js');
require("./plugins/jquery-ui/jquery-ui.min.js");
require("./plugins/slick/slick.min.js");
require('./js/pack.js');
require('./js/intlTelInput.min.js');

// Global Variable
window.Handlebars = Handlebars;
window.Clipboard = Clipboard;
window.Sortable = Sortable;
module.exports = $.fn.datepicker;
module.exports = $.fn.intlTelInput;


