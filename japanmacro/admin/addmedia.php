<style>
<?php include("calendar/CalendarControl.php");?>
</style>
<script src="calendar/CalendarControl.js" language="javascript"></script>
<?php include('header.php');?>
<script language="javascript">
    $(document).ready(function() {
        $('#add_media').submit(function() {
            var ret = true;
            $('#media_txt_error').html('');$('#media_link_error').html('');$('#img_error').html('');
            var mTxt     =   $('#media_txt').val();
            var mLink    =   $('#media_link').val();
            var img      =   $('#imageFile').val(); 
            var sort      =   $('#media_sort').val(); 
            if(mTxt == '' && img == ''){
                $('#media_txt_error').html('Please enter Text or upload an image.');
                ret =  false;
            }
            else if(img != '' && checkImg(img) == false){
                   $('#img_error').html('Please upload only image.');
                  ret =  false;
            }
            
            if(mLink == ''){
                $('#media_link_error').html('Please enter link');
                ret =  false;
            }
			if(isNaN(parseInt(sort)))
			{
                $('#media_sort_error').html('Please enter number');
				ret = false;
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
</script>

<?php
$errorMsg = '';
 $insertArray = array();
  if(isset($_POST['addMedia'])){
      
	if($_POST['addMedia']){
            
            $doc_path = '';
		
            $mediaTxt  = trim($_POST['media_txt']);
            $mediaTxt  = cleanInputField($mediaTxt);
            
            $mediaLink  = trim($_POST['media_link']);
            $mediaLink  = cleanInputField($mediaLink);
            
			$mediadate=trim($_POST['startDate']);
			$mediadate=cleanInputField($mediadate);
		
			$mediasort = trim($_POST['media_sort']);
			if(isset($_POST['media_notice']))
			$medianotice = 1;
			else
			$medianotice = 0;
			
            if($mediaTxt == '' &&  $_FILES['imageFile']['name'] == ''){
                $errorMsg ='Please enter Text or upload an image.<br/>';
            }
            if($mediaLink == ''){
                 $errorMsg = $errorMsg .'Please enter media link.<br/>';
            }
            
                    // image upload
                     if($_FILES['imageFile']['name'] != ''){                       
                            $imageFile = $_FILES['imageFile']['name'];
                            $fileSize  = $_FILES["imageFile"]["size"];
                            $ext='.';
                            $ext=  explode('.',$_FILES['imageFile']['name']);
                            $ext =  end($ext);
                            $ext = '.'.$ext;
                            $doc_time=date('dmY').date('His');
                            $doc_path=$doc_time.$ext;
                            if($ext!='.jpeg' && $ext!='.jpg' && $ext!='.gif' && $ext!='.png'){
                                    $errorMsg = 'File must be JPG, GIF or PNG';
                            }
                            else
                            {
                                move_uploaded_file($_FILES['imageFile']['tmp_name'],'../public/uploads/media/'.$doc_path);
                               
                            }
                        }
                        
           
                                $insertArray['media_value_text']          = $mediaTxt;
                                $insertArray['media_value_img']           = $doc_path;
                                $insertArray['media_link']                = $mediaLink;
								$insertArray['media_date']                =$mediadate;
								$insertArray['media_sort']                =$mediasort;
								$insertArray['media_notice']                =$medianotice;
                                $mediaObj->addMedia($insertArray);
                                $successMsg = "Chart added successfully.";
                                $insertArray = array(); 
                                echo $successMsg;
                                header('Location:listMedia.php');
           
		
	}
}
?>


<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Add Media</h1></div>


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
                 <form action="" name="add_media" enctype="multipart/form-data" id="add_media" method="post">
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                                                   
                            <tr>
                            <th>Media Image:</th>
                            <td>
                                <input type="file" name="imageFile" id="imageFile" class="file_1" />
                                <label for="media_txt_error" class="error" id="img_error"></label>                            </td>
                            </tr>

                    <tr>
                            <th valign="top">Media Text:</th>
                            <td>
                                <textarea name="media_txt" id="media_txt" rows="" cols="" class="form-textarea"></textarea>
                                <label for="media_txt" class="error" id="media_txt_error"></label>                            </td>
                            <td></td>
                    </tr>
                    
                      <tr>
                            <th valign="top">Media Link:</th>
                            <td>
                                <textarea name="media_link" id="media_link" rows="" cols="" class="form-textarea"></textarea>
                                <label for="media_link" class="error" id="media_link_error"></label>                            </td>
                            <td></td>
                    </tr>

                   

                      <tr>
                        <th>Date: </th>
                        <td valign="top">
						<input type="hidden" name="txt_startDate" id="txt_startDate" value="" />
                      <input name="startDate" type="text"  class="textBox_style2" id="startDate" value="<?php echo date("Y-m-d");?>" readonly="readonly" />
                      <a onclick="showCalendarControl(add_media.startDate,'add_media.txt_startDate');"><img src="calendar/calendar.gif"  border="0" alt="calender images" /></a> 
						</td>
                        <td></td>
                      </tr>
                      <tr>
                            <th valign="top">Notice:</th>
                            <td>
                                <input type="checkbox" name="media_notice" id="media_notice" rows="" cols="" class="form-input" />
                                <label for="media_notice" class="error" id="media_notice_error"></label>                            </td>
                            <td></td>
                    </tr>
                      <tr>
                            <th valign="top">Sort Order:</th>
                            <td>
                                <input type="text" name="media_sort" id="media_sort" rows="" cols="" class="form-input" />
                                <label for="media_sort" class="error" id="media_sort_error"></label>                            </td>
                            <td></td>
                    </tr>
                      <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="addMedia" class="form-submit" />                    </td>
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
