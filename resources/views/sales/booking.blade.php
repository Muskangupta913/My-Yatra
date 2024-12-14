@include('sales.layouts.header')
@include('sales.layouts.sidebar')
@include('sales.layouts.navbar')


   
                                <!-- Begin Page Content -->
                                <div class="container-fluid">

                                    <!-- Page Heading -->
                                    <h1 class="h3 mb-2 text-gray-800">Manage Booking</h1>
                                    <div class="form-group col-md-3"></div>
                                    

                                    <!-- DataTales Example -->
                                    <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                            <h3 class="font-weight-bold text-primary"> Manage Booking
                                        <a href="" class="btn btn-dark float-right rounded-0 btn-sm ">New Booking</a>

                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive" style="overflow-x:auto;">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Adults</th>
                                                            <th>Travel Date</th>                                                           
                                                            <th>Booked At</th>
                                                            <!-- <th>Action</th> -->
                                                        </tr>
                                                    </thead>
                                                   
                                                    <tbody>
                                                    @php
                                                      $i = 1;
                                                    @endphp
                                                        @foreach ($bookings as $item)
                                                     
                                                        <tr>
                                                            <td>{{ $i++}}</td>
                                                            <td>{{$item->full_name}}</td>
                                                            <td>{{$item->phone}}</td>
                                                            <td>{{$item->email}}</td>
                                                            <td>{{$item->adults}}</td>
                                                           
                                                            <td>{{ \Carbon\Carbon::parse($item->travel_date)->format('d/m/Y') }}</td>
                                                            
                                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y h:i A') }}</td>
                                                           
                                                            <!-- <td>
                                                                <a href="{{ route('booking.edit', $item->id)}}" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i></a>
                                                                <a href="{{ route('booking.show', $item->id)}}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> </a>
                                                

                                                            </td> -->
                                                      
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
        