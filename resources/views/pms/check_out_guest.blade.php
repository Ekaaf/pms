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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Checn Out Guest</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php
            $check_in_guest = checkButtonAccess('admin/check-in/{id}');
        ?>
        
        @if(checkButtonAccess('admin/room-category-rent/add'))
        <div class="text-end">
            <a href="{{URL::to('admin/room-category/add')}}" class="btn btn-success btn-border">
                <i class="bx bx-add-to-queue"></i>&nbsp
                Add Room Category
            </a>
        </div>
        <br>
        @endif

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
                            <div class="col-sm-3">
                                <b>Check In Time: </b> {{date_format(date_create($data[0]->checked_in_time),"jS M, Y H:i:s") }}
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
                                        <th>No of people</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key=>$d)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$d['category']}}</td>
                                        <td>{{$d['room_number']}}</td>
                                        <td>
                                            <b>Adults: </b>{{$d['people_adult']}}&nbsp
                                            <b>Child: </b>{{$d['people_child']}}
                                        </td>
                                        <td>{{$d['total_price']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(checkButtonAccess('admin/users/add'))
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" onclick="confirmCheckOut();">Confirm Check Out</button>
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
    $(document).ready(function() {
    });

    function confirmCheckOut(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Swal.fire({
            title: 'Are you sure want to confirm check out?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Confirm!'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = '<form method=\"post\" action=\"{{URL::to("admin/check-out-complete")}}/{{Request::segment(3)}}\"> @csrf<input type=\"text\" name=\"billing_id\" value=\"{{$data[0]->billing_id}}\"></form>';
                console.log(form)
                $('body').append(form);
                $("form").submit();
            }
        })
    }
</script>
@endsection