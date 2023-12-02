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
              <h5>Safe and Secure Payment</h5>
              <div class="sttl-line"></div>
            </div>
            <img alt="JMA Comodo" src="<?php echo $this->images;?>ssl/comodo_secure_113x59_white.png" >
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-4">
        <div class="sub-title">
          <h5>About IMA</h5>
          <div class="sttl-line"></div>
        </div>
        <img alt="Japan GDP Economy" src="<?php echo $this->images;?>logo-imaw.png" >
        <div class="spacer10"></div>
        <p>On May 12, 2017, our sister company, India Macro Advisors (IMA), launched its services providing macroeconomic data and analysis on India.</p>
        <div class="text-right">
          <a class="btn btn-primary btn-sm" target="_blank" href="https://www.indiamacroadvisors.com">
            More Info
          </a>
        </div>
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
          <li><a href="<?php echo $this->url('/');?>">Home</a> |</li>
          <li><a href="<?php echo $this->url('user/newsletters');?>">Newsletter</a> |</li>
          <li><a href="<?php echo $this->url('aboutus/termsofuse');?>">Terms Of Use </a> |</li>
          <li><a href="<?php echo $this->url('aboutus/privacypolicy');?>">Our Privacy Policy </a> |</li>
          <li><a href="<?php echo $this->url('aboutus/commercial_policy');?>">Commercial Policy </a> |</li>
          <li><a href="<?php echo $this->url('contact');?>">Contact</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<!--footer section-->



<?php if(Config::read('environment')=='development') { ?>
  <script type="text/javascript" src="<?php echo $this->javascript."handlebars-v2.0.0.js";?>" ></script>
  <script type="text/javascript" src="<?php echo $this->javascript."clipboard.min.js";?>" ></script>
  <script type="text/javascript" src="<?php echo $this->javascript."Sortable.min.js";?>" ></script>
  <script type="text/javascript" src="<?php echo $this->assets."plugins/jquery-ui/jquery-ui.min.js";?>" ></script>
  <script type="text/javascript" src="<?php echo $this->javascript."intlTelInput.min.js";?>" ></script>
  <script type="text/javascript" src="<?php echo $this->javascript."pack.js";?>" ></script>
  <?php } ?>
  <?php $highstock_src_=array('page','news','reports','mycharts','home'); if(in_array($this->controllername, $highstock_src_)){ ?>
  <script src="<?php echo $this->javascript."highstock.js";?>" defer="defer"></script>
  <?php if($this->controllername=='mycharts'){ ?>
  <script type="text/javascript" src="<?php echo $this->javascript."ckeditor/ckeditor.js";?>"></script>
  <?php } ?>
  <?php } ?>

  <script type="text/javascript" src="<?php echo $this->javascript."readmore.js";?>" ></script>
  <script type="text/javascript" src="<?php echo $this->javascript."jma.js";?>" ></script>

  <script type="text/javascript">

  var THIS_ASSETS='<?php echo $this->assets;?>';
  var objectParams = {
    myChart : {
      folderList : <?php echo json_encode($this->resultSet['result']['category']['folderList']);?> ,
      chartBookListInactive : <?php echo json_encode($this->resultSet['result']['category']['chartBookListInactive']);?>
    }
  };
  var JMA = new Jma('<?php echo $this->rootPath; ?>','<?php echo $this->controllername; ?>','<?php echo $this->actionname; ?>','<?php echo is_array($this->params) ? implode('/', $this->params) : ''; ?>','<?php echo isset($_SERVER['HTTPS']) ? 'https' : 'http'?>',objectParams);
  <?php
  if (isset ( $_SESSION ['user'] ) && $_SESSION ['user'] ['id'] > 0) {
    ?>
    JMA.userDetails = <?php echo json_encode($_SESSION['user']);?>;
    <?php
  }
  ?>
  </script>
  <script type="text/javascript" src="<?php echo $this->javascript."custom.js";?>" ></script>
  <?php
  $page = $this->controllername."/".$this->actionname;
  if($page == "user/completeregistration_success"){
    ?>
    <script type="text/javascript">
// Send transaction data with a pageview if available
// when the page loads. Otherwise, use an event when the transaction
// data becomes available.
dataLayer = [];
dataLayer.push({
  'ecommerce': {
    'purchase': {
      'actionField': {
        'id': '<?php echo $_SESSION['reg_user_id']; ?>',                         // Transaction ID. Required for purchases and refunds.
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
<?php
}
?>
<?php
$page = $this->controllername."/".$this->actionname;
if($page == "user/payment_success"){
  ?>
  <script type="text/javascript">
// Send transaction data with a pageview if available
// when the page loads. Otherwise, use an event when the transaction
// data becomes available.
dataLayer = [];
dataLayer.push({
  'ecommerce': {
    'purchase': {
      'actionField': {
        'id': '<?php echo $_SESSION['user']['id']; ?>',                         // Transaction ID. Required for purchases and refunds.
        'revenue': '30.00'                   // Total transaction value (incl. tax and shipping)
      },
      'products': [{                            // List of productFieldObjects.
        'name': 'Premium subscription',     // Name or ID is required.
        'id': '2',
        'price': '30.00',
        'quantity': 1                           // Optional fields may be omitted or set to empty string.
      }]
    }
  }
});
</script>
<?php
}
?>
<?php
echo '<!--'.$this->controllername.'-->';
$ENV = Config::read('environment');
if($ENV == 'production') {
 $template = $this->controllername."/".$this->actionname;
 $error_404 = $this->controllername;
 if($error_404 != 'error' && $template != 'user/login' && $template != 'user/forgotpassword' && $template != 'user/confirmregistration'
  && $template != 'user/myaccount') {
    ?>
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NX7MF9"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
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
  <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KGR56S"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script defer="defer">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-KGR56S');</script>
  <!-- End Google Tag Manager -->
  <?php
}
?>


<!-- Go to www.addthis.com/dashboard to customize your tools -->
<?php $addthis_plugin_src=array('page','news','reports'); if(in_array($this->controllername, $addthis_plugin_src)){
 //echo '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-560a39ae0a881b48"  defer="defer"></script>';
} echo $this->getAllJavascript(); ?>
