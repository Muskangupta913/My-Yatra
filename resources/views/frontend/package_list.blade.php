@extends('frontend.layouts.master')
@section('content')
{{-- package details --}}


<style>
   .price-filter {

  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.price-filter h5 {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 15px;
}

.form-check {
  margin-bottom: 10px;
}

.form-check-input {
  width: 18px;
  height: 18px;
  border-radius: 50%;
}

.form-check-label {
  font-size: 14px;
  margin-left: 10px;
  color: #333;
}
.form-check-input:checked {
  background-color: #007bff;
  border-color: #007bff;
}
.form-check-input:hover {
  transform: scale(1.1);
}
.accordion-button:not(.collapsed) {
  background-color: #fff !important;
}
</style>
@if($packages->isEmpty())
<div class="container mt-5 mb-5 py-5">
<div class=" text-center m-auto">
    <img src="{{ asset('assets/img/package-not-found.png')}}" alt="">
    <p class="mt-4">No package(s) found matching your search criteria. Please look for an alternate package or call our travel experts at <a href="tel:9871980066" target="_blank">+91 9871980066</a> . <br/> You may also drop us an email at <a href="mailto:support@makemybharatyatra.com" target="_blank">support@makemybharatyatra.com</a></p>
    
    <a href="{{ route('home')}}" class="btn btn-warning rounded-0">Return Home</a>

   </div>
</div>
    @else

<section class="packages-bg-images d-flex justify-content-center align-items-center" style="background:linear-gradient(rgba(0, 0, 0, 0.554), rgba(0, 0, 0, 0.667)), url({{ asset("uploads/packages/".$packages['0']->photo)}});  height:300px; background-position:center center; background-size:cover;">
<h1 class=" text-white">{{$state->destination_name}} Tour Packages</h1>
</section>

<section style="background-color: #fff;">
<div class="container py-5">
   
    
    <div class="row">
        <div class="col-md-3 mb-3 sticky-sidebar">
          <div class="accordion shadow" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                  Budget (per person)
                </button>
              </h2>
              <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                <div class="accordion-body">
                  <form action="">
                    <div class="form-check">
                        <input class="form-check-input filter-price" type="checkbox" value="10000" id="price1">
                        <label class="form-check-label" for="price1">
                            Below ₹ 10,000
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input filter-price" type="checkbox" value="20000" id="price2">
                        <label class="form-check-label" for="price2">
                            ₹ 10,000 - ₹ 20,000
                        </label>
                      </div>

                      <div class="form-check">
                        <input class="form-check-input filter-price" type="checkbox" value="35000" id="price3">
                        <label class="form-check-label" for="price3">
                            ₹20000 - ₹ 35,000
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input filter-price" type="checkbox" value="35001" id="price4">
                        <label class="form-check-label" for="price4">
                            Above ₹ 35,000
                        </label>
                      </div>
                </form>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                  Duration (in Nights)
                </button>
              </h2>
              <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                <div class="accordion-body">
                  <form action="">
                    
                    <div class="form-check">
                      <input class="form-check-input filter-duration" type="checkbox" value="1 Nights 2 Days" id="duration1">
                      <label class="form-check-label" for="duration1">
                          1 Night
                      </label>
                    </div>

                      <div class="form-check">
                        <input class="form-check-input filter-duration" type="checkbox" value="2 Nights 3 Days" id="duration2">
                        <label class="form-check-label" for="duration1">
                            2 Nights
                        </label>
                      </div>

                      <div class="form-check">
                        <input class="form-check-input filter-duration" type="checkbox" value="3 Nights 4 Days" id="duration3">
                        <label class="form-check-label" for="duration2">
                            3 Nights
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input filter-duration" type="checkbox" value="4 Nights 5 Days" id="duration4">
                        <label class="form-check-label" for="duration3">
                            4 Nights
                        </label>
                      </div>

                      <div class="form-check">
                        <input class="form-check-input filter-duration" type="checkbox" value="5 Nights 6 Days" id="duration5">
                        <label class="form-check-label" for="duration4">
                            5 Nights
                        </label>
                      </div>

                      <div class="form-check">
                        <input class="form-check-input filter-duration" type="checkbox" value="6 Nights 7 Days" id="duration6">
                        <label class="form-check-label" for="duration5">
                            6 Nights
                        </label>
                      </div>
                </form>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                  Themes
                </button>
              </h2>
              <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show">
                <div class="accordion-body">
                  <form action="">
                    
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="Culture">
                      <label class="form-check-label" for="Culture">
                        Culture
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="Honeymoon">
                      <label class="form-check-label" for="Honeymoon">
                            Honeymoon
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="Adevanture">
                      <label class="form-check-label" for="Adevnture">
                        Adventure
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="CityTour">
                      <label class="form-check-label" for="CityTour">
                         City Tour
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="Wildlife">
                      <label class="form-check-label" for="Wildlife">
                        Wildlife
                      </label>
                    </div>
              </form>
                </div>
              </div>
            </div>
          </div>
        </div>
     

        <div class="col-md-9 mb-3">
           <div class="row">
            @foreach ($packages as $item)
            @php
            $discount = (($item->ragular_price - $item->offer_price) / $item->ragular_price) * 100;
            @endphp
            <div class="col-md-6 mb-3">
                <div class="card shadow card-body p-0">
                  <a href="{{ url('holidays/'.$state->state_slug . '/' .$item->slug) }}"
                           class="text-decoration-none text-dark">
                     <img src="{{ asset('uploads/packages/'.$item->photo)}}" width="100%" style="height:250px; object-fit:cover;" alt="">
                
                     <div class="package-desc py-3 px-2">
                      <h5>{{ \Illuminate\Support\Str::limit($item->package_name, 38, '...') }}</h5>
                      </a>
                      <div class="d-flex justify-content-between">
                        <p class="btn btn-outline-danger fw-semibold btn-sm">{{ $item->duration}}</p>
                        <ul class="d-flex list-unstyled">
                          <li><i class="fa-solid fa-hotel text-warning px-2"></i></li>
                          <li><i class="fa-solid fa-car text-danger px-2"></i></li>
                          <li><i class="fa-solid fa-utensils text-success px-2"></i></li>
                         </ul>
                      </div>
                    
                      <div class="price-offer d-flex justify-content-between align-items-center">
                        <div>
                        <p>Starting Price Per Adult</p>
                        <p style="font-size: 20px; margin-top:-10px; font-weight:bold;">₹{{ number_format($item->offer_price) }} 

                          <small style="font-size:14px; font-weight:600; color:green;">{{ round($discount, 2) }}% Off</small>
                        </p>
                        <small class="text-muted d-block" style="text-decoration: line-through;margin-top:-10px;   font-size:14px; font-weight:600;">₹{{ number_format($item->ragular_price) }}</small>
                        
                        </div>

                        <button class="btn btn-danger mx-2 btn-lg rounded-0 booknow"  data-id="{{$item->id}}">Bookk
                           Now</button>
                       </div>

                     </div>
                  
            </div>

                
            </div>
            @endforeach
           </div>
        </div>
        
    </div>
 
</div>
</section>
@endif

<!-- The Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="bookingModalLabel">Confirm Your Booking</h5>
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
              <input type="hidden"  id="package_id">
      
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
     $(document).ready(function() {
    $('.booknow').on('click', function(event) {
        event.preventDefault(); // Prevent the form from submitting traditionally
        
        var id  = $(this).data("id");
          
        $('#bookingModal').modal('show');
        $('#package_id').val(id);

    });
     
     $('#bookingForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting traditionally


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
            terms: $('#terms').is(':checked') ? 1 : 0
        };

        $.ajax({
            url: "{{ route('book.package') }}",  // Laravel route for booking
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Booking confirmed successfully!');
                $('#bookingForm')[0].reset();  // Reset form
                $('#bookingModal').modal('hide');  // Hide modal if using popup
            },
            error: function(response) {
                // Handle validation errors
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;

                    // Loop through each error and display it
                    $.each(errors, function(field, message) {
                        // Add the 'is-invalid' class to the corresponding form field
                        $('#' + field).addClass('is-invalid');

                        // Display the error message in the next sibling .invalid-feedback div
                        $('#' + field).next('.invalid-feedback').text(message[0]).show();
                    });
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });


    // Event listener for when checkboxes are clicked
    $('.filter-price, .filter-duration').on('change', function() {
        // Get selected prices
        var selectedPrices = [];
        $('.filter-price:checked').each(function() {
            selectedPrices.push($(this).val());
        });

        // Get selected durations
        var selectedDurations = [];
        $('.filter-duration:checked').each(function() {
            selectedDurations.push($(this).val());
        });

   
    });
});
</script>
@endsection