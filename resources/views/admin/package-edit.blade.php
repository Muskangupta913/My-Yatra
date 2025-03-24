@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@include('admin.layouts.navbar')


         <!-- Begin Page Content -->
         <div class="container-fluid">
           
          

                @session('success')

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ session('success')}}</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                    
                @endsession
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Edit Package</h1>
                
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Package <a href="{{ route('package')}}" class="btn btn-primary btn-sm float-right">Back</a></h6>
                    </div>
                    <div class="card-body">
                      <form action="{{ route("package.update", $package->id)}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group mb-3">
                          <label for="destination_id">Select Destination</label>
                          <select name="destination_id" class="form-control" id="state">
                              <option selected hidden>Select Destination</option>
                              @foreach ($states as $item)
                                  <option value="{{ $item->id }}" 
                                      {{ $package->destination_id == $item->id ? 'selected' : '' }}>
                                      {{ $item->destination_name }}
                                  </option>
                              @endforeach
                          </select>
                      </div>

                      <!-- City Dropdown -->
                      <div class="form-group mb-3">
                        <label for="city">City:</label>
                        <select id="city" name="city_id" class="form-control" required>
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ $city->id == $package->city_id ? 'selected' : '' }}>
                                    {{ $city->city_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                      <div class="form-group mb-3">
                        <label for="tour_type">Select Tour-Type</label>
                        <select name="tour_type" class="form-control" id="tour_type">
                            <option hidden selected>Select Tour Type</option>
                            @foreach ($tourType as $item)
                            <option value="{{$item->id}}" {{ $package->tour_type_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                           
                        </select>
                  </div>
                          <div class="form-group mb-3">
                                <label for="name">Package
                                     Name</label>
                                <input type="text" value="{{$package->package_name}}" class="form-control" id="name" name="name">
                          </div>
                          <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" value="{{$package->slug}}" class="form-control" id="slug" name="slug">
                          </div>

                          <div class="form-group mb-3">
                            <label for="duration">Select Duration</label>
                            <select name="duration" class="form-control" id="duration">
                                <option hidden selected>Select Duration</option>
                                <option value="1 Day" {{ $package->duration == '1 Day' ? 'selected' : '' }}>1 Day</option>
                                <option value="1 Night 2 Days" {{ $package->duration == '1 Night 2 Days' ? 'selected' : '' }}>1 Night 2 Days</option>
                                <option value="2 Nights 3 Days" {{ $package->duration == '2 Nights 3 Days' ? 'selected' : '' }}>2 Nights 3 Days</option>
                                <option value="3 Nights 4 Days" {{ $package->duration == '3 Nights 4 Days' ? 'selected' : '' }}>3 Nights 4 Days</option>
                                <option value="4 Nights 5 Days" {{ $package->duration == '4 Nights 5 Days' ? 'selected' : '' }}>4 Nights 5 Days</option>
                                <option value="5 Nights 6 Days" {{ $package->duration == '5 Nights 6 Days' ? 'selected' : '' }}>5 Nights 6 Days</option>
                                <option value="6 Nights 7 Days" {{ $package->duration == '6 Nights 7 Days' ? 'selected' : '' }}>6 Nights 7 Days</option>
                            </select>
                        </div>                        

                          <div class="form-group mb-3">
                            <label for="rprice">Regular Price</label>
                            <input type="text" value="{{ $package->ragular_price }}" class="form-control" id="rprice" name="ragular_price">
                      </div>

                          <div class="form-group mb-3">
                            <label for="oprice">Offer Price</label>
                            <input type="text" value="{{ $package->offer_price }}" class="form-control" id="oprice" name="offer_price">
                      </div>  
                      <div class="form-group">
                      <img src="{{ asset('uploads/packages/'. $package->photo)}}" width="200" alt="">  
                      </div>                      
                          <div class="form-group mb-3">
                                <label for="image" >Photo*</label>
                                <input type="file" id="image" name="image">
                          </div>

                          <div class="row">

                            <div class="form-group col-md-4 mb-3">
                                <label for="name">Start Date</label>
                                 <input type="date" id="date" value="{{$package->start_date}}" name="start_date" class="form-control date" min="">
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="name">End Date</label>
                                 <input type="date" id="date" value="{{$package->end_date}}"  name="end_date" class="form-control" min="">
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="name">Last Booking Date</label>
                                <input type="date" id="date" value="{{$package->last_booking}}"  name="last_date" class="form-control" min="">
                          
                            </div>
                          </div>
  
                            <div class="form-group">
                              <label for="">Map</label>
                             <textarea name="map"  id="" cols="30" class="form-control" rows="2">{{$package->map }}</textarea>
                            </div>
  
                          
                          <div class="form-group mb-3">
                            <label for="name">Short Description</label>
                             <textarea name="short_description" class="form-control summernote" id="" cols="30" rows="3">{{$package->short_description }}</textarea>
                        </div>

                          <div class="form-group mb-3">
                                <label for="name">Description</label>
                               <textarea name="description" class="form-control summernote" id="summernote" cols="30" rows="3">{{$package->description}}</textarea>
                          </div>
                          
                          <div class="form-group mb-3">
                              <label for="name">Inclusions/Exclusions
                              </label>
                               <textarea name="location" class="form-control summernote" id="" cols="30" rows="3">{{ $package->location }}</textarea>
                          </div>


                          <div class="form-group mb-3">
                            <label for="name">Itinerary
                            </label>
                           <textarea name="itinerary" class="form-control summernote" id="summernote" cols="30" rows="3">{{ $package->itinerary }}</textarea>
                      </div>
                          <div class="form-group mb-3">
                            <label for="name">Policy
                            </label>
                           <textarea name="policy" class="form-control summernote" id="summernote" cols="30" rows="3">{{$package->policy }}</textarea>
                      </div>
                          <div class="form-group mb-3">
                            <label for="name">Terms
                            </label>
                           <textarea name="terms"  class="form-control summernote" id="summernote" cols="30" rows="3">{{$package->terms }}</textarea>
                      </div>

                          <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">SEO Information</h6>
                            </div>

                            <div class="card-body p-0">
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" value="{{$package->title }}" name="seo_title" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for="">Meta Description</label>
                                    <textarea name="seo_meta_description" class="form-control h_100" cols="30" rows="5">{{$package->meta_description }}</textarea>
                                </div>
                               
                            </div>

                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="inlineCheckbox1" name="status" value="1" {{$package->status == '1' ? 'checked':''}}>
                                    <label class="form-check-label" for="inlineCheckbox1">Show</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="inlineCheckbox2" name="status" {{$package->status == '0' ? 'checked':''}} value="0">
                                    <label class="form-check-label" for="inlineCheckbox2">Hide</label>
                                  </div>

                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                          </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->




@include('admin.layouts.footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
<script>
  $(document).ready(function() {
      $('#state').on('change', function() {
          var state_id = $(this).val();
          if (state_id) {
              $('#city').prop('disabled', false);
              $.getJSON(`/admin/cities/${state_id}`, function(data) {
                  $('#city').empty().append('<option value="">Select City</option>');
                  $('#city').append(
                      data.map(function(city) {
                          return `<option value="${city.id}">${city.city_name}</option>`;
                      })
                  );
              });
          } else {
              $('#city').empty().append('<option value="">Select City</option>').prop('disabled', true);
          }
      });
  });
</script>