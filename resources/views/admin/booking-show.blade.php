@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@include('admin.layouts.navbar')


 <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-body"> 
               
                <h4 class="text-center text-uppercase text-dark mb-3">Booking Details</h4>
                <hr style="border-width: 4px; border-color:rgb(255, 213, 0); margin-top:-10px; width:15%;">
                 
                <small style="font-weight: 700; text-primary">Booking Id : MMBY240{{$booking->id}}</small>
                <small class="float-right" style="font-weight: 700;">Travel Booking Date : {{ \Carbon\Carbon::parse($booking->created_at)->format('d-m-Y') }}</small>
                                
                <table class="table table-bordered mt-3 mb-3">

                    <tbody>
                        <tr> 
                            <th class="w-25">Name</th>
                            <td>{{$booking->full_name}}</td>
                        </tr>

                        <tr>
   
                            <th class="w-25">Email</th>
                            <td>{{$booking->email}}</td>
                        </tr>

                        <tr>
                            <th class="w-25">Phone</th>
                            <td>{{$booking->phone}}</td>
                        </tr>

                        <tr>
   
                            <th class="w-25">Number of Adults</th>
                            <td>{{$booking->adults}}</td>
                        </tr>
                        <tr>
   
                            <th class="w-25">Number of Children</th>
                            <td>{{$booking->children}}</td>
                        </tr>
                        <tr>
   
 <th class="w-25">Travel Date</th>
 <td>{{ \Carbon\Carbon::parse($booking->travel_date)->format('d-m-Y') }}</td>
                        </tr>
                    </tbody>
                </table>

                @if ($passengers->count() > 0)
                <!-- Display the passengers -->
          
                <h5 class="text-primary">Other Passengers Details</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Type</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($passengers as $item)
                        <tr id="row-{{ $item->id }}">
                            <td>{{$item->name}}</td>
                            <td>{{$item->age}}</td>
                            <td class="text-capitalize">{{$item->type}}</td>
                            <td>
                                <a href="javascript:void(0);" class="delete-btn" data-id="{{ $item->id }}">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>  
                        @endforeach


                      
                       
                    </tbody>
                </table>
                @else
                <!-- No passengers found -->
            @endif
                



                 <h5 class="text-primary">Package Details</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-25">Package Name</th>
                            <td>{{$booking->package->package_name}}</td>
                        </tr>

                        <tr>
                            <th class="w-25">Destination</th>
                            <td>{{$booking->package->destination->destination_name}}
                              > {{$booking->package->city->city_name}} > Tour Package</td>
                        </tr>
                        <tr>
                            <th class="w-25">Tour Type</th>
                            <td> <span class="badge badge-danger"> {{$booking->package->tourType->name}}</span> </td>
                        </tr>

                        <tr>
                            <th class="w-25">Price / per Adult</th>
                            <td> ₹ {{number_format($booking->package->offer_price)}} 
                          
                                <del class="text-danger">
                                    ₹ {{number_format($booking->package->ragular_price)}} 
                                </del>

                            </td>
                        </tr>
                        <tr>
                            <th class="w-25">Duration</th>
                            <td><span class="badge badge-primary"> {{$booking->package->duration}}</span></td>
                        </tr>
                    </thead>
                       
                </table>
            </div>
        </div>
    </div>
        
    </div>
 </div>



@include('admin.layouts.footer')
<script>
   $(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();

    var id = $(this).data('id'); // Get the ID of the passenger to delete
    var url = "{{ route('passengers.delete') }}"; // Your delete route URL

    if (confirm("Are you sure you want to delete this passenger?")) {
        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}', // CSRF Token for security
                id: id
            },
            success: function(response) {
                if (response.success) {
                    // Remove the deleted row from the table
                    $('#row-' + id).fadeOut(500, function() { 
                        $(this).remove(); // Remove the row after fading out
                    });

                    // Optionally, display a success message
                    alert(response.message);
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function(xhr) {
                alert("An error occurred while deleting the passenger.");
            }
        });
    }
});


</script>
        