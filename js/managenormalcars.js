function confirmMakeAvailable(event, form) {
    if (!confirm("Are you sure you want to make this car available again?")) {
        event.preventDefault(); // Cancel if not confirmed
    }
}