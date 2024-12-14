@include('sales.layouts.header')
@include('sales.layouts.sidebar')
@include('sales.layouts.navbar')

<div class="container-fluid">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Card Payment Details</h1>
        <div class="form-group col-md-3"></div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">View Card Payment Details</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Total Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($cardDetails as $index => $detail)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $detail->name }}</td>
                                    <td>{{ $detail->email }}</td>
                                    <td>{{ $detail->mobile_no }}</td>
                                    <td>{{ number_format($detail->total_amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($detail->created_at)->format('d M Y') }}</td>
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

@include('sales.layouts.footer')
