@extends('layout.master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Booking Price Add</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Booking Price</a></li>
                                <li class="breadcrumb-item active">Booking Price Add</li>
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
                        <form action="{{URL::to('admin/room-category-rent/add')}}" method="post">
                    
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Booking Price</label>
                                </div>
                                <div class="col-lg-10">
                                    <select class="form-control <?php if($errors->has('room_category_id')) echo 'element-border';?>" id="room_category_id" name="room_category_id" required>
                                        <option value="">Select</option>
                                        @foreach($room_categories as $category)
                                        <option value="{{$category->id}}" <?php if(old('room_category_id') == $category->id) echo 'selected'; ?>>{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('room_category_id'))
                                        <div class="input-error">{{ $errors->first('room_category_id') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">From Date</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" data-provider="flatpickr" data-date-format="d M Y" class="form-control <?php if($errors->has('from_date')) echo 'element-border';?>" id="from_date" name="from_date" value="{{old('from_date')}}" required>
                                    @if($errors->has('from_date'))
                                        <div class="input-error">{{ $errors->first('from_date') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">To Date</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" data-provider="flatpickr" data-date-format="d M Y" class="form-control <?php if($errors->has('to_date')) echo 'element-border';?>" id="to_date" name="to_date" value="{{old('to_date')}}" required>
                                    @if($errors->has('to_date'))
                                        <div class="input-error">{{ $errors->first('to_date') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Price</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control <?php if($errors->has('price')) echo 'element-border';?>" id="price" name="price" value="{{old('price')}}" required>
                                    @if($errors->has('price'))
                                        <div class="input-error">{{ $errors->first('price') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Discount</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="number" class="form-control <?php if($errors->has('discount')) echo 'element-border';?>" id="discount" name="discount" value="{{old('discount')}}" required>
                                    @if($errors->has('discount'))
                                        <div class="input-error">{{ $errors->first('discount') }}</div>
                                    @endif
                                </div>
                                <div class="col-lg-4 d-flex align-items-center">
                                    (Percentage)
                                </div>
                            </div>

                            @if(checkButtonAccess('room-category/add'))
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Rent</button>
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
    });
</script>
@endsection
