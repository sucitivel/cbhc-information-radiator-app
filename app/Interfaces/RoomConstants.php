<?php
namespace App\Interfaces;

interface RoomConstants
{
    const ROOMS = [
        1 => [
            'room_id' => 2,
            'csv_col' => 2,
            'room_label' => 'Veg Room',
            'db_col'  => 'celcius'
        ],
        2 => [
            'room_id' => 2,
            'csv_col' => 3,
            'room_label' => 'Veg Room',
            'db_col'  => 'rh'
        ],
        3 => [
            'room_id' => 3,
            'csv_col' => 5,
            'room_label' => 'Rooms 2 & 3',
            'db_col'  => 'celcius'
        ],
        4 => [
            'room_id' => 3,
            'csv_col' => 4,
            'room_label' => 'Rooms 2 & 3',
            'db_col'  => 'rh'
        ],
        5 => [
            'room_id' => 4,
            'csv_col' => 6,
            'room_label' => 'Rooms 7 & 8',
            'db_col'  => 'celcius'
        ],
        6 => [
            'room_id' => 4,
            'csv_col' => 7,
            'room_label' => 'Rooms 7 & 8',
            'db_col'  => 'rh'
        ],
        7 => [
            'room_id' => 5,
            'csv_col' => 8,
            'room_label' => 'Rooms 5 & 6',
            'db_col'  => 'celcius'
        ],
        8 => [
            'room_id' => 5,
            'csv_col' => 9,
            'room_label' => 'Rooms 5 & 6',
            'db_col'  => 'rh'
        ],
    ];
}
