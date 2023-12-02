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
          <div class="box">
            <div class="box-header row">
              <div class="col-sm-8">
                <h2><img src="<?php echo ($admin_details['logo']!=null)?ADMIN_LOGO.$admin_details['logo']:LOGO;?>" alt="<?php echo isset($admin_details)?$admin_details['name']:'';?>" class="w-40"> &nbsp; <?php echo isset($admin_details)?$admin_details['access_level']:'';?></h2>
              </div>
              <div class="col-sm-4 text-right">
                <a href="<?php echo HOST_ADMIN;?>admin/edit/<?php echo $admin_details['user_id'];?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp; Edit</a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="box">
                <div class="box-header">
                  <h2>User Details</h2>
                </div>
                <div>
                  <table class="table m-b-none">
                    <tbody>
                      <tr>
                        <th>Photo</th>
                        <td><img src="<?php echo ($admin_details['logo']!=null)?ADMIN_LOGO.$admin_details['logo']:LOGO;?>" alt="<?php echo isset($admin_details)?$admin_details['name']:'';?>" class="w-40"> </td>
                      </tr>
                      <tr>
                        <th>User name</th>
                        <td><?php echo isset($admin_details)?$admin_details['username']:'';?></td>
                      </tr>
                       <tr>
                        <th>Email</th>
                        <td><?php echo isset($admin_details)?$admin_details['user_email']:'';?></td>
                      </tr>

                      <tr>
                        <th>Person Name</th>
                        <td><?php echo isset($admin_details)?$admin_details['name']:'';?></td>
                      </tr>
                      <tr>
                        <th>Address</th>
                        <td><?php echo isset($admin_details)?$admin_details['address']:'';?></td>
                      </tr>
                      <tr>
                        <th>Phone Number</th>
                        <td><?php echo isset($admin_details)?$admin_details['phone_number']:'';?></td>
                      </tr>

                      <tr>
                        <th>Password</th>
                        <td><?php echo isset($admin_details)?$admin_details['password']:'';?></td>
                      </tr>

                       <tr>
                        <th>Status</th>
                        <td><?php echo isset($admin_details)?$admin_details['user_status']:'';?></td>
                      </tr>
                       <tr>
                        <th>Notes</th>
                        <td><?php echo isset($admin_details)?$admin_details['notes']:'';?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ############ PAGE END-->
      </div>
    </div>
    <!-- / -->

      <!--footer-->
   <?php //$this->load->view('footer');?>
   <!--footer-->