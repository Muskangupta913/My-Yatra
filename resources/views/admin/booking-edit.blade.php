@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@include('admin.layouts.navbar')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

           @session('success')

           <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{session('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
               
           @endsession

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title">Edit
                    <a href="{{ route('booking')}}" class="btn btn-dark btn-sm float-right">Back </a>
                </h5>
            </div>
            <div class="card-body">
               <form action="{{ route('booking.update', $booking->id)}}" method="POST">
                @method('put')
                @csrf
                <div class="row">
                    <div class="form-group col">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control" name="full_name" value="{{$booking->full_name}}">
                    </div>
                    <div class="form-group col">
                        <label for="" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" value="{{$booking->email}}">
                    </div>
                    <div class="form-group col">
                        <label for="" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{$booking->phone}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="" class="form-label">No. of adults</label>
                        <input type="text" class="form-control" name="adults" value="{{ $booking->adults}}">
                    </div>
                    <div class="form-group col">
                        <label for="" class="form-label">No. of Children</label>
                        <input type="text" class="form-control" name="children" value="{{ $booking->children}}">
                    </div>
                    <div class="form-group col">
                        <label for="" class="form-label">Travel Date</label>
                        <input type="date" class="form-control" name="travel_date" value="{{ $booking->travel_date}}">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Update info</button>
                </div>
                 
                </form>
            </div>
        </div>
        {{-- Additional Info --}}

    </div>
    </div>
</div>

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
        <form action="{{ route('passengers', $booking->id)}}" method="POST">
        @csrf
    <!-- Passenger Details -->
    <h4>Adult Passengers</h4>
    <div id="adult-container">
        <div class="form-group adult-info">
            <label>Adult Name 1:</label>
            <input type="text" name="adult_name_1" class="form-control mb-2" placeholder="Enter Adult Name" required>
            <label>Age:</label>
            <input type="number" name="adult_age_1" class="form-control mb-2" min="18" placeholder="Enter Age" required>
            {{-- <button type="button" class="btn btn-danger btn-sm mb-4" onclick="removeField(this)">Remove</button> --}}
            <hr>
        </div>
    </div>
    <button type="button" class="btn btn-secondary mb-4" onclick="addAdultFields()">Add More Adults</button>

    <h4>Child Passengers</h4>
    <div id="child-container">
        <div class="form-group child-info">
            <label>Child Name 1:</label>
            <input type="text" name="child_name_1" class="form-control mb-2" placeholder="Enter Child Name" required>
            <label>Age:</label>
            <input type="number" name="child_age_1" class="form-control mb-2" min="1" placeholder="Enter Age" required>
            <button type="button" class="btn btn-danger btn-sm mb-4" onclick="removeField(this)">Remove</button>
            <hr>
        </div>
    </div>
    <button type="button" class="btn btn-secondary mb-4" onclick="addChildFields()">Add More Children</button>
    <br>
    <button type="submit" class="btn btn-primary">Submit Booking</button>
                </form>
            </div>
        </div>
       </div>
    </div>
</div>


@include('admin.layouts.footer')

<script>
         // Function to dynamically add adult fields with a remove button
         function addAdultFields() {
            var container = document.getElementById('adult-container');
            var count = document.querySelectorAll('.adult-info').length + 1;

            var div = document.createElement('div');
            div.classList.add('form-group', 'adult-info');
            div.innerHTML = `
                <label>Adult Name ${count}:</label>
                <input type="text" name="adult_name_${count}" class="form-control mb-2" placeholder="Enter Adult Name" required>
                <label>Age:</label>
                <input type="number" name="adult_age_${count}" class="form-control mb-2" min="18" placeholder="Enter Age" required>
                <button type="button" class="btn btn-danger btn-sm mb-4" onclick="removeField(this)">Remove</button>
                <hr>
            `;
            container.appendChild(div);
        }

        // Function to dynamically add child fields with a remove button
        function addChildFields() {
            var container = document.getElementById('child-container');
            var count = document.querySelectorAll('.child-info').length + 1;

            var div = document.createElement('div');
            div.classList.add('form-group', 'child-info');
            div.innerHTML = `
                <label>Child Name ${count}:</label>
                <input type="text" name="child_name_${count}" class="form-control mb-2" placeholder="Enter Child Name" required>
                <label>Age:</label>
                <input type="number" name="child_age_${count}" class="form-control mb-2" min="1" placeholder="Enter Age" required>
                <button type="button" class="btn btn-danger btn-sm mb-4" onclick="removeField(this)">Remove</button>
                <hr>
            `;
            container.appendChild(div);
        }

        // Function to remove a field dynamically
        function removeField(button) {
            button.parentElement.remove();
        }
</script>