<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Rooms;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Service\MenuService;

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
        // $bookings = Booking::where('to_date', '<=', $check_in)->where('from_date', '>=', $check_out)->pluck('room_id');
        // $bookings = Booking::where('from_date', '>=', $check_in)->where('from_date', '<', $check_out)->pluck('room_id');
        $bookings = Booking::where(function ($query) use ($check_in, $check_out) {
            $query->where('from_date', '<=', $check_in)
                  ->where('to_date', '>', $check_in);
        })->orWhere(function ($query) use ($check_in, $check_out) {
            $query->where('from_date', '<', $check_out)
                  ->where('to_date', '>=', $check_out);
        })->pluck('room_id');
        $available_rooms = Rooms::select('room_categories.*', DB::raw('COUNT(room_categories.id) as no_of_rooms'), 'files.path', 'files.filename')->join('room_categories', 'rooms.room_category_id', 'room_categories.id')
                            ->join('files', 'room_categories.id', 'files.element_id')
                            ->where('files.type', 'room-category-thumb')
                            ->whereNotIn('room_number', $bookings)
                            ->groupBy('room_categories.id', 'files.path', 'files.filename')->get();
        return response()->json($available_rooms);
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
        // dd($booking_data_temp);
        return view('pms.billing_info')->with('booking_data_temp', $booking_data_temp);
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

                    $valid_price = $this->menuService->validateTotalPrice($booking_data);
                    if($valid_price){
                        $user_id = $this->menuService->saveUser($request);
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
}
