 @extends('templates.default')
@section('content')
 <div class="col-xs-12 col-md-10">
  <div class="main-title">
    <h1>Post Your Query</h1>
    <div class="mttl-line"></div>
  </div>
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-body">
        <?php if(isset($result['status']) && $result['status']==4001) {
         echo "<p class='text-success'>".$result['message']."</p>";
       } else {?>
       <form role="form" class="form-horizontal" name="frm_helpdesk" action="<?php echo url('helpdesk/post');?>" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
         <p>
           <?php if(isset($result['status']) && $result['status'] == 3332) {
             echo "<p class='text-danger'>".$result['message']."</p>";
         
           }?>
           One of our research associate will get back to you within 2 business working days, please leave your query below in the description
           box and hit submit tab at the bottom. We work Mon-Fri: 8:00am - 9:00pm JST hours.
         </p>
         <div class="form-group">
          <div class="col-md-12">
            <textarea required  class="form-control" rows="5" name="mail_body"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-primary" name="forgotpasswd_btn" value="Submit"> Submit </button>
          </div>
        </div>
      </form>
      <?php }?>
    </div>
  </div>
</div>
</div>
<?php
// include('view/templates/rightside.php');
?>
@stop