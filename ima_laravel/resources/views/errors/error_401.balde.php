@extends('templates.default')
@section('content')
<div class="col-md-7">
	<div class="error_401">
		<h1 class="err_401">401</h1>
		<div class="row">
			<div class="col-xs-12 col-sm-3">
				<p class="text-center">
					<i class="fa fa-warning"></i>
				</p>
			</div>
			<div class="col-xs-12 col-sm-9">
				<h4>Sorry...! Access Denied.Authorization Required</h4>
				<p>
					<b>
						Sorry..! you do not have permission to view premium ontents. Please review your subscription status
						<a href="<?php echo $this->url('user/myaccount');?>">Account details</a> .
					</b>
					<br><br> Thank you again for being a JMA user and we welcome any feedback you like to share with us at
					<a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>.
				</p>
			</div>
		</div>
	</div>
</div>
 @include('templates.rightside') 
@stop