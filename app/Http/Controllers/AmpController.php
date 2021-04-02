<?php

namespace App\Http\Controllers;

use App\City;

use DB;
use App\Tag;
use App\Page;
use App\Post;
use App\Category;
use App\Resource;
use App\Service;
use App\Module;
use App\Project;
use App\Scopes\ActiveScope;
use App\Store;
use App\Form;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use LaravelLocalization;
use Illuminate\Support\Facades\Redirect;
use Lang;
use Illuminate\Support\Facades\Route;

//custom pagination
use App\Support\Collection;

class AmpController extends Controller
{
    public function __construct() {
        Page::addGlobalScope(new ActiveScope);
        Post::addGlobalScope(new ActiveScope);
        Category::addGlobalScope(new ActiveScope);
    }

    public function index() {
        $services  = Page::where('template','service')->orderBy('id','asc')->get();
        $i = 0;
        foreach ($services as $service) {
            if($service->feature){
                $feature = Resource::where('id',$service->feature)->first();
                $services[$i]->featureImage = $feature;
            }else{
                $services[$i]->featureImage = '';
            }
           $i++;
        }
        $projects = Project::where('cat_id',49)->orderBy('sticky','desc')->orderBy('ordering','desc')->orderBy('created_at','desc')->orderBy('id','desc')->limit(10)->get();
        $event = Post::where('cid',2)->where('cat_id',3);
        if(\Lang::getLocale() == 'en'){
            $event = $event->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }
        $event = $event->orderBy('updated_at','desc')->limit(10)->get();
        $news = Post::where('active',1)->whereRaw('cid IN (72,9,29)')->orwhereRaw('cat_id IN (13,14)');
        if(\Lang::getLocale() == 'en'){
            $news = $news->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }
        $news = $news->orderBy('sticky','desc')->orderBy('ordering','desc')->orderBy('created_at','desc')->limit(4)->get();
        $page = Page::where('template','home')->orderBy('id','desc')->first();
        // var_dump($event);die;
        //hình slide
        $slides = [];
        if(!empty($page->gallery)){
            foreach ($page->gallery as $gallery) {
                $image = Resource::where('id',$gallery)->first();
                $slides[] = $image;
            }
        }
        // $galleries = empty($page->gallery) ? [] : Resource::whereIn('id', $page->gallery)->get();
        //link image service
        $resource = Resource::where('type','page')->pluck('name','id');
        $meta_tite = $page->meta_title;
        $mea_desc = $page->meta_desc;

        return view('amp.home',compact('services','projects','event','news','page','resource','meta_tite','mea_desc','slides'));
    }

    //show page dich-vu
    public function showPageDichVu(Request $request, $slug) {

        if(\Lang::getLocale() == 'en'){
            $page = Page::where("slug_en",$slug)->whereIn('id',[3,4,14])->first(); 
            if(!$page){
                $page = Page::where("slug_en",$slug)->whereIn('id',[3,4,14])->firstOrFail(); 
            }
        }else{
            $page = Page::where("slug_vn",$slug)->whereIn('id',[3,4,14])->firstOrFail();    
        }
        if($page){
           if ($page->template !== '' and view()->exists(config('view.root_page'). $page->template)) {
                //shortcode form
                $forms = Form::all();
                $arr = [];
                $replace = [];
                foreach ($forms as $form) {
                    $arr[] = '['.$form->slug.']';
                    $replace[] = $form->excerpt;
                }
                $contentget = str_replace($arr,$replace,stripslashes($page->description));
                $data['contentget'] = $contentget;
                $data['page'] = $page;
                $ids = $page->gallery;
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $data['gallery'] = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get();
                // var_dump(config('view.root_page'). $page->template);die;
                switch ($page->template) {
                    case 'service2':
                        //49 là đang kêu gọi, 48 là dự án hết suất
                        $data['p49'] = [];
                        $data['p48'] = [];
                        $data['doitac'] = Post::where('desc_vn','omember')->get();
                        // if(\Lang::getLocale() == 'en'){
                        //     $category = Category::where("alias_en","hoat-dong-an-cu")->first();
                        // }else{
                            $category = Category::where("alias_vn","hoat-dong-an-cu")->first();
                        // }
                        // $category = Category::whereRaw("UPPER(slug) LIKE UPPER('%hoat-dong-an-cu%')")->first();
                        //lay video có check show trong serivce
                        $data['video'] = Post::where('cat_id',$category->id)->where('service_display',2);
                        if(\Lang::getLocale() == 'en'){
                            $data['video'] = $data['video']->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
                        }
                        $data['video'] =  $data['video']->orderBy('ordering','desc')->first();
                        // var_dump($data['video']);die;
                        // var_dump($category);die;
                        if($category){
                            $data['hoatdong'] = Post::where('cat_id',$category->id);
                            if(\Lang::getLocale() == 'en'){
                                $data['hoatdong'] = $data['hoatdong']->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
                            }
                            $data['hoatdong'] = $data['hoatdong']->where('service_display',1)->orderBy('created_at','desc')->limit(5)->get();
                        }else{
                            $ddata['hoatdong'] = [];
                        }
                        //lấy tin trong hoat dong usis có check service
                        
                        $data['secPage'] = Page::where('slug_vn','dich-vu-an-cu-my')->first();
                        $data['category']= $category;
                        if((strpos($slug, 'dich-vu-an') !== false) || (strpos($slug, 'us-settlement-service') !== false)){
                        $data['deputy'] = Post::where('desc_vn','hoidong')->where('desc_en',3)->orderBy('ordering','desc')->orderBy('created_at','desc')->get();
                        }
                        break;
                    case 'service':
                        //49 là đang kêu gọi, 48 là dự án hết suất
                        $data['p49'] = Project::where('cat_id',49)->orderBy('sticky','desc')->get();
                        $data['p48'] = Project::where('cat_id',48)->orderBy('sticky','desc')->limit(6)->get();
                        if(strpos($slug, 'dich-vu-an') !== false){
                        $data['deputy'] = Post::where('desc_vn','hoidong')->where('desc_en',3)->orderBy('ordering','desc')->orderBy('created_at','desc')->get();
                        }
                    default: 
                    break; 
                }
                // var_dump(config('view.root_page'). $page->template);die;
                return view('amp.page.'. $page->template, $data);
            }
        }else{
            abort(404);
        }
    }
    //show page gioi-thieu
    public function showPagegioiThieu(Request $request, $slug) {
        if(\Lang::getLocale() == 'en'){
            $page = Page::where("slug_en",$slug)->whereIn('id',[1,2])->first(); 
            if(!$page){
                $page = Page::where("slug_en",$slug)->whereIn('id',[1,2])->firstOrFail(); 
            }
        }else{
            $page = Page::where("slug_vn",$slug)->whereIn('id',[1,2])->firstOrFail();    
        }
        if($page){
           if ($page->template !== '' and view()->exists(config('view.root_page'). $page->template)) {
                //shortcode form
                $forms = Form::all();
                $arr = [];
                $replace = [];
                foreach ($forms as $form) {
                    $arr[] = '['.$form->slug.']';
                    $replace[] = $form->excerpt;
                }
                $contentget = str_replace($arr,$replace,stripslashes($page->description));
                $data['contentget'] = $contentget;
                $data['page'] = $page;
                $ids = $page->gallery;
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $data['gallery'] = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get();
                // var_dump(config('view.root_page'). $page->template);die;
                switch ($page->template) {
                    case 'teams':
                        $data['hoidong']= Post::where('desc_vn','hoidong')->orderBy('ordering','desc')->orderBy('created_at','desc')->get();
                        $i= 0;
                        foreach($data['hoidong'] as $mem){
                            $img = Resource::where('id',$mem->resource_id)->first();
                            $data['hoidong'][$i]->image = $img->name;
                            $i++;
                        }
                        // var_dump($data);die;
                        $data['teams'] = Post::where('cid',14)->orderBy('ordering','asc')->orderBy('cat_id','asc')->get();
                        break;
                    case 'partners':
                        $data['module'] = Module::where('cid',37)->first();
                        $categories = Category::where('cid',37)->orderBy('created_at','desc')->orderBy('ordering','asc')->get();
                        foreach ($categories as  $category) {
                            $category->posts;
                        } 
                        $data['categories'] = $categories;
                        break;
                    case 'about':

                        $data['form'] = Form::whereRaw("slug LIKE UPPER('%form-2%')")->first();
                        $categories = Category::where('cid',37)->orderBy('ordering','asc')->orderBy('cat_id','asc')->get();
                        foreach ($categories as  $category) {
                            $category->posts;
                        } 
                        $data['categories'] = $categories;
                        $data['customer'] = Post::where('cid',6);

                        if(\Lang::getLocale() == 'en'){
                            $data['customer'] = $data['customer']->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
                        }
                        $data['customer']  = $data['customer']->orderBy('ordering','asc')->orderBy('sticky','desc')->orderBy('id','desc')->take(6)->get();
                        break;
                    break;
                }
                // var_dump('amps.page.'.$page->template);die;
                return view('amp.page.'.$page->template, $data);
            }
        }else{
            abort(404);
        }
    }

	public function showPage(Request $request, $slug) {

        if(\Lang::getLocale() == 'en'){
            $page = Page::where("slug_en",$slug)->first(); 
            if(!$page){
                $page = Page::where("slug_vn",$slug)->firstOrFail(); 
            }
        }else{
            $page = Page::where("slug_vn",$slug)->firstOrFail();    
        }
        if($page){
    	   if ($page->template !== '' and view()->exists(config('view.root_page'). $page->template)) {
                //shortcode form
                $forms = Form::all();
                $arr = [];
                $replace = [];
                foreach ($forms as $form) {
                    $arr[] = '['.$form->slug.']';
                    $replace[] = $form->excerpt;
                }
                $contentget = str_replace($arr,$replace,stripslashes($page->description));
                $data['contentget'] = $contentget;
        		$data['page'] = $page;
                $ids = $page->gallery;
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $data['gallery'] = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get();
                // var_dump(config('view.root_page'). $page->template);die;
                switch ($page->template) {
                    case 'teams':
                        $data['hoidong']= Post::where('desc_vn','hoidong')->orderBy('ordering','desc')->orderBy('created_at','desc')->get();
                        $i= 0;
                        foreach($data['hoidong'] as $mem){
                            $img = Resource::where('id',$mem->resource_id)->first();
                            $data['hoidong'][$i]->image = $img->name;
                            $i++;
                        }
                        // var_dump($data);die;
                        $data['teams'] = Post::where('cid',14)->orderBy('ordering','asc')->orderBy('cat_id','asc')->get();
                        break;
                    case 'partners':
                        $data['module'] = Module::where('cid',37)->first();
                        $categories = Category::where('cid',37)->orderBy('created_at','desc')->orderBy('ordering','asc')->get();
                        foreach ($categories as  $category) {
                            $category->posts;
                        } 
                        $data['categories'] = $categories;
                        break;
                    case 'about':

                        $data['form'] = Form::whereRaw("slug LIKE UPPER('%form-2%')")->first();
                        $categories = Category::where('cid',37)->orderBy('ordering','asc')->orderBy('cat_id','asc')->get();
                        foreach ($categories as  $category) {
                            $category->posts;
                        } 
                        $data['categories'] = $categories;
                        $data['customer'] = Post::where('cid',6);

                        if(\Lang::getLocale() == 'en'){
                            $data['customer'] = $data['customer']->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
                        }
                        $data['customer']  = $data['customer']->orderBy('ordering','asc')->orderBy('sticky','desc')->orderBy('id','desc')->take(6)->get();
                        break;
                    case 'service2':
                        //49 là đang kêu gọi, 48 là dự án hết suất
                        $data['p49'] = [];
                        $data['p48'] = [];
                        $data['doitac'] = Post::where('desc_vn','omember')->get();
                        // if(\Lang::getLocale() == 'en'){
                        //     $category = Category::where("alias_en","hoat-dong-an-cu")->first();
                        // }else{
                            $category = Category::where("alias_vn","hoat-dong-an-cu")->first();
                        // }
                        // $category = Category::whereRaw("UPPER(slug) LIKE UPPER('%hoat-dong-an-cu%')")->first();
                        //lay video có check show trong serivce
                        $data['video'] = Post::where('cat_id',$category->id)->where('service_display',2);
                        if(\Lang::getLocale() == 'en'){
                            $data['video'] = $data['video']->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
                        }
                        $data['video'] =  $data['video']->orderBy('ordering','desc')->first();
                        // var_dump($data['video']);die;
                        // var_dump($category);die;
                        if($category){
                            $data['hoatdong'] = Post::where('cat_id',$category->id);
                            if(\Lang::getLocale() == 'en'){
                                $data['hoatdong'] = $data['hoatdong']->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
                            }
                            $data['hoatdong'] = $data['hoatdong']->where('service_display',1)->orderBy('created_at','desc')->limit(5)->get();
                        }else{
                            $ddata['hoatdong'] = [];
                        }
                        //lấy tin trong hoat dong usis có check service
                        
                        
                        if((strpos($slug, 'dich-vu-an') !== false) || (strpos($slug, 'us-settlement-service') !== false)){
                        $data['deputy'] = Post::where('desc_vn','hoidong')->where('desc_en',3)->orderBy('ordering','desc')->orderBy('created_at','desc')->get();
                        }
                        break;
                    case 'service':
                        //49 là đang kêu gọi, 48 là dự án hết suất
                        $data['p49'] = Project::where('cat_id',49)->orderBy('sticky','desc')->get();
                        $data['p48'] = Project::where('cat_id',48)->orderBy('sticky','desc')->limit(6)->get();
                        if(strpos($slug, 'dich-vu-an') !== false){
                        $data['deputy'] = Post::where('desc_vn','hoidong')->where('desc_en',3)->orderBy('ordering','desc')->orderBy('created_at','desc')->get();
                        }
                    default: 
                    break;
                }
                // var_dump(config('view.root_page'). $page->template);die;
                return view('amp.page.'. $page->template, $data);
            }
    	}else{
            abort(404);
        }
	}


    public function showPage2(Request $request, $slug) {
        if(\Lang::getLocale() == 'en'){
            $page = Page::where("slug_en",$slug)->first(); 
            if(!$page){
                $page = Page::where("slug_en",$slug)->firstOrFail(); 
            }
        }else{
            $page = Page::where("slug_vn",$slug)->first();    
        }
        if($page){
            if(in_array($page->id,[3,4,14]))
                abort(404);
           if ($page->template !== '' and view()->exists(config('view.root_page'). $page->template)) {
                //shortcode form
                $forms = Form::all();
                $arr = [];
                $replace = [];
                foreach ($forms as $form) {
                    $arr[] = '['.$form->slug.']';
                    $replace[] = $form->excerpt;
                }
                $contentget = str_replace($arr,$replace,stripslashes($page->description));
                $data['contentget'] = $contentget;
                $data['page'] = $page;
                $ids = $page->gallery;
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $data['gallery'] = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get();
                // var_dump(config('view.root_page'). $page->template);die;
                switch ($page->template) {
                    case 'teams':
                        $data['hoidong']= Post::where('desc_vn','hoidong')->orderBy('ordering','desc')->orderBy('created_at','desc')->get();
                        $i= 0;
                        foreach($data['hoidong'] as $mem){
                            $img = Resource::where('id',$mem->resource_id)->first();
                            $data['hoidong'][$i]->image = $img->name;
                            $i++;
                        }
                        // var_dump($data);die;
                        $data['teams'] = Post::where('cid',14)->orderBy('ordering','asc')->orderBy('cat_id','asc')->get();
                        break;
                    case 'partners':
                        $data['module'] = Module::where('cid',37)->first();
                        $categories = Category::where('cid',37)->orderBy('created_at','desc')->orderBy('ordering','asc')->get();
                        foreach ($categories as  $category) {
                            $category->posts;
                        } 
                        $data['categories'] = $categories;
                        break;
                    case 'about':

                        $data['form'] = Form::whereRaw("slug LIKE UPPER('%form-2%')")->first();
                        $categories = Category::where('cid',37)->orderBy('ordering','asc')->orderBy('cat_id','asc')->get();
                        foreach ($categories as  $category) {
                            $category->posts;
                        } 
                        $data['categories'] = $categories;
                        $data['customer'] = Post::where('cid',6);

                        if(\Lang::getLocale() == 'en'){
                            $data['customer'] = $data['customer']->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
                        }
                        $data['customer']  = $data['customer']->orderBy('ordering','asc')->orderBy('sticky','desc')->orderBy('id','desc')->take(6)->get();
                        break;
                    case 'service2':
                        //49 là đang kêu gọi, 48 là dự án hết suất
                        $data['p49'] = [];
                        $data['p48'] = [];
                        $data['doitac'] = Post::where('desc_vn','omember')->get();
                        // if(\Lang::getLocale() == 'en'){
                        //     $category = Category::where("alias_en","hoat-dong-an-cu")->first();
                        // }else{
                            $category = Category::where("alias_vn","hoat-dong-an-cu")->first();
                        // }
                        // $category = Category::whereRaw("UPPER(slug) LIKE UPPER('%hoat-dong-an-cu%')")->first();
                        //lay video có check show trong serivce
                        $data['video'] = Post::where('cat_id',$category->id)->where('service_display',2);
                        if(\Lang::getLocale() == 'en'){
                            $data['video'] = $data['video']->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
                        }
                        $data['video'] =  $data['video']->orderBy('ordering','desc')->first();
                        // var_dump($data['video']);die;
                        // var_dump($category);die;
                        if($category){
                            $data['hoatdong'] = Post::where('cat_id',$category->id);
                            if(\Lang::getLocale() == 'en'){
                                $data['hoatdong'] = $data['hoatdong']->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
                            }
                            $data['hoatdong'] = $data['hoatdong']->where('service_display',1)->orderBy('created_at','desc')->limit(5)->get();
                        }else{
                            $ddata['hoatdong'] = [];
                        }
                        //lấy tin trong hoat dong usis có check service
                        
                        
                        if(strpos($slug, 'dich-vu-an') !== false){
                        $data['deputy'] = Post::where('desc_vn','hoidong')->where('desc_en',3)->orderBy('ordering','desc')->orderBy('created_at','desc')->get();
                        }
                        break;
                    case 'service':
                        //49 là đang kêu gọi, 48 là dự án hết suất
                        $data['p49'] = Project::where('cat_id',49)->orderBy('sticky','desc')->get();
                        $data['p48'] = Project::where('cat_id',48)->orderBy('sticky','desc')->limit(6)->get();
                        if(strpos($slug, 'dich-vu-an') !== false){
                        $data['deputy'] = Post::where('desc_vn','hoidong')->where('desc_en',3)->orderBy('ordering','desc')->orderBy('created_at','desc')->get();
                        }
                    default: 
                    break;
                }
                var_dump(config('view.root_page'). $page->template);die;
                return view(config('view.root_page'). $page->template, $data);
            }
        }else{
            abort(404);
        }
    }


    public function serive(Request $request){
        $page=Page::where('slug','dich-vu')->firstOrFail();
        return back();
    }
    public function customer(Request $request){
        // var_dump('a');die;
        $module = Module::select('*','image as resource_id')->where('cid',6)->first();
        $datas = Post::where('cid',6)->where('active',1);
        if(\Lang::getLocale() == 'en'){
            $datas = $datas->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }
        $datas = $datas->orderBy('ordering','desc')->orderBy('created_at','desc')->orderBy('id','desc')->paginate(12);    
        return view('amp.customers', compact('module', 'datas'));
    }
    public function customerDetail(Request $request, $slug){

        $customer = Post::where('cid',6);
        if(\Lang::getLocale() == 'en'){
            $customer = $customer->where("alias_en",$slug)->firstOrFail();
        }else{
            $customer = $customer->where("alias_vn",$slug)->firstOrFail();
        }
        if(!$customer){
            abort(404);
        }
        $module = Module::where('cid',6)->first();
        $others = Post::where('cid',6)->where('id', '<>',$customer->id)->where('active',1);
        if(\Lang::getLocale() == 'en'){
            $others = $others->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }
        $others = $others->orderBy('ordering','asc')->orderBy('id','desc')->limit(12)->get();
        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $contentget = str_replace($arr,$replace,stripslashes($customer->description));
        return view('amp.customerDetail', compact('customer','module', 'others','contentget'));
    }

    public function projects(Request $request){
        $module = Module::where('cid',4)->first();
        $datas_top = Project::where('cid',4)->where('cat_id',49);
        if(\Lang::getLocale() == 'en'){
            $datas_top = $datas_top->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }
        $datas_top = $datas_top->orderBy('sticky','asc')->orderBy('id','desc')->limit(6)->get();
        $datas = Project::where('cid',4)->where('cat_id',48)->where('active',1);
        if(\Lang::getLocale() == 'en'){
            $datas = $datas->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }
        $datas = $datas->orderBy('sticky','desc')->orderBy('created_at','desc')->orderBy('id','desc')->paginate(12);
        return view('amp.projects', compact('module', 'datas','datas_top'));
    }
    public function projectDetail(Request $request, $slug){
        $project = Project::where('cid',4);
        if(\Lang::getLocale() == 'en'){
            $project = $project->where("slug_en",$slug)->firstOrFail();
        }else{
            $project = $project->where("slug_vn",$slug)->firstOrFail();
        }
        if(!$project){
            abort(404);
        }

        $module = Module::where('cid',4)->first();
        $ids = $project->img_slide;
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $gallery = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get();

        $investImg = $project->invest_id ? Resource::where('id', $project->invest_id)->first() : '';
        $investImg = $investImg ? '/uploads/thumbnail/'.$investImg->type.'/'.$investImg->name :'';
        //$others = Post::where('cid',6)->where('id', '<>',$customer->id)->orderBy('ordering','asc')->orderBy('id','desc')->limit(12)->get();

        //related porject
        $category = $project->category()->first();
        $projects = Project::where('cat_id',$category->id)->where('id','<>',$project->id)->limit(6)->get(); 

        //image overview
        $imageOverview = Resource::where('id',$project->overview_id)->first();
        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $contentget = str_replace($arr,$replace,stripslashes($project->description));

        return view('amp.projectDetail', compact('project','module','gallery','investImg','projects','imageOverview','contentget'));
    }

    public function service(Request $request, $slug){
        $project = Post::where('cid',4);
        if(\Lang::getLocale() == 'en'){
            $project = $project->where("alias_en",$slug)->first();
        }else{
            $project = $project->where("alias_vn",$slug)->first();
        }

        if(!$project){
            abort(404);
        }
        $module = Module::where('cid',4)->first();
        //$others = Post::where('cid',6)->where('id', '<>',$customer->id)->orderBy('ordering','asc')->orderBy('id','desc')->limit(12)->get();
        return view('amp.projectDetail', compact('project','module'));
    }

    public function faqs(Request $request,$slug = ''){
        if(\Lang::getLocale() == 'en'){
             $page = Page::where("slug_en","faqs")->firstOrFail();
        }else{  
             $page = Page::where("slug_vn","cau-hoi-thuong-gap")->firstOrFail();
        }
       
        if($slug == ''){
            if(LaravelLocalization::getCurrentLocale() == 'vi'){
                $slug = 'cau-hoi-chung';
            }else{
                $slug = 'faqs';
            }
        }
        $module = Module::where('cid',9)->first();
        $category = Category::where('cid',9);
        if(\Lang::getLocale() == 'en'){
            $category= $category->where("alias_en",$slug)->first();
        }else{
            $category= $category->where("alias_vn",$slug)->first();
        }
        
        $categories = Category::where('cid',9)->orderBy('ordering','asc')->orderBy('id','desc')->get();
        $datas = Post::where('cid',9)->where('active',1)->where('cat_id',$category->id)->orderBy('ordering','desc')->orderBy('created_at','desc')->orderBy('id','desc')->get();
        return view('amp.faqs', compact('module', 'datas','slug','category','categories','page'));
    }

    public function news(Request $request, $slug = ''){
            if($slug == ''){
                if(LaravelLocalization::getCurrentLocale() == 'vi'){
                    $slug = 'tin-tuc-my';
                }else{
                    $slug = 'us-news';
                }
            }
        $category = Category::where('cid',8);

        if(\Lang::getLocale() == 'en'){
            $category= $category->where("alias_en",$slug)->first();
        }else{
            $category= $category->where("alias_vn",$slug)->first();
        }
        if($category){
            $lifemodule = Module::where('cid',7)->first();
            $module = Module::select('*','image as resource_id')->where('cid',8)->first();
            $categories = Category::where('cid',8)->orderBy('ordering','asc')->orderBy('id','asc')->get();
            $luatdichu = Module::where('id',72)->first();
            $huongdan = Module::where('cid',10)->first();
            $datas = Post::where('cid',8)->where('active',1)->where('cat_id',$category->id)->orderBy('ordering','desc')->orderBy('created_at','desc')->orderBy('id','desc')->get();


            //dùng pagination custom
            $posts = [];
            // $datacheck = Post::where('cid',8)->where('cat_id',$category->id)->orderBy('ordering','asc')->orderBy('id','desc')->get();
            if(isset($datas)){
                foreach ($datas as $data) {
                    //loại bài viết có title rỗng
                    if($data->title != ''){
                       $posts[] = $data; 
                    }
                   
                }
            }
            $collection = ( new Collection( $posts ) )->paginate( 12 );

            return view('amp.news', compact('module', 'datas','slug','category','categories','lifemodule','posts','collection','luatdichu','huongdan'));
        }else{
            $module = Module::where('cid',8)->first();
            $life = Module::where('cid',7)->first();
            $post = Post::where('cid',8);
            if(\Lang::getLocale() == 'en'){
                $post = $post->where('alias_en',$slug)->firstOrFail();
            }else{
                $post = $post->where('alias_vn',$slug)->firstOrFail();
            }
            $category= $post->category()->first();
            $newCategories = Category::whereIn('id',[13,14,45])->get();
            $lifecate = Module::where('id',9)->first();
            $relateds =Post::where('cid',8)->where('id','<>',$post->id)->where('active',1);
            if(\Lang::getLocale() == 'en'){
                $relateds =$relateds->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $relateds = $relateds->orderBy('ordering','asc')->orderBy('id','desc')->limit(9)->get();

            //shortcode form
            $forms = Form::all();
            $arr = [];
            $replace = [];
            foreach ($forms as $form) {
                $arr[] = '['.$form->slug.']';
                $replace[] = $form->excerpt;
            }
            $contentget = str_replace($arr,$replace,stripslashes($post->description));
            $tags = DB::table('tag_post')->join('tags','tag_post.tag_id','=','tags.id')->where('post_id',$post->id)->get();
            $cateCheck = 'new';
            return view('amp.newsDetail', compact('post','relateds','module','life','newCategories','lifecate','contentget','category','cateCheck','tags'));  
        }
        
    }



    public function life(Request $request, $slug=''){
        if($slug == 'en' || $slug == 'vi'){
           abort(404); 
        }
            
       if($slug == ''){
            if(LaravelLocalization::getCurrentLocale() == 'vi'){
                $slug = 'cuoc-song-nguoi-viet-tai-my';
            }else{
                $slug = 'vietnamese-pride-in-the-us';
            }
        }
        $lifeCategory = Category::where('cid',7);
        if(\Lang::getLocale() == 'en'){
            $lifeCategory = $lifeCategory->where('alias_en',$slug)->first();
        }else{
            $lifeCategory = $lifeCategory->where('alias_vn',$slug)->first();
        }
        // ->whereRaw("slug LIKE UPPER('%{$slug}%')")->first();

        if($lifeCategory){
           $lifemodule = Module::where('cid',7)->first();
            $categories = Category::where('cid',8)->orderBy('ordering','asc')->orderBy('id','asc')->get();
            $lifeCategories = Category::where('cid',7)->orderBy('ordering','asc')->orderBy('id','asc')->get();
            
            $datas = Post::where('cid',7)->where('cat_id',$lifeCategory->id);
            if(\Lang::getLocale() == 'en'){
                $datas= $datas->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $datas= $datas->orderBy('ordering','asc')->orderBy('id','desc')->paginate(12);
            $hots = Post::where('cid',7)->where('sticky',1)->orderBy('ordering','asc')->orderBy('id','desc')->paginate(3);
            $luatdichu = Module::where('id',72)->first();
            $huongdan = Module::where('cid',10)->first();
            return view('amp.life', compact('module', 'datas','slug','categories','lifemodule','lifeCategories','hots','lifeCategory','luatdichu','huongdan')); 
        }else{
            $module = Module::where('cid',8)->first();
            $life = Module::where('cid',7)->first();
            $lifeCategories = Category::where('cid',7)->orderBy('ordering','asc')->orderBy('id','asc')->get();

            $post = Post::where('cid',7);
            if(\Lang::getLocale() == 'en'){
                $post = $post->where('alias_en',$slug)->firstOrFail();
            }else{
                $post = $post->where('alias_vn',$slug)->firstOrFail();
            }
            $cureCateLife = $post->category()->first();
            $relateds =Post::where('cid',7)->where('id','<>',$post->id)->where('cat_id',$cureCateLife->id)->where('active',1)->orderBy('ordering','asc')->orderBy('id','desc')->limit(9)->get(); 
               
            $contentget = '';
            $lifeDetail = true;
            //shortcode form
            $forms = Form::all();
            $arr = [];
            $replace = [];
            foreach ($forms as $form) {
                $arr[] = '['.$form->slug.']';
                $replace[] = $form->excerpt;
            }
            $contentget = str_replace($arr,$replace,stripslashes($post->description));
            $tags = DB::table('tag_post')->join('tags','tag_post.tag_id','=','tags.id')->where('post_id',$post->id)->get();
            return view('amp.lifeDetail', compact('post','relateds','module','lifeCategories','life','lifeDetail','contentget','cureCateLife','tags'));
        }
        

    }

    public function events(Request $request, $slug=''){

        if($slug == ''){
            if(LaravelLocalization::getCurrentLocale() == 'vi'){
                $slug = 'hoat-dong-usis';
            }else{
                $slug = 'usis-activities';
            }
        }
        if(\Lang::getLocale() == 'en'){
            $category= Category::where('cid',2)->where("alias_en",$slug)->first();
            if(!$category){
                $category = Category::where('cid',2)->where("alias_vn",$slug)->first();
            }
        }else{
            $category= Category::where('cid',2)->where("alias_vn",$slug)->first();
        }

        if($category){  
            $module = Module::where('cid',2)->first();        
            $categories = Category::where('cid',2)->orderBy('ordering','asc')->orderBy('id','asc')->get();
            $stickyEvent = Post::where('cid',2)->where('cat_id',$category->id)->where('sticky',1);
            if(\Lang::getLocale() == 'en'){
                $stickyEvent = $stickyEvent->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $stickyEvent = $stickyEvent->orderBy('ordering','desc')->orderBy('id','desc')->first();
            $datas = Post::where('cid',2)->where('cat_id',$category->id)->where('active',1);
            if(\Lang::getLocale() == 'en'){
                $datas = $datas->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $datas = $datas->orderBy('ordering','asc')->orderBy('id','desc')->paginate(12);
            return view('amp.events', compact('module', 'datas','category','categories','stickyEvent'));  
        }else{
            $module = Module::where('cid',2)->first();
            $life = Module::where('cid',7)->first();
            $lifeCategories = Category::where('cid',7)->orderBy('ordering','asc')->orderBy('id','asc')->get();
            $post = Post::where('cid',2);
            if(\Lang::getLocale() == 'en'){
                $post = $post->where('alias_en',$slug)->firstOrFail();
            }else{
                $post = $post->where('alias_vn',$slug)->firstOrFail();
            }
            // ->whereRaw("slug LIKE UPPER('%{$slug}%')")->firstOrFail();

            $category = $post->category()->first();
            // var_dump($category->id);die;
            $eventsDetail = true;
            //shortcode form
            $forms = Form::all();
            $arr = [];
            $replace = [];
            foreach ($forms as $form) {
                $arr[] = '['.$form->slug.']';
                $replace[] = $form->excerpt;
            }
            $contentget = str_replace($arr,$replace,stripslashes($post->description));
            $relateds =Post::where('cid',2)->where('cat_id',$category->id)->where('id','<>',$post->id);
            if(\Lang::getLocale() == 'en'){
                $relateds =$relateds->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $relateds =$relateds->orderBy('ordering','asc')->orderBy('id','desc')->limit(9)->get();
            $tags = DB::table('tag_post')->join('tags','tag_post.tag_id','=','tags.id')->where('post_id',$post->id)->get();
            return view('amp.eventsDetail', compact('post','relateds','module','lifeCategories','life','contentget','eventsDetail','tags'));
        }
        
    }
    public function eventsDetail(Request $request, $slug) {
        if($slug == 'en' || $slug == 'vi'){
           abort(404); 
        }
        $module = Module::where('cid',2)->first();
        $life = Module::where('cid',7)->first();
        $lifeCategories = Category::where('cid',7)->orderBy('ordering','asc')->orderBy('id','asc')->get();

        $post = Post::where('cid',2);
        if(\Lang::getLocale() == 'en'){
            $post = $post->where('alias_en',$slug)->first();
        }else{
            $post = $post->where('alias_vn',$slug)->first();
        }
        // ->whereRaw("slug LIKE UPPER('%{$slug}%')")->first();

        if($post){
            $category = $post->category()->first();
            // var_dump($category->id);die;
            $eventsDetail = true;
            //shortcode form
            $forms = Form::all();
            $arr = [];
            $replace = [];
            foreach ($forms as $form) {
                $arr[] = '['.$form->slug.']';
                $replace[] = $form->excerpt;
            }
            $contentget = str_replace($arr,$replace,stripslashes($post->description));
            $relateds =Post::where('cid',2)->where('cat_id',$category->id)->where('id','<>',$post->id);
            if(\Lang::getLocale() == 'en'){
                $relateds =$relateds->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $relateds =$relateds->orderBy('ordering','asc')->orderBy('id','desc')->limit(9)->get();
            $tags = DB::table('tag_post')->join('tags','tag_post.tag_id','=','tags.id')->where('post_id',$post->id)->get();
            return view('amp.eventsDetail', compact('post','relateds','module','lifeCategories','life','contentget','eventsDetail','tags'));    
        }else{
            $category = Category::where('cid',2);
            if(\Lang::getLocale() == 'en'){
                $category= $category->where("alias_en",$slug)->first();
            }else{
                $category= $category->where("alias_vn",$slug)->first();
            }
            // ->whereRaw("slug LIKE UPPER('%{$slug}%')")->first();


            $module = Module::where('cid',2)->first();        
            $categories = Category::where('cid',2)->orderBy('ordering','asc')->orderBy('id','asc')->get();
            $stickyEvent = Post::where('cid',2)->where('cat_id',$category->id)->where('sticky',1);
            if(\Lang::getLocale() == 'en'){
                $stickyEvent = $stickyEvent->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $stickyEvent = $stickyEvent->orderBy('ordering','desc')->orderBy('id','desc')->first();
            $datas = Post::where('cid',2)->where('cat_id',$category->id)->where('active',1);
            if(\Lang::getLocale() == 'en'){
                $datas = $datas->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $datas = $datas->orderBy('ordering','asc')->orderBy('id','desc')->paginate(12);
            return view('amp.events', compact('module', 'datas','category','categories','stickyEvent'));  
        }

    }

    public function laws(Request $request,$slug=''){
        $post = Post::where('cid',72);
        if(\Lang::getLocale() == 'en'){
            $post = $post->where('alias_en',$slug)->first();
        }else{
            $post = $post->where('alias_vn',$slug)->first();
        }
        
        if($post){
            $module = Module::where('cid',2)->first();
            $life = Module::where('cid',7)->first();
            
            // ->whereRaw("slug LIKE ('%{$slug}%')")->first();
            $curCateLaw = $post->category()->first();
            var_dump($curCateLaw);die;
            $relateds =Post::where('cid',72)->where('id','<>',$post->id);
            if(\Lang::getLocale() == 'en'){
                $relateds = $relateds->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $relateds = $relateds->orderBy('ordering','asc')->orderBy('id','desc')->get();
            $lawDetail = true;
            //shortcode form
            $forms = Form::all();
            $arr = [];
            $replace = [];
            foreach ($forms as $form) {
                $arr[] = '['.$form->slug.']';
                $replace[] = $form->excerpt;
            }
            $contentget = str_replace($arr,$replace,stripslashes($post->description));
            return view('amp.newsDetail', compact('post','relateds','module','life','lawDetail','contentget','curCateLaw'));
        }else{
            $module = Module::where('cid',72)->first();
            $datas = Post::where('cid',72)->where('active',1);
            $page = Page::whereRaw("slug LIKE UPPER('%luat-di-tru%')")->first();
            if(\Lang::getLocale() == 'en'){
                $datas = $datas->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $datas = $datas->orderBy('ordering','desc')->orderBy('created_at','desc')->orderBy('id','desc')->paginate(12);
            $categories = Category::where('cid',8)->orderBy('ordering','asc')->orderBy('id','asc')->get();
            $lifemodule = Module::where('cid',7)->first();
            $huongdan = Module::where('cid',10)->first();
            return view('amp.laws', compact('module', 'datas','categories','lifemodule','page','huongdan'));
        }
        
    }

    public function lawsDetail(Request $request, $slug) {
        if($slug == 'en' || $slug == 'vi'){
           abort(404); 
        }
        $module = Module::where('cid',2)->first();
        $life = Module::where('cid',7)->first();
        $post = Post::where('cid',72);
        if(\Lang::getLocale() == 'en'){
            $post = $post->where('alias_en',$slug)->first();
        }else{
            $post = $post->where('alias_vn',$slug)->first();
        }
        // ->whereRaw("slug LIKE ('%{$slug}%')")->first();
        $curCateLaw = $post->category()->first();
        $relateds =Post::where('cid',72)->where('id','<>',$post->id);
        if(\Lang::getLocale() == 'en'){
            $relateds = $relateds->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }
        $relateds = $relateds->orderBy('ordering','asc')->orderBy('id','desc')->get();
        $lawDetail = true;
        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $contentget = str_replace($arr,$replace,stripslashes($post->description));
        return view('amp.newsDetail', compact('post','relateds','module','life','lawDetail','contentget','curCateLaw'));
    }
    

	public function showPost($slug) {
		$post = Post::where('slug', $slug)->firstOrFail();
		$others = Post::with('resource')->where('id', '<>', $post->id)->whereHas('categories', function($query) use($post) {
            $query->where('categories.id', $post->category->id);
        })->orderBy('id', 'desc')->take(6)->get();
        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $contentget = str_replace($arr,$replace,stripslashes($post->description));
		return view('amp.post', compact('post', 'others','contentget'));
	}

    
    public function thank(Request $request) {
        $tracking = $request->session()->get('tracking', null);
        return view($this->agent->isPhone() ? 'amp.checkout.thankyou-mobile' : 'amp.checkout.thankyou', compact('tracking'));
    }

    
    public function newsDetail(Request $request, $slug) {
        if($slug == 'en' || $slug == 'vi'){
           abort(404); 
        }   
        $module = Module::where('cid',8)->first();
        $life = Module::where('cid',7)->first();
        $post = Post::where('cid',8);
        if(\Lang::getLocale() == 'en'){
            $post = $post->where('alias_en',$slug)->firstOrFail();
        }else{
            $post = $post->where('alias_vn',$slug)->firstOrFail();
        }
        // ->whereRaw("slug LIKE UPPER('%{$slug}%')")->firstOrFail();

        $newCategories = Category::whereIn('id',[13,14,45])->get();
        $lifecate = Module::where('id',9)->first();
        $relateds =Post::where('cid',8)->where('id','<>',$post->id)->where('active',1);
        if(\Lang::getLocale() == 'en'){
            $relateds =$relateds->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }
        $relateds = $relateds->orderBy('ordering','asc')->orderBy('id','desc')->limit(9)->get();

        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $contentget = str_replace($arr,$replace,stripslashes($post->description));
        return view('amp.newsDetail', compact('post','relateds','module','life','newCategories','lifecate','contentget'));
    }

    public function lifeDetail(Request $request, $slug) {
        if($slug == 'en' || $slug == 'vi'){
           abort(404); 
        }
        $module = Module::where('cid',8)->first();
        $life = Module::where('cid',7)->first();
        $lifeCategories = Category::where('cid',7)->orderBy('ordering','asc')->orderBy('id','asc')->get();
        $post = Post::where('cid',7)->whereRaw("slug LIKE UPPER('%{$slug}%')")->firstOrFail();
        $relateds =Post::where('cid',7)->where('id','<>',$post->id)->where('active',1)->orderBy('ordering','asc')->orderBy('id','desc')->limit(9)->get(); 
           
        $contentget = '';
        $lifeDetail = true;
        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $contentget = str_replace($arr,$replace,stripslashes($post->description));
        return view('amp.newsDetail', compact('post','relateds','module','lifeCategories','life','lifeDetail','contentget'));
    }
    /**
     * Copy tu newsDetail, xai chung view voi newsDetail
     */
    

    public function contact(Request $request, $slug = 'lien-he') {
        $page = Page::where('slug', $slug)->firstOrFail();
        if(!$page){
            abort(404);
        }
                
        return view('amp.page.contact',compact('page'));
    }


   public function doitacDetail(Request $request,$slug){
        if($slug == 'en' || $slug == 'vi'){
           abort(404); 
        }
        //37 id cua đối tác chiến lược
        $post = Post::whereRaw("slug LIKE ('%{$slug}%')")->where('cid',37)->firstOrFail();
        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $contentget = str_replace($arr,$replace,stripslashes($post->description));
        $secPage = Module::where('cid',37)->first();
        return view('amp.doitacchienluoc',compact('post','contentget','secPage'));
   }

   public function hoidongDetail(Request $request,$slug){
        if($slug == 'en' || $slug == 'vi'){
           abort(404); 
        }
        $customer = Post::where('desc_vn','hoidong');
        if(\Lang::getLocale() == 'en'){
            $customer = $customer->where('alias_en',$slug)->firstOrFail();
        }else{
            $customer = $customer->where('alias_vn',$slug)->firstOrFail();
        }

        // ->whereRaw("slug LIKE ('%{$slug}%')")->firstOrFail();

        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $contentget = str_replace($arr,$replace,stripslashes($customer->description));
        return view('amp.hoidongDetail',compact('customer','contentget'));
   }

   public function daidienDetail(Request $request,$slug){
        $customer = Post::where('desc_vn','hoidong')->where('desc_en',3)->whereRaw("slug LIKE ('%{$slug}%')")->firstOrFail();
        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $contentget = str_replace($arr,$replace,stripslashes($customer->description));
        return view('amp.hoidongDetail',compact('customer','contentget'));
   }

   public function search(Request $request){
        $posts = [];
        $keyword = '';
        if($request->namesearch){
            $keyword = $request->namesearch;
            $query = Post::where('title','like','%'.$keyword.'%')->where('active',1);
            if(\Lang::getLocale() == 'en'){
               $query = $query->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $posts = $query->orderBy('created_at','desc')->orderBy('id','desc')->limit(12)->get();
        } 
        return view ('amp.search',compact('posts','keyword'));
   }
   public function searching(Request $request){
        if ($request->ajax()) {
            $keyword = $request->keyword;
            // $posts = Post::whereRaw('UPPER("%title%") like UPPER("'.$keyword.'")')->get();
            $query = Post::where('title','like','%'.$keyword.'%')->where('active',1);
            if(\Lang::getLocale() == 'en'){
               $query = $query->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }
            $posts = $query->orderBy('created_at','desc')->orderBy('id','desc')->get();
            // return response()->json(compact('posts')); 
            return view('partials.search',compact('posts'));
        }
   }

   public function huongdandinhcu(Request $request){
        $lifemodule = Module::where('cid',7)->first();
        $luatdichu = Module::where('id',72)->first();
        $categories = Category::where('cid',8)->orderBy('ordering','asc')->orderBy('id','asc')->get();
        //lấy bài trong huong dan dinh cu và dich vu
        $datas = Post::whereIn('cid',[10,3])->where('active',1);
        if(\Lang::getLocale() == 'en'){
            $datas =$datas->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }
        $datas =$datas->orderBy('ordering','asc')->orderBy('id','desc')->paginate(12);
        $module = Module::where('cid',10)->first();
        return view('amp.huongdandinhcu',compact('lifemodule','luatdichu','datas','module','categories'));
   }

   public function hddcDetail(Request $request,$slug){

        if($slug == 'en' || $slug == 'vi'){
           abort(404); 
        }
        $post = Post::whereIn('cid',[10,3]);
        if(\Lang::getLocale() == 'en'){
            $post = $post->where('alias_en',$slug)->firstOrFail();
        }else{
            $post = $post->where('alias_vn',$slug)->firstOrFail();
        }

        // ->whereRaw("slug LIKE ('%{$slug}%')")->firstOrFail();


        $relateds =Post::whereIn('cid',[10,3])->where('id','<>',$post->id);
        if(\Lang::getLocale() == 'en'){
                $relateds =$relateds->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }
        $relateds =$relateds->where('active',1)->orderBy('ordering','asc')->orderBy('id','desc')->get();
        $module = $post->module()->first();
        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $hddc = 'huong-dan';
        $contentget = str_replace($arr,$replace,stripslashes($post->description));
        return view('amp.hddcDetail', compact('post','relateds','contentget','module','hddc'));
   }
   // hàm redirecy
   public function redirectPost($slug){
        return Redirect::to('/tin-tuc-usis/'.$slug,301);
   }

    public function formXacNhan(Request $request){
         $form = Form::where('type',1)->first();
         return view('amp.form.xacnhan',compact('form'));
    }

   //shortcode
   // [slide type=1]

   private function slideNhanSu($content,$type){
        $query = Post::where('desc_vn','hoidong');
        if($type){
            $query = $query->where('desc_en',$type);
        }
        $posts = $query->orderBy('ordering','desc')->limit(10)->get();
        $html = '<section class="u020  row-section wow" > <div class="container"><div class="slide3-arr owl-carousel list14 arrow-style-1">';
        foreach ($posts as $post) {
            $html .='<div class="item ">
                    <div class="top-img">
                    <div class="img thumbCover_127"><img src="'.$post->getImage('full').'" alt="image01" /></div>
                    <h3 class="title">'.$post->title.'</h3>
                    </div>
                    <div class="text ">                    
                        <div class="position">'.$post->excerpt.'</div>
                        <div class="desc">'.$post->description.'
                        </div>
                    </div>                                      
                </div>';
        }
        $html .='</div></div></section>';
        $contentget = str_replace('[slide type="'.$type.'"]',$html,stripslashes($content));
   }


   public function level3Dichvu(Request $request,$slug,$permalink){
        //kiem tra nguoi dai dien
        $customer = Post::where('desc_vn','hoidong')->where('desc_en',3);
        if(\Lang::getLocale() == 'en'){
            $customer = $customer->where("alias_en",$permalink)->first();
        }else{
            $customer = $customer->where("alias_vn",$permalink)->first(); 
        }
        if($customer){
            //shortcode form
            $forms = Form::all();
            $arr = [];
            $replace = [];
            foreach ($forms as $form) {
                $arr[] = '['.$form->slug.']';
                $replace[] = $form->excerpt;
            }
            $secPage = Page::where('slug_vn','dich-vu-an-cu-my')->first();
            $thiPage = Page::where('slug_vn','gioi-thieu-an-cu')->first();
            $contentget = str_replace($arr,$replace,stripslashes($customer->description));
            return view('amp.hoidongDetail',compact('customer','contentget','secPage','thiPage'));
        }
        
        // $pagefirst = Page::whereRaw("slug LIKE UPPER('%{$slug}%')")->first();
        if(\Lang::getLocale() == 'en'){
            $pagefirst = Page::where("slug_en",$slug)->first(); 
        }else{
            $pagefirst = Page::where("slug_vn",$slug)->first(); 
        }

        // $page = Page::whereRaw("slug LIKE UPPER('%{$permalink}%')")->first();
        if(\Lang::getLocale() == 'en'){
            $page = Page::where("slug_en",$permalink)->first(); 
        }else{
            $page = Page::where("slug_vn",$permalink)->first(); 
        }

        //check page gioi thieu
     
        if($permalink == 'gioi-thieu-an-cu' || $permalink == 'introduce'){
            $secPage = Page::where('slug_vn','dich-vu-an-cu-my')->first();
            $deputy= Post::where('desc_vn','hoidong')->where('desc_en',3)->orderBy('ordering','desc')->orderBy('created_at','desc')->get();
            $doitac = Post::where('desc_vn','hoidong')->where('desc_en',4)->get();
            return view('amp.page.service2',compact('page','pagefirst','deputy','secPage','permalink'));


        }else{
            // neu khong co page2 thi kien tra 2 dk con lai
            if($permalink == 'doi-tac-an-cu' || $permalink == 'settlement-partners'){
                $doitacancu = Post::where('desc_vn','omember')->get();

                $secPage = Page::where('slug_vn','dich-vu-an-cu-my')->first();
                // $page = Page::whereRaw("slug LIKE UPPER('%{$permalink}%')")->first();
                if(\Lang::getLocale() == 'en'){
                    $page = Page::where("slug_en",$permalink)->first(); 
                }else{
                    $page = Page::where("slug_vn",$permalink)->first(); 
                }
                return view('amp.page.partners',compact('doitacancu','page','secPage'));
            }elseif($permalink == 'hoat-dong-an-cu' || $permalink =='activities'){
                $secPage = Page::where('slug_vn','dich-vu-an-cu-my')->first();

                //nhớ kiểm tra active
                // $category = Category::whereRaw("UPPER(slug) LIKE UPPER('%{$permalink}%')")->first();
                if(\Lang::getLocale() == 'en'){
                    $category= Category::where("alias_en",$permalink)->firstOrFail();
                }else{
                    $category= Category::where("alias_vn",$permalink)->firstOrFail();
                }

                // $category = Category::where('alias_vn',$permalink)->first();
                $checkPag = TRUE;
                $posts = Post::where('cat_id',$category->id);
                if(\Lang::getLocale() == 'en'){
                    $posts = $posts->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
                }
                $posts = $posts->orderBy('ordering','desc')->orderBy('created_at','desc')->orderBy('id','desc')->paginate(12);
                return view('amp.hoatdongancu',compact('category','posts','checkPag','secPage'));
            }
            return abort(404);
        }
   }
   public function dtAncuChitiet(Request $request,$slug,$permalink,$partners){
        $post= Post::where('desc_vn','omember');
        if(\Lang::getLocale() == 'en'){  
            $post = $post->where('alias_en',$partners)->first();
            if(!$post){
                $post = Post::where('desc_vn','omember')->where('alias_vn',$partners)->first();
            }
        }else{
            $post = $post->where('alias_vn',$partners)->first();
        }
        if($post){
            if(\Lang::getLocale() == 'en'){
                $slug = 'us-settlement-service';
                $permalink = 'partners'; 
            }else{
                $slug = 'dich-vu-an-cu';
                $permalink = 'doi-tac-an-cu';
            }
            $category = $post->category()->first();
            $forms = Form::all();
            $arr = [];
            $replace = [];
            foreach ($forms as $form) {
                $arr[] = '['.$form->slug.']';
                $replace[] = $form->excerpt;
            }
            $moretext = false;
            $relateds  = Post::where('id','<>',$post->id)->where('active',1)->where('desc_vn','omember')->orderBy('ordering','asc')->orderBy('id','desc')->limit(9)->get();
            $contentget = str_replace($arr,$replace,stripslashes($post->description));
            $secPage = Page::where('slug_vn','dich-vu-an-cu-my')->first();
            $thiPage = Page::where("slug_vn",'doi-tac-an-cu')->first(); 
            return view('amp.doitac',compact('post','contentget','moretext','relateds','secPage','thiPage'));
        }
        

        //bài chi tiết hoat dong an cu
        $post = Post::where('cat_id',53);
        if(\Lang::getLocale() == 'en'){
            $post = $post->where('alias_en',$partners)->firstOrFail();
        }else{
            $post = $post->where('alias_vn',$partners)->firstOrFail();
        }
        // ->whereRaw("slug LIKE '%$slug%'")
        // ->firstOrFail();
        // $post = Post::where('id',3215)->first();
        $category=$post->category()->first();
        if($category){
            $relateds =Post::where('cat_id',$category->id)->where('id','<>',$post->id)->where('active',1);
            if(\Lang::getLocale() == 'en'){
                $relateds = $relateds->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }   
            $relateds = $relateds->orderBy('ordering','asc')->orderBy('id','desc')->limit(9)->get();
        }else{
            $relateds = [];
        }
        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $newscheck = 'hdancu';
        $titleorder = Lang::get('menu.hoatdongancukhac');
        $contentget = str_replace($arr,$replace,stripslashes($post->description));
        $secPage = Page::where('slug_vn','dich-vu-an-cu-my')->first();

        if(\Lang::getLocale() == 'en'){
            $thiPage= Category::where("alias_en",$permalink)->firstOrFail();
        }else{
            $thiPage= Category::where("alias_vn",$permalink)->firstOrFail();
        }
        $tags = DB::table('tag_post')->join('tags','tag_post.tag_id','=','tags.id')->where('post_id',$post->id)->get();
        return view('amp.hoatdongDetail', compact('post','contentget','relateds','category','newscheck','titleorder','thiPage','secPage','tags'));

   }
   public function hdAncuChitiet(Request $request,$slug){
        $post = Post::where('cat_id',53);
        if(\Lang::getLocale() == 'en'){
            $post = $post->where('alias_en',$slug)->firstOrFail();
        }else{
            $post = $post->where('alias_vn',$slug)->firstOrFail();
        }
        // ->whereRaw("slug LIKE '%$slug%'")
        // ->firstOrFail();
        // $post = Post::where('id',3215)->first();
        $category=$post->category()->first();
        if($category){
            $relateds =Post::where('cat_id',$category->id)->where('id','<>',$post->id)->where('active',1);
            if(\Lang::getLocale() == 'en'){
                $relateds = $relateds->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
            }   
            $relateds = $relateds->orderBy('ordering','asc')->orderBy('id','desc')->limit(9)->get();
        }else{
            $relateds = [];
        }
        //shortcode form
        $forms = Form::all();
        $arr = [];
        $replace = [];
        foreach ($forms as $form) {
            $arr[] = '['.$form->slug.']';
            $replace[] = $form->excerpt;
        }
        $newscheck = 'hdancu';
        $titleorder = Lang::get('menu.hoatdongancukhac');
        // var_dump($newscheck);die;
        $contentget = str_replace($arr,$replace,stripslashes($post->description));
        return view('amp.newsDetail', compact('post','contentget','relateds','category','newscheck','titleorder'));
   }

    public function feedCustom(){
        $posts= Post::whereNotIn('cid',[0,1,2])->orderBy('created_at','desc')->limit(50)->get();
        return response()->view('amp.feed',compact('posts'), 200)->header('Content-Type', 'text/xml');
    }

    public static function imageUrl($path, $width = NULL, $height = NULL,$quality=NULL,$crop=NULL) {
     
       if(!$width && !$height) {
       $url = env('IMAGE_URL') . $path;
       } else {
       $url = url('/') . '/timthumb.php?src=' . env('IMAGE_URL') . $path;
       if(isset($width)) {
       $url .= '&w=' . $width; 
       }
       if(isset($height) && $height>0) {
       $url .= '&h=' .$height;
       }
       if(isset($crop))
       {
       $url .= "&zc=".$crop;
       }
       else
       {
       $url .= "&zc=1";
       }
      if(isset($quality))
       {
       $url .='&q='.$quality.'&s=1';
       }
       else
       {
       $url .='&q=95&s=1';
       }
      }
     
     return $url;
    }
    public function siteMap(){
        $lastproject = Project::where('cid',4)->where('cat_id',48)->where('active',1)->orderBy('sticky','desc')->orderBy('created_at','desc')->orderBy('id','desc')->first();
        $lastpartner = Post::where('cid',37)->orderBy('created_at','desc')->first();
        $lastevent = Post::where('cid',2)->orderBy('created_at','desc')->first();
        $lastnews = Post::where('cid',8)->orderBy('created_at','desc')->first();
        $url = url('/');
        $arrayget = array(
            $url.'/landing-sitemap.xml'=>array($url.'/landing',[]),
            $url.'/du-an-sitemap.xml'=>array($url.'/du-an-dau-tu/',$lastproject),
            $url.'/doi-tac-sitemap.xml'=>array($url.'/doi-tac',$lastpartner),
            $url.'/su-kien-sitemap.xml'=>array($url.'/su-kien',$lastevent),
            $url.'/tin-tuc-sitemap.xml'=>array($url.'/tin-tuc-usis',$lastnews), 
        );
        if(\Lang::getLocale() == 'en'){
            $arrayget = array(
                $url.'/en/landing-sitemap.xml'=>array($url.'/landing',[]),
                $url.'/en/projects-sitemap.xml'=>array($url.'/projects',$lastproject),
                $url.'/en/partners-sitemap.xml'=>array($url.'/partners',$lastpartner),
                $url.'/en/events-sitemap.xml'=>array($url.'/events',$lastevent),
                $url.'/en/news-sitemap.xml'=>array($url.'/us-news',$lastnews), 
            );
        }
        $duan = Project::where('cid',4)->where('cat_id',48)->where('active',1)->orderBy('sticky','desc')->orderBy('created_at','desc')->orderBy('id','desc')->get();

        $doitac = Post::where('cid',37)->orderBy('created_at','desc')->get();


        $sukien = Post::where('cid',2)->orderBy('created_at','desc')->get();


        $tintuc = Post::where('cid',8)->orderBy('created_at','desc')->get();
        $cuocsong = Post::where('cid',7)->orderBy('ordering','asc')->orderBy('id','desc')->get();
        $luat = Post::where('cid',72)->where('active',1)->orderBy('ordering','desc')->orderBy('created_at','desc')->orderBy('id','desc')->get();
        $huongdan = Post::whereIn('cid',[10,3])->where('active',1)->orderBy('ordering','asc')->orderBy('id','desc')->get();

        return response()->view('amp.sitemap.sitemap',compact('arrayget','duan','doitac','sukien','tintuc','cuocsong','luat','huongdan'), 200)->header('Content-Type', 'application/xml');
    }

    public function pageSiteMap(Request $request){
        $xml = Route::getFacadeRoot()->current()->uri();
        $xml = str_replace('-sitemap.xml','',$xml);
        // var_dump($xml);die;
        if($xml == 'landing'  || $xml == 'en/landing'){
            $gioithieu = Page::where("slug_vn","gioi-thieu-usis")->whereIn('id',[1,2])->firstOrFail(); 
            $dichvu = Page::where("slug_vn",'visa-dinh-cu-my-theo-dien-dau-tu-eb-5')->whereIn('id',[3,4,14])->firstOrFail();
            $duan = Module::where('cid',4)->first();   
            $doitac = Page::where("slug_vn",'doi-tac')->firstOrFail();
            $sukien = Category::where('cid',2)->where("alias_vn",'hoat-dong-usis')->first();
            $tintuc = Category::where('cid',8)->where("alias_vn",'tin-tuc-my')->first();
            $khachhang = Post::where('cid',6)->where('active',1)->orderBy('ordering','desc')->orderBy('created_at','desc')->orderBy('id','desc')->first(); 
            $lienhe = Page::where('slug_vn', 'lien-he')->firstOrFail();
            $priority = 1;
             return response()->view('site.sitemap.landing-sitemap',compact('gioithieu', 'dichvu','duan','doitac','sukien','tintuc','khachhang','lienhe','xml','priority'), 200)->header('Content-Type', 'application/xml');
        }
        if($xml == 'du-an'){
            $datas = Project::where('cid',4)->where('cat_id',48)->where('active',1)->orderBy('sticky','desc')->orderBy('created_at','desc')->orderBy('id','desc');
            $priority = 0.8;
        }
        if($xml == 'doi-tac'){
            $datas = Post::where('cid',37)->orderBy('created_at','desc');
            $priority = 0.8;
        }
        if($xml == 'su-kien'){
            $datas = Post::where('cid',2)->orderBy('created_at','desc');
            $priority = 0.8;
        }
        if($xml == 'tin-tuc'){
            $datas = Post::where('cid',8)->orderBy('created_at','desc');
            $priority = 0.5;
        }
        if($xml == 'en/projects'){
            $datas = Project::where('cid',4)->where('cat_id',48)->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3")->where('active',1)->orderBy('sticky','desc')->orderBy('created_at','desc')->orderBy('id','desc');
            $priority = 0.8;
            $xml = 'du-an';
        }
        if($xml == 'en/news'){
            $datas = Post::where('cid',8)->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3")->orderBy('created_at','desc');
            $priority = 0.5;
            $xml = 'tin-tuc';
        }
        if($xml == 'en/partners'){
            $datas = Post::where('cid',37)->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3")->orderBy('created_at','desc');
            $priority = 0.8;
            $xml = 'doi-tac';
        }
        if($xml == 'en/events'){
            $datas = Post::where('cid',2)->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3")->orderBy('created_at','desc');
            $priority = 0.8;
            $xml = 'su-kien';
        }

        $datas = $datas->get();
        // var_dump($datas);die;
        
        return response()->view('site.sitemap.cat-sitemap',compact('datas','xml','priority'), 200)->header('Content-Type', 'application/xml');
    }
    public function thanksforregis(){
        return view('site.thanksforregis');
    }

    public function tags(Request $request,$slug){
        $tag = Tag::where('slug',$slug)->first();
        $posts = Post::join('tag_post','tbl_contents.id','=','tag_post.post_id');
        if(\Lang::getLocale() == 'en'){
            $posts = $posts->whereRaw("LENGTH(SUBSTRING_INDEX(title,'[:en]',-1)) > 3");
        }   
        $posts = $posts->where('tag_post.tag_id',$tag->id)->paginate(12);
        return view('amp.tag',compact('posts','tag'));
    }
    public function lienheFunction(Request $request){
        if(\Lang::getLocale() == 'en'){
            $post=Page::where('slug_en','lien-he')->first();
        }else{
            $post=Page::where('slug_vn','lien-he')->first();
        }
        return view('amp.contact',compact('post'));
    }
}
