<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RoomCategory;
use App\Http\Requests\RoomCategory\RoomCategorySaveRequest;
use App\Http\Requests\RoomCategory\RoomCategoryUpdateRequest;
use App\SSP;

class RoomCategoriesController extends Controller
{
    
    public function roomCategoryAdd(Request $request)
    {   
        $bedList = numberOfBeds();
        return view('room_categories.room_category_add')->with('bedList', $bedList);
    }

    public function roomCategorySave(RoomCategorySaveRequest $request)
    {
        $roomCategory = new RoomCategory();
        $roomCategory->category = $request->category;
        $roomCategory->size = $request->size;
        $roomCategory->people_adult = $request->people_adult;
        $roomCategory->people_child = $request->people_child;
        $roomCategory->bed = $request->bed;
        $roomCategory->price = $request->price;
        $roomCategory->description = $request->description;
        $roomCategory->package = $request->package;
        $roomCategory->facilities = $request->facilities;
        $roomCategory->check_in = $request->check_in;
        $roomCategory->check_out = $request->check_out;
        $roomCategory->check_in_instruction = $request->check_in_instruction;
        $roomCategory->cancellation_policy = $request->cancellation_policy;
        $roomCategory->created_by = Auth::user()->id;
        $success = $roomCategory->save();

        if($success){
            return redirect('admin/room-category')->with('success', "Successfully Saved");
        }
        else{
            return redirect()->back()->with('error', "Couldn't save!")->withInput();
        }
    }

    public function roomCategoryList(Request $request)
    {
        return view('room_categories.room_category_list');
    }

    public function getAllroomCategories(Request $request){
        $table = "(SELECT * FROM room_categories) testtable";

        $primaryKey = 'id';
        $columns = array(

            array( 'db' => 'id', 'dt' => 'id' ),

            array( 'db' => 'category', 'dt' => 'category' ),

            array( 'db' => 'size', 'dt' => 'size' ),

            array( 'db' => 'people_adult', 'dt' => 'people_adult' ),

            array( 'db' => 'people_child', 'dt' => 'people_child' ),

            array( 'db' => 'bed', 'dt' => 'bed' ),

            array( 'db' => 'check_in', 'dt' => 'check_in' ),

            array( 'db' => 'check_out', 'dt' => 'check_out' )
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


    public function roomCategoryEdit(Request $request, $id){
        $roomCategory = RoomCategory::where('id',$id)->first();
        $bedList = numberOfBeds();
        return view('room_categories.room_category_edit')->with('roomCategory', $roomCategory)->with('bedList', $bedList);
    }


    public function roomCategoryUpdate(RoomCategoryUpdateRequest $request, $id){
        $roomCategory = RoomCategory::find($id);
        $roomCategory->category = $request->category;
        $roomCategory->size = $request->size;
        $roomCategory->people_adult = $request->people_adult;
        $roomCategory->people_child = $request->people_child;
        $roomCategory->price = $request->price;
        $roomCategory->bed = $request->bed;
        $roomCategory->description = $request->description;
        $roomCategory->package = $request->package;
        $roomCategory->facilities = $request->facilities;
        $roomCategory->check_in = $request->check_in;
        $roomCategory->check_out = $request->check_out;
        $roomCategory->check_in_instruction = $request->check_in_instruction;
        $roomCategory->cancellation_policy = $request->cancellation_policy;
        $success = $roomCategory->save();

        if($success){
            return redirect('admin/room-category')->with('success', "Successfully Updated");
        }
        else{
            return redirect()->back()->with('error', "Couldn't Update!")->withInput();
        }
    }


    public function RoomCategoryView(Request $request, $id){
        $roomCategory = RoomCategory::where('id',$id)->first();
        return view('room_categories.room_category_view')->with('roomCategory', $roomCategory);
    }
}
