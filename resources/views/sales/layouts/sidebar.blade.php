<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #2f2f48 !important;" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('sales.dashboard')}}">
        <div class="sidebar-brand-text mx-3">MMBY Sales</div>
    </a>
    
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('sales.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    
    <!-- Heading -->
    <div class="sidebar-heading">
        Packages
    </div>
    
    <!-- Nav Item - Destination -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sales.destination')}}">
            <i class="fas fa-thumbtack"></i>
            <span>Destinations</span></a>
    </li>

    <!-- Nav Item - Tour Type -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sales.tourType')}}">
            <i class="fas fa-box"></i>
            <span>Tour Type</span></a>
    </li>

    <!-- Nav Item - City -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sales.city')}}">
            <i class="fas fa-city"></i>
            <span>City</span></a>
    </li>
 <!-- Nav Item - Places -->
 <li class="nav-item">
    <a class="nav-link" href="{{ route('visit_places')}}">
        <i class="fas fa-city"></i>
        <span>Places</span></a>
</li>

    <!-- Nav Item - Package -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sales.package')}}">
            <i class="fas fa-box"></i>
            <span>Packages</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    <!-- Heading -->
    <div class="sidebar-heading">
        Booking
    </div>

    <!-- Nav Item - Manage Booking -->
    <li class="nav-item">
        <a href="{{ route('sales.booking')}}" class="nav-link">
            <i class="fas fa-fw fa-cog"></i>
            <span>Manage Booking</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Website Applied Data -->
    <div class="sidebar-heading">
        Website Applied Data
    </div>
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Website Applied Data</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Website Applied Data:</h6>
                <!-- <a class="collapse-item" href="{{ route('jobData')}}">Job Data</a> -->
                <a class="collapse-item" href="{{ route('sales.contactData')}}">Contact Data</a>
                <a class="collapse-item" href="#">Subscription</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
</ul>
<!-- End of Sidebar -->
