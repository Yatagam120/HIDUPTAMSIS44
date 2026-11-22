<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['hari', 'subject_id', 'jam_mulai', 'jam_selesai'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}