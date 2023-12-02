<?php 
$newsContent = $result['news'];
$data = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
  <loc>https://www.japanmacroadvisors.com/</loc>
</url>
<url>
  <loc>https://www.japanmacroadvisors.com/aboutus/</loc>
</url>
<url>
  <loc>https://www.japanmacroadvisors.com/contact/</loc>
</url>
<url>
  <loc>https://www.japanmacroadvisors.com/aboutus/privacypolicy/</loc>
</url>
<url>
  <loc>https://www.japanmacroadvisors.com/aboutus/termsofuse/</loc>
</url>
';
$data .= '</urlset>';
echo $data;
?>