<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends General
{
    protected $fillable = ['id_pro','id_cate','title', 'slug', 'active', 'template', 'excerpt', 'description', 'page_id', 'resource_id', 'gallery','banner','video_url','feature','meta_title','meta_desc','links','slug_en','slug_vn','canonical','amp_content'];

    protected $multilingual = ['title', 'slug','description', 'excerpt','meta_title','meta_desc','canonical','amp_content'];

    protected $casts = ['active' => 'boolean', 'gallery' => 'array','banner' =>'array'];

    public function parent() {
    	return $this->belongsTo('App\Page', 'page_id');
    }

    public function children() {
    	return $this->hasMany('App\Page');
    }
}
