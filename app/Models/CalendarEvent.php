<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'kategori',
        'judul',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}