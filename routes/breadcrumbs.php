<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

// Home > About
Breadcrumbs::register('about', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    if(LaravelLocalization::getCurrentLocale()== 'vi'){

        $breadcrumbs->push('Về chúng tôi');
    } else {
        $breadcrumbs->push('About us');
    }
});

// Home > Blog > [Category]
Breadcrumbs::register('category', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('about');
    $breadcrumbs->push($category->title, route('about', $category->slug));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::register('post', function ($breadcrumbs, $post) {
    $breadcrumbs->parent('category', $post->categories);
    $breadcrumbs->push($post->title);
});

// Home > Certificates
Breadcrumbs::register('cert', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    if(LaravelLocalization::getCurrentLocale()== 'vi'){
        $breadcrumbs->push('Chứng nhận và giải thưởng');
    } else {
        $breadcrumbs->push('Certificates and Awards');
    }
});

// Home > Projects
Breadcrumbs::register('project', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    if(LaravelLocalization::getCurrentLocale()== 'vi'){
        $breadcrumbs->push('Dự án nổi bật');
    } else {
        $breadcrumbs->push('Projects');
    }
});