@extends('frontend.layouts.master')

@section('title', $destinations->title)
@section('meta_description', $destinations->meta_description)

@section('content')
{{-- package details --}}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
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

@media (max-width: 768px) {
  #desktopAccordion {
    display: none;
  }
  #mobileAccordion {
    display: block;
  }
}

@media (min-width: 768px) {
  #mobileAccordion {
    display: none;
  }
  #desktopAccordion {
    display: block;
  }
}
</style>
<section class="packages-bg-images d-flex justify-content-center align-items-center" style="background:linear-gradient(rgba(0, 0, 0, 0.554), rgba(0, 0, 0, 0.667)), url({{ asset("uploads/destination/$destinations->photo")}}); height:300px; background-position:center center; background-size:cover;">
<h1 class=" text-white ">{{$destinations->destination_name}}</h1>

</section>

<section style="background-color: #fff;">
<div class="container py-5">
    <div class="row">
        <div class="col-md-3 mb-3">

          {{-- desktop accordion --}}
          <div class="accordion shadow d-none d-md-block" id="desktopAccordion">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                  Budget (per person) Desk
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
                      <input class="form-check-input filter-duration" type="checkbox" value="1 Night 2 Days" id="duration1">
                      <label class="form-check-label" for="duration1">
                          1 Night
                      </label>
                    </div>

                      <div class="form-check">
                        <input class="form-check-input filter-duration" type="checkbox" value="2 Nights 3 Days" id="duration2">
                        <label class="form-check-label" for="duration2">
                            2 Nights
                        </label>
                      </div>

                      <div class="form-check">
                        <input class="form-check-input filter-duration" type="checkbox" value="3 Nights 4 Days" id="duration3">
                        <label class="form-check-label" for="duration3">
                            3 Nights
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input filter-duration" type="checkbox" value="4 Nights 5 Days" id="duration4">
                        <label class="form-check-label" for="duration4">
                            4 Nights
                        </label>
                      </div>

                      <div class="form-check">
                        <input class="form-check-input filter-duration" type="checkbox" value="5 Nights 6 Days" id="duration5">
                        <label class="form-check-label" for="duration5">
                            5 Nights
                        </label>
                      </div>

                      <div class="form-check">
                        <input class="form-check-input filter-duration" type="checkbox" value="6 Nights 7 Days" id="duration6">
                        <label class="form-check-label" for="duration6">
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
                      <input class="form-check-input filter-type" type="checkbox" value="1" id="Adventure">
                      <label class="form-check-label" for="Adventure">
                        Adventure Tour
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input filter-type" type="checkbox" value="2" id="city">
                      <label class="form-check-label" for="city">
                        City Tours
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input filter-type" type="checkbox" value="3" id="Honeymoon">
                      <label class="form-check-label" for="Honeymoon">
                        Honeymoon
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input filter-type" type="checkbox" value="6" id="Trekking">
                      <label class="form-check-label" for="Trekking">
                        Trekking
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input filter-type" type="checkbox" value="7" id="adventure">
                      <label class="form-check-label" for="adventure">
                        Adventure
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input filter-type" type="checkbox" value="11" id="Religious">

                      <label class="form-check-label" for="Religious">
                        Religious Places
                      </label>
                    </div>
              </form>
                </div>
              </div>
            </div>
          </div>

     {{-- mobile accordion --}}
     <div class="accordion shadow d-block d-md-none accordion-flush" id="mobileAccordion">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
            Budget (per person)
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
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
        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
          <div class="accordion-body">
            <form action="">
              
              <div class="form-check">
                <input class="form-check-input filter-duration" type="checkbox" value="1 Night 2 Days" id="duration1">
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
        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
          <div class="accordion-body">
            <form action="">
              
              <div class="form-check">
                <input class="form-check-input filter-type" type="checkbox" value="1" id="Adventure">
                <label class="form-check-label" for="Adventure">
                  Adventure Tour
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input filter-type" type="checkbox" value="2" id="city">
                <label class="form-check-label" for="city">
                  City Tours
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input filter-type" type="checkbox" value="3" id="Honeymoon">
                <label class="form-check-label" for="Honeymoon">
                  Honeymoon
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input filter-type" type="checkbox" value="6" id="Trekking">
                <label class="form-check-label" for="Trekking">
                  Trekking
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input filter-type" type="checkbox" value="7" id="adventure">
                <label class="form-check-label" for="adventure">
                  Adventure
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input filter-type" type="checkbox" value="11" id="Religious">

                <label class="form-check-label" for="Religious">
                  Religious Places
                </label>
              </div>
        </form>
          </div>
        </div>
      </div>
    </div>
         <!-- Apply Button -->
         <!-- <button type="submit" class="btn btn-danger w-100 mt-3">Apply</button>  -->


         </div>
        <div class="col-md-9 mb-3">
          <div class="row" id="package-list">
            <!-- Filtered packages will be injected here -->
        </div>
          </div>
        </div>
    </div>
</div>
</section>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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

    $(document).on('click', '.add-to-cart', function(event) {
        event.preventDefault();
        const itemId = $(this).data('id');
        addToCart(itemId);
    });

    // Add to Cart Function 
    function addToCart(id) {
    $.ajax({
        url: `/addtocart/${id}`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
          success: function(response) {
            toastr.success('Item added to cart '); // Show success message
            // if (response.success) {
            //     alert('Item added to cart successfully!');
            // } else {
            //     alert(response.message || 'Failed to add item to cart');
            // }
        },
        error: function(xhr, status, error) {
            // Log the full error details to console
            console.error('Error Details:', {
                status: xhr.status,
                responseText: xhr.responseText,
                error: error
            });
            
            if (xhr.status === 401) {
                window.location.href = '/login';
            } else {
                   // Try to get the error message from the response
                   toastr.error('Failed to add item to cart'); // Show error message
                try {
                    const response = JSON.parse(xhr.responseText);
                    alert(response.message || 'Server error occurred');
                } catch (e) {
                    alert('An error occurred while adding to cart. Please try again.');
                }
            }
        }
    });
}
        



     
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
            success: function (response) {
              // toastr.success('Booking confirmed successfully!'); // Show success message
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
                  // toastr.error('An error occurred. Please try again.'); // Show error message
                }
            }
        });
    });



// Filter Packages Query

    $('.filter-price, .filter-duration, .filter-type').on('change', function() {
        // Get selected values
        var selectedPrice = [];
        var selectedDuration = [];
        var selectedType = [];

        $('.filter-price:checked').each(function() {
            selectedPrice.push($(this).val());
        });
        $('.filter-duration:checked').each(function() {
            selectedDuration.push($(this).val());
        });
        $('.filter-type:checked').each(function() {
            selectedType.push($(this).val());
        });

        // Make the AJAX request
        fetchPackages(selectedPrice, selectedDuration, selectedType);
        
     });
     // Filter Packages Query End
     fetchPackages();

function fetchPackages(selectedPrice, selectedDuration, selectedType) {
  $.ajax({
    url: '{{ url("/filter-packages", $destinations->slug) }}',  // Generate correct URL
    method: 'GET',
    data: {
        price: selectedPrice,
        duration: selectedDuration,
        type: selectedType
    },
    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
        $('#package-list').empty();  // Clear the package list container

    response.packagesFilter.forEach(function(item) {
        let discount = ((item.ragular_price - item.offer_price) / item.ragular_price) * 100;

        let packageHtml = `
           <div class="col-md-6 mb-3">
    <div class="card shadow card-body p-0">
        <a href="/holidays/${response.destinations.slug}/${item.slug}" class="text-decoration-none text-dark">
            <img src="/uploads/packages/${item.photo}" width="100%" style="height:250px; object-fit:cover;" alt="">
            <div class="package-desc py-3 px-2">
                <h5>${item.package_name.length > 38 ? item.package_name.substring(0, 38) + '...' : item.package_name}</h5>
            </a>
            <div class="d-flex justify-content-between">
                <p class="btn btn-outline-danger fw-semibold btn-sm">${item.duration}</p>
                <ul class="d-flex list-unstyled">
                    <li><i class="fa-solid fa-hotel text-warning px-2"></i></li>
                    <li><i class="fa-solid fa-car text-danger px-2"></i></li>
                    <li><i class="fa-solid fa-utensils text-success px-2"></i></li>
                </ul>
            </div>
            <div class="price-offer d-flex justify-content-between align-items-center">
                <div>
                    <p>Starting Price Per Adult</p>
                    <p style="font-size: 20px; margin-top:-10px; font-weight:bold;">₹${Number(item.offer_price).toLocaleString('en-IN')} 
                        <small style="font-size:14px; font-weight:600; color:green;">${discount.toFixed(2)}% Off</small>
                    </p>
                    <small class="text-muted d-block" style="text-decoration: line-through; margin-top:-10px; font-size:14px; font-weight:600;">
                    ₹${Number(item.ragular_price).toLocaleString('en-IN')}
                    </small>
                </div>
            <div class="button-group d-flex flex-column justify-content-between  mt-2">
                    <a href="/holidays/${response.destinations.slug}/${item.slug}" class="text-decoration-none text-dark">
                        <button class="btn btn-danger mb-2  rounded-0 booknow w-100" data-id="${item.id}">Details</button>
                    </a>
                    <button class="btn btn-outline-danger rounded-0 add-to-cart" data-id="${item.id}">Add To Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>

        `;

        // Append each package HTML to the list container
        $('#package-list').append(packageHtml);
    });
},

    error: function(xhr, status, error) {
        console.log(error);  // Log any errors
    }
});
}

   
});
toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right", // Positioning the toast
        "preventDuplicates": false,
        "showDuration": "300", // Show duration
        "hideDuration": "1000", // Hide duration
        "timeOut": "5000", // Disable auto-dismiss
        "extendedTimeOut": "1000", // Disable auto-dismiss on hover
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
</script>
@endsection