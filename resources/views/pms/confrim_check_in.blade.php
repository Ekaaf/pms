@extends('layout.master')

@section('content')

<div class="page-content">
	<div class="container-fluid">
		@include('layout.message')

		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					@if(isset($bookingData) && count($bookingData) > 0)
					<!-- Booking Summary -->
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
											<span id="date_range">{{ $bookingData[0]->from_date }} - {{ $bookingData[0]->to_date }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Nights:</b>
											<span id="no_of_days">{{ $bookingData[0]->nights }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Room IDs:</b>
											<span id="room_ids">
												@foreach($bookingData as $data)
												{{ $data->room_id }}@if(!$loop->last), @endif
												@endforeach
											</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Total:</b>
											<b class="float-end" style="font-size: 20px;color: #8c68cd" id="final_total">{{ $bookingData[0]->final_price }}</b>
										</li>
									</ul>                                    
								</div>
							</div>
						</div>
						<!-- Identity Information -->
						<div class="col-sm-6">
							<div class="card">
								<div class="card-header">
									<h4 class="card-header align-items-center d-flex">Identity Information</h4>
								</div>
								<div class="card-body" id="summary_div">
									<ul class="list-group">
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Identity:</b>
											<span id="identity">{{ $bookingData[0]->identity }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Identity Number:</b>
											<span id="identity_number">{{ $bookingData[0]->identity_number }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Date of Birth:</b>
											<span id="dob">{{ $bookingData[0]->dob }}</span>
										</li>
										<li class="list-group-item">
											<b style="color:#495057;margin-right: 10%;">Expire Date:</b>
											<span id="expire_date">{{ $bookingData[0]->expire_date }}</span>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					@else
					<p>No booking data available.</p>
					@endif

					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header d-flex justify-content-between align-items-center">
									<h4 class="card-title mb-0 text-center">Add Identity Information</h4>
									<button type="button" class="btn btn-success" onclick="addIdentityInfoBox();">+</button>
								</div>
								<div class="card-body">
									<form id="identity_form"> 
										@csrf
										<div id="identity_info_container">
											<!-- Dynamic Identity Info Forms will be appended here -->
										</div>
										<div class="mt-3">
											<div class="col-xxl-3 col-md-6">
												<div>
													<label for="check_in_date" class="form-label">Check-in Date:</label>
													<input type="date" class="form-control" id="check_in_date">
												</div>
											</div>
											<div class="button-group mt-3">
												<button type="submit" class="btn btn-primary">Save Identity Information</button>
												<button type="button" class="btn btn-danger" onclick="cancel();">Cancel</button>
											</div>
										</div>
									</form>
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
	document.addEventListener('DOMContentLoaded', function() {
        // Calculate the current date in the Bangladesh Standard Time (BST) timezone
		var now = new Date();
        var offset = 6 * 60; // BST is UTC +6 hours
        var bangladeshTime = new Date(now.getTime() + offset * 60 * 1000);

        var year = bangladeshTime.getUTCFullYear();
        var month = ('0' + (bangladeshTime.getUTCMonth() + 1)).slice(-2); // Months are zero-based
        var day = ('0' + bangladeshTime.getUTCDate()).slice(-2);

        var todayInBST = year + '-' + month + '-' + day;
        document.getElementById("check_in_date").value = todayInBST;
    });

	function cancel() {
		alert("Cancel clicked");
        // Add your cancel logic here
	}

	function addIdentityInfoBox() {
		var identityInfoContainer = document.getElementById("identity_info_container");
		var identityBoxCount = identityInfoContainer.children.length;
		var newIdentityBox = `
		<div class="row gy-4 mt-2" id="identity_box_${identityBoxCount}">
			<h4 style="color:#8c68cd;">Identity Information</h4>			
			<div class="col-xxl-3 col-md-6">
				<div>
					<label for="identity_${identityBoxCount}" class="form-label">Identity</label>
					<select class="form-control" id="identity_${identityBoxCount}" name="identity[${identityBoxCount}]" onchange="showExpireDiv(${identityBoxCount});">
						<option value>Select</option>
						<option value='passport'>Passport</option>
						<option value='driving_license'>Driving License</option>
						<option value='nid'>National ID</option>
					</select>
				</div>
			</div>

			<div class="col-xxl-3 col-md-6">
				<div>
					<label for="identity_number_${identityBoxCount}" class="form-label">Number</label>
					<input type="text" class="form-control" id="identity_number_${identityBoxCount}" name="identity_number[${identityBoxCount}]" placeholder="Enter Number">
				</div>
			</div>

			<div class="col-xxl-3 col-md-6" id="expire_date_div_${identityBoxCount}">
				<div>
					<label for="expire_date_${identityBoxCount}" class="form-label">Expiry Date</label>
					<input type="date" class="form-control" id="expire_date_${identityBoxCount}" name="expire_date[${identityBoxCount}]">
				</div>
			</div>

			<div class="col-xxl-3 col-md-6">
				<div>
					<label for="dob_${identityBoxCount}" class="form-label">Date of Birth</label>
					<input type="date" class="form-control" id="dob_${identityBoxCount}" name="dob[${identityBoxCount}]">
				</div>
			</div>

			<div class="col-xxl-3 col-md-6">
				<div>
					<label for="nationality_${identityBoxCount}" class="form-label">Nationality</label>
					<select class="form-control" id="nationality_${identityBoxCount}" name="nationality[${identityBoxCount}]">
						<option value="">Select</option>
						<option value="Bangladesh">Bangladesh</option>
						<!-- Add more countries as needed -->
					</select>
				</div>
			</div>
			<button type="button" class="btn btn-danger" onclick="removeIdentityInfoBox(${identityBoxCount});">Remove</button>
		</div>
		`;
		identityInfoContainer.insertAdjacentHTML('beforeend', newIdentityBox);

        // Add validation rules for the new identity info box
        addValidationRules(identityBoxCount);
	}

	function removeIdentityInfoBox(index) {
		var identityBox = document.getElementById(`identity_box_${index}`);
		identityBox.remove();
        // Reinitialize validation after removing a box
        reinitializeValidation();
	}

	function showExpireDiv(count) {
		var identitySelect = document.getElementById(`identity_${count}`);
		var expireDateDiv = document.getElementById(`expire_date_div_${count}`);
		if (identitySelect.value === "passport" || identitySelect.value === "driving_license") {
			expireDateDiv.style.display = "block";
		} else {
			expireDateDiv.style.display = "none";
		}
	}

    function addValidationRules(index) {
        $(`#identity_${index}`).rules("add", {
            required: true
        });
        $(`#identity_number_${index}`).rules("add", {
            required: true
        });
        $(`#expire_date_${index}`).rules("add", {
            required: true
        });
        $(`#dob_${index}`).rules("add", {
            required: true
        });
        $(`#nationality_${index}`).rules("add", {
            required: true
        });
    }

    function reinitializeValidation() {
        var validator = $('#identity_form').validate();
        validator.destroy();
        validator = $('#identity_form').validate({
            rules: getValidationRules(),
            messages: {},
            errorElement: 'div',
            errorElementClass: 'element-border',
            errorClass: 'input-error',
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(this.settings.errorElementClass).removeClass(errorClass);
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    }

    function getValidationRules() {
        var rules = {};
        var identityInfoContainer = document.getElementById("identity_info_container");
        var identityBoxCount = identityInfoContainer.children.length;

        for (var i = 0; i < identityBoxCount; i++) {
            rules[`identity[${i}]`] = "required";
            rules[`identity_number[${i}]`] = "required";
            rules[`expire_date[${i}]`] = "required";
            rules[`dob[${i}]`] = "required";
            rules[`nationality[${i}]`] = "required";
        }
        return rules;
    }

    $(document).ready(function() {
        reinitializeValidation();
    });
</script>
@endsection
