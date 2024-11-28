document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordField = document.getElementById("password");
  
    if (passwordField.type === "password") {
      passwordField.type = "text";
      this.textContent = "🙈"; // Change icon to hide password
    } else {
      passwordField.type = "password";
      this.textContent = "👁"; // Change icon back to show password
    }
  });
  document.getElementById("ctogglePassword").addEventListener("click", function () {
    const passwordField = document.getElementById("cpassword");
  
    if (passwordField.type === "password") {
      passwordField.type = "text";
      this.textContent = "🙈"; // Change icon to hide password
    } else {
      passwordField.type = "password";
      this.textContent = "👁"; // Change icon back to show password
    }
  });