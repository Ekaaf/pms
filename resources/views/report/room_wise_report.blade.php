@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Report</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Room Wise Report</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php
            $check_in_guest = checkButtonAccess('admin/check-in/{id}');
        ?>
        
        @include('layout.message')

        <div class="row">
            <div class="col-xl-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">From Date:</label>
                                    <input type="date" class="form-control" id="from_date" name="from_date">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">To Date:</label>
                                    <input type="date" class="form-control" id="to_date" name="to_date">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6 d-flex">
                                <button type="button" class="btn btn-primary waves-effect waves-light align-self-end"  onclick="getRoomWiseReportList();">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-nowrap align-middle mb-0" id="room_wise_report_table">
                            <thead class="table-light">
                                <tr>
                                    <th>Room Number</th>
                                    <th>Night Count</th>
                                    <th>Booked</th>
                                    <th>Maintainance</th>
                                    <th>Total Fare</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- end main content-->
@endsection

@section('script')

<script>
    $(document).ready(function() {
        // getRoomWiseReportList();
    });

    function getRoomWiseReportList(){
        var i = 1;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var table= $('#room_wise_report_table').DataTable( {
            "processing": true,
            "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
            "pageLength": 10,
            "serverSide": true,
            "destroy" :true,
            "ajax": {
                "url": './room-wise-report',
                "type": 'POST',
                "data": function ( d ) {
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                },
            },
            "columns": [
                { "data": "0" },
                { "data": "from_date" },
                { "data": "to_date" },
                { "data": "email" },
                { "data": "booked_rooms_text" },
                { "data": "final_price" },
                { "data": "check_in_time" },
                { "data": "check_out_time" },
                {
                    "data": "id",
                    "render": function ( data, type, full, meta ) {
                        var buttons = "";
                        @if($check_in_guest)
                            buttons += "<a href=\"check-in-complete/"+data+"\"><button class=\"btn btn-primary waves-effect waves-light\"><i class=\"fa fa-edit\"></i>&nbsp Check In</button></a>";
                        @endif
                        return buttons;
                    }
                }
            ]
        });
    }
</script>
@endsection