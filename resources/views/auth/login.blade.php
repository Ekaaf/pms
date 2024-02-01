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
                            <div>
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p class="text-muted">Sign in to continue to Velzon.</p>
                            </div>

                            <div class="mt-4">
                                <form class="needs-validation" novalidate action="{{URL::to('post-login')}}" method="post" id="login-form">
                                    @csrf
                                    @if($errors->any())
                                        {!!formErrorMessage($errors)!!}
                                    @endif
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                                        <div class="invalid-feedback">
                                            {{inputErrorMessage('email')}}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="{{URL::to('forget-password')}}" class="text-muted">Forgot password?</a>
                                        </div>
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password" name="password">
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                        <div class="invalid-feedback">
                                            {{inputErrorMessage('password')}}
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="remember">
                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                        </div>

                                        <div>
                                            <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="mt-5 text-center">
                                <p class="mb-0">Don't have an account ? <a href="{{URL::to('signup')}}" class="fw-semibold text-primary text-decoration-underline"> Signup</a> </p>
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
<!-- password-addon init -->
<!-- <script src="assets/js/pages/password-addon.init.js"></script> -->
<script src="{{asset('assets/js/pages/form-validation.init.js')}}"></script>
<!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
 -->
 <script>
    $(document).ready(function(){
    });
    // $("#login-form" ).validate({
    //     errorClass: "input-error",
    //     rules:{
    //         email: {
    //             required: true
    //         },
    //         password: {
    //             required: true
    //         }
    //     },
    //     messages: {
    //     },
    // });
</script>
@endsection