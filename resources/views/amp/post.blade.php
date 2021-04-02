@extends('layouts.app')

@section('meta')
    <title>{{ $post->title }} - Jollibee Vietnam</title>
    <meta name="description" content="{{ $post->excerpt }}">
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:image" content="{{ $post->getImage('full') }}" />
@endsection

@section('content')
<article class="subnews">
    <section class="primary">
        <h1 class="title text-uppercase text-center">{{ $post->title }}</h1>
        <div class="para">
            {!! $post->description !!}
        </div>
    </section>
    <section class="post-relative container">
        <h2 class="title text-uppercase text-center">@lang('page.post.text1')</h2>
        <div id="post-relative" class="slide swiper-container">
            <div class="swiper-wrapper">
                @foreach ($others as $other)
                    @if (empty($other->title)) @continue @endif
                    <a href="{{ action('SiteController@showPost', $other->slug) }}" class="swiper-slide post-hover">
                        <figure>
                            <img src="{{ $other->image }}" alt="{{ $other->title }}" class="img-full-width">
                        </figure>
                        <h3 class="text-uppercase text-center">{{ $other->title }}</h3>
                        <div class="para text-justify">{{ str_words($other->excerpt, 25) }}</div>
                    </a>
                @endforeach
            </div>
            <div class="swiper-btn">
                <span class="swiper-btn-prev"><i class="fa fa-angle-left fa-2x"></i></span>
                <span class="swiper-btn-next"><i class="fa fa-angle-right fa-2x"></i></span>
            </div>
        </div>
    </section>
</article>
@endsection
