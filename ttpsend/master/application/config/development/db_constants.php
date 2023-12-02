<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ADMIN', 'master_admin_users');
define('PRODUCTS', 'master_products');
define('SUBSCRIPTIONS', 'master_subscriptions');
define('TBL_PRODUCT_IMAGES', 'master_products_img');
define('DOWNLOADS', 'master_downloads');
 define('BANK_TRANSFERS', 'transaction_bank_transfers');
  define('DISCOUNTS', 'master_discount_codes');
 define('ORDERS', 'master_user_subscriptions');
 define('MAIL_TEMPLATE', 'master_mailtemplates');


define('NO_IMAGE', IMAGES.'kozers/thumb/0.jpg');
define('PRODUCT_IMAGE', HOST.'product_img/');

$Subscription_options = array(
                                ''  => 'Select',
                                '15'  => '15 Days (Free Trial)',
                                '90'    => '90 Days (3 Months) Short-Term',
                                '180'    => '180 Days (6 Months) Regular',
                                '365'    => '365 Days (1 Year) Regular',
                                '730'    => '730 Days (2 Years) Regular',
                                'Permanent'    => 'Permanent'
);

define('SUB_DURATION', serialize ($Subscription_options));
/* End of file constants.php */
/* Location: ./application/config/constants.php */