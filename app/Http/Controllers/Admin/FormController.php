<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Form;
use Illuminate\Http\Request;

use App\Http\Requests\SaveForm;
use App\Http\Controllers\Controller;

use App\Post;
use App\Category;
use App\Resource;
use App\Module;
use Carbon\Carbon;

class FormController extends Controller
{
    // public function index(Request $request)
    // {
    //     $forms = Form::with('mails')->orderBy('id', 'desc')->get();
    //     return view('admin.form.index', compact('forms'));
    // }

    // public function edit($id)
    // {
    //     $form = Form::findOrFail($id);
    //     $mails = $form->mails;
    //     return view('admin.form.edit', compact('form', 'mails'));
    // }
    // public function update(Request $request, $id)
    // {
    //     $form = Form::findOrFail($id);
    //     $form->update($request->all());
    //     Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.update')]);
    //     return back();
    // }

    public function index(Request $request)
    {
        $categories= [];
        if ($request->ajax()) {
            $total = Form::count('id');
            $query = Form::query();
            # Pagination
            
            # Search title
            if ('' !== $search = $request->search['value']) {
                $query = $query->whereRaw("UPPER(title) LIKE UPPER('%{$search}%')");
                $filtered = $query->count();
            }
            $posts = $query->skip($request->start)->take($request->length)->get();
            # Output
            $rows = [];
            foreach ($posts as $post) {
                $rows[] = [
                    NULL,
                    link_to(action('Admin\FormController@edit', $post->id), $post->title)->toHtml(),
                    $post->is_draft_html,
                    $post->is_sticky_html,
                    '',
                    '',
                    '',
                    $post->updated_at,
                     link_to(action('Admin\FormController@edit', $post->id), trans('admin.button.edit'), ['class' => 'waves-effect waves-light btn btn-sm'])->toHtml().
                     link_to(action('Admin\FormController@show', $post->id), trans('admin.button.view'), ['class' => 'waves-effect waves-light btn btn-sm green', 'target' => '_blank'])->toHtml()
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
        return view('admin.form.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Form();
        $post->active = true;
        $post->categories = [];
        return view('admin.form.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveForm $request)
    {
        $value = $request->all();
        if(!empty($value["created_at"])){
            $value["created_at"] = explode('/',$value["created_at"]);
            $temp = $value["created_at"][0];
            $value["created_at"][0] = $value["created_at"][1];
            $value["created_at"][1] = $temp;
            $value["created_at"] = implode('/',$value["created_at"]);
            $value["created_at"] = Carbon::parse($value["created_at"])->format('Y-m-d H:i:s');
        }
        $new = Form::create($value);

        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.create')]);
        return redirect()->action('Admin\FormController@edit', $new->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        $value = $request->all();
        if(!empty($value["created_at"])){
            $value["created_at"] = explode('/',$value["created_at"]);
            $temp = $value["created_at"][0];
            $value["created_at"][0] = $value["created_at"][1];
            $value["created_at"][1] = $temp;
            $value["created_at"] = implode('/',$value["created_at"]);
            $value["created_at"] = Carbon::parse($value["created_at"])->format('Y-m-d H:i:s');
        }
        $post = new Form($value);
        
        if (empty($post->resource_id)) $post->resource_id = NULL;
        $others = Form::with('resource')->whereHas('categories', function($query) use($post, $category_id) {
            $query->where('categories.id', $category_id);
        })->orderBy('id', 'desc')->take(6)->get();
        return view('site.form', compact('post', 'others'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Form::findOrFail($id);
        return view('admin.form.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveForm $request, $id)
    {
        $post = Form::findOrFail($id);
        
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
        Form::destroy($id);
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.delete')]);
        return redirect()->action('Admin\FormController@index');
    }

    public function show($id)
    {
        $post = Form::findOrFail($id);
        $post->categories = $post->categories->pluck('id')->all();
        $datas = $post->toArray();
        return view('view', compact('datas'));
    }
}
