<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Module extends General
{
    //cid ->id thu 2
    //parent_id danh muc cha

    protected $table = 'tbl_modules';

    protected $fillable = ['name','parent_id', 'alias_vn','cid', 'alias_en', 'desc_vn', 'desc_en', 'meta_title_vn','meta_title_en', 'meta_desc_vn', 'meta_desc_en','meta_keyword_vn','meta_keyword_en','image','display','ordering','title','slug','meta_title','meta_desc','meta_keyword','active','sticky','client','canonical'];

    protected $casts = ['display' => 'boolean', 'active' => 'boolean', 'sticky' => 'boolean'];
    protected $multilingual = ['title','slug','meta_title','meta_desc','meta_keyword','canonical'];

    protected $hidden = ['pivot'];

    public function posts() {
    	return $this->hasMany('App\Post','cid')->orderBy('tbl_contents.cid', 'desc');
    }
    public function categories() {
        return $this->hasMany('App\Category','cid')->orderBy('tbl_categories.cid', 'desc');
    }
    public function parent()
    {
        return $this->belongsTo('Module', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Module', 'parent_id');
    }

    public function getimageThumb(){
        $url = '';
        $res = Resource::where('id',$this->resource_id)->first();
        if($res != NULL){
            $url = '/uploads/thumbnail/module/'.$res->name;
        }
        return $url;
    }

}



