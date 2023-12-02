<style>
<?php include("calendar/CalendarControl.php");?>
</style>
<script src="calendar/CalendarControl.js" language="javascript"></script>
<?php include('header.php');?>
<script language="javascript">
    $(document).ready(function() {
        $('#add_event').submit(function() {
            var ret = true;
            $('#event_txt_error').html('');$('#event_link_error').html('');$('#img_error').html('');$('#event_date_error').html('');$('#button_txt_error').html('');$('#title_error').html('');
            var eTxt     =   $('#event_txt').val();
            var eLink    =   $('#event_link').val();
            var img      =   $('#imageFile').val(); 
            var edate    =   $('#event_date').val();
            var btxt     =   $('#button_txt').val();
            var etitle   =   $('#event_title').val();
            //var sort      =   $('#media_sort').val(); 
            if(etitle != '' && img != ''){
                $('#title_error').html('Please enter either image or title.');
                ret =  false;
            } 
            else if(img != '' && checkImg(img) == false){
                   $('#img_error').html('Please upload only image.');
                  ret =  false;
            }

            if (edate == '') {
              $('#event_date_error').html('Please enter date');
              ret = false;
            }
            
            if(eLink == ''){
                $('#event_link_error').html('Please enter link');
                ret =  false;
            }

            if(btxt == ''){
              $('#button_txt_error').html('Please enter the button text');
              ret = false;
            }
     /* if(isNaN(parseInt(sort)))
      {
                $('#media_sort_error').html('Please enter number');
        ret = false;
      } */
            
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
  if(isset($_POST['addEvent'])){
      
  if($_POST['addEvent']){
            
            $doc_path = '';
    
            $eventTxt  = trim($_POST['event_txt']);
            $eventTxt  = cleanInputField($eventTxt);
            
            $eventLink  = trim($_POST['event_link']);
            $eventLink  = cleanInputField($eventLink);

            $eventTitle = trim($_POST['event_title']);
            $eventTitle = cleanInputField($eventTitle);
            
      $eventdate=trim($_POST['event_date']); 
      $eventdate=cleanInputField($eventdate);

      $buttontxt=trim($_POST['button_txt']);
      $buttontxt=cleanInputField($buttontxt);

      $startDate=trim($_POST['startDate']);
      $startDate=cleanInputField($startDate);

      $modifyDate=trim($_POST['modifyDate']);
      $modifyDate=cleanInputField($modifyDate);
    
    
     /*$mediasort = trim($_POST['media_sort']);  */
      if(isset($_POST['event_status']))
      $eventstatus = 1;
      else
      $eventstatus = 0;

    

     if(isset($_POST['premium_user']))
      $premium_user = 'Yes';
      else
      $premium_user = 'No';
      
            if($eventTitle != '' &&  $_FILES['imageFile']['name'] != ''){
                $errorMsg ='Please enter either image or title<br/>';
            }
            if($eventLink == ''){
                 $errorMsg = $errorMsg .'Please enter event link.<br/>';
            }
            if ($eventdate == '') {
              $errorMsg = $errorMsg .'Please enter date.<br/>';
            }

            if ($buttontxt =='') {
              $errorMsg = $errorMsg .'Please enter button text.<br/>';
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
                        
           
                                $insertArray['event_value_text']   = $eventTxt;
                                $insertArray['event_value_img']    = $doc_path;
                                $insertArray['event_link']         = $eventLink;
                                 $insertArray['event_date']        = $eventdate;
                                 $insertArray['event_title']  =$eventTitle;
                                 $insertArray['button_txt']        = $buttontxt;
                                 $insertArray['premium_user']  =$premium_user;
                                $insertArray['status']             = $eventstatus;
                                $insertArray['date']               = $startDate;
                                $insertArray['modified_date']      = $modifyDate;
                                $mediaObj->addEvent($insertArray);
                                $successMsg = "Event added successfully.";
                                $insertArray = array(); 
                                echo $successMsg;
                                header('Location:listEvent.php');
           
    
  }
}
?>


<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Add Event</h1></div>


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
                 <form action="" name="add_event" enctype="multipart/form-data" id="add_event" method="post">
                     <?php if($errorMsg !='') { ?>
        <div class="error_sent_notification"><?php echo $errorMsg;?></div>
               <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                      <tr>
                            <th valign="top">Event Date:</th>
                            <td>
                                <input type="text" name="event_date" id="event_date" class="form-text"/>
                                <label for="event_date" class="error" id="event_date_error"></label>                            </td>
                            <td></td>
                    </tr>
                                                   
                            <tr>
                            <th>Logo Image:</th>
                            <td>
                                <input type="file" name="imageFile" id="imageFile" class="file_1" />
                                <label for="event_txt_error" class="error" id="img_error"></label>                            </td>
                            </tr>

                            <tr>
                            <th>Title</th>
                            <td>
                                <input type="text" name="event_title" id="event_title" class="form-text" />
                                <label for="event_title" class="error" id="title_error"></label>                            </td>
                            </tr>

                    <tr>
                            <th valign="top">Sub Title:</th>
                            <td>
                                <textarea name="event_txt" id="event_txt" rows="" cols="" class="form-textarea"></textarea>
                                <label for="event_txt" class="error" id="event_txt_error"></label>                            </td>
                            <td></td>
                    </tr>
                    
                                  <tr>
                            <th valign="top">Event Link:</th>
                            <td>
                                <input type="text" name="event_link" id="event_link" class="form-text"/>
                                <label for="event_link" class="error" id="event_link_error"></label>                            </td>
                            <td></td>
                    </tr>
                    <!-- <tr>
                            <th valign="top">Button Text:</th>
                            <td>
                                <input type="text" name="button_txt" id="button_txt" class="form-text"/>
                                <label for="button_txt" class="error" id="button_txt_error"></label>                            </td>
                            <td></td>
                    </tr> -->




                    <tr>
                            <th valign="top">Is Premium? :</th>
                            <td>
                                <input type="checkbox" value= 'Yes' name="premium_user" id="premium_user" rows="" cols="" class="form-input" />
                                <label for="premium_user" class="error" id="event_premium"></label>                            </td>
                            <td></td>
                    </tr>

                     <tr>
                            <th valign="top">Status:</th>
                            <td>
                                <input type="checkbox" name="event_status" id="event_status" rows="" cols="" class="form-input" />
                                <label for="event_status" class="error" id="event_status_error"></label>                            </td>
                            <td></td>
                    </tr>

                     <tr>
                        <th>Date: </th>
                        <td valign="top">
            <input type="hidden" name="txt_startDate" id="txt_startDate" value="" />
                      <input name="startDate" type="text"  class="textBox_style2" id="startDate" value="<?php echo date("Y-m-d");?>" readonly="readonly" />
                      <a onclick="showCalendarControl(add_event.startDate,'add_event.txt_startDate');"><img src="calendar/calendar.gif"  border="0" alt="calender images" /></a> 
            </td>
                        <td></td>
                      </tr>

                       <tr>
                        <th> Modified Date: </th>
                        <td valign="top">
            <input type="hidden" name="txt_modifyDate" id="txt_modifyDate" value="" />
                      <input name="modifyDate" type="text"  class="textBox_style2" id="modifyDate" value="<?php echo date("Y-m-d");?>" readonly="readonly" />
                      <a onclick="showCalendarControl(add_event.modifyDate,'add_event.txt_modifyDate');"><img src="calendar/calendar.gif"  border="0" alt="calender images" /></a> 
            </td>
                        <td></td>
                      </tr>
                    <!--<tr>
                            <th valign="top">Sort Order:</th>
                            <td>
                                <input type="text" name="media_sort" id="media_sort" rows="" cols="" class="form-input" />
                                <label for="media_sort" class="error" id="media_sort_error"></label>                            </td>
                            <td></td>
                    </tr> -->
                      <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="addEvent" class="form-submit" />                    </td>
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
