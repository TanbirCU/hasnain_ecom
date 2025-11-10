
@extends('front/master/master')

@section('title')
    Business Login | Sole Bazer
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-center text-white py-4" 
                     style="background: linear-gradient(135deg, #007bff, #975cf4ff);">
                    <h4 class="mb-0">Welcome Back</h4>
                    <small>Login to your business account</small>
                </div>
                <div class="card-body p-4">
                    <form id="businessLoginForm">
                        @csrf
                        <div class="form-group">
                            <label for="login_id">Email or Mobile Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" name="login_id" id="login_id" 
                                       class="form-control" placeholder="Enter email or mobile number" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </div>
                                <input type="password" name="password" id="password" 
                                       class="form-control" placeholder="Enter your password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-3">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>

                        <div class="text-center mt-3">
                            <a href="#" class="text-primary small">Forgot Password?</a>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center text-muted small">
                    <p class="mb-0">
                        Don't have an account? 
                        <a href="{{ route('user.registration') }}" class="text-primary font-weight-bold">Register now</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function(){
    $('#businessLoginForm').on('submit', function(e){
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "",
            method: "POST",
            data: formData,
            beforeSend: function(){
                Swal.fire({
                    title: 'Checking...',
                    text: 'Verifying your credentials',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading() }
                });
            },
            success: function(response){
                Swal.fire({
                    icon: 'success',
                    title: 'Login Successful!',
                    text: 'Redirecting to your dashboard...',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    window.location.href = response.redirect ?? '/dashboard';
                }, 1600);
            },
            error: function(xhr){
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed!',
                    text: xhr.responseJSON?.message ?? 'Invalid credentials. Please try again.'
                });
            }
        });
    });
});
</script>
@endsection
