
<div class="container-fluid sb2">
        <div class="row">
        <!--leftmenu-->
   <?php $this->load->view('a');?>
   <!--leftmenu-->
            
            <div class="sb2-2">
                <div class="sb2-2-2">
                    <ul>
                        <li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="<?php echo base_url('dashboard');?>"> Categories </a>
                        </li>
                    </ul>
                </div>



                <div class="sb2-2-3">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Categories </h4>
                                  
                                </div>
                                <div class="tab-inn">
                                   <form method="post" id="form_submit" name="form_submit"> 
                 <input type="hidden" id="hdnMethod" name="hdnMethod">

          

            <?php if($success_msg!=null){ ?>
              <div class="alert alert-success text-center">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                         <?php echo $success_msg; ?>
                    </div>
                    <?php } ?>


                    <div  class="alert alert-success text-center hide">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p id="alertMsg"></p>
                    </div>

           <div class="table-responsive table-desi">
                                        <table class="table table-hover">
              <thead>
                <tr>
                 <th><input type="checkbox" class="checkall" /></th>
        <th class="text-center">S.No</th>
        <th>Name</th>
      
        <th class="text-center">Status</th>
     
        
        <th class="text-center">ActionS</th>
      
                </tr>
              </thead>
              <tbody>
                <?php if($pages['num_rows']>0){ $s=0; for ($i=0; $i <$pages['num_rows'] ; $i++) {  ?> 
                        <tr>
                          <td align="text-center"><span class="text-center">
                     
                            <input type="checkbox" name="Checkall[]" value="<?php echo $pages['results'][$i]['id'];?>"  />
                          
                          </span>
                          </td>
                          <td class="text-center"><?php echo ($s+1);?></td>
                            <td><?php echo ($pages['results'][$i]['category_name']!=null)?$pages['results'][$i]['category_name']:'N/A';?></td>
                          
                           
                            <td class="text-center">
                              <?php if($pages['results'][$i]['status']=='Active'){ ?>
                              <a title="Active"   href="<?php echo base_url('tourpack/category_inactive')."/".$pages['results'][$i]['id'];?>" class='label label-success' class='green' ><?php echo $pages['results'][$i]['status'];?></a>
                              <?php }else{ ?>
                              <a title="Inactive"  href="<?php echo base_url('tourpack/category_active')."/".$pages['results'][$i]['id'];?>" class='label label-danger'  class='red' ><?php echo $pages['results'][$i]['status'];?></a>
                              <?php } ?>
                           
                              </td>
             
                            
                             <td class="text-center">

                             
                           
                             <a title="Edit" href="<?php echo base_url('tourpack/add_category')."/".$pages['results'][$i]['id'];?>" class="btn btn-primary edit">Edit</a>
                        <a title="Delete" href="<?php echo base_url('tourpack/category_delete')."/".$pages['results'][$i]['id'];?>" class="btn btn-primary admin_delete">Delete</a>
                           

                             </td> 
                             
                        </tr>
                     
                       <?php $s++; } }else{ ?>
<td colspan="8" class="text-center text-danger">No more records</td>
                        <?php } ?>
               
                
              </tbody>
            </table>
             </div>
            <button type="button" onclick="location.href='<?php echo base_url('tourpack/add_category');?>'" title="Add Admin" class="btn btn-info">Add Catrgory</button>
<button type="button" title="Delete" class="btn btn-success deletebuttons">Delete</button>
  <button type="button" title="Active" class="btn btn-success changebuttons">Active</button>

  <button type="button" title="Inactive" class="btn btn-danger changebuttons">Inactive</button>

         
          </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
  $(document).ready(function(){




///// DELETE SELECTED ROW IN A TABLE /////
  $('.changebuttons').click(function(){

    
             // get target id of table                  
    var sel = false;                        //initialize to false as no selected row
    var method=$(this).attr('title');
    var ch = $('table').find('tbody input[type=checkbox]');   //get each checkbox in a table
    
    //check if there is/are selected row in table
     
     if($('table').find('tbody input[name="Checkall[]"]').is(':checked')){
   
    
       if(confirm('Are you sure you want to '+method+' this ?', ''+method+' Admin')){
        $('#hdnMethod').val(method);
        $('#form_submit').submit();
   
    }else{
        sel = true;   
    }
   
       return false;
  }
    if(!sel) alert('No data selected');  //alert to no data selected
  });





///// DELETE SELECTED ROW IN A TABLE /////
  $('.deletebuttons').click(function(){
             // get target id of table                  
    var sel = false;                        //initialize to false as no selected row
    var ch = $('table').find('tbody input[type=checkbox]');   //get each checkbox in a table
    
    //check if there is/are selected row in table
     
     if($('table').find('tbody input[name="Checkall[]"]').is(':checked')){
      if(confirm('Are you sure you want to delete this ?')) {
    
    
    ch.each(function(){
      if($(this).is(':checked')) {
        var eachval=$(this).val();
        sel = true;                       //set to true if there is/are selected row

        $(this).parents('tr').fadeOut(function(){
      $.ajax({
            type: 'POST',
            url: "http://localhost/jma/yuga/master/admin/delete/"+eachval,
            async: true,
            dataType: 'json',
           // data: data,
            success: function() {
          $(this).remove();
            }
          });
                      //remove row when animation is finished
        });
      }
    });
    $('#alertMsg').parent('div').show();
    $('#alertMsg').html('Selected items are deleted');
    }else{
        sel = true;   
    }
     
       return false;
  }
    if(!sel) alert('No data selected', 'Alert Dialog');             //alert to no data selected
  });


  ///// DELETE INDIVIDUAL ROW IN A TABLE /////
  $('table td').on('click',"a.admin_delete",function(){

    event.preventDefault();
     var Delurl=$(this).attr("href");
     var curTr=$(this).parents("tr");
  if(confirm('Are you sure you want to delete this?')) {
       
       
  curTr.fadeIn(function(){ 


      $.ajax({
            type: 'POST',
            url: Delurl,
           // async: true,
          //  dataType: 'json',
           // data: data,
            success: function() {
            
          $(curTr).remove();
         
            }
          });
        


      $('#alertMsg').parent('div').show();
    $('#alertMsg').html('Selected items are deleted');
    });
       }

    
    return false;
  });









 $('table td').on('click',"a.label-success",function(){
   event.preventDefault();
      var currel=$(this);
     var inactiveurl=$(this).attr("href");
    var curTr=$(this).parents("tr");
  
 
 if(confirm('Are you sure want to inactive this?')){
  curTr.fadeIn(function(){ 

      $.ajax({
            type: 'POST',
            url: inactiveurl,
            //async: true,
            //dataType: 'json',
           // data: data,
            success: function() {
               
              currel.removeClass('label-success');
             currel.addClass('label-danger');
              currel.text('Inactive');
      var newurl=inactiveurl.replace("inactive", "active");

      currel.attr('href',newurl);
        $('#alertMsg').parent('div').removeClass('hide');
      $('#alertMsg').parent('div').show();
$('#alertMsg').html('Selected items are activated');
            }
          });
        


       });
        }
  
    
    return false;
  });

 $('table td').on('click',"a.label-danger",function(){
   event.preventDefault();
  var currel=$(this);
     var activeurl=$(this).attr("href");
      var curTr=$(this).parents("tr");
      if(confirm('Are you sure you want to active this?')) {
       
       
  curTr.fadeIn(function(){ 
      $.ajax({
            type: 'POST',
            url: activeurl,
            //async: true,
            //dataType: 'json',
           // data: data,
            success: function() {
             
              currel.removeClass('label-danger');
             currel.addClass('label-success');
              currel.text('Active');
      var newurl=activeurl.replace("active", "inactive");
     
      currel.attr('href',newurl);
        $('#alertMsg').parent('div').removeClass('hide');
       $('#alertMsg').parent('div').show();
    $('#alertMsg').html('Selected items are inactivated');
            }
          });
     
        
 });

       }
    
    return false;
  });

   })
</script>