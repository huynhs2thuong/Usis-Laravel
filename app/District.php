<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache;

class District extends Model
{
	use MultiLanguage;

    public $timestamps = false;

    protected $fillable = ['city_id', 'code', 'title', 'min_price', 'delivery'];

    protected $multilingual = ['title'];

    protected $casts = ['min_price' => 'integer', 'delivery' => 'bool'];

    public static function boot() {
        parent::boot();

        static::saved(function($model) {
          	Cache::forget('districts');
        });

        static::deleted(function($model) {
          	Cache::forget('districts');
        });
    }

    public function city() {
        return $this->belongsTo('App\City');
    }

    public function stores() {
        return $this->hasMany('App\Store');
    }

    public function getIsDeliveryHtmlAttribute() {
        if ($this->delivery === true) return '<i class="mdi-toggle-check-box green-text"></i>';
        return '';
    }
}
