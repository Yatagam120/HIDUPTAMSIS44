<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'rating',
        'komentar',
        'media_paths',
    ];

    protected $casts = [
        'media_paths' => 'array',
        'rating'      => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}