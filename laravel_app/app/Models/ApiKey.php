<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = [
        'user_id',
        'api_key',
    ];

    // Make sure the API key is automatically hidden for security purposes
    protected $hidden = [
        'api_key',
    ];
}
