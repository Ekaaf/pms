<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Rooms;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    
    public function reservation(Request $request)
    {   
        return view('pms.reservation');

    }


    public function searchRoomCategory(Request $request){
        $check_in = $request->check_in;
        $check_out = $request->check_out;
        $bookings = Booking::where('to_date', '<=', $check_in)->where('from_date', '>=', $check_out)->pluck('room_id');

        $available_rooms = Rooms::select('room_categories.*', DB::raw('COUNT(room_categories.id) as no_of_rooms'), 'files.path', 'files.filename')->join('room_categories', 'rooms.room_category_id', 'room_categories.id')
                            ->join('files', 'room_categories.id', 'files.element_id')
                            ->where('files.type', 'room-category-thumb')
                            ->whereNotIn('room_number', $bookings)
                            ->groupBy('room_categories.id', 'files.path', 'files.filename')->get();
        return response()->json($available_rooms);
    }
}
