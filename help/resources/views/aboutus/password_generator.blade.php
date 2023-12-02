 @extends('templates.default')
@section('content')
 <div class="col-xs-12 col-md-10">
<?php 

if(isset($result['status'] ) && $result['status'] != 1) {
	$err_msg = $result['message'];
} else {
	$err_msg = '';
  $encryption_msg     = $decryption_msg='';
  $encryption     = $decryption='';
}

?>




  
<div class="row">
  <div class="col-md-12">

<div class="main-title">
      <h1>Password Generator</h1>
      <div class="mttl-line"></div>
    </div>
 


 <div class="panel-group">
    <div class="panel panel-default">
     <!--  <div class="panel-heading">Newsletters</div> -->
      <div class="panel-body">
     

  <form class="form-horizontal" name="md5enc_frm" id="md5enc_frm"  method="post"  >
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  
<?php if(isset($renderResultSet['encryptionRes'])) { ?>
  <div class="text-center alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?=$renderResultSet['encryptionRes']?></strong>
</div>
  
 
 <?php } ?>
  <div class="form-group"> 
    <div class="col-md-12 text-center">
      <button type="submit"  name="encryption_btn" class="btn btn-primary"><i class="fa fa-angle-double-right"></i> Re-Try</button>
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