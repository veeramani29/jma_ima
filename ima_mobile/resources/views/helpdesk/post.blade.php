@extends('templates.default')
@section('content')

<div class="col-xs-12">
  <div class="main-title">
    <h1>Post Your Query</h1>
    <div class="mttl-line"></div>
  </div>
  <div class="panel panel-default">
    <div class="panel-body">
      <?php if(isset($result['status']) && $result['status']==4001) {
        echo "<p class='text-success'>".$result['message']."</p>";
      } else {?>
      <form role="form" class="form-horizontal" name="frm_helpdesk" id="frm_helpdesk" action="<?php echo url('helpdesk/post');?>" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <p>
          <?php if(isset($result['status']) && $result['status'] == 3332) { ?>
          <?php echo $result['message'];?>
          <?php }?>
          One of our research associate will get back to you within 2 business working days, please leave your query below in the description
          box and hit submit tab at the bottom. We work Mon-Fri: 8:00am - 5:30pm IST hours.
        </p>
        <div class="form-group">
          <div class="col-md-12">
            <textarea class="form-control" rows="5" name="mail_body" id="mail_body"></textarea>
            <div id="error_query" style="color:red;"></div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-primary" name="forgotpasswd_btn" value="Submit" > Submit </button>
          </div>
        </div>
      </form>
      <?php }?>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  $('#frm_helpdesk').submit(function() {
    var ret = true;
    $('#error_query').html('');
    var postQuery  = $('#mail_body').val();
    if(postQuery == ''){
      $('#error_query').html('Please enter your query.');
      ret =  false;
    }
    return ret;
  });
  //Slug creation
  $('#post_title').keyup(function(){
    var category_name = $(this).val();
    var url_slug = JmaAdmin.convertToSlug(category_name);
    $('#post_url').val(url_slug);
  });
});
</script>
@stop