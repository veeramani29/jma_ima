<!--footer section-->
<div class="footer_toggle">
  <div class="ft_btn">More Info <i class="fa fa-angle-up" aria-hidden="true"></i></div>
</div>
<footer>
  <div class="footer_container">
    <div class="container">
      <div class="col-xs-12 pad0">
        <div class="col-xs-12 col-sm-6">
          <div class="sub-title">
            <h5>Follow Us</h5>
            <div class="sttl-line"></div>
          </div>
          <ul class="list_socail">
            <li class="fs_linkedin">
              <a target="_blank" href="https://www.linkedin.com/company/india-macro-advisors" data-toggle="tooltip" title="Linked in">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
              </a>
            </li>
            <li class="fs_twitter">
              <a target="_blank" href="https://twitter.com/IndiaMAdvisors" data-toggle="tooltip" title="Twitter">
                <i class="fa fa-twitter" aria-hidden="true"></i>
              </a>
            </li>
            <li class="fs_facebook" data-toggle="tooltip" title="Facebook">
              <a target="_blank" href="https://www.facebook.com/indiamacroadvisors/">
                <i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
            </li>
          </ul>
        </div>
        <div class="col-xs-12 col-sm-6">
          <div class="sub-title">
            <h5>Safe and Secure Payment</h5>
            <div class="sttl-line"></div>
          </div>
          <div class="scrpay_con">
            <a data-toggle="modal" data-target=".secpay_modal">
            <!--   <img src="<?php echo images_path("powered_by_stripe.png");?>" alt="Powered by stripe"> -->
            <img src="<?php echo images_path("powered_by_razorpay.png");?>" alt="Powered by stripe">
            </a>
            <a data-toggle="modal" data-target=".secpay_modal">
              <img src="<?php echo images_path("trusted-site-seal.png");?>" alt="Comodo Trusted Site Seal">
            </a>
          </div>
        </div>
      </div>
      <div class="col-xs-12">
        <ul class="list-inline fc_links">
          <li><a href="<?php echo url('aboutus/career');?>"class="top_link_common">Careers </a> |</li>
          <li><a href="<?php echo url('products/offerings');?>" class="top_link_common">What We Offer </a> |</li>
          <li><a href="<?php echo url('aboutus/termsofuse');?>">Terms Of Use </a> |</li>
          <li><a href="<?php echo url('aboutus/privacypolicy');?>">Our Privacy Policy </a> |</li>
          <li><a href="<?php echo url('contact');?>">Contact </a> 
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) { ?>|
          </li>
          <li>
            <a href="<?php echo url('/helpdesk/post');?>" class="<?php if(thisController() == 'helpdesk' && isset($result['result']['action']) && $result['result']['action'] == 'post') { echo "selected"; } else { ""; }?>"> Help Desk</a><?php }?>
          </li>
        </ul>
        <p class="fc_cookie"><b>Note:</b> We use cookies to track usage and preferences.</p>
      </div>
    </div>
  </div>
  <div class="footer_copycont">
    <div class="container">
      <div class="col-xs-12">
        <p class="copy_right">Copyright &copy; 2016-<?php echo date('Y');?>; <a href="">INDIA MACRO ADVISORS</a></p>
      </div>
    </div>
  </div>
</footer>