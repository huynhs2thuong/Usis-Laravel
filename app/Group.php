<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Route;

class Group extends General
{
    protected $fillable = ['title', 'slug', 'is_side', 'col', 'change_size', 'change_col', 'description', 'resource_id'];

    protected $multilingual = ['title', 'change_size', 'change_col', 'description'];

    protected $casts = ['is_side' => 'boolean', 'col' => 'integer'];

    public static function boot() {
        parent::boot();

        static::addGlobalScope('public', function(Builder $builder) {
            if (!\App::runningInConsole() and Route::current()->getAction()['namespace'] === 'App\Http\Controllers')
                $builder->where('slug', '<>', 'extra');
        });

        static::saved(function($model) {
            Cache::forget('groups.main');
            Cache::forget('groups.side');
        });

        static::deleted(function($model) {
            Cache::forget('groups.main');
            Cache::forget('groups.side');
        });
    }

    public function dishes() {
    	return $this->belongsToMany('App\Dish')->orderBy('order', 'asc')->orderBy('dishes.id', 'desc');
    }

    public function getIsSideHtmlAttribute() {
    	if ($this->is_side === true) return '<i class="mdi-toggle-check-box green-text"></i>';
    	return '';
    }

    public static function splitGroups() {
    	$all_groups = static::orderBy('id', 'desc')->get();
        $groups = $all_groups->filter(function($value, $key) {
			return $value->is_side === false;
		})->pluck('title', 'id')->all();
		$side_groups = $all_groups->filter(function($value, $key) {
			return $value->is_side === true;
		});
		return [$groups, $side_groups];
    }
}
