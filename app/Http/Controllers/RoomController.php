<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {

    }

    public function show(Room $room)
    {
        return view('room', [
            'room' => $room,
        ]);
    }
}
