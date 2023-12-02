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
     <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                  <h2>  <?php echo ($this->uri->segment(3)!='')?"Edit":"Add";?> Driver</h2>
                  <small>By filling all form details of driver, driver will be shown in the list of Driver's.</small>
                </div>
                <div class="box-divider m-a-0"></div>
                <div class="box-body row">

                    <?php echo validation_errors('<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');  ?>

                       <?php echo (isset($error_msg) && $error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
             <?php echo (isset($success_msg) && $success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>

                  <form ui-jp="parsley" method="post" enctype="multipart/form-data" role="form">



   <?php

                    if ($this->uri->segment(3)!='') {
                        $first_name=$drivers_details['first_name'];
                         $middle_name=$drivers_details['middle_name'];
                          $last_name=$drivers_details['last_name'];
                        $id_code=$drivers_details['id_code'];
                        $gender=$drivers_details['gender'];
                        $dob=$drivers_details['dob'];
                        $experience=$drivers_details['experience'];
                        $number=$drivers_details['number'];
                        $WhatsAppnumber=$drivers_details['WhatsAppnumber'];
                        $email=$drivers_details['email'];
                        $residing_area=$drivers_details['residing_area'];
                        $address=$drivers_details['address'];
                        $permanent_address=$drivers_details['permanent_address'];
                        $notes=$drivers_details['notes'];
                        $aadaar_number=$drivers_details['aadaar_number'];
                        $badge_number=$drivers_details['badge_number'];
                        $dl_number=$drivers_details['dl_number'];
                        $license=$drivers_details['license'];
                        $badge=$drivers_details['badge'];
                        $display_card=$drivers_details['display_card'];
                        $pvc=$drivers_details['pvc'];
                        $bgv=$drivers_details['bgv'];
                       

                        
                    } else {
                    $first_name=set_value('first_name');
                      $middle_name=set_value('middle_name');
                        $last_name=set_value('last_name');
                    $id_code=set_value('id_code');
                    $gender=set_value('gender');
                    $dob=set_value('dob');
                    $experience=set_value('experience');
                    $number=set_value('number');
                    $WhatsAppnumber=set_value('WhatsAppnumber');
                    $email=set_value('email');
                    $residing_area=set_value('residing_area');
                    $address=set_value('address');
                    $permanent_address=set_value('permanent_address');
                    $notes=set_value('notes');
                    $aadaar_number=set_value('aadaar_number');
                    $badge_number=set_value('badge_number');
                    $dl_number=set_value('dl_number');
                    $license=set_value('license');
                    $badge=set_value('badge');
                    $display_card=set_value('display_card');
                    $pvc=set_value('pvc');
                    $bgv=set_value('bgv');
                    }
                   ?>

                     <?php if ($this->uri->segment(3)!='') {
                       ?>
                      <input type="hidden" name="hdnoldfile" value="<?php echo isset($drivers_details)?$drivers_details['logo']:''; ?>" >  

                      <input type="hidden" name="hdnid_card_proof" value="<?php echo isset($drivers_details)?$drivers_details['id_card_proof']:''; ?>" >

                 <input type="hidden" name="hdnlicense_proof" value="<?php echo isset($drivers_details)?$drivers_details['license_proof']:''; ?>" >
                  <input type="hidden" name="hdnbadge_proof" value="<?php echo isset($drivers_details)?$drivers_details['badge_proof']:''; ?>" >
                   <input type="hidden" name="hdndisplay_card_proof" value="<?php echo isset($drivers_details)?$drivers_details['display_card_proof']:''; ?>" >
                    <input type="hidden" name="hdnaadaar_card_proof" value="<?php echo isset($drivers_details)?$drivers_details['aadaar_card_proof']:''; ?>" >
                     <input type="hidden" name="hdnpvc_prooffile" value="<?php echo isset($drivers_details)?$drivers_details['pvc_proof']:''; ?>" >
                      <input type="hidden" name="hdnbgv_proof" value="<?php echo isset($drivers_details)?$drivers_details['bgv_proof']:''; ?>" >
                      
                   <?php
                   } ?>
                    <div class="form-group col-sm-3">
                      <label for="logo" class="cform-control-label">Driver  Photo</label>
                      <input  <?php if ($this->uri->segment(3)=='') {
                       ?>    <?php
                   } ?> type="file" class="form-control" id="logo" name="logo" placeholder="Company Logo">
                    </div>
 <?php if ($this->uri->segment(3)!='') {
                       ?>
                     <div class="form-group col-sm-3">
             <img src="<?php echo ($drivers_details['logo']!=null)?DRIVER_SMLIMG.$drivers_details['logo']:LOGO; ?>" alt="<?php echo isset($drivers_details)?$drivers_details['first_name']:''; ?>" class="w-40">
              </div>
    <?php
                   } ?>
                    <div class="form-group col-sm-3">
                      <label for="name" class="cform-control-label">First Name <small>*</small></label>
                      <input required="" type="text" class="form-control" value="<?php echo $first_name; ?>"  id="first_name" name="first_name"  placeholder="First Name">
                    </div>

                     <div class="form-group col-sm-3">
                      <label for="name" class="cform-control-label">Middle Name <small>*</small></label>
                      <input required="" type="text" class="form-control" value="<?php echo $middle_name; ?>"  id="middle_name" name="middle_name"  placeholder="Middle Name">
                    </div>

                     <div class="form-group col-sm-3">
                      <label for="name" class="cform-control-label">Last Name <small>*</small></label>
                      <input required="" type="text" class="form-control" value="<?php echo $last_name; ?>"  id="last_name" name="last_name"  placeholder="Last Name">
                    </div>
                    <div class="form-group col-sm-2">
                         <label for="person_name" class="cform-control-label">ID Code <small>*</small></label>
                      <div class="input-group">
                <div class="input-group-addon">BST</div>
              <input  required="" type="text" class="form-control Onumber" value="<?php echo str_replace('BST', '', $id_code); ?>" id="id_code" name="id_code" placeholder="ID Code">
              </div>
                   
                   
                    </div>
                    <div class="form-group col-sm-2">
                      <label for="" class="cform-control-label">Gender</label>
                      <select name="gender" id="gender" class="form-control">
                        <option value="Male" <?php  if($gender=='Male'){ echo "selected"; } ?>>Male</option>
                        <option value="Female" <?php  if($gender=='Female'){ echo "selected"; } ?>>Female</option>
                        <option value="Others" <?php  if($gender=='Others'){ echo "selected"; } ?>>Others</option>
                      </select>
                    </div>

                    <div class="form-group col-sm-2">
                      <label for="" class="cform-control-label">Date of Birth</label>
                      <div class="input-group date"  ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',  maxDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                        <input  type="text" value="<?php echo $dob; ?>" name="dob" id="dob" class="form-control has-value">
                        <span class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
  <div class="form-group col-sm-2">
                      <label for="" class="cform-control-label">Experience</label>
                      <select  name="experience" id="experience" class="form-control">
                        <?php for ($i=1; $i <30 ; $i++) { ?>
                        
                        
                        <option value="<?php echo $i;?>" <?php  if($experience==$i){ echo "selected"; } ?>><?php echo $i;?></option>
                       <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-sm-2">
                      <label for="number" class="cform-control-label">Mobile  Number</label>
                        <input   type="text" class="form-control Onumber" value="<?php echo $number; ?>" id="number" name="number" placeholder="Mobile  Number">
                    </div>
                     <div class="form-group col-sm-2">
                      <label for="number" class="cform-control-label">WhatsApp</label>
                        <input   type="text" class="form-control Onumber" value="<?php echo $WhatsAppnumber; ?>" id="WhatsAppnumber" name="WhatsAppnumber" placeholder="WhatsApp Number">
                    </div>
                     <div class="form-group col-sm-3">
                      <label for="number" class="cform-control-label">Email</label>
                        <input   type="text" class="form-control " value="<?php echo $email; ?>" id="email" name="email" placeholder="Email">
                    </div>
                     <div class="form-group col-sm-3">
                      <label for="residing_area" class="cform-control-label">Residing Area</label>
                        <input   type="text" class="form-control " value="<?php echo $residing_area; ?>" id="residing_area" name="residing_area" placeholder="Residing Area">
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="address" class="cform-control-label">Residing  Address</label>
                        <textarea  placeholder="Residing  Address" id="address" name="address"  class="form-control" rows="5"><?php echo $address; ?></textarea>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="address" class="cform-control-label">Permanent Address</label>
                        <textarea  placeholder="permanent Address" name="permanent_address"  class="form-control" rows="5"><?php echo $permanent_address; ?></textarea>
                    </div>

                     <div class="form-group col-sm-4">
                      <label for="" class="cform-control-label">Notes</label>
                      <textarea class="form-control" name="notes" id="notes" rows="5"  placeholder="Enter Note about driver here"><?php echo $notes;?></textarea>
                    </div>


                     <div class="box-header col-xs-12">
                      <h2>Document Numbers</h2>
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Aadaar Number</label>
                      <input  name="aadaar_number" id="aadaar_number" value="<?php echo $aadaar_number;?>"  type="text" class="form-control Onumber" id="" placeholder="Aadaar Number">
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Badge Number</label>
                      <input  name="badge_number" id="badge_number" value="<?php echo $badge_number;?>"  type="text" class="form-control " id="" placeholder="Badge Number">
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">DL Number</label>
                      <input  name="dl_number" id="dl_number" value="<?php echo $dl_number;?>"  type="text" class="form-control " id="" placeholder="Driving Licence Number">
                    </div>
                    
                    <div class="box-header col-xs-12">
                      <h2>Expiry Date</h2>
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Driving License</label>
                      <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                        <input  value="<?php echo $license;?>" name="license" id="license"  type='text' class="form-control" />
                        <span class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Badge</label>
                      <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                        <input value="<?php echo $badge;?>" name="badge" id="badge"  type='text' class="form-control" />
                        <span class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">Display Card</label>
                      <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                        <input value="<?php echo $display_card;?>" name="display_card" id="display_card"  type='text' class="form-control" />
                        <span class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">PVC</label>
                      <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                        <input value="<?php echo $pvc;?>"  name="pvc" id="pvc"  type='text' class="form-control" />
                        <span class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="" class="cform-control-label">BGV</label>
                      <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                        <input value="<?php echo $bgv;?>"  name="bgv" id="bgv"  type='text' class="form-control" />
                        <span class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
 <div class="box-header col-xs-12">
                      <h2>Document Copies</h2>
                    </div>
                   
                    <div class="form-group dc_img col-sm-3">
                      <label for="" class="cform-control-label">ID Card</label>
                      <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="id_card_proof" name="id_card_proof">
                      <img class="Simg_id_card_proof <?php echo (@end(explode('.', $drivers_details['id_card_proof']))=='pdf')?"hide":"";?>"  src="<?php echo (isset($drivers_details['id_card_proof']) && $drivers_details['id_card_proof']!='')?DRIVER_DOCU.$drivers_details['id_card_proof']:IMAGES."placeholder.jpg";?>" alt="ID Card"> 
                <embed type="application/pdf" background-color="0xFF525659" alt="ID Card" class="Simg_id_card_proof" src="<?php echo (isset($drivers_details['id_card_proof']) && $drivers_details['id_card_proof']!='')?DRIVER_DOCU.$drivers_details['id_card_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                    </div>
                    <div class="form-group dc_img col-sm-3">
                      <label for="" class="cform-control-label">Driving License</label>
                      <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="license_proof" name="license_proof">
                      <img class="Simg_license_proof <?php echo (@end(explode('.', $drivers_details['license_proof']))=='pdf')?"hide":"";?>"  src="<?php echo (isset($drivers_details['license_proof']) && $drivers_details['license_proof']!='')?DRIVER_DOCU.$drivers_details['license_proof']:IMAGES."placeholder.jpg";?>" alt="Driving License"> 
                <embed type="application/pdf" background-color="0xFF525659" alt="Driving License" class="Simg_license_proof" src="<?php echo (isset($drivers_details['license_proof']) && $drivers_details['license_proof']!='')?DRIVER_DOCU.$drivers_details['license_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                    </div>
                    <div class="form-group dc_img col-sm-3">
                      <label for="" class="cform-control-label">Badge</label>
                      <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="badge_proof" name="badge_proof">
                      <img class="Simg_badge_proof <?php echo (@end(explode('.', $drivers_details['badge_proof']))=='pdf')?"hide":"";?>"  src="<?php echo (isset($drivers_details['badge_proof']) && $drivers_details['badge_proof']!='')?DRIVER_DOCU.$drivers_details['badge_proof']:IMAGES."placeholder.jpg";?>" alt="Badge"> 
                <embed type="application/pdf" background-color="0xFF525659" alt="Badge" class="Simg_badge_proof" src="<?php echo (isset($drivers_details['badge_proof']) && $drivers_details['badge_proof']!='')?DRIVER_DOCU.$drivers_details['badge_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                    </div>
                    <div class="form-group dc_img col-sm-3">
                      <label for="" class="cform-control-label">Display Card</label>
                      <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="display_card_proof" name="display_card_proof">
                      <img class="Simg_display_card_proof <?php echo (@end(explode('.', $drivers_details['display_card_proof']))=='pdf')?"hide":"";?>"  src="<?php echo (isset($drivers_details['display_card_proof']) && $drivers_details['display_card_proof']!='')?DRIVER_DOCU.$drivers_details['display_card_proof']:IMAGES."placeholder.jpg";?>" alt="Display Card"> 
                <embed type="application/pdf" background-color="0xFF525659" alt="Display Card" class="Simg_display_card_proof" src="<?php echo (isset($drivers_details['display_card_proof']) && $drivers_details['display_card_proof']!='')?DRIVER_DOCU.$drivers_details['display_card_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                    </div>
                    <div class="form-group dc_img col-sm-3">
                      <label for="" class="cform-control-label">Aadhaar</label>
                      <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="aadaar_card_proof" name="aadaar_card_proof">
                      <img class="Simg_aadaar_card_proof <?php echo (@end(explode('.', $drivers_details['aadaar_card_proof']))=='pdf')?"hide":"";?>"  src="<?php echo (isset($drivers_details['aadaar_card_proof']) && $drivers_details['aadaar_card_proof']!='')?DRIVER_DOCU.$drivers_details['aadaar_card_proof']:IMAGES."placeholder.jpg";?>" alt="Aadhaar"> 
                <embed type="application/pdf" background-color="0xFF525659" alt="Aadhaar" class="Simg_aadaar_card_proof" src="<?php echo (isset($drivers_details['aadaar_card_proof']) && $drivers_details['aadaar_card_proof']!='')?DRIVER_DOCU.$drivers_details['aadaar_card_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                    </div>
                    <div class="form-group dc_img col-sm-3">
                      <label for="" class="cform-control-label">PVC</label>
                      <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="pvc_proof" name="pvc_proof">
                      <img class="Simg_pvc_proof <?php echo (@end(explode('.', $drivers_details['pvc_proof']))=='pdf')?"hide":"";?>"  src="<?php echo (isset($drivers_details['pvc_proof']) && $drivers_details['pvc_proof']!='')?DRIVER_DOCU.$drivers_details['pvc_proof']:IMAGES."placeholder.jpg";?>" alt="PVC"> 
                <embed type="application/pdf" background-color="0xFF525659" alt="PVC" class="Simg_pvc_proof" src="<?php echo (isset($drivers_details['pvc_proof']) && $drivers_details['pvc_proof']!='')?DRIVER_DOCU.$drivers_details['pvc_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                    </div>
                    <div class="form-group dc_img col-sm-3">
                      <label for="" class="cform-control-label">BGV</label>
                      <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="bgv_proof" name="bgv_proof">
                      <img class="Simg_bgv_proof <?php echo (@end(explode('.', $drivers_details['bgv_proof']))=='pdf')?"hide":"";?>"  src="<?php echo (isset($drivers_details['bgv_proof']) && $drivers_details['bgv_proof']!='')?DRIVER_DOCU.$drivers_details['bgv_proof']:IMAGES."placeholder.jpg";?>" alt="BGV"> 
                <embed type="application/pdf" background-color="0xFF525659" alt="BGV" class="Simg_bgv_proof" src="<?php echo (isset($drivers_details['bgv_proof']) && $drivers_details['bgv_proof']!='')?DRIVER_DOCU.$drivers_details['bgv_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                    </div>


                    <div class="form-group m-t-md">
                      <div class="col-xs-12 text-center">
                        <button type="submit" name="submit" id="submit" value="Add" class="btn btn-primary"><?php echo ($this->uri->segment(3)!='')?"Edit":"Add";?> Driver</button>
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
    </div>
    <!-- / -->

      <!--footer-->
   <?php //$this->load->view('footer');?>
   <!--footer-->