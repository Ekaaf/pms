<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    
    public function roomWiseReportView(Request $request){
        return view('report.room_wise_report');
    }

    public function roomWiseReportList(Request $request){
        $table = "(SELECT billing.id, billing.final_price, booking.from_date, booking.to_date,array_to_json(array_agg(row(room_categories.category, booking.room_category_id)))   
                    as booked_rooms, users.email, billing.checked_in_time,  billing.checked_out_time FROM billing inner join users on billing.user_id = users.id inner join user_info on users.id = user_info.user_id  inner join booking on billing.id = booking.billing_id inner join room_categories on room_categories.id = booking.room_category_id where billing.status = 1 AND billing.checked_in = 1 AND billing.checked_out = 0 group By billing.id, booking.from_date, booking.to_date, users.email) testtable";
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

            $start++;

            $idx++;

        }
        echo json_encode($result);

    }
}
