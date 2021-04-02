<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends General
{
    //cid -> module id
    //parent_id -> danh mục cha
    protected $table = 'tbl_categories';

    protected $fillable = ['name_vn', 'alias_vn','cid', 'cat_id', 'name_en' , 'alias_en', 'desc_vn', 'desc_en', 'meta_title_vn','meta_title_en', 'meta_desc_vn', 'meta_desc_en','meta_keyword_vn','meta_keyword_en','image','block','display','ordering','title','slug','description','type','meta_title','meta_desc','meta_keyword','active','sticky','canonical'];

    protected $casts = ['display' => 'boolean', 'block' => 'boolean','active' => 'boolean', 'sticky' => 'boolean'];
    protected $multilingual = ['title','slug','description','meta_title','meta_desc','meta_keyword','canonical'];

    protected $hidden = ['pivot'];

    public function posts() {
    	return $this->hasMany('App\Post','cat_id','id')->orderBy('ordering','desc')->orderBy('tbl_contents.created_at', 'desc');
    }
   
    public function module() {
        return $this->belongsTo('App\Module','cid','cid')->select(['tbl_modules.id','tbl_modules.title'])->orderBy('tbl_modules.id', 'desc');
    }

    public function parent()
    {
        return $this->belongsTo('Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Category', 'parent_id');
    }

}



