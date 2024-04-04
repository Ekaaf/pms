@extends('layout.master')

@section('content')

<style type="text/css">
    th{
        width: 20%;
    }
</style>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Room Category Edit</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Room Category</a></li>
                                <li class="breadcrumb-item active">Room Category Edit</li>
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
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">Room Category :</th>
                                        <td class="text-muted">{{$roomCategory->category}}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Room Size :</th>
                                        <td class="text-muted">{{$roomCategory->size}}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Adult :</th>
                                        <td class="text-muted">{{$roomCategory->people_adult}}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Child :</th>
                                        <td class="text-muted">{{$roomCategory->people_child}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Bed :</th>
                                        <td class="text-muted">{{numberOfBeds($roomCategory->bed)}}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Price :</th>
                                        <td class="text-muted">{{$roomCategory->price}} BDT
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Description :</th>
                                        <td class="text-muted">{!!$roomCategory->description!!}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Package :</th>
                                        <td class="text-muted">{!!$roomCategory->package!!}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Facilities :</th>
                                        <td class="text-muted">{!!$roomCategory->facilities!!}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Check In Time :</th>
                                        <td class="text-muted">{{$roomCategory->check_in}}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Check Out Time :</th>
                                        <td class="text-muted">{{$roomCategory->check_out}}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Check In Instructions :</th>
                                        <td class="text-muted">{!!$roomCategory->check_in_instruction!!}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Cancellation Policy :</th>
                                        <td class="text-muted">{!!$roomCategory->cancellation_policy!!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- end main content-->
@endsection

@section('script')
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script> -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/super-build/ckeditor.js"></script>
<script src="{{asset('assets/custom/js/ckeditorinit.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        initializeCkEditor('description', '');
        initializeCkEditor('package', '');
        initializeCkEditor('facilities', '');
        initializeCkEditor('check_in_instruction', '');
        initializeCkEditor('cancellation_policy', '');
    });
</script>
@endsection