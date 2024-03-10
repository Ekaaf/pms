@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Menu Add</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Menus</a></li>
                                <li class="breadcrumb-item active">Menu Add</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @include('layout.message')
        <div class="row" style="margin-left: 3%;margin-right: 3%;">
            <form class="needs-validation" action="{{URL::to('admin/menus/menu-add')}}" method="post" id="menu_form" novalidate>
                @csrf
                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label for="nameInput" class="form-label">Title</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Menu Title">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label for="nameInput" class="form-label">Icon</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Menu Icon">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label for="nameInput" class="form-label"></label>
                    </div>
                    <div class="col-lg-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_submenu" name="is_submenu" value="1" <?php if(old('is_submenu')) echo 'checked'; ?>>
                            <label class="form-check-label" for="is_submenu">
                                Sub Menu
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3" id="parentMenuDiv" style="display:<?php echo ($errors->has('parent_id') || old('is_submenu')) ?  "flex":  "none"; ?>;">
                    <div class="col-lg-2">
                        <label for="nameInput" class="form-label">Parent</label>
                    </div>
                    <div class="col-lg-10">
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">Select</option>
                            @foreach($menus as $menu)
                            <option value="{{$menu->id}}" <?php if(old('parent_id') == $menu->id) echo 'selected' ?>>{{$menu->title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('parent_id'))
                            <div class="error">{{ $errors->first('parent_id') }}</div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label for="nameInput" class="form-label">Menu Route</label>
                    </div>
                    <div class="col-lg-10">
                        <div id="pathDiv">
                            <select class="form-control" id="menu_path" name="menu_path">
                                <option value="" selected>Select</option>
                                @foreach($paths as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            </div>
                            @if($errors->has('path'))
                                <div class="error">{{ $errors->first('path') }}</div>
                            @endif
                        </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label for="nameInput" class="form-label"></label>
                    </div>
                    <div class="col-lg-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="default" name="default" value="1" <?php if(old('default') == 1) echo 'checked'; ?>>
                            <label class="form-check-label" for="default">
                                Default Access For All
                            </label>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered" id="methodTable">
                    <thead>
                        <tr><th>Method Name</th><th>Path</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 30%;">
                                <input type="text" class="form-control" id="method_name" name="method_name[]" placeholder="Method Name">
                            </td>
                            <td style="width: 70%;">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <select class="form-control path" name="path[]" style="width: 90%;">
                                            <option value="" selected>Select</option>
                                            @foreach($paths as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-sm btn-danger" style="display:none;">
                                            <i class="ri-delete-bin-5-line"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                
                            </td>
                        </tr>
                    </tbody>
                </table>


                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-success waves-effect waves-light" style="float:right; margin-top: 5px;" onclick="addMore();">Add More</button>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

        <!-- end main content-->
@endsection

@section('script')
<script type="text/javascript" src="{{URL::to('assets/custom/js/menu.js')}}"></script>
@endsection