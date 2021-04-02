<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	use MultiLanguage;

    public $timestamps = false;

    protected $fillable = ['code' ,'title', 'delivery'];

    protected $multilingual = ['title'];

    protected $casts = ['delivery' => 'bool'];

    public static function boot() {
        parent::boot();

        static::saved(function($model) {
          	Cache::forget('cities');
        });

        static::deleted(function($model) {
          	Cache::forget('cities');
        });
    }

    public function districts() {
        return $this->hasMany('App\District');
    }

    public function stores() {
        return $this->hasManyThrough('App\Store', 'App\District');
    }

    public function getIsDeliveryHtmlAttribute() {
        if ($this->delivery === true) return '<i class="mdi-toggle-check-box green-text"></i>';
        return '';
    }
}
