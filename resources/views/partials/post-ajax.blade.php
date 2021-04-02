@foreach ($posts as $post)
	@if (empty($post->title)) @continue @endif
	<a href="{{ action('SiteController@showPost', $post->slug) }}" class="block-item post-hover">
		<figure>
			<img src="{{ $post->image }}" alt="{{ $post->title }}" class="img-full-width" width="500" height="300">
		</figure>
	    <h3 class="text-uppercase">{{ $post->title }}</h3>
	    <div class="para">{{ $post->excerpt }}</div>
	</a>
@endforeach
