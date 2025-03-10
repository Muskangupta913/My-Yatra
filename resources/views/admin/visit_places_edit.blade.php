@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@include('admin.layouts.navbar')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-header">
            <h5>Edit Visit Place <a href="{{ route('visit_places') }}" class="btn btn-primary btn-sm float-right">Back</a></h5>
        </div>
        <div class="card-body">
            <form action="{{ route('updatevisit_places') }}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="">Select State</label>
                        <select name="state" class="form-control">
                            <option selected hidden>Select State</option>
                            @foreach ($states as $state)
                            <option value="{{ $state->id }}" {{ $visitPlace->state_id == $state->id ? 'selected' : '' }}>{{ $state->destination_name }}</option>
                            @endforeach
                        </select>
                        @error('state')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="">Select City</label>
                        <select name="city" class="form-control">
                            <option selected hidden>Select City</option>
                            @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ $visitPlace->city_id == $city->id ? 'selected' : '' }}>{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                        @error('city')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="">Visit Place</label>
                        <input type="text" name="place_name" class="form-control" value="{{ $visitPlace->place_name }}" required>
                        @error('place_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-3 mb-3">
                        <button type="submit" class="btn w-100 btn-success" style="margin-top: 30px">Update Visit Place</button>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{ $visitPlace->id }}">
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@include('admin.layouts.footer')
