<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\SSP;

class ReportController extends Controller
{
    
    public function roomWiseReportView(Request $request){
        return view('report.room_wise_report');
    }

    public function roomWiseReportList(Request $request){
        $table = "(select rooms.id, rooms.room_category_id, booked, rooms.room_number, total_price from rooms left join (select booking_days.room_id, sum(booking_days.total_price) as total_price, count(booking_days.id) as booked from booking_days where 
                date between '".$request->from_date."' and '".$request->to_date."' group by booking_days.room_id) book_days on rooms.id = book_days.room_id) 
            testtable";
        // dd($table);
        $primaryKey = 'id';
        $columns = array(

            array( 'db' => 'id', 'dt' => 'id' ),

            array( 'db' => 'room_number', 'dt' => 'room_number' ),

            array( 'db' => 'booked', 'dt' => 'booked' ),

            array( 'db' => 'total_price', 'dt' => 'total_price' )
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

            $res['night_count'] = 5;

            $res['maintenance'] = 0;

            $start++;

            $idx++;

        }
        echo json_encode($result);

    }
}
