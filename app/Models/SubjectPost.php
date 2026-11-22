<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectPost extends Model
{
    protected $fillable = [
        'subject_id',
        'user_id',
        'kategori',
        'judul',
        'deskripsi',
        'tanggal_deadline',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function attachments()
    {
        return $this->hasMany(PostAttachment::class);
    }

    public function reactions()
    {
        return $this->hasMany(PostReaction::class);
    }
}