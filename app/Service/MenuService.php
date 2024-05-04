<?php

namespace App\Service;

use App\Models\Menu;
use App\Models\Role;
use App\Models\AdmissionHistory;
use App\Models\Approver;
use App\Models\Candidate;
use App\Models\CandidateReqApproval;
use App\Models\AdmissionInfo;
use App\Models\User;
use App\Models\AdmissionInfoTemp;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\CandidateDocCheckList;
use App\Models\CandidateEducation;
use App\Models\CandidateEmployment;
use App\Models\Masterconfig;
use DB;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\SSP;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use App\Models\FileModel;
use App\Models\Rooms;
use App\Models\Booking;
use App\Models\Billing;
use App\Models\BiilingOtherInfo;
use App\Models\RoomCategory;

class MenuService{

	public function menuTree($id = ""){
		$menuTree = [];
		$menus = Menu::orderBy('parent_id', 'DESC')->orderBy('serial', 'ASC')->get()->toArray();
        foreach($menus as $menu){
            if(is_null($menu['parent_id'])){
                $menuTree[$menu['id']]['parent'] = $menu;
            }
            else{
                $menuTree[$menu['parent_id']]['child'][] = $menu;
            }
        }
        return $menuTree;
	}

    public function menuTreebyAccess($id = ""){
        $roleID = Auth::user()->role_id;
        $menuTree = [];
        $menus = DB::table('menus')
                        // ->select('menus.*')->distinct()
                        // ->select('menus.*',  DB::raw('array_agg(menu_methods.method_name) as method_name'))
                        ->select('menus.*',  DB::raw("string_agg(menu_methods.path,',') as method_paths"), DB::raw("string_agg(menu_methods.method_name,',') as method_name"))
                        ->leftjoin('menu_methods','menus.id','=','menu_methods.menu_id')
                        ->leftjoin('user_access','menu_methods.id','=','user_access.menu_method_id')
                        ->groupBy('menus.id')
                        ->orderBy('parent_id', 'DESC')
                        ->orderBy('serial', 'ASC');
        if($roleID !=1){
            $menus->where(function ($query) use ($roleID) {
                $query->where('menus.active', 1)
                      ->where('user_access.role_id', $roleID);
            });
        }
        else{
            $menus->orWhere('menus.active', 1);
        }
        $menus->orWhere('menus.default', 1);
        $menus = $menus->get();
        foreach($menus as $menu){
            $menu = (array) $menu;
            if(is_null($menu['parent_id'])){
                $menuTree[$menu['id']]['parent'] = $menu;
            }
            else{
                $menuTree[$menu['parent_id']]['child'][] = $menu;
            }
        }
        return $menuTree;
    }

	public function getAllRoutes(){
		$routeCollection = \Route::getRoutes();
        $paths = [];
        foreach ($routeCollection as $value) {
            if (str_contains($value->getName(), 'Pms')) {
                $paths[$value->uri()] = $value->getName();
            }
        }
        return $paths;
	}

    public function getUserAccessTree(){
        $userAccessTree = [];
        $userAccess = DB::table('menus')
                        ->select('menus.id','menus.parent_id','menus.title', 'menus.path', 'menus.path as menu_path', 'menu_methods.type', 'menu_methods.method_name', 'menu_methods.path as menu_method_path', 'menu_methods.id as menu_method_id')
                        ->leftjoin('menu_methods','menus.id','=','menu_methods.menu_id')
                        ->where('menus.default', '!=', 1)
                        ->orderBy('parent_id', 'DESC')
                        ->orderBy('serial', 'ASC')
                        ->get();

        foreach($userAccess as $access){
            if(is_null($access->parent_id)){
                if(!array_key_exists($access->id, $userAccessTree)){
                    $userAccessTree[$access->id]['parent_id'] = $access->parent_id;
                    $userAccessTree[$access->id]['title'] = $access->title;
                    $userAccessTree[$access->id]['path'] = $access->path;
                    $userAccessTree[$access->id]['menu_path'] = $access->menu_path;
                    $userAccessTree[$access->id]['method_name'] = $access->method_name;
                    $userAccessTree[$access->id]['menu_method_path'] = $access->menu_method_path;
                    $userAccessTree[$access->id]['menu_method_id'] = $access->menu_method_id;
                }
                $menu_methods_arr['menu_method_id'] = $access->menu_method_id;
                $menu_methods_arr['method_name'] = $access->method_name;

                $userAccessTree[$access->id]['id'] = $access->id;
                $userAccessTree[$access->id]['menu_methods'][] = $menu_methods_arr;
                if($access->type ==1){
                    $userAccessTree[$access->id]['parent_id'] = $access->parent_id;
                    $userAccessTree[$access->id]['title'] = $access->title;
                    $userAccessTree[$access->id]['path'] = $access->path;
                    $userAccessTree[$access->id]['menu_path'] = $access->menu_path;
                    $userAccessTree[$access->id]['method_name'] = $access->method_name;
                    $userAccessTree[$access->id]['menu_method_path'] = $access->menu_method_path;
                    $userAccessTree[$access->id]['menu_method_id'] = $access->menu_method_id;
                }
            }
            else{
                if($access->type == 1){
                    $userAccessTree[$access->parent_id]['child'][$access->id]['parent']  = (array) $access;
                }
                $userAccessTree[$access->parent_id]['child'][$access->id]['child'][]  = (array) $access;
            }
        }

        return $userAccessTree;
    }


    public function menuMethods($roleID = "34"){
        $menuAccess = DB::table('menu_methods')
                            ->select('menus.menu_id')
                            ->join('user_access','menu_methods.id','=','user_access.menu_method_id')
                            ->where(['user_access.role_id' => $roleID])
                            ->get()->toArray();
        return $menuAccess;
    }

    public function imageUpload($file, $filePath = '', $fileName ='', $scaleWidth = 0, $format = 'webp', $quality = 70){
        // if (!is_dir($filePath)) {
        //     mkdir($filePath, 0755, true);
        // }
        // dd($file);
        if(!is_dir($filePath)){
            mkdir($filePath, 0755, true);
        }
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        // scale down to fixed width keeping ratio
        if($scaleWidth >0){
            $image->scaleDown(width: $scaleWidth);
        }

        if($fileName == ''){
            $fileName = time();
        }

        if($filePath != ''){
            $fileName = $filePath.$fileName;
        }

        if($format == 'webp'){
            $image->toWebp($quality)->save($fileName.'.webp');
        }
        else{
            $image->toJpeg($quality)->save($fileName.'.jpeg');
        }
    }


    public function getImages($id, $types){
        $images = FileModel::where('element_id',$id)->whereIn('type', $types)->get();
        $data = [];
        foreach($types as $type){
            $data[$type] = [];
        }
        foreach($images as $image){
            $data[$image->type][] = $image;
        }
        return $data;
    }

    public function checkRoomAvailability($booking_data){
        $result = [];
        $room_category_id = array_column($booking_data['booking_data'], 'room_category_id');
        $bookings = Booking::whereIn('room_category_id', $room_category_id)->where('to_date', '<=', $booking_data['check_in'])->where('from_date', '>=', $booking_data['check_out'])->pluck('room_id', 'room_category_id');

        $total_rooms = Rooms::select('room_category_id', DB::raw('COUNT(rooms.id) as no_of_rooms'))->whereIn('room_category_id', $room_category_id)->groupBy('room_category_id')->get();
        
        if(count($bookings) == 0){
            $result['success'] = 1;
            $result['bookings'] = [];
        }
        else{
            $result['success'] = 1;
            $result['bookings'] = $bookings;
        }
        return $result;
    }

    function saveUser($request){
        $user = new User();
        $user->email = $request->email;
        $user->password = randomPassword(8);
        $user->mobile = $request->mobile;
        $user->role_id = Role::where('name', 'Customer')->value('id');
        $user->verified = 0;
        $user->status = 1;
        $user->created_by = Auth::user()->id;
        $user->save();

        return $user->id;
    }


    function saveBillingInfo($request, $user_id){
        $booking_data = $request->session()->get('booking_data_temp');
        $total_price = array_sum(array_column($booking_data['booking_data'], 'room_price'));

        $billing = new Billing();
        $billing->user_id = $user_id;
        $billing->total_price = $total_price;
        $billing->total_discount = 0;
        $billing->paid_amount = 0;
        $billing->due_amount = $total_price;
        $billing->total_vat = 0;
        $billing->price_with_vat = 0;
        $billing->adjustment = 0;
        $billing->final_price = $total_price;
        $billing->created_by = Auth::user()->id;
        $billing->payment_completed = 0;

        $billing->save();

        $biilingOtherInfo = new BiilingOtherInfo();
        $biilingOtherInfo->billing_id = $billing->id;
        $biilingOtherInfo->identity = $request->identity;
        $biilingOtherInfo->identity_number = $request->identity;
        $biilingOtherInfo->expire_date = $request->expire_date;
        $biilingOtherInfo->dob = $request->dob;
        $biilingOtherInfo->nationality = $request->nationality;
        $biilingOtherInfo->created_by = Auth::user()->id;

        $biilingOtherInfo->save();

        return $billing->id;
    }


    function validateTotalPrice($booking_data){
        $room_category_id = array_column($booking_data['booking_data'], 'room_category_id');
        $total_price = 0;
        $room_categories = RoomCategory::whereIn('id', $room_category_id)->pluck('price', 'id');
        foreach($room_categories as $key=>$value){
            $total_price += $value * $booking_data['no_of_nights'] * $booking_data['booking_data'][$key]['no_of_rooms'];
        }

        $total_price_temp = array_sum(array_column($booking_data['booking_data'], 'room_price'));
        if($total_price_temp == $total_price){
            return 1;
        }
        else{
            return 0;
        }
    }


    function saveBooking($request, $user_id, $billing_id, $bookings){
        $booking_arr[] = [];
        $booking_data = $request->session()->get('booking_data_temp');
        $booked_rooms = array_values($bookings);
        if(count($booked_rooms) == 0){
            $i = 0;
            foreach ($booking_data['booking_data'] as $key => $value){
                $rooms = Rooms::select('room_category_id', 'room_number')->where('room_category_id', $value['room_category_id'])->whereNotIn('room_number', $booked_rooms)->take($value['no_of_rooms'])->orderBy('room_number', 'ASC')->get();
                foreach($rooms as $key_room => $room){
                    $booking_arr[$i]['user_id'] = $user_id;
                    $booking_arr[$i]['room_id'] = $room->room_number;
                    $booking_arr[$i]['from_date'] = $booking_data['check_in'];
                    $booking_arr[$i]['to_date'] = $booking_data['check_out'];
                    $booking_arr[$i]['people_adult'] = $value['people_adult'][$key_room];
                    $booking_arr[$i]['people_child'] = $value['people_child'][$key_room];
                    $booking_arr[$i]['unit_price'] = $user_id;
                    $booking_arr[$i]['discount'] = 0;
                    $booking_arr[$i]['total_price'] = 0;
                    $booking_arr[$i]['vat'] = 0;
                    $booking_arr[$i]['created_by'] = Auth::user()->id;;
                    $booking_arr[$i]['room_category_id'] = $room->room_category_id;
                    $booking_arr[$i]['created_at'] = date('Y-m-d H:i:s');
                    $i++;
                }
            }
            Booking::insert($booking_arr);
        }
    }
}
?>
