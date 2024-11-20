@extends('frontend.layouts.master')
@section('title', 'Login')
@section('meta_description', '')
@section('content')
<section class="login-section">
<div class="container">
    <div class="row">
        <div class="col-md-4 m-auto">

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

            <div class="card mt-5 shadow-lg rounded-0">
                <div class="card-header bg-warning "><h4>Login</h4></div>
                <div class="card-body">
                <form action="{{ route('login')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ old('email')}}"  id="email" name="email" placeholder="Enter email" required>
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control"  id="password" name="password" placeholder="**********" required>
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
                    <a href="{{ route('registerView')}}" class="text-center d-block">If you are new User Create Account!</a>
                </div>
                
                </div>
            </div>


        </div>
    </div>
</div>
</section>
    
@endsection