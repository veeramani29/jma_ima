<?php
$newsContent = isset($result['news'])?$result['news']:'';
echo "<?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>
<channel>
<title>Unbiased Opinion on Japan's Economy | JMA offers independent analysis and easy access to economic data</title>
<link>http://japanmacroadvisors.com</link>
<description>Japan Macro Advisors offers an independent and unbiased economic analysis on the Japanese economy. Through our forecast, regularly updated economic commentaries, over 2000 downloadable economic data and free use of interactive charts, we aim to contribute to an open and evidence-based debate on Japan's economic future.</description>
<language>en-us</language>";

if(is_array($newsContent) && $newsContent)
{
	foreach($newsContent as $val)
	{
		$title=($val['post_title'] != '' ? $val['post_title'] : "null");
		$news_link_url = url('reports/view/'.$val['category_path'].$val['post_url']);
		$description=($val['post_cms_small'] != '' ? $val['post_cms_small'] : "null");

		echo "<item>";
		echo "<title>".trim($title)."</title>";
		echo "<link>".trim($news_link_url)."</link>";
		echo "<description>".trim($description)."</description>";
		echo "</item>";
	}
}	
echo "</channel></rss>";



?>