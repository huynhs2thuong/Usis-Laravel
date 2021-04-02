<?php

/**
 * XML Sitemap PHP Script
 * For more info, see: http://yoast.com/xml-sitemap-php-script/
 * Copyright (C), 2011 - 2012 - Joost de Valk, joost@yoast.com
 */


// Sent the correct header so browsers display properly, with or without XSL.
header( 'Content-Type: application/xml' );

echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";

//base url
$url = URL::to('/');

//load layout xsl
echo '<?xml-stylesheet type="text/xsl" href="'.$url.'/xml-sitemap.xsl"?>' . "\n";
?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php 
		foreach($arrayget as $key=>$sitemap){
	?>
 	   <sitemap>
	        <loc><?php echo $sitemap[0]; ?></loc>
	        <lastmod>@if(isset($sitemap[1]->created_at))<?php echo $sitemap[1]->created_at; ?>@endif</lastmod>
	        <link><?php echo $key?></link>
	    </sitemap>
	    <?php
	}
?>
</sitemapindex>
