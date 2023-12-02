
<form action="<?php echo base_url('subscriptions/edit').'/'.$edit_subscriptions['subscription_id'];?>" id="subscription_edit" name="subscription_edit" method="post" class="quickform">
<table class="tablenone">
	
	<tr>
	<td>
	<h5>Subscriptions Edit</h5>
	</td>
		<td>
			 <p>
            <label>Product</label>
           <span class="field">


                                  <?php
                                   $product_options = array();
                                  
                                   $product_options =$products_all;
                                   $product_options[''] ='Select';
                                  
                                 
                                  $other_attr = 'id="product_id" required="required"';
                                  echo form_dropdown('product_id', $product_options, $edit_subscriptions['product_id'],$other_attr);
                                  ?>



           
                            </span>
           
        </p>
		</td>
		<td>
			 <p>
                          <label>Subscriptions (Days)</label>
                            <span class="field">

                             <?php   
                              $Subscription_options = array(
                                ''  => 'Select',
                                '30'  => '30 Days (Free Trial)',
                                '180'    => '180 Days (6 Months)',
                                '365'    => '365 Days (1 Year)',
                                '730'    => '730 Days (2 Years)',
                                '1825'    => '1825 Days (5 Years)',
                                'Permanent'    => 'Permanent'

                                );
                                $other_attr = 'id="subscription_duration" required="required"';
                                echo form_dropdown('subscription_duration', $Subscription_options, $edit_subscriptions['subscription_duration'],$other_attr);
                        
                        ?>
           
                           
                            </span>
                          
                        </p>
		</td>
		<td>
			
			 <p>
            <label>Discount</label>
           <span class="field">
 <?php   
                          $subscription_discount_data = array(
                                            'name'        => 'subscription_discount',
                                            'id'          => 'subscription_discount',
                                            'value'       => $edit_subscriptions['subscription_discount'],
                                          'required'        => 'required'
                                           
                                        );

echo form_input($subscription_discount_data);?>
             </span>
           
        </p>
		</td>
    <td>
       <p>
                                <label>Currency <span class="error">*</span></label>
                                <span class="field">
                                <?php
                                $currency_options = array(
                                ''  => 'Select',
                                '1'  => CURR_D,
                                '2'    => CURR_J
                                
                                );
                                $other_attr = 'id="currency" required="required"';
                                echo form_dropdown('currency', $currency_options, $edit_subscriptions['currency'],$other_attr);
                                ?>

                                </span>
                                </p>
    </td>
		
		<td>
			
			 <p>
            <label for="slug">Amount</label>

             <?php   
                          $subscription_cost_data = array(
                                            'name'        => 'subscription_cost',
                                            'id'          => 'subscription_cost',
                                            'value'       => $edit_subscriptions['subscription_cost'],
                                          'required'        => 'required'
                                           
                                        );

echo form_input($subscription_cost_data);?>
           
        </p>
		</td>
		<td colspan="2">
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
  
  jQuery("#subscription_edit").validate({


    rules: {
      subscription_discount:{
     number: true
      }  ,
      subscription_cost:{
     number: true
      }  
    },
    messages: {
       subscription_discount :"Please enter onlu numbers",
       subscription_cost :"Please enter onlu numbers"
    },

    submitHandler: function() { 

      var action = jQuery("#subscription_edit").attr('action');

     jQuery.ajax({
        type: "POST",
        url: action,
        data: jQuery("#subscription_edit").serialize(),
        dataType: "json",
        beforeSend: function(XMLHttpRequest){
           jQuery('.quickformbutton').parent().find('.loading').show();
        
          },
        success: function(response){

          if(response!=''){
           
            jQuery('.blogtable').find('tr.current td').eq(1).html(response.product);
            jQuery('.blogtable').find('tr.current td').eq(2).html(response.subscription_duration);
            jQuery('.blogtable').find('tr.current td').eq(3).html(response.subscription_discount+' %');
            jQuery('.blogtable').find('tr.current td').eq(4).html(response.subscription_cost+' '+response.subscription_currency);
           jQuery('.quickformbutton').parents('tr.togglerow').remove();
           jQuery('#alertMsg').parent('div').show();
    jQuery('#alertMsg').html('Successfully edited selected subscription');
          }
           
        }
      });
      return false;   
  }
    
  });
</script>