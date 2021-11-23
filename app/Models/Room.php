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

    public function getDataPointsFormattedAttribute()
    {
        $transformedDatapoints = [
            'temperature' => [],
            'humidity' => [],
        ];
        $dataPoints = $this->datapoints();

        foreach ($dataPoints as $dataPoint) {
            $transformedDatapoints['temperature'] = [
                'x' => $dataPoint->time,
                'y' => $dataPoint->celcius,
            ];

            $transformedDatapoints['humidity'] = [
                'x' => $dataPoint->time,
                'y' => $dataPoint->rh,
            ];
        }

        return $transformedDatapoints;
    }
}
