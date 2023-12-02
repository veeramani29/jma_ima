<!--footer section-->
<footer>
  <div class="footer_container">
    <div class="container">
      <div class="col-xs-12 col-md-12">
        <div class="sub-title">
          <h5>About us</h5>
          <div class="sttl-line"></div>
        </div>
        <p class="fc_readmore"> <?=SITE_NAME;?>. ("We") Our mission is to provide a concise usefull/helpfull information for the benefit of global audiences. We collected this information various source like websites, Social Medias, Real-time Experince , Books , Persons etc.,The information which includes all the kind of content ,news ,data, video and images etc.,

Global audiences can free to use the contents form this website. But, don't misuse.. Please contact <a href="mailto:<?=GENERAL_EMAIL;?>"><?=GENERAL_EMAIL;?></a> to seek our authorization. </p>
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
              <li class="fs_youtube" data-toggle="tooltip" title="Youtube">
                <a target="_blank" href="https://www.facebook.com/Japanmacroadvisors/">
                  <i class="fa fa-youtube" aria-hidden="true"></i>
                </a>
              </li>
            </ul>
          </div>
         <!-- <div class="col-sm-6 col-xs-12">
            <div class="sub-title">
              <h5>Safe and Secure Payments</h5>
              <div class="sttl-line"></div>
            </div>
            <div class="scrpay_con">
              <img src="<?php echo images_path("powered_by_stripe.png");?>" alt="Powered by stripe">
              <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/pp-acceptance-medium.png" alt="Subscribe now with PayPal" title="Subscribe now with PayPal">
              <img src="<?php echo images_path("trusted-site-seal.png");?>" alt="Comodo Trusted Site Seal">
            </div>
          </div>-->
        </div>
      </div>
     <!-- <div class="col-xs-12 col-md-4">
        <div class="sub-title">
          <h5>About Help Learn</h5>
          <div class="sttl-line"></div>
        </div>
        <img class="fot_logo" alt="Japan GDP Economy" src="<?php echo images_path("logo-imaw.png");?>" >
        <div class="spacer10"></div>
        <p>On May 12, 2017, our sister company, Help Learn, launched its services providing macroeconomic data and analysis on India.</p>
        <div class="text-right">
          <a class="btn btn-primary btn-sm" target="_blank" href="https://www.indiamacroadvisors.com">
            More Info
          </a>
        </div>
      </div>-->
      <div class="col-xs-12 show-mob">
        <p><b>Note:</b> We use cookies to track usage and preferences.</p>
      </div>
    </div>
  </div>
  <div class="footer_copycont">
    <div class="container">
      <div class="col-xs-12 col-md-4">
        <p class="copy_right">Copyright &copy; 2012-<?php echo date('Y');?> <a >Help Learn</a></p>
      </div>
      <div class="col-xs-12 col-md-8">
        <ul class="list-inline pull-right">
          <li><a href="<?php echo url('/');?>">Home</a> |</li>
          <li><a href="<?php echo url('user/newsletters');?>">Newsletter</a> |</li>
          <li><a href="<?php echo url('aboutus/termsofuse');?>">Terms Of Use </a> |</li>
          <li><a href="<?php echo url('aboutus/privacypolicy');?>">Our Privacy Policy </a> |</li>
          <li><a href="<?php echo url('aboutus');?>">About Us</a> |</li>
          <li><a href="<?php echo url('contact');?>">Contact</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<!--footer section-->
<!-- ResponsiveMultiLevelMenu -->
<script src="<?php echo asset("assets/plugins/ResponsiveMultiLevelMenu/js/modernizr.custom.js");?>"></script>
  <script src="<?php echo asset("assets/plugins/ResponsiveMultiLevelMenu/js/jquery.dlmenu.js");?>"></script>
<script type="text/javascript" src="<?php echo asset("assets/plugins/MobileDetect/mobile-detect.js");?>" ></script>
<?php if(app()->environment()=='development') {  ?>
<!--<script type="text/javascript" src="<?php echo js_path("handlebars-v2.0.0.js");?>" ></script>
<script type="text/javascript" src="<?php echo js_path("Sortable.min.js");?>" ></script>
<script type="text/javascript" src="<?php echo asset("assets/plugins/jquery-ui/jquery-ui.min.js");?>" ></script>
<script type="text/javascript" src="<?php echo asset("assets/plugins/slick/slick.min.js");?>" ></script>-->
<script type="text/javascript" src="<?php echo js_path("clipboard.min.js");?>" ></script>
<!-- <script type="text/javascript" src="<?php echo js_path("intlTelInput.min.js");?>" ></script> -->
<script type="text/javascript" src="<?php echo js_path("pack.js");?>" ></script>

<!-- bootstrap select option -->
  <script src="<?php echo asset("assets/plugins/bootstrap-select/js/bootstrap-select.min.js");?>"></script>
<?php } ?>
<?php $highstock_src_=array('helplearn'); if(in_array(thisController(), $highstock_src_)){ ?>
<script type="text/javascript" src="<?php echo js_path("high_chart_stock_map.js");?>" defer="defer"></script>
<script type="text/javascript" src="<?php echo js_path("jp-all-custom.js");?>" defer="defer"></script>
<script type="text/javascript" src="<?php echo js_path("spectrum.js");?>" ></script>
<?php } ?>
 <!--  <script src="https://d3js.org/d3.v3.js"></script>
<script src="<?php echo js_path("virtualscroller.js");?>"></script>  -->
<script type="text/javascript" src="<?php echo js_path("readmore.js");?>" ></script>
<!--<script type="text/javascript" src="<?php echo js_path("jma.js");?>" ></script>-->
<script type="text/javascript">
  var THIS_ASSETS='<?php echo asset("assets");?>';
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN':  "<?php echo csrf_token();?>",
  }
});

var JMA = new Jma('<?php echo url('/'); ?>/','<?php echo thisController(); ?>','<?php echo thisMethod(); ?>','<?php  echo (app('request')->route()!=null && is_array(app('request')->route()->parameters())) ? implode('/', array_values(app('request')->route()->parameters())):'';?>','<?php echo isset($_SERVER['HTTPS']) ? 'https' : 'http'?>',null);

// Linkedn Login Auto Download XLSX
<?php if(Session::has('chartIndex') && Session::has('user')){ ?>
window.onload = function(){
  var downloadChartId=<?php echo Session::get('chartIndex');?>;
 afterLinkedinlogindownloadCsv(downloadChartId);
}
<?php } ?>
<?php  if(Session::has('chartIndex') && Session::has('user')){ ?>
  var downloadChartId='frm_download_chart_data_<?php echo Session::get('chartIndex');?>';
document.getElementById(downloadChartId).submit();
<?php } ?>
</script>
<script type="text/javascript" src="<?php echo js_path("custom.js");?>" ></script>

<?php $addthis_plugin_src=array('page','news','reports'); if(in_array(thisController(), $addthis_plugin_src)){ 
  //echo '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-560a39ae0a881b48"  defer="defer"></script>';
} ?>


