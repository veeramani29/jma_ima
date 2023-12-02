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
                <h2><img src="<?php echo ($vehicles_details['logo']!=null)?VECHICLE_SMLIMG.$vehicles_details['logo']:LOGO;?>" alt="<?php echo isset($vehicles_details)?$vehicles_details['Vnumber']:'';?>" class="w-128 img-circle"> &nbsp;  <?php echo isset($vehicles_details)?$vehicles_details['Vnumber']:'';?> / <?php echo isset($vehicles_details)?$vehicles_details['model']:'';?></h2>
              </div>
              <div class="col-sm-4 text-right">
                <a href="<?php echo HOST_ADMIN;?>vehicles/add_vehicles/<?php echo $vehicles_details['id'];?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp; Edit</a>
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
                        <th>Vehicle Registration No</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['Vnumber']:'';?></td>
                      </tr>
                      <tr>
                        <th>Vehicle Type</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['type']:'';?></td>
                      </tr>
                      <tr>
                        <th>Model</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['model']:'';?></td>
                      </tr>
                      <tr>
                        <th>Brand</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['brand']:'';?></td>
                      </tr>
                      <tr>
                        <th>Seating</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['seating']:'';?></td>
                      </tr>
                      <tr>
                        <th>Exterior Color</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['exterior_color']:'';?></td>
                      </tr>
                      <tr>
                        <th>Interior Color</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['interior_color']:'';?></td>
                      </tr>
                      <tr>
                        <th>Facilities</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['Fecilities']:'';?></td>
                      </tr>
                     
                      <tr>
                        <th>Notes</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['notes']:'';?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="box">
                <div class="box-header">
                  <h2>Document Expiry Dates</h2>
                </div>
                <div>
                  <table class="table m-b-none">
                    <tbody>
                      <tr>
                        <th>Registration Date</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['reg_date']:'';?></td>
                      </tr>
                      <tr>
                        <th>Insurance Expiry Date</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['insurance_exp_date']:'';?></td>
                      </tr>
                      <tr>
                        <th>Road Tax Expiry Date</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['tax_exp_date']:'';?></td>
                      </tr>
                      <tr>
                        <th>Pollution Certificate Expiry Date</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['poll_exp_date']:'';?></td>
                      </tr>
                      <tr>
                        <th>Commercial Permit Expiry Date</th>
                        <td><?php echo isset($vehicles_details)?$vehicles_details['permit_exp_date']:'';?></td>
                      </tr>
                      <tr>
                        <th>Fitness Expiry Date</th>
                       <td><?php echo isset($vehicles_details)?$vehicles_details['fitness_exp_date']:'';?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
             
            </div>
            <div class="col-sm-12">
              <div class="box">
                <div class="box-header">
                  <h2>Document Copies</h2>
                </div>
                <div class="box-body row">
                
                  <div class="col-sm-3 vd_regcer">
                    <p>Registration Certificate</p>
                 <!--    <input type="file" class="form-control Uimg"> -->
                 <img src="<?php echo ($vehicles_details['rc_proof']!=null)?VECHICLE_DOCU.$vehicles_details['rc_proof']:IMAGES."placeholder.jpg";?>" alt="ID Card" class="Simge <?php echo (@end(explode('.', $vehicles_details['rc_proof']))=='pdf')?"hide":"";?>"> 
        <embed type="application/pdf" background-color="0xFF525659" alt="Registration Certificate (RC)" class="Simg_rccert" src="<?php echo (isset($vehicles_details['rc_proof']) && $vehicles_details['rc_proof']!='')?VECHICLE_DOCU.$vehicles_details['rc_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                   
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>Tax</p>
                  <!--   <input type="file" class="form-control Uimg"> -->
                    <img src="<?php echo ($vehicles_details['tax_proof']!=null)?VECHICLE_DOCU.$vehicles_details['tax_proof']:IMAGES."placeholder.jpg";?>" alt="Driving License" class="Simge <?php echo (@end(explode('.', $vehicles_details['tax_proof']))=='pdf')?"hide":"";?>"> 
                      <embed type="application/pdf" background-color="0xFF525659" alt="Tax" class="Simg_taxcert" src="<?php echo (isset($vehicles_details['tax_proof']) && $vehicles_details['tax_proof']!='')?VECHICLE_DOCU.$vehicles_details['tax_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>Insurance</p>
               <!--      <input type="file" class="form-control Uimg"> -->
                   <img src="<?php echo ($vehicles_details['insurance_proof']!=null)?VECHICLE_DOCU.$vehicles_details['insurance_proof']:IMAGES."placeholder.jpg";?>" alt="Driving" class="Simge <?php echo (@end(explode('.', $vehicles_details['insurance_proof']))=='pdf')?"hide":"";?>"> 
                    <embed type="application/pdf" background-color="0xFF525659" alt="Insurance" class="Simg_insurancecert" src="<?php echo (isset($vehicles_details['insurance_proof']) && $vehicles_details['insurance_proof']!='')?VECHICLE_DOCU.$vehicles_details['insurance_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>Fitness Certificate</p>
                   <!--  <input type="file" class="form-control Uimg"> -->
                    <img src="<?php echo ($vehicles_details['fitness_proof']!=null)?VECHICLE_DOCU.$vehicles_details['fitness_proof']:IMAGES."placeholder.jpg";?>" alt="Driving" class="Simge <?php echo (@end(explode('.', $vehicles_details['fitness_proof']))=='pdf')?"hide":"";?>">
                     <embed type="application/pdf" background-color="0xFF525659" alt="Fitness" class="Simg_fitnesscert" src="<?php echo (isset($vehicles_details['fitness_proof']) && $vehicles_details['fitness_proof']!='')?$vehicles_details['fitness_proof']:IMAGES."placeholder.jpg";?>" width="100%"/> 
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>Emission Certificate</p>
                   <!--  <input type="file" class="form-control Uimg"> -->
                  <img src="<?php echo ($vehicles_details['emission_proof']!=null)?VECHICLE_DOCU.$vehicles_details['emission_proof']:IMAGES."placeholder.jpg";?>" alt="Driving" class="Simge <?php echo (@end(explode('.', $vehicles_details['emission_proof']))=='pdf')?"hide":"";?>"> 
                    <embed type="application/pdf" background-color="0xFF525659" alt="Emission" class="Simg_emissioncert" src="<?php echo (isset($vehicles_details['emission_proof']) && $vehicles_details['emission_proof']!='')?VECHICLE_DOCU.$vehicles_details['emission_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>Permit</p>
                   <!--  <input type="file" class="form-control Uimg"> -->
                     <img src="<?php echo ($vehicles_details['permit_proof']!=null)?VECHICLE_DOCU.$vehicles_details['permit_proof']:IMAGES."placeholder.jpg";?>" alt="Driving" class="Simge <?php echo (@end(explode('.', $vehicles_details['permit_proof']))=='pdf')?"hide":"";?>"> 
                      <embed class="Simg_permitcert" type="application/pdf" background-color="0xFF525659" alt="Permit" src="<?php echo (isset($vehicles_details['permit_proof']) && $vehicles_details['permit_proof']!='')?VECHICLE_DOCU.$vehicles_details['permit_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                  </div>
                  
                </div>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="box">
                <div class="box-header">
                  <h2>Photos</h2>
                </div>
                <div class="box-body row">
                  <?php 
                  $get_allImages=$this->Vehicles_Model->get_allImages($vehicles_details['id']);
                  if(!empty($get_allImages)){ foreach ($get_allImages as $key => $value) {
                    # code...
                
                  #print_r($get_allImages);
                   ?>
                  <div class="col-sm-3 vd_regcer">
                    <img src="<?php echo ($value['image_name']!=null)?VECHICLE_SMLIMG.$value['image_name']:IMAGES."placeholder.jpg";?>" alt="placeholder image">
                  </div>
                  <?php   }}else{ ?>
                  <div class="col-sm-3 vd_regcer">
                    <img src="<?php echo IMAGES;?>placeholder.jpg" alt="placeholder image">
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <img src="<?php echo IMAGES;?>placeholder.jpg" alt="placeholder image">
                  </div>
                 <?php } ?>
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