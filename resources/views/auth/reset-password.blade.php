@extends('frontend.layouts.master')

@section('content')
<div class="container mt-5">
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

            <div class="card mt-5">
                <div class="card-header bg-primary"><h5>Reset Password  <a href="{{ route('loginView')}}" class="btn btn-dark btn-sm float-end">Back</a></h5></div>
                <div class="card-body">
                <form action="{{ route('resetPassword')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control"  id="password" name="password" placeholder="Enter New Password" required>
                        <input type="hidden" name="id" value="{{$user->id}}">
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control"   id="cpassword" name="password_confirmation" placeholder="Enter confirm password" required>
                        @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    </div>
                </form>

               
                </div>
            </div>


        </div>
    </div>
</div>
    
@endsection