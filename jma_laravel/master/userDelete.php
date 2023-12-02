<?php include('controlPanel.php');
require SERVER_ROOT.'/vendor/vendor_mailgun/autoload.php';
use \Mailgun\Mailgun;

$id= $_REQUEST['id'];


$statusChage  = $userObj->userDelete($id);


$userDels = $userObj->getUserDetails($id);

$mgClient = new MailGun(env('MailGunAPI'));
$domain = 'mg.japanmacroadvisors.net';

$listAddress = env('MailGunListAddress');
$memberAddress = $userDels[0]['email'];
if(env('APP_ENV')=='production'){
$result = $mgClient->put("lists/$listAddress/members/$memberAddress", array(
   'subscribed'  => false
));
}
$return_url = $_SERVER['HTTP_REFERER'];

header("Location:$return_url");exit(0);