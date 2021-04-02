<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class General extends Model
{
    use MultiLanguage;

    public static function boot() {
        parent::boot();

        static::creating(function($model) {
            $model->user_id = auth()->check() ? auth()->user()->id : NULL;
        });
    }

     /**
     * Scope a query to only include active users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query) {
        if (!auth()->check()) return $query->where('active', true);
        return $query;
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function resource() {
        return $this->belongsTo('App\Resource');
    }

    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function getUpdatedAtAttribute($date) {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function getIsDraftHtmlAttribute() {
        if ($this->active === false) return '<i class="mdi-toggle-check-box green-text"></i>';
        return '';
    }

    public function getIsStickyHtmlAttribute() {
        if ($this->sticky === true) return '<i class="mdi-toggle-check-box green-text"></i>';
        return '';
    }

    public function getImageAttribute() {
        if ($this->resource_id === NULL) return '/images/logo-no-image.png';
        return $this->resource->thumbnail;
    }

    public function getImage($size = 'thumbnail') {
        if ($this->resource_id === NULL) return '/images/logo-no-image.png';
        return $this->resource->{$size};
    }
    public function getFeature($size = 'thumbnail') {
        if ($this->feature === NULL) return '/images/logo-no-image.png';
        return $this->resource->{$size};
    }
    public function getLogo($size = 'thumbnail') {
        if ($this->resource_id === NULL) return '/images/logo.png';
        return $this->resource->{$size};
    }
    public function getSlug(){
        $slug = $this->slug;
        if($this->slug == ''){
            LaravelLocalization::setLocale('vn');
            $slug = $this->slug;
            LaravelLocalization::setLocale('en'); 
        }
        return $slug;
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

    public function getLinkUrl(){
      $module = $this->module()->first();
      return $module->slug;
    }
    public function getLinkUrl1(){
      $category = $this->category()->first();
      if($category){
        return $category->slug;
      }else{
        return '';
      }
      
    }
}
