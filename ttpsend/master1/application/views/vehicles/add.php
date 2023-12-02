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
              <h2>  <?php echo ($this->uri->segment(3)!='')?"Edit":"Add";?> Vehicle</h2>
              <small>By filling all form details of vehicles, vehicles will be shown in the list of vehicles's.</small>
            </div>
            <div class="box-divider m-a-0"></div>
            <div class="box-body row">
              <?php echo validation_errors('<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');  ?>
              <?php echo (isset($error_msg) && $error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
              <?php echo (isset($success_msg) && $success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>
              <form ui-jjp="parsley" data-parsley-validate method="post" enctype="multipart/form-data" role="form">
                <?php
                $type_Arr=array_unique(array_filter(array_column($vehicles_assets['results'], 'type')));
                $brand_Arr=array_unique(array_filter(array_column($vehicles_assets['results'], 'brand')));
                $exterior_color_Arr=array_unique(array_filter(array_column($vehicles_assets['results'], 'exterior_color')));
                $interior_color_Arr=array_unique(array_filter(array_column($vehicles_assets['results'], 'interior_color')));
                if ($this->uri->segment(3)!='') {
                  $state_code=$vehicles_details['state_code'];
                  $rto_code=$vehicles_details['rto_code'];
                  $rto_code_=$vehicles_details['rto_code_'];
                  $Vnumber=$vehicles_details['Vnumber'];
                  $type=$vehicles_details['type'];
                  $seating=$vehicles_details['seating'];
                  $brand=$vehicles_details['brand'];
                  $exterior_color=$vehicles_details['exterior_color'];
                  $interior_color=$vehicles_details['interior_color'];
                  $Fecilities=@explode(",", $vehicles_details['Fecilities']);
                  $notes=$vehicles_details['notes'];
                  $reg_date=$vehicles_details['reg_date'];
                  $insurance_exp_date=$vehicles_details['insurance_exp_date'];
                  $tax_exp_date=$vehicles_details['tax_exp_date'];
                  $poll_exp_date=$vehicles_details['poll_exp_date'];
                  $permit_exp_date=$vehicles_details['permit_exp_date'];
                  $fitness_exp_date=$vehicles_details['fitness_exp_date'];
                  $model=$vehicles_details['model'];
                } else {
                  $state_code=set_value('state_code');
                  $rto_code=set_value('rto_code');
                  $rto_code_=set_value('rto_code_');
                  $Vnumber=set_value('Vnumber');
                  $type=set_value('type');
                  $seating=set_value('seating');
                  $brand=set_value('brand');
                  $exterior_color=set_value('exterior_color');
                  $interior_color=set_value('interior_color');
                  $Fecilities=set_value('Fecilities');
                  $notes=set_value('notes');
                  $reg_date=set_value('reg_date');
                  $insurance_exp_date=set_value('insurance_exp_date');
                  $tax_exp_date=set_value('tax_exp_date');
                  $poll_exp_date=set_value('poll_exp_date');
                  $permit_exp_date=set_value('permit_exp_date');
                  $fitness_exp_date=set_value('fitness_exp_date');
                  $model=set_value('model');
                } ?>
                <?php if ($this->uri->segment(3)!='') { ?>
                 <input type="hidden" name="hdnoldfile" value="<?php echo isset($vehicles_details)?$vehicles_details['logo']:''; ?>" >
                <input type="hidden" name="hdnrccert" value="<?php echo isset($vehicles_details)?$vehicles_details['rc_proof']:''; ?>" >

                 
                  <input type="hidden" name="hdninsurancecert" value="<?php echo isset($vehicles_details)?$vehicles_details['insurance_proof']:''; ?>" >
                   <input type="hidden" name="hdntaxcert" value="<?php echo isset($vehicles_details)?$vehicles_details['tax_proof']:''; ?>" >
                    <input type="hidden" name="hdnfitnesscert" value="<?php echo isset($vehicles_details)?$vehicles_details['fitness_proof']:''; ?>" >
                     <input type="hidden" name="hdnemissioncert" value="<?php echo isset($vehicles_details)?$vehicles_details['emission_proof']:''; ?>" >
                      <input type="hidden" name="hdnpermitcertfile" value="<?php echo isset($vehicles_details)?$vehicles_details['permit_proof']:''; ?>" >
                <?php } ?>
                <div class="form-group col-sm-3">
                  <label for="logo" class="cform-control-label">Car  Photo</label>
                  <input  <?php if ($this->uri->segment(3)=='') { ?> <?php } ?> type="file" class="form-control" id="logo" name="logo" placeholder="Company Logo">
                </div>
                <?php if ($this->uri->segment(3)!='') { ?>
                <div class="form-group col-sm-3">
                  <img src="<?php echo ($vehicles_details['logo']!=null)?VECHICLE_SMLIMG.$vehicles_details['logo']:LOGO; ?>" alt="<?php echo isset($vehicles_details)?$vehicles_details['Vnumber']:''; ?>" class="w-40">
                </div>
                <?php } ?>
                <div class="form-group col-md-5">
                  <label for="" class="cform-control-label">Vehicle Registration No <small>*</small></label>
                  <div class="av_numfor">
                    <div class="col-sm-3">
                      <select class="form-control" name="state_code" id="state_code" required>
                        <option <?php  if($state_code=='KA'){ echo "selected"; } ?> value="KA">KA</option>
                        <option <?php  if($state_code=='TN'){ echo "selected"; } ?> value="TN">TN</option>
                      </select>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" size="2" onpaste="return false;"  maxlength="2" required="" value="<?php echo $rto_code; ?>" id="rto_code" name="rto_code" class="form-control col-sm-3 Onumber" id="" placeholder="RTO code">
                    </div>
                    <div class="col-sm-3">
                      <input type="text" size="2" onpaste="return false;"  style='text-transform:uppercase' maxlength="2" required="" value="<?php echo $rto_code_; ?>" id="rto_code_" name="rto_code_" class="form-control col-sm-3 txtOnly" id="" placeholder="RTO code2">
                    </div>
                    <div class="col-sm-3">
                      <input required="" onblur="addZero(this);" onpaste="return false;"  value="<?php echo $Vnumber; ?>" type="text" id="Vnumber" name="Vnumber" class="form-control col-sm-3 Onumber" size="4" maxlength="4" placeholder="Number">
                    </div>
                  </div>
                </div>
                <div class="form-group col-sm-2">
                  <label for="name" class="cform-control-label">Vehicle Type</label>
                  <select id="type" name="type"   class="form-control select2-multiple" ui-jp="select2"   ui-options="{theme: 'bootstrap',  selectOnBlur: true,  tags: true}">
                    <option value=""></option>
                    <?php foreach ($type_Arr as $key => $value) { ?>
                    <option <?php  if($type==$value){ echo "selected"; } ?> value="<?php echo $value;?>"><?php echo $value;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label for="" class="cform-control-label">Model</label>
                  <select  name="model" id="model" class="form-control">
                    <?php for ($i=2000; $i <2500 ; $i++) { ?>
                    <option value="<?php echo $i;?>" <?php  if($model==$i){ echo "selected"; } ?>><?php echo $i;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label for="person_name" class="cform-control-label">Seating</label>
                  <input   type="number" min="0" class="form-control Onumber" value="<?php echo $seating; ?>" id="seating" name="seating" placeholder="Seating">
                </div>
                <div class="form-group col-sm-2">
                  <label for="number" class="cform-control-label">Brand</label>
                  <select id="brand" name="brand"   class="form-control select2" ui-jp="select2"   ui-options="{theme: 'bootstrap',  selectOnBlur: true,  tags: true}">
                    <option value=""></option>
                    <?php foreach ($brand_Arr as $key => $value) { ?>
                    <option <?php  if($brand==$value){ echo "selected"; } ?> value="<?php echo $value;?>"><?php echo $value;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label for="number" class="cform-control-label">Exterior Color</label>
                  <select id="exterior_color" name="exterior_color"   class="form-control select2" ui-jp="select2"   ui-options="{theme: 'bootstrap',  selectOnBlur: true,  tags: true}">
                    <option value=""></option>
                    <?php foreach ($exterior_color_Arr as $key => $value) { ?>
                    <option <?php  if($exterior_color==$value){ echo "selected"; } ?> value="<?php echo $value;?>"><?php echo $value;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label for="number" class="cform-control-label">Interior Color</label>
                  <select id="interior_color" name="interior_color"   class="form-control select2" ui-jp="select2"   ui-options="{theme: 'bootstrap',  selectOnBlur: true,  tags: true}">
                    <option value=""></option>
                    <?php foreach ($interior_color_Arr as $key => $value) { ?>
                    <option <?php  if($interior_color==$value){ echo "selected"; } ?> value="<?php echo $value;?>"><?php echo $value;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group col-sm-6">
                  <label for="" class="cform-control-label">Notes</label>
                  <textarea class="form-control" name="notes" id="notes" rows="2"  placeholder="Enter Note about Vehicles here"><?php echo $notes;?></textarea>
                </div>
                <div class="box-header col-xs-12">
                  <h2>Fecilities</h2>
                </div>
                <div class="form-group col-sm-6">
                  <div class="checkbox">
                    <label class="checkbox-inline ">
                      <input name="Fecilities[]"  <?php  if(@in_array('AC', $Fecilities)){ echo "checked"; } ?> id="FecilitiesAC" type="checkbox" value="AC">
                      <i class="dark-white"></i>
                      AC
                    </label>
                    <label class="checkbox-inline ">
                      <input name="Fecilities[]"  <?php  if(@in_array('GPS', $Fecilities)){ echo "checked"; } ?> id="FecilitiesGPS" type="checkbox" value="GPS">
                      <i class="dark-white"></i>
                      GPS
                    </label>
                    <label class="checkbox-inline ">
                      <input name="Fecilities[]"  <?php  if(@in_array('Panic button', $Fecilities)){ echo "checked"; } ?> id="FecilitiesPanic" type="checkbox" value="Panic button">
                      <i class="dark-white"></i>
                      Panic button
                    </label>
                    <label class="checkbox-inline">
                      <input name="Fecilities[]"  <?php  if(@in_array('TV', $Fecilities)){ echo "checked"; } ?> id="FecilitiesTV" type="checkbox" value="TV">
                      <i class="dark-white"></i>
                      TV
                    </label>
                    <label class="checkbox-inline">
                      <input name="Fecilities[]" id="FecilitiesWIFI" <?php  if(@in_array('WIFI', $Fecilities)){ echo "checked"; } ?> type="checkbox" value="WIFI">
                      <i class="dark-white"></i>
                      WIFI
                    </label>
                  </div>
                </div>
                <div class="box-header col-xs-12">
                  <h2>Document Expiry Dates</h2>
                </div>
                <div class="form-group col-sm-3">
                  <label for="" class="cform-control-label">Registration Date</label>
                  <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',maxDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                    <input  value="<?php echo $reg_date;?>" name="reg_date" id="reg_date"  type='text' class="form-control" />
                    <span class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="form-group col-sm-3">
                  <label for="" class="cform-control-label">Insurance Expiry Date</label>
                  <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                    <input value="<?php echo $insurance_exp_date;?>" name="insurance_exp_date" id="insurance_exp_date"  type='text' class="form-control" />
                    <span class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="form-group col-sm-3">
                  <label for="" class="cform-control-label">Road Tax Expiry Date</label>
                  <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                    <input value="<?php echo $tax_exp_date;?>" name="tax_exp_date" id="tax_exp_date"  type='text' class="form-control" />
                    <span class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="form-group col-sm-3">
                  <label for="" class="cform-control-label">Pollution Certificate Expiry Date</label>
                  <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                    <input value="<?php echo $poll_exp_date;?>"  name="poll_exp_date" id="poll_exp_date"  type='text' class="form-control" />
                    <span class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="form-group col-sm-3">
                  <label for="" class="cform-control-label">Commercial Permit Expiry Date</label>
                  <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                    <input value="<?php echo $permit_exp_date;?>"  name="permit_exp_date" id="permit_exp_date"  type='text' class="form-control" />
                    <span class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="form-group col-sm-3">
                  <label for="" class="cform-control-label">Fitness Expiry Date</label>
                  <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                    <input value="<?php echo $fitness_exp_date;?>"  name="fitness_exp_date" id="permit_exp_date"  type='text' class="form-control" />
                    <span class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="box-header col-xs-12">
                  <h2>Document Copies</h2>
                </div>
                <div class="form-group dc_img col-sm-3">
                  <label for="" class="cform-control-label">Registration Certificate (RC)</label>
			  
                  <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="rccert" name="rccert">
               <img class="Simg_rccert <?php echo (@end(explode('.', $vehicles_details['rc_proof']))=='pdf')?"hide":"";?>"  src="<?php echo (isset($vehicles_details['rc_proof']) && $vehicles_details['rc_proof']!='')?VECHICLE_DOCU.$vehicles_details['rc_proof']:IMAGES."placeholder.jpg";?>" alt="Registration Certificate (RC)"> 
                <embed type="application/pdf" background-color="0xFF525659" alt="Registration Certificate (RC)" class="Simg_rccert" src="<?php echo (isset($vehicles_details['rc_proof']) && $vehicles_details['rc_proof']!='')?VECHICLE_DOCU.$vehicles_details['rc_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                </div>
                <div class="form-group dc_img col-sm-3">
                  <label for="" class="cform-control-label">Tax</label>
                  <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="taxcert" name="taxcert"> 
                  <img class="Simg_taxcert <?php echo (@end(explode('.', $vehicles_details['tax_proof']))=='pdf')?"hide":"";?>"  src="<?php echo (isset($vehicles_details['tax_proof']) && $vehicles_details['tax_proof']!='')?VECHICLE_DOCU.$vehicles_details['tax_proof']:IMAGES."placeholder.jpg";?>" alt="Tax">
                    <embed type="application/pdf" background-color="0xFF525659" alt="Tax" class="Simg_taxcert" src="<?php echo (isset($vehicles_details['tax_proof']) && $vehicles_details['tax_proof']!='')?VECHICLE_DOCU.$vehicles_details['tax_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                </div>
                <div class="form-group dc_img col-sm-3">
                  <label for="" class="cform-control-label">Insurance</label>
                  <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="insurancecert" name="insurancecert">
                  <img class="Simg_insurancecert <?php echo (@end(explode('.', $vehicles_details['insurance_proof']))=='pdf')?"hide":"";?>" id="insuranceimg" src="<?php echo (isset($vehicles_details['insurance_proof']) && $vehicles_details['insurance_proof']!='')?VECHICLE_DOCU.$vehicles_details['insurance_proof']:IMAGES."placeholder.jpg";?>" alt="Insurance">
                        <embed type="application/pdf" background-color="0xFF525659" alt="Insurance" class="Simg_insurancecert" src="<?php echo (isset($vehicles_details['insurance_proof']) && $vehicles_details['insurance_proof']!='')?VECHICLE_DOCU.$vehicles_details['insurance_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                </div>
                <div class="form-group dc_img col-sm-3">
                  <label for="" class="cform-control-label">Fitness Certificate</label>
                  <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="fitnesscert" name="fitnesscert">
                  <img class="Simg_fitnesscert <?php echo (@end(explode('.', $vehicles_details['fitness_proof']))=='pdf')?"hide":"";?>" id="fitnessimg" src="<?php echo (isset($vehicles_details['fitness_proof']) && $vehicles_details['fitness_proof']!='')?VECHICLE_DOCU.$vehicles_details['fitness_proof']:IMAGES."placeholder.jpg";?>" alt="Fitness Certificate">

                   <embed type="application/pdf" background-color="0xFF525659" alt="Fitness" class="Simg_fitnesscert" src="<?php echo (isset($vehicles_details['fitness_proof']) && $vehicles_details['fitness_proof']!='')?$vehicles_details['fitness_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                </div>
                <div class="form-group dc_img col-sm-3">
                  <label for="" class="cform-control-label">Emission Certificate</label>
                  <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*"  id="emissioncert" name="emissioncert">
                  <img class="Simg_emissioncert <?php echo (@end(explode('.', $vehicles_details['emission_proof']))=='pdf')?"hide":"";?>" id="emissionimg" src="<?php echo (isset($vehicles_details['emission_proof']) && $vehicles_details['emission_proof']!='')?VECHICLE_DOCU.$vehicles_details['emission_proof']:IMAGES."placeholder.jpg";?>" alt="Emission Certificate">
                  <embed type="application/pdf" background-color="0xFF525659" alt="Emission" class="Simg_emissioncert" src="<?php echo (isset($vehicles_details['emission_proof']) && $vehicles_details['emission_proof']!='')?VECHICLE_DOCU.$vehicles_details['emission_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>


                    

                </div>
                <div class="form-group dc_img col-sm-3">
                  <label for="" class="cform-control-label">Permit</label>
                  <input type="file" class="form-control Uimg" accept="application/pdf,.pdf,image/*" id="permitcert" name="permitcert">
                   <img class="Simg_permitcert <?php echo (@end(explode('.', $vehicles_details['permit_proof']))=='pdf')?"hide":"";?>" id="permitimg" src="<?php echo (isset($vehicles_details['permit_proof']) && $vehicles_details['permit_proof']!='')?VECHICLE_DOCU.$vehicles_details['permit_proof']:IMAGES."placeholder.jpg";?>" alt="Permit "> 
                  <embed class="Simg_permitcert" type="application/pdf" background-color="0xFF525659" alt="Permit" src="<?php echo (isset($vehicles_details['permit_proof']) && $vehicles_details['permit_proof']!='')?VECHICLE_DOCU.$vehicles_details['permit_proof']:IMAGES."placeholder.jpg";?>" width="100%"/>
                </div>
                <div class="form-group m-t-md">
                  <div class="col-xs-12 text-center">
                    <button type="submit" name="submit" id="submit" value="Add" class="btn btn-primary"><?php echo ($this->uri->segment(3)!='')?"Update":"Add";?> </button>
                  </div>
                </div>
                <br>
              </form>
               </div>
              <?php if($this->uri->segment(3)!=''){ ?>
                  <br>
                      <br/>
              <div class="row">
                <div class="form-group col-xs-12">
                  <form enctype="multipart/form-data" action="<?php echo HOST_ADMIN;?>vehicles/dropzone" class="dropzone white dz-clickable">
                    <input type="hidden" name="vehicle_id" value="<?php echo ($this->uri->segment(3)!='')?$this->uri->segment(3):"";?>">
                    <div class="dz-message dz-clickable" ui-jp="dropzone" ui-options="{ url: '<?php echo HOST_ADMIN;?>vehicles/dropzone' }">

                      <h4 class="m-t-lg m-b-md">Drop Photos here or click to upload.</h4>
                      <span class="text-muted block m-b-lg">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                    </div>
                  </form>
                </div>
              </div>
              <?php } ?>
           
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
<script type="text/javascript">
function addZero(){
  var deg = document.getElementById("Vnumber").value;
  if(deg.length<4){
    var deg1 =(deg.length==3)?('0' + deg):('00' + deg);
    document.getElementById("Vnumber").value=deg1;
  }
}
</script>