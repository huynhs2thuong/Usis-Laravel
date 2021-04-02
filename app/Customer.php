<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jollibee\Auth\Notifications\ResetCustomerPassword as ResetPasswordNotification;

class Customer extends Authenticatable
{
	use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function socials() {
        return $this->hasMany('App\Social');
    }

    public function getAvatarAttribute($value) {
        return $value === '' ? url('/images/user-default.png') : $value;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }
}
