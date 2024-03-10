@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Roles List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Roles</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php
            $edit = checkButtonAccess('admin/roles/update-role/{id}');
            $uac = checkButtonAccess('admin/user-access/{id}');
            $delete = checkButtonAccess('admin/roles/delete-role')
        ?>
        
        @if(checkButtonAccess('admin/roles/save-role'))
        <div class="text-end">
            <button class="btn btn-success btn-border" onclick="addRole();">
                <i class="bx bx-add-to-queue"></i>&nbsp
                Add Role
            </button>
        </div>
        <br>
        @endif

        @include('layout.message')

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Serial</th>
                                    <th scope="col">Role</th>
                                    @if($edit || $uac || $delete)
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as  $role)
                                <tr id="tr{{$role->id}}">
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @if($edit)
                                        <button type="button" class="btn btn-sm btn-primary" onclick="editRole({{$role->id}});">
                                            <i class="ri-edit-2-fill"></i>&nbsp Edit
                                        </button>
                                        @endif
                                        @if($uac)
                                        <a href="{{URL::to('admin/user-access')}}/{{$role->id}}" class="btn btn-sm btn-success">
                                            <i class="bx bx-user-pin"></i> &nbsp UAC
                                        </a>
                                        @endif
                                        @if($delete)
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteRole({{$role->id}});">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- end main content-->
@endsection


@section('modal')
<div id="roleModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="roleForm" action="{{URL::to('admin/roles/save-role')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                                <div>
                                    <label for="placeholderInput" class="form-label">Role Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Please enter role">
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save_button">Save Role</button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $("#roleForm").validate({
            rules: {
                name: "required"
            },
            messages: {
                name: "Please Enter Role"
            }
        });
    });

    function addRole(){
        $('#roleForm').prop('action', "{{URL::to('admin/roles/save-role')}}");
        $(".modal-title").text('Add Role');
        $("#name").val('');
        $("#save_button").text("Save");
        $('#roleModal').modal('show');
    }

    function editRole(id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
                type: 'POST',
                url: 'roles/edit-role/'+id,
                data: {
                  id : id
                },
                dataType: 'json',
            })
            .done(function (data) {
                $('#roleForm').prop('action', "{{URL::to('admin/roles/update-role')}}/"+data.id);
                $(".modal-title").text('Edit Role');
                $("#name").val(data.name);
                $("#save_button").text("Update");
                $('#roleModal').modal('show');
            });
        
    }

    function deleteRole(id){
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
                    url: 'roles/delete-role',
                    data: {
                      id : id
                    },
                    dataType: 'json',
                })
                .done(function (data) {
                    // if(data.success){
                    //     <?php 
                    //         Session::flash('success', 'success');
                    //     ?>
                    // }
                    // else{
                    //     <?php 
                    //         Session::flash('error', 'error');
                    //     ?>
                    // }
                    location.reload();
                });
            }
        })
        
    }

</script>
@endsection