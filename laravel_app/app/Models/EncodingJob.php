<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EncodingJob extends Model
{
    use HasFactory;

    protected $table = 'encoding_jobs';

    protected $fillable = [
        'user_id',
        'input',
        'storage',
        'outputs',
        'notification',
        'job_settings',
        'status',
    ];

    protected $casts = [
        'outputs' => 'array',
        'job_settings' => 'array',
    ];

    // Relationship: an encoding job belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
