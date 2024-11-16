@extends('frontend.layouts.master')
@section('styles')
<style>
    small{
    font-size: 13px;
    color: red;
    font-weight: bold;

    }
</style>
@endsection
@section('content')
  
<div class="container-fluid form-section">
    <h1 class="text-center mt-5 mb-5 text-light">Career Application Form </h1>
  
    @if (session('success'))
    <div
      class="alert w-50 mb-3 m-auto alert-success alert-dismissible fade show"
      role="alert"
    >
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
      ></button>
    
      <strong>{{ session('success') }}</strong>
    </div>
    
        
  
      @endif

    <div class="row">
      <div class="col-md-8 m-auto">
    <div class="apply-form p-5">
        <h2>Apply Now</h2>

        <form action="{{ route("jobApply")}}" enctype="multipart/form-data" method="post">
          @csrf
            <div class="row form-content">
                <div class="col-md-6 mb-3">
                    <label for="inputName" class="form-label">Name</label>
                  <input type="text" name="name" class="form-control" placeholder="Enter Name" aria-label="First name" value="{{ old('name')}}" required>
                  @error('name')
                  <small class="error">{{ $message }}</small>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="inputEmail4" class="form-label">Phone</label>
                  <input type="text" name="phone" class="form-control" value="{{ old('phone')}}" placeholder="Enter phone" required>
                  @error('phone')
                  <small>{{ $message }}</small>              
                  @enderror
                </div>
              </div>
              <div class="row form-content">
                <div class="col-md-6 mb-3">
                    <label for="inputName" class="form-label">Email</label>
                  <input type="text" name="email" value="{{ old('email')}}" class="form-control" placeholder="Enter Email" required>
                  @error('email')
                  <small>{{ $message }}</small>              
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="inputEmail4" class="form-label">Adhar Number</label>
                  <input type="text" name="adhar-number" value="{{ old('adhar-number')}}" class="form-control" placeholder="Enter Adhar Number" aria-label="Last name" required>
                  @error('adhar-number')
                  <small>{{ $message }}</small>              
                  @enderror
                </div>
            </div>
              <div class="row form-content">
                <div class="col-md-6 mb-3">
                    <label for="inputName" class="form-label">Date Of Birth</label>
                  <input type="date" name="dob" value="{{ old('dob')}}"  class="form-control" placeholder="" required>
                  @error('dob')
                  <small>{{ $message }}</small>              
                  @enderror
                </div>
                <div class="col-md-6 mb-4">
                    <label for="inputEmail4" class="form-label">Pincode</label>
                  <input type="number" name="pincode" value="{{ old('pincode')}}"  class="form-control" placeholder="Enter pin" aria-label="Last name" required>
                  @error('pincode')
                  <small>{{ $message }}</small>              
                  @enderror
                </div>
              </div>
            <div class="mb-4">
            <select class="form-select" name="category" aria-label="Default select example" required>
                <option selected hidden>--Category--</option>
                <option value="Gen">General</option>
                <option value="ST/ST">ST/SC</option>
                <option value="OBC">OBC</option>
              </select>
              @error('category')
              <small>{{ $message }}</small>              
              @enderror
            </div>
            <div class="mb-4">
              <select class="form-select" name="state" aria-label="Default select example" required>
                <option selected hidden>--Select State--</option>
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Odisha">Odisha</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="West Bengal">West Bengal</option>
                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Lakshadweep">Lakshadweep</option>
                <option value="Puducherry">Puducherry</option>
              </select>
              
              @error('state')
              <small>{{ $message }}</small>              
              @enderror
            </div>


             <div class="row form-content">
              <div class="mb-4">
                <label for="formFile" class="form-label">Photo</label>
                <input class="form-control" name="photo" type="file" id="formFile">
              </div>
            </div>

            <div class="row form-content">
                <div class="mb-4">
                  <label for="formFile" class="form-label">Any Diploma Certificate Related To Job Post</label>
                  <input class="form-control" name="certificate" type="file" id="formFile">
                </div>
              </div>
             
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                <label class="form-check-label" for="flexCheckDefault">
                  Accept Terms & Conditions
                </label>
              </div>
             
            <button type="submit" class="btn btn-warning rounded-0 py-3 fw-bold px-3" >Submit Application</button>
        </form>
    </div>
  </div>
</div>
</div>

    
@endsection