

<div class="container-fluid sb2">
        <div class="row">
        <!--leftmenu-->
   <?php $this->load->view('a');?>
   <!--leftmenu-->
            
            <div class="sb2-2">
                <div class="sb2-2-2">
                    <ul>
                        <li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li ><a href="<?php echo base_url('tourpack');?>">   Packages</a>
                        </li>
                        <li class="active-bre"><a href="#"> <?php echo ($this->uri->segment(3)!='')?'Edit':'Add'; ?>  Package</a>
                        </li>
                    </ul>
                </div>


                <?php

                    if($this->uri->segment(3)!='') { 
                        $txtTitle=$pack_details->title;
                        $Descriptions=$pack_details->pack_desc;
                        $Author_Name=$pack_details->author_name;
                        $txtOffer=$pack_details->offer;
                        $txtLocation=$pack_details->location;
                        $access_level=$pack_details->category;
                          $pack_details_small_image=$pack_details->small_image;
                           $Inclusions=$pack_details->inclusions;
                          $Exclusions=$pack_details->exclusions;
                    }else{
                        $txtTitle=set_value('txtTitle');
                         $Descriptions=set_value('Descriptions');
                       $txtOffer=set_value('txtOffer');
                        $txtLocation=set_value('txtLocation');
                        $access_level=set_value('Category');
                         $Author_Name=set_value('Author_Name');
                         $Inclusions=set_value('Inclusions');
                          $Exclusions=set_value('Exclusions');
                        $pack_details_small_image=set_value('hdnoldfile');
                        
                          
                    }
                   ?>


                <div class="sb2-2-3">
                    <div class="row">

                          <?php   echo validation_errors('<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); 
      echo ($error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
             <?php echo ($success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>

                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4><?php echo ($this->uri->segment(3)!='')?'Edit':'Add'; ?>  Package</h4>
                                  
                                </div>
                                <div class="tab-inn">
                                  <?php $attributes = array('class' => 'stdform text-left', 'id' => 'form1','novalidate' => 'novalidate','method' => 'post','enctype' => 'multipart/form-data');
                    echo form_open('', $attributes); ?>

                      <input type="hidden" name="hdnoldfile" value="<?php echo $pack_details_small_image;?>" >  
     
                                        <div class="row">
                                            <div class="input-field col s12">

                                             <?php   
                            $Title_data = array(
                            'name'        => 'txtTitle',
                            'id'          => 'txtTitle',
                            'value'       => $txtTitle,
                            'required'        => 'required',
                            'class'        => 'validate'
                           

                            );
                            echo form_input($Title_data);

                            ?>

                                               
                                                <label for="txtTitle" class="active">Package Name<span class="error">*</span></label>
                                            </div>
                                              </div>
                                                <div class="row">
                                            <div class="input-field col s12">
                                             <?php   
                            $Descriptions_data = array(
                              //  'type'   => 'email',
                            'name'        => 'Descriptions',
                            'id'          => 'Descriptions',
                            'value'       => $Descriptions,
                            'required'        => 'required',
                            'class'        => 'materialize-textarea'
                          

                            );
                            echo form_textarea($Descriptions_data);

                            ?>

                                                
                                                <label for="Descriptions" class="active">Package Descriptions:<span class="error">*</span></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                               <?php   
                            $txtOffer_data = array(
                             
                            'name'        => 'txtOffer',
                            'id'          => 'txtOffer',
                            'value'       => $txtOffer,
                            'required'        => 'required',
                            'class'        => 'validate'
                           

                            );
                            echo form_input($txtOffer_data);

                            ?>
                                                <label for="txtOffer" class="active">Offer <span class="error">*</span></label>
                                            </div>

                                             <div class="input-field col s6">
                                               <?php   
                            $txtLocation_data = array(
                             
                            'name'        => 'txtLocation',
                            'id'          => 'txtLocation',
                            'value'       => $txtLocation,
                            'required'        => 'required',
                            'class'        => 'validate'
                           

                            );
                            echo form_input($txtLocation_data);

                            ?>
                                                <label for="txtLocation" class="active">Location <span class="error">*</span></label>
                                            </div>

                                            </div>
                                             <div class="row">
                                            <div class="input-field col s6">
                                                <div class="select-wrapper">
                                         <select class="initialized" name="Category" id="Category" required>
                                <option value="" >Select Category</option>

                                <?php foreach ($cats['results'] as $catskey => $catsvalue) { ?>
                                 <option <?php  if($access_level=='ACC-1'){ echo "selected"; } ?> value="<?php echo $catsvalue['category_name'];?>"><?php echo $catsvalue['category_name'];?></option>
                               <?php } ?>
                                   
                                      
                               
                            </select></div>
                                      
                                            
                                            </div>
                                      
                                            <div class="input-field col s6">
                                              <?php   
                            $address_data = array(

                            'name'        => 'Author_Name',
                            'id'          => 'Author_Name',
                            'value'       => $Author_Name,
                            'required'        => 'required',
                            'class'        => 'validate'
                           
                     

                            );
                            echo form_input($address_data);

                            ?>
                                                <label for="Author_Name" class="active">Author Name <span class="error">*</span></label>
                                            </div>
                                           
                                        </div>


                                           <div class="row">
                                            <div class="input-field col s12">
                                             <?php   
                            $Exclusions_data = array(
                              //  'type'   => 'email',
                            'name'        => 'Exclusions',
                            'id'          => 'Exclusions',
                            'value'       => $Exclusions,
                            'required'        => 'required',
                            'class'        => 'materialize-textarea'
                          

                            );
                            echo form_textarea($Exclusions_data);

                            ?>

                                                
                                                <label for="Descriptions" class="active">Exclusions:<span class="error">*</span></label>
                                            </div>
                                        </div>


                                           <div class="row">
                                            <div class="input-field col s12">
                                             <?php   
                            $Inclusions_data = array(
                              //  'type'   => 'email',
                            'name'        => 'Inclusions',
                            'id'          => 'Inclusions',
                            'value'       => $Inclusions,
                            'required'        => 'required',
                            'class'        => 'materialize-textarea'
                          

                            );
                            echo form_textarea($Inclusions_data);

                            ?>

                                                
                                                <label for="Descriptions" class="active">Inclusions:<span class="error">*</span></label>
                                            </div>
                                        </div>


                                        <div class="row">
                                    <div class="input-field col s12">
                                        <div class="file-field">
                                            <div class="btn">
                                                <span>Samll Image</span>
                                                <input  type="file" name="file" >
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input <?php if($this->uri->segment(3)==''){  ?> data-rule-required='true' required <?php }?> class="file-path validate" type="text" placeholder="Upload Logo">
                                            </div>
                                        </div>
                                    </div>
                                   
 

                                     <?php if($this->uri->segment(3)!=''){ ?>
              <div class='form-group'>
                          <label class='control-label col-sm-3' for='validation_image'>Samll Image </label>
                          <div class='col-sm-4 controls'>
                           <img width="100px" height="100px" src="<?php echo base_url().PACKAGE_SMLIMG.$pack_details->small_image;?>"/>
                          </div>
                        </div>
              
              <?php } ?>

                                    <div class="input-field col s12">
                                        <div class="file-field">
                                            <div class="btn">
                                                <span>Banner Images</span>
                                                <input type="file" name='bannerfile[]' multiple="multiple" >
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input <?php if($this->uri->segment(3)==''){  ?> data-rule-required='true' required <?php }?> class="file-path validate" type="text" placeholder="Upload Banner">
                                            </div>
                                             <small>Please Press Ctrl to select multiple images</small>
                          <br>
                          <small class="text-green">Please upload (1600x450 px)greter than or equal images</small>
                                        </div>
                                    </div>


                                    <?php if($this->uri->segment(3)!=''){  ?>
              <div class='form-group'>
                          <label class='control-label col-sm-3' for='validation_image'>Banner Images </label>
                         
                        </div>
              
                <div class='row'>
                   <?php  foreach($pack_images as $offerimg){ ?>
                          <div class='col-sm-2'>
                           <img width="100px" height="100px" src="<?php echo base_url().PACKAGE_LRGIMG.$offerimg->image;?>"/>
                           <a style="color:#FFF;background:red;" href="<?php echo base_url(); ?>tourpack/delete_tourpack_img/<?=$offerimg->id."/".$this->uri->segment(3);?>">Delete</a>
                          </div>
                          <?php } ?>
                        </div> 
              <?php }  ?>

                                </div>

                                        <div class="row">
                                            <div class="input-field col s6 text-right">
                                                <i class="waves-effect waves-light btn-large waves-input-wrapper" style=""><input name="offersub" value="<?php echo ($this->uri->segment(3)!='')?'Edit':'Add'; ?>" type="submit" class="waves-button-input"></i>
                                            </div>
                                             <div class="input-field col s6">
                                           <i class="waves-effect waves-light btn-large waves-input-wrapper" style=""> <a  href="<?php echo base_url('tourpack');?>"  class="btn btn-success"  />Cancel</a></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
          
    
       
        


         
            
    

