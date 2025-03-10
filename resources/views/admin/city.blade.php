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
                                    <h1 class="h3 mb-2 text-gray-800"> Manage City:</h1>
                                    
                                
                                    <form action="{{ route('city.create')}}" method="post">
                                        @csrf
                                        <div class="row">

                                            <div class="form-group col-md-3">
                                                <label for="">Select State</label>
                                              <select name="state" class="form-control" id="">
                                                <option selected hidden>Select State</option>
                                                @foreach ($states as $state)
                                                <option value="{{$state->id}}">{{$state->destination_name}}</option>
                                                @endforeach
                                              </select>
                                              @error('state')
                                              <small class="text-danger">{{ $message }}</small>
                                                  
                                              @enderror
                                            </div>
                    
                                            <div class="form-group col-md-6">
                                                <label for="">City Name</label>
                                                <input type="text" name="city" class="form-control" placeholder="Enter city name" required>

                                                @error('city')
                                                <small class="text-danger">{{ message }}</small>
                                                @enderror
                                               
                                               
                                            </div>
                                            <div class="form-group col-md-3 mb-3">
                                                
                                                <button type="submit" class="btn w-100 btn-success " style="margin-top: 30px">Add City</button>

                                            </div>
                                        </div>
                                        
                                    </form>


                                    <!-- DataTales Example -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">View Tour Type </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>State</th>
                                                            <th>City</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                         
                                                        </tr>
                                                    </thead>
                                                  
                                                    <tbody>
                                                        @php
                                                            $i = 1;
                                                        @endphp

                                                        @foreach ($cities as $city)
                                                        <tr>
                                                            <td>{{$i++}}</td>
                                                            <td>{{ $city->destination ? $city->destination->destination_name : 'N/A' }}</td>
                                                            <td>{{$city->city_name}}</td>
                                                            <td><a href="{{ route('cityEdit', $city->id)}}" class="btn btn-warning btn-sm">Edit</a></td>
                                                            <td>
                                                                <form action="{{ route('cityDelete')}}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$city->id}}">
                                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                                </form>
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


                                {{-- modal --}}

                                       
  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="card-body">
            
            <h5>Are you sure want to delete?</h5>
            <form action="{{ route('cityDelete')}}" method="POST">
                @csrf
            <input type="hidden" id="cityId" name="id">
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
            $('#cityId').val(id)
        
        });
    });
</script>

