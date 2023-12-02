@extends('templates.default')
@section('content')
<?php  $CONF_CURRENCY = Config::read('subscription.currency');
$CONF_AMOUNT = Config::read('subscription.amount'); ?>
<style type="text/css">.content_leftside{display: none;}</style>
<div class="col-md-8">
  <div class="main-title">
    <h1>Payment</h1>
    <div class="mttl-line"></div>
  </div>
  <div class="spacer10f"></div>
  <div class="sub-title">
    <h5>
      <i style="color:#22558F;" class="fa fa-user fa-lg"></i>
      <sup><i style="color:#22558F;" class="fa fa-star fa-fw"></i></sup> PREMIUM Subscription plan
    </h5>
    <div class="sttl-line"></div>
  </div>
  <div class="default-padding">
    <ul class="list-unstyled">
      <li class=""><i class="fa fa-check-square-o" aria-hidden="true"></i> Costs <?php echo $CONF_CURRENCY." ".$CONF_AMOUNT;?> a month.</li>
      <li class=""><i class="fa fa-check-square-o" aria-hidden="true"></i> Monthly payments automatically withdrawn at the beginning of each month.</li>
    </ul>
  </div>
  <div class="spacer10f"></div>
  <form class="cmxform signup_frm form-horizontal" action="<?php echo url('user/dopayment');?>" method="POST" id="payment-form" autocomplete="off">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" value="<?php echo (isset($signup_ts) && $signup_ts!='')?$signup_ts:''; ?>" name="signup_ts" />
    <p class="text-center text-danger"  <?php if(isset($result['status']) && $result['status']==1) { ?> style="display: none" <?php } ?>>  <?php echo isset($result['message'])?$result['message']:''; ?></p>
    <p class="text-danger text-center dopayment_errorcon"></p>
    <div class="panel panel-default dopay_carpan">
      <div class="panel-heading">
        <strong>Enter payment details:</strong>
        <img alt="stripe" src="<?php echo images_path("stripe-logo.png");?>" >
      </div>
      <div class="panel-body">
        <div class="col-xs-12 col-lg-6">
          <div class="form-group">
            <input type="text" size="20" onkeypress="return IsCharacter(event);" placeholder="Name on card *" maxlength="30" value="<?php echo (isset($_REQUEST['card_name']))?$_REQUEST['card_name']:'';?>" autocomplete="off" class="form-control card-name required" name="card_name" class="required" style="" />
          </div>
        </div>
        <div class="col-xs-12 col-lg-6">
          <div class="form-group">
            <input type="text" onkeypress="return IsPhoneNumber(event);" name="card-number" id="card_number" placeholder="1234 5678 9012 3456" value="<?php echo (isset($_REQUEST['card-number']))?$_REQUEST['card-number']:'';?>" autocomplete="off" class="form-control card-number stripe-sensitive required" style="" />
          </div>
        </div>
        <div class="col-lg-4 col-xs-12">
          <div class="form-group">
            <input type="text" size="2" onkeypress="return IsPhoneNumber(event);"  maxlength="2" placeholder="MM *" name="card-expiry-month" value="<?php echo (isset($_REQUEST['card-expiry-month']))?$_REQUEST['card-expiry-month']:'';?>" class="form-control card-expiry-month" />
          </div>
        </div>
        <div class="col-lg-4 col-xs-12">
          <div class="form-group">
            <input type="text" size="4" maxlength="4" onkeypress="return IsPhoneNumber(event);" placeholder="YYYY *" name="card-expiry-year" value="<?php //echo (isset($_REQUEST['card-expiry-year']))?$_REQUEST['card-expiry-year']:'';?>" class="form-control card-expiry-year" autocomplete="off" />
          </div>
        </div>
        <div class="col-lg-4 col-xs-12">
          <div class="form-group">
            <input type="password" size="4" onkeypress="return IsPhoneNumber(event);" placeholder="Card code *" maxlength="4" autocomplete="new-password" class="form-control card-cvc"  />
          </div>
        </div>
      </div>
    </div>
    <div class="panel panel-default dopay_bill">
      <div class="panel-heading"><strong>Billing address:</strong></div>
      <div class="panel-body">
        <div class="col-xs-12">
          <div class="form-group">
            <input type="text" size="20" placeholder="Company name" name="company" value="<?php echo (isset($_REQUEST['company']))?$_REQUEST['company']:'';?>" autocomplete="off" class="form-control card-company" style="" />
          </div>
        </div>
        <div class="col-xs-12">
          <div class="form-group">
            <input type="text" size="40" placeholder="Address" autocomplete="off" name="card-address" value="<?php echo (isset($_REQUEST['card-address']))?$_REQUEST['card-address']:'';?>" class="form-control card-address" style="" />
          </div>
        </div>
        <div class="col-xs-12 col-lg-6">
          <div class="form-group">
            <input type="text" size="20" placeholder="Zip code" autocomplete="off" name="card-zipCode" value="<?php echo (isset($_REQUEST['card-zipCode']))?$_REQUEST['card-zipCode']:'';?>"  class="form-control card-zipCode" style="" />
          </div>
        </div>
        <div class="col-xs-12 col-lg-6">
          <div class="form-group">
            <select class="form-control  card-country required" name="country_id" id="country_id" style="">
              <option value="">Country *</option>
              <?php
              $res = $result['country_list'];
              for($i=0;$i<count($res);$i++) {
                $selected = '';
                if((isset($_REQUEST['country_id']) && $_REQUEST['country_id']) == $res[$i]['country_id']){
                  $selected = ' selected="selected" ';
                } ?>
                <option code="<?php echo $res[$i]['country_code'];?>" value="<?php echo $res[$i]['country_id'];?>" <?php echo $selected;?>><?php echo $res[$i]['country_name'];?></option>
                <?php
              } ?>
            </select>
          </div>
        </div>
        <div class="col-xs-12 col-lg-6">
          <div class="form-group">
            <input type="text" size="20" placeholder="State" autocomplete="off" name="card-state" value="<?php echo (isset($_REQUEST['card-state']))?$_REQUEST['card-state']:'';?>"  class="form-control card-state" style="" />
          </div>
        </div>
        <div class="col-xs-12 col-lg-6">
          <div class="form-group">
            <input type="text" size="20" placeholder="City" autocomplete="off" name="card-city" value="<?php echo (isset($_REQUEST['card-city']))?$_REQUEST['card-city']:'';?>"  class="form-control card-city" style="" />
          </div>
        </div>
        <div class="col-xs-12">
          <div class="form-group">
            <input type="hidden"  name="isd_code" id="isd_code" value="<?php echo (isset($_REQUEST['isd_code']))?$_REQUEST['isd_code']:'+81';?>"  class="card-isd-code" >
            <input type="text" size="10" onkeypress="return IsPhoneNumber(event);" placeholder="Phone number" name="phone_number" value="<?php echo (isset($_REQUEST['phone_number']))?$_REQUEST['phone_number']:'';?>" class="form-control card-phone-number" />
          </div>
        </div>
        <div class="col-xs-12">
          <div class="form-group">
            <label class="control control--checkbox">
              I accept the <a data-toggle="modal" data-target="#terms_Model">terms of use </a>
              <input type="checkbox" value="y" id="agree" value="<?php echo (isset($_REQUEST['agree']) && $_REQUEST['agree']=='y')?'checked':'';?>" name="agree" class="required">
              <div class="control__indicator"></div>
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group pull-right" >
      <div class="col-md-12 ">
        <button type="submit" class="btn btn-primary" name="submit-button" value="Submit"> Submit </button>
      </div>
    </div>
    <!--register section end here-->
  </form>
</div>

<div class="col-xs-12 col-md-4 secpay_con">
  <div class="sub-title">
    <h5>Your payment information are secure with us</h5>
    <div class="sttl-line"></div>
  </div>
  <div class="spc_img">
    <a data-toggle="modal" data-target=".secpay_modal">
      <img src="<?php echo images_path("powered_by_stripe.png");?>" alt="Powered by stripe">
    </a>
    <a data-toggle="modal" data-target=".compay_modal">
      <img src="https://ssl.comodo.com/images/trusted-site-seal.png" alt="Comodo Trusted Site Seal">
    </a>
  </div>
  <hr>
  <div class="text-center">
    <img alt="stripe" src="<?php echo images_path('cards-v.png');?>" >
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="terms_Model" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Terms of use</h4>
      </div>
      <div class="modal-body">
        <div class="main-title">
          <h1>Agreement to terms of use</h1>
          <div class="mttl-line"></div>
        </div>
        <p>Please read the following terms and conditions ("Terms of Use") before using the India Macro Advisors ("IMA", "We", "US" or "Our") website (the "Site") and our products including, but not limited to, our research, text, charts, videos, recordings ("Products") that are offered via email or other format provide by US. Your access to and use of the Site and the Products are subject to these Terms of Use and all applicable laws and regulations. The Terms of Use constitute a legal agreement between you and JMA. The Site and the Products are available only to, and may only be used by, individuals who can form legally binding contracts under applicable law. Without limiting the foregoing, the Site and the Products are not available to persons under age 18. By accessing and using the Site and the Products, you accept, without qualification, these Terms of Use. If you do not approve and accept these Terms of Use without qualification, you should exit the Site, and terminate the use of our Products immediately.</p>
        <div class="sub-title">
          <h5>Personal and non-commercial use limitation</h5>
          <div class="sttl-line"></div>
        </div>
        <p>The Site and the Products are for your personal and non-commercial use. JMA grants you a non-exclusive, non-transferable and limited personal license to access and use the Site and the Products, conditioned on your continued compliance with these Terms of Use. You may not modify, copy (except as set forth below), distribute, transmit, display, perform, reproduce, publish, license, create derivative works from, transfer, or sell any information, products or services obtained from the Site and the Products. You may not link other websites to the Site without our prior written permission. You may print one hardcopy of the information and download one temporary copy of the information into one single computer's memory solely for your own personal, non-commercial use and not for distribution, provided that all copyright, trademark and other proprietary notices are kept intact. You may not allow others to use your user name or password to access or use any part of the Site or the Products. If your user name or password has been compromised for any reason, you should contact US immediately for a new user name and password. If you provide your user name or password to any third party, you will be solely responsible for any actions that such third party takes using that information. All information on the password-restricted areas of the Site and in the Products are confidential and private and may not be disclosed or distributed by you to any other person for any purpose and is made available solely for your personal use. You are prohibited from using the Site or the Products to advertise or perform any commercial solicitation. You also are prohibited from using any robot, spider, scraper or other automated means to access the Site for any purpose without the prior written permission of JMA. You may not take any action that imposes, or may impose, in our sole discretion, an unreasonable or disproportionately large load on Our infrastructure, interfere or attempt to interfere with the proper working of the Site or any activities conducted on the Site, or bypass any measures JMA may use to prevent or restrict access to the Site or the Products. JMA reserves any rights not expressly granted herein.</p>
        <div class="sub-title">
          <h5>Subscription Fees</h5>
          <div class="sttl-line"></div>
        </div>
        <p>IMA provides two types of subscription: Free and Premium. Free subscribers are entitled to no fee. Premium subscriber will pay the Monthly Fee for the monthly subscription on a monthly basis. All fees will be paid at the beginning of service. The initial service period of the monthly subscription is one (1) month and will auto renew for subsequent one (1) month periods until you cancel your subscription or send the 30 day notice to us before the subscription expires. </p>
        <p>JMA may offer, as indicated on the Website Payment page, a trial period for its subscription products. The Subscriber will be billed at the beginning of the initial service period for services and will be charged, which starts after the 1 month trial period has concluded. Following any trial period, the normal terms of this Agreement will remain in effect. Service of the subscription will not begin until all charges have been processed.</p>
        <p>Following the initial service period, JMA reserves the right to increase the Monthly Fee at any time upon 30 days notice to you, provided you shall have the right to terminate the Subscription by choosing Unsubscribe which turn back your subscription type to Free subscription from Premium subscription.  </p>
        <p>You (a) agree to pay the Monthly Fee according to any applicable credit card issuer agreement, (b) expressly authorize JMA to automatically charge the applicable card on a monthly basis during the term of this Agreement (unless otherwise agreed by the parties), (c) agrees that any fee increase made in accordance with this Section may also be charged to the same card in the same manner and (d) that you will use the subscription for your own individual usage and you will not share your login credentials with other users. <u>Each individual user must have their own individual subscription.</u></p>
        <div class="sub-title">
          <h5>Subscription term</h5>
          <div class="sttl-line"></div>
        </div>
        <p>Free subscription term/period is unlimited. Premium subscription will end after the expiration date until you cancel the subscription. Once you cancel your subscription you will be notified via email and your subscription type will turn back to Free subscription. If you encounter any problem, please feel free to contact us at <a href="mailto:support@indiamacroadvisors.com">support@indiamacroadvisors.com</a> or you can submit your query at our <a href="<?php echo url('helpdesk/post/');?>">Help Desk</a>.</p>
        <div class="sub-title">
          <h5>No Refund</h5>
          <div class="sttl-line"></div>
        </div>
        <p>The credit card which you provide will automatically and immediately be billed for the Services you subscribe to. While in trial period the card will be charged only after the trial period ends on the expiration date. Premium subscription will be charged in USD. If you cancel your Services you will no longer be billed but no money already paid will be refunded. If your credit card is invalid for any reason, IMA has the right to terminate the Services immediately.</p>
        <div class="sub-title">
          <h5>JMA is a financial publisher, not an investment adviser</h5>
          <div class="sttl-line"></div>
        </div>
        <p>JMA is strictly a financial publisher. We are not, and are not registered as, an investment adviser, broker-dealer or other financial adviser or planner. For example, JMA and its officers, members, managers, employees and affiliates are not registered as investment advisers or broker-dealers with India Financial Service Agency or with any other regulatory authority, either in Japan or in other jurisdiction. We recommend consulting with a registered investment advisor, broker-dealer, and/or financial advisor in connection with your use of the Site and the Products. Any consequences (including any losses) resulting from your investments are your sole responsibility (whether or not you choose to seek advice from any such advisor).</p>
        <p>JMA publishes information and our opinions regarding economic, financial, political and social issues in Japan and the rest of the world in which We believe our readers and subscribers may be interested and our reports reflect its sincere opinions. The Site and the Products do not and are not intended to provide any individualized investment advice. JMA will not and cannot offer personalized trading or investment advice and cannot request or consider your financial circumstances. Therefore, you agree not to provide JMA with any information about your financial situation, investment portfolio or other individual information, and further agree not to request any individualized investment advice.</p>
        <div class="sub-title">
          <h5>We are not liable to you</h5>
          <div class="sttl-line"></div>
        </div>
        <p>Neither JMA nor any officer, member, manager, employees and affiliates thereof, will be liable to any subscriber, guest or anyone else for, among other things:</p>
        <p>Any interruption, inaccuracy, error or omission, regardless of cause, in any information appearing on or furnished by JMA or for any damages whatsoever allegedly caused thereby;</p>
        <p>Any unavailability of use of the Site or the Products, nor undelivered e-mails due to Internet bandwidth problems, equipment failure, or natural causes;</p>
        <p>The information, software and services published on this Site and in the Products may include inaccuracies or typographical errors. Due to various factors, including the inherent possibility of human and mechanical error, the accuracy, completeness, timeliness and correct sequencing of such information, software and services. JMA does not guarantee the results obtained from their use or any persons creating or transmitting such information, software and services. The Site and the Products may be unavailable from time to time due to required maintenance, telecommunications interruptions or other reasons.</p>
        <p>JMA and/or its suppliers make no representations about the suitability of the information, software, products and services on this Site and in the Products for any purpose. All such information, software, products and services are provided "as is" without warranty of any kind. JMA and/or its respective suppliers disclaim all warranties and conditions regarding this information, software, products and services, including all implied warranties and conditions of merchantability, fitness for a particular purpose, title, non-infringement and availability. Because some states/jurisdictions do not allow the exclusion of implied warranties, the above exclusion may not apply to you.</p>
        <p>Your use of the Site and the Products is at your own risk. You are solely responsible for any damage to your computer system, loss of data or any other damage or loss that results from downloading any content from the Site or the Products.</p>
        <p>JMA and/or its suppliers shall not be liable for any direct, indirect, punitive, incidental, special or consequential damages arising out of or in any way connected with or relating to the use of or access to this Site or the Products or with the delay or inability to use this Site, the Products or any information, software, products or services obtained through this Site or the Products, whether based on contract, tort, strict liability or otherwise, even if JMA or any of its suppliers has been advised of the possibility of damages. Because some jurisdictions do not allow the exclusion or limitation of liability for consequential or incidental damages, the above limitation may not apply to you.</p>
        <p>JMA and any person creating or transmitting the information on the Site and in the Products shall not be liable for any infection by viruses of or damage to any computer that results from your use of, access to or downloading of such information. If you are dissatisfied with the information, products or services offered at the Site or in the Products or with these Terms of Use, your sole and exclusive remedy is to discontinue use of and access to the Site and the Products.</p>
        <div class="sub-title">
          <h5>Ownership of content</h5>
          <div class="sttl-line"></div>
        </div>
        <p>The Site, the Products and all of their content, including but not limited to all text, graphics, charts, audio, logos, images, data compilations, icons, code and software ("Content"), are the property of JMA and are protected by Japanese and international copyright laws, with all rights reserved unless otherwise noted. All trademarks, service marks, trade names and other product and service names and logos displayed on the Site and in the Products are proprietary to JMA, including all registered and unregistered trademarks and service marks of the JMA. If the Site or any Products includes any trademarks, service marks, trade names or logos of any third parties, such items are the proprietary marks and names of their respective owners, and are protected by applicable trademark and intellectual property laws. Your use of any Content, whether owned by JMA or any third party, without our express written permission, is strictly prohibited except as otherwise expressly permitted in these Terms of Use. Without limiting the foregoing, you are prohibited from using any of the Our copyrighted material or trademarks for any purpose, including, but not limited to, use as links or otherwise on any website, without the Our prior written permission.</p>
        <div class="sub-title">
          <h5>Truthful information</h5>
          <div class="sttl-line"></div>
        </div>
        <p>As a condition to your use of the Site and the Products, you represent and warrant to, and agree with US that, all of the information that you provide is truthful, accurate and complete. If We collect any information from users of the Site or the Products, the collection and use of such information is governed by our Privacy Policy which you should read before providing any information to US.</p>
        <div class="sub-title">
          <h5>No unlawful or prohibited use</h5>
          <div class="sttl-line"></div>
        </div>
        <p>As a condition to your use of the Site and the Products, you represent and warrant to, and agree with US that you will not use the Site or the Products for any purpose that is unlawful or prohibited by these Terms of Use.</p>
        <div class="sub-title">
          <h5>References to publications and other companies</h5>
          <div class="sttl-line"></div>
        </div>
        <p>References to any publication, companies or institutions in the Site or the Products are for reference and informational purposes only and are not intended to suggest that any of such entities endorse, recommend or approve of the services, analysis or recommendations of JMA or that We endorses, recommends or approves the services or products of such companies. News stories reflect only the author's opinion and not necessarily that of JMA.</p>
        <div class="sub-title">
          <h5>Links to third party websites</h5>
          <div class="sttl-line"></div>
        </div>
        <p>The Site or the Products may contain hyperlinks to websites operated by parties other than JMA, which may not have been screened or reviewed by JMA and which may contain inaccurate, inappropriate or offensive material, products or services. We do not control such websites, and We assume no responsibility or liability regarding the accuracy, reliability, legality or decency of such third-party websites, content, products or services. Such hyperlinks are provided for your convenience only. Our inclusion of hyperlinks to such websites does not imply any endorsement of the material on such websites or any association with their operators.</p>
        <div class="sub-title">
          <h5>Modification and monitoring of terms of use</h5>
          <div class="sttl-line"></div>
        </div>
        <p>We reserves the right, at its discretion, to change, modify, add or remove portions of these Terms of Use at any time without notice to you. We recommends that you check these Terms of Use periodically for changes. These Terms of Use can be accessed from the link at the bottom of each page of the Site. If you use the Site or the Products after We post changes to these Terms of Use, you accept the changed Terms of Use. JMA expressly reserves the right to monitor any and all use of the Site and the Products.</p>
        <div class="sub-title">
          <h5>Indemnity</h5>
          <div class="sttl-line"></div>
        </div>
        <p>You agree, at your own expense, to indemnify, defend and hold harmless JMA, its parents, subsidiaries and affiliates, and their officers, partners, managers, members, employees, agents, distributors and licensees, from and against any judgments, losses, deficiencies, damages, liabilities, costs, claims, demands, suits, and expenses (including, without limitation, reasonable attorney's fees and expenses) incurred in, arising out of or in any way related to your breach of these Terms of Use or the Privacy Policy, your use of the Site or any product or service related thereto, or any of your other acts or omissions.</p>
        <div class="sub-title">
          <h5>Jurisdictional issues and applicable law</h5>
          <div class="sttl-line"></div>
        </div>
        <p>These Terms of Use are governed by Japanese law, without regard to its choice of law provisions. You hereby consent to the exclusive and personal jurisdiction and venue of courts in the Tokyo Metropolitan Area, Japan, which shall have exclusive jurisdiction over any and all disputes arising out of or relating to these Terms of Use, the use of the Site or any product or service related thereto. Use of the Site is unauthorized in any jurisdiction that does not give effect to all provisions of these terms and conditions, including without limitation this paragraph.</p>
        <p>Software from the Site is further subject to Japanese export controls. Software from the Site may not be downloaded or otherwise exported or re-exported outside Japan. By downloading or using such software, you represent and warrant that you are not located in, under the control of, or a national or resident of any country or territory outside of the United States</p>
        <div class="sub-title">
          <h5>General</h5>
          <div class="sttl-line"></div>
        </div>
        <p>You agree that no joint venture, partnership, employment or agency relationship exists between you and JMA as a result of these Terms of Use or use of the Site or the Products.</p>
        <p>Our's performance of these Terms of Use is subject to existing laws and legal process, and nothing in these Terms of Use is in derogation of Our right to comply with law enforcement requests or requirements relating to your use of the Site, the Products or information provided to or gathered by JMA regarding such use.</p>
        <p>If any part of these Terms of Use is determined to be invalid or unenforceable pursuant to applicable law including, but not limited to, the warranty disclaimers and liability limitations set forth above, then the invalid or unenforceable provision shall be deemed superseded by a valid, enforceable provision that most closely matches the intent of the original provision and the remainder of these Terms of Use shall continue in effect.</p>
        <p>By reviewing or using the information on the Site or in the Products after accessing the Site, you represent and warrant that (a) you have the authority to enter into these Terms of Use and create a binding contractual obligation, (b) you understand and intend these Terms of Use to be the legal equivalent of a signed, written contract equally binding and (c) you will use the information on the Site and in the Products in a manner consistent with applicable laws and regulations in accordance with these Terms of Use, as the same may be amended by JMA online or otherwise from time to time. A printed version of these Terms of Use and any notice given in electronic form shall be admissible in judicial or administrative proceedings based on or relating to these Terms of Use to the same extent and subject to the same conditions as other business documents and records originally generated and maintained in printed form.</p>
        <p>These Terms of Use constitute the entire agreement between you and JMA with respect to the Site and the Products and they supersede all prior or contemporaneous communications and proposals, whether electronic, oral or written, between you and JMA regarding the Site and the Products.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@stop