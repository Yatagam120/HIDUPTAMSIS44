<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostReaction extends Model
{
    protected $fillable = [
        'subject_post_id',
        'user_id',
        'emoji',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}