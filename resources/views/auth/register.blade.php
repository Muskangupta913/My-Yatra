@extends('frontend.layouts.master')
@section('title', 'Register')
@section('meta_description', '')
@section('content')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<section class="register-section">
<div class="container">
    <div class="row">
        <div class="col-md-7 m-auto">
           @session('success')
           <div
            class="alert alert-success alert-dismissible fade show"
            role="alert">
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
                <div class="card-header rounded-0 bg-warning"><h5 class="mt-2">Create an account</h5>
                <button type="button" class="btn-close" id="closeLoginForm" aria-label="Close" style="position: absolute; top: 10px; right: 10px;"></button>
                </div>
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
                        <input type="number" class="form-control" value="{{ old('phone')}}"  id="phone" name="phone" placeholder="Enter phone Number" required>
                        @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
    <div class="mb-3 col position-relative">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="**********" required>
            <button class="btn btn-outline-secondary toggle-password" type="button">
                <i class="bi bi-eye-fill"></i>
            </button>
        </div>
        @error('password')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="mb-3 col position-relative">
        <label for="cpassword" class="form-label">Confirm Password</label>
        <div class="input-group">
            <input type="password" class="form-control" id="cpassword" name="password_confirmation" placeholder="**********" required>
            <button class="btn btn-outline-secondary toggle-password" type="button">
                <i class="bi bi-eye-fill"></i>
            </button>
        </div>
        @error('password_confirmation')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary b-block px-5 py-2 rounded-0  ">Register</button>
                    </div>
                    <div class="mb-3">
            <a href="{{ route('loginView')}}" style="text-decoration: none; color: #007BFF; font-weight: bold; padding: 5px 10px; border: 1px solid #007BFF; border-radius: 5px; background-color: #f8f9fa;">
               Login Here!
             </a>
        </div>

                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const inputGroup = this.closest('.input-group');
            const passwordInput = inputGroup.querySelector('input');
            const eyeIcon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye-fill');
                eyeIcon.classList.add('bi-eye-slash-fill');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash-fill');
                eyeIcon.classList.add('bi-eye-fill');
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var closeButton = document.getElementById('closeLoginForm');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            // Redirect to the home page
            window.location.href = '/';
        });
    } else {
        console.error('Close button not found');
    }
});
    </script>
@endsection