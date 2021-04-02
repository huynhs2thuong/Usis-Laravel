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
if($current_locale == 'en'){
	echo '<?xml-stylesheet type="text/xsl" href="'.$url.'/xml-sitemapen.xsl"?>' . "\n";
}else{
	echo '<?xml-stylesheet type="text/xsl" href="'.$url.'/xml-sitemap.xsl"?>' . "\n";
}

?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php 
		foreach($datas as $sitemap){
	?>
 	   <url>
	        <loc>{{$sitemap->getLinkPost($xml)}}</loc>
	        <priority>{{$priority}}</priority>
	        <changefreq>weekly</changefreq>
	        <image:image>
				<image:loc>{{$sitemap->getImage()}}</image:loc>
				<image:title><![CDATA[USIS]]></image:title>
			</image:image>
	        <lastmod>{{$sitemap->updated_at}}</lastmod>
	        <released>{{$sitemap->created_at}}</released>
	        <link>{{$sitemap->getLinkPost($xml)}}</link>
	    </url>
	    <?php
	}
?>
</urlset>
