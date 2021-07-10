<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IptvUser extends Model
{
    use HasFactory;

    protected $table = 'iptv_users';
    protected $fillable = ['login', 'password', 'expiration', 'iptvExpiration'];
    protected $dates = ['created_at', 'updated_at', 'expiration', 'iptvExpiration'];
}
