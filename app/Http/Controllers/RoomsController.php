<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\SSP;
use App\Models\Rooms;
use App\Models\RoomCategory;

class RoomsController extends Controller
{
    
    public function roomAdd(Request $request)
    {   
        $room_categories = RoomCategory::all();
        return view('rooms.room_add')->with('room_categories', $room_categories);
    }


    public function roomAddSave(Request $request)
    {   
        $rooms[] = [];
        for($i = 0; $i<$request->num_room; $i++){
            $rooms[$i]['room_category_id'] = $request->room_category_id;
            $rooms[$i]['room_number'] = $request->room_numbers[$i];
            $rooms[$i]['room_status'] = 1;
            $rooms[$i]['status'] = 1;
            $rooms[$i]['housekeeping'] = 1;
            $rooms[$i]['created_by'] = Auth::user()->id;
            $rooms[$i]['created_at'] = date('Y-m-d H:i:s');
        }

        $duplicateRoom = $this->checkDuplicateRoom($request->room_numbers);
        if(count($duplicateRoom) > 0){
            $j = 0;
            $errorMessage = 'Room ';
            foreach($duplicateRoom as $room){
                if($j > 0){
                    $errorMessage .=", "; 
                }
                $errorMessage .= $room->room_number;
                $j++;
            }
            $errorMessage .= ' already exists';
            return redirect()->back()->with('error', $errorMessage)->withInput();
        }
        Rooms::insert($rooms);
        return redirect('admin/room-category')->with('success', "Successfully Saved");
    }


    public function checkDuplicateRoom($rooms = []){
        $rooms = Rooms::whereIn('room_number', $rooms)->get();
        return $rooms;
    }



    public function roomsList(Request $request)
    {   
        return view('rooms.room_list');
    }
    
    public function getAllRoomS(Request $request){
        $table = 
            "(SELECT * FROM rooms) testtable";

        $primaryKey = 'id';
        $columns = array(

            array( 'db' => 'id', 'dt' => 'id' ),

            array( 'db' => 'room_number', 'dt' => 'room_number' ),

            array( 'db' => 'room_status', 'dt' => 'room_status' ),

            array( 'db' => 'status', 'dt' => 'status' ),

            array( 'db' => 'housekeeping', 'dt' => 'housekeeping' )
        );

        $database = config('database.connections.pgsql');

        $sql_details = array(
            'user' => $database['username'],
            'pass' => $database['password'],
            'db'   => $database['database'],
            'host' => $database['host']
        );
        // dd($sql_details);
        $result =  SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns);

        $start=$_REQUEST['start']+1;

        $idx=0;

        foreach($result['data'] as &$res){

            $res[0]=(string)$start;

            $start++;

            $idx++;

        }
        echo json_encode($result);

    }
}
