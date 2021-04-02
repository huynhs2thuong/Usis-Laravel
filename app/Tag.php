<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends General
{

    protected $fillable = ['name','slug'];

    protected $casts = ['display' => 'boolean', 'block' => 'boolean','active' => 'boolean', 'sticky' => 'boolean'];
    protected $multilingual = [''];

    // protected $hidden = ['pivot'];

    // public function posts() {
    // 	return $this->hasMany('App\Post','cat_id','id')->orderBy('ordering','desc')->orderBy('tbl_contents.created_at', 'desc');
    // }
   
    // public function module() {
    //     return $this->belongsTo('App\Module','cid','cid')->select(['tbl_modules.id','tbl_modules.title'])->orderBy('tbl_modules.id', 'desc');
    // }

    // public function parent()
    // {
    //     return $this->belongsTo('Category', 'parent_id');
    // }

    // public function children()
    // {
    //     return $this->hasMany('Category', 'parent_id');
    // }

}



