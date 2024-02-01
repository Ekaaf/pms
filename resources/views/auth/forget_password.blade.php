@extends('auth_layout.auth_master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card overflow-hidden card-bg-fill border-0 card-border-effect-none">
                <div class="row g-0">
                    @include('auth_layout.auth_cover')

                    <div class="col-lg-6">
                        <div class="p-lg-5 p-4">
                            <h5 class="text-primary">Forgot Password?</h5>
                            <p class="text-muted">Reset password with velzon</p>

                            <div class="mt-2 text-center">
                                <lord-icon
                                    src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#8c68cd" class="avatar-xl">
                                </lord-icon>
                            </div>

                            <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                                Enter your email and instructions will be sent to you!
                            </div>
                            <div class="p-2">
                                <form>
                                    <div class="mb-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email address">
                                    </div>

                                    <div class="text-center mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Send Reset Link</button>
                                    </div>
                                </form><!-- end form -->
                            </div>

                            <div class="mt-5 text-center">
                                <p class="mb-0">Wait, I remember my password... <a href="{{URL::to('login')}}" class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

    </div>
    <!-- end row -->
</div>

@endsection

@section('script')
@endsection