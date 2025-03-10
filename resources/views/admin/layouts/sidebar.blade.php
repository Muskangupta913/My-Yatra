<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #2f2f48 !important;" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard')}}">
    
    <div class="sidebar-brand-text mx-3">MMBY Admin  <sup></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{ route('admin.dashboard')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Packages
</div>

<!-- Nav Item - Pages Collapse Menu -->
{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Pages</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
        </div>
    </div>
</li> --}}

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('destination')}}">
        <i class="fas fa-thumbtack"></i>
        <span>Destinations</span></a>
</li>
    

<!-- Nav Item - Charts -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('tourType')}}">
        <i class="fas fa-box"></i>
        <span>Tour Type</span></a>
</li>

 <!-- Nav Item - Charts -->
 <li class="nav-item">
    <a class="nav-link" href="{{ route('city')}}">
        <i class="fas fa-city"></i>
        <span>City</span></a>
</li>

 <!-- Nav Item - Places -->
 <li class="nav-item">
    <a class="nav-link" href="{{ route('visit_places')}}">
        <i class="fas fa-city"></i>
        <span>Places</span></a>
</li>

<!-- Nav Item - Charts -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('package')}}">
        <i class="fas fa-box"></i>
        <span>Packages</span></a>
</li>

<!-- Nav Item - Tour Place -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('tourPlace')}}">
        <i class="fas fa-map-marker-alt"></i>
        <span>Tour Place</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">


 <!-- Heading -->
 <div class="sidebar-heading">
     Booking
 </div>
 

 <li class="nav-item">
    <a href="{{ route('booking')}}" class="nav-link"> <i class="fas fa-fw fa-cog"></i> <span>Manage Booking</span></a>
 </li>
 <!-- Nav Item - Pages Collapse Menu -->
 {{-- <li class="nav-item">
     <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
         aria-expanded="true" aria-controls="collapseTwo">
         <i class="fas fa-fw fa-cog"></i>
         <span>Manage Booking</span>
     </a>
     <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header">Custom Components:</h6>
             <a class="collapse-item" href="buttons.html">Buttons</a>
             <a class="collapse-item" href="cards.html">Cards</a>
         </div>
     </div>
 </li>
  --}}
 <!-- Nav Item - Utilities Collapse Menu -->
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
             <a class="collapse-item" href="{{ route('jobData')}}">Job Data</a>
             <a class="collapse-item" href="{{ route('contactData')}}">Contact Data</a>
             <a class="collapse-item" href="">Subscription</a>
         </div>
     </div>
 </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>


</ul>
<!-- End of Sidebar -->


 <!-- Content Wrapper -->
 <div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">