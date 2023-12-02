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

                  
                      
                        $password=$edit_admins['password'];
                       
                           
                  
                   ?>

                <div class="box-divider m-a-0"></div>
                <div class="box-body row">

                     <?php if($this->input->post('change')!=null){ echo validation_errors('<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); } ?>
            <?php echo ($error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
             <?php echo ($success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>

                  <?php $attributes = array('class' => 'stdform text-left', 'id' => 'change','role' => 'form','method' => 'post','ui-jp'=>"parsley",'enctype' => 'multipart/form-data');
                    echo form_open('', $attributes);  ?>

                                  <input type="hidden" name="Oldpassword" id="Oldpassword" value="<?php echo $password;?>" />
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Current Password</label>
                     <?php   
                            $new_password_data = array(
                             
                            'name'        => 'new_password',
                            'id'          => 'new_password',
                            'required'        => 'required',
                            'class'        => 'form-control'
                            

                            );
                            echo form_password($new_password_data);

                            ?>
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">New password</label>
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
                      <label for="" class="cform-control-label">Confirm password</label>
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
                    

                   
                  
                    <div class="form-group m-t-md">
                      <div class="col-xs-12 text-center">
                        <button type="submit" value="change" name="change" class="btn btn-primary"><?php echo ucfirst($this->router->fetch_method());?> </button>
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



    
          
    
       
        


         
            
    

