$(document).ready(function(){
$("#login,#cat").validate({
	  errorElement: 'span',
	  errorClass: 'text-danger'
/* errorPlacement: function(error, element) {
                error.insertAfter(element);
                }*/
});
$("#add_subs").validate();
$("#add_discount").validate();
$("#add_product").validate({
	 validClass: "success",
		rules: {
			
			product_image:{
    		extension: "jpg|jpeg|png"
      			}  
		},
		messages: {
			 product_image :" Please upload only image format"
		}
		
	});

$('.checkall, .checkall2').on('click',function(){
		if(!jQuery(this).is(':checked')) {
			checkbox(jQuery(this),false);	
		} else {
			checkbox(jQuery(this),true);
		}
	});
	
	function checkbox(t,v) {
	
		t.parents('table').find('input[type=checkbox]').each(function(){

			//if(!jQuery(this).parents('tr').hasClass('togglerow')) {
				$(this).attr('checked',v);
				$(this).prop('checked',v);
			//}
			
		});	
	}


	$("#change").validate({
		rules: {
			new_password:{
    equalTo: "#hdnpassword"
      }  ,
			passconf:{
    equalTo: "#password"
      }  
		},
		messages: {
			 new_password :" Enter New Password Same as Current Password",
			 passconf :" Enter Confirm Password Same as Password"
		},
		  errorElement: 'span',
	  errorClass: 'text-danger'
	});


	$("#form1").validate({
		rules: {
			
			passconf:{
    equalTo: "#password"
      }  
		},
		messages: {
			 passconf :" Enter Confirm Password Same as Password"
		},
		  errorElement: 'span',
	  errorClass: 'text-danger'
	});

	});	