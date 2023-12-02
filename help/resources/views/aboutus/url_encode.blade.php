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
  
}

?>




  
<div class="row">
  <div class="col-md-12">

<div class="main-title">
      <h1>URL Encode/Decode</h1>
      <div class="mttl-line"></div>
    </div>
 


 <div class="panel-group">
    <div class="panel panel-default">
     <!--  <div class="panel-heading">Newsletters</div> -->
      <div class="panel-body">
     
     <div class="sub-title">
 <h5 >If you would like to do url encode/decode, please enter your string/text/url.</h5>
<div class="sttl-line"></div>
    </div>

            <?php if($err_msg!='') {?><div class="text-center"><p style="color:#ff0000"><?php echo $err_msg;?></p></div><?php }?>
            <div class="text-center" <?php if(empty($encryption_msg)) { ?>style="display:none"  <?php } ?> >
                <?php echo $encryption_msg; ?>
            </div>

  <form class="form-horizontal" name="md5enc_frm" id="md5enc_frm"  method="post"  >
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-group">
    <label class="col-md-2"  for="email">Url/Text:</label>
    <div class="col-md-10">
      <input type="text"  required class="form-control" name="encryption" id="encryption" value="<?php echo $encryption; ?>" placeholder="Enter Url">
    </div>
  </div>
<?php if(isset($renderResultSet['encryptionRes'])) { ?>

<div class="text-center alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?=$renderResultSet['encryptionRes']['plain']?></strong>
</div>

<div class="text-center alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Raw : </strong> <?=$renderResultSet['encryptionRes']['raw']?>
</div>
  
 
 
 <?php } ?>
  <div class="form-group"> 
    <div class="col-md-12 text-center">
      <button type="submit" value="encode"  name="button" class="btn btn-primary"><i class="fa fa-angle-double-right"></i> Encode</button>
      <button type="submit" value="decode"  name="button" class="btn btn-primary"><i class="fa fa-angle-double-left"></i> Decode</button>
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