@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Room Add</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Rooms</a></li>
                                <li class="breadcrumb-item active">Room Add</li>
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
                        <form action="{{URL::to('admin/rooms/add')}}" method="post" id="rooms_form">
                    
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Room Category</label>
                                </div>
                                <div class="col-lg-10">
                                    <select class="form-control <?php if($errors->has('room_category_id')) echo 'element-border';?>" id="room_category_id" name="room_category_id" required>
                                        <option value="">Select</option>
                                        @foreach($room_categories as $category)
                                        <option value="{{$category->id}}">{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('room_category_id'))
                                        <div class="input-error">{{ $errors->first('room_category_id') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">No Of Rooms</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control <?php if($errors->has('num_room')) echo 'element-border';?>" id="num_room" name="num_room" onkeyup="showRoomNumbers();" required>
                                    @if($errors->has('num_room'))
                                        <div class="input-error">{{ $errors->first('num_room') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3" id="room_numbers_div" style="display: none;">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Room Numbers</label>
                                </div>
                                <div class="col-lg-10">
                                </div>
                            </div>

                            @if(checkButtonAccess('rooms/add'))
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Rooms</button>
                            </div>
                            @endif
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- end main content-->
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {

        $("form").submit(function(){
            if(checkDuplicate()){
                Swal.fire(
                  'Please check room numbers for duplicate values',
                  '',
                  'error'
                );
                return false;
            }
        });
    });

    function showRoomNumbers(){
        $(".input-error").empty();
        $(".input-error").hide();
        var no_of_rooms = $("#num_room").val();
        $("#room_numbers_div").children().eq(1).empty();
        $("#room_numbers_div").show();
        for(var i=0; i<no_of_rooms; i++){
            $("#room_numbers_div").children().eq(1).append('<input type="text" name="room_numbers[]" style="width:10%;margin-bottom:10px;margin-right:10px" onchange="checkDuplicate();" required>');
        }
    }

    function checkDuplicate(){
        var room_numbers = $("input[name='room_numbers[]']").map(function(){return $(this).val();}).get();
        var room_numbers = room_numbers.sort(); 
        var length = room_numbers.length;
        $(".input-error").remove();
                
        var duplicate = 0;
        for (var i = 0; i < length - 1; i++) {
            if(room_numbers[i] != '' && (room_numbers[i + 1] == room_numbers[i])){
                $("#room_numbers_div").children().eq(1).append('<div class="input-error">Please check room numbers for duplicate values</div>');
                duplicate = 1;
                break;
            }
        }
        return duplicate;
    }


    // function saveRooms(){
    //     if(!checkDuplicate()){
    //         $("#rooms_form").submit();
    //     }
    // }
</script>
@endsection