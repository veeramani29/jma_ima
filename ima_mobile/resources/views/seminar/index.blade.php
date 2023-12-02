@extends('templates.default')
@section('content')
<div class="col-md-7 col-xs-12">
	<div class="main-title">
		<h1>Strengthening the economic tie between India and Japan</h1>
		<div class="mttl-line"></div>
	</div>
	<div class="slick_seminar">
		<div>
			<a href="<?php //echo $media['media_link'];?>" target="_blank">
				<img src="<?php echo images_path('JNU1.jpg');?>" alt="JMA Banners">
			</a>
		</div>
		<div>
			<a href="<?php //echo $media['media_link'];?>" target="_blank">
				<img src="<?php echo images_path('JNU2.jpg');?>" alt="JMA Banners">
			</a>
		</div>
	</div>
	<p>The chief economist and founder of our sister company Mr. Takuji Okubo delivered a seminar on "Strengthening the economic tie between India and Japan" with specific focus on "The growing middle class in Asia and its implications". The seminar started with discussing the current rise of populism in Western developed world. The rise in income inequality in those countries mainly gave rise to populism. On the other hand the countries in Asia have experienced a decline in income inequality and hence the rise of populism seemed unlikely in those countries. The discussion then moved on to the major economies of Asia and how they have performed since the second world war. Japan was once the largest economy in the continent but it has now been overshadowed by fast growing economies of China and India.</p>
	<div class="spacer10f"></div>
	<div class="sub-title">
		<h5>The Q&A session</h5>
		<div class="sttl-line"></div>
	</div>
	<p>During the end of the seminar a Q&A session was held between Mr. Takuji Okubo and the participating faculty members and the students. Here the topic of Japan's high growth compared to other Asian countries in the early 20th century was discussed. The main reasons of the notable growth were: introduction of mandatory formal education all over the country, Japan's inclination towards innovative technology,etc. </p>
	<p>The seminar ended with a note of thanks to the CMS-Center of Management Studies, Jain University from the speaker.</p>
	<p>To view the presentation of the seminar please <a href="<?php echo url('/Docs/jain_cms.pdf');?>" target="_blank">Click here</a></p>
</div>
 @include('templates.rightside')
<?php //include('view/templates/rightside.php'); ?>
<script type="text/javascript" src="<?php  echo asset("assets/plugins/slick/slick.min.js");?>"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.slick_seminar').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 3000
	});
});
</script>
@stop