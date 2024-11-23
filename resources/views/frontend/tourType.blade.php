@extends('frontend.layouts.master')
@section('title', $tourTypes->name . ' ' . 'Tour Packages')
@section('meta_description', $tourTypes->name)
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

<section class="packages-bg-images d-flex justify-content-center align-items-center" style="background:linear-gradient(rgba(0, 0, 0, 0.554), rgba(0, 0, 0, 0.667)),  url('{{ asset("uploads/packages/" . $packages[0]->photo) }}'); height:300px; background-position:center center; background-size:cover;">
<h1 class=" text-white ">{{$tourTypes->name}}</h1>

</section>
<!-- <section>
<h1>adventure</h1>
</section> -->
<section style="background-color: #fff;">
<div class="container py-5">
    <div class="row">
        <div class="col-md-3 mb-3 sticky-sidebar">
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
                          <input class="form-check-input filter-type" type="checkbox" value="1" id="Adevanture">
                          <label class="form-check-label" for="Adevanture">
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
                          <input class="form-check-input filter-type" type="checkbox" value="7" id="adevanture">
                          <label class="form-check-label" for="adevanture">
                            Adevanture
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
                    <input class="form-check-input filter-type" type="checkbox" value="1" id="Adevanture">
                    <label class="form-check-label" for="Adevanture">
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
                    <input class="form-check-input filter-type" type="checkbox" value="7" id="adevanture">
                    <label class="form-check-label" for="adevanture">
                      Adevanture
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
         <button type="submit" class="btn btn-danger w-100 mt-3">Apply</button>    
         </div>

         <div class="col-md-9">
          <div class="row" id="package-type-list">
            <!-- Filtered packages will be injected here -->
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
                        <input type="hidden" id="package_id">

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
                        <label class="form-check-label px-2" for="terms">I agree to the terms and conditions.</label>
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

<!-- Package List Container -->
<div id="package-type-list" class="row">
    <!-- Packages will be loaded here dynamically -->
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize date restrictions
    const travelDateInput = document.getElementById('travelDate');
    const today = new Date().toISOString().split('T')[0];
    travelDateInput.setAttribute('min', today);

    // Form validation for adults and children
    const adultsInput = document.getElementById('adults');
    const childrenInput = document.getElementById('children');
    
    adultsInput.addEventListener('input', function() {
        if (this.value < 1) {
            this.setCustomValidity("Number of adults must be at least 1.");
        } else {
            this.setCustomValidity("");
        }
    });

    childrenInput.addEventListener('input', function() {
        if (this.value < 0) {
            this.setCustomValidity("Number of children cannot be negative.");
        } else {
            this.setCustomValidity("");
        }
    });

    // Book Now Button Click Handler
    $(document).on('click', '.booknow', function (event) {
    event.preventDefault(); // Prevent default behavior if necessary
    var slug = $(this).data("slug");     // Package slug
    var newSlug = $(this).data("newslug"); // Category slug
    var routeUrl = `/tour-category/${newSlug}/${slug}`; // Construct the route

    // Redirect to the constructed route
    window.location.href = routeUrl;
});

    // Add to Cart Button Click Handler
    $(document).on('click', '.add-to-cart', function(event) {
        event.preventDefault();
        const itemId = $(this).data('id');
        addToCart(itemId);
    });

    // Add to Cart Function
    function addToCart(id) {
        $.ajax({
            url: '{{ route("addtocart")}}',
            method: 'POST',
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert('Item added to cart successfully!');
                    updateCartCount(response.cartCount); // Update cart count if implemented
                } else {
                    alert(response.message || 'Failed to add item to cart');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error adding to cart:', error);
                alert('Error adding item to cart');
            }
        });
    }

    // Booking Form Submission
    $('#bookingForm').on('submit', function(e) {
        e.preventDefault();

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
            url: "{{ route('book.package') }}",
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Booking confirmed successfully!');
                $('#bookingForm')[0].reset();
                $('#bookingModal').modal('hide');
            },
            error: function(response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(field, message) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).next('.invalid-feedback').text(message[0]).show();
                    });
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });

    // Package Filtering
    $('.filter-price, .filter-duration, .filter-type').on('change', function() {
        let selectedPrice = $('.filter-price:checked').map(function() { return $(this).val(); }).get();
        let selectedDuration = $('.filter-duration:checked').map(function() { return $(this).val(); }).get();
        let selectedType = $('.filter-type:checked').map(function() { return $(this).val(); }).get();
        fetchPackages(selectedPrice, selectedDuration, selectedType);
    });

    // Fetch Packages Function
    function fetchPackages(selectedPrice = [], selectedDuration = [], selectedType = []) {
        $.ajax({
            url: '{{ url("/filter-tour-packages", $newSlug) }}',
            method: 'GET',
            data: {
                price: selectedPrice,
                duration: selectedDuration,
                type: selectedType
            },
            success: function(response) {
                $('#package-type-list').empty();
                response.packagesFilter.forEach(function(item) {
                    let discount = ((item.ragular_price - item.offer_price) / item.ragular_price) * 100;
                    let packageHtml = createPackageHtml(item, response.newSlug, discount);
                    $('#package-type-list').append(packageHtml);
                });
            },
            error: function(error) {
                console.error('Error fetching packages:', error);
            }
        });
    }

    // Create Package HTML Helper Function
    function createPackageHtml(item, slug, discount) {
      return `
    <div class="col-md-6 mb-3">
        <div class="card shadow card-body p-0">
            <a href="/tour-category/${slug}/${item.slug}" class="text-decoration-none text-dark">
                <img src="/uploads/packages/${item.photo}" width="100%" style="height:250px; object-fit:cover;" alt="${item.package_name}">
            </a>
            <div class="package-desc py-3 px-2">
                <h5>${item.package_name.length > 38 ? item.package_name.substring(0, 38) + '...' : item.package_name}</h5>
                <div class="d-flex justify-content-between">
                    <p class="btn btn-outline-danger fw-semibold btn-sm">${item.duration} days</p>
                    <ul class="d-flex list-unstyled">
                        <li><i class="fa-solid fa-hotel text-warning px-2"></i></li>
                        <li><i class="fa-solid fa-car text-danger px-2"></i></li>
                        <li><i class="fa-solid fa-utensils text-success px-2"></i></li>
                    </ul>
                </div>
                <div class="price-offer d-flex justify-content-between align-items-center">
                    <div>
                        <p>Starting Price Per Adult</p>
                        <p style="font-size: 20px; margin-top:-10px; font-weight:bold;">
                            ₹${Number(item.offer_price).toLocaleString('en-IN')}
                            <small style="font-size:14px; font-weight:600; color:green;">${discount.toFixed(2)}% Off</small>
                        </p>
                        <small class="text-muted d-block" style="text-decoration: line-through; margin-top:-10px; font-size:14px; font-weight:600;">
                            ₹${Number(item.ragular_price).toLocaleString('en-IN')}
                        </small>
                    </div>
                    <div class="d-flex flex-column">
                        <button class="btn btn-danger mb-2 rounded-0 booknow" data-slug="${item.slug}" data-newslug="${slug}">Book Now</button>
                        <button class="btn btn-outline-danger rounded-0 add-to-cart" data-id="${item.id}">Add To Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
`;

}


    // Initial load of packages
    fetchPackages();
});
</script>
@endsection