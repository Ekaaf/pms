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
                                        <div class="col-xxl-3 col-md-6 d-flex">
                                            <button type="button" class="btn btn-primary waves-effect waves-light align-self-end"  onclick="searchRooms(this);">Search</button>
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

                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title mb-0 text-center">Booking Summary</h4>
                                            </div>
                                            <div class="card-body" id="summary_div" style="display:none;">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <b style="color:#495057;margin-right: 10%;">Dates:</b> 
                                                        <span id="date_range">2024-05-13&nbsp; - &nbsp;2024-05-14</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b style="color:#495057;margin-right: 10%;">Nights:</b> 
                                                        <span id="no_of_days">1</span>
                                                    </li>
                                                    <li class="list-group-item" id="booked_room">
                                                        
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b style="color:#495057;margin-right: 10%;">Total:</b> 
                                                        <b class="float-end" style="font-size: 20px;color: #8c68cd" id="final_total"></b>
                                                    </li>
                                                </ul>
                                                <button type="button" class="btn btn-primary waves-effect waves-light w-100" onclick="bookNow(this);">Book Now</button>
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
        searchRooms();
    });
    var room_categories = [];
    var check_in = '';
    var check_out = ''
    function searchRooms(element){
        $(element).prop("disabled",true);
        $("#available_room_div").hide();
        $("#loading_div").show();

        check_in = $("#check_in").val();
        check_out = $("#check_out").val();
        // check_in = '2024-05-26';
        // check_out = '2024-05-29';
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
            $(element).prop("disabled",false);
            var dateList = getdateList(check_in, check_out);
            var available_rooms = data.available_rooms;
            var room_rent = data.room_category_rent_arr;
            var length = dateList.length;
            
            $("#room_list_div").empty();
            $("#booked_room").empty();
            var html = "";
            $.each(available_rooms, function(i, item) {
                var room_price_rent = 0;
                

                if(room_rent[item.id]){
                    for(var i=0; i<length; i++){
                        if(room_rent[item.id][dateList[i]]){
                            room_price_rent += parseInt(room_rent[item.id][dateList[i]].net_price);
                        }
                        else{
                            room_price_rent +=parseInt(item.price)
                        }
                    }
                }
                else{
                    room_price_rent += parseInt(item.price*length)
                }
                html += '<div class="card">'+
                            '<div class="card-body">'+
                                '<div class="row me-1">'+
                                    '<div class="col-sm-4">'+
                                        '<img class="img-thumbnail" src="../'+item.path+item.filename+'">'+
                                    '</div>'+
                                    '<div class="col-sm-8 p-3 border rounded">'+
                                    '<div>'+
                                        '<h4 style="color:#8c68cd;">'+item.category+'</h4>'+
                                        'Room Capacity: '+item.people_adult+' Adults '+item.people_child+' Children'+
                                        '<div class="row me-1">'+
                                            '<div class="col-sm-8">'+
                                                'Room Rates Exclusive of Ser. Chg. & VAT'+
                                            '</div>'+
                                            '<div class="col-sm-4 p-2 border rounded">'+
                                                '<b style="color:#8c68cd;">From BDT '+room_price_rent+'</b>'+
                                                '<br>Price for '+length+' Night'+
                                            '</div>'+
                                        '</div>'+
                                        '<button class="btn btn-primary btn-border mt-3 me-1 float-sm-end" onclick="showInputPlus(this, '+item.people_adult+', '+item.people_child+','+item.no_of_rooms+', '+item.id+')">'+
                                            'Add Room'+
                                        '</button>'+
                                        '<div class="input-step mt-3 me-1 float-sm-end" style="display:none;">'+
                                            '<button type="button" class="minus" onclick="decrement(this, '+item.id+');">–</button>'+
                                            '<input type="number" class="product-quantity" value="0" min="0" max="5">'+
                                            '<button type="button" class="plus" onclick="increment(this, '+item.people_adult+', '+item.people_child+', '+item.no_of_rooms+', '+item.id+');">+</button>'+
                                        '</div>'+
                                    '</div>'+
                                    '<button class="btn btn-success btn-border mt-3 me-1 float-sm-end confirm-button" style="display:none;" onclick="confirmRoom(this, '+item.id+', \''+item.category+'\', '+item.people_adult+', '+item.people_child+', '+room_price_rent+');">'+
                                            'Confirm'+
                                    '</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
            });
            $("#room_list_div").append(html)
            $("#loading_div").hide();
            $("#available_room_div").show();
            $("#date_range").text(check_in+'-'+check_out);
            $("#no_of_days").text((new Date(new Date(check_out) - new Date(check_in)))/1000/60/60/24);
        });
    }

    function getdateList(check_in, check_out){
        var dateList = [];
        check_in = new Date(check_in);
        check_out = new Date(check_out);
        console.log(check_out)
        for(check_in = check_in; check_in <check_out; check_in.setDate(check_in.getDate() + 1)){
            var date = check_in.getFullYear()+'-'+pad(check_in.getMonth()+1, 2)+'-'+pad(check_in.getDate(), 2);
            dateList.push(date);
        }
        return dateList;
    }
    function pad(str, max) {
      str = str.toString();
      return str.length < max ? pad("0" + str, max) : str;
    }



    function showInputPlus(element, people_adult, people_child, no_of_rooms, id){
        $(element).hide();
        $(element).next().show();
        increment($(element).next().children().eq(2), people_adult, people_child, no_of_rooms, id);
        $(element).next().next().show();
    }

    function increment(element, people_adult, people_child, no_of_rooms, id){
        var value = $(element).prev().val();
        if(value >= no_of_rooms){
            alert('No more room available');
            return false;
        }
        $(element).prev().val(++value);
        createPeopleCount(element, people_adult, people_child, id);
        $(element).parent().parent().next().show();
    }

    function decrement(element, id){
        var value = $(element).next().val();
        
        if(value > 1){
            $(element).next().val(--value);
            $($(element).parent().parent().find($('.people-count'))).eq(value).remove();
            $(element).parent().parent().next().show();
        }
        else if(value == 1){
            $(element).next().val(--value);
            $(element).parent().hide();
            $($(element).parent().parent().find($('.people-count'))).eq(0).remove();
            $(element).parent().prev().show();
            $("#"+id).remove();
            $(element).parent().parent().next().hide();
            if($("#booked_room").children().length == 0){
                $("#summary_div").hide();
            }
            room_categories = room_categories.filter(function(elem){
               return elem != id; 
            });
            finalPrice();
        }
    }

    function createPeopleCount(element, people_adult, people_child, id){
        var numItems = $(element).prev().val();
        var html = '<div class="row me-1 pt-2 w-100 people-count">'+
                        '<div class="col-sm-2">'+
                            '<b>Room '+numItems+'</b>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            'Adults(12+) &nbsp'+
                            '<select name="people_adult_'+id+'[]" required>'+
                                '<option value="">Select</option>';
        
        for(var i=1; i<=people_adult;i++){
            html += '<option value="'+i+'">'+i+'</option>'
        }

        html += '</select>'+
                    '</div>'+
                    '<div class="col-sm-4">'+
                        'Child(0-10) &nbsp'+
                        '<select name="people_child_'+id+'[]" required>'+
                            '<option value="">Select</option>';

        for(var i=1; i<=people_child;i++){
            html += '<option value="'+i+'">'+i+'</option>'
        }

        html += '</select>'+'</div>'+'</div>';
        $(element).parent().parent().append(html);
        $(element).parent().parent().next().show();
    }


    function confirmRoom(element, id, category, room_people_adult, room_people_child, room_price){
        if(room_categories.indexOf(id) == -1){
            room_categories.push(id);
        }
        var num_of_rooms = $(element).prev().find('.product-quantity').val();
        var people_adult = $("select[name='people_adult_"+id+"[]']").map(function(){ if($(this).val()!='') return $(this).val();}).get();
        var people_child = $("select[name='people_child_"+id+"[]']").map(function(){ if($(this).val()!='') return $(this).val();}).get();

        if(people_adult.length != num_of_rooms){
            alert('Please select number of adults in each room');
            return false;
        }
        if(people_child.length != num_of_rooms){
            alert('Please select number of children in each room');
            return false;
        }

        var total_people_adult = 0;
        for (var i = 0; i < people_adult.length; i++) {
            total_people_adult += parseInt(people_adult[i]);
        }
        var total_people_child = 0;
        for (var i = 0; i < people_child.length; i++) {
            total_people_child += parseInt(people_child[i]);
        }


        $(element).hide();
        var html = "";
        html += '<b style="color:#495057;margin-right: 10%;">'+category+':</b>'+ 
                    '<span>'+total_people_adult+' Adults '+total_people_child+' Children ('+num_of_rooms+' Room)</span>'+
                    '<div class="w-100 text-end" style="color: #8c68cd"> BDT&nbsp;<span class="room-rent">'+room_price*num_of_rooms +'</span></div>';

        if($('#'+id).length == 0){
            $("#booked_room").append('<div id="'+id+'"></div>');
        }
        else{
            $('#'+id).empty();
        }
        $("#"+id+"").append(html);
        $("#summary_div").show();
        finalPrice();
    }

    function finalPrice(){
        var final_price = 0;
        $('.room-rent').each(function(i, obj) {
            final_price += parseInt($(this).text());
        });
        $("#final_total").text("BDT "+final_price );
    }

    function bookNow(element){
        $('.confirm-button').each(function(i, obj) {
            if(!$(this).is(":hidden")){
                alert("Please confirm rooms");
                return false;
            }
        });
        $(element).prop("disabled",true);
        var booking_data = [];
        $.each(room_categories,function( key, value ) {
            var people_adult = $("select[name='people_adult_"+value+"[]']").map(function(){ if($(this).val()!='') return $(this).val();}).get();
            var people_child = $("select[name='people_child_"+value+"[]']").map(function(){ if($(this).val()!='') return $(this).val();}).get();
            var arr = [value, $("#"+value).children().eq(0).text() , people_adult, people_child, $("#"+value).find(".room-rent").text(), people_adult.length]
            booking_data.push(arr);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: 'book-room-temp',
            data: {
              check_in : check_in,
              check_out : check_out,
              booking_data : booking_data,
            },
            dataType: 'json',
        })
        .done(function (data) {
            $(element).prop("disabled",false);
            window.location.href = "./billing-info";
        });

    }
</script>
@endsection