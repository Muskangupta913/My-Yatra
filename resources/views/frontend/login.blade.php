<div class="container">
    <div class="row">
      <div class="card search-engine-card py-5 px-4" style="position: relative">
        <!-- Modified: Added custom responsive classes that hide text on mobile -->
        <ul class="nav nav-tabs border-0" 
            style="position: absolute; top:0; left:1%; transform:translateY(-50%); width: 95%;"
            id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link px-3 px-md-4 shadow border-0" id="flight-tab" data-bs-toggle="tab" data-bs-target="#flight"
              type="button" role="tab" aria-controls="flight" aria-selected="false">
              <i class="fa-solid fa-plane-departure d-block"></i>
              <!-- Modified: Added d-none d-md-block to hide on mobile, show on medium screens and up -->
              <small class="d-none d-md-block">Flight</small>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-3 px-md-4 shadow border-0" id="profile-tab" data-bs-toggle="tab"
              data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
              <i class="fa-solid fa-building d-block"></i>
              <!-- Modified: Added d-none d-md-block to hide on mobile -->
              <small class="d-none d-md-block">Hotel</small>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link active px-3 px-md-4 border-0 shadow" id="contact-tab" data-bs-toggle="tab"
              data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
              <i class="fa-solid fa-umbrella-beach d-block"></i>
              <!-- Modified: Added d-none d-md-block to hide on mobile -->
              <small class="d-none d-md-block">Holidays</small>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-3 px-md-4 shadow border-0" id="bus-tab" data-bs-toggle="tab" data-bs-target="#bus"
              type="button" role="tab" aria-controls="bus" aria-selected="false">
              <i class="fa-solid fa-bus d-block"></i>
              <!-- Modified: Added d-none d-md-block to hide on mobile, replaced <br> with d-block on icon -->
              <small class="d-none d-md-block">Bus</small>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-3 px-md-4 shadow border-0" id="car-tab" data-bs-toggle="tab" data-bs-target="#car"
              type="button" role="tab" aria-controls="car" aria-selected="false">
              <i class="fa-solid fa-car d-block"></i>
              <!-- Modified: Added d-none d-md-block to hide on mobile, replaced <br> with d-block on icon -->
              <small class="d-none d-md-block">Car</small>
            </button>
          </li>
        </ul>
        
        <!-- Tab content would go here -->
        
      </div>
    </div>
</div>