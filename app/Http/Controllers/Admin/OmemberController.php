<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\SaveOmember;
use App\Http\Controllers\Controller;

use App\Post;
use App\Category;
use App\Resource;
use App\Module;
use Session;
use Carbon\Carbon;

class OmemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $total = Post::where('desc_vn','omember')->count('id');
            $query = Post::query();
            $categories = Category::orderBy('id', 'asc');
            # Category filter
            if ($request->has('module')) {
                $query->where('cid', $request->module);
                $filtered = $query->count();
                $categories = Category::orderBy('id', 'asc')->get()->pluck('id', 'cid');
            }
            if ($request->has('category')) {
                $query->where('cat_id', $request->category);
                $filtered = $query->count();
            }
            # Pagination
            
            # Search title
            if ('' !== $search = $request->search['value']) {
                $query = $query->whereRaw("UPPER(title) LIKE UPPER('%{$search}%')");
                $filtered = $query->count();
            }
            $posts = $query->where('desc_vn','omember')->orderBy('ordering','desc')->orderBy('created_at','desc')->skip($request->start)->take($request->length)->get();
            # Output
            $rows = [];
            foreach ($posts as $post) {
                if($post->desc_en == '1' || $post->desc_en == ''){ $cv = 'Hội đồng';}elseif($post->desc_en == '2'){ $cv= 'Luật sư';}elseif($post->desc_en == '3'){ $cv = 'Người đại diện';}else{$cv = 'Đối tác';}
                $rows[] = [
                    NULL,
                    link_to(action('Admin\OmemberController@edit', $post->id), $post->title)->toHtml(),
                    '<div class="order-input"><input style="width:auto;max-width:45px;text-align:center;border: 1px solid #ddd;margin:0" class="inputvalue" type="text" value="'.$post->ordering.'"><input type="hidden" class="postid" data-value="'.$post->id.'"></div>',
                    $post->is_sticky_html,
                    $cv,
                    empty($post->user) ? '' : $post->user->name,
                    $post->updated_at,
                     link_to(action('Admin\OmemberController@edit', $post->id), trans('admin.button.edit'), ['class' => 'waves-effect waves-light btn btn-sm'])->toHtml().
                     link_to(action('Admin\OmemberController@show', $post->id), trans('admin.button.view'), ['class' => 'waves-effect waves-light btn btn-sm green', 'target' => '_blank'])->toHtml()
                ];
            }
            // var_dump($rows);die;
            return response()->json([
                'data'            => $rows,
                "recordsTotal"    => $total,
                'recordsFiltered' => isset($filtered) ? $filtered : $total,
                'categories'      => $categories
            ]);
        }

        // $categories = Category::orderBy('id', 'asc')->get()->pluck('title', 'id');
        // $modules = Module::where('cid','>',0)->orderBy('id', 'asc')->get()->pluck('title', 'cid');
        return view('admin.other.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        $post->active = true;
        $post->categories = [];
        $categories = Category::orderBy('cid', 'asc')->get();
        $modules = Module::where('cid','>',0)->orderBy('id', 'asc')->get()->pluck('title', 'cid');
        return view('admin.other.create', compact('post', 'categories','modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveOmember $request)
    {
        $data = $request->all();
        if(!empty($value["created_at"])){
            $value["created_at"] = explode('/',$value["created_at"]);
            $temp = $value["created_at"][0];
            $value["created_at"][0] = $value["created_at"][1];
            $value["created_at"][1] = $temp;
            $value["created_at"] = implode('/',$value["created_at"]);
            $value["created_at"] = Carbon::parse($value["created_at"])->format('Y-m-d H:i:s');
        }
        $data['cid'] = 0;
        $data['alias_vn'] = $request->slug['vi'];
        $data['alias_en'] = $request->slug['en'];
        // var_dump($data);die;
        $new = Post::create($data);
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.create')]);
        return redirect()->action('Admin\OmemberController@edit', $new->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        $category_id = (int) $request->categories[0];
        $value = $request->all();
        if(!empty($value["created_at"])){
            $value["created_at"] = explode('/',$value["created_at"]);
            $temp = $value["created_at"][0];
            $value["created_at"][0] = $value["created_at"][1];
            $value["created_at"][1] = $temp;
            $value["created_at"] = implode('/',$value["created_at"]);
            $value["created_at"] = Carbon::parse($value["created_at"])->format('Y-m-d H:i:s');
        }
        $post = new Post($value);
        
        if (empty($post->resource_id)) $post->resource_id = NULL;
        $others = Post::with('resource')->whereHas('categories', function($query) use($post, $category_id) {
            $query->where('categories.id', $category_id);
        })->orderBy('id', 'desc')->take(6)->get();
        return view('site.other', compact('post', 'others'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        // if($post->cat_id != '')
        //     $post->category = $post->category->pluck('id')->all();
        $categories = Category::orderBy('id', 'desc')->get(['id', 'title','cid']);
        $ids = $post->gallery;
        if($ids){
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $gallery = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get(); 
        }else{
            $gallery=[];
        }
        
        return view('admin.other.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveOmember $request, $id)
    {
        $post = Post::findOrFail($id);
        
        //Định dạng ngày đăng tin trước khi lưu
        $value = $request->all();
        if(!empty($value["created_at"])){
            $value["created_at"] = explode('/',$value["created_at"]);
            $temp = $value["created_at"][0];
            $value["created_at"][0] = $value["created_at"][1];
            $value["created_at"][1] = $temp;
            $value["created_at"] = implode('/',$value["created_at"]);
            $value["created_at"] = Carbon::parse($value["created_at"])->format('Y-m-d H:i:s');
        }
        $value['alias_vn'] = $request->slug['vi'];
        $value['alias_en'] = $request->slug['en'];
        $value['cid'] = 0;
        $post->update($value);
        //$post->categories()->sync($request->categories);
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
        Post::destroy($id);
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.delete')]);
        return redirect()->action('Admin\OmemberController@index');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->categories = $post->categories->pluck('id')->all();
        $datas = $post->toArray();
        return view('view', compact('datas'));
    }

    public function getCategory(Request $request){
        $mId = $request->mId;
        $query = Category::orderBy('cid','asc');
        if(isset($mId) && $mId > 0){
            $query = $query->where('cid', $mId);
        }
        $query = $query->pluck('id','id')->toArray();
        return response()->json($query);
    }
}
