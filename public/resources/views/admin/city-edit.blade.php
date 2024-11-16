@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@include('admin.layouts.navbar')


                      <!-- Begin Page Content -->
                                <div class="container-fluid">

                                    <!-- Page Heading -->
                                    {{-- <h1 class="h3 mb-2 text-gray-800"> Update City:</h1> 
                                    --}}

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
                                            <h5>Edit City <a href="{{ route('city')}}" class="btn btn-primary btn-sm float-right">Back</a></h5>
                                        </div>
                                        <div class="card-body">
   
                                    <form action="{{ route('updateCity')}}" method="post">
                                      @csrf
                                        <div class="row">
                                            <div class="form-group col-md-9">
                                                <label for="">City Name</label>
                                                <input type="text"  value="{{$cityedit->city_name}}" name="city" class="form-control"  required>
                                                <input type="hidden" name="id" value="{{$cityedit->id}}">
                                               
                                            </div>
                                            <div class="form-group col-md-3 mb-3">
                                                
                                                <button type="submit" class="btn w-100 btn-success " style="margin-top: 30px">Update City</button>

                                            </div>
                                        </div>
                                        
                                    </form>

                                        </div>
                                    </div>
                        
                
                                </div>
                                <!-- /.container-fluid -->

@include('admin.layouts.footer')
        