<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends General
{
    protected $fillable = ['title', 'address', 'district_id', 'business_hours', 'phone', 'lat', 'lng', 'resource_id'];

    protected $multilingual = ['title', 'address', 'business_hours'];

    public function district() {
        return $this->belongsTo('App\District');
    }

    public function getSlugAttribute() {
        return str_slug($this->title);
    }

    public function getLatAttribute($value) {
        return empty($value) ? '10.7883447' : $value;
    }
    public function getLngAttribute($value) {
        return empty($value) ? '106.6955799' : $value;
    }
}
