<?php
define('SERVER_ROOT' , realpath( dirname(__DIR__)));
include("lib/wideimage-lib/WideImage.php");
//.'/../'//header("ContentType: image/$filetype");

 echo '<img src="' . WideImage::load(SERVER_ROOT.'/'.$_GET['path'])->resize($_GET['w'], $_GET['h'])->output('jpg', 90) . '" />';
?>