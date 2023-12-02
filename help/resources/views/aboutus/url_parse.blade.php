 @extends('templates.default')
@section('content')
 <div class="col-xs-12 col-md-10">
<?php 

if(isset($result['status'] ) && $result['status'] != 1) {
	$err_msg = $result['message'];
} else {
	$err_msg = '';
  $encryption_msg     = $decryption_msg='';
  $encryption     = isset($_POST['encryption'])?$_POST['encryption']:'';
}

?>




  
<div class="row">
  <div class="col-md-12">

<div class="main-title">
      <h1>URL Parse</h1>
      <div class="mttl-line"></div>
    </div>
 


 <div class="panel-group">
    <div class="panel panel-default">
     <!--  <div class="panel-heading">Newsletters</div> -->
      <div class="panel-body">
     
     <div class="sub-title">
 <h5 >If you would like to do url parse, please enter your url.</h5>
<div class="sttl-line"></div>
    </div>

            <?php if($err_msg!='') {?><div class="text-center"><p style="color:#ff0000"><?php echo $err_msg;?></p></div><?php }?>
            <div class="text-center" <?php if(empty($encryption_msg)) { ?>style="display:none"  <?php } ?> >
                <?php echo $encryption_msg; ?>
            </div>

  <form class="form-horizontal" name="md5enc_frm" id="md5enc_frm"  method="post"  >
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-group">
    <label class="col-md-2"  for="email">Url:</label>
    <div class="col-md-10">
      <input type="url"  required class="form-control" name="encryption" id="encryption" value="<?php echo $encryption; ?>" placeholder="Enter Url">
    </div>
  </div>
<?php if(isset($renderResultSet['encryptionRes'])) { ?>


<table class="table table-bordered">
 <tbody>
  <?php if(count($renderResultSet['encryptionRes'])>0){ foreach($renderResultSet['encryptionRes'] as $key => $value) {?>
    <tr>
      <th scope="row"><?=ucfirst($key)?></th>
      <td><?=($value)?></td>
    </tr>
    <?php } } ?>
  </tbody>
</table>

 
 <?php } ?>
  <div class="form-group"> 
    <div class="col-md-12 text-center">
      <button type="submit" value="encode"  name="button" class="btn btn-primary"><i class="fa fa-angle-double-right"></i> Parse</button>
     
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