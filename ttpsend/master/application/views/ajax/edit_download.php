
<form action="<?php echo base_url('downloads/edit').'/'.$edit_downloads['download_id'];?>" id="download_edit" name="download_edit" method="post" class="quickform">
<table class="tablenone">
  
  <tr>
  <td>
  <h5>Downloads Edit</h5>
  </td>
<td>
  <p>
          <label for="date">Product</label>
         <span class="field">
<?php
                        $product_options = array();
                                
                                 $product_options =$products_all;
                                 $product_options[''] ='Select';
$other_attr = 'id="product_id" required="required"';
echo form_dropdown('product_id', $product_options, $edit_downloads['product_id'],$other_attr);
?>
       

                          </span>
         
      </p>
</td>
<td>
   <p>
          <label>Version Name</label>
          <?php   
                          $download_title_data = array(
                                            'name'        => 'download_title',
                                            'id'          => 'download_title',
                                            'value'       => $edit_downloads['download_title'],
                                          'required'        => 'required'
                                           
                                        );

echo form_input($download_title_data);?>
           
        </p>
</td>
<td>
   <p>
            <label for="slug">Download File Name</label>
             <?php   
                          $download_name_data = array(
                                            'name'        => 'download_name',
                                            'id'          => 'download_name',
                                            'value'       => $edit_downloads['download_name'],
                                          'required'        => 'required'
                                            
                                        );

echo form_input($download_name_data);
?>
          
        </p>
</td>
<td>
   <p>
                          <label>Latest Release</label>
                            <span class="formwrapper">
                           <input type="checkbox" name="latest_release" value="Yes" <?php echo ($edit_downloads['latest_release']=='Yes')?'checked="checked"':'';?> /> 
                            </span>
                        </p>
                     
</td>

<td>
   <p>
                          <label>Downloadable</label>
                            <span class="formwrapper">
                           <input type="checkbox" name="downloadable" value="Yes" <?php echo ($edit_downloads['downloadable']=='Yes')?'checked="checked"':'';?> /> 
                            </span>
                        </p>
                     
</td>
<td>
   <div class="quickformbutton">
      <button class="">Update</button>
        <button class="cancel">Cancel</button>
        <span class="loading"><img src="<?php echo IMAGES;?>loaders/loader3.gif" alt="" />Updating changes...</span>
    </div><!-- button -->
</td>
  </tr>
</table>
  
    
</form>




<script type="text/javascript">
  
  jQuery("#download_edit").validate({


   
    submitHandler: function() { 

      var action = jQuery("#download_edit").attr('action');

     jQuery.ajax({
        type: "POST",
        url: action,
        data: jQuery("#download_edit").serialize(),
        dataType: "json",
        beforeSend: function(XMLHttpRequest){
           jQuery('.quickformbutton').parent().find('.loading').show();
        
          },
        success: function(response){

          if(response!=''){
            if(response==2){
              alert('This download title already exists.');
            }else{
              
           jQuery('.blogtable').find('tr.current td').eq(1).html(response.product);
            jQuery('.blogtable').find('tr.current td').eq(2).html(response.download_title);
            jQuery('.blogtable').find('tr.current td').eq(3).html(response.download_name);
            jQuery('.blogtable').find('tr.current td').eq(4).html(response.latest_release);
            jQuery('.blogtable').find('tr.current td').eq(5).html(response.downloadable);
           jQuery('.quickformbutton').parents('tr.togglerow').remove();
           jQuery('#alertMsg').parent('div').show();
          jQuery('#alertMsg').html('Successfully edited selected download');
            }
           
          }
           
        }
      });
      return false;   
  }
    
  });
</script>