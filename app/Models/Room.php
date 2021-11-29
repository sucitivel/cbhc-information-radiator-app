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
        $transformedDatapoints = [
            'temperature' => [],
            'humidity' => [],
        ];
        $dataPoints = \App\Models\HoboData::where('room_id', $this->id)->get();

        foreach ($dataPoints as $dataPoint) {
            $transformedDatapoints['temperature'][] = [
                'x' => $dataPoint->time,
                'y' => $dataPoint->celcius,
            ];

            $transformedDatapoints['humidity'][] = [
                'x' => $dataPoint->time,
                'y' => $dataPoint->rh,
            ];
        }

        return $transformedDatapoints;
    }
}
