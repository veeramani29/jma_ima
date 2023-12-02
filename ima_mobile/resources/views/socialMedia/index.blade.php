<?php 
$shareDetails = $result['getsharedetails'];

$full_url=url('socialmedia/shareSocialmedia')."/".$shareDetails[0]['uniqcode']; 
?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
	<meta property="fb:app_id" content="1597539907147636" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo $shareDetails[0]['imagepath']; ?>" />


	

	<meta property="og:url" content="<?php echo $full_url;?>" />
	<meta property="og:title" content="<?php echo $shareDetails[0]['title']; ?>" />
	<meta property="og:description" content="<?php echo $shareDetails[0]['description']; ?>" />
	<meta property="og:image:width" content="506" />
	<meta property="og:image:height" content="274" />
	<!-- 486 <meta property="fb:redirect_uri" content="<?php echo $shareDetails[0]['url']; ?>"/> -->
	
	<!-- Twitter commonds -->	
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@japanmacroadvisors">
	<meta name="twitter:creator" content="@Srinivasan - Developer">
	<meta name="twitter:url" content="<?php echo $full_url;?>">
	<meta name="twitter:title" content="<?php echo $shareDetails[0]['title']; ?>">
	<meta name="twitter:description" content="<?php echo $shareDetails[0]['description']; ?>">
	<meta name="twitter:image" content="<?php echo $shareDetails[0]['imagepath']; ?>">
	<meta name="twitter:image:width" content="506" />
	<meta name="twitter:image:height" content="274" />
	
	<meta name="twitter:app:name:iphone" content="Japan Macro Advisors Economy News"/>
	<meta name="twitter:app:id:iphone" content="3255626666"/>
	<meta name="twitter:app:name:googleplay" content="Japan Macro Advisors Mobile News"/>
	<meta name="twitter:app:url:iphone" content="https://itunes.apple.com/us/app/japanmacroadvisors-economy-news/id3255626666"/> 
	<meta name="twitter:creator" content="JapanMacroAdvisors" />
	
<head>
    <body>
	</body>
</html>
<script>window.location.href="<?php echo $shareDetails[0]['url']; ?>"</script>
	
 