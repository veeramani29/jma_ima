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
              <h2>  <?php echo ($this->uri->segment(3)!='')?"Edit":"Add";?> Cabs</h2>
              <small>By filling all form details of vehicles, drivers will be shown in the list of cab's.</small>
            </div>
            <div class="box-divider m-a-0"></div>
            <div class="box-body row">
              <?php echo validation_errors('<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');  ?>
              <?php echo (isset($error_msg) && $error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
              <?php echo (isset($success_msg) && $success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>
              <form ui-jjp="parsley" data-parsley-validate method="post" enctype="multipart/form-data" role="form">
                <?php
                if ($this->uri->segment(3)!='') {
                  $notes=$cabs_details['cab_notes'];
                  $induction_status=$cabs_details['induction_status'];
                  $driver=$cabs_details['driver'];
                  $vehicle=$cabs_details['vehicle'];
                  $ride_status=$cabs_details['ride_status'];
                  $removed_date=$cabs_details['removed_date'];
                  $induction_date=$cabs_details['induction_date'];
                } else {
                  $notes=set_value('notes');
                  $induction_status=set_value('induction_status');
                  $driver=set_value('driver');
                  $vehicle=set_value('vehicle');
                  $ride_status=set_value('ride_status');
                  $removed_date=set_value('removed_date');
                  $induction_date=set_value('induction_date');
                } ?>
                <div class="form-group col-sm-2">
                  <label class="" for="">Vehicle Number <small>*</small></label>
                  <select id="vehicle" name="vehicle" required=""   class="form-control select2" ui-jp="select2"   ui-options="{theme: 'bootstrap',  selectOnBlur: true,  tags: true}">
                    <option value=""></option>
                    <?php if($all_vehicles['num_rows']>0) { $all_vehicles=($all_vehicles['results']); foreach ($all_vehicles as $key => $value) { ?>
                    <option <?php  if($vehicle==$value['id']){ echo "selected"; } ?>  value="<?php echo $value['id'];?>"><?php echo $value['Vnumber'];?></option>
                    <?php } } ?>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label class="" for="">Driver Name <small>*</small></label>
                  <select id="driver" name="driver" required=""   class="form-control select2" ui-jp="select2"   ui-options="{theme: 'bootstrap',  selectOnBlur: true,  tags: true}">
                    <option value=""></option>
                    <?php if($all_drivers['num_rows']>0) { $all_drivers=$all_drivers['results']; foreach ($all_drivers as $key => $value) { ?>
                    <option <?php  if($driver==$value['id']){ echo "selected"; } ?>  value="<?php echo $value['id'];?>"><?php echo $value['first_name'];?></option>
                    <?php } } ?>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label class="" for="">Induction Status</label>
                  <select id="induction_status" name="induction_status"   class="form-control ">
                    <option value="">Select Induction Status</option>
                    <option <?php  if($induction_status=='Not Inducted'){ echo "selected"; } ?> value="Not Inducted">Not Inducted</option>
                    <option <?php  if($induction_status=='Inducted'){ echo "selected"; } ?> value="Inducted">Inducted</option>
                    <option <?php  if($induction_status=='Removed'){ echo "selected"; } ?> value="Removed">Removed</option>
                    
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label class="" for="">Ride Status</label>
                  <select id="ride_status" name="ride_status"   class="form-control">
                    <option value="">Select Ride Status</option>
                    <option <?php  if($ride_status=='Running'){ echo "selected"; } ?> value="Running">Running</option>
                    <option <?php  if($ride_status=='Available'){ echo "selected"; } ?> value="Available">Available</option>
                    <option <?php  if($ride_status=='On Leave'){ echo "selected"; } ?> value="On Leave">On Leave</option>
                  </select>
                </div>
                <div class="form-group col-sm-4">
                  <label for="" class="cform-control-label">Notes</label>
                  <textarea class="form-control" name="notes" id="notes"   placeholder="Enter Note about Vehicles here"><?php echo $notes;?></textarea>
                </div>
                <div class="box-header col-xs-12">
                  <h2> Dates</h2>
                </div>
                <div class="form-group col-sm-3">
                  <label for="" class="cform-control-label">Induction Date</label>
                  <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',maxDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                    <input  value="<?php echo $induction_date;?>" name="induction_date" id="induction_date"  type='text' class="form-control" />
                    <span class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="form-group col-sm-3">
                  <label for="" class="cform-control-label">Removal Date</label>
                  <div class='input-group date' ui-jp="datetimepicker" ui-options="{format: 'YYYY-MM-DD',minDate:new Date(), icons: {time: 'fa fa-clock-o', date: 'fa fa-calendar', up: 'fa fa-chevron-up', down: 'fa fa-chevron-down', previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right', today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'} }">
                    <input value="<?php echo $removed_date;?>" name="removed_date" id="removed_date"  type='text' class="form-control" />
                    <span class="input-group-addon">
                      <span class="fa fa-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="form-group m-t-md">
                  <div class="col-xs-12 text-center">
                    <button type="submit" name="submit" id="submit" value="Add" class="btn btn-primary"><?php echo ($this->uri->segment(3)!='')?"Update":"Add";?> </button>
                  </div>
                </div>
                <br>
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
<script type="text/javascript">
function addZero(){
  var deg = document.getElementById("Vnumber").value;
  if(deg.length<4){
    var deg1 =(deg.length==3)?('0' + deg):('00' + deg);
    document.getElementById("Vnumber").value=deg1;
  }
}
</script>