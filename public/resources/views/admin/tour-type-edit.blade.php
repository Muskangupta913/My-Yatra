@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@include('admin.layouts.navbar')


                      <!-- Begin Page Content -->
                                <div class="container-fluid">

                                    <!-- Page Heading -->
                                    <h1 class="h3 mb-2 text-gray-800"> Update Tour Type:</h1>
                                    
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Edit Tour Type <a href="{{ route('tourType')}}" class="btn btn-primary btn-sm float-right">Back</a></h5>
                                        </div>
                                        <div class="card-body">
   
                                    <form action="{{ route('updateTour')}}" method="post">
                                      @csrf
                                        <div class="row">
                                            <div class="form-group col-md-9">
                                                <label for="">Tour Name</label>
                                                <input type="text"  value="{{$data->name}}" name="tour" class="form-control"  required>
                                                <input type="hidden" name="id" value="{{$data->id}}">
                                               
                                            </div>
                                            <div class="form-group col-md-3 mb-3">
                                                
                                                <button type="submit" class="btn w-100 btn-success " style="margin-top: 30px">Update Tour</button>

                                            </div>
                                        </div>
                                        
                                    </form>

                                        </div>
                                    </div>
                        
                
                                </div>
                                <!-- /.container-fluid -->

@include('admin.layouts.footer')
        