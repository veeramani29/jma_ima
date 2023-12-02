

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
                        <li class="active-bre"><a href="<?php echo base_url('dashboard');?>"> <?php echo ucfirst($this->router->fetch_method());?> Profile</a>
                        </li>
                    </ul>
                </div>


                <?php

                    if($this->router->fetch_method()=='edit') { 
                        $username=$edit_admins['username'];
                        $password=$edit_admins['password'];
                        $user_email=$edit_admins['user_email'];
                        $phone_number=$edit_admins['phone_number'];
                        $address=$edit_admins['address'];
                        $access_level=$edit_admins['access_level'];
                          $hdnoldfile=$edit_admins['logo'];
                    }else{
                        $username=set_value('username');
                        $password='';
                        $user_email=set_value('user_email');
                        $phone_number=set_value('phone_number');
                        $address=set_value('address');
                        $access_level=set_value('access_level');
                         $hdnoldfile=set_value('hdnoldfile');

                        
                    }
                   ?>


                <div class="sb2-2-3">
                    <div class="row">

                     <?php if($this->input->post('change')==null){ echo validation_errors('<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); } ?>
            <?php echo ($error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
             <?php echo ($success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>

                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4><?php echo ucfirst($this->router->fetch_method());?> Profile</h4>
                                  
                                </div>
                                <div class="tab-inn">
                                  <?php $attributes = array('class' => 'stdform text-left', 'id' => 'form1','novalidate' => 'novalidate','method' => 'post','enctype' => 'multipart/form-data');
                    echo form_open('', $attributes);  ?>

 <?php if($this->uri->segment(3)!=''){ ?>
                      <input type="hidden" name="hdnoldfile" value="<?php echo $hdnoldfile;?>" >  
                   <?php      }
                   ?>
                                        <div class="row">
                                            <div class="input-field col s6">

                                             <?php   
                            $username_data = array(
                            'name'        => 'username',
                            'id'          => 'username',
                            'value'       => $username,
                            'required'        => 'required',
                            'class'        => 'validate'
                           

                            );
                            echo form_input($username_data);

                            ?>

                                               
                                                <label for="website" class="active">Username<span class="error">*</span></label>
                                            </div>
                                            <div class="input-field col s6">
                                             <?php   
                            $user_email_data = array(
                                'type'   => 'email',
                            'name'        => 'user_email',
                            'id'          => 'user_email',
                            'value'       => $user_email,
                            'required'        => 'required',
                            'class'        => 'validate'
                          

                            );
                            echo form_input($user_email_data);

                            ?>

                                                
                                                <label for="user_email" class="active">Email<span class="error">*</span></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                               <?php   
                            $phone_number_data = array(
                             
                            'name'        => 'phone_number',
                            'id'          => 'phone_number',
                            'value'       => $phone_number,
                            'required'        => 'required',
                            'class'        => 'validate'
                           

                            );
                            echo form_input($phone_number_data);

                            ?>
                                                <label for="phone_number" class="active">Phone Number <span class="error">*</span></label>
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="select-wrapper">
                                         <select class="initialized" name="access_level" id="access_level" required>
                                <option value="" disabled="">Select Admin Level</option>
                                   <option <?php  if($access_level=='ACC-1'){ echo "selected"; } ?> value="ACC-1">Admin</option>
                                        <option <?php  if($access_level=='ACC-2'){ echo "selected"; } ?> value="ACC-2">Sub-Admin</option>
                                            <option value="ACC-3" <?php  if($access_level=='ACC-3'){ echo "selected"; } ?>>Marketing</option>
                               
                            </select></div>
                                      
                                            
                                            </div>
                                        </div>
                                           <?php if($this->router->fetch_method()=='add') { ?>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <?php   
                            $password_data = array(
                             
                            'name'        => 'password',
                            'id'          => 'password',
                            'required'        => 'required',
                            'class'        => 'validate'
                            

                            );
                            echo form_password($password_data);

                            ?>
                                                <label for="password" class="active">Password</label>
                                            </div>
                                            <div class="input-field col s6">
                                              
                            <?php   
                            $passconf_data = array(
                             
                            'name'        => 'passconf',
                            'id'          => 'passconf',
                            'required'        => 'required',
                            'class'        => 'validate'
                       

                            );
                            echo form_password($passconf_data);

                            ?>
                                                <label for="password1" class="active">Confirm Password</label>
                                            </div>
                                        </div>
                                          <?php } ?>
                                        <div class="row">
                                            <div class="input-field col s12">
                                              <?php   
                            $address_data = array(

                            'name'        => 'address',
                            'id'          => 'address',
                            'value'       => $address,
                            'required'        => 'required',
                            'class'        => 'validate'
                           
                     

                            );
                            echo form_input($address_data);

                            ?>
                                                <label for="email" class="active">Address</label>
                                            </div>
                                           
                                        </div>


                                          <div class="row">
                                    <div class="input-field col s12">
                                        <div class="file-field">
                                            <div class="btn">
                                                <span>Logo</span>
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
                           <img width="100px" height="100px" src="<?php echo base_url().COMPANY_LOGO.$edit_admins['logo'];?>"/>
                          </div>
                        </div>
              
              <?php } ?>

                                        <div class="row">
                                            <div class="input-field col s6 text-right">
                                                <i class="waves-effect waves-light btn-large waves-input-wrapper" style=""><input type="submit" class="waves-button-input"></i>
                                            </div>
                                             <div class="input-field col s6">
                                           <i class="waves-effect waves-light btn-large waves-input-wrapper" style=""> <a  href="<?php echo base_url('admin');?>"  class="btn btn-success"  />Cancel</a></i>
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


    
          
    
       
        


         
            
    

