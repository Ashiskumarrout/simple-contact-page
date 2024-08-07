function hideMessage() {
    const messageDiv = document.getElementById('messageDiv');
    if (messageDiv) {
        messageDiv.style.display = 'none';
    }
    const form = document.getElementById('contactForm');
    if (form) {
        form.reset();
    }
}

function showMessage() {
    const messageDiv = document.getElementById('messageDiv');
    if (messageDiv) {
        messageDiv.style.display = 'block';
        setTimeout(hideMessage, 2000); // Hide message after 2 seconds
    }
}

window.onload = function() {
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const form = event.target;
        const formData = new FormData(form);
        const messageDiv = document.getElementById('messageDiv');

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            messageDiv.textContent = data.message;
            messageDiv.className = "message" + (data.message.includes('issue') ? " error" : "");
            showMessage(); // Show message after form submission
        })
        .catch(error => {
            messageDiv.textContent = "There was an issue with your submission. Please try again.";
            messageDiv.className = "message error";
            showMessage(); // Show message after form submission
        });
    });

    // Set the current year in the footer
    document.getElementById('year').textContent = new Date().getFullYear();
};
