<?php
require_once "Contacto.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $contacto = new Contacto();

    $contacto->nombre   = trim($_POST["nombre"] ?? "");
    $contacto->correo   = trim($_POST["correo"] ?? "");
    $contacto->telefono = trim($_POST["telefono"] ?? "");
    $contacto->servicio = trim($_POST["servicio"] ?? "");
    $contacto->mensaje  = trim($_POST["mensaje"] ?? "");

    $errores = [];

    // Validar nombre
    if (empty($contacto->nombre)) {
        $errores[] = "Error de validación: El nombre es obligatorio.";
    }

    // Validar correo
    if (empty($contacto->correo) || !filter_var($contacto->correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "PHP rechaza el correo: El formato del correo electrónico es inválido.";
    }

    // Validar servicio
    $serviciosValidos = ["Soporte Técnico", "Desarrollo Web", "Redes y Conectividad", "Servicios en la nube"];
    if (empty($contacto->servicio) || !in_array($contacto->servicio, $serviciosValidos)) {
        $errores[] = "PHP indica que se debe seleccionar un servicio válido.";
    }

    // Validar teléfono (solo números, guiones y paréntesis)
    if (empty($contacto->telefono) || !preg_match('/^[0-9\s\-\(\)\+]+$/', $contacto->telefono)) {
        $errores[] = "PHP rechaza el teléfono: El teléfono contiene caracteres no permitidos.";
    }

    // Validar mensaje
    if (empty($contacto->mensaje)) {
        $errores[] = "El mensaje no puede estar vacío.";
    }

    if (!empty($errores)) {
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='style.css'>
            <title>Error de Validación - NEXUSTECHLITE</title>
        </head>
        <body>
            <main style='padding: 50px 20px; display: flex; justify-content: center; align-items: center; min-height: 80vh;'>
                <section class='tarjeta' style='max-width: 550px; width: 100%; padding: 40px 30px; text-align: center; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); border-top: 6px solid #e74c3c;'>
                    
                    <div style='display: inline-flex; align-items: center; justify-content: center; width: 70px; height: 70px; background-color: #fceae9; border-radius: 50%; margin-bottom: 20px;'>
                        <svg width='36' height='36' viewBox='0 0 24 24' fill='none' stroke='#e74c3c' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'>
                            <circle cx='12' cy='12' r='10'></circle>
                            <line x1='12' y1='8' x2='12' y2='12'></line>
                            <line x1='12' y1='16' x2='12.01' y2='16'></line>
                        </svg>
                    </div>

                    <h2 style='color: #2c3e50; font-size: 1.6rem; margin-bottom: 10px;'>Atención requerida</h2>
                    <p style='color: #7f8c8d; font-size: 0.95rem; margin-bottom: 25px;'>Por favor corrige los siguientes campos para continuar:</p>

                    <div style='background-color: #fdf2f2; border-left: 4px solid #e74c3c; border-radius: 6px; padding: 15px 20px; margin-bottom: 30px; text-align: left;'>
                        <ul style='margin: 0; padding-left: 5px; list-style: none;'>";
        foreach ($errores as $error) {
            echo "          <li style='margin-bottom: 8px; color: #c0392b; font-size: 0.95rem; display: flex; align-items: center; gap: 8px;'>
                                <span style='font-weight: bold;'>•</span> " . htmlspecialchars($error) . "
                            </li>";
        }
        echo "          </ul>
                    </div>

                    <a href='index.html' class='boton' style='display: inline-block; text-decoration: none; padding: 12px 28px; border-radius: 6px;'>Regresar al formulario</a>
                </section>
            </main>
        </body>
        </html>";
    } else {
        if ($contacto->guardar()) {
            echo "<!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' href='style.css'>
                <title>Registro Exitoso - NEXUSTECHLITE</title>
            </head>
            <body>
                <main style='padding: 50px 20px; display: flex; justify-content: center; align-items: center; min-height: 80vh;'>
                    <section class='tarjeta' style='max-width: 550px; width: 100%; padding: 40px 30px; text-align: center; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); border-top: 6px solid #2ecc71;'>
                        
                        <div style='display: inline-flex; align-items: center; justify-content: center; width: 70px; height: 70px; background-color: #e8f8f5; border-radius: 50%; margin-bottom: 20px;'>
                            <svg width='36' height='36' viewBox='0 0 24 24' fill='none' stroke='#2ecc71' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'>
                                <path d='M22 11.08V12a10 10 0 1 1-5.93-9.14'></path>
                                <polyline points='22 4 12 14.01 9 11.01'></polyline>
                            </svg>
                        </div>

                        <h2 style='color: #2c3e50; font-size: 1.6rem; margin-bottom: 10px;'>¡Mensaje enviado y registrado con éxito!</h2>
                        <p style='color: #7f8c8d; font-size: 1rem; margin-bottom: 25px;'>Gracias, <strong>" . htmlspecialchars($contacto->nombre) . "</strong>. Nos pondremos en contacto contigo pronto.</p>
                        
                        <a href='index.html' class='boton' style='display: inline-block; text-decoration: none; padding: 12px 28px; border-radius: 6px;'>Volver al inicio</a>
                    </section>
                </main>
            </body>
            </html>";
        } else {
            echo "<h2>Error al guardar en la base de datos.</h2>";
            echo "<a href='index.html' class='boton'>Intentar de nuevo</a>";
        }
    }
} else {
    header("Location: index.html");
    exit();
}
?>