@extends('frontend.layouts.master')
@section('title', 'Register')
@section('meta_description', '')

@section('content')
<section class="register-section">
<div class="container">
    <div class="row">
        <div class="col-md-7 m-auto">
           @session('success')
           <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
           >
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
           
            <strong>
                {{ session('success') }}
            </strong>
           </div>
           @endsession

           @session('error')
           <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
           >
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
           
            <strong>
                {{ session('error') }}
            </strong>
           </div>
           @endsession

            <div class="card rounded-0 shadow-lg">
                <div class="card-header rounded-0 bg-warning"><h5 class="mt-2">Create an account</h5></div>
                <div class="card-body">
                <form action="{{ route('register')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" value="{{ old('name')}}" id="name" name="name" placeholder="Enter name" required>
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3 col">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{ old('email')}}"  id="email" name="email" placeholder="Enter email" required>
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="number" class="form-control" value="{{ old('phone')}}"  id="phone" name="phone" placeholder="Enter phone number" required>
                        @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="mb-3 col position-relative">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="**********" required>
                                <span class="input-group-text bg-light" id="togglePassword" style="cursor: pointer;">
                                    <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                </span>
                            </div>
                            @error('password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3 col position-relative">
                            <label for="cpassword" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="cpassword" name="password_confirmation" placeholder="**********" required>
                                <span class="input-group-text bg-light" id="toggleCPassword" style="cursor: pointer;">
                                    <i class="fa fa-eye" id="toggleCPasswordIcon"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary b-block px-5 py-2 rounded-0">Register</button>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('loginView')}}">If you are already a user, Login Here!</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<!-- Password Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Password field toggle
        const passwordField = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            togglePasswordIcon.classList.toggle('fa-eye');
            togglePasswordIcon.classList.toggle('fa-eye-slash');
        });

        // Confirm Password field toggle
        const cPasswordField = document.getElementById('cpassword');
        const toggleCPassword = document.getElementById('toggleCPassword');
        const toggleCPasswordIcon = document.getElementById('toggleCPasswordIcon');

        toggleCPassword.addEventListener('click', function () {
            const type = cPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
            cPasswordField.setAttribute('type', type);
            toggleCPasswordIcon.classList.toggle('fa-eye');
            toggleCPasswordIcon.classList.toggle('fa-eye-slash');
        });
    });
</script>

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

@endsection
