<?php
$user_position = '';
$user_industry = '';
$user_title = '';
$fname = '';
$lname = '';
$email = (isset($_POST['register_email']))?$_POST['register_email']:'';
$country_id = '';
$phone_code = '';
$phone = '';
$country_code='';
$Subscription ='';
$OtherTitle ='';
if($this->resultSet['status']!=1) {
  $signup_error_id = $this->resultSet['result']['signup_error_id'];
  $user_position = $this->resultSet['result']['postdata']['user_position'];
  $user_industry = $this->resultSet['result']['postdata']['user_industry'];
  $user_title = $this->resultSet['result']['postdata']['user_title'];
  $OtherTitle = $this->resultSet['result']['postdata']['OtherTitle'];
  $fname = $this->resultSet['result']['postdata']['fname'];
  $lname = $this->resultSet['result']['postdata']['lname'];
  $email = $this->resultSet['result']['postdata']['email'];
  $country_id = $this->resultSet['result']['postdata']['country_id'];
  $phone = $this->resultSet['result']['postdata']['phone'];
  $phone_code = $this->resultSet['result']['postdata']['phone_code'];
  $country_code = $this->resultSet['result']['postdata']['country_code'];
  $product = $this->resultSet['result']['postdata']['product'];
}
if(isset($_REQUEST['pre_info']) || isset($_REQUEST['co_info'])){
  if(isset($this->resultSet['result']['request_info'])){
    $carp=$this->resultSet['result']['request_info']['corporate'];
    $premium=$this->resultSet['result']['request_info']['premium'];
    $product=(($carp==1)?'corporate':(($premium==1)?'premium':'free'));
  }
}
if(isset($_SESSION['signup_ts']))
{
  $signup_ts  = $_SESSION['signup_ts'];
}
if(empty($signup_ts))
{
  $signup_ts  = time();
  $_SESSION['signup_ts'] = $signup_ts;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php echo !isset($this->pageTitle) ? 'Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo' : $this->pageTitle; ?> | Offreing New Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" href="../favicon.ico" type="image/icon">
  <link rel="icon" href="../favicon.ico" type="image/icon">
<?php if(Config::read('environment')=='development') { ?>
   <link rel='stylesheet'  href="<?php  echo $this->assets."plugins/font-awesome/css/font-awesome.min.css";?>" type='text/css' media='all' />
  <link rel='stylesheet'  href='<?php  echo $this->assets."css/jquery.fullPage.css";?>' type='text/css' media='all' />
  <link rel="stylesheet" href="<?php echo $this->assets."css/intlTelInput.css";?>" />
  <link rel='stylesheet'   href='<?php  echo $this->assets."css/style.css";?>' type='text/css' media='all' />
  <link rel='stylesheet' media='all' href='<?php  echo $this->assets."css/media-launch.css";?>' type='text/css' />
  <?php }else { ?>

  <script type="text/javascript" src="<?php echo $this->assets."builds/offer_pack.js";?>" ></script>

  <?php } ?>
 
  <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NX7MF9" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NX7MF9');</script>
</head>
<body class="home page page-id-7 page-template page-template-template-fullscreen-slider page-template-template-fullscreen-slider-php fixed-header no-slider icons-style-light">
  <div id="main-container" >
    <div  class="page-wrapper" >
      <!--HEADER -->
      <div class="header-wrapper" >
        <header id="header">
          <div class="section-boxed section-header">
            <div id="logo-container">
              <a href="<?php echo $this->url('/');?>"><img src="<?php  echo $this->images."product/";?>logo.png" alt="JMA Landing" /></a>
            </div>
            <div class="mobile-nav">
              <span class="mob-nav-btn">Menu</span>
            </div>
            <nav class="navigation-container">
              <div id="menu" class="nav-menu">
                <ul id="menu-main-menu" class="menu-ul">
                  <li id="menu-item-206" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-206"><a target="_blank" href="<?php echo $this->url('');?>">Home</a></li>
                  <li id="menu-item-201" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-7 current_page_item menu-item-201"><a href="<?php echo $this->url('/products');?>">Product</a></li>
                  <li id="menu-item-202" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-202"><a target="_blank" href="<?php echo $this->url('/aboutus');?>">About us</a></li>
                  <li id="menu-item-203" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-203"><a target="_blank" href="<?php echo $this->url('/contact');?>">Contact</a></li>
                  <li id="menu-item-204" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-204"><a target="_blank" href="<?php echo $this->url('/aboutus/privacypolicy');?>">Our Privacy Policy</a></li>
                  <li id="menu-item-205" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-205"><a target="_blank" href="<?php echo $this->url('/aboutus/commercial_policy');?>">Commercial Policy</a></li>
                </ul>
              </div>
            </nav>
            <div class="clear"></div>
            <div id="navigation-line"></div>
          </div>
        </header>
        <!-- end #header -->
      </div>
      <div id="content-container" class=" layout-full">
        <div id="full-width" class="content">
          <div class="section section-textimg layout-left sec_first" style="background-image: url(<?php  echo $this->images."product/";?>A.jpg); background-color: #17C5CC; background-position: center center;">
            <div class="bg-coloroverlay"></div>
            <div class="section-wrapper">
              <div class="section-img anim-el">
                <div class="desktop-wrapper" style="background-image:url(<?php  echo $this->images."product/";?>desktop.png);">
                  <div class="youtube2">
                    <iframe width="853" height="480" src="https://www.youtube.com/embed/I829ZTQPBnc?rel=0&autoplay=1&loop=1&playlist=I829ZTQPBnc&iv_load_policy=3&controls=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
                  </div>
                </div>
              </div>
              <div class="section-content anim-el">
               <h2 class="section-title">Interactive JMA Chart tools</h2>
               <div class="section-desc">
                <p> helps you visualize data and instantly produce presentation materials.</p>
              </div>
              <a href="#2" class="button hide-mob">Read More</a></div>
            </div>
          </div>
          <div class="section section-textimg layout-right sec_two" style="background-image: url(<?php  echo $this->images."product/";?>B.jpg);">
            <div class="bg-coloroverlay"></div>
            <div class="section-wrapper">
              <div class="section-img anim-el">
                <div class="desktop-wrapper" style="background-image:url(<?php  echo $this->images."product/";?>desktop.png);">
                  <div class="youtube2">
                    <iframe width="853" height="480" src="https://www.youtube.com/embed/a8-vYFHp6zo?rel=0&autoplay=1&loop=1&playlist=a8-vYFHp6zo&iv_load_policy=3&controls=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
                  </div>
                </div>
              </div>
              <div class="section-content anim-el">
                <h2 class="section-title">My Chart</h2>
                <div class="section-desc"><p>enabling instant creation of chartbook</p>
                </div>
                <a href="#5" class="button anibtn-hide">Try Free</a>
                <a href="#launch-registration" class="button anibtn-show">Try Free</a>
              </div>
            </div>
          </div>
          <div class="section section-textimg layout-left" style="background-image: url(<?php  echo $this->images."product/";?>LandingD.jpg);">
            <div class="bg-coloroverlay"></div>
            <div class="section-wrapper">
              <div class="section-img anim-el"><img src="<?php  echo $this->images."product/";?>Dnews.png" alt="news image"/></div>
              <div class="section-content anim-el">
                <h2 class="section-title">Timely and concise analysis </h2>
                <div class="section-desc">
                  <p>helps you make better decision.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="section section-textimg layout-bottom" style="background-image: url(<?php  echo $this->images."product/";?>LandingF.jpg);">
            <div class="section-wrapper">
              <div class="section-img anim-el">
                <div class="price-table-wrapper">
                  <div class="cols-wrapper cols-3">
                    <div class="col pt-col pt-non-highlightfree">
                      <div class="pt-titlefree">Free</div>
                      <div class="pt-price-box pt-position-left"><span class="pt-cur"></span><span class="pt-price">FREE</span><span class="pt-period">per month</span></div>
                      <ul class="pt-features">
                        <li>Our economic analysis</li>
                        <li>Data and charts functions</li>
                        <li>Limited functionality of My Charts</li>
                      </ul>
                      <div class="ac_menu1">
                        <label for="navi01"><font color="#7ec238"><i class="fa fa-angle-double-down"></i> More details</font></label>
                        <input type="checkbox" id="navi01" class="bellows" />
                        <ul class="pt-features2">
                          <li><i class="fa fa-check" aria-hidden="true" style="color:#2ecc71"></i>Create your own chart folder with up to 4 charts</li>
                          <li><i class="fa fa-times" aria-hidden="true" style="color:#e74c3c"></i>Create your own chart folder with up to 2000 charts</li>
                          <li><i class="fa fa-times" aria-hidden="true" style="color:#e74c3c"></i>Research consultation</li>
                          <li><i class="fa fa-times" aria-hidden="true" style="color:#e74c3c"></i>Meetings/seminars with our economists</li>
                        </ul>
                      </div>
                      <div class="pt-button hide-mob"><a product="free" class="button offer_product" href="#5">Register NOW</a></div>
                      <div class="pt-button show-mob"><a product="free" class="button offer_product" href="#launch-registration">Register NOW</a></div>
                    </div>
                    <div class="col pt-col pt-highlight">
                      <div class="pt-title" >Premium</div>
                      <div class="pt-price-box pt-position-left"><span class="pt-cur">JPY</span><span class="pt-price">3500</span><span class="pt-period">per month</span></div>
                      <ul class="pt-features">
                        <li>Access to our Premium Reports</li>
                        <li>Data download of our proprietary data</li>
                        <li>Full functionality of My Charts</li>
                      </ul>
                      <div class="ac_menu2">
                        <label for="navi02"><font color="#E60013"><i class="fa fa-angle-double-down"></i> More details</font></label>
                        <input type="checkbox" id="navi02" class="bellows" />
                        <ul class="pt-features2">
                          <li><i class="fa fa-check" aria-hidden="true" style="color:#2ecc71"></i>Create your own chart folder with up to 4 charts</li>
                          <li><i class="fa fa-check" aria-hidden="true" style="color:#2ecc71"></i>Create your own chart folder with up to 2000 charts</li>
                          <li><i class="fa fa-check" aria-hidden="true" style="color:#2ecc71"></i>Research consultation</li>
                          <li><i class="fa fa-times" aria-hidden="true" style="color:#e74c3c"></i>Meetings/seminars with our economists</li>
                        </ul>
                      </div>
                      <div class="pt-button hide-mob"><a product="premium" class="button offer_product" href="#5">30 days Free Trial</a></div>
                      <div class="pt-button show-mob"><a product="premium" class="button offer_product" href="#launch-registration">30 days Free Trial</a></div>
                    </div>
                    <div class="col pt-col pt-non-highlight">
                      <div class="pt-title" >Corporate</div>
                      <div class="pt-price-box pt-position-left"><span class="pt-cur">USD</span><span class="pt-price">800</span><span class="pt-period">per month</span></div>
                      <ul class="pt-features">
                        <li>10 Premium accounts</li>
                        <li>Research consultation</li>
                        <li>Meetings/seminars with our economists</li>
                      </ul>
                      <div class="ac_menu3">
                        <label for="navi03"><font color="#22558F"><i class="fa fa-angle-double-down"></i> More details</font></label>
                        <input type="checkbox" id="navi03" class="bellows" />
                        <ul class="pt-features2">
                          <li><i class="fa fa-check" aria-hidden="true" style="color:#2ecc71"></i>Create your own chart folder with up to 4 charts</li>
                          <li><i class="fa fa-check" aria-hidden="true" style="color:#2ecc71"></i>Create your own chart folder with up to 2000 charts</li>
                          <li><i class="fa fa-check" aria-hidden="true" style="color:#2ecc71"></i>Research consultation</li>
                          <li><i class="fa fa-check" aria-hidden="true" style="color:#2ecc71"></i>Meetings/seminars with our economists</li>
                        </ul>
                      </div>
                      <div class="pt-button hide-mob"><a product="corporate" class="button offer_product" href="#5"  >Request Info</a></div>
                      <div class="pt-button show-mob"><a product="premium" class="button offer_product" href="#launch-registration">Request Info</a></div>
                    </div>
                  </div>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="section section-textimg layout-bottom reg_section" style="background-image: url(<?php  echo $this->images."product/";?>LandingE.jpg);">
            <div class="bg-coloroverlay" id="launch-registration"></div>
            <div class="section-wrapper">
              <div class="section-content anim-el">
                <h2 class="section-title"> Registration </h2>
                <div class="section-desc">
                  <form class="signup_frm" name="signup_frm" id="signup_frm" action="<?php echo $this->url('user/completeregistration');?>" method="post" autocomplete="off" novalidate="novalidate">
                    <input type="hidden" value="<?php echo $signup_ts; ?>" name="signup_ts">
                    <input type="hidden" value="Offrening" name="pagefrom">
                    <p>Select Product</p>
                    <p align="center" class="text-danger"
                    <?php if($this->resultSet['status']==1) { ?> style="display: none"
                    <?php } ?>><?php echo $this->resultSet['message']; ?></p>
                    <div class="cols-3 btn_regbtn" >
                      <div class="col text-right">
                        <div class="signup_request_select button <?php echo (isset($product) && $product =='free') ? 'activepro': '';?>">
                          <i class="fa fa-user fa-lg" style=""></i>
                          <b>Free</b>
                          <input type="checkbox" class="signup_product" name="product" <?php echo (isset($product) && $product =='free') ? 'checked': '';?>  value="free">
                          <i class="fa fa-check" <?php echo (isset($product) && $product =='free') ? 'style="display:inline-block"': '';?>></i>
                        </div>
                      </div>
                      <div class="col">
                        <div class="signup_request_select button <?php echo (!isset($product)) ? 'activepro':'';?><?php echo (isset($product) && $product =='premium') ? 'activepro':'';?>">
                          <i class="fa fa-user fa-lg" style=""></i>
                          <sup><i style="" class="fa fa-star fa-fw"></i></sup>
                          <b>Premium</b>
                          <input type="checkbox" class="signup_product"  name="product" <?php echo (isset($product) && $product =='premium') ? 'checked': '';?> <?php echo (!isset($product)) ? 'checked': '';?> value="premium">
                          <i class="fa fa-check"  <?php echo (!isset($product)) ? 'style="display:inline-block"': '';?> <?php echo (isset($product) && $product =='premium')  ? 'style="display:inline-block"': '';?>></i>
                        </div>
                      </div>
                      <div class="col text-left">
                        <div class="signup_request_select button <?php echo (isset($product) && $product =='corporate') ? 'activepro': '';?>">
                          <i class="fa fa-building fa-lg" style=""></i>
                          <b>Corporate</b>
                          <input type="checkbox" <?php echo (isset($product) && $product =='corporate') ? 'checked': '';?> class="signup_product" name="product" value="corporate">
                          <i class="fa fa-check" <?php echo (isset($product) && $product =='corporate') ? 'style="display:inline-block"': '';?>></i>
                        </div>
                      </div>
                    </div>
                    <div class="cols-1 brb_lininbtn" >
                      <div class="col" >
                        <a class="reg_linkedin"  href="<?php echo $this->url('user/linkedinProcess');?>/premium">
                          <img alt="Linkedin Signup" src="<?php  echo $this->images;?>linkedin_signup.png" alt="sign up image">
                        </a>
                        <p>OR</p>
                      </div>
                    </div>
                    <div class="cols-1">
                      <div class="col">
                        <select class="" name="user_title" id="user_title_id">
                          <option value="">Title</option>
                          <option value="Mr" <?php echo $user_title == 'Mr' ? 'selected' : ''?>>Mr</option>
                          <option value="Mrs" <?php echo $user_title == 'Mrs' ? 'selected' : ''?>>Mrs</option>
                          <option value="Miss" <?php echo $user_title == 'Miss' ? 'selected' : ''?>>Miss</option>
                          <option value="Ms" <?php echo $user_title == 'Ms' ? 'selected' : ''?>>Ms</option>
                          <option value="Dr" <?php echo $user_title == 'Dr' ? 'selected' : ''?>>Dr</option>
                          <option value="Prof" <?php echo $user_title == 'Prof' ? 'selected' : ''?>>Prof</option>
                          <option value="Sir" <?php echo $user_title == 'Prof' ? 'selected' : ''?>>Sir</option>
                          <option value="Other" <?php echo $user_title == 'Other' ? 'selected' : ''?>>Other</option>
                        </select>
                      </div>
                    </div>
                    <div class="cols-1" id="other" style="display: none;">
                      <div class="col">
                        <input type="text" class="form-control" placeholder="Other Title " name="OtherTitle" id="reg_user_title" value="<?php echo $OtherTitle; ?>">
                      </div>
                    </div>
                    <div class="cols-2">
                      <div class="col">
                        <input type="text" placeholder="Given name *" class="form-control" name="fname" id="reg_first_name" value="<?php echo $fname; ?>" onkeypress="return IsCharacter(event);" data-rule-required="true" data-msg-required="Please enter given name" />
                      </div>
                      <div class="col">
                        <input type="text" onkeypress="return IsCharacter(event);" class="form-control" placeholder="Surname *" name="lname" id="reg_last_name" value="<?php echo $lname; ?>"  data-rule-required="true" data-msg-required="Please enter Surname"/>
                      </div>
                    </div>
                    <div class="cols-3">
                      <div class="col">
                        <input class="form-control"  type="text" placeholder="Email  *" name="email" id="reg_email" value="<?php echo $email; ?>" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address">
                      </div>
                      <div class="col">
                        <select data-rule-required="true" class="required" name="country_id" id="country_id">
                         <option value="">Country  *</option>
                         <?php
                         $res = $this->resultSet['result']['country_list'];
                         for($i=0;$i<count($res);$i++) {
                          $selected = '';
                          if($country_id == $res[$i]['country_id']){
                            $selected = ' selected="selected" ';
                          }
                          ?>
                          <option code="<?php echo $res[$i]['country_code'];?>" value="<?php echo $res[$i]['country_id'];?>"
                            <?php echo $selected;?>><?php echo $res[$i]['country_name'];?></option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col">
                        <select class="" name="user_industry" id="user_industry">
                          <option value="0">Sector (pick one)</option>
                          <?php
                          $res = $this->resultSet['result']['user_industry'];
                          for($i=0;$i<count($res);$i++) {
                            $selected = '';
                            if($user_industry == $res[$i]['user_industry_id']){
                              $selected = ' selected="selected" ';
                            }
                            ?>
                            <option <?php echo $selected;?> value="<?php echo $res[$i]['user_industry_id'];?>"><?php echo $res[$i]['user_industry_value'];?></option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                      <div class="clear"></div>
                    </div>
                    <div class="cols-2">
                      <div class="col">
                        <select class="" name="user_position" id="user_position">
                          <option value="0">Job function (pick one)</option>
                          <?php
                          $res = $this->resultSet['result']['user_position'];
                          for($i=0;$i<count($res);$i++) {
                            $selected = '';
                            if($user_position == $res[$i]['user_position_id']){
                              $selected = ' selected="selected" ';
                            }
                            ?>
                            <option <?php echo $selected;?> value="<?php echo $res[$i]['user_position_id'];?>"><?php echo $res[$i]['user_position_value'];?></option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col">
                        <div class="form-control su_couinp">
                          <input type="hidden"   value="<?php echo ($country_code!='')?$country_code:'+81';?>" name="country_code"   id="country_code"   />
                          <input type="text" class="phonecls " onkeypress="return IsPhoneNumber(event);"  placeholder="Phone number" value="<?php echo $phone;?>" name="phone"  data-rule-number="true" data-rule-minlength="6" id="reg_phone_number"   />
                        </div>
                      </div>
                    </div>
                    <div class="cols-1">
                      <div class="col suf_paratxt">
                        <p>Premium and Corporate subscriptions are our fee based service. For further information please see our <a target="_blank" href="<?php echo $this->url('products');?>">products</a> </p>
                        <p><small style="color:red;">*</small> Required fields</p>
                      </div>
                    </div>
                    <div class="cols-1">
                      <div class="col">
                        <button type="submit" style="text-align: right;" name="signup_btn" class="btn btn-primary">Continue</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
    </div> <!-- end #content-container -->
  </div>
</div> <!-- end #main-container -->
<!-- FOOTER ENDS -->
<?php if(Config::read('environment')=='development') { ?>
<script type='text/javascript' src='<?php echo $this->javascript."jquery.min.js";?>'></script>
<script type="text/javascript" src="<?php echo $this->javascript."/pack/jquery.validate.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->javascript."intlTelInput.min.js";?>"></script>
<?php } ?>
<script type='text/javascript' src='<?php echo $this->javascript."scrolloverflow.min.js";?>'></script>
<script type='text/javascript' src='<?php echo $this->javascript."jquery.fullPage.min.js";?>'></script>

<script type="text/javascript">
$(function() {
  $( ".mobile-nav" ).on( "click", function() {
    $(".navigation-container" ).slideToggle();
    $("body").toggleClass("overflow-hide");
  });
} );
</script>
<script type="text/javascript">
var isPhoneDevice = "ontouchstart" in document.documentElement;
var isMobile = window.matchMedia("only screen and (max-width: 1199px)");
if (isMobile.matches) {
}
else {
  $('#full-width').fullpage({
    anchors:['#1', '#2', '#3', '#4', '#5'],
    animateAnchor: true,
    navigation:true,
    css3: true,
    scrollingSpeed: 700,
    scrollOverflow: true,
    autoScrolling: true,
    autoplay:true
  });
}
</script>
<script type="text/javascript">
var $=jQuery;
$(function() {
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
    utilsScript: '<?php echo $this->javascript,"utils.js";?>',
  });
  $('div.selected-flag').attr("tabindex",-1);
  $('ul.country-list li.country').on('click , ontouchstart', function() {
    var option1 = $(this).data('dial-code');
    $('#country_code').val("+"+option1);
  });
  $('#country_id').on('change , ontouchstart', function() {
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
    $('div.selected-flag').attr("title",(sel_country_name+': '+"+"+sel_dial_code));
    $('#country_code').val("+"+sel_dial_code);
  });
$('.signup_request_select').on('click , ontouchstart',function(event){
  var jqO = $(this);
  var target = $(event.target);
  $('.signup_request_select').removeClass( "activepro" );
  jqO.addClass('activepro');
  $('.signup_request_select').find('.signup_product').prop('checked',false);
  $('.signup_request_select').find('i.fa-check').hide();
  jqO.find('.signup_product').prop('checked',true);
  var sub_type=jqO.find('.signup_product').prop('checked',true).val();
  var theHref = $('a.reg_linkedin').attr("href");
  var last = theHref.substring(theHref.lastIndexOf("/") + 1, theHref.length);
  $('a.reg_linkedin').attr("href", (theHref.replace(last,sub_type)));
  jqO.find('i.fa-check').show();
});
$('.signup_product').on('click',function(event){
  $('.signup_product').parent('div').removeClass( "activepro" );
  $('.signup_product').prop('checked',false);
  $(this).parent('div').addClass('activepro');
  $(this).prop('checked',true);
});
$('.offer_product').on('click , ontouchstart',function(event){
  var clickbutn=$(this).attr('product');
  $(".signup_product[value='"+clickbutn+"']").parent('div').trigger( "click" );
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
    form.submit();
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
  </script>
</body>
</html>
