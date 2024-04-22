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
                                        <th class="ps-0" scope="row">Thumb Image :</th>
                                        <td class="text-muted">
                                            <div class="image-display-div">
                                                <img src="{{URL::to($images['room-category-thumb'][0]['path'].$images['room-category-thumb'][0]['filename'])}}" class="img-thumbnail">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Other Images :</th>
                                        <td class="text-muted">

                                        <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel" style="width: 70%;">
                                          <div class="carousel-indicators">
                                            @php $i = 0; @endphp
                                            @foreach($images['room-category-other-image'] as $room)
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$i}}" class="active" aria-current="true" aria-label="Slide {{$i}}"></button>
                                            @php $i++; @endphp
                                            @endforeach
                                          </div>
                                          <div class="carousel-inner">
                                            @php $i = 0; @endphp
                                            @foreach($images['room-category-other-image'] as $room)
                                                <div class="carousel-item <?php if($i==0) echo 'active';?>">
                                                    <img src="{{URL::to($room->path.$room->filename)}}" class="d-block w-100" alt="...">
                                                </div>
                                            @php $i++; @endphp
                                            @endforeach
                                            
                                          </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Discount :</th>
                                        <td class="text-muted">{{$roomCategory->discount}} %
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

    });
</script>
@endsection