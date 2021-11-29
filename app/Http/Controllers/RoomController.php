<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        return view('room-index', [
            'rooms' => Room::all(),
            'selectedRoom' => $request->input('room'),
        ]);
    }

    public function show(Room $room)
    {
        return view('room', [
            'room' => $room,
        ]);
    }
}
