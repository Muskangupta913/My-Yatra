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
                                    <h4 class="mb-4 text-gray-800"> {{$package->package_name}}</h4>
                                    
                                    <div class="card shadow">
                                        <div class="card-header bg-light">
                                            <h5 class="text-primary">Add Package Photo <a href="{{ route("package")}}" class="btn btn-primary btn-sm float-right">Back to Package Page</a></h5>
                                        </div>
                                    <div class="card-body">
                                    <form action="{{ route('package.photos', $package->id)}}" method="post" enctype="multipart/form-data">
                                      @csrf
                                            <div class="form-group">
                                                <label for=""><b>Select Photo *</b></label><br>
                                                <input type="file" name="photo"  required>
                                            </div>
                                            <div class="form-group">
                                                
                                                <button type="submit" class="btn btn-success ">Submit</button>

                                            </div>
                                       
                                        
                                    </form>
                                     </div>
                                    </div>
                                    
                                    
                                   {{-- manage photos table --}}
                                        <div class="card mt-5 shadow">
                                            <div class="card-header">
                                                <h5 class="fw-bold text-dark">All Existing Photos  <a href="{{ route("package")}}" class="btn btn-primary btn-sm float-right">Back to Package Page</a></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Photo</th>
                                                              
                                                                <th>Delete</th>
                                                             
                                                            </tr>
                                                        </thead>
                                                      
                                                        <tbody>
                                                            @php
                                                                $i = 1;
                                                            @endphp
                                                           
                                                           @foreach ($photos as $item)

                                                           <tr>
                                                            <td>{{$i++}}</td>
                                                            <td> <img src="{{ asset('uploads/packages/'.$item->photo)}}" width="200px" alt=""></td>
                                                            
                                                                {{-- <td><a href="{{route('package.photo.edit')}}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a></td> --}}
                                                                <td><button type="button" class="btn btn-danger delete btn-sm" data-id="{{$item->id}}" ><i class="fas fa-trash"></i></a></td>
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
            <form action="{{ route("package.photo.delete")}}" method="POST">
                @csrf
            <input type="hidden" id="packageId" name="id">
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
            $('#packageId').val(id)
        
        });
    });
</script>