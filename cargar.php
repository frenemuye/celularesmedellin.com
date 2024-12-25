<!-- PHP no funciona en servidor github pages -->

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        color: #333;
        margin: 0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        text-align: center;
    }

    .mensaje {
        font-size: 1.2rem;
        padding: 15px 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        max-width: 400px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .mensaje.exito {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
    }

    .mensaje.error {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    button {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #45a049;
    }

    button.error {
        background-color: #c62828;
    }

    button.error:hover {
        background-color: #b71c1c;
    }
</style>


<?php
// Define la ruta donde se guardará el archivo
$rutaDestino = __DIR__ . '/precios.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se subió un archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        // Verifica que el archivo sea de tipo texto plano
        $tipoArchivo = mime_content_type($_FILES['archivo']['tmp_name']);
        if ($tipoArchivo !== 'text/plain') {
            echo '<div class="mensaje error">Error: El archivo debe ser de tipo .txt.</div>';
            echo '<button onclick="window.history.back()">Volver</button>';
            exit;
        }

        // Verifica si el archivo ya existe
        if (file_exists($rutaDestino)) {
            // Elimina el archivo existente antes de subir el nuevo
            unlink($rutaDestino);
        }

        // Mueve el archivo subido al destino con el nombre fijo "precios.txt"
        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaDestino)) {
            echo '<div class="mensaje exito">El archivo ha sido subido y reemplazado exitosamente como precios.txt.</div>';
            echo '<button onclick="window.location.href=\'index.html\'">Volver al Inicio</button>';
        } else {
            echo '<div class="mensaje error">Error: No se pudo mover el archivo al destino.</div>';
            echo '<button onclick="window.history.back()">Volver</button>';
        }
    } else {
        echo '<div class="mensaje error">Error: No se subió ningún archivo o hubo un problema con la subida.</div>';
        echo '<button onclick="window.history.back()">Volver</button>';
    }
} else {
    echo '<div class="mensaje error">Error: El método de solicitud no es válido.</div>';
    echo '<button onclick="window.history.back()">Volver</button>';
}
?>
