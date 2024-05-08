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
                                    <th>Category</th>
                                    <th>Size</th>
                                    <th>No. of People</th>
                                    <th>Bed</th>
                                    <th>Room Price</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    @if($editaction || $deleteaction || $viewaction)
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
<script type="text/javascript">
    var editaction = {{$editaction}};
    var viewaction = {{$viewaction}};
    var deleteaction = {{$deleteaction}};
</script>
<script type="text/javascript" src="{{URL::to('assets/custom/js/room_category.js')}}"></script>
@endsection