<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends General
{
    const STATUS_PUBLIC  = 0;
    const STATUS_PRIVATE = 1;
    const STATUS_HIDDEN  = 2;

    protected $fillable = ['page_id','cid','cat_id','title', 'slug','slug_en','slug_vn','active','render','hot_news', 'sticky', 'description', 'excerpt','overview','progress','investor','address','lat','lng', 'resource_id', 'img_slide','invest_id','overview_id','canonical'];

    protected $multilingual = ['title', 'slug', 'description', 'excerpt','overview','progress','investor','address','canonical'];

    protected $casts = ['active' => 'boolean', 'sticky' => 'boolean', 'img_slide' => 'array'];
    protected $hidden = ['pivot'];

    public function category() {
        return $this->belongsTo('App\Category','cat_id','id')->select(['tbl_categories.id','tbl_categories.title'])->orderBy('tbl_categories.id', 'desc');
    }

    public function module() {
        return $this->belongsTo('App\Module','cid','cid')->orderBy('tbl_modules.id', 'desc');
    }

        public function getLinkPost($slug){
        if($slug == 'tin-tuc' || $slug == 'news'){
            $link = action('SiteController@newsDetail',['slug'=>$this->slug]);
        }elseif($slug == 'du-an' || $slug == 'eb-5-projects'){
            $link = action('SiteController@projectDetail',$this->slug);
        }elseif($slug == 'hoat-dong'){
            $link = action('SiteController@hdAncuChitiet',$this->slug);
        }elseif($slug == 'su-kien' || $slug == 'events'){
            $link = action('SiteController@eventsDetail',['slug'=>$this->slug]);
        }elseif($slug == 'cuoc-song-tai-my' || $slug == 'life-in-america'){
            $link = action('SiteController@lifeDetail',['slug'=>$this->slug]);
        }elseif($slug == 'luat-di-tru' || $slug == 'immigration-law'){
            $link = action('SiteController@lawsDetail',['slug'=>$this->slug]);
        }elseif($slug == 'cam-nhan-khach-hang' || $slug == 'testimonials'){
            $link = action('SiteController@customerDetail',['slug'=>$this->slug]);
        }elseif($slug == 'dich-vu' || $slug == 'huong-dan-dinh-cu-hoa-ky'){
            $link = action('SiteController@hddcDetail',['slug'=>$this->slug]);
        }elseif($slug == 'doi-tac'){
            $link = action('SiteController@doitacDetail',$this->slug);
        }else{
            $link ='/';
        }
        return $link;
    }
}
