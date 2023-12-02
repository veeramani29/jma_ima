<?php 
// make sure that this is the first character in the file, no spaces before it
//print_r($newsContent[0]['post_url']);
$newsContent = $this->resultSet['result']['news'];
$data = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">';
if($newsContent)
{
	foreach($newsContent as $val)
	{
		//echo $val['post_url'];
		$news_link_url = $this->url(array('controller'=>'reports','action'=>'view','params'=>$val['category_path'].$val['post_url']));
		if($val['post_url']){
			$data .= '<url>
						
						<loc>https:'.$news_link_url.'</loc>
						<news:news>
						  <news:publication>
							<news:name>Japan Macro Advisors</news:name>
							<news:language>en</news:language>
						  </news:publication>
						  <news:genres>OpEd, Opinion</news:genres>
						  <news:publication_date>'.date("Y-m-d",strtotime($val['post_datetime'])).'</news:publication_date>
						  <news:title>'.$val['post_meta_title'].'</news:title>
						  <news:keywords>'.$val['post_meta_keywords'].'</news:keywords>
						</news:news>	
			</url>';
		}
	}
}
$data .= '</urlset>';
echo $data;
?>