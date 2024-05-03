@extends('layout.master')

@section('content')

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                                <h4 class="mb-sm-0">Booking Info</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Reservation</a></li>
                                        <li class="breadcrumb-item active"> Reservation</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
                @include('layout.message')

                <div class="row">
                    <div class="col-sm-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0 text-center">Booking Summary</h4>
                            </div>
                            <div class="card-body" id="summary_div">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0 text-center">Booking Summary</h4>
                            </div>
                            <div class="card-body" id="summary_div">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- End Page-content -->

        <!-- end main content-->
@endsection

@section('script')
<script>
    $( document ).ready(function() {
    });
</script>
@endsection