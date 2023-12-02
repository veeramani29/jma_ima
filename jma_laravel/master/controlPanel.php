<?php ob_start();session_start();
ini_set("max_execution_time",120);
ini_set("upload_max_filesize ",'10M');
ini_set("post_max_size ",'10M');
//ini_set('memory_limit','1000M');
function includeFile($file)
{
    if(!file_exists($file))
    {
     echo "Unable to locate the file path:".$file;
    }
    include $file;
}
$commonFilePath = '';

includeFile($commonFilePath."library/mysql.php");
includeFile($commonFilePath."library/alaneememcached.php");

includeFile($commonFilePath."library/class.phpmailer.php");
includeFile($commonFilePath."library/function.php");
includeFile("lib/admin.php");
includeFile("lib/copywriter.php");
includeFile("lib/class.category.php");
includeFile("lib/class.post.php");
includeFile("lib/class.chart.php");
includeFile("lib/class.media.php");
includeFile("lib/class.materials.php");
includeFile("lib/class.briefseries.php");
includeFile("lib/class.meta.php");
includeFile("lib/class.user.php");
includeFile("lib/class.sharelogs.php");
includeFile("lib/class.seopages.php");
$adminObj = new admin();
$copywriterObj = new copywriter();
$catObj = new category();
$postObj = new post();
$chartObj =  new chart();
$mediaObj = new media();
$eventObj=new media();
$materialObj = new materials();
$briefSeriesObj = new briefseries();
$metaObj = new meta();
$userObj = new user();
$sharelogObj = new sharelogs();
$seopages = new seopages();

$isLogged = $adminObj->isLogged();

if( (curPageName() == 'index.php') && ($isLogged === false) ){
	//header("location:index.php");
}


$notinPageArray = array('forgotpassword.php','index.php');
if( ( (curPageName() != 'login.php') ) && ($isLogged === false) ){
	if(!in_array(curPageName(),$notinPageArray)){
		header("location:index.php");
	}
}

$adminThemeLink = 'http://localhost/japanmacroadvisors.com/jma_3.0/admin/';
 
if(isset($_SESSION['jma_admin_id']))
$admin_id = $_SESSION['jma_admin_id'];
//$_SESSION['lang'] = '';
define('CKW',700);
define('CKH',300);
?>
