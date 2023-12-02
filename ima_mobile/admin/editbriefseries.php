<style>
<?php include("calendar/CalendarControl.php");?>
</style>
<script src="calendar/CalendarControl.js" language="javascript"></script>
<?php include('header.php');
include("lib/wideimage-lib/WideImage.php");
?>
<script language="javascript">
    $(document).ready(function() {
        $('#add_briefseries').submit(function() {
            var ret = true;
            $('#briefseries_title_error').html('');$('#briefseries_title_img_error').html('');$('#briefseries_summery_file_error').html('');$('#briefseries_date_error').html('');
            var title     =   $('#briefseries_title').val();
            var img      =   $('#imageFile').val(); 
            var fle      =   $('#summeryFile').val();
            var dte		=	$('#briefseries_date').val();
            var tpe = $('#briefseriesType').val();
			
            if(title == ''){
                $('#briefseries_title_error').html('Please enter Title.');
                ret =  false;
            }
			
            /* if((tpe == 'general' || $briefseriesType == 'oxford') && (img == '' || checkImg(img) == false)){
                   $('#briefseries_title_img_error').html('Please upload a valid image file.');
                  ret =  false;
            }
			
			 if(fle == ''){
                $('#briefseries_summery_file_error').html('Please upload a brief series summery file');
                ret =  false;
            } */ 
			
			/* 
			if(tpe != '' && checkImg(tpe) == false){
               $('#briefseries_title_img_error').html('Please upload a valid image file.');
              ret =  false;
            }
			
			if(fle != '' && checkImg(fle) == false){
               $('#briefseries_title_img_error').html('Please upload a brief series summery file.');
              ret =  false;
            } */
			
            if(dte == ''){
                $('#briefseries_date_error').html('Please enter Date.');
                ret =  false;
            }
            
                      
            return ret;
     });
    });

function checkImg(imagePath) {
var pathLength  = imagePath.length;
var lastDot     = imagePath.lastIndexOf(".");
var fileType    = imagePath.substring(lastDot,pathLength);
if((fileType == ".gif") || (fileType == ".jpg") || (fileType == ".jpeg") || (fileType == ".png") || (fileType == ".GIF") || (fileType == ".JPG") || (fileType == ".PNG")) {
return true;
} else {
return false;
}
} 

function setbriefseriesType() {
	if($('#briefseriesType').val() == 'japanese') {
		$('#briefseries_title_error').html('');$('#briefseries_title_img_error').html('');$('#briefseries_summery_file_error').html('');$('#briefseries_date_error').html('');
		$('#tr_briefseries_image').hide();
		$('#tr_briefseries_description').hide();
	}else if($('#briefseriesType').val() == 'oxford'){
		$('#briefseries_title_error').html('');$('#briefseries_title_img_error').html('');$('#briefseries_summery_file_error').html('');$('#briefseries_date_error').html('');
		$('#tr_briefseries_image').show();
		$('#tr_briefseries_description').show();
	} else {
		$('#briefseries_title_error').html('');$('#briefseries_title_img_error').html('');$('#briefseries_summery_file_error').html('');$('#briefseries_date_error').html('');
		$('#tr_briefseries_image').show();
		$('#tr_briefseries_description').hide();
	}
  }  
</script>

<?php
$id = $_REQUEST['id'];
if($id == ''){
	header('Location:listBriefSeries.php');
}

$getBriefSeries = $briefSeriesObj->getBriefSeriesDetails($id);
$briefseries_type = $getBriefSeries[0]['briefseries_type'];
$briefseries_title    = $getBriefSeries[0]['briefseries_title'];
$briefseries_description = $getBriefSeries[0]['briefseries_description'];
$briefseries_title_img    = $getBriefSeries[0]['briefseries_title_img'];
$briefseries_path   = $getBriefSeries[0]['briefseries_summary_path'];
$briefseries_ppt_path   = $getBriefSeries[0]['briefseries_ppt_path'];
$briefseries_date  = $getBriefSeries[0]['briefseries_date'];
$isPremium = $getBriefSeries[0]['is_premium'];

$errorMsg = '';
$insertArray = array();

if($_POST['addBriefSeries']){
	try {
	$update_fields = array();
	$files_to_delete = array();
	if($briefseries_type != $_POST['briefseriesType']) {
		if($_POST['briefseriesType'] == '')
			throw new Exception("Select brief series type");
		$update_fields['briefseries_type'] = $_POST['briefseriesType'];
	}
	if($briefseries_title != $_POST['materials_title']) {
		if($_POST['materials_title'] == '')
			throw new Exception("Enter a Title");
		$update_fields['briefseries_title'] = $_POST['materials_title'];
	}
	if($briefseries_date != $_POST['briefseries_date']) {
		if($_POST['briefseries_date'] == '')
			throw new Exception("Enter a date");
		$update_fields['briefseries_date'] = $_POST['briefseries_date'];
	}
	if($isPremium != $_POST['is_premium']) {
		$update_fields['is_premium'] = $_POST['is_premium'];
	}

	
	if($briefseries_type == 'general' || $briefseries_type == 'oxford') {
		if($_FILES['imageFile']['name']!='') {
			// image upload
			$file = time()."_".str_replace(' ','_',$_FILES['imageFile']['name']);
			$imageFile = '';
			$materialFile = '';
			if($_FILES['imageFile']['type'] == 'image/png' || $_FILES['imageFile']['type'] == 'image/gif' || $_FILES['imageFile']['type'] == 'image/jpeg' || $_FILES['imageFile']['type'] == 'image/jpg' || $_FILES['imageFile']['type'] == 'image/pjpeg') {
				$img = WideImage::load('imageFile');
			} else {
				throw new Exception("Error..! selected image is not supported", 9999);
			}
			$filepath = '../public/uploads/briefseries/'.$file;
			$img->saveToFile($filepath);
			if(file_exists($filepath)) {
				$imageFile = 'public/uploads/briefseries/'.$file;
			} else {
				throw new Exception("Error..! image write error occured.", 9999);
			}
			$update_fields['briefseries_title_img'] = $imageFile;
			$files_to_delete[] = '../'.$briefseries_title_img;
		}
	}
	
	
	if($briefseries_type == 'general' || $briefseries_type == 'oxford') {
		$materialDescription = cleanMyCkEditor(trim($_POST['description']));
		if($briefseries_description != $materialDescription) {
			$update_fields['briefseries_description'] = $materialDescription;
		}
	}
	
	// brief series summery file upload
	
	if($_FILES['summeryFile']['name'] != ''){
		$mFile = str_replace(' ','_',$_FILES['summeryFile']['name']);
		$summeryFile = 'public/files/'.$mFile;
		if(file_exists('../public/files/'.$mFile)) {
			unlink('../public/files/'.$mFile);
		} else{
			$files_to_delete[] = '../'.$briefseries_path;
		}
		$udfneme = '../public/files/'.$mFile;
		if(file_exists($udfneme)) {
			unlink($udfneme);
		}
		if(move_uploaded_file($_FILES['summeryFile']['tmp_name'],$udfneme)) {
			$update_fields['briefseries_summary_path'] = $summeryFile;
		} else {
			throw new Exception("Error in uploading material file");
		}
		
	}

	// brief series ppt file upload
	
    if($_FILES['pptFile']['name'] != ''){
		$mFile = str_replace(' ','_',$_FILES['pptFile']['name']);
		$pptFile = 'public/files/'.$mFile;
		if(file_exists('../public/files/'.$mFile)) {
			unlink('../public/files/'.$mFile);
		} else{
			$files_to_delete[] = '../'.$briefseries_ppt_path;
		}
		$udfneme = '../public/files/'.$mFile;
		if(file_exists($udfneme)) {
			unlink($udfneme);
		}
		if(move_uploaded_file($_FILES['pptFile']['tmp_name'],$udfneme)) {
			$update_fields['briefseries_ppt_path'] = $pptFile;
		} else {
			throw new Exception("Error in uploading material file");
		}
		
	}
	
	}catch (Exception $ex) {
		$errorMsg = $ex->getMessage();
	}
	if($errorMsg == '' && !empty($update_fields)) {
		if($briefSeriesObj->updateThisBriefSeries($id,$update_fields)) {
			foreach ($files_to_delete as $fles){
				unlink($fles);
			}
			header('Location:listBriefSeries.php');
		} else{
			$errorMsg = "DB Error...! Database update failed..";
		}
		
	}
	
}
?>
<script type="text/javascript" src="../public/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../public/plugins/ckeditor/ckfinder.js"></script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Edit Breif Series</h1></div>


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
                 <form action="" name="add_briefseries" enctype="multipart/form-data" id="add_briefseries" method="post">
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
				<table border="0" cellpadding="0" cellspacing="0" id="id-form">
					<tr>
						<th>Brief Series Type:</th>
						<td>
							<select name="briefseriesType" id="briefseriesType" onchange="setbriefseriesType()">
								<option value="general" <?php if($briefseries_type=="general"){ ?> selected="selected" <?php } ?> >General</option>
								<option value="japanese" <?php if($briefseries_type=="japanese"){ ?> selected="selected" <?php } ?>>Japanese</option>
								<option value="oxford" <?php if($briefseries_type=="oxford"){ ?> selected="selected" <?php } ?>>Oxford Economics</option>
							</select>
						</td>
					</tr>
                    <?php if($briefseries_type == 'general' || $briefseries_type == 'oxford') { ?>   
					<tr id="tr_briefseries_image">
						<th>Title Image:</th>
						<td><input type="file" name="imageFile" id="imageFile"
							class="file_1" /  > <label for="imageFile" class="error"
							id="briefseries_title_img_error"></label></td>
					</tr>
                    <?php } ?>
						<tr id="tr_briefseries_image" style="display:none;">
							<th>Title Image:</th>
							<td><input type="file" name="imageFile" id="imageFile"
								class="file_1" /  > <label for="imageFile" class="error"
								id="briefseries_title_img_error"></label></td>
						</tr>
					
					<tr>
						<th valign="top">Brief Series Title:</th>
						<td><input name="materials_title" type="text" id="briefseries_title"
							class="inp-form" value="<?php echo htmlspecialchars($briefseries_title,ENT_QUOTES);?>"> <label for="briefseries_title" class="error"
							id="briefseries_title_error"></label></td>
						<td></td>
					</tr>
					<?php if($briefseries_type == 'oxford') { ?>
                     <tr>
                            <th valign="top"> Description:</th>
                            <td>
                                <textarea  name="description" id="mate_desc" cols="5" rows="5"  ><?php echo htmlspecialchars($briefseries_description,ENT_QUOTES);?></textarea>
						<script type="text/javascript">
						   if ( typeof CKEDITOR == 'undefined' ){}
						   else{
							var editor = CKEDITOR.replace( 'mate_desc',{
										height:100,
										width:600
										} );
							CKFinder.SetupCKEditor( editor, '../public/plugins/ckeditor/' ) ;
						   }
						  </script>
                                <label for="post" class="error" id="post_error"></label>
                            </td>
                            <td></td>
                    </tr>
					<?php } ?> 
					
					   <tr id="tr_briefseries_description" style="display: none">
                            <th valign="top"> Description:</th>
                            <td>
                                <textarea  name="description" id="mate_desc" cols="5" rows="5"  ><?php echo htmlspecialchars($briefseries_description,ENT_QUOTES);?></textarea>
						<script type="text/javascript">
						   if ( typeof CKEDITOR == 'undefined' ){}
						   else{
							var editor = CKEDITOR.replace( 'mate_desc',{
										height:100,
										width:600
										} );
							CKFinder.SetupCKEditor( editor, '../public/plugins/ckeditor/' ) ;
						   }
						  </script>
                                <label for="post" class="error" id="post_error"></label>
                            </td>
                            <td></td>
                    </tr>
					
					<tr>
						<th>Brief Series summary File:</th>
						<td><input type="file" name="summeryFile" id="summeryFile"
							class="file_1" /> <label for="summerylFile" class="error"
							id="briefseries_summery_file_error"></label></td>
					</tr>

                     <tr>
						<th>Brief Series PPT File:</th>
						<td><input type="file" name="pptFile" id="pptFile"
							class="file_1" /> <label for="summerylFile" class="error"
							id="materials_ppt_file_error"></label></td>
					</tr>

					<tr>
						<th>Date:</th>
						<td valign="top"><input type="hidden" name="txt_startDate"
							id="txt_startDate" value="" /> <input name="briefseries_date"
							type="text" class="textBox_style2" id="briefseries_date"
							value="<?php echo $briefseries_date;?>" readonly="readonly" /> <a
							onclick="showCalendarControl(add_briefseries.briefseries_date,'add_briefseries.txt_startDate');"><img
							src="calendar/calendar.gif" border="0" /></a></td>
						<td></td>
					</tr>
					<tr>
						<th>Is Premium:</th>
						<td valign="top">
							<select name="is_premium" style="width:50px">
								<option value="Y" <?php echo $isPremium == 'Y' ? 'selected' : '';?>>Y</option>
								<option value="N"<?php echo $isPremium == 'N' ? 'selected' : '';?>>N</option>
							</select>
						</td>
						<td></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td valign="top"><input type="submit" value="Submit"
							name="addBriefSeries" class="form-submit" /></td>
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
