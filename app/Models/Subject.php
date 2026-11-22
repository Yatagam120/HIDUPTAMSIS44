<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function posts()
    {
        return $this->hasMany(SubjectPost::class);
    }

    public function getKodeMapelAttribute($value)
    {
        return $value
            ?? ($this->attributes['kode']
            ?? ($this->attributes['code']
            ?? ($this->attributes['singkatan'] ?? 'MAPEL')));
    }

    public function getNamaMapelAttribute($value)
    {
        return $value
            ?? ($this->attributes['nama']
            ?? ($this->attributes['name']
            ?? ($this->attributes['judul'] ?? '-')));
    }
}