@extends('templates.default')
@section('content')
<div class="col-xs-12 col-md-10">
	<?php
	if(isset($result['status']) && $result['status'] != 1) {
		?>
		<h3>Sorry, <?php echo isset($result['message'])?$result['message']:'';?></h3>
		<?php
	} else {
		$resn = $result['posts'];
		?>
		<?php
		$count = count($resn);
		if($count==0){
			?>
			<h3>Sorry, No news found</h3>
			<?php
		} else { ?>
		
		<div itemscope itemtype="http://schema.org/Article">
			<div class="sec-date main-title">
				<?php if(!empty($resn[0]['post_released'])) {?><span class="released"><?php echo stripslashes($resn[0]['post_released']);?></span><?php }?>
				<h1 itemprop="name" class="<?php if(empty($resn[0]['post_released'])) echo "title-only"; ?>"><?php echo stripslashes($resn[0]['post_title']);?></h1>
				<div class="mttl-line"></div>
			</div>
			<?php if(!empty($resn[0]['post_heading'])) { ?>
			<h5 style="margin:0px"><?php echo stripslashes($resn[0]['post_heading']);?></h5>
			<?php } ?>
			<?php if(!empty($resn[0]['post_subheading'])) { ?>
			<h3><?php echo stripslashes($resn[0]['post_subheading']);?></h3>
			<?php } ?>
			<div class="folussoc_con fus_indicator">
				<ul class="list_socail">
					
					<li class="fs_facebook" data-toggle="tooltip" title="Facebook"><a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="facebook"title="Share on facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li class="fs_twitter" data-toggle="tooltip" title="Twitter"><a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="twitter"title="Share on twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<li class="fs_google" data-toggle="tooltip" title="Google"><a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="google" title="Share on google+"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
					<li class="fs_linkedin" data-toggle="tooltip" title="Linkedin"><a href="javascript:void(0)" class="commonShare" link_input_id="common_share_url" stype="linkedin" title="Share on linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>

					<?php $protocol_ = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
					?>
					<input type="hidden" class="graph_share_input form-control" name="common_share_url" id="common_share_url" value="<?php echo $protocol_.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'];?>">
				</ul>
			</div>
			<?php if($resn[0]['premium_news']!='Y' && !empty($resn[0]['post_image']) && $resn[0]['post_image']!=null) { ?>
			<p><img width="640" height="360" src="public/uploads/postImages/<?php echo $resn[0]['post_image']; ?>" alt="alt="Bearking Reports Image""></p>
			<?php } ?>
			<div itemprop="articleBody">
				<?php	if($resn[0]['premium_news']=='Y' && $resn[0]['post_type']=='N' && ((Session::has('user') && (Session::get('user.user_type_id')==1 )) || !Session::has('user'))){
					echo "<p><strong>Summary</strong></p><p class='rdt_readmore'>".$resn[0]['post_cms_small']."</p>";
					if(!Session::has('user')){
                    $popup_link_url="href='javascript:JMA.User.showLoginBox(".'"premium","'.url()->current().'"'.");'";
               }else{
           $popup_link_url="data-toggle='modal' data-target='#Dv_modal_upgrade_premium_content'";  
               }
               if(!Session::has('user') || (Session::has('user') && Session::get('user.user_type_id')==1 )){
					if((Session::has('user') && Session::get('user.user_type_id')==1 )){ 
$text_msg="<p><strong>If you are a Free account user registered before Jan 2018, please upgrade your subscription status from <a href=".url('user/myaccount/subscription').">here</a>. </strong></p>";
}else{

$text_msg="<p><strong>If you are already a JMA subscriber please <a class='subscriber_login' ".$popup_link_url." >login</a></strong></p>";
}
					echo "<div style='padding:20px 20px 11px;background-color: #dddddd;'><p><strong> To read a full report, please become a Standard / Corporate subscriber.</strong></p><a target='_blank' href='".url('products')."' class='rdt_modal btn btn-success'>Start a subscription with 30-days Free Trial <i class='fa fa-angle-right' aria-hidden='true'></i></a>".$text_msg."</div>";
		?>
			
			   <?php }} else{  ?>
		<?php echo $resn[0]['post_cms']; } ?>
			</div>
			<meta itemprop="articleSection" content="Japan Economy">
			<meta itemprop="url" content="http:/<?php echo $_SERVER['REQUEST_URI'];?>">
			<span itemprop="author" itemscope itemtype="http://schema.org/Person">
				<meta itemprop="datePublished" content="<?php echo date(strtotime($resn[0]['post_datetime']));?>">
				<meta itemprop="name" content="Takuji Okubo">
			</span>
			<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
				<meta itemprop="name" content="Japanmacroadvisors">
			</span>
			<?php if(isset($result['getLatestNewsItems']) && count($result['getLatestNewsItems'])>0) { ?>
			<div class="suggestion_con">
				<div class="col-xs-12">
					<div class="main-title">
						<h1>Recently Published</h1>
						<div class="mttl-line"></div>
					</div>
				</div>
				<?php for ($ln=0; $ln <count($result['getLatestNewsItems']) ; $ln++) { 
				 ?>
				<div class="col-sm-3">
					<figure class="effect-zoe">
						<div class="sugttl_con">
							<div class="sub-title">


								<h5><a style="color:#4A4A48" target="_blank" href="<?php echo url('news/view/'.$result['getLatestNewsItems'][$ln]['post_url']); ?>"><?php echo $result['getLatestNewsItems'][$ln]['post_title']; ?></a></h5>
								<div class="sttl-line"></div>
							</div>
							<p><?php echo (strlen($result['getLatestNewsItems'][$ln]['post_cms_small'])>80)?substr($result['getLatestNewsItems'][$ln]['post_cms_small'], 0,80)."...":$result['getLatestNewsItems'][$ln]['post_cms_small']; ?></p>
						</div>
						<figcaption>
							<h2>
								<a class="btn btn-primary btn-sm" target="_blank" href=<?php echo url('news/view/'.$result['getLatestNewsItems'][$ln]['post_url']); ?>>
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
		<?php	} ?>
	</div>
	<div id="veera"></div>
	<?php } ?>
	@stop