<div class="col-md-10">
  <?php
  if($this->resultSet['status'] != 1) {
    $err_msg = $this->resultSet['message'];
  } else {
    $err_msg = '';
  }
  $unsubscribe_msg    = '';
  $unsubscribe_email    = '';
  $unsubscribe_error_id   = '';
  $unsubscribe_ts     = '';
  if(isset($_SESSION['unsubscribe_ts']))
  {
    $unsubscribe_ts = $_SESSION['unsubscribe_ts'];
  }
  if(empty($unsubscribe_ts))
  {
    $unsubscribe_ts = time();
    $_SESSION['unsubscribe_ts'] = $unsubscribe_ts;
  }
  ?>
  <div class="main-title">
    <h1>Newsletters</h1>
    <div class="mttl-line"></div>
  </div>
  <div class="panel-group">
    <div class="panel panel-default">
      <!--  <div class="panel-heading">Newsletters</div> -->
      <div class="panel-body">
        <div class="sub-title">
          <h5 >If you would like to stop receiving alerts for new reports, please enter your email and hit submit.</h5>
          <div class="sttl-line"></div>
        </div>
        <?php if($err_msg!='') {?><div class="text-center"><p style="color:#ff0000"><?php echo $err_msg;?></p></div><?php }?>
        <div class="text-center" <?php if(empty($unsubscribe_msg)) { ?>style="display:none"  <?php } ?> >
          <?php echo $unsubscribe_msg; ?>
        </div>
        <form class="form-horizontal" name="unsubscribe_frm" id="unsubscribe_frm" action="<?php echo $this->url('/user/newsletters');?>" method="post"  role="form">
          <input type="hidden" value="<?php echo $unsubscribe_ts; ?>" name="unsubscribe_ts" />
          <div class="form-group">
            <label class="col-md-2"  for="email">Email:</label>
            <div class="col-md-10">
              <input type="email"  required class="form-control" name="unsubscribe_email" id="unsubscribe_email" value="<?php echo $unsubscribe_email; ?>" placeholder="Enter email">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12 text-center">
              <button type="submit"  name="unsubscribe_btn" class="btn btn-primary"><i class="fa fa-angle-double-right"></i> Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
//include('view/templates/rightside.php');
?>