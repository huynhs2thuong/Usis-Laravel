<?php

namespace App\Providers;

use App\Dish;
use App\Group;
use App\Page;
use App\Category;
use App\Project;
use Cache;
use File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use LaravelLocalization;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('current_locale', LaravelLocalization::getCurrentLocale());

        View::composer(['layouts.app', 'site.*'], function($view) {
            $data['currentUser'] = auth()->guard('customer')->user();
            if (!\App::runningInConsole()) {
                $data['bodyClass'] = \Route::currentRouteName() !== NULL
                    ? \Route::currentRouteName()
                    : strtolower(str_replace('Controller@', '-', array_last(explode('\\', \Route::currentRouteAction()))));
            }
            $view->with($data);
        });

        View::composer(['site.order.dishes', 'site.order.mobile'], function($view) {
            $data['side_groups'] = Cache::remember('groups.side', 1440, function() {
                return Group::with(['dishes' => function($query) {
                    $query->whereNull('dishes.dish_id')->with('resource', 'child');
                }])->where('is_side', true)->get()->keyBy('id')->all();
            });
            $view->with($data);
        });

        View::composer(['admin.dish.create', 'admin.dish.edit'], function ($view) {
            $data['dishes'] = Dish::where('type', Dish::TYPE_SIDE)->whereNull('dish_id')->orderBy('id', 'desc')->get()->pluck('title', 'id')->all();
            list($data['groups'], $data['side_groups']) = Group::splitGroups();
            $view->with($data);
        });
      
        View::composer('admin.page.form', function ($view) {
            $data['pages'] = Page::orderBy('id', 'desc')->get()->pluck('title', 'id')->all();
            array_unshift($data['pages'] ,'None');
             //$data['id_pro'] = Page::orderBy('id', 'desc')->get()->pluck('id_pro', 'id')->all();
            $data['id_pro'] = array('Chương Trình');
            array_unshift($data['id_pro'],'None');
           // var_dump($data);die;


           $data['categories']  = Category::orderBy('id','desc')->where('cid',76)->get(['title','id'])->pluck('id','title')->all();
           //array_unshift($data['categories'],'None');
          //var_dump($data['categories']);die;
           
            $carry = array('None');
            $data['templates'] = array_reduce(File::files(resource_path('views/site/page')), function($carry, $item) {
                $name = str_replace('.blade.php', '', basename($item));
                $carry[$name] = ucfirst($name);
                return $carry;
            });
            array_unshift($data['templates'],'None');
            $view->with($data);
        });
        View::composer('admin.project.form', function ($view) {
            $data['render'] = Project::orderBy('id', 'desc')->get()->pluck('render', 'id')->all();

            $data['render'] = array('DỰ ÁN ĐANG KÊU GỌI','DỰ ÁN ĐÃ HẾT SUẤT');
            $data['hot_news'] = array('Nổi bật');
            array_unshift($data['hot_news'],'None');
           // var_dump($data);die;
            $view->with($data);
        });
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
