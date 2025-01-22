<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
  .plane {
  margin: auto;
  max-width: 300px;
  background: #f0f0f0;
  padding: 10px;
  border-radius: 5px;
  text-align: center;
}
.cockpit {
  padding: 10px 0;
  background: #333;
  color: white;
  font-weight: bold;
}
.cabin {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.row {
  display: flex;
  justify-content: center;
  margin: 5px 0;
}
.seat {
  width: 40px;
  height: 40px;
  background: #4caf50;
  margin: 5px;
  line-height: 40px;
  text-align: center;
  border-radius: 5px;
  color: white;
  cursor: pointer;
}
.seat.selected {
  background: #ff5722;
}

</style>
@extends('frontend.layouts.master')

@section('content')

<!-- Booking Form Modal -->
<div class="modal fade show" id="bookingFormModal" tabindex="-1" aria-labelledby="bookingFormModalLabel" aria-hidden="true" style="display: block;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookingFormModalLabel">Booking Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="bookingForm">
          <!-- Personal Details Section -->
          <div class="card mb-3">
            <div class="card-header">
              <h6 class="mb-0">Personal Details</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label for="title" class="form-label">Title</label>
                  <select class="form-select" id="title" name="Title" required>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                  </select>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="firstName" class="form-label">First Name</label>
                  <input type="text" class="form-control" id="firstName" name="FirstName" required>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="lastName" class="form-label">Last Name</label>
                  <input type="text" class="form-control" id="lastName" name="LastName" required>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="gender" class="form-label">Gender</label>
                  <select class="form-select" id="gender" name="Gender" required>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="Email" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="contactNo" class="form-label">Contact Number</label>
                  <input type="tel" class="form-control" id="contactNo" name="ContactNo" required>
                </div>
                <div class="col-md-12 mb-3">
                  <label for="addressLine1" class="form-label">Address</label>
                  <input type="text" class="form-control" id="addressLine1" name="AddressLine1" required>
                </div>
              </div>
            </div>
          </div>

          <!-- Passport Details Section -->
          <div class="card mb-3">
            <div class="card-header">
              <h6 class="mb-0">Passport Details</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label for="passportNo" class="form-label">Passport Number</label>
                  <input type="text" class="form-control" id="passportNo" name="PassportNo">
                </div>
                <div class="col-md-4 mb-3">
                  <label for="passportExpiry" class="form-label">Passport Expiry</label>
                  <input type="date" class="form-control" id="passportExpiry" name="PassportExpiry">
                </div>
                <div class="col-md-4 mb-3">
                  <label for="passportIssueDate" class="form-label">Passport Issue Date</label>
                  <input type="date" class="form-control" id="passportIssueDate" name="PassportIssueDate">
                </div>
              </div>
            </div>
          </div>

          <!-- Dynamic Sections Container -->
          <div id="dynamicSections"></div>

          <!-- Fare Details Section -->
          <div class="card mb-3">
            <div class="card-header">
              <h6 class="mb-0">Fare Details</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label class="form-label">Total Fare</label>
                  <input type="text" class="form-control" id="totalFare" readonly>
                </div>
              </div>
            </div>
          </div>

          <!-- Additional Sections -->
         <!-- Baggage Options -->
<div class="baggage-section mb-3">
    <h6>Baggage Options</h6>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Weight</th>
                <th>Price (INR)</th>
                <th>Route</th>
                <th>Select</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($baggage[0] as $option)
            <tr>
                <td>{{ $option['Weight'] }} kg</td>
                <td>{{ $option['Price'] }}</td>
                <td>{{ $option['Origin'] }} → {{ $option['Destination'] }}</td>
                <td><input type="radio" name="baggage_option" value="{{ $option['Code'] }}"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Meal Options -->
<div class="meal-section mb-3">
    <h6>Meal Options</h6>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Meal Description</th>
                <th>Price (INR)</th>
                <th>Route</th>
                <th>Select</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mealDynamic[0] as $meal)
            <tr>
                <td>{{ $meal['AirlineDescription'] ?: 'No Description Available' }}</td>
                <td>{{ $meal['Price'] }}</td>
                <td>{{ $meal['Origin'] }} → {{ $meal['Destination'] }}</td>
                <td><input type="radio" name="meal_option" value="{{ $meal['Code'] }}"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Seat Selection Section -->
<div class="seat-selection-section mb-3">
  <h6>Seat Selection</h6>
  <button type="button" class="btn btn-secondary" id="selectSeatBtn" onclick="window.location.href='{{ route('flight.seat') }}'">
    Select Seat
  </button>
  <span id="seatInfo" class="ms-2" style="font-size: 14px;"></span>
</div>

 <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">Submit Booking</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// JSON Data
const bookingData = {
  "EndUserIp": "1.1.1.1",
  "ClientId": "180133",
  "UserName": "MakeMy91",
  "Password": "MakeMy@910",
  "SrdvType": "MixAPI",
  "SrdvIndex": "2",
  "TraceId": "173876",
  "ResultIndex": "OB2_0_0",
  "Passengers": [/* Your passenger data */]
};

// Initialize Form
$(document).ready(() => {
  const passenger = bookingData.Passengers[0];

  // Fill Personal Details
  $('#title').val(passenger.Title);
  $('#firstName').val(passenger.FirstName);
  $('#lastName').val(passenger.LastName);
  $('#gender').val(passenger.Gender);
  $('#email').val(passenger.Email);
  $('#contactNo').val(passenger.ContactNo);
  $('#addressLine1').val(passenger.AddressLine1);
  $('#city').val(passenger.City);
  $('#countryCode').val(passenger.CountryCode);
  $('#countryName').val(passenger.CountryName);

  // Fill Passport Details
  $('#passportNo').val(passenger.PassportNo);
  $('#passportExpiry').val(passenger.PassportExpiry);
  $('#passportIssueDate').val(passenger.PassportIssueDate);

  // Render Dynamic Sections
  const dynamicSections = $('#dynamicSections');


  // Render Seat Selection
  if (passenger.Seat && passenger.Seat.length > 0) {
    const seatsHtml = `
      <div class="card mb-3">
        <div class="card-header">
          <h6 class="mb-0">Seat Selection</h6>
        </div>
        <div class="card-body">
          <div class="row">
            ${passenger.Seat.map(seat => `
              <div class="col-md-6 mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="seat_${seat.Origin}_${seat.Destination}" 
                         value="${seat.Code}" id="seat_${seat.Code}">
                  <label class="form-check-label" for="seat_${seat.Code}">
                    ${seat.SeatNumber} - ₹${seat.Amount}
                    <br>
                    <small class="text-muted">
                      ${seat.AirlineCode}${seat.FlightNumber} (${seat.Origin} → ${seat.Destination})
                      ${seat.IsLegroom ? '| Legroom' : ''}
                      ${seat.IsAisle ? '| Aisle' : ''}
                    </small>
                  </label>
                </div>
              </div>
            `).join('')}
          </div>
        </div>
      </div>
    `;
    dynamicSections.append(seatsHtml);
  } -->

  // Fill Fare Details
  if (passenger.Fare) {
    $('#baseFare').val(`₹${passenger.Fare.BaseFare}`);
    $('#tax').val(`₹${passenger.Fare.Tax}`);
    $('#yqTax').val(`₹${passenger.Fare.YQTax}`);
    const total = passenger.Fare.BaseFare + passenger.Fare.Tax + passenger.Fare.YQTax;
    $('#totalFare').val(`₹${total}`);
  }

  // Show modal
  $('#bookingFormModal').modal('show');
});

// Form Submit Handler
$('#bookingForm').submit((e) => {
  e.preventDefault();
  
  // Collect form data
  const formData = new FormData(e.target);
  const bookingFormData = Object.fromEntries(formData);

  
  bookingFormData.Seat = [];
  $('input[id^="seat_"]:checked').each(function() {
    bookingFormData.Seat.push($(this).val());
  });

  console.log('Booking Form Data:', bookingFormData);
  alert('Booking submitted successfully!');
  $('#bookingFormModal').modal('hide');
});

// Meal and Baggage
document.addEventListener('DOMContentLoaded', function () {
  fetch('/api/fetch-ssr-details', { method: 'POST' })
    .then(response => response.json())
    .then(data => {
      // Populate baggage options
      const baggageSelect = document.getElementById('baggage');
      data.Baggage.forEach(baggage => {
        const option = document.createElement('option');
        option.value = baggage.Code;
        option.text = `${baggage.Weight}kg - ${baggage.Price} ${baggage.Currency}`;
        baggageSelect.appendChild(option);
      });

      // Populate meal options
      const mealSelect = document.getElementById('meal');
      data.MealDynamic.forEach(meal => {
        const option = document.createElement('option');
        option.value = meal.Code;
        option.text = `${meal.AirlineDescription} - ${meal.Price} ${meal.Currency}`;
        mealSelect.appendChild(option);
      });
    })
    .catch(error => console.error('Error fetching SSR details:', error));
});

//  seat selection
<button type="button" class="btn btn-secondary" id="selectSeatBtn" onclick="window.location.href='/flight-seat'">
  Select Seat
</button> 
</script>

@endsection
