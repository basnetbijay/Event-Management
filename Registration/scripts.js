document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const event = document.getElementById('event').value;
    const comments = document.getElementById('comments').value;

    // Display a confirmation message
    const message = `Thank you for registering, ${name}! You will receive an email confirmation at ${email}.`;
    document.getElementById('message').textContent = message;

    // Optionally, here you can add code to send the form data to a server
    // using AJAX or a form submission
});
