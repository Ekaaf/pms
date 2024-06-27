<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Rooms;
use App\Models\Booking;
use App\Models\User;
use App\Models\Role;
use App\Models\RoomCategoryRent;
use Illuminate\Support\Facades\DB;
use App\Service\MenuService;
use App\SSP;
use App\Models\Billing;

class ReservationController extends Controller
{
    
    public function reservation(Request $request)
    {   
        $request->session()->forget('booking_data_temp');
        return view('pms.reservation');
    }

    public function searchRoomCategory(Request $request){
        $request->session()->forget('booking_data_temp');
        $check_in = $request->check_in;
        $check_out = $request->check_out;
        $bookings = Booking::where(function ($query) use ($check_in, $check_out) {
            $query->where('from_date', '<=', $check_in)
                  ->where('to_date', '>', $check_in);
        })->orWhere(function ($query) use ($check_in, $check_out) {
            $query->where('from_date', '<', $check_out)
                  ->where('to_date', '>=', $check_out);
        })->pluck('room_id');
        $data['available_rooms'] = Rooms::select('room_categories.*', DB::raw('COUNT(room_categories.id) as no_of_rooms'), 'files.path', 'files.filename')->join('room_categories', 'rooms.room_category_id', 'room_categories.id')
                            ->join('files', 'room_categories.id', 'files.element_id')
                            ->where('files.type', 'room-category-thumb')
                            ->whereNotIn('rooms.id', $bookings)
                            ->groupBy('room_categories.id', 'files.path', 'files.filename')->get();

        $room_categories_id = array_column($data['available_rooms']->toArray(), 'id');
        $room_category_rents = RoomCategoryRent::whereIn('room_category_id', $room_categories_id)->where('rent_date', '>=', $check_in)->where('rent_date', '<', $check_out)->get();
        $room_category_rent_arr = [];
        foreach($room_category_rents as $rent){
            $room_category_rent_arr[$rent->room_category_id][$rent->rent_date] = ['price'=>$rent->price, 'discount'=>$rent->discount, 'net_price'=>$rent->net_price];
        }
        // $data['room_category_rent_arr'] = json_encode($room_category_rent_arr);
        $data['room_category_rent_arr'] = $room_category_rent_arr ;
        return response()->json($data);
    }


    public function bookRoomTemp(Request $request){
        $input = [];
        $input['check_in'] = $request->check_in;
        $input['check_out'] = $request->check_out;
        $input['no_of_nights'] = (int) (strtotime($request->check_out) - strtotime($request->check_in)) / (60 * 60 * 24);
        foreach($request->booking_data as $key=>$value){
            $input['booking_data'][$value[0]]['room_category_id'] = $value[0];
            $input['booking_data'][$value[0]]['room_category'] = $value[1];
            $input['booking_data'][$value[0]]['people_adult'] = $value[2];
            $input['booking_data'][$value[0]]['people_child'] = $value[3];
            $input['booking_data'][$value[0]]['room_price'] = $value[4];
            $input['booking_data'][$value[0]]['no_of_rooms'] = $value[5];
        }
        $request->session()->put('booking_data_temp', $input);
        return response()->json($input);
    }


    public function billingInfo(Request $request){
        $booking_data_temp = $request->session()->get('booking_data_temp');
        $customers = User::where('role_id', Role::where('name', 'Customer')->value('id'))->get();
        return view('pms.billing_info')->with('booking_data_temp', $booking_data_temp)->with('customers', $customers);
    }


    public function confirmBooking(Request $request){
        if(null !== $request->session()->get('booking_data_temp')){
            try {
                DB::beginTransaction();
                $booking_data = $request->session()->get('booking_data_temp');
                $this->menuService = new MenuService();
                $available = $this->menuService->checkRoomAvailability($booking_data);
                if($available['success'] == 1){
                    $bookings = $available['bookings'];

                    $valid_price = $this->menuService->validateTotalPrice($booking_data, $request);
                    if($valid_price){
                        if($request->user_type != 'existing_user'){
                            $user_id = $this->menuService->saveUser($request);
                        }
                        else{
                            $user_id = $request->user_id;
                        }
                        $billing_id = $this->menuService->saveBillingInfo($request, $user_id);
                        $this->menuService->saveBooking($request, $user_id, $billing_id, $bookings);
                        DB::commit();
                        $request->session()->forget('booking_data_temp');
                        echo "Booking Successful";
                        exit;
                    }
                    else{
                        dd($valid_price);
                    }
                }
                else{
                    dd($available);
                }
                return redirect('admin/room-category')->with('success', "Successfully Saved");
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                return redirect()->back()->with('error', "Couldn't save!")->withInput();
            }
        }
        else{
            echo "No Booking data found";
            exit;
        }
        
    }

    public function getUserInfo(Request $request){
        $user = User::join('user_info', 'users.id', 'user_info.user_id')->where('users.id', $request->user_id)->first();
        return response()->json($user);
    }


    public function checkInList(Request $request)
    {
        return view('pms.check_in_list');
    }

    public function getAllCheckInList(Request $request){
        $table = "(SELECT billing.id, billing.final_price, booking.from_date, booking.to_date,array_to_json(array_agg(row(room_categories.category, booking.room_category_id)))   
                    as booked_rooms, users.email, billing.checked_in_time,  billing.checked_out_time FROM billing inner join users on billing.user_id = users.id inner join user_info on users.id = user_info.user_id  inner join booking on billing.id = booking.billing_id inner join room_categories on room_categories.id = booking.room_category_id where billing.status = 1 and (billing.checked_in = 0 OR billing.checked_out = 0) group By billing.id, booking.from_date, booking.to_date, users.email) testtable";
        // dd($table);
        $primaryKey = 'id';
        $columns = array(

            array( 'db' => 'id', 'dt' => 'id' ),

            array( 'db' => 'from_date', 'dt' => 'from_date' ),

            array( 'db' => 'to_date', 'dt' => 'to_date' ),

            array( 'db' => 'email', 'dt' => 'email' ),

            array( 'db' => 'booked_rooms', 'dt' => 'booked_rooms' ),
            
            array( 'db' => 'final_price', 'dt' => 'final_price' ),

            array( 'db' => 'checked_in_time', 'dt' => 'check_in_time' ),

            array( 'db' => 'checked_out_time', 'dt' => 'check_out_time' ),
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

            $res['from_date'] = date_format(date_create($res['from_date']),"jS M, Y");

            $res['to_date'] = date_format(date_create($res['to_date']),"jS M, Y");

            $res['email'] = $res['email'];
            
            $booked_rooms = json_decode($res['booked_rooms']);
            
            $arr = [];$text = '';
            foreach($booked_rooms as $room){
                $arr[$room->f1] = 0;
            }
            foreach($booked_rooms as $room){
                $arr[$room->f1]++;
            }

            foreach($arr as $key => $value){
                $text .="<b>".$key.":</b> ".$value."<br>";
            }

            $res['booked_rooms_text'] = $text;

            $start++;

            $idx++;

        }
        echo json_encode($result);

    }

    public function checkInView(Request $request, $billing_id)
    {   
        $data = Billing::select('billing.id as billing_id', 'users.email', 'user_info.title', 'user_info.first_name', 'user_info.last_name', 'users.mobile', 'booking.from_date', 'booking.to_date', 'booking.people_adult', 'booking.people_child', 'booking.total_price', 'room_categories.category', 'rooms.room_number')->join('biiling_other_info', 'billing.id', 'biiling_other_info.billing_id')->join('booking', 'billing.id', 'booking.billing_id')->join('users', 'users.id', 'billing.user_id')->join('room_categories', 'room_categories.id', 'booking.room_category_id')->join('user_info', 'user_info.user_id', 'users.id')->join('rooms', 'rooms.id', 'booking.room_id')->where('billing.id', $billing_id)->get();

        // dd($data);
        return view('pms.check_in_guest')->with('data',$data);
    }


    public function checkInComplete(Request $request, $billing_id)
    {
        if($request->billing_id == $billing_id){
            $billing = Billing::find($billing_id);
            if($billing->checked_in == 1){
                return redirect()->back()->with('error', "Guest Already Checked In")->withInput();
            }
            else{
                $billing->checked_in = 1;
                $billing->checked_in_time = date('Y-m-d H:i:s');
                $billing->save();
                echo "Checked In Successful";
            }
        }
    }
}
