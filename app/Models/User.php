<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'type',
        'verification_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function markEmailAsVerified()
    {
        if (!$this->hasVerifiedEmail()) {
            $this->forceFill([
                'email_verified_at' => $this->freshTimestamp(),
            ])->save();

            event(new Verified($this));
        }
    }

    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }
}
