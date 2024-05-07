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
                <form id="billing_form" method="post" action="{{URL::to('admin/confirm-booking')}}">
                @csrf
                <div class="row">
                    <div class="col-sm-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0 text-center">Booking Summary</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-check form-radio-primary mb-1">
                                            <input class="form-check-input" type="radio" name="user_type" id="type1" value="existing_user" onclick="showBookingDiv($(this).val());">
                                            <label class="form-check-label" for="type1">
                                                Existing User
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check form-radio-primary mb-1">
                                            <input class="form-check-input" type="radio" name="user_type" id="type2" value="new_user" onclick="showBookingDiv($(this).val());">
                                            <label class="form-check-label" for="type2">
                                                Create New User
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check form-radio-primary mb-1">
                                            <input class="form-check-input" type="radio" name="user_type" id="type3" value="guest_user" onclick="showBookingDiv($(this).val());">
                                            <label class="form-check-label" for="type3">
                                                Guest User
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5" id="existing_user_div" style="display:none;">
                                    <div class="col-lg-2">
                                        <label for="nameInput" class="form-label">Select Existing User</label>
                                    </div>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="user_id" name="user_id" onchange="getUserInfo();">
                                            <option value>Select</option>
                                            @foreach($customers as $customer)
                                                <option value='{{$customer->id}}'>{{$customer->email}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row gy-4 mt-5" id="existing_user_info_div" style="display:none;">
                                        <h4 style="color:#8c68cd;">User Basic Information</h4>
                                        <div class="col-xxl-2 col-md-2">
                                            <div>
                                                <label for="basiInput" class="form-label">Title: </label>
                                                <span id="title_text"></span>
                                            </div>
                                        </div>


                                        <div class="col-xxl-5 col-md-5">
                                            <div>
                                                <label for="basiInput" class="form-label">First Name: </label>
                                                <span id="first_name_text"></span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-5 col-md-5">
                                            <div>
                                                <label for="basiInput" class="form-label">Last Name: </label>
                                                <span id="last_name_text"></span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-md-2">
                                            <div>
                                                <label for="basiInput" class="form-label">Gender: </label>
                                                <span id="gender_text"></span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-5 col-md-5">
                                            <div>
                                                <label for="basiInput" class="form-label">Email: </label>
                                                <span id="email_text"></span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-5 col-md-5">
                                            <div>
                                                <label class="form-label">Mobile Number: </label>
                                                <span id="mobile_text"></span>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="col-xxl-8 col-md-8">
                                            <div>
                                                <label for="basiInput" class="form-label">Address: </label>
                                                <span id="address_text"></span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-md-6">
                                            <div>
                                                <label for="basiInput" class="form-label">City: </label>
                                                <span id="city_text"></span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-md-6">
                                            <div>
                                                <label for="basiInput" class="form-label">Zip/Post Code: </label>
                                                <span id="postal_code_text"></span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-md-6">
                                            <div>
                                                <label for="basiInput" class="form-label">State: </label>
                                                <span id="state_text"></span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-md-6">
                                            <div>
                                                <label for="basiInput" class="form-label">Country: </label>
                                                <span id="country_text"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row gy-4 mt-5" id="new_user_div" style="display:none">
                                    <h4 style="color:#8c68cd;">User Basic Information</h4>
                                    <div class="col-xxl-2 col-md-2">
                                        <div>
                                            <label for="basiInput" class="form-label">Title</label>
                                            <select class="form-control" id="title" name="title">
                                                <option value>Select</option>
                                                <option value='Mr.'>Mr.</option>
                                                <option value='Mrs.'>Mrs.</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-5 col-md-5">
                                        <div>
                                            <label for="basiInput" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-xxl-5 col-md-5">
                                        <div>
                                            <label for="basiInput" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-md-2">
                                        <div>
                                            <label for="basiInput" class="form-label">Gender</label>
                                            <select class="form-control" id="gender" name="gender">
                                                <option value>Select</option>
                                                <option value='Male.'>Male</option>
                                                <option value='Female'>Female</option>
                                                <option value='Others'>Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-5 col-md-5">
                                        <div>
                                            <label for="basiInput" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-xxl-5 col-md-5">
                                        <div>
                                            <label for="basiInput" class="form-label">Confirm Email</label>
                                            <input type="email" class="form-control" id="confirm_email" name="confirm_email" placeholder="Confirm Email">
                                        </div>
                                    </div>
                                    <div class="col-xxl-5 col-md-5">
                                        <div>
                                            <label class="form-label">Mobile Number</label>
                                            <div class="input-group" data-input-flag>
                                                <button class="btn btn-light border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{URL::to('assets/images/flags/bd.svg')}}" alt="flag img" height="20" class="country-flagimg rounded">
                                                    <span class="ms-2 country-codeno">+ 880</span>
                                                </button>
                                                <input type="text" class="form-control rounded-end flag-input" value="" placeholder="Enter number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                                <div class="dropdown-menu w-100">
                                                    <div class="p-2 px-3 pt-1 searchlist-input">
                                                        <input type="text" class="form-control form-control-sm border search-countryList" placeholder="Search country name or country code..." id="mobile" name="mobile" />
                                                    </div>
                                                    <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="col-xxl-8 col-md-8">
                                        <div>
                                            <label for="basiInput" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">City</label>
                                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter City">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">Zip/Post Code</label>
                                            <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter Zip/Post Code">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">State</label>
                                            <input type="text" class="form-control" id="state" name="state" placeholder="Enter State">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">Country</label>
                                            <select class="form-control" id="country" name="country">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>


                                <div class="row gy-4 mt-2" id="identity_div" style="display:none;">
                                    <h4 style="color:#8c68cd;">Identity Information</h4>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">Identity</label>
                                            <select class="form-control" id="identity" name="identity">
                                                <option value>Select</option>
                                                <option value='passport'>Passport</option>
                                                <option value='driving_license'>Driving License</option>
                                                <option value='nid'>National ID</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">Number</label>
                                            <input type="text" class="form-control" id="identity_number" name="identity_number" placeholder="Enter Number">
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">Expiry Date</label>
                                            <input type="date" class="form-control" id="expire_date" name="expire_date" placeholder="Enter Number">
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth">
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">Nationality</label>
                                            <select class="form-control" id="nationality" name="nationality">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0 text-center">Customer Details</h4>
                            </div>
                            <div class="card-body" id="summary_div">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <b style="color:#495057;margin-right: 10%;">Dates:</b> 
                                        <span id="date_range">{{$booking_data_temp['check_in']}}&nbsp; - &nbsp;{{$booking_data_temp['check_out']}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <b style="color:#495057;margin-right: 10%;">Nights:</b> 
                                        <span id="no_of_days">{{round((strtotime($booking_data_temp['check_out']) - strtotime($booking_data_temp['check_in'])) / (60 * 60 * 24))}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <?php $total = 0; ?>
                                        @foreach($booking_data_temp['booking_data'] as $book)
                                        <div>
                                            <b style="color:#495057;margin-right: 10%;">{{$book['room_category']}}:</b>
                                            <span>{{array_sum($book['people_adult'])}} Adults {{array_sum($book['people_adult'])}} Children ({{count($booking_data_temp['booking_data'])}} Room)</span>
                                            <div class="w-100 text-end" style="color: #8c68cd"> BDT&nbsp;
                                                <span class="room-rent">{{$book['room_price']}}</span>
                                            </div>
                                        </div>
                                        <?php $total += $book['room_price']; ?>
                                        @endforeach
                                    </li>
                                    <li class="list-group-item">
                                        <b style="color:#495057;margin-right: 10%;">Total:</b> 
                                        <b class="float-end" style="font-size: 20px;color: #8c68cd" id="final_total">{{$total}}</b>
                                    </li>
                                </ul>
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100">Pay Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            
            <!-- End Page-content -->

        <!-- end main content-->
@endsection

@section('script')
<script src="{{asset('assets/js/pages/flag-input.init.js')}}"></script>
<script>
    $( document ).ready(function() {
        $.getJSON(baseUrl+"assets/json/country-list.json", function (data){
            var options = '';
            $.each(data, function (key, value){
                options += '<option value="'+value.countryName+'">'+value.countryName+'</option>';
            });

            $('#country').append(options);
            $('#country').select2();
            $('#country').val('Bangladesh').trigger('change');

            $('#nationality').append(options);
            $('#nationality').select2();
            $('#nationality').val('Bangladesh').trigger('change');
        });


        $("#billing_form").validate({
            rules: {
                user_type: "required",
                title: "required",
                // title: {
                //     required: function() {
                //         if($('input[name="user_type"]:checked').val() == 'new_user'){
                //             return 1;
                //         }
                //     }
                // },
                first_name: "required",
                last_name: "required",
                gender: "required",
                email: "required",
                confirm_email: "required",
                mobile: "required",
                address: "required",
                city: "required",
                postal_code: "required",
                state: "required",
                country: "required",
                identity: "required",
                identity_number: "required",
                expire_date: "required",
                dob: "required",
                nationality: "required"
            },
            // Specify validation error messages
            messages: {
            },
            errorElement: 'div',
            errorElementClass: 'element-border',
            errorClass: 'input-error',
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(this.settings.errorElementClass).removeClass(errorClass);
            },
            errorPlacement: function(error, element) {
                // if (element.attr("name") == "menu_path" ) {
                //     error.insertAfter("#pathDiv");
                // }
                // else{
                //     error.insertAfter(element);
                // }
                error.insertAfter(element);
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });


    function showBookingDiv(type){
        $("#identity_div").show();
        $("#existing_user_info_div").hide();
        if(type == 'existing_user'){
            $("#existing_user_div").show();
            $("#new_user_div").hide();
        }
        else{
            $("#existing_user_div").hide();
            $("#new_user_div").show();
            
        }
    }


    function getUserInfo(){
        var user_id = $("#user_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: 'get-user-info',
            data: {
              user_id : user_id
            },
            dataType: 'json',
        })
        .done(function (data) {
            $("#title_text").text(data.title);
            $("#first_name_text").text(data.first_name);
            $("#last_name_text").text(data.last_name);
            $("#email_text").text(data.email);
            $("#gender_text").text(data.gender);
            $("#mobile_text").text(data.mobile);
            $("#address_text").text(data.address);
            $("#city_text").text(data.city);
            $("#state_text").text(data.state);
            $("#country_text").text(data.country);
            $("#postal_code_text").text(data.postal_code);
            $("#existing_user_info_div").show();
        });
    }
</script>
@endsection