 <!--header-->
   <?php //$this->load->view('header');?>
   <!--header-->
     <!--leftmenu-->
   <?php $this->load->view('leftmenu');?>
   <!--leftmenu-->
 <!-- content -->
    <div id="content" class="app-content box-shadow-z0" role="main">
      
          <!--app footer-->
   <?php $this->load->view('a');?>
   <!--app footer-->
<div ui-view="" class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                  <h2><?php echo ucfirst($this->router->fetch_method());?> Profile</h2>
                    <small>By filling all form details of User, User will be shown in the list of User's.</small>
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
                           $name=$edit_admins['name'];
                            $notes=$edit_admins['notes'];
                           
                    }else{
                        $username=set_value('username');
                        $password='';
                        $user_email=set_value('user_email');
                        $phone_number=set_value('phone_number');
                        $address=set_value('address');
                        $access_level=set_value('access_level');
                         $hdnoldfile=set_value('hdnoldfile');
                         $name=set_value('name'); $notes=set_value('notes');

                       }
                   ?>

                <div class="box-divider m-a-0"></div>
                <div class="box-body row">

                     <?php if($this->input->post('change')==null){ echo validation_errors('<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); } ?>
            <?php echo ($error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
             <?php echo ($success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>

                  <?php $attributes = array('class' => 'stdform text-left', 'id' => 'form1','role' => 'form','method' => 'post','ui-jp'=>"parsley",'enctype' => 'multipart/form-data');
                    echo form_open('', $attributes);  ?>

 <?php if($this->uri->segment(2)=='edit'){ ?>
                      <input type="hidden" name="hdnoldfile" value="<?php echo $hdnoldfile;?>" >  
                   <?php      }
                   ?>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Photo  <small>*</small></label>
                        <input <?php if($this->uri->segment(2)=='add'){  ?> data-rule-required='true' required <?php }?> class="file-path form-control" name="file" id="file" type="file" placeholder="Upload Logo">
                    </div>

                       <?php if($this->uri->segment(2)=='edit'){ ?>
              <div class='form-group'>
                          <label class='control-label col-sm-3' for='validation_image'>Photo   <small>*</small></label>
                          <div class='col-sm-4 controls'>
                           <img width="100px" height="100px" src="<?php echo ADMIN_LOGO.$edit_admins['logo'];?>"/>
                          </div>
                        </div>
              
              <?php } ?>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Name  <small>*</small></label>
                      <?php   
                            $name_data = array(
                            'name'        => 'name',
                            'id'          => 'name',
                            'value'       => $name,
                            'required'        => 'required',
                            'class'        => 'form-control'
                           

                            );
                            echo form_input($name_data);

                            ?>
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Mobile  <small>*</small></label>
                     <?php   
                            $phone_number_data = array(
                             
                            'name'        => 'phone_number',
                            'id'          => 'phone_number',
                            'value'       => $phone_number,
                            'required'        => 'required',
                            'class'        => 'form-control'
                           

                            );
                            echo form_input($phone_number_data);

                            ?>
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Email  <small>*</small></label>
                     <?php   
                            $user_email_data = array(
                                'type'   => 'email',
                            'name'        => 'user_email',
                            'id'          => 'user_email',
                            'value'       => $user_email,
                            'required'        => 'required',
                            'class'        => 'form-control'
                          

                            );
                            echo form_input($user_email_data);

                            ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Username  <small>*</small></label>
                       <?php   
                            $username_data = array(
                            'name'        => 'username',
                            'id'          => 'username',
                            'value'       => $username,
                            'required'        => 'required',
                            'class'        => 'form-control'
                           

                            );
                            echo form_input($username_data);

                            ?>
                    </div>
                                <?php  $admin_data=$this->session->userdata('admin_data');
         if($admin_data['user_id']==1 && $this->router->fetch_method()=='edit') { ?>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Password  <small>*</small></label>
                      <?php   
                            $password_data = array(
                             
                            'name'        => 'password',
                            'id'          => 'password',
                             'value'       => $password,
                            'required'        => 'required',
                            'class'        => 'form-control'
                            

                            );
                            echo form_input($password_data);

                            ?>
                    </div>
                    <?php  } if($this->router->fetch_method()=='add') { ?>

                      <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Password  <small>*</small></label>
                      <?php   
                            $password_data = array(
                             
                            'name'        => 'password',
                            'id'          => 'password',
                            'required'        => 'required',
                            'class'        => 'form-control'
                            

                            );
                            echo form_password($password_data);

                            ?>
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Re-type password  <small>*</small></label>
                 <?php   
                            $passconf_data = array(
                             
                            'name'        => 'passconf',
                            'id'          => 'passconf',
                            'required'        => 'required',
                            'class'        => 'form-control'
                       

                            );
                            echo form_password($passconf_data);

                            ?>
                    </div>
                      <?php } ?>

                       <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Address  <small>*</small></label>
               <?php   
                            $address_data = array(

                            'name'        => 'address',
                            'id'          => 'address',
                            'value'       => $address,
                            'required'        => 'required',
                            'class'        => 'form-control'
                           
                     

                            );
                            echo form_input($address_data);

                            ?>
                    </div>

                     <?php 
        
        if($admin_data['user_id']==1){ 
        ?>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Role  <small>*</small></label>
                     <select class="form-control" name="access_level" id="access_level" required>
                                <option value="">Select User Level</option>
                                  

                         <option <?php  if($access_level=='Super User'){ echo "selected"; } ?> value="Super User">Super User</option>
                        <option <?php  if($access_level=='Transport Admin'){ echo "selected"; } ?> value="Transport Admin">Transport Admin</option>
                        <option <?php  if($access_level=='Company Admin'){ echo "selected"; } ?> value="Company Admin">Company Admin</option>
                        <option <?php  if($access_level=='Employee'){ echo "selected"; } ?> value="Employee">Employee</option>
                        <option <?php  if($access_level=='Driver'){ echo "selected"; } ?> value="Driver">Driver</option>
                        <option <?php  if($access_level=='Accounts'){ echo "selected"; } ?> value="Accounts">Accounts</option>
                               
                            </select>
                    </div>
                    <?php } ?>
                    <div class="form-group col-xs-12">
                      <label for="" class="cform-control-label">Notes  <small>*</small></label>
                      <textarea class="form-control" name="notes" id="notes" rows="3" required="" placeholder="Enter Note about User here"><?php echo $notes;?></textarea>
                    </div>
                    <div class="form-group m-t-md">
                      <div class="col-xs-12 text-center">
                        <button type="submit" class="btn btn-primary"><?php echo ucfirst($this->router->fetch_method());?> Profile</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ############ PAGE END-->
      </div>


        <!--footer-->
   <?php //$this->load->view('footer');?>
   <!--footer-->



    
          
    
       
        


         
            
    

