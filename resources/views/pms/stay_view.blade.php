@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Stay View List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Stay View</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @include('layout.message')

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-nowrap align-middle mb-0" id="roomCategoriesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Rooms</th>
                                    @for($i=0; $i<7; $i++)
                                    <th>{{$days[$i]}}</th>
                                    @endfor
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
        // getAllCheckInList();
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
                "url": './check-in',
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
                        return buttons;
                    }
                }
            ]
        });
    }
</script>
@endsection