<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\SaveCategory;
use App\Http\Controllers\Controller;

use App\Category;
use App\Module;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //convert data to translate format
        // $posts = Category::all();
        // foreach ($posts as $post) {
        //     $data=[
        //         'title'=> array('vi' => addslashes($post->name_vn),'en' => addslashes($post->name_en)),
        //         'slug'=>array('vi' => addslashes($post->alias_vn),'en' => addslashes($post->alias_en)),
        //         'description'=> array('vi' => addslashes($post->content_vn),'en' => addslashes($post->content_en)),
        //         'meta' => array('vi' => addslashes($post->meta_vn),'en' => addslashes($post->meta_en)),
        //         'meta_title' => array('vi' => addslashes($post->meta_title_vn),'en' => addslashes($post->meta_title_en)),
        //         'meta_desc' => array('vi' => addslashes($post->meta_desc_vn),'en' => addslashes($post->meta_desc_en)),
        //         'meta_keyword' => array('vi' => addslashes($post->meta_keyword_vn),'en' => addslashes($post->meta_keyword_en)),
        //         'created_at' => date('Y-m-d H:m:s',$post->created),
        //         'updated_at' => date('Y-m-d H:m:s',$post->modified),
        //            'active' => $post->display
        //     ];
        //     $post->update($data);
        // }
        //  echo 'ok';

        $type = ($request->has('type') && in_array($request->get('type'), config('category_type'))) ? $request->get('type') : 'post';
        $categories = Category::with('user')->where('type', $type)->orderBy('cid', 'asc')->orderBy('id', 'desc')->get();
       
        return view('admin.category.index', compact('categories', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = ($request->has('type') && in_array($request->get('type'), config('category_type'))) ? $request->get('type') : 'post';

        $modules = Module::where('cid','>',0)->orderBy('id', 'asc')->get()->pluck('title', 'cid');
        $cates = Category::where('type', $type)->orderBy('title', 'asc')->get()->pluck('title', 'id');
        $cates = $cates->toArray();
        $category = new Category();
        return view('admin.category.create', compact('category', 'type','cates','modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveCategory $request)
    {
        $data = $request->all();
        $data['alias_vn'] = $data['slug']['vi'];
        $data['alias_en'] = $data['slug']['en'];
        $data['meta_title_vn'] = $data['meta_title']['vi'];
        $data['meta_title_en'] = $data['meta_title']['en'];
        $data['meta_desc_vn'] = $data['meta_desc']['vi'];
        $data['meta_desc_en'] = $data['meta_desc']['en'];
        $data['meta_keyword_vn'] = $data['meta_keyword']['vi'];
        $data['meta_keyword_en'] = $data['meta_keyword']['en'];
        $data['cid'] = isset($data['module_id']) ? $data['module_id']: 0;
        if(isset($data['module_id'])) 
            unset($data['module_id']) ;
        $new = Category::create($data);
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.create')]);
        return redirect()->action('Admin\CategoryController@edit', $new->id);
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
        $category = Category::findOrFail($id);
        $type = $category->type;
        $cates = Category::where('type', $type)->where('id','<>',$id)->orderBy('title', 'asc')->get()->pluck('title', 'id');
        $cates = $cates->toArray();
        $modules = Module::where('cid','>',0)->orderBy('id', 'asc')->get()->pluck('title', 'cid');
        return view('admin.category.edit', compact('category', 'cates', 'type','modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveCategory $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->all();
        $data['alias_vn'] = $data['slug']['vi'];
        $data['alias_en'] = $data['slug']['en'];
        $data['cid'] = $request->get('module_id');
        unset($data['module_id']);
        $category->update($data);
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
        $category = Category::findOrFail($id);
        $category->delete();
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.delete')]);
        return redirect()->action('Admin\CategoryController@index');
    }
}
