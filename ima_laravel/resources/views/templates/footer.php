<!--footer section-->
<?php if(isMobileDevice()) { ?>
<div class="footer_toggle">
  <div class="ft_btn">More Info <i class="fa fa-angle-up" aria-hidden="true"></i></div>
</div>
<footer class="fot_mob">
  <div class="footer_container">
    <div class="container">
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
          <img src="<?php echo images_path("powered_by_razorpay.png");?>" alt="Powered by stripe">
          <img src="<?php echo images_path("trusted-site-seal.png");?>" alt="Comodo Trusted Site Seal">
        </div>
      </div>
      <div class="col-xs-12">
        <ul class="list-inline fc_links">
          <li><a href="<?php echo url('/');?>">Home</a> |</li>
          <li><a href="<?php echo url('aboutus/termsofuse');?>">Terms Of Use </a> |</li>
          <li><a href="<?php echo url('aboutus/privacypolicy');?>">Our Privacy Policy </a> |</li>
          <li><a href="<?php echo url('contact');?>">Contact</a></li>
        </ul>
        <p class="fc_cookie"><b>Note:</b> We use cookies to track usage and preferences.</p>
      </div>
    </div>
  </div>
  <div class="footer_copycont">
    <div class="container">
      <div class="col-xs-12">
        <p class="copy_right">Copyright &copy; 2012-<?php echo date('Y');?>; <a href="">INDIA MACRO ADVISORS</a></p>
      </div>
    </div>
  </div>
</footer>
<?php } else { ?>
<footer>
  <div class="footer_container">
    <div class="container">
      <div class="col-xs-12 col-md-8">
        <div class="sub-title">
          <h5>About us</h5>
          <div class="sttl-line"></div>
        </div>
        <p class="fc_about">India Macro Advisors Inc. ("We") are not an investment advisory and we do not make any offer or solicitation to buy/sell financial securities or other type of assets. The information contained herein has been obtained from, or is based upon, sources believed by us to be reliable, but we do not make any representation or warranty for their accuracy or completeness. The text, numerical data, charts and other graphical contents we provide ("IMA contents") are copyrighted properties of India Macro Advisors ("Us"). While we permit personal non-commercial usage of IMA contents, it should be accompanied by an explicit mention that the contents belong to us. We do not allow any reproduction of IMA contents for other purposes unless specifically authorised by us. Please contact us at <a href="mailto:info@indiamacroadvisors.com">info@indiamacroadvisors.com</a> to seek our authorization.</p>
      </div>
      <div class="col-md-4 col-xs-12 pad0">
        <div class="col-xs-12">
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
        <div class="col-xs-12">
          <div class="sub-title">
            <h5>Safe and Secure Payment</h5>
            <div class="sttl-line"></div>
          </div>
          <div class="scrpay_con">
            <img src="<?php echo images_path("powered_by_razorpay.png");?>" alt="Powered by stripe">
            <img src="<?php echo images_path("trusted-site-seal.png");?>" alt="Comodo Trusted Site Seal">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer_copycont">
    <div class="container">
      <div class="col-xs-12 col-md-4">
        <p class="copy_right">Copyright &copy; 2012-<?php echo date('Y');?>; <a href="">INDIA MACRO ADVISORS</a></p>
      </div>
      <div class="col-xs-12 col-md-8">
        <ul class="list-inline pull-right">
          <li><a href="<?php echo url('/');?>">Home</a> |</li>
          <li><a href="<?php echo url('aboutus/termsofuse');?>">Terms Of Use </a> |</li>
          <li><a href="<?php echo url('aboutus/privacypolicy');?>">Our Privacy Policy </a> |</li>
          <li><a href="<?php echo url('contact');?>">Contact</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<?php } ?>
<div class="scrollTop">
  <span><a href=""><i class="fa fa-chevron-up"></i></a></span>
</div>