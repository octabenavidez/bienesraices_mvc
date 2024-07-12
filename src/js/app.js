document.addEventListener("DOMContentLoaded", function () {
  eventListeners();

  darkMode();

  borrarMensaje();
});

function darkMode() {
    // Funcionalidad para el modo oscuro en base a lo elegido en windows
    //   const prefiereDarkMode = window.matchMedia("(prefers-color-scheme: dark)");

    //   if (prefiereDarkMode.matches) {
    //     document.body.classList.add("dark-mode");
    //   } else {
    //     document.body.classList.remove("dark-mode");
    //   }

    //   prefiereDarkMode.addEventListener("change", function () {
    //     if (prefiereDarkMode.matches) {
    //       document.body.classList.add("dark-mode");
    //     } else {
    //       document.body.classList.remove("dark-mode");
    //     }
    //   });

  const botonDarkMode = document.querySelector(".dark-mode-boton");

  botonDarkMode.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");
  });
}

function eventListeners() {
  const mobileMenu = document.querySelector(".mobile-menu");

  mobileMenu.addEventListener("click", navegacionResponsive);

  // Muestra campos condicionales
  const metodoContacto = document.querySelectorAll(
    'input[name="contacto[contacto]"]'
  );

  metodoContacto.forEach((input) => {
    input.addEventListener("click", mostrarMetodosContacto);
  });
}

function navegacionResponsive() {
  const navegacion = document.querySelector(".navegacion");

  navegacion.classList.toggle("mostrar");
}

function borrarMensaje() {
  const mensajeConfirm = document.querySelector(".alerta");
  if (mensajeConfirm !== null) {
    setTimeout(function () {
      const padre = mensajeConfirm.parentElement;
      padre.removeChild(mensajeConfirm);
    }, 2500);
  }
}

function mostrarMetodosContacto(e) {
  const contactoDiv = document.querySelector("#contacto");

  if (e.target.value === "telefono") {
    contactoDiv.innerHTML = `
            <label for="telefono">Numero de Teléfono</label>
            <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">

            <p>Elija la fecha y hora para la llamada</p>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora:</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[horario]">
        `;
  } else {
    contactoDiv.innerHTML = `
            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu E-mail" id="email" name="contacto[email]">
        `;
  }
}
