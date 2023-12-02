
<?php include('header.php');?>

<?php set_time_limit(0);
ini_set('max_execution_time', 0); ?>
<?php //set_time_limit(50); ?>
<style type="text/css">
        #imgContainer
        {
            height: 100%;
            width: 100%;
            position: absolute;
        }
        #divProgressLayer
        {
            z-index: 999;
    position: fixed;
    background-color: rgba(255,255,255,0.8);
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
        }
		#divProgressLayer > img{
			position: absolute;
    top: calc(50% - 120px);
    left: calc(50% - 120px);
		}
</style>


<script language="javascript">
    $(document).ready(function() {
        $('#add_categoryr').submit(function() {
            var ret = true;
            $('#cat_error').html('');
            var cat     =   $('#category').val();            
            if(cat == ''){
                $('#cat_error').html('Please enter category.');
                ret =  false;
            }
			
			if(document.getElementById("statuOfDefaultAlert").value == 1)
			{
				document.getElementById("divProgressLayer").style.display = "block";
			}
            
             
            return ret;
     });
    });
    
	function callchangeDefaultAlert(altVal)
	{
		$('#statuOfDefaultAlert').val(1);
	}
    
</script>

<?php
$curerent_url = "http" . (($_SERVER['SERVER_PORT']==443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$subject = "http://www.google.com";
$pattern = "/(\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|])(admin)/i";
preg_match($pattern, $curerent_url, $matches);
$id = $_REQUEST['id'];
if($id == ''){
    header('Location:listcategory.php');
}

$someobj   = $catObj->getIndividualCategory2($id);
$getCat   = $someobj['post_category_name'];
$meta_title   = $someobj['category_meta_title'];
$meta_keywords = $someobj['category_meta_keywords'];
$meta_description = $someobj['category_meta_description'];
$post_category_parent_id = $someobj['post_category_parent_id'];
$category_type = $someobj['category_type'];
$category_url = $someobj['category_url'];
$category_link = $someobj['category_link'];
$alert_mail = $someobj['email_alert'];
$default_alert_mail = $someobj['default_email_alert'];


$errorMsg = '';
 $insertArray = array();
  if(isset($_POST['categoryAdd'])){
      
	if($_POST['categoryAdd']){
		
                               
                $category   = trim($_POST['category']);
                $meta_title = $_POST['meta_title'];
                $meta_keywords = $_POST['meta_keywords'];
                $meta_desc = $_POST['meta_description'];
                $category   = cleanInputField($category);
                $get_category_type = $_POST['category_type'];
                $get_category_link = $_POST['category_link'];
				$email_alert = $_POST['email_alert'];   
                $default_email_alert = $_POST['default_email_alert'];
                /*
				$get_title = str_replace(array(' ',	"'",':','/','\\'), '-', $category);
				$get_title = str_replace(array(',','?','(',')',), '', $get_title);
				$get_title = str_replace(array('%',), 'per', $get_title);
				$get_title = str_replace(array('&',), 'and', $get_title);
				$get_title = trim(strtolower($get_title),'-');
				$get_category_type = $_POST['category_type'];
				$get_category_link = $_POST['category_link'];
				*/
				//echo $get_title;
				//echo '<br><br>';
                $get_title = $_POST['category_url'];
				$key__ = md5($get_title);
                			
		if($category == ''){
			$errorMsg ='Please enter Categories<br/>';
		}
         else{           
                  try 
				  {  
				        
				          $catTd = $_REQUEST['id'];
						  if($_POST['statuOfDefaultAlert']!= "")
						  {
							  
							  if($_POST['default_email_alert']=="N")
							  {
								  $want_user_list = $catObj->selectInDefaultEmailUserId($id);
								  foreach($want_user_list as $key=>$values)
								  {
									 
									  
									  $sdsss = $values[0];
									  $userId = $values[1];
									  $arrtoCate = explode(",",$sdsss);
									  
									  
										   $key = array_search($catTd,$arrtoCate);
										   unset($arrtoCate[$key]);
										   
										   $ddfccv = implode(",",$arrtoCate);
										   
										  $catObj->updteDefaultAlert($userId,$ddfccv);
										   
								   }
							  }
							  
							  if($_POST['default_email_alert']=="Y")
							  {
								  $want_user_list = $catObj->selectOutDefaultEmailUserId($id);
								  foreach($want_user_list as $key=>$values)
								  {
									 
									  
									  $sdsss = $values[0];
									  $userId = $values[1];
									  $arrtoCate = explode(",",$sdsss);
									  
										   array_push($arrtoCate,$catTd);
										   
										   $ddfccv = implode(",",$arrtoCate);
										   
										  $catObj->updteDefaultAlert($userId,$ddfccv);
										   
								   }
							  }	 
							  
							  
							  
						  }
						 
		        	$catObj->updteCategories2($id,$category, $meta_title, $meta_keywords, $meta_desc,$get_title,$key__,$post_category_parent_id,$get_category_type,$get_category_link,$email_alert,$default_email_alert);
					
					
					
                  } catch (Exception $ex) {
                  	$errorMsg = $ex->getMessage();
                  }
                  if($errorMsg != '') {
                  	echo $errorMsg;
                  } else {
						$successMsg = "Category added successfully.";
                        $insertArray = array(); 
                        echo $successMsg;
                        header('Location:listcategory.php');
                  }
		}	
		
		
	}
}
?>

<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">
 <div id="divProgressLayer" style="display: none;">
	  <img src="../images/loader.gif" />
    </div>


<div id="page-heading"><h1>Edit Category</h1></div>


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
                 <form action="" name="add_categoryr" id="add_categoryr" method="post">
				   <input type="hidden" name="statuOfDefaultAlert" id = "statuOfDefaultAlert" value=""/>
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                    <tr>
                            <th valign="top"> Category Name:</th>
                            <td>
                                <input type="text" name="category" id="category" value="<?php echo $getCat?>" class="inp-form" />
                                <label for="category" class="error" id="cat_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top"> Type (Content Type) :</th>
                            <td>
                                <select name="category_type" id="category_type"  class="styledselect_form_1" onchange="JmaAdmin.AddCategory.showHideLinkUrlEntry(this)">
                                	<option value="P" <?php echo $category_type == 'P' ? 'selected' : ''?>>Page</option>
                                	<option value="N" <?php echo $category_type == 'N' ? 'selected' : ''?>>News</option>
                                	<option value="M" <?php echo $category_type == 'M' ? 'selected' : ''?>>Materials</option>
                                	<option value="L" <?php echo $category_type == 'L' ? 'selected' : ''?>>Link</option>
                                </select>
                            </td>
                            <td></td>
                    </tr>   
                   <tr id="Tr_placeholder-category_url">
                            <th valign="top"> Category URL:</th>
                            <td>
                                <input type="text" name="category_url" id="category_url" class="inp-form2" value="<?php echo $category_url;?>" />
                                <br><font color="#ff0000">Note: Existing link won't work if changed.</font>
                                <label for="category_url" class="error" id="category_url_error"></label>
                            </td>
                            <td></td>
                    </tr>    
                    <tr id="Tr_placeholder-link_url" style="display:<?php echo $category_type == 'L' ? '' : 'none' ;?>">
                            <th valign="top"> Link URL:</th>
                            <td>
                            <span style="font-size:14px;font-weight:bold"><?php echo isset($matches[1]) ? $matches[1] : '';?></span>
                                <input type="text" name="category_link" id="category_link" class="inp-form" value="<?php echo $category_link; ?>" /><br>Note: Give relative path (eg. materials/category/presentation-materials)
                                <label for="category_link" class="error" id="cat_error"></label>
                            </td>
                            <td></td>
                    </tr>                 
                    <tr>
                            <th valign="top">Meta Title:</th>
                            <td>
                                 <input type="text" name="meta_title" id="meta_title" class="inp-form" maxlength="250" value="<?php echo $meta_title;?>" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Meta Keywords:</th>
                            <td>
                                 <input type="text" name="meta_keywords" id="meta_keywords" class="inp-form2" maxlength="250" value="<?php echo $meta_keywords;?>" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Meta Description:</th>
                            <td>
                                 <input type="text" name="meta_description" id="meta_description" class="inp-form2" maxlength="1024" value="<?php echo $meta_description;?>" />
                            </td>
                            <td></td>
                    </tr>
                    
                 <tr>   
                    <th>Is this email alert?:</th>
                    <td >
                            <input type="radio" value="Y" name="email_alert" id="email_alert" onclick = "return calldefault_email_alert(this.value);"  <?php if($alert_mail == 'Y') { echo "checked"; } ?> /> Yes
							<input type="radio" value="N" name="email_alert" id="email_alert" onclick = "return calldefault_email_alert(this.value);"  <?php if($alert_mail == 'N') { echo "checked"; } ?> />  No
							
                    </td>
                    <td></td>
                </tr>
				
				<?php if($alert_mail == 'Y') { ?> 
				 <tr id="show_default_alert">
                    <th>Is this default email alert?</th>
                    <td>
                            <input type="radio" value="Y" name="default_email_alert" id="default_email_alert" <?php if($default_alert_mail == 'Y') { echo "checked"; } ?> onclick="return callchangeDefaultAlert(<?php echo $id; ?>)"/> Yes
							<input type="radio" value="N" name="default_email_alert" id="default_email_alert" <?php if($default_alert_mail == 'N') { echo "checked"; } ?> onclick="return callchangeDefaultAlert(<?php echo $id; ?>)"/> No
                    </td>
                    <td></td>
                </tr>
				<?php } else {?>
				      <tr id="show_default_alert"  style="display:none;">
						<th>Is this default email alert?</th>
						<td>
								<input type="radio" value="Y" name="default_email_alert" id="default_email_alert" <?php if($default_alert_mail == 'Y') { echo "checked"; } ?> /> Yes
								<input type="radio" value="N" name="default_email_alert" id="default_email_alert" <?php if($default_alert_mail == 'N') { echo "checked"; } ?> /> No
						</td>
						<td></td>
					</tr>
                <?php }?>   

                <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="categoryAdd" value="Submit" class="form-submit" />

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
<script type="text/javascript" language="javascript">
function calldefault_email_alert(typeVal)
	{
		if(typeVal == "Y")
		{
			$('#show_default_alert').show();
		}
		else
		{
			$('#show_default_alert').hide();
		}
		
	}
	
</script>
<?php include('footer.php');?>
