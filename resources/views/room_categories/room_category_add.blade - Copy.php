@extends('layout.master')

@section('content')
    <link rel="stylesheet" href="{{asset('assets/libs/filepond/filepond.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Room Category Add {{session('count');}}</h4>

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
                        <form action="{{URL::to('admin/room-category/add')}}" method="post">
                    
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Room Category</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control <?php if($errors->has('category')) echo 'element-border';?>" id="category" name="category" placeholder="Room Category">
                                    @if($errors->has('category'))
                                        <div class="input-error">{{ $errors->first('category') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Room Size</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="number" class="form-control <?php if($errors->has('size')) echo 'element-border';?>" id="size" name="size" placeholder="Room Size">
                                    @if($errors->has('size'))
                                        <div class="input-error">{{ $errors->first('size') }}</div>
                                    @endif
                                </div>
                                <div class="col-lg-4 d-flex align-items-center">
                                    (Size in Sqaure Feet)
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Adult</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control <?php if($errors->has('people_adult')) echo 'element-border';?>" id="people_adult" name="people_adult" placeholder="Number of Adult People">
                                    @if($errors->has('size'))
                                        <div class="input-error">{{ $errors->first('people_adult') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Child</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control <?php if($errors->has('people_child')) echo 'element-border';?>" id="people_child" name="people_child" placeholder="Number of Child">
                                    @if($errors->has('people_child'))
                                        <div class="input-error">{{ $errors->first('people_child') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Bed</label>
                                </div>
                                <div class="col-lg-10">
                                    <select class="form-control <?php if($errors->has('bed')) echo 'element-border';?>" id="bed" name="bed">
                                        <option value="">Select bed</option>
                                        @foreach($bedList as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('bed'))
                                        <div class="input-error">{{ $errors->first('bed') }}</div>
                                    @endif
                                </div>
                            </div>
                            

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Price</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control <?php if($errors->has('price')) echo 'element-border';?>" id="price" name="price" placeholder="Price">
                                    @if($errors->has('size'))
                                        <div class="input-error">{{ $errors->first('price') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Discount</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="number" class="form-control <?php if($errors->has('discount')) echo 'element-border';?>" id="discount" name="discount" placeholder="Discount">
                                    @if($errors->has('discount'))
                                        <div class="input-error">{{ $errors->first('discount') }}</div>
                                    @endif
                                </div>
                                <div class="col-lg-4 d-flex align-items-center">
                                    (Percentage)
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Thumb Image</label>
                                </div>
                                <div class="col-lg-10">
                                    <div id="thumb_preview_div" style="position: relative; margin-bottom: 1.5%;">
                                        <img class="img-thumbnail" alt="200x200" width="200" id="thumb_preview" src="{{URL::to('images/no-img.jpg')}}" >
                                        <button type="button" class="btn btn-danger waves-effect waves-light" style="position: absolute; bottom: 0; margin-left: 1.5%; display: none;" id="remove_image_button" onclick="removeImage('#thumb_preview', '#thumb_image', '#remove_image_button');">
                                            <i class="ri-delete-bin-6-line"></i>
                                        </button>
                                    </div>
                                    <input type="file" class="form-control <?php if($errors->has('discount')) echo 'element-border';?>" id="thumb_image" name="thumb_image" placeholder="thumb_image">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Other Images</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="file" class="my-pond" id="other_image" name="filepond"/>
                                    <!-- <input type="file" class="filepond filepond-input-multiple" multiple name="filepond" data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3"> -->
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Description</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea class="form-control <?php if($errors->has('description')) echo 'element-border';?>" id="description" name="description"></textarea>
                                    @if($errors->has('description'))
                                        <div class="input-error">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                            </div>
                            


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Package</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea class="form-control <?php if($errors->has('package')) echo 'element-border';?>" id="package" name="package"></textarea>
                                    @if($errors->has('package'))
                                    <div class="input-error">{{ $errors->first('package') }}</div>
                                @endif
                                </div>
                            </div>
                            

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Facilities</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea class="form-control <?php if($errors->has('facilities')) echo 'element-border';?>" id="facilities" name="facilities"></textarea>
                                    @if($errors->has('facilities'))
                                        <div class="input-error">{{ $errors->first('facilities') }}</div>
                                    @endif
                                </div>
                            </div>
                            


                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Check In Time</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control <?php if($errors->has('check_in')) echo 'element-border';?>" id="check_in" name="check_in" placeholder="Check In Time">
                                    @if($errors->has('check_in'))
                                        <div class="input-error">{{ $errors->first('check_in') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Check Out Time</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control <?php if($errors->has('check_out')) echo 'element-border';?>" id="check_out" name="check_out" placeholder="Check Out Time">
                                    @if($errors->has('check_out'))
                                        <div class="input-error">{{ $errors->first('check_out') }}</div>
                                    @endif
                                </div>
                            </div>
                            

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Check In Instructions</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea class="form-control <?php if($errors->has('check_in_instruction')) echo 'element-border';?>" id="check_in_instruction" name="check_in_instruction" placeholder="Check In Instructions">
                                    </textarea> 
                                    @if($errors->has('check_in_instruction'))
                                        <div class="input-error">{{ $errors->first('check_in_instruction') }}</div>
                                    @endif
                                </div>
                            </div>
                            

                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="nameInput" class="form-label">Cancellation Policy</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea class="form-control <?php if($errors->has('cancellation_policy')) echo 'element-border';?>" id="cancellation_policy" name="cancellation_policy" placeholder="Cancellation Policy">
                                    </textarea>
                                    @if($errors->has('cancellation_policy'))
                                        <div class="input-error">{{ $errors->first('cancellation_policy') }}</div>
                                    @endif
                                </div>
                            </div>


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
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script> -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/super-build/ckeditor.js"></script>
<script src="{{asset('assets/custom/js/ckeditorinit.js')}}"></script>
<script src="{{asset('assets/libs/filepond/filepond.min.js')}}"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script src="{{asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js')}}"></script>
<script src="{{asset('assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js')}}"></script>
<script src="{{asset('assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js')}}"></script>
<script src="{{asset('assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js')}}"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        initializeCkEditor('description', '');
        initializeCkEditor('package', '');
        initializeCkEditor('facilities', '');
        initializeCkEditor('check_in_instruction', '');
        initializeCkEditor('cancellation_policy', '');


    });
    // FilePond.registerPlugin(FilePondPluginFileValidateSize);
    FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginImagePreview);
    $('.my-pond').filepond({
            allowMultiple: true,
            maxFileSize: '10MB',
            acceptedFileTypes: ['image/*']
        }
    );
    $("#thumb_image").change(function() {
        readURL(this, '#thumb_preview');
        $("#remove_image_button").show();
    });
</script>
@endsection