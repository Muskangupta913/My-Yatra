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
    <h1 class="h3 mb-2 text-gray-800">Tour Places</h1>
    <a href="{{ route('tourPlace.create') }}" class="btn btn-primary mb-3">Add Tour Place</a>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tour Places</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Photo</th>
                            <th>Video</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tourPlaces as $tourPlace)
                        <tr>
                            <td>{{ $tourPlace->id }}</td>
                            <td>{{ $tourPlace->state->destination_name }}</td>
                            <td>{{ $tourPlace->city->city_name }}</td>
                            <td>{{ $tourPlace->name }}</td>
                            <td>{{ $tourPlace->description }}</td>
                            <td>{{ $tourPlace->price }}</td>
                            <td><img src="{{ asset('storage/' . $tourPlace->photo) }}" width="100" alt=""></td>
                            <td>{{ $tourPlace->video }}</td>
                            <td>
                                <a href="{{ route('tourPlace.edit', $tourPlace->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

@include('admin.layouts.footer')
