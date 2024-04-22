<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RoomCategory;
use App\Models\RoomCategoryRent;
use App\Models\FileModel;
use App\Http\Requests\RoomCategory\RoomCategorySaveRequest;
use App\Http\Requests\RoomCategory\RoomCategoryUpdateRequest;
use App\Http\Requests\RoomCategoryRent\RoomCategoryRentSaveRequest;
use App\Http\Requests\RoomCategoryRent\RoomCategoryRentUpdateRequest;
use App\SSP;
use DateTime;
use DatePeriod;
use DateInterval;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use App\Service\MenuService;
use Illuminate\Support\Facades\DB;


class RoomCategoriesController extends Controller
{
    public function roomCategoryAdd(Request $request)
    {   
        $request->session()->increment('count');
        $bedList = numberOfBeds();
        return view('room_categories.room_category_add')->with('bedList', $bedList);
    }

    public function roomCategorySave(RoomCategorySaveRequest $request)
    {   

        try {
            DB::beginTransaction();
            $files[] = [];
            $this->menuService = new MenuService();

            $roomCategory = new RoomCategory();
            $roomCategory->category = $request->category;
            $roomCategory->size = $request->size;
            $roomCategory->people_adult = $request->people_adult;
            $roomCategory->people_child = $request->people_child;
            $roomCategory->bed = $request->bed;
            $roomCategory->price = $request->price;
            $roomCategory->discount = $request->discount;
            $roomCategory->description = $request->description;
            $roomCategory->package = $request->package;
            $roomCategory->facilities = $request->facilities;
            $roomCategory->check_in = $request->check_in;
            $roomCategory->check_out = $request->check_out;
            $roomCategory->check_in_instruction = $request->check_in_instruction;
            $roomCategory->cancellation_policy = $request->cancellation_policy;
            $roomCategory->created_by = Auth::user()->id;
            $roomCategory->save();

            $room_category_id = $roomCategory->id;
            $thumb_image_url = 'images/room-category/'.$request->category.'/';
            $thumb_filename = $request->category.'_thumb';

            $this->menuService->imageUpload($request->thumb_image, $thumb_image_url, $thumb_filename, 800, 'webp', 70);

            // dd($request->thumb_image);
            $files[0]['element_id'] = $room_category_id;
            $files[0]['type'] = 'room-category-thumb';
            $files[0]['path'] = $thumb_image_url;
            $files[0]['filename'] = $thumb_filename.'.webp';
            $files[0]['last_modified_by'] = Auth::user()->id;
            $files[0]['created_at'] = date("Y-m-d H:i:s");

            $i = 1;
            foreach($request->other_image as $image){
                $other_image_url = 'images/room-category/'.$request->category.'/';
                $other_image_filename = $request->category.'_other_image_'.$i;
                $this->menuService->imageUpload($image, $other_image_url, $other_image_filename, 800, 'webp', 70);

                $files[$i]['element_id'] = $room_category_id;
                $files[$i]['type'] = 'room-category-other-image';
                $files[$i]['path'] = $other_image_url;
                $files[$i]['filename'] = $other_image_filename.'.webp';
                $files[$i]['last_modified_by'] = Auth::user()->id;
                $files[$i]['created_at'] = date("Y-m-d H:i:s");

                $i++;
            }
// dd($files);
            FileModel::insert($files);
            DB::commit(); 
            return redirect('admin/room-category')->with('success', "Successfully Saved");
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
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

        $this->menuService = new MenuService();
        $type = ['room-category-thumb', 'room-category-other-image'];
        $images = $this->menuService->getImages($id, $type);
        return view('room_categories.room_category_edit')->with('roomCategory', $roomCategory)->with('bedList', $bedList)->with('images', $images);
    }

    public function roomCategoryUpdate(RoomCategoryUpdateRequest $request, $id)
    {   

        try {
            DB::beginTransaction();
            $files[] = [];
            $this->menuService = new MenuService();

            $roomCategory = RoomCategory::find($id);
            $roomCategory->category = $request->category;
            $roomCategory->size = $request->size;
            $roomCategory->people_adult = $request->people_adult;
            $roomCategory->people_child = $request->people_child;
            $roomCategory->bed = $request->bed;
            $roomCategory->price = $request->price;
            $roomCategory->discount = $request->discount;
            $roomCategory->description = $request->description;
            $roomCategory->package = $request->package;
            $roomCategory->facilities = $request->facilities;
            $roomCategory->check_in = $request->check_in;
            $roomCategory->check_out = $request->check_out;
            $roomCategory->check_in_instruction = $request->check_in_instruction;
            $roomCategory->cancellation_policy = $request->cancellation_policy;
            $roomCategory->created_by = Auth::user()->id;
            $roomCategory->save();
            
            if(null !== $request->thumb_image){
                $room_category_id = $roomCategory->id;
                $thumb_image_url = 'images/room-category/'.$request->category.'/';
                $thumb_filename = $request->category.'_thumb';

                $this->menuService->imageUpload($request->thumb_image, $thumb_image_url, $thumb_filename, 800, 'webp', 70);
                $thumb_image = ['element_id'=>$id, 'path'=>$thumb_image_url, 'filename'=>$thumb_filename.'.webp', 'last_modified_by'=>Auth::user()->id, 'created_at'=>date("Y-m-d H:i:s")];
                FileModel::where('element_id', $id)->where('type','room-category-thumb')->update($thumb_image);
            }
            

            FileModel::where('element_id', $id)->where('type','room-category-other-image')->delete();
            array_map('unlink', glob(public_path().'/images/room-category/'.$request->category.'/'.$request->category.'_other_image_*'));
            $i = 0;
            
            foreach($request->other_image as $image){
                $other_image_url = 'images/room-category/'.$request->category.'/';
                $other_image_filename = $request->category.'_other_image_'.$i+1;
                $this->menuService->imageUpload($image, $other_image_url, $other_image_filename, 800, 'webp', 70);

                $files[$i]['element_id'] = $id;
                $files[$i]['type'] = 'room-category-other-image';
                $files[$i]['path'] = $other_image_url;
                $files[$i]['filename'] = $other_image_filename.'.webp';
                $files[$i]['last_modified_by'] = Auth::user()->id;
                $files[$i]['created_at'] = date("Y-m-d H:i:s");

                $i++;
            }
            // dd($files);
            FileModel::insert($files);
            DB::commit(); 
            return redirect('admin/room-category')->with('success', "Successfully updated");
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->with('error', "Couldn't save!")->withInput();
        }
    }

    public function RoomCategoryView(Request $request, $id){
        $roomCategory = RoomCategory::join('files', 'room_categories.id', 'files.element_id')->where('room_categories.id',$id)->where('element_id',$id)
                                        ->where(function ($query) {
                                            $query->where('type', '=', 'room-category-thumb')
                                                  ->orWhere('type', '=', 'room-category-other-image');
                                        })->get();
        
        $roomCategory = RoomCategory::where('id',$id)->first();
        $this->menuService = new MenuService();
        $type = ['room-category-thumb', 'room-category-other-image'];
        $images = $this->menuService->getImages($id, $type);

        return view('room_categories.room_category_view')->with('roomCategory', $roomCategory)->with('images', $images);
    }


    public function roomCategoryRentAdd(Request $request){
        $room_categories = RoomCategory::all();
        return view('room_categories_rent.room_category_rent_add')->with('room_categories', $room_categories);
    }


    public function roomCategoryRentSave(RoomCategoryRentSaveRequest $request)
    {
        $rents[] = [];
        $i = 0;

        $begin = new DateTime(date("Y-m-d", strtotime($request->from_date)));
        $end = new DateTime(date("Y-m-d", strtotime($request->to_date)));
        $end = $end->modify('+1 day'); 

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);

        foreach($daterange as $date){
            $rents[$i]['room_category_id'] = $request->room_category_id;
            $rents[$i]['rent_date'] = $date->format("Y-m-d");
            $rents[$i]['price'] = $request->price;
            $rents[$i]['discount'] = $request->discount;
            $rents[$i]['created_by'] = Auth::user()->id;
            $rents[$i]['created_at'] = date('Y-m-d H:i:s');
            $i++;
        }
        $duplicateRent = $this->checkDuplicateRent($request->room_category_id, array_column($rents, 'rent_date'));
        if(count($duplicateRent) > 0){
            $j = 0;
            $errorMessage = 'Rent for ';
            foreach($duplicateRent as $rent){
                if($j > 0){
                    $errorMessage .=", "; 
                }
                $errorMessage .= date('d M Y', strtotime($rent->rent_date));
                $j++;
            }
            $errorMessage .= ' already exists';
            return redirect()->back()->with('error', $errorMessage)->withInput();
        }

        RoomCategoryRent::insert($rents);
        return redirect('admin/room-category-rent')->with('success', "Successfully Saved");
    }


    public function checkDuplicateRent($room_category_id, $dates){
        $rents = RoomCategoryRent::where('room_category_id', $room_category_id)->whereIn('rent_date', $dates)->get();
        return $rents;
    }



    public function roomCategoryRentList(Request $request)
    {
        return view('room_categories_rent.room_category_rent_list');
    }

    public function getAllroomCategoriesRent(Request $request){
        $table = "(SELECT room_categories_rent.id, room_categories_rent.room_category_id, room_categories_rent.rent_date, room_categories_rent.price, room_categories_rent.discount, room_categories.category FROM room_categories_rent inner join room_categories on room_categories_rent.room_category_id = room_categories.id) testtable";

        $primaryKey = 'id';
        $columns = array(

            array( 'db' => 'id', 'dt' => 'id' ),

            array( 'db' => 'category', 'dt' => 'category' ),

            array(

                'db'        => 'rent_date',

                'dt'        => 'rent_date',

                'formatter' => function( $d, $row ) {
                    if($d) return date( 'd F, Y', strtotime($d));
                }
            ),

            array( 'db' => 'price', 'dt' => 'price' ),

            array( 'db' => 'discount', 'dt' => 'discount' )
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

    public function roomCategoryRentEdit(Request $request, $id){
        $rent = RoomCategoryRent::select('room_categories_rent.*', 'room_categories.category')->join('room_categories', 'room_categories_rent.room_category_id', 'room_categories.id')->where('room_categories_rent.id',$id)->first();
        return view('room_categories_rent.room_category_rent_edit')->with('rent', $rent);
    }


    public function roomCategoryRentUpdate(RoomCategoryRentUpdateRequest $request, $id){
        $rent = RoomCategoryRent::find($id);
        $rent->price = $request->price;
        $rent->discount = $request->discount;
        $success = $rent->save();

        if($success){
            return redirect('admin/room-category-rent')->with('success', "Successfully Updated");
        }
        else{
            return redirect()->back()->with('error', "Couldn't Update!")->withInput();
        }
    }


    public function roomCategoryRentDelete(Request $request){
        $success = RoomCategoryRent::where('id', $request->id)->delete();
        return $success;
    }
}
