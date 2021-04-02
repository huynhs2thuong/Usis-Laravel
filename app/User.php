<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Cache;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot() {
        parent::boot();

        static::saved(function($model) {
            Cache::forget("user_{$model->id}.userById");
            Cache::forget("user_{$model->id}.userByIdAndToken");
        });

        static::deleted(function($model) {
            Cache::forget("user_{$model->id}.userById");
            Cache::forget("user_{$model->id}.userByIdAndToken");
        });
    }

    public function getIsAdminAttribute() {
        return $this->level == 'admin';
    }

    public function getCreatedAtAttribute($date) {
        if (!empty($date)) return Carbon::parse($date)->format('d/m/Y');
        else return '';
    }
    public function get_role(){
        return $this->level;
    }
}
