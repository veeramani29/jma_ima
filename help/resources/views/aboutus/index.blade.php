@extends('templates.default')
@section('content')
<div class="col-md-7 col-xs-12">
	<div class="row">
		<div class="col-md-12">
			<div class="main-title">
				<h1>About <?=SITE_NAME;?></h1>
				<div class="mttl-line"></div>
			</div>
			<p>Our mission is to provide a concise usefull/helpfull information for the benefit of global audiences. We collected this information various source like websites, Social Medias, Real-time Experince , Books , Persons etc., </p>
			<p>The information which includes all the kind of content ,news ,data, video and images etc.,</p>
			<p>Global audiences can free to use the contents form this website. But, don't misuse.  </p>
			<p class="lgray"><?=SITE_NAME;?></p>
			<div class="folussoc_con">
				<h5>Follow Us</h5>
				<ul class="list_socail">
					<li class="fs_linkedin">
						<a target="_blank" href="https://www.linkedin.com/company/japan-macro-advisors" data-toggle="tooltip" title="Linked in">
							<i class="fa fa-linkedin" aria-hidden="true"></i>
						</a>
					</li>
					<li class="fs_twitter">
						<a target="_blank" href="https://twitter.com/JapanMadvisors" data-toggle="tooltip" title="Twitter">
							<i class="fa fa-twitter" aria-hidden="true"></i>
						</a>
					</li>
					<li class="fs_facebook" data-toggle="tooltip" title="Facebook">
						<a target="_blank" href="https://www.facebook.com/Japanmacroadvisors/">
							<i class="fa fa-facebook" aria-hidden="true"></i>
						</a>
					</li>
					<li class="fs_youtube" data-toggle="tooltip" title="Youtube">
                <a target="_blank" href="https://www.facebook.com/Japanmacroadvisors/">
                  <i class="fa fa-youtube" aria-hidden="true"></i>
                </a>
              </li>
				</ul>
			</div>
		</div>
	</div>
	 <!--<div class="row">
		<div class="col-xs-12">
			<div class="main-title">
				<h1>Our Team</h1>
				<div class="mttl-line"></div>
			</div>
		</div>
	</div>-->
	<!--<div class="our_team">
		
	<hr>
		<div class="row ot_member">
			<div class="col-sm-3 col-xs-12 ot_img">
				<img alt="Sumie" src="<?php //echo images_path('About_Sumie.jpg');?>" alt="team image">
			</div>
			<div class="col-sm-9 col-xs-12 ot_content">
				<h4>Sumie Goto</h4>
				<p class="lgray">Chief Marketing Officer</p>
				<p class="ot_readmore"> Sumie is our Chief Marketing Officer. She has an extensive experience in business development and project management in a multinational environment. Prior to joining JMA, she worked for SunGard Financial Systems and P&G. She holds a MBA from University of Leicester, a MS in Chemistry from University of Tokyo and a BS in Chemistry from Kyoto University. </p>
			</div>
		</div>
	</div> -->
	<script type="text/javascript">
	$(document).ready(function(){
		if (window.matchMedia("(max-width: 991px)").matches) {
			$('.ot_readmore').readmore({
				speed: 500,
				collapsedHeight: 73
			});
		}else{
			$('.ot_readmore').readmore({
				speed: 500,
				collapsedHeight: 63
			});
		}
	});
	</script>	
</div>

@include('templates.rightside') 
@stop