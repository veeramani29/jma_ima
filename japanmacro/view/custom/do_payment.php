<?php  $CONF_CURRENCY = Config::read('subscription.currency');
 $CONF_AMOUNT = Config::read('subscription.amount');

  ?>



<div class="payloder">
<div id="spinner">
<i style="color:red;" class="fa fa-spinner fa-spin fa-5" ></i>
</div>
</div>

<div class="content_midsection">



<div class="mid_content"><!--Register section starts here--> 
<form class="cmxform signup_frm" action="<?php echo $this->url('custom/dopayment');?>" method="POST" id="payment-form" autocomplete="off">
<input type="hidden" value="<?php echo (isset($signup_ts) && $signup_ts!='')?$signup_ts:''; ?>" name="signup_ts" />

<input type="hidden" value="premium_annual" name="plan" />

<div class="register_content_outer">
	<div style="width: 532px;margin-bottom:8px; float: left">
	<!-- <div class="Header"><i style="color:#22558F;font-size:20px; margin: 0 0 0 0;" class="fa fa-user fa-lg"></i></div>
	<div class="Header"><i style="color:#22558F;font-size:11px; margin: -8px -1px -6px -6px;" class="fa fa-star fa-fw"></i></div> -->
	<div style="float:left;padding-left:4px;"><b>Subscription plan </b></div>	
</div> 
<div class="fontsize12" style="width:500px; float:left;">
<ul>
<li>Conference call on "The End of Kurodanomics"</li>
	<li>Costs $US 1000.<br /></li>
	
<li>You will receive an access code for the call, presentation slides and our special report "The End of Kurodanomics"  <br /></li>
</ul>
</div>
<div class="fontsize12" style="width:500px; float:left;">
<strong>Enter payment details:<br /></strong>
</div>
<div class="register_errorcon" align="center" <?php if($this->resultSet['status']==1) { ?> style="display: none"
<?php } ?>>  <?php echo $this->resultSet['message']; ?></div>

<div class="dopayment_errorcon"></div>


<div class="dopay_input fontsize12">
	<!-- <div class="register_box_label">Name on card: <small class="error" >*</small></div> -->
	<div class="register_box_input">
		<input type="text" size="20" onkeypress="return IsCharacter(event);" placeholder="Name on card *" maxlength="30" value="<?php echo (isset($_REQUEST['card_name']))?$_REQUEST['card_name']:$_SESSION['user']['fname'].' '.$_SESSION['user']['lname'];?>" autocomplete="off" class="form_textfield_payment card-name required" name="card_name"  class="required" style="" />	</div>
</div>
<div class="dopay_input fontsize12">
	<!-- <div class="register_box_label">Card Number: <small class="error" >*</small></div> -->
	<div class="register_box_input">
		<input type="text" size="20" onkeypress="return IsPhoneNumber(event);" placeholder="Card number *" maxlength="16" name="card-number" value="<?php echo (isset($_REQUEST['card-number']))?$_REQUEST['card-number']:'';?>"  autocomplete="off" class="form_textfield_payment card-number stripe-sensitive required" style="" />
	</div>
</div>
<div class="dopay_input fontsize12">
	<!-- <div class="register_box_label">Expires (MM/YYYY): <small class="error" >*</small></div> -->
	<div class="register_box_input">
		<input type="text" size="2"  onkeypress="return IsPhoneNumber(event);" maxlength="2" placeholder="MM *" name="card-expiry-month" value="<?php echo (isset($_REQUEST['card-expiry-month']))?$_REQUEST['card-expiry-month']:'';?>" class="form_textfield_payment card-expiry-month" style="width: 25%;display: inline-block;"/>
        <span> / </span>
		<input type="text"  onkeypress="return IsPhoneNumber(event);" size="4" maxlength="4" placeholder="YYYY *" name="card-expiry-year" value="<?php echo (isset($_REQUEST['card-expiry-year']))?$_REQUEST['card-expiry-year']:'';?>" class="form_textfield_payment card-expiry-year" style="width: 25%;display: inline-block;"/>
	</div>
</div>
<div class="dopay_input fontsize12">
	<!-- <div class="register_box_label">Card code: <small class="error" >*</small></div> -->
	<div class="register_box_input">
        <input type="password" size="4" onkeypress="return IsPhoneNumber(event);" placeholder="Card code *" maxlength="4" autocomplete="off" class="form_textfield_payment card-cvc" style="" />
	</div>
</div>		
<div class="fontsize12" style="width:500px; float:left;">
<strong>Billing address:<br /></strong>
</div>
<div class="dopay_input fontsize12">
<!-- 	<div class="register_box_label">Company Name:</div> -->
	<div class="register_box_input">
        <input type="text" size="20" placeholder="Company name" name="company" value="<?php echo (isset($_REQUEST['company']))?$_REQUEST['company']:'';?>" autocomplete="off" class="form_textfield_payment card-company" style="" />
	</div>
</div>		
<div class="dopay_input fontsize12">
	<!-- <div class="register_box_label">Address:</div> -->
	<div class="register_box_input">
        <input type="text" size="40" placeholder="Address" autocomplete="off" name="card-address" value="<?php echo (isset($_REQUEST['card-address']))?$_REQUEST['card-address']:$_SESSION['user']['address'].' '.$_SESSION['user']['address_1'];?>" class="form_textfield_payment card-address" style="" />
	</div>
</div>
<div class="dopay_input fontsize12">
	<!-- <div class="register_box_label">Zip code:</div> -->
	<div class="register_box_input">
        <input type="text" size="20" placeholder="Zip code" autocomplete="off" name="card-zipCode" value="<?php echo (isset($_REQUEST['card-zipCode']))?$_REQUEST['card-zipCode']:'';?>"  class="form_textfield_payment card-zipCode" style="" />
	</div>
</div>
<div class="dopay_input fontsize12">
	<!-- <div class="register_box_label">Country <small class="error" >*</small></div> -->
	<div class="register_box_input">
		<select class="card-country required" name="country_id" id="country_id" style="">
			<option value="">Country *</option>
			<?php
			$res = $this->resultSet['result']['country_list'];
			for($i=0;$i<count($res);$i++) {
				$selected = '';
				if((isset($_REQUEST['country_id']) && $_REQUEST['country_id']) == $res[$i]['country_id']){
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
</div>
<div class="dopay_input fontsize12">
	<!-- <div class="register_box_label">State:</div> -->
	<div class="register_box_input">
        <input type="text" size="20" placeholder="State" autocomplete="off" name="card-state" value="<?php echo (isset($_REQUEST['card-state']))?$_REQUEST['card-state']:'';?>"  class="form_textfield_payment card-state" style="" />
	</div>
</div>
<div class="dopay_input fontsize12">
	<!-- <div class="register_box_label">City:</div> -->
	<div class="register_box_input">
        <input type="text" size="20" placeholder="City" autocomplete="off" name="card-city" value="<?php echo (isset($_REQUEST['card-city']))?$_REQUEST['card-city']:'';?>"  class="form_textfield_payment card-city" style="" />
	</div>
</div>
<div class="dopay_input fontsize12">
	<!-- <div class="register_box_label">Phone:</div> -->
	<div class="register_box_input">
		<input type="hidden"  name="isd_code" id="isd_code" value="<?php echo (isset($_REQUEST['isd_code']))?$_REQUEST['isd_code']:'+81';?>"  class="card-isd-code" >
		<input type="text" size="10" onkeypress="return IsPhoneNumber(event);" placeholder="Phone number" name="phone_number" value="<?php echo (isset($_REQUEST['phone_number']))?$_REQUEST['phone_number']:$_SESSION['user']['phone'];?>" class="card-phone-number" style="width: 86%;padding-left: 65px;"/>	</div>
</div>
<div class="dopay_input fontsize12">
	<div class="register_box_input">
		<input type="checkbox" value="y" id="agree" value="<?php echo (isset($_REQUEST['agree']) && $_REQUEST['agree']=='y')?'checked':'';?>"  name="agree" class="required">
		I accept the <a id="terms" href="#terms_fancybox">terms of use 
		
		 </a>	

		
	</div>
</div>
<div style="display:none">

<div id="terms_fancybox" >
<h4><u>Agreement to terms of use</u></h4>
<p>Please read the following terms and conditions ("Terms of Use") before using the Japan Macro Advisors ("JMA", "We", "US" or "Our") website (the "Site") and our products including, but not limited to, our research, text, charts, videos, recordings ("Products") that are offered via email or other format provide by US. Your access to and use of the Site and the Products are subject to these Terms of Use and all applicable laws and regulations. The Terms of Use constitute a legal agreement between you and JMA. The Site and the Products are available only to, and may only be used by, individuals who can form legally binding contracts under applicable law. Without limiting the foregoing, the Site and the Products are not available to persons under age 18. By accessing and using the Site and the Products, you accept, without qualification, these Terms of Use. If you do not approve and accept these Terms of Use without qualification, you should exit the Site, and terminate the use of our Products immediately.</p>
<h4><u>Personal and non-commercial use limitation</u></h4>
<p>The Site and the Products are for your personal and non-commercial use. JMA grants you a non-exclusive, non-transferable and limited personal license to access and use the Site and the Products, conditioned on your continued compliance with these Terms of Use. You may not modify, copy (except as set forth below), distribute, transmit, display, perform, reproduce, publish, license, create derivative works from, transfer, or sell any information, products or services obtained from the Site and the Products. You may not link other websites to the Site without our prior written permission. You may print one hardcopy of the information and download one temporary copy of the information into one single computer's memory solely for your own personal, non-commercial use and not for distribution, provided that all copyright, trademark and other proprietary notices are kept intact. You may not allow others to use your user name or password to access or use any part of the Site or the Products. If your user name or password has been compromised for any reason, you should contact US immediately for a new user name and password. If you provide your user name or password to any third party, you will be solely responsible for any actions that such third party takes using that information. All information on the password-restricted areas of the Site and in the Products are confidential and private and may not be disclosed or distributed by you to any other person for any purpose and is made available solely for your personal use. You are prohibited from using the Site or the Products to advertise or perform any commercial solicitation. You also are prohibited from using any robot, spider, scraper or other automated means to access the Site for any purpose without the prior written permission of JMA. You may not take any action that imposes, or may impose, in our sole discretion, an unreasonable or disproportionately large load on Our infrastructure, interfere or attempt to interfere with the proper working of the Site or any activities conducted on the Site, or bypass any measures JMA may use to prevent or restrict access to the Site or the Products. JMA reserves any rights not expressly granted herein.</p>
<h4><u>Subscription Fees</u></h4>
<p>JMA provides three types of subscription: Free, Premium and Corporate. Free subscribers are entitled to no fee. Premium subscriber will pay the Monthly Fee for the monthly subscription on a monthly basis and Corporate subscriber will pay Monthly Fee for the quarterly subscription on a quarterly basis. All fees will be paid at the beginning of service. The initial service period of the monthly subscription is one (1) month and will auto renew for subsequent one (1) month periods until you cancel your subscription or send the 30 day notice to us before the subscription expires. </p>
<p>JMA may offer, as indicated on the Website Payment page, a trial period for its subscription products. The Subscriber will be billed at the beginning of the initial service period for services and will be charged, which starts after the 1 month trial period has concluded. Following any trial period, the normal terms of this Agreement will remain in effect. Service of the subscription will not begin until all charges have been processed.</p>
<p>Following the initial service period, JMA reserves the right to increase the Monthly Fee at any time upon 30 days notice to you, provided you shall have the right to terminate the Subscription by choosing Unsubscribe which turn back your subscription type to Free subscription from Premium subscription.  </p>
<p>You (a) agree to pay the Monthly Fee according to any applicable credit card issuer agreement, (b) expressly authorize JMA to automatically charge the applicable card on a monthly basis during the term of this Agreement (unless otherwise agreed by the parties), (c) agrees that any fee increase made in accordance with this Section may also be charged to the same card in the same manner and (d) that you will use the subscription for your own individual usage and you will not share your login credentials with other users. <u>Each individual user must have their own individual subscription.</u></p>
<h4><u>Subscription term</u></h4>
<p>Free subscription term/period is unlimited. Premium subscription and Corporate subscription will end after the expiration date until you cancel the subscription. Corporate subscription expiration will be handled by JMA and will terminate until user cancels his corporate subscriptions or send the 30 day notice to us. Once you cancel your subscriptions you will be notified via email and your subscription type will turn back to Free subscription. If you encounter any problem, please feel free to contact us at <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a> or you can submit your query at our <a href="<?php echo $this->url('helpdesk/post/');?>">Help Desk</a>.</p>
<h4><u>No Refund</u></h4>
<p>The credit card which you provide will automatically and immediately be billed for the Services you subscribe to. While in trial period the card will be charged only after the trial period ends on the expiration date. Premium subscription will be charged in JPY and corporate subscription in USD. If you cancel your Services you will no longer be billed but no money already paid will be refunded. If your credit card is invalid for any reason, JMA has the right to terminate the Services immediately.</p>
<h4><u>JMA is a financial publisher, not an investment adviser</u></h4>
<p>JMA is strictly a financial publisher. We are not, and are not registered as, an investment adviser, broker-dealer or other financial adviser or planner. For example, JMA and its officers, members, managers, employees and affiliates are not registered as investment advisers or broker-dealers with Japan Financial Service Agency or with any other regulatory authority, either in Japan or in other jurisdiction. We recommend consulting with a registered investment advisor, broker-dealer, and/or financial advisor in connection with your use of the Site and the Products. Any consequences (including any losses) resulting from your investments are your sole responsibility (whether or not you choose to seek advice from any such advisor).</p>
<p>JMA publishes information and our opinions regarding economic, financial, political and social issues in Japan and the rest of the world in which We believe our readers and subscribers may be interested and our reports reflect its sincere opinions. The Site and the Products do not and are not intended to provide any individualized investment advice. JMA will not and cannot offer personalized trading or investment advice and cannot request or consider your financial circumstances. Therefore, you agree not to provide JMA with any information about your financial situation, investment portfolio or other individual information, and further agree not to request any individualized investment advice.</p>
<h4><u>We are not liable to you</u></h4>



<p>Neither JMA nor any officer, member, manager, employees and affiliates thereof, will be liable to any subscriber, guest or anyone else for, among other things:</p>
<p>Any interruption, inaccuracy, error or omission, regardless of cause, in any information appearing on or furnished by JMA or for any damages whatsoever allegedly caused thereby;</p>
<p>Any unavailability of use of the Site or the Products, nor undelivered e-mails due to Internet bandwidth problems, equipment failure, or natural causes;</p>
<p>The information, software and services published on this Site and in the Products may include inaccuracies or typographical errors. Due to various factors, including the inherent possibility of human and mechanical error, the accuracy, completeness, timeliness and correct sequencing of such information, software and services. JMA does not guarantee the results obtained from their use or any persons creating or transmitting such information, software and services. The Site and the Products may be unavailable from time to time due to required maintenance, telecommunications interruptions or other reasons.</p>
<p>JMA and/or its suppliers make no representations about the suitability of the information, software, products and services on this Site and in the Products for any purpose. All such information, software, products and services are provided "as is" without warranty of any kind. JMA and/or its respective suppliers disclaim all warranties and conditions regarding this information, software, products and services, including all implied warranties and conditions of merchantability, fitness for a particular purpose, title, non-infringement and availability. Because some states/jurisdictions do not allow the exclusion of implied warranties, the above exclusion may not apply to you.</p>
<p>Your use of the Site and the Products is at your own risk. You are solely responsible for any damage to your computer system, loss of data or any other damage or loss that results from downloading any content from the Site or the Products.</p>
<p>JMA and/or its suppliers shall not be liable for any direct, indirect, punitive, incidental, special or consequential damages arising out of or in any way connected with or relating to the use of or access to this Site or the Products or with the delay or inability to use this Site, the Products or any information, software, products or services obtained through this Site or the Products, whether based on contract, tort, strict liability or otherwise, even if JMA or any of its suppliers has been advised of the possibility of damages. Because some jurisdictions do not allow the exclusion or limitation of liability for consequential or incidental damages, the above limitation may not apply to you.</p>
<p>JMA and any person creating or transmitting the information on the Site and in the Products shall not be liable for any infection by viruses of or damage to any computer that results from your use of, access to or downloading of such information. If you are dissatisfied with the information, products or services offered at the Site or in the Products or with these Terms of Use, your sole and exclusive remedy is to discontinue use of and access to the Site and the Products.</p>



<h4><u>Ownership of content</u></h4>
<p>The Site, the Products and all of their content, including but not limited to all text, graphics, charts, audio, logos, images, data compilations, icons, code and software ("Content"), are the property of JMA and are protected by Japanese and international copyright laws, with all rights reserved unless otherwise noted. All trademarks, service marks, trade names and other product and service names and logos displayed on the Site and in the Products are proprietary to JMA, including all registered and unregistered trademarks and service marks of the JMA. If the Site or any Products includes any trademarks, service marks, trade names or logos of any third parties, such items are the proprietary marks and names of their respective owners, and are protected by applicable trademark and intellectual property laws. Your use of any Content, whether owned by JMA or any third party, without our express written permission, is strictly prohibited except as otherwise expressly permitted in these Terms of Use. Without limiting the foregoing, you are prohibited from using any of the Our copyrighted material or trademarks for any purpose, including, but not limited to, use as links or otherwise on any website, without the Our prior written permission.</p>

<h4><u>Truthful information</u></h4>
<p>As a condition to your use of the Site and the Products, you represent and warrant to, and agree with US that, all of the information that you provide is truthful, accurate and complete. If We collect any information from users of the Site or the Products, the collection and use of such information is governed by our Privacy Policy which you should read before providing any information to US.</p>
<h4><u>No unlawful or prohibited use</u></h4>
<p>As a condition to your use of the Site and the Products, you represent and warrant to, and agree with US that you will not use the Site or the Products for any purpose that is unlawful or prohibited by these Terms of Use.</p>
<h4><u>References to publications and other companies</u></h4>
<p>References to any publication, companies or institutions in the Site or the Products are for reference and informational purposes only and are not intended to suggest that any of such entities endorse, recommend or approve of the services, analysis or recommendations of JMA or that We endorses, recommends or approves the services or products of such companies. News stories reflect only the author's opinion and not necessarily that of JMA.</p>


<h4><u>Links to third party websites</u></h4>
<p>The Site or the Products may contain hyperlinks to websites operated by parties other than JMA, which may not have been screened or reviewed by JMA and which may contain inaccurate, inappropriate or offensive material, products or services. We do not control such websites, and We assume no responsibility or liability regarding the accuracy, reliability, legality or decency of such third-party websites, content, products or services. Such hyperlinks are provided for your convenience only. Our inclusion of hyperlinks to such websites does not imply any endorsement of the material on such websites or any association with their operators.</p>
<h4><u>Modification and monitoring of terms of use</u></h4>
<p>We reserves the right, at its discretion, to change, modify, add or remove portions of these Terms of Use at any time without notice to you. We recommends that you check these Terms of Use periodically for changes. These Terms of Use can be accessed from the link at the bottom of each page of the Site. If you use the Site or the Products after We post changes to these Terms of Use, you accept the changed Terms of Use. JMA expressly reserves the right to monitor any and all use of the Site and the Products.</p>
<h4><u>Indemnity</u></h4>
<p>You agree, at your own expense, to indemnify, defend and hold harmless JMA, its parents, subsidiaries and affiliates, and their officers, partners, managers, members, employees, agents, distributors and licensees, from and against any judgments, losses, deficiencies, damages, liabilities, costs, claims, demands, suits, and expenses (including, without limitation, reasonable attorney's fees and expenses) incurred in, arising out of or in any way related to your breach of these Terms of Use or the Privacy Policy, your use of the Site or any product or service related thereto, or any of your other acts or omissions.</p>
<h4><u>Jurisdictional issues and applicable law</u></h4>
<p>These Terms of Use are governed by Japanese law, without regard to its choice of law provisions. You hereby consent to the exclusive and personal jurisdiction and venue of courts in the Tokyo Metropolitan Area, Japan, which shall have exclusive jurisdiction over any and all disputes arising out of or relating to these Terms of Use, the use of the Site or any product or service related thereto. Use of the Site is unauthorized in any jurisdiction that does not give effect to all provisions of these terms and conditions, including without limitation this paragraph.</p>
<p>Software from the Site is further subject to Japanese export controls. Software from the Site may not be downloaded or otherwise exported or re-exported outside Japan. By downloading or using such software, you represent and warrant that you are not located in, under the control of, or a national or resident of any country or territory outside of the United States</p>
<h4><u>General</u></h4>

<p>You agree that no joint venture, partnership, employment or agency relationship exists between you and JMA as a result of these Terms of Use or use of the Site or the Products.</p>
<p>Our's performance of these Terms of Use is subject to existing laws and legal process, and nothing in these Terms of Use is in derogation of Our right to comply with law enforcement requests or requirements relating to your use of the Site, the Products or information provided to or gathered by JMA regarding such use.</p>
<p>If any part of these Terms of Use is determined to be invalid or unenforceable pursuant to applicable law including, but not limited to, the warranty disclaimers and liability limitations set forth above, then the invalid or unenforceable provision shall be deemed superseded by a valid, enforceable provision that most closely matches the intent of the original provision and the remainder of these Terms of Use shall continue in effect.</p>
<p>By reviewing or using the information on the Site or in the Products after accessing the Site, you represent and warrant that (a) you have the authority to enter into these Terms of Use and create a binding contractual obligation, (b) you understand and intend these Terms of Use to be the legal equivalent of a signed, written contract equally binding and (c) you will use the information on the Site and in the Products in a manner consistent with applicable laws and regulations in accordance with these Terms of Use, as the same may be amended by JMA online or otherwise from time to time. A printed version of these Terms of Use and any notice given in electronic form shall be admissible in judicial or administrative proceedings based on or relating to 
these Terms of Use to the same extent and subject to the same conditions as other business documents and records originally generated and maintained in printed form.</p>
<p>These Terms of Use constitute the entire agreement between you and JMA with respect to the Site and the Products and they supersede all prior or contemporaneous communications and proposals, whether electronic, oral or written, between you and JMA regarding the Site and the Products.</p>
<!-- <p>YOU SHOULD PRINT OR SAVE THESE TERMS OF USE BY USING THE "PRINT" OR "FILE SAVE" OPTIONS ON YOUR INTERNET BROWSER.</p> -->


</div>


</div>

<div class="dopay_input fontsize12" style="">

	<div class="register_box_input">
		<button type="submit" class="btn form_submit_btn" name="submit-button" value="Submit" style="" > <i class="fa fa-angle-double-right"></i> Submit</button>
	</div>
</div>
</div>
<!--register section end here-->
</form>
</div>
</div>
<?php 
 include('view/templates/rightside.php');
?>
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<!-- jQuery is used only for this example; it isn't required to use Stripe -->
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->
<script type="text/javascript">
// this identifies your website in the createToken call below
Stripe.setPublishableKey('<?php echo $this->resultSet['result']['stripe_publish_key']; ?>');

$(function() { 

$('#payment-form')
        .find('[name="phone_number"]')
            .intlTelInput({
               // utilsScript: '/js/intlTelInput.min.js',
                autoPlaceholder: true,
                preferredCountries: ['jp', 'us', 'in']
            });



            $('ul.country-list li.country').on('click', function() {
	var option1 = $(this).data('dial-code');

	 $('#isd_code').val("+"+option1);

	 });
$('#country_id').on('change', function() {
	var option = $('option:selected', this).attr('code').toLowerCase();
	
	var country_code = $('ul.country-list li.country.active').data('country-code');
	var country_name = $('ul.country-list li.country.active span.country-name').text();
	var dial_code = $('ul.country-list li.country.active').data('dial-code');
	$('div.selected-flag div.iti-flag').removeClass(country_code).addClass(option);
	$('ul.country-list li.country').removeClass('active');
	$('ul.country-list li.country[data-country-code="'+option+'"]').addClass('active');
	var sel_country_name =$('ul.country-list li.country[data-country-code="'+option+'"] span.country-name').text();
	var sel_dial_code =$('ul.country-list li.country[data-country-code="'+option+'"]').data('dial-code');
	$('div.selected-flag').attr("title",(sel_country_name+': '+"+"+sel_dial_code));
   		
      
          $('#isd_code').val("+"+sel_dial_code);
          
       
      });

            });

$(document).ready(function() {

	


	$("a#terms").fancybox({
		
autoDimensions: false,
height: 400,
width: 800,
opacity:0.6,
speedIn  :600,
speedOut   :200,
centerOnScroll: true,
scrolling		: 'yes',
autoScale: true,
	
	
  }); 

                function addInputNames() {

                    // Not ideal, but jQuery's validate plugin requires fields to have names
                    // so we add them at the last possible minute, in case any javascript 
                    // exceptions have caused other parts of the script to fail.
                    $(".card-number").attr("name", "card-number")
                    $(".card-cvc").attr("name", "card-cvc")
                    $(".card-expiry-year").attr("name", "card-expiry-year")
                }

                function removeInputNames() {
                    $(".card-number").removeAttr("name")
                    $(".card-cvc").removeAttr("name")
                    $(".card-expiry-year").removeAttr("name")
                }

                function submit(form) {

                	$('.payloder').show();
    				$('html, body').animate({scrollTop : 0},800);
                    // remove the input field names for security
                    // we do this *before* anything else which might throw an exception
                    removeInputNames(); // THIS IS IMPORTANT!

                    // given a valid form, submit the payment details to stripe
                    $(form['submit-button']).attr("disabled", "disabled")
                   
                    Stripe.createToken({
						name: $('.card-name').val(),
						number: $('.card-number').val(),
						cvc: $('.card-cvc').val(),
						exp_month: $('.card-expiry-month').val(),
						exp_year: $('.card-expiry-year').val(),
						address_line1: $('.card-address').val(),
						address_zip: $('.card-zipCode').val(),
						address_country: $('.card-country').val(),
						address_state: $('.card-state').val(),
						address_city: $('.card-city').val()
                    }, function(status, response) {
                        if (response.error) {
                            // re-enable the submit button
                            $(form['submit-button']).removeAttr("disabled")
							switch (response.error.type) {
							  case 'card_error':
								// A declined card error
								response.error.message = 'your card is declined'; // => e.g. "Your card's expiration year is invalid."
								break;
							  case 'invalid_request_error':
								// Invalid parameters were supplied to Stripe's API
								response.error.message = 'Sorry! Something went wrong. Please try again later.'; 
								break;
							  case 'api_error':
								// An error occurred internally with Stripe's API
								response.error.message = 'Sorry! Something went wrong. Please try again later.'; 
								break;
							  case 'api_connection_error':
								// Some kind of error occurred during the HTTPS communication
								response.error.message = 'Sorry! Something went wrong. Please try again later.'; 
								break;
							  case 'authentication_error':
								// You probably used an incorrect API key
								response.error.message = 'Sorry! Something went wrong. Please try again later.'; 
								break;
							  case 'rate_limit_error':
								// You probably used an incorrect API key
								response.error.message = 'Sorry! Something went wrong. Please try again later.'; 
								break;	
							}
                            // show the error
                            $(".dopayment_errorcon").html(response.error.message);

                            // we add these names back in so we can revalidate properly
                            addInputNames();
                        } else {
                            // token contains id, last4, and card type
                            var token = response['id'];

                            // insert the stripe token
                            var input = $("<input name='stripeToken' value='" + token + "' style='display:none;' />");
                            form.appendChild(input[0])

                            // and submit
                            form.submit();
                        }
                    });
                    
                    return false;
                }
                
                // add custom rules for credit card validating
                jQuery.validator.addMethod("cardNumber", Stripe.validateCardNumber, "Please enter a valid card number");
                jQuery.validator.addMethod("cardCVC", Stripe.validateCVC, "Please enter a valid security code");
                jQuery.validator.addMethod("cardExpiry", function() {
                    return Stripe.validateExpiry($(".card-expiry-month").val(), 
                                                 $(".card-expiry-year").val())
                }, "Please enter a valid expiration");

                // We use the jQuery validate plugin to validate required params on submit
                $("#payment-form").validate({
                    submitHandler: submit,
                    rules: {
                        "card-cvc" : {
                            cardCVC: true,
                            required: true
                        },
                        "card-number" : {
                            cardNumber: true,
                            required: true
                        },
                        "card-expiry-month" : {
                           
                            required: true
                        },
                        "card-expiry-year" : "cardExpiry" // we don't validate month separately
                    },

                });

                // adding the input field names is the last step, in case an earlier step errors     

                addInputNames();
            });

</script>