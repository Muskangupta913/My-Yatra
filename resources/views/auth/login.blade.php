@extends('frontend.layouts.master')
@section('title', 'Login')
@section('meta_description', '')
@section('content')
<section class="login-section">
<div class="container">
    <div class="row">
        <div class="col-md-4 m-auto">

           @session('success')
           <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ session('success') }}</strong>
           </div>
           @endsession

           @session('error')
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ session('error') }}</strong>
           </div>
           @endsession

            <div class="card mt-5 shadow-lg rounded-0">
                <div class="card-header bg-warning">
                    <h4>Login</h4>
                    <!-- Close Icon to dismiss the login form -->
                    <button type="button" class="btn-close" id="closeLoginForm" aria-label="Close" style="position: absolute; top: 10px; right: 10px;"></button>
                </div>
                <div class="card-body">
                <form action="{{ route('login')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ old('email')}}" id="email" name="email" placeholder="Enter email" required>
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="**********" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword" tabindex="-1">
                                <i class="fa fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                          Remember Me
                        </label>
                        <a href="{{ route('forgotView')}}" class="float-end">Forgot Password</a>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary rounded-0 w-100">Login</button>
                    </div>
                </form>
                
                <div class="mb-3">
                <a href="{{ route('registerView')}}" style="text-decoration: none; color: #007BFF; font-weight: bold; padding: 5px 10px; border: 1px solid #007BFF; border-radius: 5px; background-color: #f8f9fa;">
                Create Account!
             </a>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- FontAwesome script -->

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordField = document.getElementById('password');
        var passwordFieldType = passwordField.type;
        var eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordFieldType === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });

    // Close the login form and redirect to the home page when the close icon is clicked
    document.getElementById('closeLoginForm').addEventListener('click', function() {
        var loginForm = document.querySelector('.login-section');
        loginForm.style.display = 'none';  
        
        // Redirect to home page
        window.location.href = '/'; 
    });
</script>


@endsection
