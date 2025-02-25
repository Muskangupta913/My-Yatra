<!-- Guest Nationality -->
<div class="mb-3 col-md-2"> <!-- Original div sizing and alignment that others should match -->
    <div class="date-caption" style="text-align: center;">Nationality</div>
    <select id="nationalitySelect" class="form-control rounded-0 py-3 text-center">
        <option value="" selected>Select Nationality</option>
        <option value="IN" data-nationality="Indian">INDIA</option>
        <option value="US" data-nationality="American">American</option>
        <option value="GB" data-nationality="British">British</option>
        <option value="CA" data-nationality="Canadian">Canadian</option>
    </select>
</div>

<!-- Hidden inputs now wrapped in consistent div for alignment -->
<!-- ADDED: Wrapper div for hidden inputs with same classes -->
<div class="mb-3 col-md-2">
    <div class="date-caption" style="text-align: center; visibility: hidden;">Hidden Fields</div>
    <input type="hidden" name="CountryCode" id="countryCodeInput" value="">
    <input type="hidden" name="SelectedNationality" id="hiddenNationality" value="">
</div>

<!-- Search Button -->
<!-- MODIFIED: Adjusted classes and styles to match nationality div -->
<div class="mb-3 col-md-2">
    <div class="date-caption" style="text-align: center;">Search</div> <!-- Changed visibility:hidden to match other captions -->
    <button type="button" class="btn btn-warning w-100 rounded-0 py-3 fw-bold hotelbuttonsearch" id="searchButton">Search</button>
</div>