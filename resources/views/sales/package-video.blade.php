@include('sales.layouts.header')
@include('sales.layouts.sidebar')
@include('sales.layouts.navbar')


                      <!-- Begin Page Content -->
                                <div class="container-fluid">

                                    <!-- Page Heading -->
                                    <h4 class="mb-4 text-gray-800"> Videos of 3 days in Buenos Aires:</h4>
                                    
                                    <div class="card shadow">
                                        <div class="card-header bg-light">
                                            <h5 class="text-primary">Add Package Video <a href="{{ route("package")}}" class="btn btn-primary btn-sm float-right">Back to Package Page</a></h5>
                                        </div>
                                    <div class="card-body">
   
                                    <form action="{{ route('package.videos', $package->id)}}" method="post">
                                      @csrf
                                       
                                            <div class="form-group">
                                                <label for=""><b>Video Youtube Id *</b></label><br>
                                                <input type="text" name="video_youtube_id" class="form-control" required>

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
                                                <h5 class="fw-bold text-dark">All Existing Videos  <a href="{{ route("package")}}" class="btn btn-primary btn-sm float-right">Back to Package Page</a></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Photo</th>
                                                                <th>Edit</th>
                                                                <th>Delete</th>
                                                             
                                                            </tr>
                                                        </thead>
                                                      
                                                        <tbody>
                                                            @php
                                                                $i = 1;
                                                            @endphp
                                                           

                                                           @foreach ($videos as $item)
                                                               
                                                        
                                    
                                                            <tr>
                                                               
                                                                <td>{{$i++}}</td>
                                                                <td><iframe width="360" height="215" 
                                                                    src="https://www.youtube.com/embed/{{ $item->video_id }}" 
                                                                    title="YouTube video player" 
                                                                    frameborder="0" 
                                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                                    allowfullscreen>
                                                                </iframe></td>
                                                                
                                                                <td><a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                                                
                                                                
                                                            </tr>
                                                            @endforeach
                                                           
                                                         
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                  
                
                                </div>
                                <!-- /.container-fluid -->

@include('sales.layouts.footer')
        