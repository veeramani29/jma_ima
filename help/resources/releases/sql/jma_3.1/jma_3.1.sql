/*
New fields in user_accounts table
1. stripe_customer_id
2. stripe_subscription_id
Added By : Shijo Thomas
*/

ALTER TABLE `jma_www`.`user_accounts` ADD COLUMN `stripe_customer_id` VARCHAR(40) NULL AFTER `oauth_uid`, ADD COLUMN `stripe_subscription_id` VARCHAR(40) NULL AFTER `stripe_customer_id`;

/*
Changed payment_status field's enum values
1. Added one more status 'F' Stands for Failed
Added By : Shijo Thomas
*/
ALTER TABLE `jma_www`.`payment_transactions` CHANGE `payment_status` `payment_status` ENUM('I','C','A','F') CHARSET utf8 COLLATE utf8_unicode_ci DEFAULT 'I' NULL; 



/* 
This template is using both payment status Success or failure
Added By : Veera */

INSERT INTO `email_templates` (`email_templates_id`, `email_templates_code`, `email_templates_subject`, `email_templates_message`, `email_templates_variable`) VALUES

(10, 'payment_status', 'Your Payment with Japan Macro Advisors', '<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Welcome to Japan Macro Advisors</title>\r\n</head>\r\n<body>\r\n	<div style="width:818px;float:left; font-family:Arial;border:1px solid black">\r\n    <div style="float:left; padding-left:80px;padding-top:10px;">\r\n    <img src="http://japanmacroadvisors.com/images/mail_template/logo.png" />\r\n    \r\n			<h3>Welcome to Japan Macro Advisors</h3>\r\n			</div>\r\n<div>\r\n<img src="http://japanmacroadvisors.com/images/mail_template/jmabanner.jpg" />\r\n</div><br />		\r\n<div style="width:655px; float:left; margin-top:-10px; padding-left:80px">\r\n		\r\n			{{msg}}\r\n    		\r\n       \r\n	</div>\r\n</div>\r\n</body>\r\n</html>', '{name}, {msg}');




/* 
This template is using  every month payment notification mail template
Added By : Veera */

INSERT INTO `jma_www`.`email_templates` (`email_templates_id`, `email_templates_code`, `email_templates_subject`, `email_templates_message`, `email_templates_variable`) VALUES (NULL, 'payment_notify_success', 'Your Payment with Japan Macro Advisors', '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Japan Macro Advisors</title>
</head>
<body>
	<div style="width:818px;float:left; font-family:Arial;border:1px solid black">
    <div style="float:left; padding-left:80px;padding-top:10px;">
    <img src="http://japanmacroadvisors.com/images/mail_template/logo.png" />
    
			<h3>Welcome to Japan Macro Advisors</h3>
			</div>
<div>
<img src="http://japanmacroadvisors.com/images/mail_template/jmabanner.jpg" />
</div><br />		
<div style="width:655px; float:left; margin-top:-10px; padding-left:80px">
		
			<p style="font-size:14px;">Dear <b>{{name}}</b>,</p>

<p style="font-size:14px;">We hope you have been enjoying reading updates on Japan’s economy. Your monthly Premium 

subscription with the email address <a href="mailto:{{email}}">{{email}}</a> has reached its renewal 

date. </p>

<p style="font-size:14px;">Your credit card was charged USD 30 on April 25, 2016 and your service remains uninterrupted.</p>

<p style="font-size:14px;">For any assistance, contact our <a href="http://japanmacroadvisors.com/helpdesk/post/">Helpdesk</a> or <a href="http://japanmacroadvisors.com/contact">Support</a></p>

<p style="font-size:14px;">You can access your account <a href="http://japanmacroadvisors.com/user/myaccount">My account</a></p>

<p style="font-size:14px;">Thank you,

<br>Japan Macro Advisors

<br><a href="http://japanmacroadvisors.com/">www.japanmacroadvisors.com</a></p>
    		
       
	</div>
</div>
</body>
</html>', '{name},{email}');


UPDATE `jma_www`.`email_templates` SET `email_templates_message` = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Japan Macro Advisors</title>
</head>
<body>
	<div style="width:818px;float:left; font-family:Arial;border:1px solid black">
    <div style="float:left; padding-left:80px;padding-top:10px;">
    <img src="http://japanmacroadvisors.com/images/mail_template/logo.png" />
    </div>
<div>
<img src="http://japanmacroadvisors.com/images/mail_template/jmabanner.jpg" />
</div><br>		
<div style="width:655px; float:left; margin-top:-10px; padding-left:80px">
		<p style="font-size:14px;">Dear {{name}},</p>
			<!-- <p style="font-size:14px;">Welcome to Japan Macro Advisors and thank you for signing up.</p>
			<p>If you requested information on our Corporate or Premium account, our representative will contact you shortly.</p> -->

			<p style="font-size:14px;">Thank you for signing up to Japan Macro Advisors. We hope you find our updated timely and informative.</p>
<p style="font-size:14px;">If you requested information on our Corporate account, a representative will contact you shortly.</p>

			<p><b>Account information :</b></p>
    
    <p style="font-size:14px; color:#000; font-weight:bold">
    	Account type : {{accountType}}<br><br>
    </p>
	
	<p style="font-size:14px;"><strong>JMA offers the following services:</strong></p>
	<a href="javascript:;" >Data and Charts</a><br>
	<a href="javascript:;" >Play around our interactive charts and download the chart image to share your own views on your blog or SNS.</a><br>
	<a href="http://japanmacroadvisors.com/page/category/economic-indicators/gdp-and-business-activity/gdp" target="_blank">GDP & Business activity</a><br>
	<a href="http://japanmacroadvisors.com/page/category/economic-indicators/international-balance/balance-of-payment" target="_blank">International balance</a><br>
	<a href="http://japanmacroadvisors.com/page/category/economic-indicators/inflation-and-prices/cpi" target="_blank">Inflation and price</a><br>
	<a href="http://japanmacroadvisors.com/page/category/economic-indicators/labor-markets/job-offers-to-applicant-ratio" target="_blank">Labor market</a><br>
	... and more!<br>
	</p>



	<p><strong>Our Economic Analysis on Japan</strong><br>
	Newsletters sent to your inbox offer short summaries of reports from our economists.</p>
	<!-- <a href="http://japanmacroadvisors.com/page/category/our-views-on-japan" target="_blank">Our Views on Japan: </a>Periodically updated report on our outlook for the Japanese economy.<br>
	<a href="http://japanmacroadvisors.com/page/category/breaking-news" target="_blank">Breaking News: </a>In-depth analysis of trends and key events in Japan.<br> -->
<b><a href="http://japanmacroadvisors.com/page/category/our-views-on-japan" target="_blank">Japan outlook :</a></b> A periodically updated report on the direction of the Japanese economy.<br>
<b><a href="http://japanmacroadvisors.com/page/category/breaking-news" target="_blank">News : </a></b>In-depth analysis of trends and key events in Japan.

	</p>

	<p><strong>My Charts</strong><br>
	My charts, a useful platform for your economic research.<br>
Create and save your own charts and much more!
	
	</p>

	<p><strong>Special Reports</strong><br>
	Periodical reports on the mid- to long-term outlook for Japan.<br>
	<a href="http://japanmacroadvisors.com/page/category/special-reports/how-global-is-japan-inc" target="_blank">How global is Japan Inc?</a><br>
	<a href="http://japanmacroadvisors.com/page/category/special-reports/abenomics-progress-report" target="_blank">Abenomics progress report</a><br>
	... and more!<br>
	</p>
	<p>
	Premium contents require Corporate accounts or Premium accounts. If you are interested in upgrading your account, please contact us at <a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>.
	</p>
	<p>
	If you encounter any problems with our services, please mail site <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a>.
	</p>
	Thank you for choosing Japan Macro Advisors.
		<p><br>
	Follow us on: <br><br>
	Twitter: <a href="https://twitter.com/JapanMadvisors" target="_blank">@japanMadvisors</a><br>
	Facebook: <a href="www.facebook.com/japanmacroadvisors" target="_blank">www.facebook.com/japanmacroadvisors</a><br>
	Linkedin: <a href="www.linkedin.com/company/japan-macro-advisors" target="_blank">www.linkedin.com/company/japan-macro-advisors</a>
	</p>
	</div>
</div>
</body>
</html>' WHERE `email_templates`.`email_templates_id` = 8;

INSERT INTO `jma_www`.`email_templates` (`email_templates_id`, `email_templates_code`, `email_templates_subject`, `email_templates_message`, `email_templates_variable`) VALUES (NULL, 'payment_notify_error', 'Your Payment with Japan Macro Advisors', '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Japan Macro Advisors</title>
</head>
<body>
	<div style="width:818px;float:left; font-family:Arial;border:1px solid black">
    <div style="float:left; padding-left:80px;padding-top:10px;">
    <img src="http://japanmacroadvisors.com/images/mail_template/logo.png" />
    
			<h3>Welcome to Japan Macro Advisors</h3>
			</div>
<div>
<img src="http://japanmacroadvisors.com/images/mail_template/jmabanner.jpg" />
</div><br />		
<div style="width:655px; float:left; margin-top:-10px; padding-left:80px">
		
			<p style="font-size:14px;">Dear <b>{{name}}</b>,</p>

<p style="font-size:14px;">We regret to inform you that your payment to renew your monthly Premium subscription with email address <a href="mailto:{{email}}">{{email}}</a> did not process. This happens sometime due to credit card decline, change in card expiration date or a need to “verify” your credit card.</p>

<p style="font-size:14px;">Your overdue payment is</p>
<p style="font-size:14px;">Amount: USD 30</p>

<p>First, please reply back to us to confirm that you received the notice and you are working to resolve the issue.</p>
<p>Please note that you have the privilege to change your credit card details with us. To add another card please follow the <a href="http://japanmacroadvisors.com/user/dopayment">payment page link </a>. </p>
<p style="font-size:14px;">You can access your subscription details page <a href="http://japanmacroadvisors.com/user/myaccount/subscription">Manage Subscription</a></p>

<p style="font-size:14px;">If you need any help, please let us know so we can assist you before your subscription is cancelled.</p>

<p style="font-size:14px;">Thank you,

<br>Japan Macro Advisors

<br><a href="http://japanmacroadvisors.com/">www.japanmacroadvisors.com</a></p>
    		
       
	</div>
</div>
</body>
</html>', '{name},{email}');



UPDATE `jma_www`.`email_templates` SET `email_templates_message` = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Japan Macro Advisors</title>
</head>
<body>
	<div style="width:818px;float:left; font-family:Arial;border:1px solid black">
    <div style="float:left; padding-left:80px;padding-top:10px;">
    <img src="http://japanmacroadvisors.com/images/mail_template/logo.png" />
    </div>
<div>
<img src="http://japanmacroadvisors.com/images/mail_template/jmabanner.jpg" />
</div><br>		
<div style="width:655px; float:left; margin-top:-10px; padding-left:80px">
		<p style="font-size:14px;">Dear {{name}},</p>
			<!-- <p style="font-size:14px;">Welcome to Japan Macro Advisors and thank you for signing up.</p>
			<p>If you have requested information on our {{title}}, our representative will contact you shortly.</p> -->
			

<p style="font-size:14px;">Thank you for signing up to Japan Macro Advisors. We hope you find our updated timely and informative.</p>
<p style="font-size:14px;">If you requested information on our Corporate account, a representative will contact you shortly.</p>
		<p><b>Account information :</b></p>
    <p style="font-size:14px; color:#000; font-weight:bold">
    	Account type : {{accountType}}<br><br>
       	Email : <span style="text-decoration: none">{{username}}</span><br><br>
       	Password : {{password}}
    </p>
	<!-- <p style="font-size:14px;"><strong>We hope our service provides you with timely insights and a deeper understanding of Japan.</strong></p>

	<p style="font-size:14px;"><strong>Quick look upon data releases with chart functions</strong>
	Play around our interactive charts and download the chart image to share your own views on your blog or SNS.<br> -->

	<p style="font-size:14px;"><strong>JMA offers the following services:</strong></p>
	<a href="javascript:;" >Data and Charts</a><br>
	<a href="javascript:;" >Play around our interactive charts and download the chart image to share your own views on your blog or SNS.</a><br>
	<a href="http://japanmacroadvisors.com/page/category/economic-indicators/gdp-and-business-activity/gdp" target="_blank">GDP & Business activity</a><br>
	<a href="http://japanmacroadvisors.com/page/category/economic-indicators/international-balance/balance-of-payment" target="_blank">International balance</a><br>
	<a href="http://japanmacroadvisors.com/page/category/economic-indicators/inflation-and-prices/cpi" target="_blank">Inflation and price</a><br>
	<a href="http://japanmacroadvisors.com/page/category/economic-indicators/labor-markets/job-offers-to-applicant-ratio" target="_blank">Labor market</a><br>
	... and more!<br>
	</p>



	<p><strong>Our Economic Analysis on Japan</strong><br>
	Newsletters sent to your inbox offer short summaries of reports from our economists.</p>
	<!-- <a href="http://japanmacroadvisors.com/page/category/our-views-on-japan" target="_blank">Our Views on Japan: </a>Periodically updated report on our outlook for the Japanese economy.<br>
	<a href="http://japanmacroadvisors.com/page/category/breaking-news" target="_blank">Breaking News: </a>In-depth analysis of trends and key events in Japan.<br> -->
<b><a href="http://japanmacroadvisors.com/page/category/our-views-on-japan" target="_blank">Japan outlook :</a></b> A periodically updated report on the direction of the Japanese economy.<br>
<b><a href="http://japanmacroadvisors.com/page/category/breaking-news" target="_blank">News : </a></b>In-depth analysis of trends and key events in Japan.

	</p>

	<p><strong>My Charts</strong><br>
	My charts, a useful platform for your economic research.<br>
Create and save your own charts and much more!
	
	</p>

	<p><strong>Special Reports</strong><br>
	Periodical reports on the mid- to long-term outlook for Japan.<br>
	<a href="http://japanmacroadvisors.com/page/category/special-reports/how-global-is-japan-inc" target="_blank">How global is Japan Inc?</a><br>
	<a href="http://japanmacroadvisors.com/page/category/special-reports/abenomics-progress-report" target="_blank">Abenomics progress report</a><br>
	... and more!<br>
	</p>
	<p>
	Premium contents require Corporate accounts or Premium accounts. If you are interested in upgrading your account, please contact us at <a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>.
	</p>
	<p>
	If you encounter any problems with our services, please mail site <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a>.
	</p>
	Thank you for choosing Japan Macro Advisors.
		<p><br>
	Follow us on: <br><br>
	Twitter: <a href="https://twitter.com/JapanMadvisors" target="_blank">@japanMadvisors</a><br>
	Facebook: <a href="www.facebook.com/japanmacroadvisors" target="_blank">www.facebook.com/japanmacroadvisors</a><br>
	Linkedin: <a href="www.linkedin.com/company/japan-macro-advisors" target="_blank">www.linkedin.com/company/japan-macro-advisors</a>
	</p>
	</div>
</div>
</body>
</html>', `email_templates_variable` = '{username}, {password}, {name}, {accountType},{title}' WHERE `email_templates`.`email_templates_id` = 7;



INSERT INTO `jma_www`.`email_templates` (`email_templates_id`, `email_templates_code`, `email_templates_subject`, `email_templates_message`, `email_templates_variable`) VALUES (NULL, 'payment_success', 'Your Payment with Japan Macro Advisors', '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Japan Macro Advisors</title>
</head>
<body>
	<div style="width:818px;float:left; font-family:Arial;border:1px solid black">
    <div style="float:left; padding-left:80px;padding-top:10px;">
    <img src="http://japanmacroadvisors.com/images/mail_template/logo.png" />
    
			<h3>Welcome to Japan Macro Advisors</h3>
			</div>
<div>
<img src="http://japanmacroadvisors.com/images/mail_template/jmabanner.jpg" />
</div><br />		
<div style="width:655px; float:left; margin-top:-10px; padding-left:80px">
		
			<p style="font-size:14px;">Dear <b>{{name}}</b>,</p>

<p style="font-size:14px;">Thank you for choosing Japan Macro Advisors. Your Premium subscription with the email address <a href="mailto:{{email}}">{{email}}</a> has been successful and your Premium account is now active.  Your monthly subscription fee is.</p>

<p style="font-size:14px;">Amount: USD 30</p>

<p>Your monthly subscription will auto-renew every month. </p>
<p style="font-size:14px;">For any assistance, contact our <a href="http://japanmacroadvisors.com/helpdesk/post/">Helpdesk</a> or <a href="http://japanmacroadvisors.com/contact">Support</a></p>

<p style="font-size:14px;">Thank you,

<br>Japan Macro Advisors

<br><a href="http://japanmacroadvisors.com/">www.japanmacroadvisors.com</a></p>
    		
       
	</div>
</div>
</body>
</html>', '{name},{email}');



INSERT INTO `jma_www`.`email_templates` (`email_templates_id`, `email_templates_code`, `email_templates_subject`, `email_templates_message`, `email_templates_variable`) VALUES (NULL, 'downgrade_success', 'Your Premium subscription has been downgraded to Free subscription', '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Japan Macro Advisors</title>
</head>
<body>
	<div style="width:818px;float:left; font-family:Arial;border:1px solid black">
    <div style="float:left; padding-left:80px;padding-top:10px;">
    <img src="http://japanmacroadvisors.com/images/mail_template/logo.png" />
    
			<h3>Welcome to Japan Macro Advisors</h3>
			</div>
<div>
<img src="http://japanmacroadvisors.com/images/mail_template/jmabanner.jpg" />
</div><br />		
<div style="width:655px; float:left; margin-top:-10px; padding-left:80px">
		
			<p style="font-size:14px;">Dear <b>{{name}}</b>,</p>

<p style="font-size:14px;">You successfully cancelled your monthly Premium subscription. Your account has been downgraded to Free User.</p>

<p style="font-size:14px;">Subscription charges will be cancelled the next time your account is up for monthly renewal.</p>
<!-- <p style="font-size:14px;">Please note that your payment for subscription charge of {{currency}} {{amount}} stands cancelled for the monthly Premium subscription at your next renewal.</p> -->
<p style="font-size:14px;">We would appreciate any feedback on our services at <a href="support@japanmacroadvisors.com">support@japanmacroadvisors.com</a>. </p>

<p>For more information on our products, check  <a href="http://japanmacroadvisors.com/products">here</a> </p>
<p style="font-size:14px;">Thank you for choosing Japan Macro Advisors.</p>


<p style="font-size:14px;">Thank you,

<br>Japan Macro Advisors

<br><a href="http://japanmacroadvisors.com/">www.japanmacroadvisors.com</a></p>
    		
       
	</div>
</div>
</body>
</html>', '{name},{email},{currency},{amount}');


/*
New Table mail_queue - For handling mail queue
Added By : Shijo Thomas
*/
CREATE TABLE `jma_www`.`mail_queue`( `id` INT NOT NULL AUTO_INCREMENT, `mail_type` ENUM('stripe_payment_success','stripe_payment_failure','notification') NOT NULL DEFAULT 'notification', `mail_to` TEXT NOT NULL, `mail_from` TEXT, `data` TEXT, PRIMARY KEY (`id`) ) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci; 




UPDATE `jma_www`.`email_templates` SET `email_templates_message` = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Japan Macro Advisors</title>
</head>
<body>
	<div style="width:818px;float:left; font-family:Arial;border:1px solid black">
    <div style="float:left; padding-left:80px;padding-top:10px;">
    <img src="http://japanmacroadvisors.com/images/mail_template/logo.png" />
    
			<h3>Welcome to Japan Macro Advisors</h3>
			</div>
<div>
<img src="http://japanmacroadvisors.com/images/mail_template/jmabanner.jpg" />
</div><br />		
<div style="width:655px; float:left; margin-top:-10px; padding-left:80px">
		<p style="font-size:14px;">Dear {{name}},</p>
			<p style="font-size:14px;">
				To activate your JMA account, click on the button below or paste the link below into your browser.
    		</p>
    		<p style="font-size:14px;">
<a href='{{activation_link}}' ><img src = "http://japanmacroadvisors.com/images/btn/activate_account_btn.png"></a>
<br><br>Link : {{activation_link}}<br><br>
</p>

       <p style="font-size:14px;">Thank you,<br>Japan Macro Advisors</p>
       	<p><br>
	Follow us on: <br><br>
	Twitter: <a href="https://twitter.com/JapanMadvisors" target="_blank">@japanMadvisors</a><br>
	Facebook: <a href="www.facebook.com/japanmacroadvisors" target="_blank">www.facebook.com/japanmacroadvisors</a><br>
	Linkedin: <a href="www.linkedin.com/company/japan-macro-advisors" target="_blank">www.linkedin.com/company/japan-macro-advisors</a>
	</p>
	</div>
</div>
</body>
</html>' WHERE `email_templates`.`email_templates_id` = 1;