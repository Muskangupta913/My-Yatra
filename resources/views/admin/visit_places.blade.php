@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@include('admin.layouts.navbar')

<!-- Begin Page Content -->
<div class="container-fluid">

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Manage Visit Places:</h1>

    <form action="{{ route('visit_places.create') }}" method="post">
        @csrf
        <div class="row">
            <div class="form-group col-md-3">
                <label for="">Select State</label>
                <select name="state" class="form-control">
                    <option selected hidden>Select State</option>
                    @foreach ($states as $state)
                    <option value="{{ $state->id }}">{{ $state->destination_name }}</option>
                    @endforeach
                </select>
                @error('state')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label for="">Select City</label>
                <select name="city" class="form-control">
                    <option selected hidden>Select City</option>
                    @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                    @endforeach
                </select>
                @error('city')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="">Visit Places</label>
                <input type="text" name="place_name" class="form-control" placeholder="Enter place name" required>
                @error('place_name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-3 mb-3">
                <button type="submit" class="btn w-100 btn-success" style="margin-top: 30px">Add Visit Places</button>
            </div>
        </div>
    </form>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">View Visit Places</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Visit Place</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($visitPlaces as $place)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $place->state ? $place->state->destination_name : 'N/A' }}</td>
                            <td>{{ $place->city ? $place->city->city_name : 'N/A' }}</td>
                            <td>{{ $place->place_name }}</td>
                            <td><a href="{{ route('visit_placesEdit', $place->id) }}" class="btn btn-warning btn-sm">Edit</a></td>
                            <td><button type="button" class="btn btn-danger delete btn-sm" data-id="{{ $place->id }}">Delete</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card-body">
                <h5>Are you sure want to delete?</h5>
                <form action="{{ route('visit_placesDelete') }}" method="POST">
                    @csrf
                    <input type="hidden" id="placeId" name="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('admin.layouts.footer')

<script>
    $(document).ready(function(){
        $('.delete').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $('#deleteModal').modal('show');
            $('#placeId').val(id);
        });
    });
</script>

