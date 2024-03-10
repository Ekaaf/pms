@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Menu Edit</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Menus</a></li>
                                <li class="breadcrumb-item active">Menu Edit</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @include('layout.message')
        <div class="row" style="margin-left: 3%;margin-right: 3%;">
            <form class="needs-validation" action="{{URL::to('admin/menus/menu-edit/'.$menuCurrent[0]->id)}}" method="post" id="menu_form" novalidate>
                @csrf
                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label for="nameInput" class="form-label">Title</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title') ?? $menuCurrent[0]->title}}" placeholder="Menu title">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label for="nameInput" class="form-label">Icon</label>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="icon" name="icon" value="{{old('icon') ?? $menuCurrent[0]->icon}}" placeholder="Menu icon">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label for="nameInput" class="form-label"></label>
                    </div>
                    <div class="col-lg-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_submenu" name="is_submenu" value="1" <?php if(old('is_submenu') || $menuCurrent[0]->parent_id != '') echo 'checked'; ?>>
                            <label class="form-check-label" for="is_submenu">
                                Sub Menu
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3" id="parentMenuDiv" style="display:<?php echo (old('is_submenu') || $menuCurrent[0]->parent_id != '') ?  "flex;":  "none"; ?>;">
                    <div class="col-lg-2">
                        <label for="nameInput" class="form-label">Parent</label>
                    </div>
                    <div class="col-lg-10">
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">Select</option>
                            @foreach($menus as $menu)
                            <option value="{{$menu->id}}" <?php if((old('parent_id') == $menu->id) || ($menuCurrent[0]->parent_id == $menu->id)) echo 'selected' ?>>{{$menu->title}}</option>
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
                                @if(old('menu_path'))
                                @foreach($paths as $key => $value)
                                <option value="{{$key}}" <?php if(old('menu_path') == $key) echo 'selected' ?>>{{$value}}</option>
                                @endforeach
                                @else
                                @foreach($paths as $key => $value)
                                <option value="{{$key}}" <?php if($menuCurrent[0]->path == $key) echo 'selected' ?>>{{$value}}</option>
                                @endforeach
                                @endif
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
                            <input class="form-check-input" type="checkbox" id="default" name="default" value="1" <?php if((old('default') == 1) || $menuCurrent[0]->default == 1) echo 'checked'; ?>>
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
                        <?php $i = 0; ?>
                        @foreach($menuCurrent as $current)
                        <tr>
                            <td style="width: 30%;">
                                <input type="text" class="form-control" name="method_name[]" placeholder="Method Name" value="{{$current->method_name}}">
                            </td>
                            <td style="width: 70%;">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <select class="form-control path" name="path[]" style="width: 90%;">
                                            <option value="" selected>Select</option>
                                            @foreach($paths as $key => $value)
                                            <option value="{{$key}}" <?php if($current->menu_path == $key) echo "selected"; ?>>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-sm btn-danger" style="<?php if($i == 0){ echo 'display: none;'; } ?>" onclick="$(this).parent().parent().remove();">
                                            <i class="ri-delete-bin-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="text" name="menu_methods_id[]" value="{{$current->menu_methods_id}}" style="display:none;">
                            </td>
                        </tr>
                        
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>


                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-success waves-effect waves-light" style="float:right; margin-top: 5px;" onclick="addMore();">Add More</button>
                </div>

                @if(checkButtonAccess('admin/menus/menu-edit/{id}'))
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                @endif
            </form>
        </div>
    </div>

        <!-- end main content-->
@endsection

@section('script')
<script type="text/javascript" src="{{URL::to('assets/custom/js/menu.js')}}"></script>
@endsection