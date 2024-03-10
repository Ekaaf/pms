@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Menu List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Menus</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php
            $edit = checkButtonAccess('admin/menus/menu-edit/{id}');
            $uac = checkButtonAccess('admin/user-access/{id}');
            $delete = checkButtonAccess('admin/menus/delete-menu');
        ?>
        
        @if(checkButtonAccess('admin/menus/menu-add'))
        <div class="text-end">
            <a href="{{URL::to('admin/menus/menu-add')}}" class="btn btn-success btn-border">
                <i class="bx bx-add-to-queue"></i>&nbsp
                Add Menu
            </a>
        </div>
        <br>
        @endif

        @include('layout.message')
        
        <div class="row">
            @foreach($menuTree as $menu)
            <div class="col-xl-6">
                <div class="card border-secondary">
                    <div class="card-body">
                        <table class="table table-bordered  table-nowrap align-middle mb-0">
                            <tbody>
                                <tr>
                                    <td>
                                        {{$menu['parent']['title']}}
                                        @if($edit)
                                        <a href="{{URL::to('admin/menus/menu-edit')}}/{{$menu['parent']['id']}}" class="btn btn-sm btn-primary"><i class=" ri-edit-2-fill"></i></a>
                                        @endif
                                        @if($delete)
                                        @if(!array_key_exists("child",$menu))
                                        <button type="button" value="{{$menu['parent']['id']}}" class="btn btn-danger btn-border btn-sm" onclick="deleteMenu(this,'parent');"><i class=" ri-delete-bin-fill"></i></button>
                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if(array_key_exists("child",$menu))
                                        <table class="table table-bordered table-hover" style="margin-bottom:0px!important;">
                                            <tbody>
                                                @foreach($menu['child'] as $child)
                                                <tr>
                                                    <td>{{$child['title']}}</td>
                                                    <td>
                                                        @if($edit)
                                                        <a href="{{URL::to('admin/menus/menu-edit')}}/{{$child['id']}}" class="btn btn-sm btn-primary"><i class=" ri-edit-2-fill"></i></a>
                                                        @endif
                                                        @if($edit)
                                                        <button type="button" value="{{$child['id']}}" class="btn btn-danger btn-border btn-sm" onclick="deleteMenu(this, 'child');"><i class="ri-delete-bin-fill"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

        <!-- end main content-->
@endsection

@section('script')
<script type="text/javascript" src="{{URL::to('assets/custom/js/menu.js')}}"></script>
@endsection