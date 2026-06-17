// Set minimum dates to today
const today = new Date().toISOString().split('T')[0];
document.getElementById('pickup_date').min = today;
document.getElementById('return_date').min = today;

// Update return date minimum based on selected pickup date
document.getElementById('pickup_date').addEventListener('change', function () {
    document.getElementById('return_date').min = this.value;
});