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
if($current_locale == 'en'){
    $gioithieuurl = 'about-us';
    $visa = 'united-states-immigration-visa-for-eb-5-investment-program';
    $doitacurl = 'partners';
    $hoatdongurl = 'activities';
    $newurl = 'us-news';
    $lienheurl = 'lien-he';
}else{
    $gioithieuurl = 'gioi-thieu-usis';
    $visa = 'visa-dinh-cu-my-theo-dien-dau-tu-eb-5';
    $doitacurl = 'doi-tac';
    $hoatdongurl = 'hoat-dong-usis';
    $newurl = 'tin-tuc-my';
    $lienheurl = 'lien-he';
}
//load layout xsl
echo '<?xml-stylesheet type="text/xsl" href="'.$url.'/xml-sitemap.xsl"?>' . "\n";
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
        <loc>{{action('SiteController@showPagegioiThieu',$gioithieuurl)}}</loc>
        <priority>{{$priority}}</priority>
        <changefreq>weekly</changefreq>
        <image:image>
			<image:loc>{{$gioithieu->getImage()}}</image:loc>
			<image:title><![CDATA[USIS]]></image:title>
		</image:image>
        <lastmod>{{$gioithieu->updated_at}}</lastmod>
        <released>{{$gioithieu->created_at}}</released>
        <link>{{action('SiteController@showPagegioiThieu',$gioithieuurl)}}</link>
    </url>
    <url>
        <loc>{{action('SiteController@showPageDichVu',$visa)}}</loc>
        <priority>{{$priority}}</priority>
        <changefreq>weekly</changefreq>
        <image:image>
			<image:loc>{{$dichvu->getImage()}}</image:loc>
			<image:title><![CDATA[USIS]]></image:title>
		</image:image>
        <lastmod>{{$dichvu->updated_at}}</lastmod>
        <released>{{$dichvu->created_at}}</released>
        <link>{{action('SiteController@showPageDichVu',$visa)}}</link>
    </url>
    <url>
        <loc>{{action('SiteController@projects')}}</loc>
        <priority>{{$priority}}</priority>
        <changefreq>weekly</changefreq>
        <image:image>
			<image:loc>{{$duan->getImage()}}</image:loc>
			<image:title><![CDATA[USIS]]></image:title>
		</image:image>
        <lastmod>{{$duan->updated_at}}</lastmod>
        <released>{{$duan->created_at}}</released>
        <link>{{action('SiteController@projects')}}</link>
    </url>
    <url>
        <loc>{{action('SiteController@showPage',$doitacurl)}}</loc>
        <priority>{{$priority}}</priority>
        <changefreq>weekly</changefreq>
        <image:image>
			<image:loc>{{$doitac->getImage()}}</image:loc>
			<image:title><![CDATA[USIS]]></image:title>
		</image:image>
        <lastmod>{{$doitac->updated_at}}</lastmod>
        <released>{{$doitac->created_at}}</released>
        <link>{{action('SiteController@showPage',$doitacurl)}}</link>
    </url>
    <url>
        <loc>{{action('SiteController@events',$hoatdongurl)}}</loc>
        <priority>{{$priority}}</priority>
        <changefreq>weekly</changefreq>
        <image:image>
			<image:loc>{{$sukien->getImage()}}</image:loc>
			<image:title><![CDATA[USIS]]></image:title>
		</image:image>
        <lastmod>{{$sukien->updated_at}}</lastmod>
        <released>{{$sukien->created_at}}</released>
        <link>{{action('SiteController@events',$hoatdongurl)}}</link>
    </url>
    <url>
        <loc>{{action('SiteController@news',$newurl)}}</loc>
        <priority>{{$priority}}</priority>
        <changefreq>weekly</changefreq>
        <image:image>
			<image:loc>{{$tintuc->getImage()}}</image:loc>
			<image:title><![CDATA[USIS]]></image:title>
		</image:image>
        <lastmod>{{$tintuc->updated_at}}</lastmod>
        <released>{{$tintuc->created_at}}</released>
        <link>{{action('SiteController@news',$newurl)}}</link>
    </url>
    <url>
        <loc>{{action('SiteController@customer')}}</loc>
        <priority>{{$priority}}</priority>
        <changefreq>weekly</changefreq>
        <image:image>
			<image:loc>{{$khachhang->getImage()}}</image:loc>
			<image:title><![CDATA[USIS]]></image:title>
		</image:image>
        <lastmod>{{$khachhang->updated_at}}</lastmod>
        <released>{{$khachhang->created_at}}</released>
        <link>{{action('SiteController@customer')}}</link>
    </url>
    <url>
        <loc>{{action('SiteController@showPage',$lienheurl)}}</loc>
        <priority>{{$priority}}</priority>
        <changefreq>weekly</changefreq>
        <image:image>
			<image:loc>{{$lienhe->getImage()}}</image:loc>
			<image:title><![CDATA[USIS]]></image:title>
		</image:image>
        <lastmod>{{$lienhe->updated_at}}</lastmod>
        <released>{{$lienhe->created_at}}</released>
        <link>{{action('SiteController@showPage',$lienheurl)}}</link>
    </url>

</urlset>
