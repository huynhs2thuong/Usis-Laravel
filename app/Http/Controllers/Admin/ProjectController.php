<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Page;
use App\Resource;
use Illuminate\Http\Request;
use App\Http\Requests\SaveProject;
use App\Http\Controllers\Controller;
use App\Project;
use App\Category;

use Session;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //print_r(Project::all());die();
        try {

        $categories = Category::where('type','project')->orderBy('id', 'desc')->get()->pluck('title', 'id');
        if ($request->ajax()) {
            $total = Project::count('id');
            $query = Project::query();

            # Category filter
            if ($request->has('category')) {
                $query->where('cat_id', $request->category);
                $filtered = $query->count();
            }
            // # Search title
            if ('' !== $search = $request->search['value']) {
                $query = $query->whereRaw("UPPER(title) LIKE UPPER('%{$search}%')");
                $filtered = $query->count();
            }
            // # Order
            if ($request->has('order')) {
                $order_map = [
                    1 => 'title',
                    4 => 'id',
                ];
                $order = $request->order[0];
                $query = $query->orderBy($order_map[$order['column']], $order['dir']);
            } else $query = $query->orderBy('sticky', 'desc')->orderBy('ordering','desc')->orderBy('created_at','desc')->orderBy('id', 'desc');
            // # Pagination
            $posts = $query->skip($request->start)->take($request->length)->get();
            # Output
            $rows = [];
            foreach ($posts as $post) {
                $rows[] = [
                    NULL,
                    link_to(action('Admin\ProjectController@edit', $post->id), $post->title)->toHtml(),
                    '<div class="order-input"><input style="width:auto;max-width:45px;text-align:center;border: 1px solid #ddd;margin:0" class="inputvalue" type="text" value="'.$post->ordering.'"><input type="hidden" class="postid" data-value="'.$post->id.'"></div>',
                    $post->is_sticky_html,
                    empty($post->category) ? '' : $post->category->title,
                    empty($post->render == 0) ? '<div class="order-input"><input disabled style="width:auto;max-width:45px;text-align:center;border: 1px solid #ddd;margin:0;margin-left:1rem;visibility: inherit;position: inherit;" class="inputvalue" type="checkbox" checked ></div>': 
                    '<div class="order-input"><input disabled style="width:auto;max-width:45px;text-align:center;border: 1px solid #ddd;margin:0;margin-left:1rem;visibility: inherit;position: inherit;" class="inputvalue" type="checkbox" ></div>',
                   // '<input type="checkbox" ' . empty($post->render == 1) ? 'checked' : '' . ' disabled class=" select-checkbox"> ',
                   empty($post->hot_news == 0) ? '<div class="order-input"><input disabled style="width:auto;max-width:45px;text-align:center;border: 1px solid #ddd;margin:0;margin-left:1rem ;visibility: inherit;position: inherit;" class="inputvalue" type="checkbox" checked ></div>': 
                    '<div class="order-input"><input disabled style="width:auto;max-width:45px;text-align:center;border: 1px solid #ddd;margin:0;margin-left:1rem;visibility: inherit;position: inherit;" class="inputvalue" type="checkbox" ></div>',
                 //  empty($post->hot_news == 0) ? '<input type="checkbox" disabled class=" select-checkbox">' : '',
                    empty($post->user) ? '' : $post->user->name,
                    $post->created_at,
                    link_to(action('Admin\ProjectController@edit', $post->id), trans('admin.button.edit'), ['class' => 'waves-effect waves-light btn btn-sm'])->toHtml(),
                ];
            }
            return response()->json([
                'data'            => $rows,
                "recordsTotal"    => $total,
                'recordsFiltered' => isset($filtered) ? $filtered : $total
            ]);
        }
        return view('admin.project.index', compact('categories'));

        } catch (\Exception $e) {
            return 'Error: '.$e->getMessage().' Line: '.$e->getLine();
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Project();
        $post->active = true;
        $post->categories = [];
        $investImg = NULL;
        $overviewImg = NULL;
        $gallery = '';
        $create = true; // biến thông báo với form hiện đang ở trang create
        $categories = Category::orderBy('id', 'desc')->where('type','project')->get();
        $list_page = Page::orderBy('id', 'desc')->where('id_pro','1')->get()->pluck('title', 'id')->all();// get list chương trình
        return view('admin.project.create', compact('post', 'categories','investImg','create','overviewImg','list_page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveProject $request)
    {
        $data = $request->all();
        if($data['cat_id']){
            $category = Category::find($data['cat_id']);
            $data['cid'] = $category->cid;
        }
        if($request->ordering){
            $data['ordering'] = $request->ordering;
        }
        else{
            $data['ordering'] = 0;
        }
        $data['slug_vn'] = $data['slug']['vi'];
        $data['slug_en'] = $data['slug']['en'];
        // var_dump($data);die;
        $data['invest_id'] = $data['invest_id'] ? $data['invest_id'] : NULL;
        $new = Project::create($data);
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.create')]);
        return redirect()->action('Admin\ProjectController@edit', $new->id);
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
        $post = new Project($request->all());
        if (empty($post->resource_id)) $post->resource_id = NULL;
        $others = Project::with('resource')->whereHas('categories', function($query) use($post, $category_id) {
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
        $post = Project::findOrFail($id);
        $categories = Category::orderBy('id', 'desc')->where('type','project')->get(['id', 'title']);
        $gallery = (array) $post->img_slide;
        $gallery = array_map('intval', $gallery);
        $gallery = Resource::whereIn('id', $gallery)->get();
        $investImg = $post->invest_id ? Resource::where('id', $post->invest_id)->first() : '';
        $investImg = $investImg ? '/uploads/thumbnail/'.$investImg->type.'/'.$investImg->name :'';
        $overviewImg = $post->overview_id ? Resource::where('id', $post->overview_id)->first() : '';
        $overviewImg = $overviewImg ? '/uploads/thumbnail/'.$overviewImg->type.'/'.$overviewImg->name :'';
        $list_page = Page::orderBy('id', 'desc')->where('id_pro','1')->get()->pluck('title', 'id')->all();// get list chương trình
        $render = Project::where('id', $id)->get()->pluck('render', 'id')->all();
        $hot_news = Project::where('id', $id)->get()->pluck('hot_news', 'id')->all();
        //var_dump($render);die;
        return view('admin.project.edit', compact('post', 'categories', 'gallery','investImg','overviewImg','list_page','hot_news','render'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveProject $request, $id)
    {
        $data = $request->all();
        //$data['page_id'] = intval($data['page_id']);
        // var_dump(intval($data['page_id']));
         // var_dump($data );die;
        if($data['cat_id']){
            $category = Category::find($data['cat_id']);
            $data['cid'] = $category->cid;
        }
        $data['slug_vn'] = $data['slug']['vi'];
        $data['slug_en'] = $data['slug']['en'];
        $post = Project::findOrFail($id);
        $products = $request->products;
        $data['invest_id'] = $data['invest_id'] ? $data['invest_id'] : NULL;
        $data['page_id'] = intval($data['page_id']);
        $post->update($data);
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
        Project::destroy($id);
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.delete')]);
        return redirect()->action('Admin\ProjectController@index');
    }

    public function show($id)
    {
        $post = Project::findOrFail($id);
        $post->categories = $post->categories->pluck('id')->all();
        $img_slide = (array) $post->img_slide;
        $img_slide = array_map('intval', $img_slide);
        $img_slide = Resource::whereIn('id', $img_slide)->select(['name'])->get();
        //$post->sliders = $img_slide->toArray();
        $datas = $post->toArray();
        return view('view', compact('datas'));
    }

    public function sortProject(Request $request){
        $values = $request->values;
        $ids = $request->ids;
        $i = 0;
        foreach($ids as $id){
            Project::where('id',$id)->update(['ordering'=>$values[$i]]);
            $i++;
        }
        $test = 'success';
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.update')]);
        return response()->json($test);
    }
}
