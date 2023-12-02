<!--footer section-->
<footer>
  <div class="footer_container">
    <div class="container">
      <div class="col-xs-12 col-md-8">
        <div class="sub-title">
          <h5>About us</h5>
          <div class="sttl-line"></div>
        </div>
        <p class="fc_readmore"> Japan Macro Advisors Inc. ("We") are not an investment advisory and we do not make any offer or solicitation to buy/sell financial securities or other type of assets. The information contained herein has been obtained from, or is based upon, sources believed by us to be reliable, but we do not make any representation or warranty for their accuracy or completeness. The text, numerical data, charts and other graphical contents we provide ("JMA contents") are copyrighted properties of Japan Macro Advisors ("Us"). While we permit personal non-commercial usage of JMA contents, it should be accompanied by an explicit mention that the contents belong to us. We do not allow any reproduction of JMA contents for other purposes unless specifically authorised by us. Please contact <a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a> to seek our authorization. </p>
        <div class="row">
          <div class="col-sm-6 col-xs-12">
            <div class="sub-title">
              <h5>Follow Us</h5>
              <div class="sttl-line"></div>
            </div>
            <ul class="list_socail">
              <li class="fs_linkedin">
                <a target="_blank" href="https://www.linkedin.com/company/japan-macro-advisors" data-toggle="tooltip" title="Linked in">
                  <i class="fa fa-linkedin" aria-hidden="true"></i>
                </a>
              </li>
              <li class="fs_twitter">
                <a target="_blank" href="https://twitter.com/JapanMadvisors" data-toggle="tooltip" title="Twitter">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
              </li>
              <li class="fs_facebook" data-toggle="tooltip" title="Facebook">
                <a target="_blank" href="https://www.facebook.com/Japanmacroadvisors/">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
              </li>
            </ul>
          </div>
          <div class="col-sm-6 col-xs-12">
            <div class="sub-title">
              <h5>Safe and Secure Payments</h5>
              <div class="sttl-line"></div>
            </div>
            <div class="scrpay_con">
              <img src="<?php echo images_path("powered_by_stripe.png");?>" alt="Powered by stripe">
              <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/pp-acceptance-medium.png" alt="Subscribe now with PayPal" title="Subscribe now with PayPal">
              <img src="<?php echo images_path("trusted-site-seal.png");?>" alt="Comodo Trusted Site Seal">
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-4">
        <div class="sub-title">
          <h5>About IMA</h5>
          <div class="sttl-line"></div>
        </div>
        <img class="fot_logo" alt="Japan GDP Economy" src="<?php echo images_path("logo-imaw.png");?>" >
        <div class="spacer10"></div>
        <p>On May 12, 2017, our sister company, India Macro Advisors (IMA), launched its services providing macroeconomic data and analysis on India.</p>
        <div class="text-right">
          <a class="btn btn-primary btn-sm" target="_blank" href="https://www.indiamacroadvisors.com">
            More Info
          </a>
        </div>
      </div>
      <div class="col-xs-12 show-mob">
        <p><b>Note:</b> We use cookies to track usage and preferences.</p>
      </div>
    </div>
  </div>
  <div class="footer_copycont">
    <div class="container">
      <div class="col-xs-12 col-md-4">
        <p class="copy_right">Copyright &copy; 2012-<?php echo date('Y');?> <a >JAPAN MACRO ADVISORS</a></p>
      </div>
      <div class="col-xs-12 col-md-8">
        <ul class="list-inline pull-right">
          <li><a href="<?php echo url('/');?>">Home</a> |</li>
          <li><a href="<?php echo url('user/newsletters');?>">Newsletter</a> |</li>
          <li><a href="<?php echo url('aboutus/termsofuse');?>">Terms Of Use </a> |</li>
          <li><a href="<?php echo url('aboutus/privacypolicy');?>">Our Privacy Policy </a> |</li>
          <li><a href="<?php echo url('aboutus/commercial_policy');?>">Commercial Policy </a> |</li>
          <li><a href="<?php echo url('contact');?>">Contact</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<!--footer section-->

<script type="text/javascript">
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN':  "<?php echo csrf_token();?>",
  }
});
<?php  if(Session::has('chartIndex') && Session::has('user')){ ?>
  var downloadChartId='frm_download_chart_data_<?php echo Session::get('chartIndex');?>';
document.getElementById(downloadChartId).submit();
<?php } ?>

</script>
<!-- ResponsiveMultiLevelMenu -->
<script src="<?php echo asset("assets/plugins/ResponsiveMultiLevelMenu/js/modernizr.custom.js");?>"></script>
  <script src="<?php echo asset("assets/plugins/ResponsiveMultiLevelMenu/js/jquery.dlmenu.js");?>"></script>
<script type="text/javascript" src="<?php echo asset("assets/plugins/MobileDetect/mobile-detect.js");?>" ></script>
<?php if(app()->environment()=='development') {  ?>
<script type="text/javascript" src="<?php echo js_path("handlebars-v2.0.0.js");?>" ></script>
<script type="text/javascript" src="<?php echo js_path("clipboard.min.js");?>" ></script>
<script type="text/javascript" src="<?php echo js_path("Sortable.min.js");?>" ></script>
<script type="text/javascript" src="<?php echo asset("assets/plugins/jquery-ui/jquery-ui.min.js");?>" ></script>
<script type="text/javascript" src="<?php echo js_path("intlTelInput.min.js");?>" ></script>
<script type="text/javascript" src="<?php echo js_path("pack.js");?>" ></script>
<script type="text/javascript" src="<?php echo asset("assets/plugins/slick/slick.min.js");?>" ></script>
<!-- bootstrap select option -->
  <script src="<?php echo asset("assets/plugins/bootstrap-select/js/bootstrap-select.min.js");?>"></script>
<?php } ?>
<?php $highstock_src_=array('page','news','reports','mycharts','home'); if(in_array(thisController(), $highstock_src_)){ ?>
<script type="text/javascript" src="<?php echo js_path("high_chart_stock_map.js");?>" defer="defer"></script>
<script type="text/javascript" src="<?php echo js_path("jp-all-custom.js");?>" defer="defer"></script>
<script type="text/javascript" src="<?php echo js_path("spectrum.js");?>" ></script>
<?php if(thisController()=='mycharts'){ ?>
<script type="text/javascript" src="<?php echo js_path("tinymce/tinymce.min.js");?>" ></script>
<?php } ?>
<?php } ?>
  <script src="https://d3js.org/d3.v3.js"></script>
<script src="<?php echo js_path("virtualscroller.js");?>"></script> 
<script type="text/javascript" src="<?php echo js_path("readmore.js");?>" ></script>
<script type="text/javascript" src="<?php echo js_path("jma.js");?>" ></script>
<script type="text/javascript">
var THIS_ASSETS='<?php echo asset("assets");?>';

var objectParams = {
  myChart : {
    folderList : <?php echo isset($menu_items['folderList'])?json_encode($menu_items['folderList']):json_encode(array());?>,
    chartBookListInactive : <?php echo isset($menu_items['chartBookListInactive'])?json_encode($menu_items['chartBookListInactive']):'null';?>
  }
};
var JMA = new Jma('<?php echo url('/'); ?>/','<?php echo thisController(); ?>','<?php echo thisMethod(); ?>','<?php  echo (app('request')->route()!=null && is_array(app('request')->route()->parameters())) ? implode('/', array_values(app('request')->route()->parameters())):'';?>','<?php echo isset($_SERVER['HTTPS']) ? 'https' : 'http'?>',objectParams);
<?php
if (Session::has('user') && Session::get('user.id') > 0) {
  ?>
  JMA.userDetails = <?php echo json_encode(Session::get('user'));?>;
  <?php
} ?>

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN':  "<?php echo csrf_token();?>",
  }
});

// Linkedn Login Auto Download XLSX
<?php if(Session::has('chartIndex') && Session::has('user')){ ?>
window.onload = function(){
  var downloadChartId=<?php echo Session::get('chartIndex');?>;
 afterLinkedinlogindownloadCsv(downloadChartId);
}
<?php } ?>

</script>
<script type="text/javascript" src="<?php echo js_path("custom.js");?>" ></script>

<?php
echo '<!--'.thisController().'-->';
$ENV = app()->environment();
if($ENV == 'production') {
  $template = thisController()."/".thisMethod();
  $error_404 = thisController();
  if($error_404 != 'error' && $template != 'user/login' && $template != 'user/forgotpassword' && $template != 'user/confirmregistration'
    && $template != 'user/myaccount') {
      ?>
      <!-- Google Tag Manager -->
      <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NX7MF9" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <script defer="defer">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NX7MF9');</script>
    <!-- End Google Tag Manager -->
    <?php
  }
}
elseif ($ENV == 'test'){
  ?>
  <!-- Google Tag Manager -->
  <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KGR56S" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <script defer="defer">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KGR56S');</script>
<!-- End Google Tag Manager -->
<?php } ?>

<?php
$page = thisController()."/".thisMethod();
if($page == "user/completeregistration_success"){ ?>
<script type="text/javascript">
// Send transaction data with a pageview if available
// when the page loads. Otherwise, use an event when the transaction
// data becomes available.
var dataLayer=[];
datalayer.push({
  'ecommerce': {
    'purchase': {
      'actionField': {
        'id': '<?php echo Session::get('reg_user_id'); ?>',                         // Transaction ID. Required for purchases and refunds.
        'revenue': '0'                   // Total transaction value (incl. tax and shipping)
      },
      'products': [{                            // List of productFieldObjects.
        'name': 'Individual free subscription',     // Name or ID is required.
        'id': '1',
        'price': '0',
        'quantity': 1                           // Optional fields may be omitted or set to empty string.
      }]
    }
  }
});
</script>
<?php } ?>
<?php
$page = thisController()."/".thisMethod();
if($page == "user/payment_success"){ ?>
<script type="text/javascript">
// Send transaction data with a pageview if available
// when the page loads. Otherwise, use an event when the transaction
// data becomes available.
datalayer.push({
  'ecommerce': {
    'purchase': {
      'actionField': {
        'id': '<?php echo Session::get('user.id'); ?>',                         // Transaction ID. Required for purchases and refunds.
        'revenue': '100.00'                   // Total transaction value (incl. tax and shipping)
      },
      'products': [{                            // List of productFieldObjects.
        'name': 'Premium subscription',     // Name or ID is required.
        'id': '2',
        'price': '100.00',
        'quantity': 1                           // Optional fields may be omitted or set to empty string.
      }]
    }
  }
});
</script>
<?php } ?>


<?php $addthis_plugin_src=array('page','news','reports'); if(in_array(thisController(), $addthis_plugin_src)){ 
  //echo '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-560a39ae0a881b48"  defer="defer"></script>';
} ?>


