// Add this code just before the closing </script> tag in your existing script

// Form validation - add this to your existing DOMContentLoaded event
document.getElementById('passengerBookingForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Reset previous errors
    document.querySelectorAll('.error-message').forEach(el => el.remove());
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    let isValid = true;
    let firstInvalidField = null;
    
    // Check all required fields
    this.querySelectorAll('[required]').forEach(field => {
        if (!field.value.trim()) {
            markInvalid(field, 'This field is required');
            isValid = false;
            firstInvalidField = firstInvalidField || field;
        }
    });
    
    // Simple email validation
    this.querySelectorAll('input[type="email"]').forEach(field => {
        if (field.value.trim() && !field.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            markInvalid(field, 'Please enter a valid email');
            isValid = false;
            firstInvalidField = firstInvalidField || field;
        }
    });
    
    // Passport expiry date validation (if passport is required)
    if (fareQuoteData?.IsPassportRequiredAtBook) {
        this.querySelectorAll('input[name$="[PassportExpiry]"]').forEach(field => {
            if (field.value && new Date(field.value) <= new Date()) {
                markInvalid(field, 'Expiry date must be in the future');
                isValid = false;
                firstInvalidField = firstInvalidField || field;
            }
        });
    }
    
    // If validation fails, scroll to first error
    if (!isValid && firstInvalidField) {
        firstInvalidField.focus();
        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Show global error message
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-danger mb-3';
        errorAlert.textContent = 'Please fill in all required fields correctly.';
        this.prepend(errorAlert);
    } else {
        // Form is valid, submit it
        this.submit();
    }
    
    // Helper function to mark fields as invalid
    function markInvalid(field, message) {
        field.classList.add('is-invalid');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-danger small mt-1';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }
});

// Add this CSS to your page
document.head.insertAdjacentHTML('beforeend', `
<style>
.is-invalid {
  border-color: #dc3545 !important;
}
</style>
`);