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
                        <form action="{{URL::to('admin/room-category-rent/edit')}}/{{$rent->id}}" method="post">
                    
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Room Category</label>
                                </div>
                                <div class="col-lg-10">
                                    {{$rent->category}}
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Rent Date</label>
                                </div>
                                <div class="col-lg-10">
                                    {{date('d M, Y', strtotime($rent->rent_date))}}
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Price</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control <?php if($errors->has('price')) echo 'element-border';?>" id="price" name="price" value="{{old('price') ?? $rent->price}}" required>
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
                                    <input type="number" class="form-control <?php if($errors->has('discount')) echo 'element-border';?>" id="discount" name="discount" value="{{old('discount') ?? $rent->discount}}" required>
                                    @if($errors->has('discount'))
                                        <div class="input-error">{{ $errors->first('discount') }}</div>
                                    @endif
                                </div>
                                <div class="col-lg-4 d-flex align-items-center">
                                    (Percentage)
                                </div>
                            </div>

                            @if(checkButtonAccess('admin/room-category-rent/edit/{$roomCategory->id}'))
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
