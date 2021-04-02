<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends General
{
	//type = 1 form xác nhận

    protected $fillable = ['title', 'slug','description', 'excerpt','css', 'created_at','type'];

    protected $multilingual = ['title', 'description', 'excerpt','css'];

    protected $casts = ['active' => 'boolean'];
}
