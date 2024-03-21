@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Room Category Add</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Room Category</a></li>
                                <li class="breadcrumb-item active">Room Category Add</li>
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
                        <form action="{{URL::to('room-category/add')}}" method="post">
                    
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Room Category</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="category" name="category" placeholder="Room Category">
                                </div>
                            </div>
                            @if($errors->has('category'))
                                <div class="error">{{ $errors->first('category') }}</div>
                            @endif


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Room Size</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="size" name="size" placeholder="Room Size">
                                </div>
                                <div class="col-lg-4 d-flex align-items-center">
                                    (Size in Sqaure Feet)
                                </div>
                            </div>
                            @if($errors->has('size'))
                                <div class="error">{{ $errors->first('size') }}</div>
                            @endif


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Adult</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="people_adult" name="people_adult" placeholder="Number of Adult People">
                                </div>
                            </div>
                            @if($errors->has('people_adult'))
                                <div class="error">{{ $errors->first('people_adult') }}</div>
                            @endif


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Child</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="people_child" name="people_child" placeholder="Number of Child">
                                </div>
                            </div>
                            @if($errors->has('people_child'))
                                <div class="error">{{ $errors->first('people_child') }}</div>
                            @endif


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Bed</label>
                                </div>
                                <div class="col-lg-10">
                                    <select class="form-control" id="bed" name="bed">
                                        <option value="">Select bed</option>
                                    </select>
                                </div>
                            </div>
                            @if($errors->has('bed'))
                                <div class="error">{{ $errors->first('bed') }}</div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Description</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                            </div>
                            @if($errors->has('description'))
                                <div class="error">{{ $errors->first('description') }}</div>
                            @endif


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Package</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="package" name="package"></textarea>
                                </div>
                            </div>
                            @if($errors->has('package'))
                                <div class="error">{{ $errors->first('package') }}</div>
                            @endif


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Facilities</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="facilities" name="facilities"></textarea>
                                </div>
                            </div>
                            @if($errors->has('facilities'))
                                <div class="error">{{ $errors->first('facilities') }}</div>
                            @endif


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Check In Time</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="check_in" name="check_in" placeholder="Check In Time">
                                </div>
                            </div>
                            @if($errors->has('check_in'))
                                <div class="error">{{ $errors->first('check_in') }}</div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Check Out Time</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="check_out" name="check_out" placeholder="Check Out Time">
                                </div>
                            </div>
                            @if($errors->has('check_out'))
                                <div class="error">{{ $errors->first('check_out') }}</div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Check In Instructions</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="check_in_instruction" name="check_in_instruction" placeholder="Check In Instructions">
                                    </textarea> 
                                </div>
                            </div>
                            @if($errors->has('check_in_instruction'))
                                <div class="error">{{ $errors->first('check_in_instruction') }}</div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Cancellation Policy</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="cancellation_policy" name="cancellation_policy" placeholder="Cancellation Policy">
                                    </textarea> 
                                </div>
                            </div>
                            @if($errors->has('cancellation_policy'))
                                <div class="error">{{ $errors->first('cancellation_policy') }}</div>
                            @endif




                            @if(checkButtonAccess('room-category/add'))
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Category</button>
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
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script src="{{asset('assets/custom/js/room_category.js')}}"></script>

<script type="text/javascript">
    

</script>
@endsection