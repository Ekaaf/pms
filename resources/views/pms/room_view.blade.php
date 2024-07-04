@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Room View List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Room View</a></li>
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
                        <?php $i = 0; ?>
                        @foreach($data as $key=>$d)
                            <div class="accordion custom-accordionwithicon" id="accordionFill">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="accordionFillExample{{$key}}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accor_fill{{$i}}" aria-expanded="true" aria-controls="accor_fill{{$i}}">
                                            {{$key}}
                                        </button>
                                    </h2>
<!-- bg-success -->
                                    <div id="accor_fill{{$i}}" class="accordion-collapse collapse show" aria-labelledby="accordionFillExample{{$key}}" data-bs-parent="#accordionFill">
                                        <div class="accordion-body">
                                            <div class="d-flex align-items-start flex-wrap gap-4">
                                                @foreach($d as $room)
                                                <?php
                                                    $colorCode = '';
                                                    if($room['room_status'] == 'empty'){
                                                        $colorCode = '#bfbfbf';
                                                    }
                                                    else if($room['room_status'] == 'checked_in'){
                                                        $colorCode = '#009933';
                                                    }
                                                    else if($room['room_status'] == 'booked'){
                                                        $colorCode = '#4da6ff';
                                                    }
                                                    else if($room['room_status'] == 'checking_out'){
                                                        $colorCode = '#e6ac00';
                                                    }
                                                    else if($room['room_status'] == 'checked_out'){
                                                        $colorCode = '#e62e00';
                                                    }
                                                ?>
                                                <div class="border border-1 border-light rounded" style="width: 140px;height: 80px;position: relative;">
                                                    <div class="rounded" style="height:55%;background-color: {{$colorCode}};padding: 5px;color: black;">{{$room['room_number']}}</div>
                                                    <div class="rounded" style="position: absolute;bottom: 5px;color: black;padding-left: 5px;">{{$room['guest_name']}}</div>
                                                </div>
                                                @endforeach
                                            </div>
                                            
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>
                        <?php $i++; ?>
                        @endforeach
                </div>
            </div>
        </div>
    </div>

        <!-- end main content-->
@endsection

@section('script')

<script>
    $(document).ready(function() {
        // getAllCheckInList();
    });
</script>
@endsection