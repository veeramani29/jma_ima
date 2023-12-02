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
                <h2><img src="<?php echo ($company_details['logo']!=null)?CMPNY_SMLIMG.$company_details['logo']:LOGO;?>" alt="<?php echo isset($company_details)?$company_details['name']:'';?>" class="w-40"> &nbsp; <?php echo isset($company_details)?$company_details['name']:'';?></h2>
              </div>
              <div class="col-sm-4 text-right">
                <a href="<?php echo HOST_ADMIN;?>companies/add_companies/<?php echo $company_details['id'];?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp; Edit</a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="box">
                <div class="box-header">
                  <h2>Company  Details</h2>
                </div>
                <div>
                  <table class="table m-b-none">
                    <tbody>
                      <tr>
                        <th>Company Logo</th>
                        <td><img src="<?php echo ($company_details['logo']!=null)?CMPNY_SMLIMG.$company_details['logo']:LOGO;?>" alt="<?php echo isset($company_details)?$company_details['name']:'';?>" class="w-40"> </td>
                      </tr>
                      <tr>
                        <th>Company name</th>
                        <td><?php echo isset($company_details)?$company_details['name']:'';?></td>
                      </tr>
                      
                      <tr>
                        <th>Display  Name</th>
                        <td><?php echo isset($company_details)?$company_details['dispaly_name']:'';?></td>
                      </tr>
                      <tr>
                        <th>Short  Name</th>
                        <td><?php echo isset($company_details)?$company_details['short_name']:'';?></td>
                      </tr>
                      <tr>
                        <th>Person  Name</th>
                        <td><?php echo isset($company_details)?$company_details['person_name']:'';?></td>
                      </tr>

                      <tr>
                        <th>Email</th>
                        <td><?php echo isset($company_details)?$company_details['email']:'';?></td>
                      </tr>
                      <tr>
                        <th>Website</th>
                        <td><?php echo isset($company_details)?$company_details['website']:'';?></td>
                      </tr>
                      <tr>
                        <th>GSTIN</th>
                        <td><?php echo isset($company_details)?$company_details['gstin']:'';?></td>
                      </tr>



                       <tr>
                        <th>Google Maps Location</th>
                        <td><?php echo isset($company_details)?$company_details['map_location']:'';?></td>
                      </tr>
                       <tr>
                        <th>Tariffs</th>
                        <td><a href="tariffs/<?php echo isset($company_details)?$company_details['id']:'';?>">View</a></td>
                      </tr>
                       <tr>
                        <th>Contract Status</th>
                        <td><?php echo isset($company_details)?$company_details['contract_status']:'';?></td>
                      </tr>
                       <tr>
                        <th>Agreement Date</th>
                        <td><?php echo isset($company_details)?$company_details['agreement_date']:'';?></td>
                      </tr>
                       <tr>
                        <th>Agreement Expiry Date</th>
                        <td><?php echo isset($company_details)?$company_details['agreement_exp_date']:'';?></td>
                      </tr>

                      <tr>
                        <th>Notes</th>
                        <td><?php echo isset($company_details)?$company_details['notes']:'';?></td>
                      </tr>

                       <tr>
                        <th>Address</th>
                        <td><?php echo isset($company_details)?$company_details['address']:'';?></td>
                      </tr>
                      <tr>
                        <th>Phone Number</th>
                        <td><?php echo isset($company_details)?$company_details['number']:'';?></td>
                      </tr>
                       <tr>
                        <th>Status</th>
                        <td><?php echo isset($company_details)?$company_details['status']:'';?></td>
                      </tr>
                       <tr>
                        <th>When Created</th>
                        <td><?php echo isset($company_details)?$company_details['add_date']:'';?></td>
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