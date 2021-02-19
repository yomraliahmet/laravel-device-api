<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Device extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        "uid",
        "appId",
        "language",
        "os",
    ];

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
