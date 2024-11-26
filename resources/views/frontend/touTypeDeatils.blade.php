@extends('frontend.layouts.master')
@section('title', $package->title)
@section('meta_description', $package->meta_description)
@section('styles')
<style>
.packageDetailsSlider .swiper-slide img {
  
    display: block;
    width: 100%;
    height: 400px !important;
    object-fit: cover;
  }
  .packageDetailsSlider{
    margin-bottom: 40px;
  }

  /* Custom styles for Swiper slider buttons */
.swiper-button-next,
.swiper-button-prev {
  background-color: #007bff; /* Button background color */
  color: #fff; /* Button icon color */
  width: 35px;  /* Button width */
  height: 35px; /* Button height */
  border-radius: 50%; /* Rounded corners */
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional shadow for a 3D effect */
  transition: background-color 0.3s ease; /* Smooth hover effect */
}

/* Next button */
.swiper-button-next:after,
.swiper-button-prev:after {
  font-size: 14px; /* Control the size of the arrow */
}

/* Hover effect */
.swiper-button-next:hover,
.swiper-button-prev:hover {
  background-color: #0056b3; /* Change button color on hover */
}

/* Custom positioning */
.swiper-button-next {
  right: 10px;
}

.swiper-button-prev {
  left: 10px;
}

/* Disable button appearance when inactive */
.swiper-button-disabled {
  opacity: 0.5;
  cursor: not-allowed;
}


/* Popover container */
.popover-container {
  position: relative;
  display: inline-block;
}

/* Popover button */
.popover-btn {
  /* background-color: #f5f5f5; Customize button color */
  border: none;
  padding: 4px 15px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 12px;
  border: 1px solid #ddd !important;
  background-color: #dedede !important;
  display: inline-flex;
  align-items: center;
  /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); */
}

/* Popover content */
.popover-content {
  visibility: hidden;
  width: 270px; /* Adjust as needed */
  background-color: #000; /* Background color */
  color: #fff;
  text-align: left;
  padding: 10px;
  border-radius: 5px;
  position: absolute;
  z-index: 100;
  left: 40px; /* Adjust popover position */
  left: 0;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: visibility 0.3s, opacity 0.3s ease;
  opacity: 0;
}

/* Show the popover when hovering over the button */
.popover-container:hover .popover-content {
  visibility: visible;
  opacity: 1;
}

/* Styling the popover content */
.popover-content strong {
  font-size: 13px;
}
.popover-content ul {
  list-style-type: none;
  padding-left: 0;
  margin: 5px 0;
}
.popover-content li {
  margin: 5px 0;
  font-size: 11px;
}

.sticky-price {
  position: sticky;
  top: 80px; /* Adjust as needed to create spacing from the top */
  z-index: 3;
  margin-top: 105px;
}
#datepicker {
      border-radius: 5px;
      padding: 10px;
      width: 100%;
      font-size: 16px;
      text-align: left;
    }
    /* Customize the Flatpickr calendar */
    .flatpickr-calendar {
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
 #bookingForm input{
    border-radius: 0px;
    padding: 8px;
    }

    .duration{
      padding-left: 5px;
    }
    #booknow{
      margin-top: 60px !important;
    }
    @media(max-width:768px){
      #booknow {
        font-size: 14px !important;
        margin-top: 85px !important;
      }

      .packageDetailsSlider .swiper-slide img {
        height: 200px !important;
      }
      .popover-btn {
        padding: 4px 5px !important;
      }
      .sticky-price {
        margin-top: 0 !important;
      }
    }
    button{
      border-radius: 0px !important;
      border-color: #ddd !important;
    }

    .sticker{
      width: auto !important;
    height: auto !important;
    display: inline-block;
    position: relative;
    background: red;
    top: 36px;
    left: 0;
    text-transform: uppercase;
    color: #fff;
    font-size: 12px !important;
    font-weight: bold;
    z-index: 3;
    clip-path: polygon(100% 0, 92% 50%, 100% 100%, 0 100%, 0 0);
    padding: 3px 13px 3px 9px;
    border-radius: 3px 0 0 3px;
    line-height: 16px;
    }
</style>

@endsection
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class=" fs-3 mb-3">{{$package->package_name}}</h1>
           
            <ul class="d-flex align-items-center list-unstyled">
                <li>
                    <div class="popover-container">
                        <button class="popover-btn btn-sm btn-secondary"> Customizable</button>
                        <div class="popover-content">
                          <strong>Highlights</strong>
                          <ul>
                            <li>✓ Customise the package as per need</li>
                            <li>✓ Just your friends/family</li>
                          </ul>
                        </div>
                      </div>
                </li>
                <li class="duration">
                  <button class="btn btn-info btn-sm">{{$package->duration}}</button>
                </li>
            
                <li><i class="fa-solid fa-hotel text-warning px-2"></i></li>
                <li><i class="fa-solid fa-car text-danger px-2"></i></li>
                <li><i class="fa-solid fa-utensils text-success px-2"></i></li>
            </ul>
          
            <!-- Swiper -->
            <div class="sticker">
              {{$package->tourType->name}}
            </div>

  <div class="swiper packageDetailsSlider">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <img src="{{ asset('uploads/packages/' .$package->photo)}}" alt=""></div>
        
        @foreach ($package->photos as $item)  
       <div class="swiper-slide">
        <img src="{{ asset('uploads/packages/'.$item->photo)}}" alt="">
    </div>
      @endforeach
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </div>
        </div>
        <div class="col-md-4 sticky-price mb-3">
            <div class="card shadow py-3 border-0 rounded-0">
                <div class="card-body">
                  @php
                  $discount = (($package->ragular_price - $package->offer_price) / $package->ragular_price) * 100;
                  @endphp
                    <h4>Price Details</h4>
                    <hr>
                    <div class="price-offer d-flex justify-content-between align-items-center">
                      <div>
                      <p>Starting Price Per Adult</p>
                      <p style="font-size: 20px; margin-top:-10px; font-weight:bold;">₹{{ number_format($package->offer_price) }} 
                        <small style="font-size:14px; font-weight:600; color:green;">{{ round($discount, 2) }} % Off</small>
                      </p>
                      <small class="text-muted d-block" style="text-decoration: line-through;margin-top:-10px; font-size:14px; font-weight:600;">₹{{ number_format($package->ragular_price) }}</small>
                       <small>Excluding applicable taxes</small>
                      </div>
                      <button class="btn btn-danger btn-lg rounded-0" id="booknow" data-bs-toggle="modal" data-bs-target="#bookingModal">Book Now</button>
                     </div>
                </div>
            </div>
        </div>
        
    </div>

    {{-- row --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card rounded-0 mb-3">
                <div class="card-body">
                    <h4>Package Overview</h4>
                    <p>{!!$package->description!!}</p>
                </div>  
             </div>

             <div class="card rounded-0 mb-3">
              <div class="card-body">
                  <h4>Package Highlights</h4>
                  {!!$package->short_description!!}
                 
              </div>
          </div>

             <div class="card rounded-0 mb-3">
                <div class="card-body">
                    <h4>Day wise Itinerary</h4>
                    {!!$package->itinerary!!}

                </div>
             </div>

             <div class="card rounded-0 mb-3">
              <div class="card-body">
                 
                  {!!$package->location!!}

              </div>
           </div>

        </div>
        <div class="col-md-4">
       
             </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="bookingModalLabel">Confirmmmm Your Booking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="bookingForm">
          <div class="row">
              <div class="col-md-6 mb-3">
                  <label for="fullName" class="form-label">Full Name</label>
                  <input type="text" class="form-control" id="fullName" name="full_name" required>
                  <div class="invalid-feedback">Please enter your full name.</div>
              </div>
              <input type="hidden" id="package_id" value="{{$package->id}}">
      
              <div class="col-md-6 mb-3">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input type="tel" class="form-control" id="phone" name="phone" required>
                  <div class="invalid-feedback">Please enter a valid phone number.</div>
              </div>
          </div>
      
          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                  <div class="invalid-feedback">Please enter a valid email address.</div>
              </div>
          </div>
      
          <div class="row">
              <div class="col-md-6 mb-3">
                  <label for="adults" class="form-label">Number of Adults</label>
                  <input type="number" class="form-control" id="adults" name="adults" min="1" required>
                  <div class="invalid-feedback">Number of adults must be at least 1.</div>
              </div>
      
              <div class="col-md-6 mb-3">
                  <label for="children" class="form-label">Number of Children</label>
                  <input type="number" class="form-control" id="children" name="children" value="0" min="0" required>
                  <div class="invalid-feedback">Number of children cannot be negative.</div>
              </div>
          </div>
      
          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="travelDate" class="form-label">Travel Date</label>
                  <input type="date" class="form-control" id="travelDate" name="travel_date" required>
                  <div class="invalid-feedback">Please select a valid travel date.</div>
              </div>
          </div>
      
          <!-- Terms & Conditions -->
          <div class="form-check mb-3">
              <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
              <label class="form-check-label px-2" for="terms"> I agree to the terms and conditions.</label>
              <div class="invalid-feedback">You must agree to the terms and conditions.</div>
          </div>
      
          <!-- Submit Button -->
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Confirm Booking</button>
          </div>
      </form>
      
      </div>
    </div>
  </div>
</div>
    
@endsection

@section('scripts')

<script>
    var swiper = new Swiper(".packageDetailsSlider", {
      slidesPerView: 1,
      spaceBetween: 30,
      loop: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  </script>

<script>
  const travelDateInput = document.getElementById('travelDate');
  const today = new Date().toISOString().split('T')[0];
  travelDateInput.setAttribute('min', today);
 
  // Wait for the DOM to load before running the script
  document.addEventListener('DOMContentLoaded', function () {
      const adultsInput = document.getElementById('adults');
      const childrenInput = document.getElementById('children');
      const form = document.getElementById('bookingForm');
      // Adults Field Validation
      adultsInput.addEventListener('input', function () {
        if (adultsInput.value < 1) {
          adultsInput.setCustomValidity("Number of adults must be at least 1.");
        } else {
          adultsInput.setCustomValidity(""); // Clear error
        }
      });
      
      // Children Field Validation
      childrenInput.addEventListener('input', function () {
        if (childrenInput.value < 0) {
          childrenInput.setCustomValidity("Number of children cannot be negative.");
        } else {
          childrenInput.setCustomValidity(""); // Clear error
        }
      });

      // Validate on form submit
      form.addEventListener('submit', function (event) {
        // Trigger validation before submitting
        if (!form.checkValidity()) {
          event.preventDefault(); // Prevent form submission if invalid
          event.stopPropagation();
        }
        form.classList.add('was-validated'); // Add Bootstrap validation class
      });
    });


    // Submit Form
    $(document).ready(function () {
    $('#bookingForm').on('submit', function (event) {
        event.preventDefault(); // Prevent traditional form submission

        // Clear previous validation errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').hide();

        // Gather form data
        let formData = {
            package_id: $('#package_id').val(),
            full_name: $('#fullName').val(),
            phone: $('#phone').val(),
            email: $('#email').val(),
            adults: $('#adults').val(),
            children: $('#children').val(),
            travel_date: $('#travelDate').val(),
            terms: $('#terms').is(':checked') ? 1 : 0,
        };

        $.ajax({
            url: "{{ route('book.package') }}", // Laravel route for booking
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                alert('Booking confirmed successfully!');
                // Navigate to the booking page with the dynamic booking ID
                window.location.href = `/booking/${response.booking_id}`;
            },
            error: function (response) {
                // Handle validation errors
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;

                    // Loop through each error and display it
                    $.each(errors, function (field, message) {
                        // Add the 'is-invalid' class to the corresponding form field
                        $('#' + field).addClass('is-invalid');

                        // Display the error message in the next sibling .invalid-feedback div
                        $('#' + field).next('.invalid-feedback').text(message[0]).show();
                    });
                } else {
                    alert('An error occurred. Please try again.');
                }
            },
        });
    });
});
  



</script>
@endsection