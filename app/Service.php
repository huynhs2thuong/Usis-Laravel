<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends General
{
	const STATUS_PUBLIC  = 0;
	const STATUS_PRIVATE = 1;
	const STATUS_HIDDEN  = 2;

    protected $fillable = ['title', 'slug', 'active', 'description'];

    protected $multilingual = ['title', 'description'];

    protected $casts = ['active' => 'boolean'];

    public function categories() {
        return $this->belongsToMany('App\Category')->orderBy('categories.id', 'desc');
    }

    public function getCategoryAttribute() {
    	return $this->categories->first();
    }
}
