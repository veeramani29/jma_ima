<!--header-->
<?php //$this->load->view('header');?>
<!--header-->
<!--leftmenu-->
<?php $this->load->view('leftmenu');
  $type_Arr=array_unique(array_filter(array_column($vehicles_assets['results'], 'type')));
?>
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

         <?php $error_msg=$this->session->flashdata('error_msg'); echo (isset($error_msg) && $error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?> 

        <div class="box-header">
          <h2>Cabs</h2>
          <small>List of vehicle and drivers</small>
        </div>
        <div  class="alert alert-success text-center hide">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <p id="alertMsg"></p>
        </div>
        <div class="box-body row">
          <div class="col-sm-5">
            Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r"/>
            <select class="input-sm form-control w-xs inline v-middle">
              <option value="0">10</option>
              <option value="1">20</option>
              <option value="2">50</option>
              <option value="3">100</option>
            </select>
          </div>
          <div class="col-sm-7 ft_addfle ">
            <form method="post" action="<?php echo HOST_ADMIN;?>cabs/add_cabs" class="form-inline" role="form">
              <div class="form-group col-sm-3">
                <label class="sr-only" for="">Vehicle Number</label>
                <select id="vehicle" name="vehicle" required=""   class="form-control select2" ui-jp="select2"   ui-options="{theme: 'bootstrap',  selectOnBlur: true,  tags: true}">
                  <option value=""></option>
                  <?php if($all_vehicles['num_rows']>0) { $all_vehicles=($all_vehicles['results']); foreach ($all_vehicles as $key => $value) { ?>
                  <option  value="<?php echo $value['id'];?>"><?php echo $value['Vnumber'];?></option>
                  <?php } } ?>
                </select>
              </div>
              <div class="form-group col-sm-3">
                <label class="sr-only" for="">Driver Name</label>
                <select id="driver" name="driver" required=""   class="form-control select2" ui-jp="select2"   ui-options="{theme: 'bootstrap',  selectOnBlur: true,  tags: true}">
                  <option value=""></option>
                  <?php if($all_drivers['num_rows']>0) { $all_drivers=$all_drivers['results']; foreach ($all_drivers as $key => $value) { ?>
                  <option  value="<?php echo $value['id'];?>"><?php echo $value['first_name'];?></option>
                  <?php } } ?>
                </select>
              </div>
              <button type="submit" name="submit" value="add" class="btn btn-primary"> &nbsp; Add Fleet</button>
              <button type="button"  data-toggle="modal" data-target="#m-a-a" ui-toggle-class="rotate" ui-target="#animate" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Quick Add</button>
            </form>
          </div>
        </div>
        <div>
          <table class="table m-b-none" ui-jp="footable" data-filter="#filter" data-page-size="5">
            <thead>
              <tr>
                <th> Cab id </th>
                <th> Driver ID </th>
                <th> Vehicle Reg. No. </th>
                <th> Driver Name </th>
                <th> Driver Mobile </th>
                <th> Vehicle Type </th>
                <th> Induction Status </th>
                <th> Status </th>
                <th> View More </th>
              </tr>
            </thead>
            <tbody>
              <?php if($all_cabs['num_rows']>0){ $s=0; for ($i=0; $i <$all_cabs['num_rows'] ; $i++) {  ?>
              <tr>
                <td><?php echo ($all_cabs['results'][$i]['cab_id']!=null)?"Cab".$all_cabs['results'][$i]['cab_id']:'N/A';?></td>
                <td><?php echo ($all_cabs['results'][$i]['id_code']!=null)?$all_cabs['results'][$i]['id_code']:'N/A';?></td>
                <td><?php echo ($all_cabs['results'][$i]['Vnumber']!=null)?$all_cabs['results'][$i]['state_code']."-".$all_cabs['results'][$i]['rto_code']."-".strtoupper($all_cabs['results'][$i]['rto_code_'])."-".$all_cabs['results'][$i]['Vnumber']:'N/A';?></td>
                <td><?php echo ($all_cabs['results'][$i]['first_name']!=null)?$all_cabs['results'][$i]['first_name']:'N/A';?></td>
                <td><?php echo ($all_cabs['results'][$i]['number']!=null)?$all_cabs['results'][$i]['number']:'N/A';?></td>
                <td class="center"><?php echo ($all_cabs['results'][$i]['type']!=null)?$all_cabs['results'][$i]['type']:'N/A';?></td>
                <td class="center"><?php echo ($all_cabs['results'][$i]['induction_status']!=null)?$all_cabs['results'][$i]['induction_status']:'N/A';?></td>
                <td class="text-center">
                  <?php if($all_cabs['results'][$i]['status']=='Active'){ ?>
                  <a title="Active"   href="<?php echo base_url('vehicles/inactive')."/".$all_cabs['results'][$i]['cab_id'];?>" class='label label-success'><?php echo $all_cabs['results'][$i]['status'];?></a>
                  <?php }else{ ?>
                  <a title="Inactive"  href="<?php echo base_url('vehicles/active')."/".$all_cabs['results'][$i]['cab_id'];?>" class='label label-danger'  ><?php echo $all_cabs['results'][$i]['status'];?></a>
                  <?php } ?>
                </td>
                <td class="text-center">
                  <a title="Edit" href="<?php echo base_url('cabs/add_cabs')."/".$all_cabs['results'][$i]['cab_id'];?>" class="btn btn-xs edit white">Edit</a>
                  <!-- <a title="Delete" href="<?php echo base_url('vehicles/delete')."/".$all_cabs['results'][$i]['id'];?>" class="btn btn-xs white">Edit</a>  -->
                  <a href="<?php echo base_url('cabs/view')."/".$all_cabs['results'][$i]['cab_id'];?>" class="btn btn-xs white">Details</a>
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
<!-- .modal -->
<div id="m-a-a" class="modal fade " data-backdrop="true">
  <div class="modal-dialog modal-lg" id="animate">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="pull-left modal-title">Quick Add</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body p-lg">
        <form data-parsley-validate id="quick_add" action="<?php echo base_url('cabs/quick_add');?>" ui-jpp="parsley" method="post" novalidate="">
          <div class="row">
            <div class="col-sm-4">
              <label>State Code <small>*</small></label>
             <select class="form-control" name="state_code" id="state_code" required="">
                        <option  value="KA">KA</option>
                        <option value="TN">TN</option>
                      </select>
            </div>
            <div class="col-sm-4">
              <label>RTO Code <small>*</small></label>
              <input type="text" size="2" maxlength="2" onpaste="return false;"  name="rto_code" id="rto_code" class="form-control Onumber" placeholder="RTO code" required="" >
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Prefix <small>*</small></label>
                <input type="text" size="2" style='text-transform:uppercase' maxlength="2" onpaste="return false;"  required="" class="form-control txtOnly" id="rto_code_" name="rto_code_" placeholder="Prefix" >
              </div>
            </div>
         
            <div class="col-sm-4">
              <div class="form-group">
                <label>Vehicle Number <small>*</small></label>
                 <input required="" onblur="addZero(this);" onpaste="return false;"    type="text" id="Vnumber" name="Vnumber" class="form-control col-sm-3 Onumber" size="4" maxlength="4" placeholder="Number">

             
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Vehicle Type <small>*</small></label>
                <select id="type" name="type"   class="form-control select2" ui-jp="select2"   ui-options="{theme: 'bootstrap',  selectOnBlur: true,  tags: true}">
                    <option value=""></option>
                    <?php foreach ($type_Arr as $key => $value) { ?>
                    <option value="<?php echo $value;?>"><?php echo $value;?></option>
                    <?php } ?>
                  </select>
              </div>
            </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label>First Name <small>*</small></label>
         <input required="" type="text" class="form-control"   id="first_name" name="first_name"  placeholder="First Name">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label>Middle Name <small>*</small></label>
               <input required="" type="text" class="form-control"   id="middle_name" name="middle_name"  placeholder="Middle Name">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label>Last Name <small>*</small></label>
             <input required="" type="text" class="form-control"   id="last_name" name="last_name"  placeholder="Last Name">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label>Mobile Number <small>*</small></label>
              <input   type="text" class="form-control Onumber"  id="number" name="number" placeholder="Mobile  Number">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label>Induction Status</label>
              <select id="induction_status" name="induction_status" class="form-control " >
                <option value="" disable>Select Induction Status</option>
                 <option value="Not Inducted">Not Inducted</option>
                <option value="Inducted">Inducted</option>
                <option value="Removed">Removed</option>
               
              </select>
            </div>
          </div>
        </div>
        <div class="text-center">
          <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
          <button type="submit" value="add" name="login_btn" id="pop_login_btn" class="btn btn-primary">Add Cab</button>
        </div>
      </form>
    </div>
    <!-- <div class="modal-footer">
      <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
    </div> -->
  </div><!-- /.modal-content -->
</div>
</div>
<!-- / .modal -->
<script type="text/javascript">
function addZero(){
  var deg = document.getElementById("Vnumber").value;
  if(deg.length<4){
    var deg1 =(deg.length==3)?('0' + deg):('00' + deg);
    document.getElementById("Vnumber").value=deg1;
  }
}
</script>