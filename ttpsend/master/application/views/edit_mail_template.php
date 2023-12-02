<!--leftmenu-->
<?php $this->load->view('leftmenu');?>
<!--leftmenu-->
<?php
if($this->router->fetch_method()=='edit') { 
$mail_subject=$edit_mails['mail_subject'];
$mail_content=$edit_mails['mail_content'];
$mail_title =$edit_mails['mail_title'];
}else{
$mail_subject=set_value('mail_subject');
$mail_content=set_value('mail_content');
$mail_title =set_value('mail_title');
}
?>

<section class="col-sm-10 col-xs-12">
      <div class="clearfix text-center">
        <h2>Edit Mail Template</h2>

        <?php  echo validation_errors('<div class="alert alert-warning text-center"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');  ?>
<?php echo ($error_msg!='')?'<div class="alert alert-danger text-center"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$error_msg.'</p></div>':''; ?>
<?php echo ($success_msg!='')?'<div class="alert alert-success text-center"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><p>'.$success_msg.'</p></div>':''; ?>

      <form id="add_product" class="stdform stdform2" method="post" enctype="multipart/form-data" novalidate="novalidate">

          <div class="clearfix">
            <div class="addDetails contact">
              <div class="clearfix form-group">
                <label for="">Title <small class="error">*</small></label>
                <span>
                 <input type="text"  name="mail_title" id="mail_title" value="<?php echo $mail_title;?>" class="form-control" required="" />
                </span>
              </div>
              <div class="clearfix form-group">
                <label for="">Subject <small class="error">*</small></label>
                <span>
                <input type="text"  name="mail_subject" id="mail_subject" value="<?php echo $mail_subject;?>" class="form-control" required="" />
                </span>
              </div>
              <div class="clearfix form-group">
                <label for="">Message <small class="error">*</small></label>
                <span>
                <textarea id="mail_content" name="mail_content" required="" rows="15" cols="80" class="form-control tinymce"><?php echo $mail_content;?></textarea>
                 
                </span>
                <br/>
               <small class="error">Please dont edit ##inside## text</small>
              </div>
            
              <div class="clearfix form-group text-center">
              <button class="btn btn-primary">Submit Button</button>
              <a  href="<?php echo base_url('mail_template');?>"  class="btn btn-default"  />Cancel</a>

              </div>
            </div>
          </div>  
        </form>
      </div>
    </section>
       </section>

    
                                
           
                    



					
					

            
    

