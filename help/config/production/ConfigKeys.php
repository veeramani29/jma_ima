<?php

return [
//realpath( dirname(__DIR__).'/../'),
'appication_path' => '',
'environment' => env('APP_ENV'),

//SMTP mail configurations
'SMTPserver' => env('MAIL_HOST'),
'SMTPport' => env('MAIL_PORT'),
'SMTPusername' => env('MAIL_USERNAME'),
'SMTPpassword' => env('MAIL_PASSWORD'),

//[imageCDN]
'imageCDN' => array(
	'development'=>'',
	'test' => 'testing.content.japanmacroadvisors.com/images',
	'production' => 'content.japanmacroadvisors.com/images',
	),

//[jsCDN]
'jsCDN' => array(
	'development'=>'',
	'test' => 'testing.content.japanmacroadvisors.com/js',
	'production' => 'content.japanmacroadvisors.com/js',
	),

//[jsCDN]
'assetsCDN' => array(
	'development'=>'',
	'test' => 'testing.content.japanmacroadvisors.com',
	'production' => 'content.japanmacroadvisors.com',
	),

//[cssCDN]
'cssCDN' => array(
	'development'=>'',
	'test' => 'testing.content.japanmacroadvisors.com/css',
	'production' => 'content.japanmacroadvisors.com/css',
	),

// Stripe  payment connfigurations
////;pk_live_IiHzWUL69kpHM52Tj2NKkgJz
'stripe' => array(
	'development'=>array('api_key'=>'sk_test_AxMZ0qKW3fJxC9FXh9duOf8C','publish_Key'=>'pk_test_goLF7zzPwzChlljx9W1PMzep'),
	'test'=>array('api_key'=>'sk_test_2ti1Je2omkKmBKhjEOhVz4L5','publish_Key'=>'pk_test_goLF7zzPwzChlljx9W1PMzep'),
	'production'=>array('api_key'=>'sk_live_IfiYH3jME87H4ln58jzPXJQi','publish_Key'=>'pk_live_IiHzWUL69kpHM52Tj2NKkgJz')
	),

// Paypal payment connfigurations
'paypal' => array(
	'development'=>array(
		'username'=>'29veeramani_api1.gmail.com',
		'password'=>'2WFQ7WV558LSJTZU',
		'signature'=>'Ap5W3DCacgQZ1b0OfRO29PCBcoMJAlGOdibIRVbOH2jXwlg23f9K44R0',
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
	'username'=>'okubo.takuji_api1.gmail.com',
		'password'=>'8BHTCCQ8SHPU8L8Z',
		'signature'=>'A.7LmTOXeCCf1qog3uZ11atHEcmaAhTRiW.VCfQzvtUBBvbOpv2otJZ2',
		'api_endpoint'=>'https://api-3t.paypal.com/nvp',
		'payment_url'=>'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=',
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
		'linkedinScope'=>'r_liteprofile r_emailaddress r_basicprofile w_member_social '
		
		),
	'test'=>array(
		'baseURL'=> url('/user/signup'),
		'callbackURL'=> url('/user/linkedinProcess'),
		'linkedinApiKey'=>'78kztb0v4r824h',
		'linkedinApiSecret'=>'5ahxppwruJ7Djjeg',
		'linkedinScope'=>'r_liteprofile r_emailaddress r_basicprofile w_member_social '
		),
	'production'=>array(
	'baseURL'=> url('/user/signup'),
		'callbackURL'=> url('/user/linkedinProcess'),
		'linkedinApiKey'=>'7544v0lvvnwbkq',
		'linkedinApiSecret'=>'yNeWmEV5X7rhBwdF',
		'linkedinScope'=>'r_liteprofile r_emailaddress r_basicprofile w_member_social '
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
	'development'=>array('server'=>'localhost','port'=>'11211'),
	'test'=>array('server'=>'10.0.0.168','port'=>'11211'),
	'production'=>array('server'=>'10.0.0.200','port'=>'11211')
	),

// mailconfig payment connfigurations
'mailconfig' => array(
	'development'=>array(
		'newuser_notification_to'=> 'team@japanmacroadvisors.com',
		'newuser_notification_subject'=> 'New User signed up - DEV',
		'oxford_enquiry_to'=> 'team@japanmacroadvisors.com',
		'oxford_enquiry_subject'=> 'New enquiry on Oxford page - DEV',
		'upgradeRequest_notification_to'=>'team@japanmacroadvisors.com',
		'upgradeRequest_notification_subject'=> 'Account upgrade request - DEV',
		'payment_notification_to'=> 'report@japanmacroadvisors.com'
		),
	'test'=>array(
		'newuser_notification_to'=> 'team@japanmacroadvisors.com',
		'newuser_notification_subject'=> 'New User signed up - TEST SERVER',
		'oxford_enquiry_to'=> 'team@japanmacroadvisors.com',
		'oxford_enquiry_subject'=> 'New enquiry on Oxford page - TEST SERVER',
		'upgradeRequest_notification_to'=>'team@japanmacroadvisors.com',
		'upgradeRequest_notification_subject'=> 'Account upgrade request - TEST SERVER',
		'payment_notification_to'=> 'report@japanmacroadvisors.com'
		),
	'production'=>array(
	'newuser_notification_to'=> 'report@japanmacroadvisors.com',
		'newuser_notification_subject'=> 'New User signed up - LIVE',
		'oxford_enquiry_to'=> 'team@japanmacroadvisors.com',
		'oxford_enquiry_subject'=> 'New enquiry on Oxford page - LIVE',
		'upgradeRequest_notification_to'=>'report@japanmacroadvisors.com',
		'upgradeRequest_notification_subject'=> 'Account upgrade request - LIVE',
		'payment_notification_to'=> 'report@japanmacroadvisors.com'
		)
	),

// subscription
'subscription' => array(
	'currency'=>'USD', 'amount'=>100
	),

// MailGunConfig configuration
'MailGunConfig' => array(
	'development'=>array(
		'MailGunAPI'=> 'key-9ff03593f82696cfa7a5e253e6bb8cb8',
		'MailGunDomain'=> 'mg.japanmacroadvisors.net',
		'FromInfoMail'=>'info@mg.japanmacroadvisors.net',
		'JmaDevTeam'=>'team@japanmacroadvisors.com',
		'MailGunListAddress'=>'tets@mg.japanmacroadvisors.net'
		
		),
	'test'=>array(
		'MailGunAPI'=> 'key-9ff03593f82696cfa7a5e253e6bb8cb8',
		'MailGunDomain'=> 'mg.japanmacroadvisors.net',
		'FromInfoMail'=>'info@mg.japanmacroadvisors.net',
		'JmaDevTeam'=>'team@japanmacroadvisors.com',
		'MailGunListAddress'=>'tets@mg.japanmacroadvisors.net'
		),
	'production'=>array(
		'MailGunAPI'=> 'key-9ff03593f82696cfa7a5e253e6bb8cb8',
		'MailGunDomain'=> 'mg.japanmacroadvisors.net',
		'FromInfoMail'=>'info@mg.japanmacroadvisors.net',
		'JmaDevTeam'=>'report@japanmacroadvisors.com',
		'MailGunListAddress'=>'jmanews@mg.japanmacroadvisors.net'
		)
	),

// [cloudinary]
'cloudinary' => array(
	
		'cloud_name'=>'jma-mobile',
		'api_key'=>'572334978779747',
		'api_secret'=>'zIelXVq7s-AgRP0bWXnz7W1JbT0'
		
		),
	
	

];
