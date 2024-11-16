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
                <div class="card-header rounded-0 bg-warning"><h5 class="mt-2">Create an accounttt</h5></div>
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
                    <div class="mb-3 col">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control"  id="password" name="password" placeholder="**********" required>
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3 col">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control"  id="cpassword" name="password_confirmation" placeholder="**********" required>
                        @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary b-block px-5 py-2 rounded-0  ">Register</button>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('loginView')}}">If you are already User Login Here!</a>
                    </div>

                </form>
                </div>
            </div>


        </div>
    </div>
</div>
</section>
    
@endsection