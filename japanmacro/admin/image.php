<?php
include("lib/wideimage-lib/WideImage.php");
//header("ContentType: image/$filetype");

 echo '<img src="' . WideImage::load($_GET['path'])->resize(100, 100)->output('jpg', 90) . '" />';
?>
