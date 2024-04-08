@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Rooms List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Rooms</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if(checkButtonAccess('admin/rooms/add'))
        <div class="text-end">
            <a href="{{URL::to('admin/rooms/add')}}" class="btn btn-success btn-border">
                <i class="bx bx-add-to-queue"></i>&nbsp
                Add Rooms
            </a>
        </div>
        <br>
        @endif

        @include('layout.message')

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-nowrap align-middle mb-0" id="rooms">
                            <thead class="table-light">
                                <tr>
                                    <th>Serial</th>
                                    <th>Room Number</th>
                                    <th>Room Status</th>
                                    <th>Status</th>
                                    <th>House Keeping</th>
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
<script type="text/javascript">
</script>
<script type="text/javascript" src="{{URL::to('assets/custom/js/rooms.js')}}"></script>
@endsection