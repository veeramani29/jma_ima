<?php
/**
 * Check unique email
 * NOTE: Requires PHP version 5 or later
 * @package admin - user
 * @author bonie@reowix.in
 * @copyright 2012 reowix
 * @creatd on 6 july 2012
 */

include_once("../../config/config.php");
include_once("../../library/mysql.php");
include_once("../lib/class.user.php");
$email   =  $_REQUEST['email'];
$userOb  =  new user();
$retVal  =  $userOb->uniqueMailCheck($email);
if($retVal == 0){ echo 'true'; } else { echo 'false'; }
?>
