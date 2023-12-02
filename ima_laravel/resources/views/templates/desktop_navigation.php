<nav class="navbar navbar-default">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?php echo url('/');?>">
							<img alt="Indian GDP Economy" src="<?php echo images_path("logo.png");?>" >
						</a>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="mainNav">
						<ul class="nav navbar-nav navbar-right">
							<li class="<?php echo (thisController()=='home')?'active':'';?>"><a href="<?php echo url('/');?>" class="top_link_common">Home</a></li>
							<li class="<?php echo (thisController()=='aboutus' && thisMethod()=='index')?'active':'';?>"><a href="<?php echo url('aboutus');?>" class="top_link_common">About IMA</a></li>
							<li class="<?php echo (thisController()=='products')?'active':'';?>"><a href="<?php echo url('products');?>" class="top_link_common">Products</a></li>
							<li class="<?php echo (thisMethod()=='career')?'active':'';?>"><a href="<?php echo url('aboutus/career');?>"class="top_link_common">Careers</a></li>
							<li class="<?php echo (thisController()=='contact')?'active':'';?>"><a href="<?php echo url('contact');?>" class="top_link_common">Contact</a></li>
							<li class="<?php echo (thisMethod()=='offerings')?'active':'';?>"><a href="<?php echo url('products/offerings');?>" class="top_link_common">What We Offer</a></li>
							<!-- <li class="<?php echo (thisController()=='search')?'active':'';?>"><a href="<?php echo url('search');?>" class="top_link_common">Search</a></li> -->
							<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {?>
							<li class="jma_username">
								<a href="<?php echo url('user/myaccount');?>" class="top_link_common">
									<?php echo ucfirst($_SESSION['user']['fname']).' '.$_SESSION['user']['lname'];?>
								</a>
							</li>
							<li class="last"><a href="<?php echo url('user/logout');?>" class="top_link_common">Signout</a></li>
							<?php } else {?>
							<li class="last" id="lnk_client_login"><a href="<?php echo url('user/login');?>" class="top_link_client_login">User Login</a></li>
							<?php }?>
						</ul>
						<!-- @include('templates.responsive_navigation') -->
						<ul class="nav navbar-nav mob_navsec">
							<li class="<?php echo (thisController()=='aboutus' && thisMethod()=='index')?'active':'';?>"><a href="<?php echo url('aboutus');?>" class="top_link_common">About IMA</a></li>
							<li class="<?php echo (thisController()=='products')?'active':'';?>"><a href="<?php echo url('products');?>" class="top_link_common">Products</a></li>
							<li class="<?php echo (thisMethod()=='career')?'active':'';?>"><a href="<?php echo url('aboutus/career');?>"class="top_link_common">Careers</a></li>
							<li class="<?php echo (thisController()=='contact')?'active':'';?>"><a href="<?php echo url('contact');?>" class="top_link_common">Contact</a></li>
						</ul>
						<!--<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>