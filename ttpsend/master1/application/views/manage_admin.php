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
<div class="box-header">
              <h2>User List</h2>
              <small>List of User</small>
            </div>

               <div  class="alert alert-success  text-center hide">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p id="alertMsg"></p>
                    </div>
            <div class="box-body row">
              <div class="col-sm-6">
                Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r">
                <select class="input-sm form-control w-xs inline v-middle">
                  <option value="0">10</option>
                  <option value="1">20</option>
                  <option value="2">50</option>
                  <option value="3">100</option>
                </select>
              </div>
              <div class="col-sm-6 text-right">
                <a href="<?php echo HOST_ADMIN;?>admin/add" class="btn btn-sm btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Add User</a>
              </div>
            </div>
            <div>



               <table class="table m-b-none" ui-jp="footable" data-filter="#filter" data-page-size="5">
              <thead>
                <tr>

              
             

             <!--     <th><input type="checkbox" class="checkall" /></th> -->
        <th class="">S.No</th>
         <th>Photo</th>
        <th data-toggle="true">User Name</th>
        <th>Email</th>
        <th>Mobile</th>
          <th>Name</th>
        <th class="">Role</th>
         <th class="">Notes</th>
        <th class="">Status</th>
        <?php 
        $admin_data=$this->session->userdata('admin_data');
        if($admin_data['user_id']==1){ 
        ?>
        <th class="">Action</th>
        <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php if($all_admins['num_rows']>0){ $s=0; for ($i=0; $i <$all_admins['num_rows'] ; $i++) {  ?> 
                        <tr>
                         <!--  <td align=""><span class="">
                          <?php if($all_admins['results'][$i]['user_id']!=1){ ?>
                            <input type="checkbox" name="Checkall[]" value="<?php echo $all_admins['results'][$i]['user_id'];?>"  />
                             <?php } ?>
                          </span>
                          </td> -->
                          <td class=""><?php echo ($s+1);?></td>
                             <td><img class="w-40 img-circle" src="<?php echo ($all_admins['results'][$i]['logo']!=null)?ADMIN_LOGO.$all_admins['results'][$i]['logo']:LOGO;?>"></td>
                            <td><?php echo ($all_admins['results'][$i]['username']!=null)?$all_admins['results'][$i]['username']:'N/A';?></td>
                            <td><?php echo ($all_admins['results'][$i]['user_email']!=null)?$all_admins['results'][$i]['user_email']:'N/A';?></td>
                            <td><?php echo ($all_admins['results'][$i]['phone_number']!=null)?$all_admins['results'][$i]['phone_number']:'N/A';?></td>
                              <td><?php echo ($all_admins['results'][$i]['name']!=null)?$all_admins['results'][$i]['name']:'N/A';?></td>
                            <td class="center"><?php echo ($all_admins['results'][$i]['access_level']!=null)?$all_admins['results'][$i]['access_level']:'N/A';?></td> 
                         <!--    <td class=""><?php echo (($all_admins['results'][$i]['access_level']=='ACC-1')?'Admin':(($all_admins['results'][$i]['access_level']=='ACC-2')?'Sub-Admin':'Marketing'));?></td> -->
                             <td><?php echo ($all_admins['results'][$i]['notes']!=null)?$all_admins['results'][$i]['notes']:'N/A';?></td>
                            <td class="">
                              <?php if($all_admins['results'][$i]['user_status']=='Active'){ ?>
                              <a title="Active"  <?php if($admin_data['user_id']==1){ ?> href="<?php echo base_url('admin/inactive')."/".$all_admins['results'][$i]['user_id'];?>" class='label label-success' <?php } else { ?> class='green' <?php } ?>><?php echo $all_admins['results'][$i]['user_status'];?></a>
                              <?php }else{ ?>
                              <a title="Inactive" <?php if($admin_data['user_id']==1){ ?> href="<?php echo base_url('admin/active')."/".$all_admins['results'][$i]['user_id'];?>" class='label label-danger' <?php } else { ?> class='red' <?php } ?> ><?php echo $all_admins['results'][$i]['user_status'];?></a>
                              <?php } ?>
                           
                              </td>
              <?php if($admin_data['user_id']==1){  ?>
                            
                             <td class="">

                             
                             <?php if($all_admins['results'][$i]['user_id']!=1){ ?>
                             <a title="Edit" href="<?php echo base_url('admin/edit')."/".$all_admins['results'][$i]['user_id'];?>" class="btn btn-xs warning edit">Edit</a>
                             <a title="Edit" href="<?php echo base_url('admin/view')."/".$all_admins['results'][$i]['user_id'];?>" class="btn btn-xs success view">View</a>
                              <!--  <a title="Delete" href="<?php echo base_url('admin/delete')."/".$all_admins['results'][$i]['user_id'];?>" class="btn btn-primary admin_delete">Delete</a> -->
                             <?php } ?>

                             </td> 
                               <?php } ?>
                        </tr>
                     
                       <?php $s++; } }else{ ?>
<td colspan="8" class=" text-danger">No more records</td>
                        <?php } ?>
               
                
              </tbody>
               <tfoot class="hide-if-no-paging">
                  <tr>
                    <td colspan="5" >
                      <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </td>
                    <td colspan="4" class="text-right">
                      <ul class="pagination"></ul>
                    </td>
                  </tr>
                </tfoot>
            </table>

            
             
              </table>
            </div>
          </div>
        </div>
        <!-- ############ PAGE END-->
      </div>
