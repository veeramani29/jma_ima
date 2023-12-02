<?php
include('header.php');
require SERVER_ROOT.'/vendor/vendor_mailgun/autoload.php';
use \Mailgun\Mailgun; 

$mgClient= $mgObject = new MailGun(env('MailGunAPI'));
$domain = 'mg.indiamacroadvisors.net';

$queryString = array('event' => 'delivered','limit' => '300');

$result = $mgClient->get("$domain/events", $queryString);

$get_Arr = json_decode(json_encode($result), true);
echo count($get_Arr['http_response_body']['items']);
$newArr = $get_Arr['http_response_body']['items'];
print_r($newArr);

?>