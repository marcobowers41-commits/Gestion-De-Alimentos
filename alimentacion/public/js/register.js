// public/js/register.js

const registerForm = document.getElementById("registerForm");

if (registerForm) {
  registerForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    const data = new FormData(registerForm);
    const pass1 = document.getElementById("reg-password")?.value;
    const pass2 = document.getElementById("reg-password-confirm")?.value;

    if (pass1 && pass2 && pass1 !== pass2) {
      alert("Las contraseñas no coinciden.");
      return;
    }

    try {
      const response = await fetch("../backend/api/register.php", {
        method: "POST",
        body: data
      });

      const resultado = await response.json();

      if (resultado.status === "success") {
        alert("¡Registro exitoso! Iniciá sesión para continuar.");
        window.location.href = "login.html";
      } else {
        alert(resultado.message || "Error al registrarse.");
      }
    } catch (error) {
      console.error(error);
      alert("Error al conectar con el servidor.");
    }
  });
}
