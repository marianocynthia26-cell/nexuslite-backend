// ==============================================================================
// PRÁCTICA 3: CONSTRUCCIÓN DE UNA PÁGINA WEB UTILIZANDO JAVASCRIPT
// INSTITUCIÓN: NEXUSTECHLITE
// ==============================================================================

// 1. Mensaje de bienvenida emergente (alert) y Reloj Dinámico en formato 12h
document.addEventListener("DOMContentLoaded", function () {
    // Alerta emergente de bienvenida
    alert("¡Bienvenido a NEXUSTECHLITE! Gracias por visitar nuestro portal informativo.");

    // Función del reloj dinámico que actualiza hora, minuto y segundo
    function actualizarReloj() {
        const ahora = new Date();
        let horas = ahora.getHours();
        const minutos = String(ahora.getMinutes()).padStart(2, '0');
        const segundos = String(ahora.getSeconds()).padStart(2, '0');
        const ampm = horas >= 12 ? 'PM' : 'AM';

        // Conversión a formato de 12 horas
        horas = horas % 12;
        horas = horas ? horas : 12; // La hora '0' equivale a '12'

        const horaFormateada = `Hora actual: ${String(horas).padStart(2, '0')}:${minutos}:${segundos} ${ampm}`;
        
        const contenedorReloj = document.getElementById("reloj");
        if (contenedorReloj) {
            contenedorReloj.textContent = horaFormateada;
        }
    }

    // Ejecución inicial y temporizador de 1 segundo (setInterval)
    actualizarReloj();
    setInterval(actualizarReloj, 1000);
});

// 3. Detección de selección en el menú desplegable (<select>)
const selectServicio = document.getElementById("servicio");
if (selectServicio) {
    selectServicio.addEventListener("change", function (evento) {
        console.log(`[EVENTO CHANGE] Servicio seleccionado: ${evento.target.value}`);
    });
}

// 4. Detección de eventos del mouse (mouseover / mouseleave) en los botones
const botones = document.querySelectorAll("button, .boton, .boton-secundario");
botones.forEach(function (boton) {
    boton.addEventListener("mouseover", function () {
        console.log(`[MOUSEOVER] El cursor ingresó al botón: "${boton.textContent.trim()}"`);
    });
    boton.addEventListener("mouseleave", function () {
        console.log(`[MOUSELEAVE] El cursor salió del botón: "${boton.textContent.trim()}"`);
    });
});

// 5, 6 y 7. Validación de formulario, Alerta interactiva y LocalStorage
const formularioContacto = document.querySelector("form");
if (formularioContacto) {
    formularioContacto.addEventListener("submit", function (e) {
        e.preventDefault(); // Evita la recarga automática de la página

        // Captura y limpieza de valores
        const nombre = document.getElementById("nombre").value.trim();
        const correo = document.getElementById("correo").value.trim();
        const telefono = document.getElementById("telefono").value.trim();
        const servicio = document.getElementById("servicio").value;
        const mensaje = document.getElementById("mensaje").value.trim();

        // 5. Validar que ningún campo se envíe vacío
        if (!nombre || !correo || !telefono || !mensaje) {
            alert("Error: Por favor completa todos los campos del formulario antes de enviar.");
            return;
        }

        // Estructura de objeto con los datos procesados
        const registroUsuario = {
            nombre: nombre,
            correo: correo,
            telefono: telefono,
            servicio: servicio,
            mensaje: mensaje,
            fechaRegistro: new Date().toLocaleString()
        };

        // 7. Guardar en el almacenamiento local (localStorage) usando JSON.stringify
        localStorage.setItem("registroContacto", JSON.stringify(registroUsuario));

        // 6. Mensaje de confirmación interactivo
        alert(`¡Registro exitoso! Gracias ${nombre}. Tu solicitud para el servicio de '${servicio}' ha sido guardada correctamente.`);

        // Limpieza de campos tras el registro exitoso
        formularioContacto.reset();
    });
}