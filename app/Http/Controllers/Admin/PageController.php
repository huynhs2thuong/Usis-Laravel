<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavePage;
use App\Page;
use App\Category;
use App\Resource;
use File;
use Illuminate\Http\Request;
use Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::with('user', 'parent')->orderBy('id', 'desc')->get();
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = new Page();
        $page->active = true;
        $categories = Category::orderBy('id','desc')->where('cid',76)->get(['id','title'])->pluck('title','id')->all();
        return view('admin.page.create', compact('page','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SavePage $request)
    {
        if ($request->has('page_id')) {
            $request->merge([
                'slug' => Page::findOrFail($request->page_id)->slug . '/' . $request->slug
            ]);
        }
        $data = $request->all();
        $data['alias_vn'] = $data['slug']['vi'];
        $data['alias_en'] = $data['slug']['en'];
	    $data['slug_vn'] = $data['slug']['vi'];
        $data['slug_en'] = $data['slug']['en'];
        $new = Page::create($data);
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.create')]);
        return redirect()->action('Admin\PageController@edit', $new->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $categories = Category::orderBy('id','desc')->where('cid',76)->get(['id','title'])->pluck('title','id')->all();
        //var_dump($categories);die;
        if ($page->page_id !== NULL) $page->slug = str_replace(Page::findOrFail($page->page_id)->slug . '/', '', $page->slug);
        $ids = $page->gallery;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $gallery = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get();
        if($id == 13){
            $id_banner = $page->banner;
            $placeholders_banner = implode(',', array_fill(0, count($id_banner), '?'));
            $banner = empty($id_banner) ? [] : Resource::whereIn('id', $id_banner)->orderByRaw("field(id,{$placeholders_banner})", $id_banner)->get();
        }else{
            $banner = [];
        }
        $feature = $page->feature;
        $imgFeature = Resource::where('id',$feature)->first();
        if($imgFeature){
            $imgFeature = $imgFeature->name;
        }else{
            $imgFeature = '';
        }
        return view('admin.page.edit', compact('page','categories','gallery','banner','imgFeature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SavePage $request, $id)
    {
        $data = $request->all();
        $page = Page::findOrFail($id);
        if ($request->has('page_id')) {
            $request->merge([
                'slug' => Page::findOrFail($request->page_id)->slug . '/' . $request->slug
            ]);
        }
        $data['slug_vn'] = $data['slug']['vi'];
        $data['slug_en'] = $data['slug']['en'];
        $page->update($data);
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.update')]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.delete')]);
        return redirect()->action('Admin\PageController@index');
    }
}
