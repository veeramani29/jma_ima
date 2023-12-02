<?php
$resn = $this->resultSet['result']['news'];
?>
<div class="col-xs-12 col-md-10">
	<?php
	$count = count($resn);
	if($count==0)
	{
		?>
		<h3>Sorry, No news found</h3>
		<?php
	}
	else
	{
		?>
		<div itemscope itemtype="http://schema.org/Article">
			<?php if(!empty($resn[0]['post_released'])) {?><p class="released"><?php echo stripslashes($resn[0]['post_released']);?></p><?php }?>
			<h3 itemprop="name" class="<?php if(empty($resn[0]['post_released'])) echo "title-only"; ?>"><?php echo stripslashes($resn[0]['post_title']);?></h3>
			<?php if(!empty($resn[0]['post_heading'])) {?><h5><?php echo stripslashes($resn[0]['post_heading']);?></h5><?php }?>
			<?php if(!empty($resn[0]['post_subheading'])) {?><h3><?php echo stripslashes($resn[0]['post_subheading']);?></h3><?php }?>
			

			<?php if(!empty($resn[0]['post_image']) && $resn[0]['post_image']!=null) { ?>
		<p><img width="640" height="360" src="public/uploads/postImages/<?php echo $resn[0]['post_image']; ?>" alt="alt="Bearking News Image""></p>

		<?php } ?>
		
		
			<div itemprop="articleBody">
				<?php echo $resn[0]['post_cms']; // makeChart(cleanMyCkEditor($resn[0]['post_cms']));?>
			</div>
			
			
			<meta itemprop="articleSection" content="Japan Economy">
			<meta itemprop="url" content="http:/<?php echo $_SERVER['REQUEST_URI'];?>">
			<span itemprop="author" itemscope itemtype="http://schema.org/Person">
				<meta itemprop="datePublished" content="<?php echo date(strtotime($resn['post_datetime']));?>">
				<meta itemprop="name" content="Takuji Okubo">
			</span>
			<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<meta itemprop="name" content="Japanmacroadvisors">
			</span>
			<?php if($resn[0]['sugPageTitle1'] !="" || $resn[0]['sugPageTitle2'] !="" || $resn[0]['sugPageTitle3'] !="" || $resn[0]['sugPageTitle4'] !="") { ?>
				<div class="suggestion_con">
					<div class="col-xs-12">
						<div class="main-title">
							<h1>Suggested Pages</h1>
							<div class="mttl-line"></div>
						</div>
					</div>
					
					<?php if($resn[0]['sugPageTitle1'] !="") { ?>
					<div class="col-sm-3">
						<figure class="effect-zoe">
							<div class="sugttl_con">
								<div class="sub-title">
									<h5><?php echo $resn[0]['sugPageTitle1']; ?></h5>
									<div class="sttl-line"></div>
								</div>
								<p><?php echo $resn[0]['sugPageDesc1']; ?></p>
							</div>
							<figcaption>
								<h2>
									<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink1']; ?>>
										View Page
									</a>
								</h2>
							</figcaption>     
						</figure>
					</div>
					<?php } ?>
					
					<?php if($resn[0]['sugPageTitle2'] !="") { ?>
					<div class="col-sm-3">
						<figure class="effect-zoe">
							<div class="sugttl_con">
								<div class="sub-title">
									<h5><?php echo $resn[0]['sugPageTitle2']; ?></h5>
									<div class="sttl-line"></div>
								</div>
								<p><?php echo $resn[0]['sugPageDesc2']; ?></p>
							</div>
							<figcaption>
								<h2>
									<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink2']; ?>>
										View Page
									</a>
								</h2>
							</figcaption>     
						</figure>
					</div>
					<?php } ?>
					
					<?php if($resn[0]['sugPageTitle3'] !="") { ?>
					<div class="col-sm-3">
						<figure class="effect-zoe">
							<div class="sugttl_con">
								<div class="sub-title">
									<h5><?php echo $resn[0]['sugPageTitle3']; ?></h5>
									<div class="sttl-line"></div>
								</div>
								<p><?php echo $resn[0]['sugPageDesc3']; ?></p>
							</div>
							<figcaption>
								<h2>
									<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink3']; ?>>
										View Page
									</a>
								</h2>
							</figcaption>     
						</figure>
					</div>
					<?php } ?>
					
					<?php if($resn[0]['sugPageTitle4'] !="") { ?>
					<div class="col-sm-3">
						<figure class="effect-zoe">
							<div class="sugttl_con">
								<div class="sub-title">
									<h5><?php echo $resn[0]['sugPageTitle4']; ?></h5>
									<div class="sttl-line"></div>
								</div>
								<p><?php echo $resn[0]['sugPageDesc4']; ?></p>
							</div>
							<figcaption>
								<h2>
									<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink4']; ?>>
										View Page
									</a>
								</h2>
							</figcaption>     
						</figure>
					</div>
					<?php } ?>
					
					
					
					
					
				</div>
				<?php } ?>
				<div class="addthis_sharing_toolbox" style="float: right"></div>
		</div>
		
	</div>
	<?php } ?>
	
<?php
 // include('view/templates/rightside.php');
?>