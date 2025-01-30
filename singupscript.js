function togglePassword(inputId) {
    const passwordInput = document.getElementById(inputId);
    const toggleButton = passwordInput.nextElementSibling.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleButton.classList.remove('fa-eye');
        toggleButton.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleButton.classList.remove('fa-eye-slash');
        toggleButton.classList.add('fa-eye');
    }
}

// Validimi i password match
const password = document.getElementById('password');
const cpassword = document.getElementById('cpassword');
const form = document.querySelector('form');

form.addEventListener('submit', function(e) {
    if (password.value !== cpassword.value) {
        e.preventDefault();
        alert('Passwords do not match!');
        return false;
    }
    
    if (password.value.length < 8) {
        e.preventDefault();
        alert('Password must be at least 8 characters long!');
        return false;
    }
    
    return true;
});

// Real-time validation
cpassword.addEventListener('input', function() {
    if (this.value !== password.value) {
        this.setCustomValidity('Passwords do not match!');
    } else {
        this.setCustomValidity('');
    }
});

password.addEventListener('input', function() {
    if (cpassword.value !== '') {
        if (this.value !== cpassword.value) {
            cpassword.setCustomValidity('Passwords do not match!');
        } else {
            cpassword.setCustomValidity('');
        }
    }
});
 