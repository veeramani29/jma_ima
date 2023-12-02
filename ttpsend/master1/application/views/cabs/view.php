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
                <h2>  <?php echo isset($cabs_details)?$cabs_details['Vnumber']:'';?> / <?php echo isset($cabs_details)?$cabs_details['model']:'';?></h2>
              </div>
              <div class="col-sm-4 text-right">
                <a href="<?php echo HOST_ADMIN;?>cabs/add_cabs/<?php echo $cabs_details['cab_id'];?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp; Edit</a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="box">
                <div class="box-header">
                  <h2>Vehicle Details</h2>
                </div>
                <div>
                  <table class="table m-b-none">
                    <tbody>

                      <tr>
                        <th>Cab id</th>
                        <td><?php echo isset($cabs_details)?"Cab".$cabs_details['id']:'';?></td>
                      </tr>
                      <tr>
                        <th>Vehicle Registration No</th>
                        <td><?php echo isset($cabs_details)?$cabs_details['Vnumber']:'';?></td>
                      </tr>
 <tr>
                       <th>
                      Driver Code
                    </th>
                     <td><?php echo isset($cabs_details)?$cabs_details['id_code']:'';?></td>
                  </tr>
                     <tr>
                    <th>
                      Induction Date
                    </th>
                      <td><?php echo ($cabs_details['induction_date']!=null)?$cabs_details['induction_date']:'N/A';?></td>
                  </tr>
                   <tr>
                     <th>
                      Driver name
                    </th>
                     <td><?php echo ($cabs_details['first_name']!=null)?$cabs_details['first_name']:'N/A';?></td>
                  </tr>
                   <tr>
                    <th>
                      Driver Mobile
                    </th>
                     <td><?php echo ($cabs_details['number']!=null)?$cabs_details['number']:'N/A';?></td>
</tr>
                      <tr>
                        <th>Vehicle Type</th>
                        <td><?php echo isset($cabs_details)?$cabs_details['type']:'';?></td>
                      </tr>

                      <tr>
                        <th>Removal Date</th>
                        <td><?php echo isset($cabs_details)?$cabs_details['removed_date']:'';?></td>
                      </tr>
                      
                      <tr>
                        <th>Model</th>
                        <td><?php echo isset($cabs_details)?$cabs_details['model']:'';?></td>
                      </tr>
                      <tr>
                        <th>Brand</th>
                        <td><?php echo isset($cabs_details)?$cabs_details['brand']:'';?></td>
                      </tr>
                      <tr>
                        <th>Seating</th>
                        <td><?php echo isset($cabs_details)?$cabs_details['seating']:'';?></td>
                      </tr>
                      <tr>
                        <th>Exterior Color</th>
                        <td><?php echo isset($cabs_details)?$cabs_details['exterior_color']:'';?></td>
                      </tr>
                      <tr>
                        <th>Interior Color</th>
                        <td><?php echo isset($cabs_details)?$cabs_details['interior_color']:'';?></td>
                      </tr>
                      <tr>
                        <th>Facilities</th>
                        <td><?php echo isset($cabs_details)?$cabs_details['Fecilities']:'';?></td>
                      </tr>
                     
                      <tr>
                        <th>Notes</th>
                        <td><?php echo isset($cabs_details)?$cabs_details['cab_notes']:'';?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="box">
                <div class="box-header">
                  <h2>Detail Summery</h2>
                </div>
                <div>
                  <table class="table m-b-none">
                    <tbody>
                      <tr>
                        <th>Driver Details</th>
                        <td><a href="<?php echo HOST_ADMIN;?>drivers/view/<?php echo $cabs_details['driver'];?>" class="btn btn-warning">View Driver</a> <a href="<?php echo HOST_ADMIN;?>drivers/add_drivers/<?php echo $cabs_details['driver'];?>" class="btn btn-success">Edit Driver</a></td>
                      </tr>
                      <tr>
                        <th>Vehicle Details</th>
                        <td><a href="<?php echo HOST_ADMIN;?>vehicles/view/<?php echo $cabs_details['vehicle'];?>" class="btn btn-warning">View Vehicle </a> <a href="<?php echo HOST_ADMIN;?>vehicles/add_vehicles/<?php echo $cabs_details['vehicle'];?>" class="btn btn-success">Edit Vehicle </a></td>
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