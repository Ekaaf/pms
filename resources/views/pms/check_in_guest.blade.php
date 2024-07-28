@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Checn In Guest</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Checn In Guest</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php
            $check_in_guest = checkButtonAccess('admin/check-in/{id}');
        ?>

        @include('layout.message')

        <div class="row">
            <div class="col-xl-12">
                
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <b>Guest Name:</b> {{$data[0]->title}}&nbsp{{$data[0]->first_name}}&nbsp{{$data[0]->last_name}}
                            </div>
                            <div class="col-sm-3">
                                <b>Email:</b> {{$data[0]->email}}
                            </div>
                            <div class="col-sm-3">
                                <b>Mobile: </b> {{$data[0]->mobile}}
                            </div>
                            <div class="col-sm-3">
                                <b>No of Nights: </b> {{(int) (strtotime($data[0]->to_date) - strtotime($data[0]->from_date)) / (60 * 60 * 24);}}
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <b>From Date: </b> {{date_format(date_create($data[0]->from_date),"jS M, Y")}}
                            </div>
                            <div class="col-sm-3">
                                <b>To Date: </b> {{date_format(date_create($data[0]->to_date),"jS M, Y") }}
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered align-middle table-nowrap mb-0" >
                                <thead class="table-light">
                                    <tr>
                                        <th>Serial</th>
                                        <th>Room Category</th>
                                        <th>Room Number</th>
                                        <th style="width:35% !important;">No of people</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $total_adult = 0;
                                        $total_children = 0;
                                    ?>
                                    @foreach($data as $key=>$d)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$d['category']}}</td>
                                        <td>{{$d['room_number']}}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <div id="view_number_of_people_{{$d['booking_id']}}">
                                                        <b>Adults: </b><span id="view_adult_{{$d['booking_id']}}">{{$d['people_adult']}}</span>&nbsp
                                                        <b>Child: </b><span id="view_child_{{$d['booking_id']}}">{{$d['people_child']}}</span>
                                                    </div>
                                                    <div id="change_number_of_people_{{$d['booking_id']}}" style="display:none;">
                                                        <b>Adults: </b>Adults(12+)&nbsp
                                                        <select id="adult_{{$d['booking_id']}}" name="adult_{{$d['booking_id']}}" required>
                                                            @for($i=1; $i<=$d['max_adult']; $i++)
                                                            <option value="{{$i}}" <?php if($d['people_adult'] == $i) echo 'selected'; ?>>{{$i}}</option>;
                                                            @endfor
                                                        </select>
                                                        <b>Child: </b>Child(0-10)&nbsp
                                                        <select id="child_{{$d['booking_id']}}" name="child_{{$d['booking_id']}}" required>
                                                            @for($i=1; $i<=$d['max_child']; $i++)
                                                            <option value="{{$i}}" <?php if($d['people_child'] == $i) echo 'selected'; ?>>{{$i}}</option>;
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <b>Max: </b>Adults:{{$d['max_adult']}}&nbsp Child:{{$d['max_child']}}
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button type="button" class="btn btn-info" onclick="changeNoOfPeople({{$d['booking_id']}}, this);">Change</button>
                                                </div>
                                            </div>
                                            
                                        </td>
                                        <td>{{$d['total_price']}}</td>
                                    </tr>
                                    <?php 
                                        $total_adult += $d['people_adult'];
                                        $total_children += $d['people_child'];
                                    ?>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="row gy-4">
                            <div class="col-md-3">
                                <h4 style="color:#8c68cd;font-weight: bold;">Total Adult:<span id="total_adult">{{$total_adult}}</span></h4> 
                            </div>
                            <div class="col-md-3">
                                <h4 style="color:#8c68cd;font-weight: bold;">Total Children:<span id="total_children">{{$total_children}}</span></h4> 
                            </div>
                        </div>

                        <form id="form" method="post" action="{{URL::to('admin/check-in-complete')}}/{{Request::segment(3)}}"> 
                            @csrf
                            <div id="other_info_div">
                                
                            </div>
                        </form>

                        @if(checkButtonAccess('admin/users/add'))
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" onclick="confirmCheckIn();">Confirm Check In</button>
                        </div>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>

        <!-- end main content-->
@endsection

@section('script')

<script>
    var total_adult = {{$total_adult}};
    var total_children = {{$total_children}}
    $(document).ready(function() {
        createIdentityDiv({{$total_adult}});
    });

    function confirmCheckIn(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#form").append('<input type=\"text\" name=\"billing_id\" value=\"{{$data[0]->billing_id}}\">')
        $("#form").submit();
        
        // Swal.fire({
        //     title: 'Are you sure want to confirm booking ?',
        //     // text: "You won't be able to revert this!",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Yes, Confirm!'
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         // var form = '<form method=\"post\" action=\"{{URL::to("admin/check-in-complete")}}/{{Request::segment(3)}}\"> @csrf<input type=\"text\" name=\"billing_id\" value=\"{{$data[0]->billing_id}}\"></form>';
        //         $("#form").append('<input type=\"text\" name=\"billing_id\" value=\"{{$data[0]->billing_id}}\">')
        //         // console.log(form)
        //         // $('body').append(form);
        //         $("#form").submit();
        //     }
        // })
    }


    function changeNoOfPeople(booking_id, element){
        if($(element).text() == 'Change'){
            $("#view_number_of_people_"+booking_id).hide();
            $("#change_number_of_people_"+booking_id).show();
            $(element).text('Update');
        }
        else{
            // $("#view_number_of_people_"+booking_id).show();
            // $("#change_number_of_people_"+booking_id).hide();
            // $(element).text('Change');

            var adult = $("#adult_"+booking_id).val();
            var child = $("#child_"+booking_id).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '../check-in-change-people',
                data: {
                  booking_id : booking_id,
                  adult : adult,
                  child : child,
                },
                dataType: 'json',
            })
            .done(function (data) {
                if(data.status == 0){
                    alert(data.message);
                }
                else{
                    total_adult = parseInt(total_adult) - parseInt($("#view_adult_"+booking_id).text()) + parseInt(data.data.people_adult);
                    total_children = parseInt(total_children) - parseInt($("#view_child_"+booking_id).text()) + parseInt(data.data.people_child);
                    
                    $("#view_adult_"+booking_id).text(data.data.people_adult);
                    $("#view_child_"+booking_id).text(data.data.people_child);

                    $("#view_number_of_people_"+booking_id).show();
                    $("#change_number_of_people_"+booking_id).hide();
                    $(element).text('Change');

                    $("#total_adult").text(total_adult);
                    $("#total_children").text(total_children);
                    createIdentityDiv(total_adult);

                    alert(data.message);
                }
            });
        }
        
    }


    function showExpireDiv(count){
        if($("#identity_"+count).val() == 'nid'){
            $("#expire_date_div_"+count).hide();
        }
        else{
            $("#expire_date_div_"+count).show();
        }
    }

    function createIdentityDiv(total_adult){
        $("#other_info_div").empty();
        // var total_adult = {{$total_adult}} - 1;
        var html = "";

        for(var i=1; i<= total_adult-1; i++){
            html += '<div class="row gy-4 mt-2">'+
                        '<h4 style="color:#8c68cd;">Adult '+i+'</h4>'+
                        '<div class="col-md-2">'+
                            '<div class="mb-3">'+
                                '<label for="basiInput" class="form-label">Identity</label>'+
                                '<select class="form-control" id="identity_'+i+'" name="identity[]" onchange="showExpireDiv('+i+');" required>'+
                                    '<option value>Select</option>'+
                                    '<option value="passport">Passport</option>'+
                                    '<option value="driving_license">Driving License</option>'+
                                    '<option value="nid">National ID</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+

                        '<div class="col-md-3">'+
                            '<div class="mb-3">'+
                                '<label for="basiInput" class="form-label">Number</label>'+
                                '<input type="text" class="form-control" id="identity_number_'+i+'" name="identity_number[]"'+
                                'placeholder="Enter Number" required>'+
                            '</div>'+
                        '</div>'+

                        '<div class="col-md-2" id="expire_date_div_'+i+'">'+
                            '<div class="mb-3">'+
                                '<label for="basiInput" class="form-label">Expiry Date</label>'+
                                '<input type="date" class="form-control" id="expire_date_'+i+'" name="expire_date[]"'+ 
                                'placeholder="Enter Number">'+
                            '</div>'+
                        '</div>'+

                        '<div class="col-md-2">'+
                            '<div class="mb-3">'+
                                '<label for="basiInput" class="form-label">Date of Birth</label>'+
                                '<input type="date" class="form-control" id="dob_'+i+'" name="dob[]" placeholder="Date of Birth" required>'+
                            '</div>'+
                        '</div>'+

                        '<div class="col-md-3">'+
                            '<div class="mb-3">'+
                                '<label for="basiInput" class="form-label">Nationality</label>'+
                                '<select class="form-control" id="nationality_'+i+'" name="nationality[]" required>'+
                                    '<option value="">Select</option>'+
                                    '<option value="Bangladeshi">Bangladeshi</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
        }
        $("#other_info_div").append(html);
    }
</script>
@endsection