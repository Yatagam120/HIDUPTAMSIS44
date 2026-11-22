<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
protected $fillable = [
        'nama',
        'jabatan',
        'umur',
        'tanggal_lahir',
        'hobi',
        'skill',
        'foto',
    ];
}