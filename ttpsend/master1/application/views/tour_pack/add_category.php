
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
                        <li class="active-bre"><a href="<?php echo base_url('tourpack/categories');?>"> Categories</a>
                        </li>
                        <li class="active-bre"><a href="#"> <?php echo ($this->uri->segment(3)!='')?'Edit':'Add'; ?> Category</a>
                        </li>
                    </ul>
                </div>


                <?php

                    if($this->uri->segment(3)!='') { 
                        $category_name=$edit_cats['category_name'];
                        
                    }else{
                        $category_name=set_value('category_name');
                       
                    }
                   ?>


                <div class="sb2-2-3">
                    <div class="row">

                     <?php echo validation_errors('<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); 
            echo ($error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
             <?php echo ($success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>
 
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4><?php echo ($this->uri->segment(3)!='')?'Edit':'Add'; ?> Category </h4>
                                  
                                </div>
                                <div class="tab-inn">
                                  <?php $attributes = array('class' => 'stdform text-left', 'id' => 'cat','novalidate' => 'novalidate','method' => 'post');
                    echo form_open('', $attributes); ?>
                    
                                        <div class="row">
                                            <div class="input-field col s12">

                                           <?php   
                            $new_password_data = array(
                             
                            'name'        => 'category_name',
                            'id'          => 'category_name',
                            'required'        => 'required',
                            'class'        => 'validate',
                             'value'       => $category_name

                            );
                            echo form_input($new_password_data);

                            ?>

                                               
                                                <label for="category_name" class="active">Category name<span class="error">*</span></label>
                                            </div>
                                            
                                        </div>
                                        
                                          
                                        
                                        
                                        <div class="row">
                                            <div class="input-field col s6 text-right">
                                                <i class="waves-effect waves-light btn-large waves-input-wrapper" style=""><input value="<?php echo ($this->uri->segment(3)!='')?'Edit':'Add'; ?>" name="add_cat" type="submit" class="waves-button-input"></i>
                                            </div>
                                             <div class="input-field col s6">
                                           <i class="waves-effect waves-light btn-large waves-input-wrapper" style=""> <a  href="<?php echo base_url('tourpack/categories');?>"  class="btn btn-success"  />Cancel</a></i>
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