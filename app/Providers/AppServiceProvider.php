<?php

namespace App\Providers;

use App\Menu;
use App\Page;
use App\Post;
use App\Form;
use App\Project;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use LaravelLocalization;
use App\Setting;
use App\Resource;
//custom pagination
use App\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('supported_locales', LaravelLocalization::getSupportedLocales());

        Blade::directive('e', function($expression) {
            list($textVi, $textEn) = explode(',',str_replace(['(',')',"'"], '', $expression));
            $text = '[:vi]' . $textVi . '[:en]' . $textEn . '[:]';
            return "<?php echo getLocaleValue('$text', \$current_locale); ?>";
        });
        View::composer(['site.header_menu'], function($view) {
            $menus = Menu::where([['position','=','header'],['active','=','1'],])->orderBy('created_at', 'desc')->firstOrFail()->pluck('data')->toArray();
            
            $setting = Setting::where('name','basic')->first();
            $menus = json_decode(current($menus), true);
            //  echo '<pre>';var_dump($menus,1); exit();
            $view->with(compact('menus','setting'));
        });
        View::composer(['amp.header_menu'], function($view) {
            $menus = Menu::where('position','amp')->firstOrFail()->pluck('data')->toArray();
            $setting = Setting::where('name','basic')->first();
            $menus = json_decode($menus[2],true);
            $view->with(compact('menus','setting'));
        });
        View::composer(['site.footer_menu'], function($view) {
            $menus = Menu::where([['position','=','footer'],['active','=','1'],])->orderBy('created_at', 'desc')->firstOrFail()->pluck('data')->toArray();

            $form = Form::where('slug','form-1')->first();
            // $page = Page::where('slug','dich-vu')->first();
            $menus = json_decode($menus[1], true);
            $segment = Request()->route()->getPrefix();//get current Name
            //var_dump($segment);
            if($segment == '/dich-vu' || $segment == '/du-an-dau-tu-eb-5'){
               $segment = 'true';
            }
            //related porject
            $projects = Project::where('cat_id',48)->limit(6)->get(); 
            //var_dump($projects);

            $footerlogo = Setting::where('name','logofooter')->first();
            $imagelogofooter = '';
            if($footerlogo){
                $imagelogofooter =  Resource::where('id',$footerlogo->resource_id)->first();
            }
            
            $setting = Setting::where('name','basic')->first();
            $logofooter = [];
            if($setting){
                $imageIds = unserialize($setting->value);
                // var_dump($imageIds);die;    
                if(is_array($imageIds)){
                    foreach ($imageIds[0] as $key => $value) {
                        $image = Resource::where('id',$value)->first();
                        if($image){
                             $logofooter['url'][] = $image->name;
                        }else{
                            $logofooter['url'][] = '';
                        }
                       
                    }
                    if($imageIds[1]){
                        foreach ($imageIds[1] as $key => $value) {
                            $logofooter['link'][] = $value;
                        }
                    }else{
                        $logofooter['link'] = '';
                    }
                }
            }
            $view->with(compact('menus','form','logofooter','footerlogo','imagelogofooter','segment','projects'));
        });
        View::composer(['amp.footer_menu'], function($view) {
            $menus = Menu::where([['position','=','footer'],['active','=','1'],])->orderBy('created_at', 'desc')->firstOrFail()->pluck('data')->toArray();
            $form = Form::where('slug','form-1')->first();
            $menus = json_decode($menus[1], true);
            $footerlogo = Setting::where('name','logofooter')->first();
            $imagelogofooter = '';
            if($footerlogo){
                $imagelogofooter =  Resource::where('id',$footerlogo->resource_id)->first();
            }
            
            $setting = Setting::where('name','basic')->first();
            $logofooter = [];
            if($setting){
                $imageIds = unserialize($setting->value);
                // var_dump($imageIds);die;    
                if(is_array($imageIds)){
                    foreach ($imageIds[0] as $key => $value) {
                        $image = Resource::where('id',$value)->first();
                        if($image){
                             $logofooter['url'][] = $image->name;
                        }else{
                            $logofooter['url'][] = '';
                        }
                       
                    }
                    if($imageIds[1]){
                        foreach ($imageIds[1] as $key => $value) {
                            $logofooter['link'][] = $value;
                        }
                    }else{
                        $logofooter['link'] = '';
                    }
                }
            }
            $view->with(compact('menus','form','logofooter','footerlogo','imagelogofooter'));
        });

        //form tu database
        View::composer(['partials.footer_form'], function($view) {
            $form = Form::where('slug','form-1')->first();
            $view->with(compact('form'));
        });


        //form tu database
        View::composer(['partials.footer_form2'], function($view) {
            $form = Form::where('slug','form-3')->first();
            $view->with(compact('form'));
        });

        //form tu database
        View::composer(['partials.formRegistry'], function($view) {
            $form = Form::where('slug','form-register')->first();
            $view->with(compact('form'));
        });

        //amp form
        View::composer(['partials.amp.footer_form2'], function($view) {
            $form = Form::where('slug','form-3')->first();
            $view->with(compact('form'));
        });
        View::composer(['partials.amp.formRegistry'], function($view) {
            $form = Form::where('slug','form-register')->first();
            $view->with(compact('form'));
        });
        View::composer(['partials.amp.footer_form'], function($view) {
            $form = Form::where('slug','form-1')->first();
            $view->with(compact('form'));
        });

        Collection::macro('paginate', function( $perPage, $total = null, $page = null, $pageName = 'page' ) {
          $page = $page ?: LengthAwarePaginator::resolveCurrentPage( $pageName );
              
          return new LengthAwarePaginator( $this->forPage( $page, $perPage ), $total ?: $this->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => $pageName,
          ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
