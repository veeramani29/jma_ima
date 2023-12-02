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
                  <h2>  <?php echo ($this->uri->segment(3)!='')?"Edit":"Add";?> Tariff</h2>
                  <small>By filling all form details of Tariff, Tariff will be shown in the list of Company's.</small>
                </div>
                <div class="box-divider m-a-0"></div>
                <div class="box-body row">

                    <?php echo validation_errors('<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');  ?>

                       <?php echo (isset($error_msg) && $error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
             <?php echo (isset($success_msg) && $success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>

                  <form ui-jp="parsley" method="post" enctype="multipart/form-data" at_form role="form">



   <?php

                    if ($this->uri->segment(3)!='') {
                  $company_name=$tariff_details['company_name'];
                  $vehicle_category=$tariff_details['vehicle_category'];
                  $package_type=$tariff_details['package_type'];
                  $combany_base_rate=$tariff_details['combany_base_rate'];
                  $cab_base_rate=$tariff_details['cab_base_rate'];
                  $combany_extra_hr_rate=$tariff_details['combany_extra_hr_rate'];
                  $cab_extra_hr_rate=$tariff_details['cab_extra_hr_rate'];
                  $combany_extra_km_rate=$tariff_details['combany_extra_km_rate'];
                  $cab_extra_km_rate=$tariff_details['cab_extra_km_rate'];
                  $company_outstn_km_rate=$tariff_details['company_outstn_km_rate'];
                  $cab_outstn_km_rate=$tariff_details['cab_outstn_km_rate'];
                  $company_batta=$tariff_details['company_batta'];
                  $cab_batta=$tariff_details['cab_batta'];
                  $company_outstation_batta=$tariff_details['company_outstation_batta'];
                  $cab_outstation_batta=$tariff_details['cab_outstation_batta'];

                        
                    } else {
                $company_name=set_value('company_name');
                $vehicle_category=set_value('vehicle_category');
                $package_type=set_value('package_type');
                $combany_base_rate=set_value('combany_base_rate');
                $cab_base_rate=set_value('cab_base_rate');
                $combany_extra_hr_rate=set_value('combany_extra_hr_rate');
                $cab_extra_hr_rate=set_value('cab_extra_hr_rate');
                $combany_extra_km_rate=set_value('combany_extra_km_rate');
                $cab_extra_km_rate=set_value('cab_extra_km_rate');
                $company_outstn_km_rate=set_value('company_outstn_km_rate');
                $cab_outstn_km_rate=set_value('cab_outstn_km_rate');
                $company_batta=set_value('company_batta');
                $cab_batta=set_value('cab_batta');
                $company_outstation_batta=set_value('company_outstation_batta');
                $cab_outstation_batta=set_value('cab_outstation_batta');
                       
                    }
                   ?>




                 
                    <div class="form-group col-sm-4">
                      <label for="" class="cform-control-label">Company Name <small>*</small></label>
                      <select required=""  id="company_name" name="company_name" class="form-control">
                         <option>Select Company</option>
                        <?php if(!empty($all_companies['results'])){ foreach ($all_companies['results'] as $key => $Combvalue) { ?>
                       <option value="<?php echo $Combvalue['id']; ?>" <?php  if($Combvalue['id']==$company_name){ echo "selected"; } ?>><?php echo $Combvalue['name']; ?></option>
                       <?php  }} ?>
                      </select>
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="" class="cform-control-label">Vehicle Category <small>*</small></label>
                      <select required="" id="vehicle_category" name="vehicle_category" class="form-control">
                         <option>Select Vehicle Category</option>

                         <?php if(!empty($allVehicle_Categories['results'])){ foreach ($allVehicle_Categories['results'] as $key => $Catvalue) { ?>
                       <option value="<?php echo $Catvalue['id']; ?>" <?php  if($Catvalue['id']==$vehicle_category){ echo "selected"; } ?>><?php echo $Catvalue['cate_name']; ?></option>
                       <?php  }} ?>
                    
                      </select>
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="" class="cform-control-label">Package type <small>*</small></label>
                      <select required="" id="package_type" name="package_type" class="form-control">
                       <option>Select Package type</option>
                        <option value="1">1</option>
                      </select>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="box-header col-xs-12">
                          <h2>Lables</h2>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="box-header col-xs-12">
                          <h2>Comapny Fare</h2>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="box-header col-xs-12">
                          <h2>Cabs Fare</h2>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group col-xs-12">
                          <label for=""  class="cform-control-label af_label">Base Rate <small>*</small></label>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input required="" type="text" class="form-control Onumber" id="combany_base_rate" name="combany_base_rate"  value="<?php echo $combany_base_rate; ?>" placeholder="base rate">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input required="" type="text" class="form-control Onumber" id="cab_base_rate" name="cab_base_rate"  value="<?php echo $cab_base_rate; ?>" placeholder="base rate">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group col-xs-12">
                          <label for="" class="cform-control-label af_label">Extra hr rate</label>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input type="text" class="form-control Onumber" id="combany_extra_hr_rate" name="combany_extra_hr_rate"  value="<?php echo $combany_extra_hr_rate; ?>" placeholder="Extra hr rate">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input type="text" class="form-control Onumber" id="cab_extra_hr_rate" name="cab_extra_hr_rate"  value="<?php echo $cab_extra_hr_rate; ?>" placeholder="Extra hr rate">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group col-xs-12">
                          <label for="" class="cform-control-label af_label">Extra km rate</label>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input type="text" class="form-control Onumber" id="combany_extra_km_rate" name="combany_extra_km_rate"  value="<?php echo $combany_extra_km_rate; ?>" placeholder="extra km rate">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input type="text" class="form-control Onumber" id="cab_extra_km_rate" name="cab_extra_km_rate"  value="<?php echo $cab_extra_km_rate; ?>" placeholder="extra km rate">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group col-xs-12">
                          <label for="" class="cform-control-label af_label">Outstation km rate</label>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input type="text" class="form-control Onumber" id="company_outstn_km_rate" name="company_outstn_km_rate"  value="<?php echo $company_outstn_km_rate; ?>" placeholder="outstation km rate">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input type="text" class="form-control Onumber" id="cab_outstn_km_rate" name="cab_outstn_km_rate"  value="<?php echo $cab_outstn_km_rate; ?>" placeholder="outstation km rate">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group col-xs-12">
                          <label for="" class="cform-control-label af_label">Night batta</label>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input type="text" class="form-control Onumber" id="company_batta" name="company_batta"  value="<?php echo $company_batta; ?>" placeholder="night batta">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input type="text" class="form-control Onumber" id="cab_batta" name="cab_batta"  value="<?php echo $cab_batta; ?>" placeholder="outstation batta">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group col-xs-12">
                          <label for="" class="cform-control-label af_label">Outstation batta</label>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input type="text" class="form-control Onumber" id="company_outstation_batta" name="company_outstation_batta"  value="<?php echo $company_outstation_batta; ?>" placeholder="outstation batta">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group col-xs-12">
                          <input type="text" class="form-control Onumber" id="cab_outstation_batta" name="cab_outstation_batta"  value="<?php echo $cab_outstation_batta; ?>" placeholder="outstation batta">
                        </div>
                      </div>
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