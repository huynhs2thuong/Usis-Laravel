<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\SavePost;
use App\Http\Controllers\Controller;

use App\Post;
use App\Category;
use App\Resource;
use App\Module;
use Session;
use Carbon\Carbon;
use App\Tag;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $total = Post::count('id');
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
             // $query = $query->orderBy('sticky','desc')->orderBy('ordering','desc')->orderBy('created_at','desc')->orderBy('id','desc');
             $query = $query->orderBy('created_at','desc')->orderBy('id','desc');
            $posts = $query->skip($request->start)->take($request->length)->get();
            # Output
            $rows = [];
            foreach ($posts as $post) {

                // tạo link theo module
                if($post->module){
                    if($post->module->slug === 'su-kien'){
                        $link = link_to(action('SiteController@eventsDetail',['slug'=>$post->slug,'suffix'=>'.html']), trans('admin.button.view'), ['class' => 'waves-effect waves-light btn btn-sm green', 'target' => '_blank'])->toHtml();
                    }elseif($post->module->slug === 'tin-tuc'){
                        $link = link_to(action('SiteController@newsDetail',['slug'=>$post->slug,'suffix'=>'.html']), trans('admin.button.view'), ['class' => 'waves-effect waves-light btn btn-sm green', 'target' => '_blank'])->toHtml();
                    }elseif($post->module->slug === 'doi-tac-chien-luoc'){
                         $link = link_to(action('SiteController@doitacDetail',['slug'=>$post->slug,'suffix'=>'.html']), trans('admin.button.view'), ['class' => 'waves-effect waves-light btn btn-sm green', 'target' => '_blank'])->toHtml();
                    }elseif($post->module->slug === 'luat-di-tru'){ 
                        $link = link_to(action('SiteController@laws',['slug'=>$post->slug]), trans('admin.button.view'), ['class' => 'waves-effect waves-light btn btn-sm green', 'target' => '_blank'])->toHtml();
                    }elseif($post->module->slug === 'cuoc-song-tai-my'){
                        $link = link_to(action('SiteController@life',$post->slug), trans('admin.button.view'), ['class' => 'waves-effect waves-light btn btn-sm green', 'target' => '_blank'])->toHtml();
                    }else{
                        $link = '<a href="#" class="waves-effect waves-light btn btn-sm green">Xem</a>';
                    }
                }else{
                    $link = '';
                }
                $stickshow = '';
                if($post->service_display == 1){ $stickshow = '<i class="mdi-toggle-check-box green-text"></i>';}
                $rows[] = [
                    NULL,
                    link_to(action('Admin\PostController@edit', $post->id), $post->title)->toHtml(),
                    '<div class="order-input"><input style="width:auto;max-width:45px;text-align:center;border: 1px solid #ddd;margin:0" class="inputvalue" type="text" value="'.$post->ordering.'"><input type="hidden" class="postid" data-value="'.$post->id.'"></div>',
                    $post->is_sticky_html,
                    $stickshow,
                    empty($post->category) ? '' : $post->category->title,
                    empty($post->module) ? '' : $post->module->name,
                    empty($post->user) ? '' : $post->user->name,
                    $post->updated_at,
                     link_to(action('Admin\PostController@edit', $post->id), trans('admin.button.edit'), ['class' => 'waves-effect waves-light btn btn-sm'])->toHtml().
                     $link
                     // link_to(action('SiteController@newsDetail',['slug'=>$post->slug]), trans('admin.button.view'), ['class' => 'waves-effect waves-light btn btn-sm green', 'target' => '_blank'])->toHtml()
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

        $categories = Category::orderBy('id', 'asc')->get()->pluck('title', 'id');
        $modules = Module::where('cid','>',0)->orderBy('id', 'asc')->get()->pluck('title', 'cid');
        return view('admin.post.index', compact('categories','modules'));
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
        return view('admin.post.create', compact('post', 'categories','modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SavePost $request)
    {
        // var_dump($request->all());die;
        $data = $request->all();
        if(!empty($data["created_at"])){
            $data["created_at"] = explode('/',$data["created_at"]);
            $temp = $data["created_at"][0];
            $data["created_at"][0] = $data["created_at"][1];
            $data["created_at"][1] = $temp;
            $data["created_at"] = implode('/',$data["created_at"]);
            $data["created_at"] = Carbon::parse($data["created_at"])->format('Y-m-d H:i:s');
        }
        $data['alias_vn'] = $data['slug']['vi'];
        $data['alias_en'] = $data['slug']['en'];
        // var_dump($request->all());die;
        if($request->module_id){
             $data['cid'] = $request->module_id;
        }else{
             $data['cid'] = 0;
        }
        if($request->cat_id){
             $data['cat_id'] = $request->cat_id;
        }else{
            $data['cat_id'] = 0;
        }
        if($request->ordering){
            $data['ordering'] = $request->ordering;
        }
        else{
            $data['ordering'] = 0;
        }
        // $data['cid'] = $data['module_id'];
        $new = Post::create($data);
        if($request->tags){
            foreach($request->tags as $tag){
                $slug = $this->to_slug($tag);
                $tagcreated = Tag::firstOrCreate(['name'=>$tag,'slug'=>$slug]);
                DB::table('tag_post')->insert(['tag_id'=>$tagcreated->id,'post_id'=>$id]);
            }
            
        }else{
            DB::table('tag_post')->where('post_id',$new->id)->delete();
        }

        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.create')]);
        return redirect()->action('Admin\PostController@edit', $new->id);
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
        $value['cat_id'] = $request->cat_id;
        $value['cid'] = $request->module_id;
        if (empty($post->resource_id)) $post->resource_id = NULL;
        $others = Post::with('resource')->whereHas('categories', function($query) use($post, $category_id) {
            $query->where('categories.id', $category_id);
        })->orderBy('id', 'desc')->take(6)->get();
        return view('site.post', compact('post', 'others'));
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
        $modules = Module::where('cid','>',0)->orderBy('id', 'asc')->get()->pluck('title', 'cid');
        $ids = $post->gallery;
        if($ids){
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $gallery = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get(); 
        }else{
            $gallery=[];
        }
        //tags
        $tags = DB::table('tag_post')->where('post_id',$id)->get();
        $tagarr = [];
        foreach($tags as $tag){
            $tagarr[] = $tag->tag_id;
        }
        $tags = Tag::whereIn('id',$tagarr)->get();

        return view('admin.post.edit', compact('post', 'categories','gallery','modules','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SavePost $request, $id)
    {
        $post = Post::findOrFail($id);
        
        //Định dạng ngày đăng tin trước khi lưu
        $value = $request->all();
        $value['alias_vn'] = $value['slug']['vi'];
        $value['alias_en'] = $value['slug']['en'];
        if(!empty($value["created_at"])){
            $value["created_at"] = explode('/',$value["created_at"]);
            $temp = $value["created_at"][0];
            $value["created_at"][0] = $value["created_at"][1];
            $value["created_at"][1] = $temp;
            $value["created_at"] = implode('/',$value["created_at"]);
            $value["created_at"] = Carbon::parse($value["created_at"])->format('Y-m-d H:i:s');
        }
        $value['cid'] = $value['module_id'];
        $post->update($value);
        if($request->tags){
            DB::table('tag_post')->where('post_id',$id)->delete();
            foreach($request->tags as $tag){
                $slug = $this->to_slug($tag);
                $tagcreated = Tag::firstOrCreate(['name'=>$tag,'slug'=>$slug]);
                DB::table('tag_post')->insert(['tag_id'=>$tagcreated->id,'post_id'=>$id]);
            }
            
        }else{
            DB::table('tag_post')->where('post_id',$id)->delete();
        }
        // $post->categories()->sync($request->categories);
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
        return redirect()->action('Admin\PostController@index');
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
    public function sortPost(Request $request){
        $values = $request->values;
        $ids = $request->ids;
        $i = 0;
        foreach($ids as $id){
            Post::where('id',$id)->update(['ordering'=>$values[$i]]);
            $i++;
        }
        $test = 'success';
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.update')]);
        return response()->json($test);
    }

    public function getTagName($tag){
        $tagget = Tag::where('id',$tag)->first();
        return $tagget;
    }

}
