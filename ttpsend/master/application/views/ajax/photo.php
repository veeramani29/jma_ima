

 <form id="upload_img" method="POST" action="<?php echo base_url('products/uploading_img');?>" novalidate="novalidate" enctype="multipart/form-data">
         <input  type="hidden" name="pro_id" value="<?php echo $pro_id;?>"  id="pro_id"  >
         <p class="text-center text-success" id="alertMsg"></p>
              <div class="form-group">
            <!--   <label for="disapprove_reason">Comments</label> -->
             <input  type="file" name="product_images[]" multiple="multiple"  id="product_images" accepts="image/*" required >
              <br/>
        <small class="text-danger">Please upload only image (gif,jpeg,jpg,png) format</small> 
              </div>
              
        

       
        <button class="btn btn-default">Upload</button>
        
        <span class="loading hide"><img src="<?php echo IMAGES;?>loaders/loader3.gif" alt="" />Uploading...</span>
    
     

      
        </form>


       
       
<script type="text/javascript">




    $("#upload_img").validate({
    
        rules: {
            upload_imgs:{
            extension: "jpg|jpeg|png"
                }  
        },
        messages: {
             upload_imgs :" Please upload only image format"
        },
          submitHandler: function() { 

   var action = $("#upload_img").attr('action');
   var form_data = new FormData();   

   $.each($('#product_images')[0].files, function(i, file) {
   	 form_data.append("product_images["+i+"]", file); 
   
});

   
    

    form_data.append("pro_id", $("#pro_id").val());
   

     $.ajax({
       	url: action,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
         type: "POST",
        beforeSend: function(XMLHttpRequest){
           $('.stdformbutton').find('.loading').show();
        
          },
        success: function(response){

          if(response.response==1){
          	 	var lastid=response.id;
          	 	var filename=response.product_images_url;
          	 	$.each(filename,function(i,val){
$('#imagelist').append('<li><input type="hidden" id="'+lastid[i]+'" name="product_img_val[]" value="'+filename[i]+'"/><image  src="'+HOST+'product_img/'+filename[i]+'"/><span id="'+lastid[i]+'" class="fa fa-trash-o error"></span></li>');
$('#alertMsg').html('Successfully uploaded');
//$('span').find('.loading').hide();
$("#product_images").val('');
          	 	});
          	  	//var filesInput = document.getElementById("product_images");
				//readURL(filesInput,filename,lastid);
					
					
				

             
          }else{
            alert(response);
          }
           
        }
      });
      return false;   
  }
         
    });


    function readURL(input,filename,lastid) {
		
         for(var i = 0; i<input.files.length; i++){
     		var new_filename= filename[i];
   			var lastids= lastid[i];
if (input.files && input.files[i]) {
 
var inputs='';
var span='';
var reader= new FileReader();




reader.onload = function (e) {

}
$('#imagelist').after(inputs);
reader.readAsDataURL(input.files[i]);
}

}
}
 

</script>