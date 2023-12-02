<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>404 Page Not Found | Admin</title>
<link rel="stylesheet" href="<?php echo CSS;?>style.default.css" type="text/css" />
<script type="text/javascript" src="<?php echo JS;?>plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="<?php echo JS;?>plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="<?php echo JS;?>plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo JS;?>custom/general.js"></script>
<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
</head>

<body>

<div class="bodywrapper">
    <div class="topheader orangeborderbottom5">
        <div class="left">
            <h1 class="logo"><a href="<?php echo HOST;?>dashboard"><?php echo PROJECT_NAME_HTML;?></a></h1>
            <span class="slogan">Admin</span>
            
          
            
            <br clear="all" />
            
        </div><!--left-->
        
       
    </div><!--topheader-->
    
    
    <div class="contentwrapper padding10">
    	<div class="errorwrapper error404">
        	<div class="errorcontent">
                <h1>404 Page Not Found</h1>
                <h3>We couldn't find that page. It appears that you are lost.</h3>
                
                <p>The page you are looking for is not found. This could be for several reasons</p>
                <ul>
                    <li>It never existed.</li>
                    <li>It got deleted for some reason.</li>
                    <li>You were looking for something that is not here.</li>
                    <li>You like this page.</li>
                </ul>
                <br />
                <button class="stdbtn btn_black" onclick="history.back()">Go Back to Previous Page</button> &nbsp; 
               
                 <button onclick="location.href='<?php echo HOST_ADMIN;?>dashboard'" class="stdbtn btn_orange">Go Back to Dashboard</button>
                 
              
            </div><!--errorcontent-->
        </div><!--errorwrapper-->
    </div>    
    
    
</div><!--bodywrapper-->

</body>

</html>
