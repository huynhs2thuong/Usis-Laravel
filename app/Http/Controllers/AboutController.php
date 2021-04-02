<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Page;
use App\Project;
use App\Resource;
use App\Development;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class AboutController extends Controller
{
    public function index(Request $request) {
        $page = Page::where('slug', 've-toa')->firstOrFail();
        if(!$page){
            abort(404);
        }

        $dev = Category::orderBy('created_at','desc')->where('slug', 'phat-trien-ben-vung')->first();
        $development = Category::orderBy('created_at','desc')->where('parent_id', $dev->id)->limit(3)->get();
        $project = Project::orderBy('sticky','desc')->orderBy('created_at','desc')->limit(4)->get();
        return view('site.about.index', compact('page', 'development', 'project'));
    }

    public function about(Request $request) {
        $page = Page::where('slug', 'gioi-thieu')->firstOrFail();
        if(!$page){
            abort(404);
        }
        $ids = $page->gallery;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $gallery = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get();
        return view('site.page.about', compact('page','gallery'));
    }

    public function development(Request $request, $slug = 'phat-trien-ben-vung') {
        $limit = 6;
        $page = Page::where('slug', 'phat-trien-ben-vung')->firstOrFail();
        if(!$page){
            abort(404);
        }
        // $datas = Post::orderBy('created_at','desc')->whereHas('categories', function($query) use($slug) {
        //     $query->where('slug', $slug);
        // })->limit($limit)->get();
        // foreach ($datas as $data) {
        //     $ids = $data->gallery;
        //     $placeholders = implode(',', array_fill(0, count($ids), '?'));
        //     $data->gallery = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get();
        // }

        $category = Category::where('slug','phat-trien-ben-vung')->first();
        $datas = Category::where('parent_id',$category->id)->orderBy('created_at','desc')->get();

        foreach ($datas as $cate) {
            $cate->posts;
        }

        return view('site.about.development', compact('page','datas','slug','category'));
    }

	public function show($slug, $slug_post) {
        $post = Post::where('slug', $slug_post)->first();
        $post->categories = $post->categories->first();
        $relateds = Post::orderBy('created_at','desc')->where('id', '<>', $post->id)->whereHas('categories', function($query) use($slug) {
            $query->where('slug', $slug);
        })->limit(3)->get();
        return view('site.about.show', compact('post','relateds', 'slug'));
    }
}
