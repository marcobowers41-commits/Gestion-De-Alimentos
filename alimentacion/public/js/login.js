// public/js/login.js

const loginForm = document.getElementById("loginForm");

if (loginForm) {
  loginForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    const data = new FormData(loginForm);

    try {
      const response = await fetch("../backend/api/login.php", {
        method: "POST",
        body: data
      });

      const resultado = await response.json();

      if (resultado.status === "success") {
        if (resultado.usuario_id) {
          localStorage.setItem("usuario_id", resultado.usuario_id);
          localStorage.setItem("usuario", resultado.usuario);
        }
        // Redirigir a la siguiente pantalla (family.html o space.html)
        window.location.href = "family.html";
      } else {
        alert(resultado.message || "Error al iniciar sesión.");
      }
    } catch (error) {
      console.error(error);
      alert("Error al conectar con el servidor.");
    }
  });
}
