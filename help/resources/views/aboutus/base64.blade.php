 @extends('templates.default')
@section('content')
 <div class="col-xs-12 col-md-10">
<?php 

if(isset($result['status'] ) && $result['status'] != 1) {
	$err_msg = $result['message'];
} else {
	$err_msg = '';
  $encryption_msg     = $decryption_msg='';
  $encryption     =$encryption     = isset($_POST['encryption'])?$_POST['encryption']:'';
   $decryption  = isset($_POST['decryption'])?$_POST['decryption']:'';
}

?>




  
<div class="row">
  <div class="col-md-12">

<div class="main-title">
      <h1>Base64 Encode</h1>
      <div class="mttl-line"></div>
    </div>
 


 <div class="panel-group">
    <div class="panel panel-default">
     <!--  <div class="panel-heading">Newsletters</div> -->
      <div class="panel-body">
     
     <div class="sub-title">
 <h5 >If you would like to do base64 encode, please enter your string/text.</h5>
<div class="sttl-line"></div>
    </div>

            <?php if($err_msg!='') {?><div class="text-center"><p style="color:#ff0000"><?php echo $err_msg;?></p></div><?php }?>
            <div class="text-center" <?php if(empty($encryption_msg)) { ?>style="display:none"  <?php } ?> >
                <?php echo $encryption_msg; ?>
            </div>

  <form class="form-horizontal" name="md5enc_frm" id="md5enc_frm"  method="post"  >
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-group">
    <label class="col-md-2"  for="email">String / Text:</label>
    <div class="col-md-10">
      <input type="text"  required class="form-control" name="encryption" id="encryption" value="<?php echo $encryption; ?>" placeholder="Enter String / Text">
    </div>
  </div>
<?php if(isset($renderResultSet['encryptionRes'])) { ?>
   <div class="text-center alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?=$renderResultSet['encryptionRes']?></strong>
</div>
  
 
 <?php } ?>
  <div class="form-group"> 
    <div class="col-md-12 text-center">
      <button type="submit"  name="encryption_btn" class="btn btn-primary"><i class="fa fa-angle-double-right"></i> Encode</button>
    </div>
  </div>
</form>

      </div>
    </div>
    </div>



 <div class="panel-group">
    <div class="panel panel-default">
     <!--  <div class="panel-heading">Newsletters</div> -->
      <div class="panel-body">
     
     <div class="sub-title">
 <h5 >If you would like to do base64 decode, please enter your string/text and hit submit.</h5>
<div class="sttl-line"></div>
    </div>

            <?php if($err_msg!='') {?><div class="text-center"><p style="color:#ff0000"><?php echo $err_msg;?></p></div><?php }?>
            <div class="text-center" <?php if(empty($decryption_msg)) { ?>style="display:none"  <?php } ?> >
                <?php echo $decryption_msg; ?>
            </div>

  <form class="form-horizontal" name="md5dec_frm" id="md5dec_frm"  method="post"  >
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
 <div class="form-group">
    <label class="col-md-2"  for="email">String / Text:</label>
    <div class="col-md-10">
      <input type="text"  required class="form-control" name="decryption" id="decryption" value="<?php echo $decryption; ?>" placeholder="Enter String / Text">
    </div>
  </div>
 
  <?php if(isset($renderResultSet['decryptionRes'])) { ?>
     <div class="text-center alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?=$renderResultSet['decryptionRes']?></strong>
</div>
  
 
 <?php } ?>
  <div class="form-group"> 
    <div class="col-md-12 text-center">
      <button type="submit"  name="decryption_btn" class="btn btn-primary"><i class="fa fa-angle-double-left"></i> Decode</button>
    </div>
  </div>
</form>

      </div>
    </div>
    </div>

    </div>
</div>
</div>
@stop