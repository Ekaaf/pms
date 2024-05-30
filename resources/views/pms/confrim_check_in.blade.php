@extends('layout.master')

@section('content')

<div class="page-content">
	<div class="container-fluid">


		<!-- container-fluid -->
		@include('layout.message')

		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					@if(isset($bookingData) && count($bookingData) > 0)
					@foreach($bookingData as $data)
					<div class="row">
						<div class="col-sm-6">
							<div class="card">
								<div class="card-header">
									<h4 class="card-header align-items-center d-flex">Booking Summary</h4>
								</div>
								<div class="card-body" id="summary_div">
									<ul class="list-group">
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Dates:</b>
											<span id="date_range">{{ $data->from_date }} - {{ $data->to_date }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Nights:</b>
											<span id="no_of_days">{{ $data->nights }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Room ID:</b>
											<span id="room_id">{{ $data->room_id }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Total:</b>
											<b class="float-end" style="font-size: 20px;color: #8c68cd" id="final_total">{{ $data->final_price }}</b>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card">
								<div class="card-header">
									<h4 class="card-header align-items-center d-flex">Identity Information</h4>
								</div>
								<div class="card-body" id="summary_div">
									<ul class="list-group">
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Identity:</b>
											<span id="identity">{{ $data->identity }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Identity Number:</b>
											<span id="identity_number">{{ $data->identity_number }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Date of Birth:</b>
											<span id="dob">{{ $data->dob }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Expire Date:</b>
											<span id="expire_date">{{ $data->expire_date }}</span>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-12 mt-3">
							<div class="button-group">
								<button type="button" class="btn btn-primary" onclick="checkIn(this, {{ $data->billing_id }});">Check In</button>
								<button type="button" class="btn btn-danger" onclick="cancel(this, {{ $data->billing_id }});">Cancel</button>
							</div>
						</div>
					</div>
					@endforeach
					@else
					<p>No booking data available.</p>
					@endif

					<div class="row" id="available_room_div">
						<div class="col-xl-12">
							<div class="card">
								<div class="card-header align-items-center d-flex">
									<h4 class="card-title mb-0 flex-grow-1">Available Rooms</h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-sm-12 pe-0" id="room_list_div">
											<!-- Room list content goes here -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@endsection
		@section('script')

		<script>
			function checkIn(button, billingId) {

			}

			function cancel(button, billingId) {
            // alert("Cancel clicked for billing ID: " + billingId);
            // Add your cancel logic here
				$.ajax({
					// type: 'GET',
			        // url: '/path/to/your/endpoint', // Update this to your actual endpoint
			        // data: { billing_id: billingId },
			        // success: function(response) {
		            // Append the date picker to the relevant container
		        	var container = '#datepicker-container-' + billingId;
		        	$(container).html('<input type="text" id="datepicker-' + billingId + '" class="datepicker">');
		        	$('#datepicker-' + billingId).datepicker();
        		},
        error: function(error) {
        	console.log(error);
        }
    });
			}
		</script>

		@endsection


