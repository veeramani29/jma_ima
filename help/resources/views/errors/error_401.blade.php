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
     
            <p>We welcome any feedback you like to share with us at <a href="mailto:<?=GENERAL_EMAIL;?>"><?=GENERAL_EMAIL;?></a>. </p>
			</div>
		</div>
	</div>
</div>
 @include('templates.rightside') 
@stop