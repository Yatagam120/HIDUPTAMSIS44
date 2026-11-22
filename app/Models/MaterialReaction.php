<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialReaction extends Model
{
    protected $fillable = ['material_id', 'user_id', 'emote'];
}