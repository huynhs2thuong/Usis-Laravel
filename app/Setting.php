<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends General
{

    protected $table = 'settings';

    protected $fillable = ['name','value','resource_id','user_id','created_at', 'updated_at'];

    protected $casts = [];
    protected $multilingual = [];

}
