<style>
<?php include("calendar/CalendarControl.php");?>
</style>
<?php 
include('header.php');
include("lib/wideimage-lib/WideImage.php");
?>
<script src="calendar/CalendarControl.js" language="javascript"></script>
<script language="javascript">
    $(document).ready(function() {
        $('#add_briefseries').submit(function() {
            var ret = true;
			var tpe = $('#briefseriesType').val();
			if(tpe != "japanese")
			{
				$('#briefseries_title_error').html('');$('#briefseries_title_img_error').html('');$('#briefseries_summery_file_error').html('');$('#briefseries_date_error').html('');
				var title     =   $('#briefseries_title').val();
				var img      =   $('#imageFile').val(); 
				var fle      =   $('#summeryFile').val();
				var dte		=	$('#briefseries_date').val();
			  
				if(title == ''){
					$('#briefseries_title_error').html('Please enter Title.');
					ret =  false;
				}
				if((tpe == 'general' || $briefseriesType == 'oxford') && (img == '' || checkImg(img) == false)){
					   $('#briefseries_title_img_error').html('Please upload a valid image file.');
					  ret =  false;
				}
				if(dte == ''){
					$('#briefseries_date_error').html('Please enter Date.');
					ret =  false;
				}
				
				if(fle == ''){
					$('#briefseries_summery_file_error').html('Please upload a brief series summery file');
					ret =  false;
				}  	
				return ret;
			
			}
			else
			{
				$('#briefseries_title_error').html('');$('#briefseries_title_img_error').html('');$('#briefseries_summery_file_error').html('');$('#briefseries_date_error').html('');
				var title     =   $('#briefseries_title').val();
				
				var fle      =   $('#summeryFile').val();
				
				if(title == ''){
					$('#briefseries_title_error').html('Please enter Title.');
					ret =  false;
				}
				if(fle == ''){
					$('#briefseries_summery_file_error').html('Please upload a brief series summery file');
					ret =  false;
				}  	
				return ret;
			}
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
$errorMsg = '';
$insertArray = array();
      
if($_POST['addBriefSeries']){
	
	

	
	// print_r($_POST); exit('------------------');
	try {
		$doc_path = '';
		
		$briefseriesType = $_POST['briefseriesType'];

		$briefseriesTitle  = trim($_POST['materials_title']);
	//	$briefseriesTitle  = cleanInputField($briefseriesTitle);
	
		$briefseriesDescription = cleanMyCkEditor(trim($_POST['description']));

		$briefseriesDate=trim($_POST['briefseries_date']);
	//	$briefseriesDate=cleanInputField($briefseriesDate);
	
		$is_premium=$_POST['is_premium'];

		if($briefseriesTitle == ''){
			$errorMsg ='Please enter Title.<br/>';
		}
		if($briefseriesDate == ''){
			$errorMsg = $errorMsg .'Please enter a date.<br/>';
		}
		if(($briefseriesType == 'general' || $briefseriesType == 'oxford') && $_FILES['imageFile']['name'] == '') {
			$errorMsg = $errorMsg .'Please upload media file.<br/>';
		}
		
		$briefSeriesPath = '../public/uploads/briefseries/';
			if (!is_dir($briefSeriesPath)) {


				mkdir($briefSeriesPath,0777);         

				//mkdir($briefSeriesPath);         


		}
		
		$briefSeriesFile = "public/uploads/briefseries/";
		
		if($briefseriesType == 'general' || $briefseriesType == 'oxford') {
			// image upload
			$file = time()."_".str_replace(' ','_',$_FILES['imageFile']['name']);
			$imageFile = '';
			$summerylFile = '';
			if($_FILES['imageFile']['type'] == 'image/png' || $_FILES['imageFile']['type'] == 'image/gif' || $_FILES['imageFile']['type'] == 'image/jpeg' || $_FILES['imageFile']['type'] == 'image/jpg' || $_FILES['imageFile']['type'] == 'image/pjpeg') {
				$img = WideImage::load('imageFile');
			} else {
				throw new Exception("Error..! selected image is not supported", 9999);
			}
			$filepath = $briefSeriesPath.$file;
			$img->saveToFile($filepath);
			if(file_exists($filepath)) {
				$imageFile = $briefSeriesFile.$file;
			} else {
				throw new Exception("Error..! image write error occured.", 9999);
			}
		} else {
			$imageFile = '';
		}
		
		
		
		  $briefSeriesFile = "public/files/";
		  $briefSeriesPath = '../public/files/';
			$summerylFilePath = "";
			// summery file upload
			if($_FILES['summeryFile']['name'] != ''){
				$mFile = str_replace(' ','_',$_FILES['summeryFile']['name']);
				$summerylFilePath = $briefSeriesFile.$mFile;
				if(file_exists($briefSeriesPath.$mFile)) {
					throw new Exception("File already exists - use different filename");
				}
				if(!move_uploaded_file($_FILES['summeryFile']['tmp_name'],$briefSeriesPath.$mFile)) {
					throw new Exception("Error in uploading brief series summery file");
				}
	
			} else {
				$errorMsg = $errorMsg .'Please upload brief series summery file.<br/>';
			}
			
			// ppt file upload
			$pptFilePath = "";
			if($_FILES['pptFile']['name'] != ''){
				$pptFile = str_replace(' ','_',$_FILES['pptFile']['name']);
				$pptFilePath = $briefSeriesFile.$pptFile;
				if(file_exists($briefSeriesPath.$pptFile)) {
					throw new Exception("File already exists - use different filename");
				}
				if(!move_uploaded_file($_FILES['pptFile']['tmp_name'],$briefSeriesPath.$pptFile)) {
					throw new Exception("Error in uploading brief series ppt file");
				}
	
			}

			
		$insertArray['briefseries_type'] = $briefseriesType;
		$insertArray['briefseries_title'] = $briefseriesTitle;
		$insertArray['briefseries_description'] = $briefseriesDescription;
		$insertArray['briefseries_title_img'] = $imageFile;
		$insertArray['briefseries_summary_path'] = $summerylFilePath;
		$insertArray['briefseries_ppt_path'] = $pptFilePath;
		$insertArray['briefseries_date'] = $briefseriesDate;
		$insertArray['is_premium'] = $is_premium;
		$briefSeriesObj->addBriefSeries($insertArray);
		$successMsg = "Brief series added successfully.";
	} catch (Exception $ex) {
		$errorMsg = $ex->getMessage();
	}

	$insertArray = array();
	if($errorMsg == '') {
		header('Location:listBriefSeries.php');
	} 
		
}
?>

<script type="text/javascript" src="../public/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../public/plugins/ckeditor/ckfinder.js"></script>
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Add Brief Series</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slide images" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="slide images" /></th>
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
								<option value="general">General</option>
								<option value="japanese">Japanese</option>
								<option value="oxford">Oxford Economics</option>
							</select>
						</td>
					</tr>

					<tr id="tr_briefseries_image">
						<th>Title Image:</th>
						<td><input type="file" name="imageFile" id="imageFile"
							class="file_1" /> <label for="imageFile" class="error"
							id="briefseries_title_img_error"></label></td>
					</tr>

					<tr>
						<th valign="top">Brief Series Title:</th>
						<td><input name="materials_title" type="text" id="briefseries_title"
							class="inp-form"> <label for="briefseries_title" class="error"
							id="briefseries_title_error"></label></td>
						<td></td>
					</tr>
                     <tr id="tr_briefseries_description" style="display: none">
                            <th valign="top"> Description:</th>
                            <td>
                                <textarea  name="description" id="mate_desc" cols="5" rows="5"  ></textarea>
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
							value="<?php echo date("Y-m-d");?>" readonly="readonly" /> <a
							onclick="showCalendarControl(add_briefseries.briefseries_date,'add_briefseries.txt_startDate');"><img
							src="calendar/calendar.gif" border="0" alt="calender images" /></a></td>
						<td></td>
					</tr>
					<tr>
						<th>Is Premium:</th>
						<td valign="top">
							<select name="is_premium" style="width:50px">
								<option value="Y">Y</option>
								<option value="N">N</option>
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
