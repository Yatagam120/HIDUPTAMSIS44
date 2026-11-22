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
        if (!empty($value)) {
            return $value;
        }

        foreach (['kode', 'code', 'singkatan', 'short_name'] as $col) {
            if (!empty($this->attributes[$col])) {
                return $this->attributes[$col];
            }
        }

        return $this->attributes['nama'] ?? ($this->attributes['name'] ?? 'MAPEL');
    }

    public function getNamaMapelAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        foreach (['nama', 'name', 'judul', 'title'] as $col) {
            if (!empty($this->attributes[$col])) {
                return $this->attributes[$col];
            }
        }

        return '-';
    }
}