<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostAttachment extends Model
{
    protected $fillable = [
        'subject_post_id',
        'file_path',
        'file_type',
    ];

    public function post()
    {
        return $this->belongsTo(SubjectPost::class, 'subject_post_id');
    }
}