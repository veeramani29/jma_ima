<?php include('header.php');?>
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
             
            return ret;
     });

    	$('#category').keyup(function(){
    		var category_name = $(this).val();
    		var url_slug = JmaAdmin.convertToSlug(category_name);
    		$('#category_url').val(url_slug);
    	});
    });
    
    
</script>

<?php
$curerent_url = "http" . (($_SERVER['SERVER_PORT']==443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$subject = "http://www.google.com";
$pattern = "/(\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|])(admin)/i";
preg_match($pattern, $curerent_url, $matches);
$errorMsg = '';
 $insertArray = array();
  if(isset($_POST['categoryAdd'])){
      
	if($_POST['categoryAdd']){		
                $mainCategory = '';
                
             //   if(isset($_POST['main_cat'])){
              //     $mainCategory =  $_POST['main_cat'];
              //  }
                
                $category   = trim($_POST['category']);

				$meta_title = $_POST['meta_title'];
				$meta_keywords = $_POST['meta_keywords'];
				$meta_description = $_POST['meta_description'];
                
                
                $category   = cleanInputField($category);
                
				/*$get_title = str_replace(array(' ',	"'",':','/','\\'), '-', $category);
				$get_title = str_replace(array(',','?','(',')',), '', $get_title);
				$get_title = str_replace(array('%',), 'per', $get_title);
				$get_title = str_replace(array('&',), 'and', $get_title);
				$get_title = trim(strtolower($get_title),'-');
				*/
				//echo $get_title;
				//echo '<br><br>';
				$get_title = $_POST['category_url'];
				$key = md5($get_title);
                
                $insertArray['post_category_name']       = $category;

                $insertArray['category_meta_title']        = $meta_title;
                $insertArray['category_meta_keywords']        = $meta_keywords;
                $insertArray['category_meta_description']        = $meta_description;
                $insertArray['category_url'] = $get_title;
				$insertArray['category_url_key'] = $key;

            //    if($mainCategory == ''){
             //   $insertArray['post_category_parent_id']  = 0;
             //   }
            //    else{
            //        $insertArray['post_category_parent_id']  = $mainCategory;
            //    }
            	 $insertArray['post_category_parent_id'] = $_POST['parent_category_id'];
            	 $insertArray['category_type'] = $_POST['category_type'];       	 
                 $insertArray['post_category_status']  = 'Y';
                 $insertArray['category_link'] = $insertArray['category_type'] == 'L' ? trim($_POST['category_link'],'/') : '';
                                        
		if($category == ''){
			$errorMsg ='Please enter Categories<br/>';
		}
                 else{           
                  try {  
		        	$catObj->addCategories($insertArray);
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


<div id="page-heading"><h1>Add Category</h1></div>


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
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                    <tr>
                            <th valign="top"> Main Categories:</th>
                            <td>
                                <?php  $getCats = $catObj->getAllCategories();?>
                                    
                                <select name="main_cat" id="main_cat"  class="styledselect_form_1" onchange="JmaAdmin.createSubcategoryDropdown('main_cat',true,'addCategory','Dv_select_subcategory_0');">
                                    <option value="">Select Category</option>
                                  <?php  
                                    if(count($getCats)>0){
                                         for($i=0;$i<count($getCats);$i++){
                                             $mainCatId   = $getCats[$i]['mainCatId'];
                                             $mainCatName =  $getCats[$i]['mainCatName'];
                                         ?>
                                            <option value="<?php echo $getCats[$i]['mainCatId'] ?>"><?php echo $getCats[$i]['mainCatName'] ?></option>
                                            <?php
                                            }
                                    }
                                    ?>
                                    
		           </select>
                                 <label for="mainCat" class="error" id="mainCat_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                    <tr>
                    	<th valign="top"> Sub-categories </th>
                    	    <td id="TD_select_subcategory">
                            	<div id="Dv_select_subcategory_0"></div>
                            </td>
                    		 <td><input type="hidden" name="parent_category_id" id="parent_category_id" value="0"></td>
                    </tr>
                     <tr>
                            <th valign="top"> Type (Content Type) :</th>
                            <td>
                                <select name="category_type" id="category_type"  class="styledselect_form_1" onchange="JmaAdmin.AddCategory.showHideLinkUrlEntry(this)">
                                	<option value="P" selected>Page</option>
                                	<option value="N">News</option>
                                	<option value="M">Materials</option>
                                	<option value="L">Link</option>
                                </select>
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top"> Category Name:</th>
                            <td>
                                <input type="text" name="category" id="category" class="inp-form" />
                                <label for="category" class="error" id="cat_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    <tr id="Tr_placeholder-category_url">
                            <th valign="top"> Category URL:</th>
                            <td>
                                <input type="text" name="category_url" id="category_url" class="inp-form2" />
                                <br><font color="#ff0000">Note: Automatically generated. Change only if required.</font>
                                <label for="category_url" class="error" id="category_url_error"></label>
                            </td>
                            <td></td>
                    </tr>                    
                    <tr id="Tr_placeholder-link_url" style="display:none">
                            <th valign="top"> Link URL:</th>
                            <td>
                            <span style="font-size:14px;font-weight:bold"><?php echo isset($matches[1]) ? $matches[1] : '';?></span>
                                <input type="text" name="category_link" id="category_link" class="inp-form" /><br>Note: Give relative path (eg. materials/category/presentation-materials)
                                <label for="category_link" class="error" id="cat_error"></label>
                            </td>
                            <td></td>
                    </tr>                    
                    <tr>
                            <th valign="top">Meta Title:</th>
                            <td>
                                 <input type="text" name="meta_title" id="meta_title" class="inp-form2" maxlength="250" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Meta Keywords:</th>
                            <td>
                                 <input type="text" name="meta_keywords" id="meta_keywords" class="inp-form2" maxlength="250" />
                            </td>
                            <td></td>
                    </tr>
                    <tr>
                            <th valign="top">Meta Description:</th>
                            <td>
                                 <input type="text" name="meta_description" id="meta_description" class="inp-form2" maxlength="1024" />
                            </td>
                            <td></td>
                    </tr>

                   

                <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="categoryAdd" class="form-submit" />

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