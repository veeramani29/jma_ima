@extends('templates.default')
@section('content')
<style>
.exhtabs_charts ul.exhibit-tab-footer {
	padding: 0;
	margin: 10px 0 0 0;
	list-style: none;
	float: right;
	border: 1px solid #999;
	border-bottom: none;
}
.exhtabs_charts ul.exhibit-tab-footer li {
	float: left;
	margin: 2px;
	padding: 0 5px;
	border-right: 1px solid #999;
}
.exhtabs_charts ul.exhibit-tab-footer li:last-child {
	border-right: none;
}

</style>
<div class="col-xs-12 col-md-10">
	<?php
	if(isset($result['status']) &&  $result['status']!= 1) {
		?>
		<h3>Sorry, <?php echo (isset($result['message']))?$result['message']:'';?></h3>
		<?php 
	} else {
		$resn = $result['posts'];
		?>
		<?php
		$count = count($resn);
		if($count==0) { ?>
		<h3>Sorry, No news found</h3>
		<?php 
	}
	else { ?>
	<div itemscope itemtype="http://schema.org/Article">
		<div class="sec-date main-title">

			<time itemprop="datePublished" class="released" datetime="<?php if(!empty($resn[0]['post_released'])) { echo stripslashes($resn[0]['post_released']); }//echo isset($published)?date_format($published,'F d Y'):'';?>"><?php if(!empty($resn[0]['post_released'])) { echo stripslashes($resn[0]['post_released']); }//echo isset($published)?date_format($published,'F d Y'):'';?></time>
			<meta itemprop="dateModified" content="<?php if(!empty($resn[0]['post_datetime'])) { echo stripslashes($resn[0]['post_datetime']); }?>">
			<link itemprop="mainEntityOfPage" href="{{Request::fullUrl()}}"/>
			
			<?php if(!empty($resn[0]['post_released'])) { ?>
			<span class="released"><?php //echo stripslashes($resn[0]['post_released']);?></span>
			<?php } ?>
			<h1 itemprop="headline" class="<?php if(empty($resn[0]['post_released'])) echo "title-only"; ?>">
				<?php echo stripslashes($resn[0]['post_title']);?>
			</h1>
			<div class="mttl-line"></div>
		</div>
		<div class="folussoc_con fus_indicator">
			<ul class="list_socail">
				<li class="fs_linkedin" data-toggle="tooltip" title="Share on Facebook">
					<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
				</li>
				<li class="fs_twitter" data-toggle="tooltip" title="Share on Twitter">
					<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
				</li>
				<li class="fs_facebook" data-toggle="tooltip" title="Share on Google">
					<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
				</li>
				<li class="fs_print" data-toggle="tooltip" title="Share&nbsp;on&nbsp;Linkedin">
					<a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
				</li>

				<?php $protocol_ = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
				?>
				<input type="hidden" class="graph_share_input form-control" name="common_share_url" id="common_share_url" value="<?php echo  $protocol_.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'];?>">
			</ul>
		</div>
		
		<?php if(!empty($resn[0]['post_heading'])) {?>
		<h4><?php echo stripslashes($resn[0]['post_heading']);?></h4>
		<?php }?>
		<?php if(!empty($resn[0]['post_subheading'])) {?>
		<h3><?php echo stripslashes($resn[0]['post_subheading']);?></h3>
		<?php }?>
		<div itemprop="articleBody">
			<?php echo $resn[0]['post_cms']; // makeChart(cleanMyCkEditor($resn[0]['post_cms']));?>
		</div>
		<meta itemprop="articleSection" content="Japan Economy">
		<meta itemprop="url" content="{{url('/')}}<?php echo $_SERVER['REQUEST_URI'];?>">
		<span itemprop="author" itemscope itemtype="http://schema.org/Person">
		<!-- 	<meta itemprop="datePublished" content="<?php echo date(strtotime($resn[0]['post_datetime']));?>"> -->
			<meta itemprop="name" content="Takuji Okubo">
		</span>
		<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
		
			 <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
       <meta itemprop="url" content="<?php echo images_path("logo.png");?>">
      <meta itemprop="width" content="221">
      <meta itemprop="height" content="14">
    </span>
    	<meta itemprop="name" content="Japanmacroadvisors">
		</span>
		<span itemprop="image" content="<?php echo !isset($renderResultSet['meta']['shareImage']) ? images_path("ima-logo-sq.jpg"): $renderResultSet['meta']['shareImage'];?>" itemscope="" itemtype="https://schema.org/ImageObject"> 
			<meta itemprop="url" content="<?php echo !isset($renderResultSet['meta']['shareImage']) ? images_path("ima-logo-sq.jpg"): $renderResultSet['meta']['shareImage'];?>">
		</span>
	</div>
	<?php } ?>
	
	<?php if((isset($resn[0]['sugPageTitle1']) && $resn[0]['sugPageTitle1'] !="") || (isset($resn[0]['sugPageTitle2']) && $resn[0]['sugPageTitle2'] !="") || (isset($resn[0]['sugPageTitle3']) && $resn[0]['sugPageTitle3'] !="") || (isset($resn[0]['sugPageTitle4']) && $resn[0]['sugPageTitle4'] !="")) { ?>
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

			<p><a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink1']; ?>>
							View Page
						</a></p> 
				</div>
			<!--  <figcaption>
					<h2>
						<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink1']; ?>>
							View Page
						</a>
					</h2>
				</figcaption>  -->
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
					<p><a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink2']; ?>>
							View Page
						</a></p>
				</div>
			<!-- 	<figcaption>
					<h2>
						<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink2']; ?>>
							View Page
						</a>
					</h2>
				</figcaption>   -->   
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
					<p><a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink3']; ?>>
							View Page
						</a></p>
				</div>
				<!-- <figcaption>
					<h2>
						<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink3']; ?>>
							View Page
						</a>
					</h2>
				</figcaption>      -->
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
					<p><a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink4']; ?>>
							View Page
						</a></p>
				</div>
			<!-- 	<figcaption>
					<h2>
						<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo $resn[0]['sugPageLink4']; ?>>
							View Page
						</a>
					</h2>
				</figcaption>      -->
			</figure>
		</div>
		<?php } ?>
		
		
		
		
		
	</div>
	<?php } ?>
</div>
<div class="addthis_sharing_toolbox" style="float: right"></div>
<?php
 // include('view/templates/rightside.php');
?>
<script type="text/javascript">
$(document).ready(function(e) {
	<?php $cat_array_og = isset($result['category_array'])?json_encode($result['category_array']):''; ?>
	var category_array = JSON.parse('<?php echo $cat_array_og;?>');
	var cat_selected = '';
	$.each(category_array,function(catId,row){
		cat_selected = '.left_cat_'+catId;
		$(cat_selected).addClass("minus");
		//$(cat_selected).parent('ul').css('display','block');
		$(cat_selected).parent('ul').addClass('in');
	});
	$(cat_selected).removeClass('minus');
	$(cat_selected).addClass('active');
});
</script>
<?php
}
?>
@stop
