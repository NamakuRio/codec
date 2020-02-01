<?php

namespace App\Models;

use App\Traits\UserRelation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, UserRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'phone', 'photo_url', 'activation_token', 'phone_verification_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeMyPhoto()
    {
        return ($this->photo_url == null ? asset('images/user/default.jpg') : asset($this->photo_url));
    }

    /**
     *
     * Status, Activation, PhoneVerification
     *
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->save();

        return $this;
    }

    public function setActivation($activation)
    {
        $this->activation = $activation;
        $this->save();

        return $this;
    }

    public function setPhoneVerification($phone_verification)
    {
        $this->phone_verification = $phone_verification;
        $this->save();

        return $this;
    }
}
