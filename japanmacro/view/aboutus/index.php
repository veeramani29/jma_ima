<div class="col-md-7 col-xs-12">
	<div class="row">
		<div class="col-md-12">
			<div class="main-title">
				<h1>About Japan Macro Advisors</h1>
				<div class="mttl-line"></div>
			</div>
			<p>Our mission is to provide a concise and timely analysis on the Japanese economy for the benefit of global audiences. Communication, especially in foreign languages, has always been a weakness for the Japanese, which was fine when Japan's economic might attracted foreign media and various other institutions to study and report on Japan - such days are long gone. In the last two decades, we saw foreign institutions reallocating their resources from Japan to other more exciting parts of the world. As a result, when we read reporting on Japan in foreign media, we sense a subtle but noticeable decline in the depth of understanding what is actually happening in Japan. </p>
			<p>Many Japanese may even be comfortable with such neglection. But, the lack of understanding can be a critical deficit especially in time of crisis. What happened in the aftermath of the East Japan Earthquake was shocking as well as instructive for us. The Japanese government, in a crisis mode, hardly paid any attention to providing information to the non-Japanese audience. Such deficiency led to uncertainty and general loss of trust in Japan. We aim to fill this information void.</p>
			<p>Tough roads await Japan. A fiscal crisis is almost a certainty in the near future. However, it is also our belief that Japan has the capacity to resolve difficulties and eventually return to a path of prosperity. We hope our service provides you with timely insights and a deeper understanding of Japan.</p>
			<p class="lgray">Managing Director and Chief Economist<br /> Takuji Okubo</p>
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
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="main-title">
				<h1>Our Team</h1>
				<div class="mttl-line"></div>
			</div>
		</div>
	</div>
	<div class="our_team">
		<div class="row ot_member">
			<div class="col-sm-3 col-xs-12 ot_img">
				<img src="<?php echo $this->images;?>about_takuji.png" alt="Takuji" >
			</div>
			<div class="col-sm-9 col-xs-12 ot_content">
				<h4>Takuji Okubo</h4>
				<p class="lgray">Managing Director and Chief Economist</p>
				<p class="ot_readmore">
					Prior to founding JMA, he worked as Chief Economist for Societe Generale in Tokyo, covering the Japanese and South Korean economy. His previous positions includes Senior Economist at Merrill Lynch and at Goldman Sachs. Apart from work, he enjoys motor-cycling, scuba-diving, cooking as well as worrying about the future of the Japanese economy. Takuji holds B.A in Economics from Tokyo University, MBA from INSEAD and post graduate degrees in Economics from UPF in Barcelona.
				</p>
			</div>
		</div>
		<hr>
		<div class="row ot_member">
			<div class="col-sm-3 col-xs-12 ot_img">
				<img alt="Komagata" src="<?php echo $this->images;?>komagata.png" alt="team image">
			</div>
			<div class="col-sm-9 col-xs-12 ot_content">
				<h4>Kokichi Komagata</h4>
				<p class="lgray">Managing Director</p>
				<p class="ot_readmore">Prior to joining the firm in 2015, he was Chairman at Kokusai Asset Management (currently Mitsubishi UFJ Kokusai Asset Management) between 2012 and 2014. He has worked in various executive positions, including CEO of Tokyo-Mitsubishi International in London, Senior executive officer at Mitsubishi Securities. He has also held held various public positions including Board Member of the Investment Trusts Association.</p>

			</div>
		</div>
		<hr>
		<div class="row ot_member">
			<div class="col-sm-3 col-xs-12 ot_img">
				<img alt="Sumie" src="<?php echo $this->images;?>About_Sumie.jpg" alt="team image">
			</div>
			<div class="col-sm-9 col-xs-12 ot_content">
				<h4>Sumie Goto</h4>
				<p class="lgray">Chief Marketing Officer</p>
				<p class="ot_readmore"> Sumie is our Chief Marketing Officer. She has an extensive experience in business development and project management in a multinational environment. Prior to joining JMA, she worked for SunGard Financial Systems and P&G. She holds a MBA from University of Leicester, a MS in Chemistry from University of Tokyo and a BS in Chemistry from Kyoto University. </p>
			</div>
		</div>
	</div>
	
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
<?php include('view/templates/rightside.php'); ?>