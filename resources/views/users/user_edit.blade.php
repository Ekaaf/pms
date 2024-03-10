@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">User Add</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                <li class="breadcrumb-item active">User Add</li>
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
                        <form action="{{URL::to('admin/users/edit')}}/{{$user->id}}" method="post">
                    
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Email</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}" placeholder="Email">
                                </div>
                            </div>
                            @if($errors->has('email'))
                                <div class="error">{{ $errors->first('email') }}</div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Mobile</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{$user->mobile}}" placeholder="Mobile">
                                </div>
                            </div>
                            @if($errors->has('mobile'))
                                <div class="error">{{ $errors->first('mobile') }}</div>
                            @endif

                            
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Role</label>
                                </div>
                                <div class="col-lg-10">
                                    <select class="form-control" name="role_id" id="role_id">
                                        <option value="">Select</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}" <?php if($user->role_id == $role->id) echo "selected"; ?>>{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if($errors->has('role_id'))
                                <div class="error">{{ $errors->first('role_id') }}</div>
                            @endif

                            @if(checkButtonAccess('admin/users/update/{$id}'))
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                            @endif
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- end main content-->
@endsection

@section('script')
<script type="text/javascript" src="{{URL::to('assets/custom/js/user.js')}}"></script>
@endsection