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
                  <h2>  <?php echo ($this->uri->segment(3)!='')?"Edit":"Add";?> Vehicle Category</h2>
                  <small>By filling all form details of Category, Category will be shown in the list of Vehicle Category's.</small>
                </div>
                <div class="box-divider m-a-0"></div>
                <div class="box-body row">

                    <?php echo validation_errors('<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');  ?>

                       <?php echo (isset($error_msg) && $error_msg!='')?'<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
             <?php echo (isset($success_msg) && $success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>

                  <form data-parsley-validate method="post" enctype="multipart/form-data" role="form">



   <?php
  $type_Arr=array_unique(array_filter(array_column($vehicles_assets['results'], 'type')));
                    if ($this->uri->segment(3)!='') {
                        $company=$vehicles_cat_details['company'];
                        $cate_name=$vehicles_cat_details['cate_name'];
                        $vehicle_types=@explode(",", $vehicles_cat_details['vehicle_types']);
                      } else {
                        $company=set_value('company');
                        $cate_name=set_value('cate_name');
                        $vehicle_types=set_value('vehicle_types');
                       
                       
                    }
                   ?>

                     <div class="form-group col-sm-4">
                      <label for="" class="cform-control-label">Company Name <small>*</small></label>
                      <select required=""  id="company" name="company" class="form-control">
                         <option>Select Company</option>
                        <?php if(!empty($all_companies['results'])){ foreach ($all_companies['results'] as $key => $Combvalue) { ?>
                       
                       
                        <option value="<?php echo $Combvalue['id']; ?>" <?php  if($Combvalue['id']==$company){ echo "selected"; } ?>><?php echo $Combvalue['name']; ?></option>
                       <?php  }} ?>
                      </select>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="" class="cform-control-label">Vehicle type <small>*</small></label>
                      <select required="" multiple=""  id="vehicle_types" name="vehicle_types[]" class="form-control select2-multiple" ui-jp="select2"   ui-options="{theme: 'bootstrap',  selectOnBlur: true,  tags: true}">
                     
                    <?php foreach ($type_Arr as $key => $value) { ?>
                    <option   <?php  if(@in_array($value, $vehicle_types)){ echo "selected"; } ?> value="<?php echo $value;?>"><?php echo $value;?></option>
                    <?php  } ?>
                  </select>

                    </div>

                    <div class="form-group col-sm-3">
                      <label for="name" class="cform-control-label">Vehicle Category name <small>*</small></label>
                      <input required="" type="text" class="form-control" value="<?php echo $cate_name; ?>"  id="cate_name" name="cate_name"  placeholder="Category name">
                    </div>

                      
                    
                    <div class="form-group m-t-md">
                      <div class="col-xs-12 text-center">
                        <button type="submit" name="add_cat" id="add_cat" value="Add" class="btn btn-primary"><?php echo ($this->uri->segment(3)!='')?"Update":"Add";?> </button>
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