function validateForm() {
    var usuario = document.forms["loginForm"]["usuario"].value;
    var contraseña = document.forms["loginForm"]["contraseña"].value;

    if (usuario == "" || contraseña == "") {
        alert("Todos los campos son obligatorios.");
        return false;
    }

    return true;
}

function togglePasswordVisibility() {
    var passwordField = document.getElementById("contraseña");
    var toggleIcon = document.getElementById("togglePasswordIcon");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}
const inputs = document.querySelectorAll('.form-group input');

inputs.forEach(input => {
  input.addEventListener('focus', () => {
    const icon = input.nextElementSibling;
    icon.style.display = 'none';
  });
});

const alertElement = document.querySelector('.alert');

// Mostrar el alert
alertElement.style.display = 'block';

// Ocultar el alert después de 5 segundos
setTimeout(() => {
  alertElement.style.display = 'none';
}, 5000); // 5000 milisegundos = 5 segundos