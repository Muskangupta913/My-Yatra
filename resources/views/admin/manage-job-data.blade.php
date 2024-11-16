@include('admin.layouts.header')
@include('admin.layouts.sidebar')
@include('admin.layouts.navbar')

                                <!-- Begin Page Content -->
                                <div class="container-fluid">
                                    <!-- Page Heading -->
                                    <h1 class="h3 mb-2 text-gray-800">Manage Job Application</h1>
                                    
                                    <!-- DataTales Example -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Manage Job Application </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Adhar Number</th>
                                                            <th>DOB</th>
                                                            <th>Pin</th>
                                                            <th>Category</th>
                                                            <th>State</th>
                                                            <th>Photo</th>
                                                            <th>Document</th>
                                                            <th>Applied Date</th>
                                                        </tr>
                                                    </thead>
                                                
                                                    <tbody>
@php
    $i = 1;
@endphp
                                                       @foreach ($jobApplications as $item)
                                                        <tr>
                                                            <td>{{$i++}}</td>
                                                            <td>{{$item->name}}</td>
                                                            <td>{{$item->email}}</td>
                                                            <td>{{$item->phone}}</td>
                                                            <td>{{$item->adhar_number}}</td>
                                                            <td >{{$item->dob}}</td>
                                                            <td>{{$item->pincode}}</td>
                                                            <td>{{$item->category}}</td>
                                                            <td>{{$item->state}}</td>
                                                         <td><a href="{{ asset("storage/$item->photo") }}" target="_blank"> Photo</a></td>
                                                            <td><a href="{{ asset("storage/$item->certificate") }}" target="_blank">Document</a></td>
                                                       
                                                          <td>{{$item->created_at}}</td>
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
                
     