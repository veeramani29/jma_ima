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
                  <h2>  <?php echo ($this->uri->segment(3)!='')?"Edit":"Add";?> Company</h2>
                  <small>By filling all form details of Company, Company will be shown in the list of Company's.</small>
                </div>
                <div class="box-divider m-a-0"></div>
                <div class="box-body row">

                    <?php echo validation_errors('<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');  ?>

                       <?php echo (isset($error_msg) && $error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
             <?php echo (isset($success_msg) && $success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>

                  <form ui-jp="parsley" method="post" enctype="multipart/form-data" role="form">



   <?php

                    if ($this->uri->segment(3)!='') {
                        $name=$company_details['name'];
                        $person_name=$company_details['person_name'];
                        $number=$company_details['number'];
                        $address=$company_details['address'];

                        $short_name=$company_details['short_name'];
                        $dispaly_name=$company_details['dispaly_name'];
                        $notes=$company_details['notes'];
                        $tariffs=$company_details['tariffs'];
                        $map_location=$company_details['map_location'];
                        $gstin=$company_details['gstin'];
                        $website=$company_details['website'];
                        $email=$company_details['email'];
                        $contract_status=$company_details['contract_status'];
                        $agreement_date=$company_details['agreement_date'];
                        $agreement_exp_date=$company_details['agreement_exp_date'];

                        $garage_place=$company_details['garage_place'];
                        $garage_location=$company_details['garage_location'];
                        $garage_distance=$company_details['garage_distance'];
                       # $address=$company_details['address'];



                        
                    } else {
                        $name=set_value('name');
                        $person_name=set_value('person_name');
                        $number=set_value('number');
                        $address=set_value('address');

                    $short_name=set_value('short_name');
                    $dispaly_name=set_value('dispaly_name');
                    $notes=set_value('notes');
                    $tariffs=set_value('tariffs');
                    $map_location=set_value('map_location');
                    $gstin=set_value('gstin');
                    $website=set_value('website');
                    $email=set_value('email');
                    $contract_status=set_value('contract_status');
                    $agreement_date=set_value('agreement_date');
                    $agreement_exp_date=set_value('agreement_exp_date');

                     $garage_place=set_value('garage_place');
                      $garage_location=set_value('garage_location');
                      $garage_distance=set_value('garage_distance');
                       
                    }
                   ?>

                     <?php if ($this->uri->segment(3)!='') {
                       ?>
                      <input type="hidden" name="hdnoldfile" value="<?php echo isset($company_details)?$company_details['logo']:''; ?>" >  
                   <?php
                   } ?>
                    <div class="form-group col-sm-3">
                      <label for="logo" class="cform-control-label">Company Logo</label>
                      <input  <?php if ($this->uri->segment(3)=='') {
                       ?>    <?php
                   } ?> type="file" class="form-control" id="logo" name="logo" placeholder="Company Logo">
                    </div>
 <?php if ($this->uri->segment(3)!='') {
                       ?>
                     <div class="form-group col-sm-3">
             <img src="<?php echo ($company_details['logo']!=null)?CMPNY_SMLIMG.$company_details['logo']:LOGO; ?>" alt="<?php echo isset($company_details)?$company_details['name']:''; ?>" class="w-40">
              </div>
    <?php
                   } ?>
                    <div class="form-group col-sm-3">
                      <label for="name" class="cform-control-label">Company name <small>*</small></label>
                      <input required="" type="text" class="form-control" value="<?php echo $name; ?>"  id="name" name="name"  placeholder="Company name">
                    </div>

                       <div class="form-group col-sm-3">
                      <label for="name" class="cform-control-label">Display name <small>*</small></label>
                      <input required="" type="text" class="form-control" value="<?php echo $dispaly_name; ?>"  id="dispaly_name" name="dispaly_name"  placeholder="Display name">
                    </div>


                       <div class="form-group col-sm-3">
                      <label for="name" class="cform-control-label">Short name <small>*</small></label>
                      <input required="" type="text" class="form-control" value="<?php echo $short_name; ?>"  id="short_name" name="short_name"  placeholder="Short name">
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="person_name" class="cform-control-label">Contact Person Name <small>*</small></label>
                      <input   type="text" class="form-control" value="<?php echo $person_name; ?>" id="person_name" name="person_name" placeholder="Contact Person Name">
                    </div>
                    <div class="form-group col-sm-3">
                      <label for="number" class="cform-control-label">Contact Number <small>*</small></label>
                        <input   type="text" class="form-control Onumber" value="<?php echo $number; ?>" id="number" name="number" placeholder="Contact Number">
                    </div>

                     <div class="form-group col-sm-3">
                      <label for="number" class="cform-control-label">Email</label>
                        <input   type="email" class="form-control " value="<?php echo $email; ?>" id="email" name="email" placeholder="Email">
                    </div>

                    <div class="form-group col-sm-3">
                      <label for="number" class="cform-control-label">Website</label>
                        <input   type="url" class="form-control " value="<?php echo $website; ?>" id="website" name="website" placeholder="Website">
                    </div>


                    <div class="form-group col-sm-3">
                      <label for="number" class="cform-control-label">GSTIN</label>
                        <input   type="text" class="form-control " value="<?php echo $gstin; ?>" id="gstin" name="gstin" placeholder="GSTIN">
                    </div>


                    <div class="form-group col-sm-3">
                      <label for="number" class="cform-control-label">Google Maps Location</label>
                        <input   type="url" class="form-control " value="<?php echo $map_location; ?>" id="map_location" name="map_location" placeholder="Map Location">
                    </div>

                   <!--  <div class="form-group col-sm-3">
                      <label for="number" class="cform-control-label">Tariffs</label>
                        <input   type="text" class="form-control " value="<?php echo $tariffs; ?>" id="tariffs" name="tariffs" placeholder="Tariffs">
                    </div> -->


                     <div class="form-group col-sm-2">
                      <label for="" class="cform-control-label">Contract Status</label>
                      <select  name="contract_status" id="contract_status" class="form-control">
                        <option value="Male" <?php  if($contract_status=='Yes'){ echo "selected"; } ?>>Yes</option>
                        <option value="Female" <?php  if($contract_status=='No'){ echo "selected"; } ?>>No</option>
                        <option value="Others" <?php  if($contract_status=='Expired'){ echo "selected"; } ?>>Expired</option>
                      </select>
                    </div>

                    <div class="form-group col-sm-2">
                      <label for="" class="cform-control-label">Agreement Date</label>
                      <div class="input-group date"  ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',  maxDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                        <input  type="text" value="<?php echo $agreement_date; ?>" name="agreement_date" id="agreement_date" class="form-control has-value">
                        <span class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>

                     <div class="form-group col-sm-2">
                      <label for="" class="cform-control-label">Agreement Expiry Date</label>
                      <div class="input-group date"  ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',  minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                        <input type="text" value="<?php echo $agreement_exp_date; ?>" name="agreement_exp_date" id="agreement_exp_date" class="form-control has-value">
                        <span class="input-group-addon">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>


                    <div class="form-group col-xs-4">
                      <label for="address" class="cform-control-label">Address <small>*</small></label>
                        <textarea  id="address" name="address"  class="form-control" rows="2"><?php echo $address; ?></textarea>
                    </div>
                     <div class="form-group col-sm-2">
                      <label for="" class="cform-control-label">Garage Place</label>
                      <select  name="garage_place" id="garage_place" class="form-control">

                        <option value="" >Select Garage Place</option>
                        <option value="Office" <?php  if($garage_place=='Office'){ echo "selected"; } ?>>Office</option>
                        <option value="Company" <?php  if($garage_place=='Company'){ echo "selected"; } ?>>Company</option>
                      
                      </select>
                    </div>

                      <div class="form-group col-sm-3">
                      <label for="number" class="cform-control-label">Garage Location</label>
                        <input   type="text" class="form-control " value="<?php echo $garage_location; ?>" id="garage_location" name="garage_location" placeholder="Location">
                    </div>

                      <div class="form-group col-sm-3">
                      <label for="number" class="cform-control-label">Garage to Company Distance</label>
                        <input   type="text" class="form-control " value="<?php echo $garage_distance; ?>" id="garage_distance" name="garage_distance" placeholder="Distance">
                    </div>

                     <div class="form-group col-xs-12">
                      <label for="address" class="cform-control-label">Notes</label>
                        <textarea  id="notes" name="notes"  class="form-control" rows="2"><?php echo $notes; ?></textarea>
                    </div>
                    <div class="form-group m-t-md">
                      <div class="col-xs-12 text-center">
                        <button type="submit" name="submit" id="submit" value="Add" class="btn btn-primary"><?php echo ($this->uri->segment(3)!='')?"Update":"Add";?> </button>
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