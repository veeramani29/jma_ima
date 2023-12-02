<?php include('header.php');?>
<?php
$id = $_REQUEST['id'];
if($id == ''){
    header('Location:listMeta.php');
}

$getMeta = $metaObj->getMetaDetails($id);

$filename = $getMeta[0]['filename'];
$title = $getMeta[0]['title'];
$keywords = $getMeta[0]['keywords'];
$desc = $getMeta[0]['description'];

$errorMsg = '';
 $insertArray = array();
  if(isset($_POST['addMeta'])){
      
	if($_POST['addMeta']){
			
								$filename = $_POST['filename'];
								$title = $_POST['title'];
								$keywords = $_POST['keywords'];
								$desc = $_POST['description'];
            
                            $metaObj->updateMetaFilename($id,$filename);
                            $metaObj->updateMetaTitle($id,$title);
                            $metaObj->updateMetaKeywords($id,$keywords);
                            $metaObj->updateMetaDesc($id,$desc);
						
                           header('Location:listMeta.php');
	}
}
?>

<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Edit Meta</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	
		<!-- start id-form -->
                 <form action="" name="add_media" enctype="multipart/form-data" id="add_media" method="post">
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                                                   
                    <tr>
                            <th valign="top">File Name:</th>
                            <td>
                                 <input type="text" name="filename" id="filename" class="inp-form" maxlength="250" value="<?php echo $filename; ?>" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Title:</th>
                            <td>
                                 <input type="text" name="title" id="title" class="inp-form" maxlength="250" value="<?php echo $title; ?>" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Keywords:</th>
                            <td>
                                 <input type="text" name="keywords" id="keywords" class="inp-form2" maxlength="250" value="<?php echo $keywords; ?>" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Description:</th>
                            <td>
                                 <input type="text" name="description" id="description" class="inp-form2" maxlength="1024" value="<?php echo $desc; ?>" />
                            </td>
                            <td></td>
                    </tr>


                <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="addMeta" class="form-submit" />

                    </td>
                    <td></td>
                </tr>

                </table>
          </form>
	<!-- end id-form  -->

	</td>
	<td>


</td>
</tr>

</table>
 
<div class="clear"></div>
 

</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>



<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<?php include('footer.php');?>
