<?php include('header.php');?>

<script language="javascript">
    $(document).ready(function() {
        $('#add_post').submit(function() {
            var ret = true;
            $('#email_code_error').html(''); $('#email_sub_error').html('');
           // $('#post_head_error').html('');$('#sub_head_error').html('');  
            var emailcode  = $('#email_code').val();
            var subj      =   $('#email_sub').val();  
			var vari      =   $('#email_vari').val();  
            
            if(emailcode == ''){
                $('#email_code_error').html('Please enter mail code.');
                ret =  false;
            }
            
             if(subj == ''){
                $('#email_sub_error').html('Please enter mail subject.');
                ret =  false;
            }
          
            
            var editorcontent = CKEDITOR.instances['mail_message'].getData().replace(/<[^>]*>/gi, '');
             
            if(editorcontent.length){}
            else{
            $('#mail_message_error').html('Please enter message');
            ret =  false;
            }
              if(vari == ''){
                $('#varia_error').html('Please enter mail variable.');
                ret =  false;
            }
			 
            
            return ret;
     });

        //Slug creation
        $('#post_title').keyup(function(){
            var category_name = $(this).val();
            var url_slug = JmaAdmin.convertToSlug(category_name);
            $('#post_url').val(url_slug);
        });
    });
    
   

</script>

<?php
$errorMsg = '';
 $insertArray = array();
 
 $usersList =  $userObj->getUserList();

  if(isset($_POST['postAdd'])){
               
                $code   = trim(addslashes($_POST['email_code']));
                $subj  = trim(addslashes($_POST['email_sub']));
                $message  = trim(addslashes($_POST['mail_message']));
                $varia   = trim(addslashes($_POST['email_vari']));
				
                $insertArray['email_templates_code'] = stripslashes($code);
                $insertArray['email_templates_subject'] = stripslashes($subj);
                $insertArray['email_templates_message'] = $message;
                $insertArray['email_templates_variable'] = trim(stripslashes($varia));

                $insertArray = cleanInputArray($insertArray);
                
                if($code == '' ||  $subj == '' || $message == '' || $varia == ''){
                    $errorMsg ='Please enter all mandatory fields<br/>';              
                }
                 else{

                    try{
                        $postId = $postObj->addmailTemplate($insertArray);
                       
                        if($postId > 1){
                            $successMsg = "New mail template added successfully.";
                            $insertArray = array();
                            echo $successMsg;
                            header('Location:listEmail.php');
                        }
                        else{
                            $errorMsg ="Error. Couldn't create post";
                       }
                    } catch (Exception $ex) {
                        $errorMsg = $ex->getMessage();
                    }
                if($errorMsg != '') {
                    echo $errorMsg;
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


<div id="page-heading"><h1>Add New Email Template</h1></div>


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
                 <form action="" name="add_post" id="add_post" method="post" enctype="multipart/form-data">
                     <?php if($errorMsg !='') { ?>
                <div class="error_sent_notification"><?php echo $errorMsg;?></div>
                 <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                    <tr>
                            <th valign="top">Email Code:</th>
                            <td>
                                <input type="text" name="email_code"  id="email_code" class="inp-form2" />
                                <label for="email_code" class="error" id="email_code_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Subject:</th>
                            <td>
                                <input type="text" name="email_sub" id="email_sub" class="inp-form2" />
                                <label for="email_sub" class="error" id="email_sub_error"></label>
                            </td>
                            <td></td>
                    </tr>  
                  
                     <tr>
                            <th valign="top">Message</th>
                            <td>
                                <textarea  name="mail_message" id="mail_message" cols="5" rows="8"  ></textarea>
                        <script type="text/javascript">
                           if ( typeof CKEDITOR == 'undefined' ){}
                           else{
                            var editor = CKEDITOR.replace( 'mail_message',{
                                        height:"<?php echo CKH;?>", width:"<?php echo CKW;?>"
                                        } );
                            CKFinder.SetupCKEditor( editor, '../public/plugins/ckeditor/' ) ;
                           }
                          </script>
                                <label for="message" class="error" id="mail_message_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                      <tr>
                            <th valign="top">Variable:</th>
                            <td>
                                 <textarea name="email_vari" id="email_vari" rows="" cols="" class="form-textarea"></textarea>
                                <label for="email_vari" class="error" id="varia_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                    
                 
                   
                    
                <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="postAdd" class="form-submit" />

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

<script>
    
    // add multiple select / deselect functionality
    $("#select_all").click(function () {
          $('.case').attr('checked', this.checked);
    });
    
    $("#select_all").click(function(){
 
        if($(".case").length == $(".case:checked").length) {
            $("#select_all").attr("checked", "checked");
        } else {
            $("#select_all").removeAttr("checked");
        }
 
    });
 </script>
<?php include('footer.php');?>