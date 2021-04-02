<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
<channel>
<title>USIS</title>
<link>{{URL::to('/')}}</link>
<description>Tin tức</description>
<?php foreach($posts as $post){?>
<item>
	<title>{{$post->title}}</title>
	<link>
		<?php 
			$link = '';
			if($post->cid == 8){ // tin tuc
				$link = action('SiteController@news',$post->slug);
			}elseif($post->cid == 72){ // luat di tru
				$link = action('SiteController@laws',$post->slug);
			}elseif($post->cid == 29){ // hd dinh cu hoa ky
				$link = action('SiteController@hddcDetail',['slug'=>$post->slug,'suffix'=>'.html']);
			}elseif($post->cid == 2){ // su kien
				$link = action('SiteController@eventsDetail',['slug'=>$post->slug,'suffix'=>'.html']);
			}elseif($post->cid == 7){ // cuoc song tai my
				$link = action('SiteController@life',$post->slug);
			}
		?>
		{{$link}}
	</link>
	<pubDate>{{$post->created_at}}</pubDate>
	<?php
	$categories = $post->category()->get();
	 ?>
	 @foreach($categories as $category)
	 <category>{{$category->title}}</category>
	 @endforeach
	<description>{{html_entity_decode(str_replace("&nbsp;", '',stripslashes($post->description)))}}</description>
</item>
<?php } ?>
</channel>
</rss>