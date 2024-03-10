@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">User List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php
            $editaction = checkButtonAccess('admin/users/edit/{id}');
            $changepassaction = checkButtonAccess('admin/users/change-password/{id}');
            $deleteaction = checkButtonAccess('admin/users/delete/{id}');
        ?>
        
        @if(checkButtonAccess('admin/users/add'))
        <div class="text-end">
            <a href="{{URL::to('admin/users/add')}}" class="btn btn-success btn-border">
                <i class="bx bx-add-to-queue"></i>&nbsp
                Add User
            </a>
        </div>
        <br>
        @endif

        @include('layout.message')

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-nowrap align-middle mb-0" id="usersTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Serial</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <<th>Role</th>
                                    @if($editaction || $deleteaction || $changepassaction)
                                    <th>Action</th>
                                    @endif
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
<script type="text/javascript" src="{{URL::to('assets/custom/js/user.js')}}"></script>
<script>
    $(document).ready(function(){
        getAllUsers();
    });
    function getAllUsers(){
        var i = 1;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table= $('#usersTable').DataTable( {
            "processing": true,
            "lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
            "pageLength": 10,
            "serverSide": true,
            "destroy" :true,
            "ajax": {
                "url": './users',
                "type": 'POST',
                // "data": function ( d ) {
                //     d.current_semester = $('#current_semester').val();
                    
                // },
            },
            "columns": [
                { "data": "0" },
                { "data": "email" },
                { "data": "mobile" },
                { "data": "role" },
                @if($editaction || $deleteaction)
                { "data": "id",
                  "render": function ( data, type, full, meta ) {
                    var buttons = "";
                    @if($editaction)
                        buttons += "<a href=\"users/edit/"+data+"\"><button class=\"btn btn-xs btn-primary\"><i class=\"fa fa-edit\"></i>&nbsp Edit</button></a>";
                    @endif
                    @if($changepassaction)
                        buttons += "&nbsp<a href=\"users/change-password/"+data+"\"><button class=\"btn btn-xs btn-success\"><i class=\"fa fa-edit\"></i>&nbsp Change Password</button></a>"
                    @endif
                    @if($deleteaction)
                        buttons += "&nbsp<button class=\"btn btn-xs btn-danger\" onclick=\"deleteUser("+data+")\"><i class=\"fa fa-trash\"></i>&nbsp Delete</button>"
                    @endif
                    @if(Auth::user()->role_id == 1)
                        var array = new Array();
                        array = Object.entries(full);
                        buttons += "&nbsp<button class=\"btn btn-xs btn-info\" onclick=\"actAsUser("+full.id+",'"+full.email+"')\"><i class=\"fa fa-user\"></i>&nbspAct As User</button>"
                    @endif
                    // return "<a href=\"users/edit/"+data+"\"><button class=\"btn btn-xs btn-info\"><i class=\"fa fa-edit\"></i>&nbsp Edit</button></a>&nbsp<button class=\"btn btn-xs btn-danger\" onclick=\"deleteUser("+data+")\"><i class=\"fa fa-trash\"></i>&nbsp Delete</button>";
                    return buttons;
                  }
                }
                @endif
            ]
        });
    }

    function actAsUser(id, username){
        Swal.fire({
            title: 'Are you sure want to act as '+username+"?",
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "act-as-user/"+id;
            }
        })
    }

    function deleteUser(id){
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