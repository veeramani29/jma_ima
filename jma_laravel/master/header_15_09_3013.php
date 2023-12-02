<?php 
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('memory_limit','128M');
error_reporting(E_ALL);
include('include/mysql.php');
include('include/common.php');
include('library/function.php');
$user_id = 0;
if(isset($_SESSION['user_id']))
{
	$user_id = $_SESSION['user_id'];
}

$meta_title = '';
$meta_keywords = '';
$meta_desc = '';

$meta_script = $_SERVER["SCRIPT_FILENAME"];
$meta_name = substr($meta_script, 
		strrpos($meta_script, '/')+1, -4);


$meta_result = $db->selectQuery("SELECT * FROM meta where filename like '$meta_name'");
if(isset($meta_result[0]))
{
	$meta_title = $meta_result[0]['title'];
	$meta_keywords = $meta_result[0]['keywords'];
	$meta_desc = $meta_result[0]['description'];
}
else
{
	$meta_result = $db->selectQuery("SELECT * FROM meta where filename like 'index'");
	if(isset($meta_result[0]))
	{
		$meta_title = $meta_result[0]['title'];
		$meta_keywords = $meta_result[0]['keywords'];
		$meta_desc = $meta_result[0]['description'];
	}
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $meta_title; ?></title>
<meta name="keywords" content="<?php echo $meta_keywords; ?>"/>
<meta name="description" content="<?php echo $meta_desc; ?>"/>
<link href='http://fonts.googleapis.com/css?family=PT+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Arimo:400,700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<link href="css/master.css" rel="stylesheet" type="text/css" />
<?php /*<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />*/ ?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
</head>
<body>
<div id="wrapper">
<!--header section-->
  <div id="headerouter">
    <div class="logosection"><a href="index.php"><img src="images/logo.jpg" alt="Logo" /></a></div>
    <div class="top_navigation">
      <ul>
	<?php
	if(intval($user_id))
	{
	?>
        <!--<li><a href="logout.php">Logout</a></li>-->
  <?php
	}
	else
	{
	?>
     
        <!--<li><a href="login.php">Login</a></li>-->
  <?php
	}
	?>

        <li><a href="index.php">Home</a></li>	
        <li><a href="about.php">About us</a></li>	
        <li><a href="contact.php">Contact</a></li>
        <li class="last"><a href="privacy_policy.php">Our Privacy Policy</a></li>

      </ul>
    </div>
<div id="header-logo">
  <div class="right"> <a id="signup" href="signup.php">Register to receive<br />alerts for new reports</a></div>
  <div class="left">CONCISEs AND INSIGHTFUL ANALYSIS ON THE JAPANESE ECONOMY</div>

</div>
  </div>
 <!--header section--> 
 <!--content section-->
 <div class="contentouter">
