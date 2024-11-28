document.getElementById("ltogglePassword").addEventListener("click", function () {
    const passwordField = document.getElementById("lpassword");
  
    if (passwordField.type === "password") {
      passwordField.type = "text";
      this.textContent = "🙈"; // Change icon to hide password
    } else {
      passwordField.type = "password";
      this.textContent = "👁"; // Change icon back to show password
    }
  });