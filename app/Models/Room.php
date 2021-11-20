<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function datapoints()
    {
        return $this->hasMany(\App\Models\HoboData::class);
    }

    public function getDataPointsAttribute()
    {
        $dataPoints = $this->datapoints;

        foreach ($dataPoints as $dataPoint) {
            // reform
        }
    }
}
