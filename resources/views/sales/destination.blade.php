@include('sales.layouts.header')
@include('sales.layouts.sidebar')
@include('sales.layouts.navbar')

        <div class="container-fluid">
                                <!-- Begin Page Content -->
                                <div class="container-fluid">

                                    <!-- Page Heading -->
                                    <h1 class="h3 mb-2 text-gray-800">Destination</h1>
                                    <div class="form-group col-md-3"></div>
                                    
                                    <!-- DataTales Example -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h3 class="m-0 font-weight-bold text-primary">View Destinations </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Name</th>
                                                            <th>Heading</th>
                                                            <th>Photo</th>
                                                            <!-- <th>Edit</th>
                                                            <th>Delete</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($destinations as $destination)

                                                        <tr>
                                                            <td>{{$destination->id}}</td>
                                                            <td>{{$destination->destination_name}}</td>
                                                            <td>{{$destination->heading}}</td>
                                                            <td><img src="{{asset('uploads/destination/'.$destination->photo)}}" width="140" alt=""></td>
                                                            <!-- <td><a href="{{ route('destination.edit', $destination->id)}}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a></td>
                                                            <td><button type="button" class="btn btn-danger delete btn-sm" data-id="{{$destination->id}}" ><i class="fas fa-trash"></i></button></td> -->
                                                        </tr>
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                
                                </div>
                                <!-- /.container-fluid -->
        </div>

        <!-- Modal -->
        <!-- <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="card-body">
                    
                    <h5>Are you sure want to delete?</h5>
                    <form action="{{ route("destination.delete")}}" method="POST">
                        @csrf
                    <input type="hidden" id="destinationId" name="id">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-danger">Yes</button>
                </form>
                </div>
              </div>
            </div>
          </div> -->
                     
        
        @include('sales.layouts.footer')
                
        <script>
            $(document).ready(function(){
                $('.delete').click(function(e){
                    e.preventDefault();
                    var id = $(this).data('id');
                
                    $('#deleteModal').modal('show');
                    $('#destinationId').val(id)
                
                });
            });
        </script>