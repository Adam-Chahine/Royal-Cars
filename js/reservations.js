// Confirmation for actions
function confirmAction(message, event) {
    if (!confirm(message)) {
        event.preventDefault();
    }
}