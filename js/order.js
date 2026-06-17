document.addEventListener('DOMContentLoaded', () => {
    // 1. Get Car from URL
    const params = new URLSearchParams(window.location.search);
    const car = params.get('car') || "Not Selected";
    document.getElementById('car-display-name').innerText = decodeURIComponent(car);
    document.getElementById('car_name').value = decodeURIComponent(car);

    // 2. Date Logic (Min = Today)
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('p_date').min = today;
    document.getElementById('r_date').min = today;

    // 3. ONE-CLICK PROTECTION
    const form = document.getElementById('res-form');
    const btn = document.getElementById('submit-btn');

    form.addEventListener('submit', (e) => {
        // Check if already clicked
        if (btn.hasAttribute('data-clicked')) {
            e.preventDefault();
            return;
        }

        // Visual Feedback
        btn.setAttribute('data-clicked', 'true');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

        // Form continues to order.php
    });
});