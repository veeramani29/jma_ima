@extends('templates.default')
@section('content')
<div class="col-md-7">
	<div class="error_401">
		<!-- <h1 class="err_401">401</h1> -->
		<div class="row">
			<div class="col-xs-12 col-sm-3">
				<p class="text-center">
					<i class="fa fa-warning"></i>
				</p>
			</div>
			<div class="col-xs-12 col-sm-9">
				 <h4 class="modal-title text-warning">Sorry! This feature is restricted</h4>
      <br>
      <p><b> Please review your subscription status in account details <a href="<?php echo url('user/myaccount/subscription');?>">here</a></b>. </p>
            <p>You can visit our <a target="_balnk" href="<?php echo url('product');?>">product page</a> for more details on what we offer</a></p>
            <p>We welcome any feedback you like to share with us at <a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>. </p>
			</div>
		</div>
	</div>
</div>
 @include('templates.rightside') 
@stop