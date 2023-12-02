<?php

return [
'appication_path' => realpath( dirname(__DIR__).'/../'),
'environment' => env('APP_ENV'),

//SMTP mail configurations
'SMTPserver' => env('MAIL_HOST'),
'SMTPport' => env('MAIL_PORT'),
'SMTPusername' => env('MAIL_USERNAME'),
'SMTPpassword' => env('MAIL_PASSWORD'),

//[imageCDN]
'imageCDN' => array(
	'development'=>'',
	'test' => 'content.indiamacroadvisors.com/images',
	'production' => 'content.indiamacroadvisors.com/images',
	),

//[jsCDN]
'jsCDN' => array(
	'development'=>'',
	'test' => 'content.indiamacroadvisors.com/js',
	'production' => 'content.indiamacroadvisors.com/js',
	),

//[jsCDN]
'assetsCDN' => array(
	'development'=>'',
	'test' => 'content.indiamacroadvisors.com/assets',
	'production' => 'content.indiamacroadvisors.com/assets',
	),

//[cssCDN]
'cssCDN' => array(
	'development'=>'',
	'test' => 'content.indiamacroadvisors.com/css',
	'production' => 'content.indiamacroadvisors.com/css',
	),

// Stripe  payment connfigurations
//;pk_live_IiHzWUL69kpHM52Tj2NKkgJz
'stripe' => array(
	'development'=>array('api_key'=>'sk_test_AxMZ0qKW3fJxC9FXh9duOf8C','publish_Key'=>'pk_test_goLF7zzPwzChlljx9W1PMzep'),
	'test'=>array('api_key'=>'sk_test_AxMZ0qKW3fJxC9FXh9duOf8C','publish_Key'=>'pk_test_goLF7zzPwzChlljx9W1PMzep'),
	'production'=>array('api_key'=>'sk_test_AxMZ0qKW3fJxC9FXh9duOf8C','publish_Key'=>'pk_test_goLF7zzPwzChlljx9W1PMzep')
	),

// subscription
'subscription' => array(
	'currency'=>'INR', 'amount'=>799
	),

// Razorpay payment connfigurations
'razorpay' => array(
	'development'=>array(
	'api_key'=>'rzp_test_0G426euDFns9qo',
	'api_secret'=>'sXJWqSvJCPJUjuMXsIBVUHQN',
	'api_plan'=>'plan_AKrk5o334H0U2W'
	),
	'test'=>array(
	'api_key'=>'rzp_test_0G426euDFns9qo',
	'api_secret'=>'sXJWqSvJCPJUjuMXsIBVUHQN',
	'api_plan'=>'plan_AKrk5o334H0U2W'
		),
	'production'=>array(
		'api_key'=>'rzp_test_0G426euDFns9qo',
	'api_secret'=>'sXJWqSvJCPJUjuMXsIBVUHQN',
	'api_plan'=>'plan_AKrk5o334H0U2W'
		)
),


// Paypal payment connfigurations
'paypal' => array(
	'development'=>array(

		'username'=>'adarsh.babug_api1.gmail.com',
		'password'=>'X87DTQ6URX3WTJF3',
		'signature'=>'AFIcNTPQaZAHWKlTFoGxyQxfdVKRA7imJkXaVeFChvlC1aFqL1uatCZp',
	
		/*'username'=>'b.adarsh01_api1.gmail.com',
		'password'=>'M33XK48TKEBN7FAC',
		'signature'=>'Ao5pXSs6cGHeVa10-q6.4nn67.KBAdmShAIbeQOtnYGKlkmVI.BJGDei',*/
		'api_endpoint'=>'https://api-3t.sandbox.paypal.com/nvp',
		'payment_url'=>'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=',
		'api_version'=>'114'
		),
	'test'=>array(
		'username'=>'shijo-developer_api1.alanee.com',
		'password'=>'1400828499',
		'signature'=>'AFcWxV21C7fd0v3bYYYRCpSSRl31Af646PmZMBVio-jUwdpfqDufdoVc',
		'api_endpoint'=>'https://api-3t.sandbox.paypal.com/nvp',
		'payment_url'=>'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=',
		'api_version'=>'114'
		),
	'production'=>array(
	'username'=>'shijo-developer_api1.alanee.com',
		'password'=>'1400828499',
		'signature'=>'AFcWxV21C7fd0v3bYYYRCpSSRl31Af646PmZMBVio-jUwdpfqDufdoVc',
		'api_endpoint'=>'https://api-3t.sandbox.paypal.com/nvp',
		'payment_url'=>'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=',
		'api_version'=>'114'
		)
	),

// LinkedIn configuration
'LinkedIn' => array(
	'development'=>array(
		'baseURL'=> url('/user/signup'),
		'callbackURL'=> url('/user/linkedinProcess'),
		'linkedinApiKey'=>'78kztb0v4r824h',
		'linkedinApiSecret'=>'5ahxppwruJ7Djjeg',
		'linkedinScope'=>'r_liteprofile r_emailaddress'
		
		),
	'test'=>array(
		'baseURL'=> url('/user/signup'),
		'callbackURL'=> url('/user/linkedinProcess'),
		'linkedinApiKey'=>'78kztb0v4r824h',
		'linkedinApiSecret'=>'5ahxppwruJ7Djjeg',
		'linkedinScope'=>'r_liteprofile r_emailaddress'
		),
	'production'=>array(
	'baseURL'=> url('/user/signup'),
		'callbackURL'=> url('/user/linkedinProcess'),
		#'linkedinApiKey'=>'75hfoo8awwmh8g',
		#'linkedinApiSecret'=>'os4fiWsJ1nIrTBFO', 
		'linkedinApiKey'=>'78kztb0v4r824h',
		'linkedinApiSecret'=>'5ahxppwruJ7Djjeg',
		'linkedinScope'=>'r_liteprofile r_emailaddress'
		)
	),

// Chart configurations
'chart' => array(
	'download'=>array('tempfolder'=> base_path()."/public/temp/"),
	'export'=>array('BATIK_PATH'=>base_path().'/vendor/vendor_batik/')
	),
//download['tempfolder'] = '/var/www/www/temp/'
//export['BATIK_PATH'] = '/var/www/www/libraries/batik/'

// memcached configurations
'memcached' => array(
	'development'=>array('server'=>'127.0.0.1','port'=>'11211'),
	'test'=>array('server'=>'10.0.0.216','port'=>'11211'),
	'production'=>array('server'=>'10.0.0.249','port'=>'11211')
	),

// mailconfig payment connfigurations
'mailconfig' => array(
	'development'=>array(
		'newuser_notification_to'=> 'team@indiamacroadvisors.com',
		'newuser_notification_subject'=> 'New User signed up - DEV',
		'oxford_enquiry_to'=> 'team@indiamacroadvisors.com',
		'oxford_enquiry_subject'=> 'New enquiry on Oxford page - DEV',
		'upgradeRequest_notification_to'=>'team@indiamacroadvisors.com',
		'upgradeRequest_notification_subject'=> 'Account upgrade request - DEV',
		'payment_notification_to'=> 'report@indiamacroadvisors.com'
		),
	'test'=>array(
		'newuser_notification_to'=> 'team@indiamacroadvisors.com',
		'newuser_notification_subject'=> 'New User signed up - TEST SERVER',
		'oxford_enquiry_to'=> 'team@indiamacroadvisors.com',
		'oxford_enquiry_subject'=> 'New enquiry on Oxford page - TEST SERVER',
		'upgradeRequest_notification_to'=>'team@indiamacroadvisors.com',
		'upgradeRequest_notification_subject'=> 'Account upgrade request - TEST SERVER',
		'payment_notification_to'=> 'report@indiamacroadvisors.com'
		),
	'production'=>array(
	'newuser_notification_to'=> 'report@indiamacroadvisors.com',
		'newuser_notification_subject'=> 'New User signed up - LIVE',
		'oxford_enquiry_to'=> 'team@indiamacroadvisors.com',
		'oxford_enquiry_subject'=> 'New enquiry on Oxford page - LIVE',
		'upgradeRequest_notification_to'=>'report@indiamacroadvisors.com',
		'upgradeRequest_notification_subject'=> 'Account upgrade request - LIVE',
		'payment_notification_to'=> 'report@indiamacroadvisors.com'
		)
	),



// MailGunConfig configuration
'MailGunConfig' => array(
	'development'=>array(
		'MailGunAPI'=> 'key-9ff03593f82696cfa7a5e253e6bb8cb8',
		'MailGunDomain'=> 'mg.indiamacroadvisors.net',
		'FromInfoMail'=>'info@mg.indiamacroadvisors.net',
		'JmaDevTeam'=>'srinivasan.m@japanmacroadvisors.com',
		'MailGunListAddress'=>'test@mg.indiamacroadvisors.net'
		
		),
	'test'=>array(
		'MailGunAPI'=> 'key-9ff03593f82696cfa7a5e253e6bb8cb8',
		'MailGunDomain'=> 'mg.indiamacroadvisors.net',
		'FromInfoMail'=>'info@mg.indiamacroadvisors.net',
		'JmaDevTeam'=>'team@indiamacroadvisors.com',
		'MailGunListAddress'=>'test@mg.indiamacroadvisors.net'
		),
	'production'=>array(
		'MailGunAPI'=> 'key-9ff03593f82696cfa7a5e253e6bb8cb8',
		'MailGunDomain'=> 'mg.indiamacroadvisors.net',
		'FromInfoMail'=>'info@mg.indiamacroadvisors.net',
		'JmaDevTeam'=>'report@indiamacroadvisors.com',
		'MailGunListAddress'=>'imabreakingnews@mg.indiamacroadvisors.net'
		)
	),

// [cloudinary]
'cloudinary' => array(
	
		'cloud_name'=>'jma-mobile',
		'api_key'=>'572334978779747',
		'api_secret'=>'zIelXVq7s-AgRP0bWXnz7W1JbT0'
		
		),
	
	

];
