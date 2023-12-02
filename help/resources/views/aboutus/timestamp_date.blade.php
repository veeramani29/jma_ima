 @extends('templates.default')
@section('content')
 <div class="col-xs-12 col-md-10">
<?php 

if(isset($renderResultSet['status'] ) && $renderResultSet['status'] != 1) {
	 $encryption_msg =$err_msg= $renderResultSet['message'];
  $encryption = isset($_POST['encryption'])?$_POST['encryption']:'';
} else {
	$encryption_msg =$err_msg='';
  $encryption = isset($_POST['encryption'])?$_POST['encryption']:'';
  
}

?>




  
<div class="row">
  <div class="col-md-12">

<div class="main-title">
      <h1>Timestamp to Date</h1>
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
           

  <form class="form-horizontal" name="md5enc_frm" id="md5enc_frm"  method="post"  >
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-group">
    <label class="col-md-2"  for="email">Timestamp:</label>
    <div class="col-md-10">
      <input type="text"  required class="form-control" name="encryption" id="encryption" value="<?php echo $encryption; ?>" placeholder="Enter Url">
    </div>
  </div>
<?php if(isset($renderResultSet['encryptionRes'])) { ?>


<div class="text-center alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> <?=$renderResultSet['encryptionRes']?></strong>
</div>
  
 
 
 <?php } ?>
  <div class="form-group"> 
    <div class="col-md-12 text-center">
      <button type="submit" value="encode"  name="button" class="btn btn-primary"><i class="fa fa-angle-double-right"></i> Convert</button>
     
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