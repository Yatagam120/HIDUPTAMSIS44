<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['subject_id', 'user_id', 'kategori', 'judul', 'deskripsi', 'barang_bawaan', 'deadline', 'media'];

    protected $casts = [
        'media' => 'array',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->hasMany(MaterialReaction::class);
    }
}