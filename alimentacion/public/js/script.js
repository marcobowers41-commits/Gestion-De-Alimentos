const loginForm = document.getElementById("loginForm");

loginForm.addEventListener("submit", async (event) => {
  event.preventDefault();

  const data=new FormData(loginForm);

  try {
    const response = await fetch("http://localhost/alimentacion/002proyecto/backend/api/login.php", {
      method: "POST",
      body: data
    });

    const resultado = await response.json();

    if (resultado.status === "success") {
        console.log("Iniciando sesión.");

        // Redirigir después de iniciar sesión
        window.location.href = "account.html";
    }
    else {
        console.log(resultado.message);
      }
    }catch (error) {
      console.error(error);
      console.log("Error al conectar con el servidor.");
    }

});
