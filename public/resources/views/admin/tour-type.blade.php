@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@include('admin.layouts.navbar')


                                <!-- Begin Page Content -->
                                <div class="container-fluid">

                                    <!-- Page Heading -->
                                    <h1 class="h3 mb-2 text-gray-800"> Manage Tour Type:</h1>
                                    
                                
                                    <form action="{{ route('createTour')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-9">
                                                <label for="">Tour Name</label>
                                                <input type="text" name="tour" class="form-control" placeholder="Enter Tour Type Name" required>

                                                @error('tour')
                                                <small>{{ message }}</small>
                                                @enderror
                                               
                                                    @if(session('error'))
                                                    <small class="text-danger fw-bold">
                                                            {{ session('success') }}
                                                        </small>
                                                @endif
                                               
                                            </div>
                                            <div class="form-group col-md-3 mb-3">
                                                
                                                <button type="submit" class="btn w-100 btn-success " style="margin-top: 30px">Add Tour</button>

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
                                                            <th>Name</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                         
                                                        </tr>
                                                    </thead>
                                                  
                                                    <tbody>
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach ($tourtype as $item)
                                
                                                        <tr>
                                                            <td>{{$i++}}</td>
                                                            <td>{{$item->name}}</td>
                                                            <td><a href="{{ route('editTour', $item->id) }}" class="btn btn-warning btn-sm">Edit</a></td>

                                                            <td><button type="button" class="btn btn-danger delete btn-sm" data-id="{{$item->id}}" >Delete</a></td>
                                                            
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
            <form action="" method="POST">
                @csrf
            <input type="hidden" id="tourtypeid" name="id">
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
            $('#tourtypeid').val(id)
        
        });
    });
</script>

        