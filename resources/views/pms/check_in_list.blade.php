@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Room Categories List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Room Categories</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php
            $editaction = checkButtonAccess('admin/room-category/edit/{id}');
            $viewaction = checkButtonAccess('admin/room-category/view/{id}');
            $deleteaction = checkButtonAccess('admin/room-category/delete/{id}');
        ?>
        
        @if(checkButtonAccess('admin/room-category-rent/add'))
        <div class="text-end">
            <a href="{{URL::to('admin/room-category/add')}}" class="btn btn-success btn-border">
                <i class="bx bx-add-to-queue"></i>&nbsp
                Add Room Category
            </a>
        </div>
        <br>
        @endif

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
                { "data": "from_date" },
                { "data": "to_date" },
                { "data": "final_price" },
                { "data": "to_date" },
                { "data": "from_date" },
                // { "data": "to_date" },
                { "data": null, "orderable": false, "searchable": false }
            ],
            "columnDefs": [{
                "targets": -1, // Targets the last column
                "data": null,
                "render": function(data, type, row, meta) {
                    return '<button class="btn btn-success btn-sm" onclick="handleButtonClick(' + row.id +')">Check-in</button>';
                }
            }]

        });
    }

    function handleButtonClick(id) {
        // alert("Button clicked! "+ id);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: 'check-in-confirmation',
            data: {
              id : id
            },
            dataType: 'json',
        })
        .done(function (data) {
            // $(element).prop("disabled",false);
            console.log("AJAX request was successful:", data);
            window.location.href = "./check-in-confirmation";
        });
    }

    function deleteRoomCategory(id){
        var txt;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Swal.fire({
            title: 'Are you sure want to delete ?',
            // text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: 'users/delete/'+id,
                data: {
                  id : id
                },
                dataType: 'json',
            })
            .done(function (data) {
                if(data){
                    Swal.fire(
                      'Successfully Deleted',
                      '',
                      'success'
                    );
                    getAllUsers();
                }
                else{
                    Swal.fire(
                      'Sorry! User could not be deleted',
                      '',
                      'error'
                    );
                }
            });
        }
    })
}
</script>
@endsection