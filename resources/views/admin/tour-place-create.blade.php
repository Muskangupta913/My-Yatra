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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Tour Place</h1>
        <a href="{{ route('tourPlace')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Tour Places
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tour Place Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('tourPlace.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="state"><i class="fas fa-map fa-sm mr-1"></i> Select State</label>
                            
                            <!-- FIXED STATE DROPDOWN: Directly fetch from DB in the view -->
                            <select name="state_id" class="form-control" id="state" required>
                                <option value="">Select State</option>
                                @php
                                    // Directly query the database for states
                                    $statesList = DB::table('states')->get();
                                @endphp
                                
                                @foreach ($statesList as $state)
                                    <option value="{{ $state->id }}">
                                        @php
                                            // Check which field exists and use it
                                            if(property_exists($state, 'state_name')) {
                                                echo $state->state_name;
                                            } elseif(property_exists($state, 'name')) {
                                                echo $state->name;
                                            } else {
                                                // Dump all available fields to see what's actually in the database
                                                $fields = get_object_vars($state);
                                                // Find a field that might contain the state name
                                                $nameField = null;
                                                foreach ($fields as $key => $value) {
                                                    if (is_string($value) && $key != 'id' && $key != 'created_at' && $key != 'updated_at') {
                                                        $nameField = $key;
                                                        break;
                                                    }
                                                }
                                                
                                                if ($nameField) {
                                                    echo $state->$nameField;
                                                } else {
                                                    echo "State #" . $state->id;
                                                }
                                            }
                                        @endphp
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('state_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="city"><i class="fas fa-city fa-sm mr-1"></i> Select City</label>
                            <select name="city_id" class="form-control" id="city" required disabled>
                                <option value="">Select City</option>
                            </select>
                            @error('city_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name"><i class="fas fa-tag fa-sm mr-1"></i> Tour Place Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="price"><i class="fas fa-rupee-sign fa-sm mr-1"></i> Price</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description"><i class="fas fa-align-left fa-sm mr-1"></i> Description</label>
                    <textarea name="description" class="form-control summernote" id="description" cols="30" rows="5" required></textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="photo"><i class="fas fa-image fa-sm mr-1"></i> Photo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="photo" name="photo" required>
                                <label class="custom-file-label" for="photo">Choose file</label>
                            </div>
                            @error('photo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="video"><i class="fas fa-video fa-sm mr-1"></i> Video URL</label>
                            <input type="text" class="form-control" id="video" name="video" placeholder="YouTube or Vimeo URL">
                            @error('video')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Save Tour Place
                    </button>
                    <a href="{{ route('tourPlace') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </a>
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
        // Initialize the summernote editor if available
        if(typeof $.fn.summernote !== 'undefined') {
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }
        
        // Custom file input label update
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
        
        // Dependent dropdown for cities
        $('#state').on('change', function() {
            var state_id = $(this).val();
            if (state_id) {
                $('#city').prop('disabled', false);
                
                // Show loading state
                $('#city').html('<option>Loading cities...</option>');
                
                $.ajax({
                    url: `/admin/cities/${state_id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#city').empty().append('<option value="">Select City</option>');
                        $.each(data, function(key, city) {
                            $('#city').append(`<option value="${city.id}">${city.city_name}</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading cities:', error);
                        $('#city').empty().append('<option value="">Error loading cities</option>');
                    }
                });
            } else {
                $('#city').empty().append('<option value="">Select City</option>').prop('disabled', true);
            }
        });
    });
</script>