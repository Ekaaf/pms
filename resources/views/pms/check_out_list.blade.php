@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Check Out List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Check Out</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php
            $check_out_guest = checkButtonAccess('admin/check-out/{id}');
        ?>
        

        @include('layout.message')

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-nowrap align-middle mb-0" id="roomCategoriesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Serial</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Guest</th>
                                    <th>Rooms</th>
                                    <th>Price</th>
                                    <th>Check In Time</th>
                                    <th>Check Out Time</th>
                                    <th>Action</th>
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
        getAllCheckInList();
    });

    function getAllCheckInList(){
        var i = 1;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var table= $('#roomCategoriesTable').DataTable( {
            "processing": true,
            "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
            "pageLength": 10,
            "serverSide": true,
            "destroy" :true,
            "ajax": {
                "url": './check-out',
                "type": 'POST',
                // "data": function ( d ) {
                //     d.current_semester = $('#current_semester').val();
                // },
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
                        @if($check_out_guest)
                            buttons += "<a href=\"check-out-complete/"+data+"\"><button class=\"btn btn-primary waves-effect waves-light\"><i class=\"fa fa-edit\"></i>&nbsp Check Out</button></a>";
                        @endif
                        return buttons;
                    }
                }
            ]
        });
    }
</script>
@endsection