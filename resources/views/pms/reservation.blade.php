@extends('layout.master')

@section('content')

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                                <h4 class="mb-sm-0">Reservation</h4>

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
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{URL::to('admin/search-room-category')}}" method="post">
                                    <div class="row gy-4">
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="basiInput" class="form-label">Check-in Date:</label>
                                                <input type="date" class="form-control" id="check_in" value="04/30/2024" name="check_in">
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="basiInput" class="form-label">Check-out Date:</label>
                                                <input type="date" class="form-control" id="check_out" name="check_in" value="05/01/2024">
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <button type="button" class="btn btn-primary waves-effect waves-light" style="position: absolute; bottom: 0;" onclick="searchRooms();">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center" id="loading_div" style="display:none;">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="row" id="available_room_div" style="display: none;">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Available Rooms</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8 pe-0" id="room_list_div">
                                        <!-- <div class="card">
                                            <div class="card-body">
                                                <div class="row me-1">
                                                    <div class="col-sm-4">
                                                        <img class="img-thumbnail" src="../images/room-category/Sea View/Sea View_thumb.webp">
                                                    </div>
                                                    <div class="col-sm-8 p-3 border rounded">
                                                        <h4 style="color:#8c68cd;">Sea View</h4>Room Capacity: 2 Adults 2 Children <div class="row me-1">
                                                            <div class="col-sm-8">Room Rates Exclusive of Ser. Chg. &amp; VAT</div>
                                                            <div id="room_plus_" 0="" class="col-sm-4 p-2 border rounded">
                                                                <b style="color:#8c68cd;">From BDT 5000</b>
                                                                <br>Per Room/Night
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-success btn-border mt-3 me-1 float-sm-end" onclick="showInputPlus(this)" >Add Room</button>
                                                        <div class="input-step mt-3 me-1 float-sm-end" style="">
                                                            <button type="button" class="minus" onclick="decrement(this);">–</button>
                                                            <input type="number" class="product-quantity" value="0" min="0" max="500">
                                                            <button type="button" class="plus" onclick="increment(this);">+</button>
                                                        </div>
                                                        <div class="row me-1 pt-2 w-100">
                                                            <div class="col-sm-2">
                                                                <b>Room 1</b>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                Adults(12+) &nbsp
                                                                <select required>
                                                                    <option value="">Select</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                Child(0-10) &nbsp
                                                                <select required>
                                                                    <option value="">Select</option>
                                                                    <option value="0">0</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
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
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- End Page-content -->

        <!-- end main content-->
@endsection

@section('script')
<script src="{{asset('assets/js/pages/form-input-spin.init.js')}}"></script>
<script>
    $( document ).ready(function() {
    });

    function searchRooms(){
        $("#available_room_div").hide();
        $("#loading_div").show();

        var check_in = $("#check_in").val();
        var check_out = $("#check_out").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: 'search-room-category',
            data: {
              check_in : check_in,
              check_out : check_out,
            },
            dataType: 'json',
        })
        .done(function (data) {
            console.log(data);
            $("#room_list_div").empty();
            var html = "";
            $.each(data, function(i, item) {
                html += '<div class="card">'+
                            '<div class="card-body">'+
                                '<div class="row me-1">'+
                                    '<div class="col-sm-4">'+
                                        '<img class="img-thumbnail" src="../'+item.path+item.filename+'">'+
                                    '</div>'+
                                    '<div class="col-sm-8 p-3 border rounded">'+
                                        '<h4 style="color:#8c68cd;">'+item.category+'</h4>'+
                                        'Room Capacity: '+item.people_adult+' Adults '+item.people_child+' Children'+
                                        '<div class="row me-1">'+
                                            '<div class="col-sm-8">'+
                                                'Room Rates Exclusive of Ser. Chg. & VAT'+
                                            '</div>'+
                                            '<div id="room_plus_"'+i+' class="col-sm-4 p-2 border rounded">'+
                                                '<b style="color:#8c68cd;">From BDT '+item.price+'</b>'+
                                                '<br>Per Room/Night'+
                                            '</div>'+
                                        '</div>'+
                                        '<button class="btn btn-success btn-border mt-3 me-1 float-sm-end" onclick="showInputPlus(this, '+item.people_adult+', '+item.people_child+')">'+
                                            'Add Room'+
                                        '</button>'+
                                        '<div class="input-step mt-3 me-1 float-sm-end" style="display:none;">'+
                                            '<button type="button" class="minus" onclick="decrement(this);">–</button>'+
                                            '<input type="number" class="product-quantity" value="0" min="0" max="500">'+
                                            '<button type="button" class="plus" onclick="increment(this, '+item.people_adult+', '+item.people_child+');">+</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
            });
            $( document ).ready(function() {
            });
            $("#room_list_div").append(html)
            $("#loading_div").hide();
            $("#available_room_div").show();
        });
    }


    function showInputPlus(element, people_adult, people_child){
        $(element).hide();
        $(element).next().show();
        increment($(element).next().children().eq(2), people_adult, people_child);
        $(element).next().next().show();
    }

    function increment(element, people_adult, people_child){
        var value = $(element).prev().val();
        $(element).prev().val(++value);
        console.log(people_adult)
        createPeopleCount(element, people_adult, people_child)
    }

    function decrement(element){
        var value = $(element).next().val();
        if(value > 0){
            $(element).next().val(--value)
        }
    }

    function createPeopleCount(element, people_adult, people_child){
        var html = '<div class="row me-1 pt-2 w-100 people-count">'+
                        '<div class="col-sm-2">'+
                            '<b>Room 1</b>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            'Adults(12+) &nbsp'+
                            '<select required>'+
                                '<option value="">Select</option>';

                            '</select>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            'Child(0-10) &nbsp'+
                            '<select required>'+
                                '<option value="">Select</option>'+
                                '<option value="0">0</option>'+
                                '<option value="1">1</option>'+
                                '<option value="2">2</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>';
        
        for(var i=1; i<=people_adult;i++){
            html += '<option value="'+i+'">'+i+'</option>'
        }

        html += '</select>'+
                    '</div>'+
                    '<div class="col-sm-4">'+
                        'Child(0-10) &nbsp'+
                        '<select required>'+
                            '<option value="">Select</option>';

        for(var i=1; i<=people_child;i++){
            html += '<option value="'+i+'">'+i+'</option>'
        }

        html += '</select>'+'</div>'+'</div>';
        $(element).parent().parent().append(html);
    }
</script>
@endsection