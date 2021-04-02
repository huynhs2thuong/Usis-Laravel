<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
// use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use App\Category;
use DB;

// class Post extends General implements HasMedia
class Post extends General
{
    // use HasMediaTrait;
    //cid -> id module
    //cat_id -> id category
    //desc_vn -> type
    
	const STATUS_PUBLIC  = 0;
	const STATUS_PRIVATE = 1;
	const STATUS_HIDDEN  = 2;

    protected $table = 'tbl_contents';

    protected $fillable = ['title','slug','excerpt','description','title_vn', 'alias_vn','cid', 'cat_id', 'title_en' , 'alias_en', 'desc_vn', 'desc_en', 'meta_title_vn','meta_title_en', 'meta_desc_vn', 'meta_desc_en','meta_keyword_vn','meta_keyword_en','image','content_image','block','display','ordering','focus', 'is_new','created','modified','published','meta','meta_title','meta_desc','meta_keyword','active','sticky','file_vn','file_en','resource_id','video_url','created_at','service_display','content_vn','content_en','canonical'];

    protected $casts = ['display' => 'boolean', 'block' => 'boolean','active' => 'boolean', 'sticky' => 'boolean'];
    protected $multilingual = ['title','slug','excerpt','description','meta','meta_title','meta_desc','meta_keyword','canonical'];
    protected $hidden = ['pivot'];

    public function category() {
        return $this->belongsTo('App\Category','cat_id','id')->select(['tbl_categories.id','tbl_categories.title','tbl_categories.slug']);
    }
    public function getCat(){
        return Category::where('id',$this->cat_id);
    }
    public function module() {
        return $this->belongsTo('App\Module','cid','cid')->select(['tbl_modules.id','tbl_modules.title','tbl_modules.slug'])->orderBy('tbl_modules.id', 'desc');
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
    public function getLinkPost($slug){
      if($slug == 'tin-tuc' || $slug == 'news'){
      $link = action('SiteController@news',['slug'=>$this->slug]);
    }elseif($slug == 'du-an' || $slug == 'eb-5-projects'){
      $link = action('SiteController@projectDetail',['slug'=>$this->slug]);
    }elseif($slug == 'hoat-dong'){
      $link = action('SiteController@hdAncuChitiet',$this->slug);
    }elseif($slug == 'su-kien' || $slug == 'events'){
      $link = action('SiteController@events',['slug'=>$this->slug]);
    }elseif($slug == 'cuoc-song-tai-my' || $slug == 'life-in-america'){
      $link = action('SiteController@life',['slug'=>$this->slug]);
    }elseif($slug == 'luat-di-tru' || $slug == 'immigration-law'){
      $link = action('SiteController@laws',['slug'=>$this->slug]);
    }elseif($slug == 'cam-nhan-khach-hang' || $slug == 'testimonials'){
      $link = action('SiteController@customerDetail',['slug'=>$this->slug]);
    }elseif($slug == 'dich-vu' || $slug == 'huong-dan-dinh-cu-hoa-ky'){
      $link = action('SiteController@hddcDetail',['slug'=>$this->slug]);
    }elseif($slug == 'doi-tac'){
      $link = action('SiteController@doitacDetail',$this->slug);
    }elseif($slug == 'huong-dan'){
      $link = action('SiteController@hddcDetail',['slug'=>$this->slug]); 
    }else{
      $link ='/';
    }
    return $link;
    }
}
