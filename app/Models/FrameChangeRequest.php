<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrameChangeRequest extends Model
{
    protected $fillable = [
        'user_id',
        'student_name',
        'frame_path',
        'status',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}