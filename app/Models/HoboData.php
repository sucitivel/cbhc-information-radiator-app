<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoboData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function room()
    {
        return $this->belongsTo(\App\Models\Room::class);
    }

}
