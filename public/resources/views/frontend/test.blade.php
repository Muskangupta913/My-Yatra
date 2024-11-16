
<!-- DEBUG-VIEW START 6 APPPATH/Views/template/default-layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip4book Meta Title- Book Flight Tickets, Hotels, Volvo, Holiday Packages</title>
    <meta name="keywords" content="Trip4book Meta Keyword - Book Flight Tickets, Hotels, Volvo, Holiday Packages">
    <meta name="description" content="Trip4book Meta Description - Book Flight Tickets, Hotels, Volvo, Holiday Packages">
    <meta name="robots" content="INDEX, FOLLOW">
    <link rel="shortcut icon" href="https://trip4book.com/uploads/favicon/1722927000_trip4book-final-logo.jpg" type="image/x-icon" />
    <link rel="apple-touch-icon" href="https://trip4book.com/uploads/favicon/1722927000_trip4book-final-logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://trip4book.com/webroot/vendor/bootstrap/css/bootstrap.css?1668248918">
    <link rel="stylesheet" href="https://trip4book.com/webroot/css/jquery-ui.min.css?1696654605">
    <link rel="stylesheet" href="https://trip4book.com/webroot/vendor/select2/select2.min.css?1668248915">
    <link rel="stylesheet" href="https://trip4book.com/webroot/css/custom.css?1722332039">
    <link rel="stylesheet" href="https://trip4book.com/webroot/css/flight_result.css?1708764127">
    <link rel="stylesheet" href="https://trip4book.com/webroot/css/owl.carousel.css?1696654605">
    <link rel="stylesheet" href="https://trip4book.com/webroot/css/owl.theme.css?1696654605">

            <link rel="stylesheet" href="https://trip4book.com/webroot/css/wl_header/header.css?1710742968">
    
            <link rel="stylesheet" href="https://trip4book.com/webroot/css/wl_search/search1.css?1713963378">
    
            <link rel="stylesheet" href="https://trip4book.com/webroot/css/wl_footer/footer.css?1721382714">
    
    
    <script type="text/javascript" src="https://trip4book.com/webroot/vendor/bootstrap/js/bootstrap.bundle.min.js?1668248920"></script>
    <script type="text/javascript" src="https://trip4book.com/webroot/js/jquery.min.js?1696654555"></script>
    <script type="text/javascript" src="https://trip4book.com/webroot/js/jquery-ui.min.js?1696654554"></script>
    <script type="text/javascript" src="https://trip4book.com/webroot/js/angular.min.js?1702122511"></script>

    <style>
        .note-editable {
            font-family: 'Poppins' !important;
            font-size: 15px !important;
            text-align: left !important;

            height: 350px !important;

        }
    </style>

</head>

<body>


<div class="def_layout_content">

<section class="search_form_section">
   <div class="hero-banner">
               <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">

                           <div class="carousel-item active" style="background-image:url(https://trip4book.com/uploads/sliders/1713963120_pngtree-blue-minimalist-flat-travel-banner-background-image_223018.jpg);">

               </div>
            
         </div>
         </div>
   <div class="container">
      <div class="row">
         <div class="col-md-12 m-auto">
            <div class="page-content search_form_box">
               <div class="tts_product_box">
                  <div class="searchtabslist">
                     <ul class=" search_tabs">
                                                   <li class="tab-link ">
                              <a href="https://trip4book.com/flight " class=" current flights">
                                 <span><i class="fa-solid fa-plane-departure"></i> Flight </span>
                              </a>
                           </li>
                                                                           <li class="tab-link ">
                              <a href="https://trip4book.com/cheap-hotel-deals " class="">
                                 <span> <i class="fa-solid fa-building"></i> Hotel </span>
                              </a>
                           </li>
                                                                           <li class="tab-link ">
                              <a href="https://trip4book.com/online-bus-ticket-booking " class="">
                                 <span><i class="fa-solid fa-bus"></i> Bus</span>
                              </a>
                           </li>
                                                                           <li class="tab-link ">
                              <a href="https://trip4book.com/holiday " class="">
                                 <span> <i class="fa-solid fa-umbrella-beach"></i> Holidays </span>
                              </a>
                           </li>
                                                                                                                                                                     </ul>
                  </div>
                <div id="flight" class="tab-content  current">
                        <!----radio----->
                        <div class="row">
                           <div class="col-12">
                              <div class="flight-search d-md-flex align-items-center justify-content-between">
                                 <div class="btn-group">
                                    <input id="1" class="form-check-input btn-check" type="radio" name="flightjtype" value="Oneway" onclick="checkflightJourneytype('Oneway')" checked>
                                    <label class="search-check-label btn btn-sm btn-secondary" for="1">Oneway</label>
                                    <input id="2" class="form-check-input btn-check" type="radio" name="flightjtype" value="Roundtrip" onclick="checkflightJourneytype('Roundtrip')">
                                    <label class="search-check-label btn btn-sm btn-secondary" for="2"> Round Trip </label>
                                    <input id="3" class="form-check-input btn-check" type="radio" name="flightjtype" value="Multicity" onclick="checkflightJourneytype('Multicity')">
                                    <label class="search-check-label btn btn-sm btn-secondary" for="3"> Multi City </label>
                                 </div>
                                 <div class="search-title">
                                    <h2>Book Flight Tickets</h2>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!----radio----->
                        <div class="row align-items-center">
                           <div class="tab-pane fade show active">
                              <form action="https://trip4book.com/flight/search" type="get" class="tts__form_wrapper" name="flight-form" flight-oneway-roundtrip-form="true">
                                 <input type="hidden" value="Oneway" name="journeytype">
                                 <ul class="row flight_search_border">
                                    <li class="col-lg-3 col-md-6 col-6 from">
                                       <label class="form-label">From </label>
                                       <input type="text" class="form-control tts__input__input tts-cursor-pointer" placeholder="Origin" value="Delhi" tts-flight-origin="true" data-validation="required" data-validation-error-msg="Please select from ">
                                       <input type="hidden" name="origin" value="Delhi (DEL), India">
                                       <div class="flight_text_p">[DEL] Indira Gandhi International</div>
                                       <span class="tts__interchange__arrow" alt="arrows" swape-city="true">
                                          <svg width="20" height="15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M14.11 6.739a.842.842 0 0 1-.842-.842V4.844a.21.21 0 0 0-.21-.211H4.543a1.264 1.264 0 1 1 0-2.527h8.515a.21.21 0 0 0 .21-.21V.841A.843.843 0 0 1 14.544.12l4.212 2.528a.842.842 0 0 1 0 1.444L14.544 6.62a.843.843 0 0 1-.433.12ZM.409 10.26l4.212-2.527a.842.842 0 0 1 1.276.723v1.053c0 .116.095.21.21.21h8.516a1.264 1.264 0 1 1 0 2.528H6.108a.21.21 0 0 0-.21.21v1.053a.842.842 0 0 1-1.277.722L.409 11.705a.842.842 0 0 1 0-1.445Z" fill="#000000"></path>
                                          </svg>
                                       </span>
                                    </li>
                                    <li class="col-lg-3 col-md-6 col-6  to">
                                       <div class="position-relative">
                                          <label class="form-label">To </label>
                                          <input type="text" class="form-control  tts__input__input tts-cursor-pointer" placeholder="Destination" value="Mumbai" tts-flight-destination="true" data-validation="required" data-validation-error-msg="Please select to airport">
                                          <input type="hidden" name="destination" value="Mumbai (BOM), India">
                                          <div class="flight_text_p">[BOM] Chhatrapati Shivaji</div>
                                       </div>
                                    </li>
                                    <li class="col-lg-3 col-md-12 col-12 depart">
                                       <div class="position-relative">
                                          <label class="form-label"><i class="fa-solid fa-calendar-days"></i> Depart <i class="fa-solid fa-angle-down"></i></label>
                                          <input type="text" class="form-control tts__input__input tts-cursor-pointer" name="departdate" placeholder="Depart" readonly value="13 Sep 24" data-validation="required" data-validation-error-msg="Please select departure date" flight-departure-date="true">
                                          <div class="flight_text_p">Friday</div>
                                       </div>
                                    </li>
                                    <li class="col-lg-3 col-md-12 col-12 return">
                                       <div class="position-relative" onclick="selectroundtripDate('Roundtrip')">
                                          <label class="form-label"><i class="fa-solid fa-calendar-days"></i> Return <i class="fa-solid fa-angle-down"></i></label>
                                          <input type="text" class="form-control tts__input__input flight-return-date-disable tts-cursor-pointer" name="returndate" readonly placeholder="" data-validation="required" data-validation-error-msg="Please select return date" flight-return-date="true">
                                          <div class="flight_text_p">Book a round trip to save more </div>
                                       </div>
                                    </li>
                                    <li class="col-lg-2 col-md-12 col-12 travellers">
                                       <div class="position-relative tts__dropdown__wrapper tts-cursor-pointer">
                                          <label class="form-label">Travellers & Class </label>
                                          <div id="select_flight_pax" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                             <h6 class="date" data-total-pax="true"> 1
                                                <span>Traveller(s)</span>
                                             </h6>
                                             <p class="cabinclass" flight-cabin-class="true"> Any</p>
                                          </div>
                                          <div class=" tts__dropdown__menu__right p-3 dropdown-menu" aria-labelledby="select_flight_pax" style="width: 300px;">
                                             <div class="row mb-3">
                                                <div class="col-md-12 col-12">
                                                   <div class="tts__traveller__select mt-0 d-flex align-items-center">
                                                      <h5>Adult</h5>
                                                      <div class="GwMit">
                                                         <span class="tts__counter" data-adult-pre="true">-</span>
                                                         <span class="tts_traveller__counter_span" data-adult-count="true">1</span>
                                                         <input class="form-control tts_traveller__counter" type="hidden" value="1" name="adults" adult-input="true">
                                                         <span class="tts__counter" data-adult-next="true">+</span>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-md-12 col-12 ">
                                                   <div class="tts__traveller__select mt-2 d-flex align-items-center">
                                                      <h5>Children <span class="tts__traveller__limit">(2y - 12y)</span></h5>
                                                      <div class="GwMit">
                                                         <span class="tts__counter" data-child-pre>-</span>
                                                         <span class="tts_traveller__counter_span" data-child-count="true">0</span>
                                                         <input class="form-control tts_traveller__counter" type="hidden" value="0" name="child" child-input="true">
                                                         <span class="tts__counter" data-child-next>+</span>
                                                      </div>

                                                   </div>
                                                </div>
                                                <div class="col-md-12 col-12 ">
                                                   <div class="tts__traveller__select mt-2 d-flex align-items-center">
                                                      <h5>Infant <span class="tts__traveller__limit">(below 2y)</span></h5>
                                                      <div class="GwMit">
                                                         <span class="tts__counter" data-infant-pre>-</span>
                                                         <span class="tts_traveller__counter_span" data-infant-count="true">0</span>
                                                         <input class="form-control tts_traveller__counter" type="hidden" value="0" name="infant" infant-input="true">
                                                         <span class="tts__counter" data-infant-next>+</span>
                                                      </div>

                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row gy-2">
                                                <h5>Choose travel class</h5>
                                                <div class="col-12">
                                                   <label class="tts__inputradio_label">
                                                      <input type="radio" name="cabinclass" value="Any" class="mr-1" onclick="changeCabinclass('Any' ,'flight-cabin-class')" checked> Any</label>
                                                </div>
                                                <div class="col-12">
                                                   <label class="tts__inputradio_label">
                                                      <input type="radio" name="cabinclass" value="Economy" class="mr-1" onclick="changeCabinclass('Economy','flight-cabin-class')">
                                                      Economy
                                                   </label>
                                                </div>
                                                <div class="col-12">
                                                   <label class="tts__inputradio_label">
                                                      <input type="radio" name="cabinclass" value="Business" class="mr-1" onclick="changeCabinclass('Business','flight-cabin-class')">
                                                      Business
                                                   </label>
                                                </div>
                                                <div class="col-12">
                                                   <label class="tts__inputradio_label">
                                                      <input type="radio" name="cabinclass" value="PremiumEconomy" class="mr-1" onclick="changeCabinclass('Premium  Economy' ,'flight-cabin-class')">
                                                      Premium Economy</label>
                                                </div>
                                                <div class="col-12">
                                                   <label class="tts__inputradio_label">
                                                      <input type="radio" name="cabinclass" value="PremiumBusiness" class="mr-1" onclick="changeCabinclass('Premium  Business' ,'flight-cabin-class')">
                                                      Premium
                                                      Business</label>
                                                </div>
                                                <div class="col-12">
                                                   <label class="tts__inputradio_label">
                                                      <input type="radio" name="cabinclass" value="First" class="mr-1" onclick="changeCabinclass('First' ,'flight-cabin-class')">
                                                      First</label>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </li>
                                    <li class="col-lg-1 col-md-3 col-12  btnarea">
                                       <button type="submit" class="oneway_btn oneway_search_btn btn" onclick="return checkFlightSearchValidation('flight-form');">Search </button>
                                    </li>
                                 </ul>
                                 <input type="hidden" class="form-check-input" name="direct_flight" value="0">
                                 <input type="hidden" name="preferred_carriers" id="PreferredCarriers">
                                 <input type="hidden" name="result_fare_type" resultFareType="true" value="RegularFare">
                              </form>
                              <form action="https://trip4book.com/flight/search" type="get" class="tts__form_wrapper" name="flight-multi-form" flight-multicity-form="true" style="display: none;">
                                 <input type="hidden" value="Multicity" name="journeytype">
                                 <input type="hidden" class="form-check-input" name="direct_flight" value="0">
                                 <div multicity-addmore class="flight-mult-city">
                                    <ul class="row flight_search_border " data-journey-key="0">
                                       <li class="col-lg-3 col-md-6 col-6 from">
                                          <div class="position-relative">
                                             <label class="form-label">From </label>
                                             <input type="text" class="form-control tts__input__input " placeholder="Origin" tts-flight-origin="true" data-validation="required" data-validation-error-msg="Please select from " value="Delhi" data-key="0">
                                             <input type="hidden" name="search_data[0][origin]" value="Delhi (DEL), India">
                                             <div class="flight_text_p">[DEL] Indira Gandhi International</div>
                                          </div>
                                       </li>
                                       <li class="col-lg-3 col-md-6 col-6 to">
                                          <div class="position-relative">
                                             <label class="form-label">To </label>
                                             <input type="text" class="form-control  tts__input__input" placeholder="Destination" tts-flight-destination="true" data-validation="required" value="Mumbai" data-validation-error-msg="Please select to airport" data-key="0">
                                             <input type="hidden" name="search_data[0][destination]" value="Mumbai (BOM), India">
                                             <div class="flight_text_p">[BOM] Chhatrapati Shivaji</div>
                                          </div>
                                       </li>
                                       <li class="col-lg-3 col-md-12 col-12 depart">
                                          <div class="position-relative">
                                             <label class="form-label"><i class="fa-solid fa-calendar-days"></i> Depart <i class="fa-solid fa-angle-down"></i></label>
                                             <input type="text" class="form-control tts__input__input tts-cursor-pointer" name="search_data[0][departdate]" placeholder="Depart Date" data-validation="required" data-validation-error-msg="Please select departure date" value="13 Sep 24" flight-departure-date="true" data-key="0" readonly>
                                             <div class="flight_text_p">Friday</div>
                                          </div>
                                       </li>
                                       <li class="col-lg-2 col-md-12 col-12 travellers">
                                          <div class="position-relative tts__dropdown__wrapper tts-cursor-pointer">
                                             <label class="form-label">Travellers & Class </label>
                                             <div id="select_flight_pax" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                <h6 class="date" data-total-pax="true"> 1
                                                   <span>Traveller(s)</span>
                                                </h6>
                                                <p class="cabinclass" flight-cabin-class="true"> Any</p>
                                             </div>
                                             <div class=" tts__dropdown__menu__right p-3 dropdown-menu" aria-labelledby="select_flight_pax" style="width: 300px;">
                                                <div class="row mb-3">
                                                   <div class="col-md-12 col-12">
                                                      <div class="tts__traveller__select mt-0 d-flex align-items-center">
                                                         <h5>Adult</h5>
                                                         <div class="GwMit">
                                                            <span class="tts__counter" style="margin-right: -5px;" data-adult-pre="true">-</span>
                                                            <span class="tts_traveller__counter_span" data-adult-count="true">1</span>
                                                            <input class="form-control tts_traveller__counter" type="hidden" value="1" name="adults" adult-input="true">
                                                            <span class="tts__counter" data-adult-next="true">+</span>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-12 col-12">
                                                      <div class="tts__traveller__select mt-0 d-flex align-items-center">
                                                         <h5>Children <span class="tts__traveller__limit">(2y - 12y)</span></h5>
                                                         <div class="GwMit">
                                                            <span class="tts__counter" style="margin-right: -5px;" data-child-pre>-</span>
                                                            <span class="tts_traveller__counter_span" data-child-count="true">0</span>
                                                            <input class="form-control tts_traveller__counter" type="hidden" value="0" name="child" child-input="true">
                                                            <span class="tts__counter" data-child-next>+</span>
                                                         </div>

                                                      </div>
                                                   </div>
                                                   <div class="col-md-12 col-12">
                                                      <div class="tts__traveller__select mt-0 d-flex align-items-center">
                                                         <h5>Infant <span class="tts__traveller__limit">(below 2y)</span></h5>
                                                         <div class="GwMit">
                                                            <span class="tts__counter" style="margin-right: -5px;" data-infant-pre>-</span>
                                                            <span class="tts_traveller__counter_span" data-infant-count="true">0</span>
                                                            <input class="form-control tts_traveller__counter" type="hidden" value="0" name="infant" infant-input="true">
                                                            <span class="tts__counter" data-infant-next>+</span>
                                                         </div>

                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="row gy-3">
                                                   <div class="col-12">
                                                      <label class="tts__inputradio_label">
                                                         <input type="radio" name="cabinclass" value="Any" class="mr-1" onclick="changeCabinclass('Any' ,'flight-cabin-class')" checked> Any</label>
                                                   </div>
                                                   <div class="col-12">
                                                      <label class="tts__inputradio_label">
                                                         <input type="radio" name="cabinclass" value="Economy" class="mr-1" onclick="changeCabinclass('Economy','flight-cabin-class')">
                                                         Economy
                                                      </label>
                                                   </div>
                                                   <div class="col-12">
                                                      <label class="tts__inputradio_label">
                                                         <input type="radio" name="cabinclass" value="Business" class="mr-1" onclick="changeCabinclass('Business','flight-cabin-class')">
                                                         Business
                                                      </label>
                                                   </div>
                                                   <div class="col-12">
                                                      <label class="tts__inputradio_label">
                                                         <input type="radio" name="cabinclass" value="PremiumEconomy" class="mr-1" onclick="changeCabinclass('Premium  Economy' ,'flight-cabin-class')">
                                                         Premium Economy</label>
                                                   </div>
                                                   <div class="col-12">
                                                      <label class="tts__inputradio_label">
                                                         <input type="radio" name="cabinclass" value="PremiumBusiness" class="mr-1" onclick="changeCabinclass('Premium  Business' ,'flight-cabin-class')">
                                                         Premium
                                                         Business</label>
                                                   </div>
                                                   <div class="col-12">
                                                      <label class="tts__inputradio_label">
                                                         <input type="radio" name="cabinclass" value="First" class="mr-1" onclick="changeCabinclass('First' ,'flight-cabin-class')">
                                                         First</label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </li>

                                    </ul>
                                    <ul class="row  align-items-center border-top-0 flight_search_border" data-journey-key="1">
                                       <li class="col-lg-3 col-md-6 col-6 from">
                                          <div class="position-relative">
                                             <label class="form-label">From</label>
                                             <input type="text" class="form-control tts__input__input tts__input__input1" name="search_data[1][origin]" placeholder="Origin" tts-flight-origin="true" value="Mumbai" data-validation="required" data-validation-error-msg="Please select from" data-key="1">
                                             <input type="hidden" name="search_data[1][origin]" value="Mumbai (BOM), India">
                                             <div class="flight_text_p">[BOM] Chhatrapati Shivaji</div>
                                          </div>
                                       </li>
                                       <li class="col-lg-3 col-md-6 col-6  to">
                                          <div class="position-relative">
                                             <label class="form-label">To</label>
                                             <input type="text" class="form-control  tts__input__input tts__input__input1" placeholder="Destination" tts-flight-destination="true" data-validation="required" data-validation-error-msg="Please select to airport" data-key="1">
                                             <input type="hidden" name="search_data[1][destination]">
                                             <div class="flight_text_p"></div>
                                          </div>
                                       </li>
                                       <li class="col-lg-3 col-md-12 col-12 depart">
                                          <div class="position-relative">
                                             <label class="form-label"> <i class="fa-solid fa-calendar-days"></i> Depart <i class="fa-solid fa-angle-down"></i></label>
                                             <input type="text" class="form-control tts__input__input tts-cursor-pointer tts__input__input1 tts__input__input2 " name="search_data[1][departdate]" placeholder="Depart Date" data-validation="required" data-validation-error-msg="Please select departure date" flight-departure-date="true" data-key="1" readonly>
                                             <div class="flight_text_p"></div>
                                          </div>
                                       </li>
                                       <li class="col-lg-1 col-md-3 col-12  btnarea search-flight">
                                          <button type="submit" class="oneway_btn oneway_search_btn btn" onclick="return checkFlightSearchValidation('flight-multi-form');"> Search </button>
                                          <button type="button" class="add-city btn" add-mult-city="true">Add City </button>
                                       </li>
                                    </ul>
                                 </div>
                                 <input type="hidden" name="preferred_carriers" id="PreferredCarriers">
                                 <input type="hidden" name="result_fare_type" resultFareType="true">
                              </form>
                           </div>
                        </div>
                        <div class="makeflex">
                           <span>Select A Fare Type</span>

                                                      <div class="search_filters">
                                                               <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="resultFareType" value="RegularFare" result-fare-type-filter="true" id="resultFareTypeRegularFare" checked>
                                    <label class="form-check-label" for="resultFareTypeRegularFare">Regular Fare</label>
                                 </div>
                                                               <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="resultFareType" value="StudentFare" result-fare-type-filter="true" id="resultFareTypeStudentFare" >
                                    <label class="form-check-label" for="resultFareTypeStudentFare">Student Fares</label>
                                 </div>
                                                               <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="resultFareType" value="SeniorCitizenFare" result-fare-type-filter="true" id="resultFareTypeSeniorCitizenFare" >
                                    <label class="form-check-label" for="resultFareTypeSeniorCitizenFare">Senior Citizen</label>
                                 </div>
                                                               <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="resultFareType" value="MilitaryFare" result-fare-type-filter="true" id="resultFareTypeMilitaryFare" >
                                    <label class="form-check-label" for="resultFareTypeMilitaryFare">Armed Forces</label>
                                 </div>
                                                         </div>
                           <!-- <div class="search_filters">
                              <div class="form-check form-check-inline form-check-border"><input type="checkbox" name="Nonstop" id="direct_flight" class="form-check-input" check-direct-flight="true"><label for="direct_flight" class="form-check-label">Non-Stop</label></div>
                              <span class="blackBorder"></span>
                              <div class="form-check form-check-inline"><input type="checkbox" class="form-check-input" id="inlineCheckbox6E" value="6E" airline-filter="true"><label class="form-check-label" for="inlineCheckbox6E">Indigo</label></div>
                              <div class="form-check form-check-inline"><input type="checkbox" class="form-check-input" id="inlineCheckboxUK" value="UK" airline-filter="true"><label class="form-check-label" for="inlineCheckboxUK">Vistara</label></div>
                              <div class="form-check form-check-inline"><input type="checkbox" class="form-check-input" id="inlineCheckboxAI" value="AI" airline-filter="true"><label class="form-check-label" for="inlineCheckboxAI">AirIndia</label></div>
                              <div class="form-check form-check-inline"><input type="checkbox" class="form-check-input" id="inlineCheckboxSG" value="SG" airline-filter="true"><label class="form-check-label" for="inlineCheckboxSG">Spice jet</label></div>
                              <div class="form-check form-check-inline"><input type="checkbox" class="form-check-input" id="inlineCheckboxG8" value="G8" airline-filter="true"><label class="form-check-label" for="inlineCheckboxG8">Go First</label></div>
                              <div class="form-check form-check-inline"><input type="checkbox" class="form-check-input" id="inlineCheckboxI5" value="I5" airline-filter="true"><label class="form-check-label" for="inlineCheckboxI5">Air Asia</label></div>
                           </div> -->
                        </div>
                     </div>
                                                                        
                                                                        <!-------Activities----Start------>
                                    <!-------Activities----end------>
                  <!-------tourguide----->
                                    <!-------tourguide----end------>
               </div>
            </div>
         </div>
      </div>
</section>
<!--------End Search Bar --------------->


<style>
    .moretext {
        display: none;
    }
</style>

    </div>
  
<input type="hidden" value="" id="web-partner-company-id">
<script type="text/javascript">
   var get_param = "";
   var DateFormat = "d M y";
</script>
<script type="text/javascript" src="https://trip4book.com/webroot/vendor/select2/select2.min.js"></script>
<script type="text/javascript" src="https://trip4book.com/webroot/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="https://trip4book.com/webroot/js/custom.js"></script>
<script type="text/javascript" src="https://trip4book.com/webroot/js/jquery.form-validator.min.js"></script>
<script type="text/javascript" src="https://trip4book.com/webroot/js/flight.js"></script>
  


</body>

</html>

