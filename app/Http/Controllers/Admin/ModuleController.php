<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\SaveModule;
use App\Http\Controllers\Controller;

use App\Module;

use Session;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //convert data to translate format
        // $posts = Module::all();
        // foreach ($posts as $post) {
        //     $data=[
        //         'title'=> array('vi' => addslashes($post->desc_vn),'en' => addslashes($post->desc_en)),
        //         'slug'=>array('vi' => addslashes($post->alias_vn),'en' => addslashes($post->alias_en)),
        //         'meta_title' => array('vi' => addslashes($post->meta_title_vn),'en' => addslashes($post->meta_title_en)),
        //         'meta_desc' => array('vi' => addslashes($post->meta_desc_vn),'en' => addslashes($post->meta_desc_en)),
        //         'meta_keyword' => array('vi' => addslashes($post->meta_keyword_vn),'en' => addslashes($post->meta_keyword_en)),
        //         'created_at' => date('Y-m-d H:m:s',$post->created),
        //         'updated_at' => date('Y-m-d H:m:s',$post->modified),
        //         'active' => $post->display
        //     ];
        //     $post->update($data);
        // }
        //  echo 'ok';
        //  die;

        $categories = Module::with('user')->where('parent_id',0)->where('client',1)->orderBy('ordering', 'desc')->get();
       
        return view('admin.module.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cates = Module::orderBy('title', 'asc')->where('parent_id',0)->where('client',1)->get()->pluck('title', 'id');
        $cates = $cates->toArray();
        $module = new Module();
        return view('admin.module.create', compact('module', 'cates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveModule $request)
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
        $data['client'] = 1;
        $data['cid'] = 123;
        if($request->cid){
        	$data['cid'] = $request->cid;
        }
        
        $new = Module::create($data);
        $new->update(array('cid'=>$new->id));
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.create')]);
        return redirect()->action('Admin\ModuleController@edit', $new->id);
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

        $module = Module::select('*','image as resource_id')->where('id',$id)->firstOrFail();

        $cates = Module::where('id','<>',$id)->where('parent_id',0)->where('client',1)->orderBy('title', 'asc')->get()->pluck('title', 'id');
        $cates = $cates->toArray();
        return view('admin.module.edit', compact('module', 'cates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveModule $request, $id)
    {
        $module = Module::findOrFail($id);
        // var_dump($request->all());die;
        $data = $request->all();
        $data["image"] = $data['resource_id'];
        $data['alias_vn'] = $data['slug']['vi'];
        $data['alias_en'] = $data['slug']['en'];
        $data['meta_title_vn'] = $data['meta_title']['vi'];
        $data['meta_title_en'] = $data['meta_title']['en'];
        $data['meta_desc_vn'] = $data['meta_desc']['vi'];
        $data['meta_desc_en'] = $data['meta_desc']['en'];
        $data['meta_keyword_vn'] = $data['meta_keyword']['vi'];
        $data['meta_keyword_en'] = $data['meta_keyword']['en'];
        $module->update($data);
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
        $module = Module::findOrFail($id);
        $module->delete();
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.delete')]);
        return redirect()->action('Admin\ModuleController@index');
    }
}
