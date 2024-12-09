@extends('frontend.layouts.master')
@section('content')

<style>
    /* General styles for responsiveness */
    .container-fluid {
        max-width: 100%;
        padding: 15px;
    }

    /* Sidebar Responsiveness */
    @media (max-width: 992px) {
        .col-lg-3 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
    }

    /* Bus card responsiveness */
    @media (max-width: 768px) {
        .bus-card {
            flex-direction: column;
            text-align: center;
        }

        .bus-card img {
            margin-bottom: 15px;
            max-width: 100%;
        }

        .bus-card .details, .bus-card .pricing {
            max-width: 100%;
        }

        .bus-card .pricing {
            margin-top: 20px;
        }

        .bus-card button {
            width: 100%;
        }
    }

    /* Filter toggle icon alignment */
    .toggle-icon {
        margin-left: auto;
        cursor: pointer;
    }
</style>

<div class="container-fluid mt-3 gx-5">
    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="sidebar">
                <h4 class="text-black">Filter Buses</h4>

                <!-- Price Section -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Price</h5>
                        <button class="btn btn-link text-white p-0 toggle-icon" type="button">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="FilterPrice">
                        <div class="card-body">
                            <label class="form-label">Select Price:</label>
                            <div class="list-group">
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price" value="below-10000">
                                    Below ₹300
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price" value="10000-20000">
                                    ₹300 - ₹500
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price" value="20000-35000">
                                    ₹500 - ₹1000
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price" value="above-35000">
                                    Above ₹1000
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Name Section -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Company Name</h5>
                        <button class="btn btn-link text-white p-0 toggle-icon" type="button">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="FilterCompany">
                        <div class="card-body">
                            <label class="form-label">Select Company Name:</label>
                            <div class="list-group">
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="company" value="mahindra">
                                    Mahindra & Mahindra Limited
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="company" value="tata">
                                    Tata Buses
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="company" value="boltbus">
                                    BoltBus
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Review Section -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Category</h5>
                        <button class="btn btn-link text-white p-0 toggle-icon" type="button">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="FilterReview">
                        <div class="card-body">
                            <label class="form-label">Select Category:</label>
                            <div class="list-group">
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="review" value="ac">
                                    AC
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="review" value="non-ac">
                                    NON AC
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="review" value="sleeper">
                                    Sleeper
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bus Details Section -->
        <div class="col-lg-9">
            <div class="bus-card d-flex justify-content-between flex-wrap border shadow-sm p-3 rounded mb-4" data-price="below-10000" data-company="mahindra" data-review="ac">
                <div class="details d-flex flex-wrap">
                     <!-- Left Section: Bus Image -->
        <div class="bus-image me-3">
            <img src="{{ asset('assets/images/bus.cms') }}" alt="Bus Image" class="rounded" style="width: 120px; height: 80px; object-fit: cover;">
        </div>
                    <div>
                        <h2 class="mb-1">Bus or Similar</h2>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success">4.4/5</span>
                            <span class="ms-2 text-muted">810 ratings</span>
                        </div>
                        <p class="mt-2 text-muted">AC • 40 Seats • 1384 kms included</p>
                        <p class="mt-2"><strong>Fuel Type:</strong> Diesel</p>
                        <p><strong>Cancellation Policy:</strong> Free cancellation up to 24 hours before departure.</p>
                    </div>
                </div>
                <div class="pricing text-end">
                    <p class="mb-1 text-decoration-line-through text-muted">₹40,626</p>
                    <p class="fw-bold text-danger">₹33,286</p>
                    <p class="text-muted small">+ ₹2054 (Taxes & Charges)</p>
                    <button class="btn btn-primary w-100">BOOK NOW</button>
                    <p class="text-muted mt-2 small">✨ Roof carrier available from ₹158</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Filter Functionality
        const checkboxes = document.querySelectorAll('.filter-checkbox');
        const busItems = document.querySelectorAll('.bus-card');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', filterBuses);
        });

        function filterBuses() {
            const filters = { price: [], company: [], review: [] };

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    filters[cb.dataset.filter].push(cb.value);
                }
            });

            busItems.forEach(item => {
                const matchesPrice = filters.price.length === 0 || filters.price.includes(item.dataset.price);
                const matchesCompany = filters.company.length === 0 || filters.company.includes(item.dataset.company);
                const matchesReview = filters.review.length === 0 || filters.review.includes(item.dataset.review);

                item.style.display = matchesPrice && matchesCompany && matchesReview ? '' : 'none';
            });
        }

        // Toggle Icon
        const toggleButtons = document.querySelectorAll('.toggle-icon');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function () {
                const icon = this.querySelector('i');
                const collapseTarget = this.closest('.card').querySelector('.collapse');

                if (collapseTarget.classList.contains('show')) {
                    collapseTarget.classList.remove('show');
                    icon.classList.replace('bi-chevron-down', 'bi-chevron-up');
                } else {
                    collapseTarget.classList.add('show');
                    icon.classList.replace('bi-chevron-up', 'bi-chevron-down');
                }
            });
        });
    });
</script>
@endsection
