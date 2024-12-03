document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('loginForm');

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (!email || !password) {
      alert('Please fill in both email and password.');
    } else if (!email.includes('@')) {
      alert('Please enter a valid email address with an "@" symbol.');
    } else {
      alert('Form submitted!');
      
      // Redirect to the home page after validation success
      window.location.href = 'indexhome.html';
    }
  });
});

