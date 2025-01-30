<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiKey extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'api_key',
    ];

    // Make sure the API key is automatically hidden for security purposes
    protected $hidden = [
        'api_key',
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
