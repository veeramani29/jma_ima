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
                <h2><img src="<?php echo ($drivers_details['logo']!=null)?DRIVER_SMLIMG.$drivers_details['logo']:LOGO;?>" alt="<?php echo isset($drivers_details)?$drivers_details['first_name']:'';?>" class="w-128 img-circle"> &nbsp; Driver <?php echo isset($drivers_details)?$drivers_details['first_name']:'';?> / <?php echo isset($drivers_details)?$drivers_details['id_code']:'';?></h2>
              </div>
              <div class="col-sm-4 text-right">
                <a href="<?php echo HOST_ADMIN;?>drivers/add_drivers/<?php echo $drivers_details['id'];?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp; Edit</a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="box">
                <div class="box-header">
                  <h2>Driver Details</h2>
                </div>
                <div>
                  <table class="table m-b-none">
                    <tbody>
                      <tr>
                        <th>ID Code</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['id_code']:'';?></td>
                      </tr>
                      <tr>
                        <th>First Name</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['first_name']:'';?></td>
                      </tr>
                       <tr>
                        <th>Last Name</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['middle_name']:'';?></td>
                      </tr>
                       <tr>
                        <th>Middle Name</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['last_name']:'';?></td>
                      </tr>
                      <tr>
                        <th>Gender</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['gender']:'';?></td>
                      </tr>
                      <tr>
                        <th>Date of Birth</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['dob']:'';?></td>
                      </tr>
                      <tr>
                        <th>Experience</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['experience']:'';?></td>
                      </tr>
                      <tr>
                        <th>Mobile Number</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['number']:'';?></td>
                      </tr>
                      <tr>
                        <th>WhatsApp</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['WhatsAppnumber']:'';?></td>
                      </tr>
                      <tr>
                        <th>Email ID</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['email']:'';?></td>
                      </tr>
                      <tr>
                        <th>Residing Area</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['residing_area']:'';?></td>
                      </tr>
                      <tr>
                        <th>Residing Address</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['address']:'';?></td>
                      </tr>
                      <tr>
                        <th>Permanent Address</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['permanent_address']:'';?></td>
                      </tr>
                      <tr>
                        <th>Notes</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['notes']:'';?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="box">
                <div class="box-header">
                  <h2>Document Numbers</h2>
                </div>
                <div>
                  <table class="table m-b-none">
                    <tbody>
                      <tr>
                        <th>Aadaar No</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['aadaar_number']:'';?></td>
                      </tr>
                      <tr>
                        <th>Badge No</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['badge_number']:'';?></td>
                      </tr>
                      <tr>
                        <th>DL No</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['dl_number']:'';?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="box">
                <div class="box-header">
                  <h2>Expirty Date</h2>
                </div>
                <div>
                  <table class="table m-b-none">
                    <tbody>
                      <tr>
                        <th>Driving License</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['license']:'';?></td>
                      </tr>
                      <tr>
                        <th>Badge</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['badge']:'';?></td>
                      </tr>
                      <tr>
                        <th>Display Card</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['display_card']:'';?></td>
                      </tr>
                      <tr>
                        <th>PVC</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['pvc']:'';?></td>
                      </tr>
                      <tr>
                        <th>BGV</th>
                        <td><?php echo isset($drivers_details)?$drivers_details['bgv']:'';?></td>
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
                    <p>ID Card</p>
                 <!--    <input type="file" class="form-control Uimg"> -->
                 <img src="<?php echo ($drivers_details['id_card_proof']!=null)?DRIVER_DOCU.$drivers_details['id_card_proof']:IMAGES."placeholder.jpg";?>" alt="ID Card" class="Simge <?php echo (@end(explode('.', $drivers_details['id_card_proof']))=='pdf')?"hide":"";?>"> 
 <embed type="application/pdf" background-color="0xFF525659" alt="BGV" class="Simg_rccert" src="<?php echo (isset($drivers_details['id_card_proof']) && $drivers_details['id_card_proof']!='')?DRIVER_DOCU.$drivers_details['id_card_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                   
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>Driving License</p>
                  <!--   <input type="file" class="form-control Uimg"> -->
                    <img src="<?php echo ($drivers_details['license_proof']!=null)?DRIVER_DOCU.$drivers_details['license_proof']:IMAGES."placeholder.jpg";?>" alt="Driving License" class="Simge <?php echo (@end(explode('.', $drivers_details['license_proof']))=='pdf')?"hide":"";?>"> 
                     <embed type="application/pdf" background-color="0xFF525659" alt="BGV" class="Simg_rccert" src="<?php echo (isset($drivers_details['license_proof']) && $drivers_details['license_proof']!='')?DRIVER_DOCU.$drivers_details['license_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>Badge</p>
              
                   <img src="<?php echo ($drivers_details['badge_proof']!=null)?DRIVER_DOCU.$drivers_details['badge_proof']:IMAGES."placeholder.jpg";?>" alt="Driving" class="Simge <?php echo (@end(explode('.', $drivers_details['badge_proof']))=='pdf')?"hide":"";?>"> 
                    <embed type="application/pdf" background-color="0xFF525659" alt="BGV" class="Simg_rccert" src="<?php echo (isset($drivers_details['badge_proof']) && $drivers_details['badge_proof']!='')?DRIVER_DOCU.$drivers_details['badge_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>Display Card</p>
                   <!--  <input type="file" class="form-control Uimg"> -->
                    <img src="<?php echo ($drivers_details['display_card_proof']!=null)?DRIVER_DOCU.$drivers_details['display_card_proof']:IMAGES."placeholder.jpg";?>" alt="Driving" class="Simge <?php echo (@end(explode('.', $drivers_details['display_card_proof']))=='pdf')?"hide":"";?>"> 
                     <embed type="application/pdf" background-color="0xFF525659" alt="BGV" class="Simg_rccert" src="<?php echo (isset($drivers_details['display_card_proof']) && $drivers_details['display_card_proof']!='')?DRIVER_DOCU.$drivers_details['display_card_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>Aadhaar</p>
                   <!--  <input type="file" class="form-control Uimg"> -->
                  <img src="<?php echo ($drivers_details['aadaar_card_proof']!=null)?DRIVER_DOCU.$drivers_details['aadaar_card_proof']:IMAGES."placeholder.jpg";?>" alt="Driving" class="Simge <?php echo (@end(explode('.', $drivers_details['aadaar_card_proof']))=='pdf')?"hide":"";?>"> 
                   <embed type="application/pdf" background-color="0xFF525659" alt="BGV" class="Simg_rccert" src="<?php echo (isset($drivers_details['aadaar_card_proof']) && $drivers_details['aadaar_card_proof']!='')?DRIVER_DOCU.$drivers_details['aadaar_card_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>PVC</p>
                   <!--  <input type="file" class="form-control Uimg"> -->
                     <img src="<?php echo ($drivers_details['pvc_proof']!=null)?DRIVER_DOCU.$drivers_details['pvc_proof']:IMAGES."placeholder.jpg";?>" alt="Driving" class="Simge <?php echo (@end(explode('.', $drivers_details['pvc_proof']))=='pdf')?"hide":"";?>"> 
                      <embed type="application/pdf" background-color="0xFF525659" alt="BGV" class="Simg_rccert" src="<?php echo (isset($drivers_details['pvc_proof']) && $drivers_details['pvc_proof']!='')?DRIVER_DOCU.$drivers_details['pvc_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                  </div>
                  <div class="col-sm-3 vd_regcer">
                    <p>BGV</p>
                 <!--    <input type="file" class="form-control Uimg"> -->
                 <img src="<?php echo ($drivers_details['bgv_proof']!=null)?DRIVER_DOCU.$drivers_details['bgv_proof']:IMAGES."placeholder.jpg";?>" alt="Driving" class="Simge <?php echo (@end(explode('.', $drivers_details['bgv_proof']))=='pdf')?"hide":"";?>"> 
                  <embed type="application/pdf" background-color="0xFF525659" alt="BGV" class="Simg_rccert" src="<?php echo (isset($drivers_details['bgv_proof']) && $drivers_details['bgv_proof']!='')?DRIVER_DOCU.$drivers_details['bgv_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                  </div>
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