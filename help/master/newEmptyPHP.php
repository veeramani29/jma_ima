 <?php 
                                                  for($k=0;$k<count($getSubSubCats);$k++){
                                                       $subSubCatId   = $getSubSubCats[$k]['post_category_id']; 
                                                       $subSubCatName = $getSubSubCats[$k]['post_category_name']; 
                                                  ?>
                                                       <option value="<?php echo $subSubCatId ?>"><?php echo $subSubCatName;?></option>
                                                  
                                                 <?
                                                 }
                                                 
                                                 
                                                 
                                                 
 <tr>
                            <th valign="top">Categories</th>
                            <td>
                                <?php  $getCats = $catObj->getAllCategories();?>
                                    
                                <select name="main_cat" id="main_cat"  class="styledselect_form_1">
                                    <option value="">Select Category</option>
                                  <?php  
                                    if(count($getCats)>0){
                                         for($i=0;$i<count($getCats);$i++){
                                             $mainCatSelect = '';
                                             $subCatSelect = '';
                                             if($getCats[$i]['mainCatId'] == $insertArray['post_category_id'])
                                             {
                                                 $mainCatSelect = 'selected="selected"';
                                             }
                                            
                                         ?>
                                            <option <?php echo $mainCatSelect?> value="<?php echo $getCats[$i]['mainCatId'] ?>"><?php echo $getCats[$i]['mainCatName'] ?></option>
                                            <?php
                                            if($getCats[$i]['subCatId'] != ''){ 
                                                 if($getCats[$i]['subCatId'] == $insertArray['post_category_id'])
                                                 {
                                                 $subCatSelect = 'selected="selected"';
                                                 }
                                             ?>
                                             <option <?php echo $subCatSelect?> value="<?php echo $getCats[$i]['subCatId'] ?>"><?php echo $getCats[$i]['subCatName'] ?></option>
                                            <?php
                                              }
                                            
                                            }
                                    }
                                    ?>
                                    
		           </select>
                                 <label for="mainCat" class="error" id="mainCat_error"></label>
                            </td>
                            <td></td>
                    </tr>
                                                                     