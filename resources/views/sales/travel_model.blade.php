<!-- resources/views/sales/travel_modal.blade.php -->
<div class="modal fade" id="travelModal" tabindex="-1" role="dialog" aria-labelledby="travelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="travelModalLabel">Travel Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="travel_form" method="POST" action="{{ route('travel.store') }}">
                    @csrf
                    <input type="hidden" id="selected_travel_mode" name="travel_mode">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="departure">Departure City</label>
                                <input type="text" class="form-control" id="departure" name="departure" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="destination">Destination City</label>
                                <input type="text" class="form-control" id="destination" name="destination" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="departure_date">Departure Date</label>
                                <input type="date" class="form-control" id="departure_date" name="departure_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="return_date">Return Date</label>
                                <input type="date" class="form-control" id="return_date" name="return_date">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="adults">Adults</label>
                                <input type="number" class="form-control" id="adults" name="adults" min="1" value="1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="children">Children</label>
                                <input type="number" class="form-control" id="children" name="children" min="0" value="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="class">Travel Class</label>
                                <select class="form-control" id="class" name="class">
                                    <option value="economy">Economy</option>
                                    <option value="business">Business</option>
                                    <option value="first">First Class</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="special_requests">Special Requests</label>
                        <textarea class="form-control" id="special_requests" name="special_requests" rows="3"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Search Available Options</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate return date is after departure date
    document.getElementById('return_date').addEventListener('change', function() {
        var departureDate = new Date(document.getElementById('departure_date').value);
        var returnDate = new Date(this.value);
        
        if (returnDate < departureDate) {
            alert('Return date must be after departure date');
            this.value = '';
        }
    });

    // Set minimum date for departure to today
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('departure_date').setAttribute('min', today);
});
document.getElementById('travel_form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    
    fetch('{{ route('travel.store') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            $('#travelModal').modal('hide');
            // Reset form
            this.reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the form');
    });
});
</script>