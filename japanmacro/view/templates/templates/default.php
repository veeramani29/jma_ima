<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="description" content="<?php echo $this->resultSet['meta']['description'];?>">
	<meta name="keywords" content="<?php echo $this->resultSet['meta']['keywords'];?>">
	<meta name="google-translate-customization" content="1fea04e055fb6965-35248e5248638537-g6177b01b3439e3b2-16"></meta>
	<meta property="og:type" content="article" />
	<meta property="og:image" content="http://content.japanmacroadvisors.com/images/japan-macro-advisors.png" />
	<meta property="og:site_name" content="japanmacroadvisors.com" />
	<meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" />
	<meta property="og:title" content="<?php echo !isset($this->resultSet['meta']['shareTitle']) ? 'Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo' : $this->resultSet['meta']['shareTitle']; ?>" />
	<meta property="og:description" content="<?php echo $this->resultSet['meta']['description'];?>" />
	<meta property="fb:app_id" content="1597539907147636" />
	<base href="<?php echo $this->rootPath; ?>">
	<title><?php echo !isset($this->pageTitle) ? 'Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo' : $this->pageTitle; ?></title>
	<link rel="shortcut icon" href="favicon.ico" type="image/icon">
	<link rel="icon" href="favicon.ico" type="image/icon">
	<!-- <link href="//fonts.googleapis.com/css?family=Arimo:400,700" rel="stylesheet" type="text/css"> -->
	<!-- fontawesome -->
	<link rel="stylesheet" href="<?php  echo $this->assets."plugins/font-awesome/css/font-awesome.css";?>">
	<!-- bootstrap -->
	<link rel="stylesheet" href="<?php  echo $this->assets."plugins/bootstrap/css/bootstrap.css";?>">
	<!-- <link rel="stylesheet" href="<?php  echo $this->css."bootstrap-responsive.css";?>"> -->
	<link href="<?php  echo $this->css."jquery.alerts.css";?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->css."intlTelInput.css";?>" />
	<link rel="stylesheet" media="print" href="<?php echo $this->css."print_page.css";?>" />
	<link rel="stylesheet" href="<?php echo $this->css."jquery.fancybox-1.3.4.css";?>" />
	<link rel="stylesheet" href="<?php echo $this->css."style.css";?>" />
	<script type="text/javascript" src="<?php echo $this->javascript."jquery.min.js";?>"></script>
	<script src="<?php echo $this->javascript."bootstrap.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->javascript."jma.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->javascript."jquery.easing-1.3.pack.js";?>"></script>
<script type="text/javascript" src="<?php echo $this->javascript."Sortable.min.js";?>"></script> 

	
	<script type="text/javascript" src="<?php echo $this->javascript."handlebars-v2.0.0.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->javascript."jquery.fancybox-1.3.4.pack.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->javascript."highstock.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->javascript."jquery.validate.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->javascript."jspdf.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->javascript."intlTelInput.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $this->javascript."jquery.alerts.js";?>"></script>
	<?php echo $this->getAllJavascript(); ?>
	<script type="text/javascript" src="<?php echo $this->javascript."jquery.cookiebar.js";?>"></script>
<!-- <link href="<?php  echo $this->css."master.css";?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" id="themeCSS" href="<?php echo $this->css."classic.css";?>" /> -->
	<link rel="stylesheet" href="<?php echo $this->assets."css/custom-styles.css";?>" />
	<link rel="stylesheet" href="<?php echo $this->assets."css/media.css";?>" />
	<?php echo $this->getAllCss(); ?>
	<script type="text/javascript">
	var objectParams = {
		myChart : {
			folderList : <?php echo json_encode($this->resultSet['result']['category']['folderList']);?>
		}
	};
	var JMA = new Jma('<?php echo $this->rootPath; ?>','<?php echo $this->controllername; ?>','<?php echo $this->actionname; ?>','<?php echo is_array($this->params) ? implode('/', $this->params) : ''; ?>','<?php echo isset($_SERVER['HTTPS']) ? 'https' : 'http'?>',objectParams);
	<?php
	if (isset ( $_SESSION ['user'] ) && $_SESSION ['user'] ['id'] > 0) {
		?>
		JMA.userDetails = <?php echo json_encode($_SESSION['user']);?>;
		<?php
	}
	?>
	</script>
</head>
<body>
	<?php
	$ENV = Config::read('environment');
	if($ENV == 'production') {
		$template = $this->controllername."/".$this->actionname;
		$error_404 = $this->controllername;
		if($error_404 != 'error' && $template != 'user/login' && $template != 'user/forgotpassword' && $template != 'user/completeregistration_success'
			&& $template != 'user/myaccount') {
		?>
		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NX7MF9"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
				new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-NX7MF9');</script>
		<!-- End Google Tag Manager -->
	<?php
		}
	} elseif ($ENV == 'test'){
	?>
		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KGR56S"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
				new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-KGR56S');</script>
		<!-- End Google Tag Manager -->
		<?php
	}
	?>
	<!-- <div class="container"> -->
	<div id="overlay_loading">
		<div class="cssload-preloader">
			<div class="cssload-preloader-box">
				<div>L</div>
				<div>o</div>
				<div>a</div>
				<div>d</div>
				<div>i</div>
				<div>n</div>
				<div>g</div>
			</div>
		</div>
	</div>
	<div class="payloder">
		<div id="spinner">
			<i style="color:red;" class="fa fa-spinner fa-spin fa-5" ></i>
		</div>
	</div>
	<!-- Templates Start -->
	<script type="template/alanee" id="template_graph_full">
	<div class="">
	<div class="">
	<div class="h_graph_wrap notranslate panel panel-default" id="h_graph_wrap_{{chart_details.chartIndex}}">
	<div class="h_graph_graph_area">
	<div class="h_graph_top_area">
	{{#if chart_details.isRightPannel}}
	{{#unless mychart_details.isMyChart}}
	<div class="pull-right">
	<div class="EDHeading">
	<div class="ExportHeading graph-nav" id="EXDOW" >
	<div class="nav-txt"> <i class="fa fa-line-chart" style="color:#EF6F07"></i>&nbsp;SAVE</div>
	<div class="Folders sub-nav">
	<div id="FloatLeft"></div>
	<div id="" class="ExportItem1">
	<select id="save_chart_select_folder_{{chart_details.chartIndex}}" class="addmore-select mychart-select-addto-folder">
	{{#mychart_details.folderList}}
	<option value="{{folder_id}}">{{folder_name}}</option>
	{{/mychart_details.folderList}}
	</select>
	<input type="button" class="btn graph_share_button" value="Save" onClick="JMA.myChart.saveThisChartToFolder({{chart_details.chartIndex}});">
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	{{/unless}}
	{{else}}
	{{#unless mychart_details.isMyChart}}
	<div class="EDHeading">
	<ul class="list-inline list_graphhead">
	<li>
	<div class="ExportHeading graph-nav" id="EXDOW" >
	<a href=""><i class="fa fa-file-image-o"></i> EXPORT</a>
	<div class="Exports sub-nav">
	<div id="FloatLeft"></div>
	<div id="" class="ExportItem1">
	<select id="export_chart_image_select_format_{{chart_details.chartIndex}}" class="addmore-select">
	<option value="jpeg">Image (JPEG)</option>
	<option value="png">Image (PNG)</option>
	<option value="pdf">Document (PDF)</option>
	</select>
	<input type="button" class="btn graph_share_button" value="Export" onClick="JMA.JMAChart.exportChart({{chart_details.chartIndex}});">
	</div>
	<div id="" class="ExportItem2" style="display:none">
	<select id="export_chart_image_size_{{chart_details.chartIndex}}" class="addmore-select">
	<option value="small">Small</option>
	<option value="medium">Medium</option>
	<option value="large">Large</option>
	</select>
	<input type="button" class="btn graph_share_button" value="Export" onClick="JMA.JMAChart.exportChart({{chart_details.chartIndex}});">
	</div>
	</div>
	</div>
	</li>
	<li>
	<div class="DownloadHeading graph-nav" id="EXDOW">
	<a href=""><i class="fa fa-download"></i> DOWNLOAD</a>
	<div class="Downloads sub-nav">
	<select id="download_data_select_format_{{chart_details.chartIndex}}" class="addmore-select" >
	<option value="csv">Comma seperated Value (CSV)</option>
	</select>
	<input type="button"  class="btn graph_share_button" value="Download" onClick="JMA.JMAChart.downloadChartData({{chart_details.chartIndex}});" />
	</div>
	</div>
	</li>
	<li>
	<div class="ExportHeading graph-nav" id="EXDOW" >
	<a href=""><i class="fa fa-line-chart"></i> SAVE</a>
	<div class="Folders sub-nav">
	<div id="FloatLeft"></div>
	<div id="" class="ExportItem1">
	<select id="save_chart_select_folder_{{chart_details.chartIndex}}" class="addmore-select mychart-select-addto-folder">
	{{#mychart_details.folderList}}
	<option value="{{folder_id}}">{{folder_name}}</option>
	{{/mychart_details.folderList}}
	</select>
	<input type="button" class="btn graph_share_button" value="Save" onClick="JMA.myChart.saveThisChartToFolder({{chart_details.chartIndex}});">
	</div>
	</div>
	</li>
	</ul>
	</div>
	</div>
	{{/unless}}
	{{/if}}
	<form name="frm_download_chart_data_{{chart_details.chartIndex}}" id="frm_download_chart_data_{{chart_details.chartIndex}}" method="post" action="<?php echo $this->url('chart/downloadxls');?>">
	<input type="hidden" id="frm_input_download_chart_codes_{{chart_details.chartIndex}}" name="chart_codes" value="">
	<input type="hidden" id="frm_input_download_chart_datatype_{{chart_details.chartIndex}}" name="chart_datatype" value="">
	</form>
	</div>
	<div class="h_graph_content_area" >
	<div class="" id="Jma_chart_container_{{chart_details.chartIndex}}">
	</div>
	</div>
	</div>
	{{#if chart_details.isRightPannel}}
	<div class="h_graph_tab_area">
	<div class="Graph_tabset_tabset_tabs">
	<div chart_index="{{chart_details.chartIndex}}"  class="Graph_tabset_tab active fst Graph_tabset_tab_head_dataseries" contentdiv="#Dv_dataseries_{{chart_details.chartIndex}}"><div class="tab-title">Series</div></div>
	<div chart_index="{{chart_details.chartIndex}}" class="Graph_tabset_tab inactive mdl Graph_tabset_tab_head_download" contentdiv="#Dv_download_{{chart_details.chartIndex}}"><div class="tab-title">Download</div></div>
	{{#unless mychart_details.isMyChart}}
	<div chart_index="{{chart_details.chartIndex}}" class="Graph_tabset_tab inactive mdl Graph_tabset_tab_head_share" contentdiv="#Dv_share_{{chart_details.chartIndex}}"><div class="tab-title">Share</div></div>
	{{/unless}}
	</div>
	<div class="Graph_tabset_contentarea">
	<div id="Dv_dataseries_{{chart_details.chartIndex}}" class="Graph_tabset_contentdiv graph-right">
	&nbsp;
	</div>
	<div id="Dv_download_{{chart_details.chartIndex}}" class="Graph_tabset_contentdiv graph-right" style="display:none">
	<div>
	<div><span class="addmore">Download Data</span></div>
	<div>
	<br>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr><td align="left">
	Select format
	</tr></td>
	<tr><td align="center">
	<select id="download_data_select_format_{{chart_details.chartIndex}}" class="addmore-select">
	<option value="csv">Comma seperated Value (CSV)</option>
	</select>
	</tr></td>
	<tr><td align="center">
	<input type="button" style="margin-top:10px;" class="btn graph_share_button" value="Download" onClick="JMA.JMAChart.downloadChartData({{chart_details.chartIndex}});">
	</tr></td>
	</table>
	</div>
	<br><br>
	<div><span class="addmore">Export Chart</span></div>
	<div>
	<br>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr><td align="left">
	Export as
	</tr></td>
	<tr><td align="center">
	<select id="export_chart_image_select_format_{{chart_details.chartIndex}}" class="addmore-select">
	<option value="jpeg">Image (JPEG)</option>
	<option value="png">Image (PNG)</option>
	<option value="pdf">Document (PDF)</option>
	</select>
	</tr></td>
	<tr><td align="left" style="display:none">
	Select size
	</tr></td>
	<tr><td align="center" style="display:none">
	<select id="export_chart_image_size_{{chart_details.chartIndex}}" class="addmore-select">
	<option value="small">Small</option>
	<option value="medium">Medium</option>
	<option value="large">Large</option>
	</select>
	</tr></td>
	<tr><td align="center">
	<input type="button" style="margin-top:10px;" class="btn graph_share_button" value="Export" onClick="JMA.JMAChart.exportChart({{chart_details.chartIndex}});">&nbsp;&nbsp;
	<input type="button" style="margin-top:10px;" class="btn graph_share_button" value="Print" onClick="JMA.JMAChart.printChart({{chart_details.chartIndex}});">
	</tr></td>
	</table>
	</div>
	</div>
	</div>
	<div id="Dv_share_{{chart_details.chartIndex}}" class="Graph_tabset_contentdiv graph-right" style="display:none">
	<div>
	<div class="social_share_buttons">
	<div class="social_icon_facebook"></div>
	<div class="social_share_button">
	<a href="javascript:void(0)" class="share" link_input_id="graph_share_url_{{chart_details.chartIndex}}" stype="facebook"><input type="button" style="margin-top:10px;" class="btn graph_share_button" value="Share on facebook"></a>
	</div>
	</div>
	<div class="social_share_buttons">
	<div class="social_icon_twitter"></div>
	<div class="social_share_button">
	<a href="javascript:void(0)" class="share" link_input_id="graph_share_url_{{chart_details.chartIndex}}" stype="twitter"><input type="button" style="margin-top:10px;" class="btn graph_share_button" value="Share on twitter"></a>
	</div>
	</div>
	<div class="social_share_buttons">
	<div class="social_icon_googleplus"></div>
	<div class="social_share_button">
	<a href="javascript:void(0)" class="share" link_input_id="graph_share_url_{{chart_details.chartIndex}}" stype="google"><input type="button" style="margin-top:10px;" class="btn graph_share_button" value="Share on google+"></a>
	</div>
	</div>
	<div class="social_share_buttons">
	<div class="social_icon_linkedin"></div>
	<div class="social_share_button">
	<a href="javascript:void(0)" class="share" link_input_id="graph_share_url_{{chart_details.chartIndex}}" stype="linkedin"><input type="button" style="margin-top:10px;" class="btn graph_share_button" value="Share on linkedin"></a>
	</div>
	</div>
	<div class="social_share_buttons">
	<div class="">Share Link</div>
	<div class="social_share_button">
	<input type="text" class="graph_share_input" name="graph_share_url_{{chart_details.chartIndex}}" id="graph_share_url_{{chart_details.chartIndex}}" value="<?php echo '//'.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'];?>" onclick="this.select()" readonly>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	{{/if}}
	</div>
	</div>
	</script>
	<script type="template/alanee" id="template_graph_section_series">
	<div>
	<div class="graph-list" id="Dv_placeholder_graph_series_section_{{chartIndex}}">
	{{#each current_series}}
	<div class="graph-line" id="Dv_placeholder_graph_currentseries_select_{{../chartIndex}}_{{@index}}">
	<select onChange="JMA.JMAChart.populateYSubDropdown({{../chartIndex}},{{@index}},this)">
	{{#each series}}
	<option value="{{@index}}" {{#if isCurrent}}selected{{/if}}>{{label}}</option>
	{{/each}}
	</select>
	{{#each series}}
	{{#if isCurrent}}
	<div class="Dv_placeholder_graph_currentseries_ysub_select">
	<select class="chart-select" onChange="JMA.JMAChart.replaceThisGraphCode({{../../../chartIndex}},{{@../index}},this)">
	{{#each series}}
	<option value="{{code}}" {{#if isCurrent}}selected{{/if}}>{{label}}</option>
	{{/each}}
	</select>
	</div>
	{{/if}}
	{{/each}}
	<div class="graph-line-controls">{{#ifCond @index '>' 0}}<a href="javascript:void(0)" onClick="JMA.JMAChart.removeThisChartCodeByIndex({{../../chartIndex}},{{@index}})">Remove</a>{{/ifCond}}</div>
	</div>
	{{/each}}
	</div>
	{{#if isAddMoreseries}}
	<div class="graph-addmore">
	<span class="addmore">Add More Series</span>
	<select id="select_series_addmore-select_{{chartIndex}}" class="addmore-select">
	{{#each available_series}}
	<option value="{{code}}">{{label}}</option>
	{{/each}}
	</select>
	<div class="dv_addmore-button"><a class="addmore-button" href="javascript:void(0)" onClick="JMA.JMAChart.addThisGraphCode({{chartIndex}})">Add more</a></div>
	</div>
	{{/if}}
	{{#ifCond isBarChart '!=' true}}
	<div class="checkbox"><input type="checkbox" value="checkbox" name="multiaxis_checkbox__{{chartIndex}}" id="multiaxis_checkbox__{{chartIndex}}" {{#if isMultiAxis}}checked{{/if}} onClick="JMA.JMAChart.switchToMultiAxisLine({{chartIndex}},this);">Multiple yAxis</div>
	{{/ifCond}}
	<div class="checkbox"><input type="checkbox" value="checkbox" name="barchart_checkbox__{{chartIndex}}" id="barchart_checkbox__{{chartIndex}}" {{#if isBarChart}}checked{{/if}} onClick="JMA.JMAChart.switchToBarChart({{chartIndex}},this);">Bar chart</div>
	</div>
	</script>
	<!-- Template End -->
	<header>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo $this->url('/');?>">
						<img src="<?php echo $this->images;?>logo.png" alt="">
					</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="mainNav">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo $this->url('/');?>" class="top_link_common">Home</a></li>
						<li><a href="<?php echo $this->url('aboutus');?>" class="top_link_common">About us</a></li>
						<li><a href="<?php echo $this->url('products');?>" class="top_link_common">Products</a></li>
						<!-- <li><a href="<?php // echo $this->url('careers');?>"class="top_link_common">Careers</a></li> -->
						<li><a href="<?php echo $this->url('contact');?>" class="top_link_common">Contact</a></li>
						<li><a href="<?php echo $this->url('aboutus/privacypolicy');?>" class="top_link_common">Our Privacy Policy</a></li>
						<li><a href="<?php echo $this->url('aboutus/commercial_policy');?>" class="top_link_common">Commercial Policy </a></li>
						<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {?>
						<li><a href="<?php echo $this->url('user/myaccount');?>" class="top_link_common"><font color="red"><?php echo ucfirst($_SESSION['user']['fname']).' '.$_SESSION['user']['lname'];?></font></a></li>
						<li class="last"><a href="<?php echo $this->url('user/logout');?>" class="top_link_common">Signout</a></li>
						<?php } else {?>
						<li class="last" id="lnk_client_login"><a href="<?php echo $this->url('user/login');?>" class="top_link_client_login">USER LOGIN</a></li>
						<?php }?>
						<li>
							<div class="gte_con" id="google_translate_element"></div>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-mobmenu">
						<li role="separator" class="divider"></li>
						<li>
							<a href="" class="mob_maitit">
								<i class="fa fa-bar-chart"></i>
								DATA & EVENTS
							</a>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Economic Indicators <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="dropdown dropdown-submenu">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">GDP & Business Activity <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="#">GDP</a></li>
										<li><a href="#">Corporate Profits</a></li>
										<li><a href="#">Industrial Production</a></li>
										<li><a href="#">Machinery Orders</a></li>
										<li><a href="#">Retail Sales</a></li>
										<li><a href="#">Number of Visitors to Japan</a></li>
									</ul>
								</li>
								<li><a href="#">International Balance</a></li>
								<li><a href="#">Leading Indicators</a></li>
								<li><a href="#">Inflation & Prices</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bank of Japan<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">Overview</a></li>
								<li><a href="#">What can the BoJ do?</a></li>
								<li><a href="#">BoJ Policy Meetings</a></li>
								<li><a href="#">BoJ balance sheet</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Politics<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">Overview</a></li>
								<li><a href="#">Who's who</a></li>
								<li><a href="#">Cabinet Approval Rating</a></li>
							</ul>
						</li>
					</ul>
					<!-- dropdown indide dropdown script -->
					<script type="text/javascript">
					$(document).ready(function(){
						$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
							event.preventDefault(); 
							event.stopPropagation(); 
							$(this).parent().siblings().removeClass('open');
							$(this).parent().toggleClass('open');
						});
					});
					</script>
					<script type="text/javascript">
					function googleTranslateElementInit() {
						new google.translate.TranslateElement({pageLanguage: 'en',includedLanguages: 'af,ca,da,de,el,en,es,fr,it,ko,nl,pl,pt,ru,sv,tl', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
					}
					</script>
					<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
	</header>
	<section>
		<div id="carousel_home" class="carousel slide carousel_home" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			</ol>
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<?php for ($b=0; $b <3 ; $b++) { ?>
				<div class="item <?php echo ($b==0)?"active":'';?>">
					<img src="images/slider/slider<?php echo ($b+1);?>.jpg" alt="...">
					<div class="color_overlayd"></div>
					<div class="carousel-caption">
						<h4>CONCISE AND INSIGHTFUL ANALYSIS ON THE JAPANESE ECONOMY</h4>
						<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) { ?>
						<a class="btn btn-primary btn_carhom" href=<?php echo $this->url('user/myaccount/subscription');?>>
							<?php if ($_SESSION['user']['user_type'] == 'corporate') {?>
							<i style="color: #22558F;" class="fa fa-building fa-lg"></i>&nbsp;<strong>Corporate</strong>
							<?php } ?>
							<?php if ($_SESSION['user']['user_type'] == 'individual') {?>
							<i class="fa fa-user fa-lg" style="color: #22558F;"></i><sup><i style="color: #22558F;" class="fa fa-star fa-fw"></i></sup> <b>Premium</b>
							<?php } ?>
							<?php if ($_SESSION['user']['user_type'] == 'free') {?>
							<p><i style="color: #6EB92B;" class="fa fa-user fa-lg"></i> &nbsp;<strong>Free</strong></p>
							<?php } ?>
						</a>
						<?php }else{ ?>
						<a class="btn btn-primary btn_carhom" href="<?php echo $this->url('user/signup');?>">
							<i class="fa fa-play-circle"></i>
							Register for a Free account
						</a>
						<?php   } ?>
					</div>

				</div>
				<?php } ?>

			</div>

			<!-- Controls -->
			<a class="left carousel-control" href="#carousel_home" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel_home" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</section>
	<section class="container">
		<div class="col-md-2 content_leftside">
			<?php  include ('view/templates/left_navigation.php');?>
		</div>
		<div class="col-sm-<?php echo (isset($_GET['url']) && $_GET['url']=='products')?10:7;?>">
			<?php
			$this->view ();
			?>
		</div>
		<?php if($_GET['url']!='products'){?>
		<div class="col-sm-3">
			<?php include ('view/templates/rightside.php');?>
		</div>
		<?php } ?>
	</section>
	<footer class="container">
		<hr>
		<?php include ('view/templates/footer.php');?>
	</footer>
	<!-- Modal Start -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="pull-left">
						<h4 class="modal-title">Login</h4>
					</div>
					<div class="pull-right icons">
						<div class="col-md-4 download-img" >
							<i class="fa fa-user fa-lg" style="color: #6EB92B;"></i><b>FREE</b>
						</div>
						<div class="col-md-4 premium-img">
							<i class="fa fa-user fa-lg" style="color: #22558F;"></i>
							<sup>
								<i class="fa fa-star fa-fw"
								style="color: #22558F; font-size: 12px; margin: -7px 0 0 -6px;"></i>
							</sup>
							<b>PREMIUM</b>
						</div>
						<div class="col-md-4 premium-img">
							<i class="fa fa-building fa-lg"
							style="color: #22558F;"></i><b>CORPORATE</b>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<form>
						<div class="text-center form-group mychart">
							<p>This feature is restricted <b>for logged-in users only.</b> <br> If you
								are a FREE / PREMIUM / CORPORATE account user, please log-in.<br></p>
							</div>
							<div class="text-center form-group premium">
								<p>This content is restricted <b>for paying users only.</b> <br> If you
									are a PREMIUM / CORPORATE account user, please log-in.<br></p>
								</div>
								<div class="text-center form-group download">
									<p>Please log-in to access our <b>data download function.</b><br></p>
								</div>
								<div class="text-center form-group">
									<a href="<?php echo $this->url('user/linkedinProcess');?>" class="linkedIn"><img src="<?php echo $this->images;?>sign-in-with-linkedin.png" /></a>
								</div>
								<p class="text-center" >OR</p>
								<p class="login_frm_ajx_login_status" style="font-size: 12px;display: none;"></p>
								<div class="form-group">
									<label for="recipient-name" class="control-label">Recipient:</label> <input class="form-control" placeholder="Email" name="login_email" id="login_email">
								</div>
								<div class="form-group">
									<label for="recipient-name" class="control-label">Recipient:</label>
									<input type="password" class="form-control"  placeholder="Password" name="login_password" id="login_password"  />
									<input type="hidden" name="chart_login_perm_type" id="chart_login_perm_type" >
									<input type="hidden" name="chart_login_chart_index" id="chart_login_chart_index">
									<input type="hidden" name="chart_login_premium_url" id="chart_login_premium_url">
								</div>
								<button type="button"  class="btn btn-primary" name="login_btn" id="pop_login_btn">
									<i class="fa fa-angle-double-right"></i> Submit</button>
									<a class="btn" id="SubmitForgotPss"  href="<?php echo $this->url('user/forgotpassword');?>">Forgot
										Password?</a>
										<p class="premium-logininfo"><a href="<?php echo $this->url('products');?>">Upgrade or Register for </a> PREMIUM or CORPORATE account.</p>
										<p class="download-logininfo">
											Not registered?</br>
											<i class="fa fa-play-circle" style="color: #F39019; font-size: 20px;padding: 1px 5px 3px 2px;"></i>
											<a href="<?php echo $this->url('products');?>">Setup a <b>Free Account</b></a> to access our services free of charge.
										</p>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal End-->
					<!-- Auto Modal Start-->
					<?php if(!isset($_COOKIE['isLoginBox']) || $_COOKIE['isLoginBox'] !='0'){?>
					<div class='popup'>
						<div class='cnt223'>
							<div class="POPUser">
								<i class="fa fa-user fa-lg"
								style="color: #666666; font-size: 17px; margin: 0 4px 1px 5px;"></i>User
								Login
								<div alt='quit' class='x' id='x'>
									<i class="fa fa-times" style="color: #EA2635"></i>
								</div>
							</div>
							<div id="Dv_login_wrapper">
								<form name="login_frm" id="login_frm"
								action="<?php echo $this->url('/user/login');?>" method="post">
								<div class="login_box_input">
									<input type="text" placeholder="Email"
									class="formPop_textfield" name="login_email"
									id="login_email" />
								</div>
								<div class="login_box_input">
									<input type="password" placeholder="password"
									class="formPop_textfield" name="login_password"
									id="login_password" />
								</div>
								<p class="text-center" >OR</p>
								<div style="margin-bottom: 10px;">
									<a href="<?php echo $this->url('user/linkedinProcess');?>"><img style="height:35px;" src="<?php echo $this->images;?>sign-in-with-linkedin.png" /></a>
								</div>
								<div class="login_box_input">
									<input type="checkbox" value="y" id="login_rememberMe" name="login_rememberMe" /> Keep me signed in
								</div>
								<div class="login_box_input">
									<input type="submit" value="Submit"
									class="btn btn-primary" name="login_btn"  />
								</div>
								<div class="ForPassword">
									<a href="<?php echo $this->url('user/forgotpassword');?>">Forgot
										your password?</a>
									</div>
								</form>
								<div class="HR"></div>
							</div>
						</div>
					</div>
					<?php }?>
					<!-- Auto Modal End-->
				</body>
				<!-- Go to www.addthis.com/dashboard to customize your tools -->
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-560a39ae0a881b48" async="async"></script>
				<script type="text/javascript">
//script
if ( !("placeholder" in document.createElement("input")) ) {
	$("input[placeholder], textarea[placeholder]").each(function() {
		var val = $(this).attr("placeholder");
		if ( this.value == "" ) {
			this.value = val;
		}
		$(this).focus(function() {
			if ( this.value == val ) {
				this.value = "";
			}
		}).blur(function() {
			if ( $.trim(this.value) == "" ) {
				this.value = val;
			}
		});
	});
    // Clear default placeholder values on form submit
    $('form').submit(function() {
    	$(this).find("input[placeholder], textarea[placeholder]").each(function() {
    		if ( this.value == $(this).attr("placeholder") ) {
    			this.value = "";
    		}
    	});
    });
  }
  </script>
  </html>