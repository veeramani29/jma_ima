<?php include('controlPanel.php');
//ini_set('memory_limit', '128M');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>IndiaMacroAdvisors</title>
<link rel="stylesheet" href="themes/theme1/css/screen.css" type="text/css" media="screen" title="default" />
<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css" />
<![endif]-->

<!--  jquery core -->
<script src="themes/theme1/js/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="js/jma_admin.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=q2rya3n8ynujgdxqsommbewc66g7bqns86z9umq3zsvzy3eu"></script>

</head>
<body> 
<!-- Start: page-top-outer -->
<div id="page-top-outer">    

<!-- Start: page-top -->
<div id="page-top">

	<!-- start logo -->
	<div id="logo">
	<!--<a href=""><img src="images/shared/logo.png" width="156" height="40" alt="" /></a>-->
	</div>
	<!-- end logo -->
        
 	<div class="clear"></div>

</div>
<!-- End: page-top -->

</div>
<!-- End: page-top-outer -->
	
<div class="clear">&nbsp;</div>

<?php
$postPages   = array('listPost.php','addpost.php','editpost.php');
$catPages    = array('listcategory.php','addCategory.php','editCategory.php');
$writerPages = array('copywriter.php','addcopywriter.php','editcopywriter.php');
$chartPages  = array('addchart.php','listchart.php','editchart.php');
$mediaPages = array('addmedia.php','listMedia.php','editmedia.php');
$materialsPages = array('addmaterials.php','listMaterials.php','editmaterials.php');
$briefseriesPages = array('addbriefseries.php','listBriefSeries.php','editbriefseries.php');
$settingsPages = array('listSettings.php');
$moresettings = array('memcached.php','homepagegraph.php');
$userPages = array('listUser.php','editUser.php','addUser.php','listCompanies.php','addCompanies.php','editCompanies.php');
$emailTemplate = array('listEmail.php','editEmail.php','addEmail.php');
$graphPages=array('addGraph.php','editGraph.php','listGraph.php', 'viewGraph.php');
$mapPages=array('addMapGraph.php','editMap.php','listMap.php', 'viewMap.php');
$metaPages=array('addMeta.php','editMeta.php','listMeta.php');
$seoPages = array('addseopage.php', 'editseopage.php', 'deleteseopage.php', 'listseopages.php');
?>
 
<!--  start nav-outer-repeat................................................................................................. START -->
<div class="nav-outer-repeat"> 
<!--  start nav-outer -->
<div class="nav-outer"> 

		<!-- start nav-right -->
		<div id="nav-right">
		
		</div>
		<!-- end nav-right -->


		<!--  start nav -->
		<div class="nav" style="width:1280px;">
		<div class="table">
                    
                    
                    <ul <?php if( in_array(curPageName(),$postPages)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listPost.php"><b>Posts</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="listPost.php">View all Posts</a></li>
				<li ><a href="addpost.php">Add Posts</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
                    
                    <div class="nav-divider">&nbsp;</div>
                    
                    
                <ul <?php if( in_array(curPageName(),$catPages)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listcategory.php"><b>Category</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="listcategory.php">View all Category</a></li>
				<li ><a href="addCategory.php">Add Category</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
                    
                     <div class="nav-divider">&nbsp;</div>
                     
<!-- 	
		<ul <?php // if( in_array(curPageName(),$writerPages)) { ?>class="current" <?php // }else{?>class="select"<?php // }?>><li><a href="copywriter.php"><b>Copy writer</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
<!-- 
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="copywriter.php">View Copy writer</a></li>
				<li><a href="addcopywriter.php">Add Copy writer</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
<!-- 		
		</li>
		</ul>
                    
                <div class="nav-divider">&nbsp;</div>
-->
		
		<ul <?php if( in_array(curPageName(),$seoPages)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listseopages.php"><b>SEO Page</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="listseopages.php">List SEO Pages</a></li>
				<li><a href="addseopage.php">Add New Page</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>  
                
       <div class="nav-divider">&nbsp;</div>
		
		<ul <?php if( in_array(curPageName(),$mediaPages)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listMedia.php"><b>Media</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="listMedia.php">View Media</a></li>
				<li><a href="addmedia.php">Add Media</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
       <div class="nav-divider">&nbsp;</div>
		
		<ul <?php if( in_array(curPageName(),$materialsPages)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listMaterials.php"><b>Materials</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="listMaterials.php">View Materials</a></li>
				<li><a href="addmaterials.php">Add Materials</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul> 

         <div class="nav-divider">&nbsp;</div>
		
		<ul <?php if( in_array(curPageName(),$briefseriesPages)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listBriefSeries.php"><b>Brief Series</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="listBriefSeries.php">View Brief Series</a></li>
				<li><a href="addbriefseries.php">Add Brief Series</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>

 		
                   <div class="nav-divider">&nbsp;</div>
		
		<ul <?php if( in_array(curPageName(),$metaPages)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listMeta.php"><b>Meta</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="listMeta.php">View Meta</a></li>
				<li><a href="addmeta.php">Add Meta</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>     
                      <div class="nav-divider">&nbsp;</div>

		

		<ul <?php if( in_array(curPageName(),$graphPages)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listGraph.php"><b>Graph</b><!--[if IE 7]><!--></a><!--<![endif]-->

		<!--[if lte IE 6]><table><tr><td><![endif]-->

		<div class="select_sub show">

			<ul class="sub">

				<li><a href="listGraph.php">List Graph</a></li>

				<li><a href="addGraph.php">Add Graph</a></li>  

				

			</ul>

		</div></li></ul>   
                    <div class="nav-divider">&nbsp;</div>
					
					
		<ul <?php if( in_array(curPageName(),$mapPages)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listMap.php"><b>Map</b><!--[if IE 7]><!--></a><!--<![endif]-->

		<!--[if lte IE 6]><table><tr><td><![endif]-->

		<div class="select_sub show">

			<ul class="sub">

				<li><a href="listMap.php">List Map</a></li>

				<li><a href="addMapGraph.php">Add Map</a></li> 

			</ul>

		</div></li></ul>   
                    <div class="nav-divider">&nbsp;</div>			
					
                   
                <ul <?php if( in_array(curPageName(),$userPages)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listUser.php"><b>Users</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="listUser.php">List user</a></li>
				<li><a href="addUser.php">Add user</a></li>
				<li><a href="listCompanies.php">List Company</a></li> 
				<li><a href="addCompanies.php">Add Company</a></li> 
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>

           <div class="nav-divider">&nbsp;</div>
                   
                <ul <?php if( in_array(curPageName(),$emailTemplate)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="listEmail.php"><b>Email Template</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="listEmail.php">List Email Template</a></li>
				<li><a href="addEmail.php">Add Email Template</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul> 				
  
         <div class="nav-divider">&nbsp;</div>
		<ul <?php if( in_array(curPageName(),$moresettings)) { ?>class="current" <?php }else{?>class="select"<?php }?>><li><a href="memcached.php"><b>More Settings</b></a>
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="memcached.php">Cache Settings</a></li>
				<li><a href="homepagegraph.php">Home page Graph</a></li>		
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>           
           <div class="nav-divider">&nbsp;</div>    
					<div class="showhide-account">
                         <a href="changepasword.php" id="myaccount"> <img src="<?php // echo $adminThemeLink?>themes/theme1/images/shared/nav/nav_myaccount.gif" width="93" height="14" alt="" /></a>
                       	<a href="logout.php" id="logout"><img src="themes/theme1/images/shared/nav/nav_logout.gif" width="64" height="14" alt="" /></a>
                        </div>
                        
			<div class="nav-divider">&nbsp;</div>
		
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
		</div>
		<!--  start nav -->

</div>
<div class="clear"></div>
<!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->

 <div class="clear"></div>
 
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
