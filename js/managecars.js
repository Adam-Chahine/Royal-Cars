function confirmMakeAvailable(event, form) {
    if (!confirm("Are you sure you want to delete this car ?")) {
        event.preventDefault(); // Cancel if not confirmed
    }
}