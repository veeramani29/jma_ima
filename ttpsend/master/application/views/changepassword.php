
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
                        <li class="active-bre"><a href="<?php echo base_url('dashboard');?>"> <?php echo ucfirst($this->router->fetch_method());?> </a>
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
                    }else{
                        $username=set_value('username');
                        $password='';
                        $user_email=set_value('user_email');
                        $phone_number=set_value('phone_number');
                        $address=set_value('address');
                        $access_level=set_value('access_level');
                    }
                   ?>


                <div class="sb2-2-3">
                    <div class="row">

                     <?php if($this->input->post('change')==null){ echo validation_errors('<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); } ?>
            <?php echo ($error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
             <?php echo ($success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>
  <?php if($this->input->post('change')!=null){ echo validation_errors('<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); } ?>
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4><?php echo ucfirst($this->router->fetch_method());?> </h4>
                                  
                                </div>
                                <div class="tab-inn">
                                  <?php $attributes = array('class' => 'stdform text-left', 'id' => 'change','novalidate' => 'novalidate','method' => 'post');
                    echo form_open('', $attributes); ?>
                     <input type="hidden" name="hdnpassword" id="hdnpassword" value="<?php echo $password;?>" />
                                        <div class="row">
                                            <div class="input-field col s12">

                                           <?php   
                            $new_password_data = array(
                             
                            'name'        => 'new_password',
                            'id'          => 'new_password',
                            'required'        => 'required',
                            'class'        => 'validate'
                            

                            );
                            echo form_password($new_password_data);

                            ?>

                                               
                                                <label for="new_password" class="active">Current Password<span class="error">*</span></label>
                                            </div>
                                            
                                        </div>
                                        
                                          
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
                                                <label for="password" class="active">New Password<span class="error">*</span></label>
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
                                                <label for="passconf" class="active">Confirm Password<span class="error">*</span></label>
                                            </div>
                                        </div>
                                         
                                        
                                        <div class="row">
                                            <div class="input-field col s6 text-right">
                                                <i class="waves-effect waves-light btn-large waves-input-wrapper" style=""><input value="change" name="change" type="submit" class="waves-button-input"></i>
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