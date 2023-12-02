<!--leftmenu-->
<?php $this->load->view('leftmenu');?>
<!--leftmenu-->
 <?php
$send_subject=set_value('send_subject');
$send_msg=set_value('send_msg');
$send_user_list=set_value('send_user_list');
$other_user=set_value('other_user');
$subscribers=$this->Discount_Model->get_all_subscriptions_user();
                  ?>



   <section class="col-sm-10 col-xs-12">
      <div class="clearfix text-center">
        <h2>Contact Users</h2>

             <?php  echo validation_errors('<div class="alert alert-warning text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');  ?>
            
            <?php echo ($error_msg!='')?'<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
<?php echo ($success_msg!='')?'<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>

     <form id="add_product" class="stdform stdform2" method="post" enctype="multipart/form-data" novalidate="novalidate" >
          <div class="clearfix">
            <div class="addDetails contact">
              <div class="clearfix form-group">
                <label for="">Subscriber List <small class="error">*</small></label>

                <span>
                  <select name="send_user_list[]" id="send_user_list" class="form-control" multiple="multiple" required size="5">
                               
<?php if($subscribers['num_rows']>0){ foreach ($subscribers['results'] as $subscriber) {
 echo '<option value="'.$subscriber['user_email'].'">'.$subscriber['user_name'].' ('.$subscriber['user_email'].')</option>';
} } ?>

                                
                               
                            </select>
                  <small>( Use CTRL + Select to Select multiple users )</small>
                </span>
              </div>

              
<div class="clearfix form-group">
                <label for="">Other User's</label>
                <span>
                  <input type="text"  name="other_user" id="tags" value="<?php echo ($other_user!=null)?'test@gmail.com':'';?>" class="form-control" />
                </span>
                <br>
                            <small>Please enter tab on ater entering email address</small>
              </div>


              <div class="clearfix form-group">
                <label for="">Subject <small class="error">*</small></label>
                <span>
                 <input type="text"  name="send_subject" id="send_subject" value="<?php echo $send_subject;?>" class="form-control" required="" />
                </span>
              </div>
              <div class="clearfix form-group">
                <label for="">Description <small class="error">*</small></label>
                <span>
                 <textarea id="send_msg" name="send_msg" required="" rows="15" cols="80"  class="form-control tinymce"><?php echo $send_msg;?></textarea>
                </span>
              </div>
              <div class="clearfix form-group">
                <label for="">Attachment <small class="error">*</small></label>
                <span>
                    <input class="form-control" type="file" id="attachment" name="attachment"  />
                </span>
              </div>
              <div class="clearfix form-group text-center">
              <button class="btn btn-primary">Submit Button</button>
               <a  href="<?php echo base_url('contact_user');?>"  class="btn btn-default"  />Cancel</a>
              
              </div>
            </div>
          </div>  
        </form>
      </div>
    </section>
 </section>
<script type="text/javascript">

$('#tags').tagsInput({
        width: 'auto',
        onChange: function(elem, elem_tags)
        {
          var languages = ['php','ruby','javascript'];
          $('.tag', elem_tags).each(function()
          {
            alert(0);
            if($(this).text().search(new RegExp('\\b(' + languages.join('|') + ')\\b')) >= 0)
              $(this).css('background-color', 'yellow');
          });
        }
      });

 
  $('#tags_tagsinput').addClass('form-control');

  
</script>
   
                        
                       


                   

                     

    

