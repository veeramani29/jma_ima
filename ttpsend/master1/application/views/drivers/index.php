       <!--header-->
   <?php //$this->load->view('header');?>
   <!--header-->
     <!--leftmenu-->
   <?php $this->load->view('leftmenu');?>
   <!--leftmenu-->
 <!-- content -->
    <div id="content" class="app-content box-shadow-z0" role="main">
    
          <!--app header ,footer-->
   <?php $this->load->view('a');?>
   <!--app header,footer-->
     <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
          <div class="box">
            <div class="box-header">
              <h2>Driver List</h2>
              <small>List of driver with availablity status below</small>
            </div>

                 <div  class="alert alert-success text-center hide">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p id="alertMsg"></p>
                    </div>

            <div class="box-body row">
              <div class="col-sm-6">
                Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r"/>
                <select class="input-sm form-control w-xs inline v-middle">
                  <option value="0">10</option>
                  <option value="1">20</option>
                  <option value="2">50</option>
                  <option value="3">100</option>
                </select>
              </div>
              <div class="col-sm-6 text-right">
                <a href="<?php echo HOST_ADMIN;?>drivers/add_drivers" class="btn btn-sm btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Add Driver</a>
              </div>
            </div>
            <div>
              <table class="table m-b-none" ui-jp="footable" data-filter="#filter" data-page-size="5">
                <thead>
                  <tr>
                  <!--   <th style="width:20px;">
              <label class="ui-check m-a-0">
                <input type="checkbox" name="Checkall[]"><i></i>
              </label>
            </th> -->

                     <th>
                      S.No
                    </th>
                     <!-- <th >
                      Ride Status
                    </th> -->
                    <th>
                      Profile Photo
                    </th>
                     <th >
                      Driver Id
                    </th>
                    <th>
                      Full Name
                    </th>
                       <th>
                      Mobile Number
                    </th>
                     <th>
                      Residing Area
                    </th>
                    <th>
                      Experience
                    </th>
                    <th >
                      Address
                    </th>
                 
                     <th>
                      Status
                    </th>
                    <th>
                      View More
                    </th>
                  </tr>
                </thead>
                <tbody>

                    <?php if($all_drivers['num_rows']>0){ $s=0; for ($i=0; $i <$all_drivers['num_rows'] ; $i++) {  ?> 
                        <tr>

                         

                         <!--  <td align="text-center"><span class="text-center">
                         
                            <input type="checkbox" name="Checkall[]" value="<?php echo $all_drivers['results'][$i]['id'];?>"  />
                           
                          </span>
                          </td> -->
                          <td class="text-center"><?php echo ($s+1);?></td>
                             <td><img class="w-40 img-circle" src="<?php echo ($all_drivers['results'][$i]['logo']!=null)?DRIVER_SMLIMG.$all_drivers['results'][$i]['logo']:LOGO;?>"></td>
<td><?php echo ($all_drivers['results'][$i]['id_code']!=null)?$all_drivers['results'][$i]['id_code']:'N/A';?></td>

                            <td><?php echo ($all_drivers['results'][$i]['first_name']!=null)?$all_drivers['results'][$i]['middle_name'].' '.$all_drivers['results'][$i]['first_name'].' '.$all_drivers['results'][$i]['last_name']:'N/A';?></td>
                       
                            <td><?php echo ($all_drivers['results'][$i]['number']!=null)?$all_drivers['results'][$i]['number']:'N/A';?></td>

                             <td><?php echo ($all_drivers['results'][$i]['residing_area']!=null)?"+ ".$all_drivers['results'][$i]['residing_area']:'N/A';?></td>
                                 <td><?php echo ($all_drivers['results'][$i]['experience']!=null)?"+ ".$all_drivers['results'][$i]['experience']:'N/A';?></td>

                                 
                         <td class="center"><?php echo ($all_drivers['results'][$i]['address']!=null)?$all_drivers['results'][$i]['address']:'N/A';?></td> 
                           
                           
                            <td class="text-center">
                              <?php if($all_drivers['results'][$i]['status']=='Active'){ ?>
                              <a title="Active"   href="<?php echo base_url('drivers/inactive')."/".$all_drivers['results'][$i]['id'];?>" class='label label-success'><?php echo $all_drivers['results'][$i]['status'];?></a>
                              <?php }else{ ?>
                              <a title="Inactive"  href="<?php echo base_url('drivers/active')."/".$all_drivers['results'][$i]['id'];?>" class='label label-danger'  ><?php echo $all_drivers['results'][$i]['status'];?></a>
                              <?php } ?>
                           
                              </td>
          
                            
                             <td class="text-center">

                             
                         
                             <a title="Edit" href="<?php echo base_url('drivers/add_drivers')."/".$all_drivers['results'][$i]['id'];?>" class="btn btn-xs edit white">Edit</a>
                              <!--  <a title="Delete" href="<?php echo base_url('drivers/delete')."/".$all_drivers['results'][$i]['id'];?>" class="btn btn-primary companies_delete">Delete</a> -->
                              <a href="<?php echo base_url('drivers/view')."/".$all_drivers['results'][$i]['id'];?>" class="btn btn-xs white">Details</a>
                   

                             </td> 
                              
                        </tr>
                     
                       <?php $s++; } }else{ ?>
<td colspan="6" class="text-center text-danger">No more records</td>
                        <?php } ?>

               
               
                </tbody>
                <tfoot class="hide-if-no-paging">
                  <tr>
                    <td colspan="3" >
                      <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </td>
                    <td colspan="3" class="text-right">
                      <ul class="pagination"></ul>
                    </td>
                  </tr>
                </tfoot>
              </table>
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
   

         