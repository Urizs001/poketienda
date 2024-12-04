<?php
// Incluir el archivo de conexión a la base de datos
require('conexion.php');

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos JSON enviados desde JavaScript
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData);

    // Verificar si el campo id_nombre está presente en el objeto JSON
    if (isset($data->id_nombre)) {
        // Obtener el valor de id_nombre del objeto JSON
        $id_nombre = $data->id_nombre;

        try {
            // Preparar la consulta SQL para seleccionar el Pokémon por número o nombre
            $query = "SELECT * FROM pokemon WHERE numero = :id_nombre OR nombre = :id_nombre";
            $stmt = $pdo->prepare($query);
            
            // Ejecutar la consulta con los parámetros binded
            $stmt->execute(['id_nombre' => $id_nombre]);

            // Obtener el resultado de la consulta
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Establecer el encabezado de respuesta como JSON
                header('Content-Type: application/json');
                // Devolver el resultado como JSON
                echo json_encode($row);
            } else {
                // Si no se encuentra el Pokémon, devolver un mensaje de error
                header('Content-Type: application/json');
                echo json_encode(['error' => 'No se encontró el Pokémon en la base de datos']);
            }
        } catch (PDOException $e) {
            // Si hay un error en la consulta SQL, devolver un mensaje de error
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Error en la consulta SQL: ' . $e->getMessage()]);
        }
    } else {
        // Si el campo id_nombre no está presente en el objeto JSON, devolver un mensaje de error
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Campo id_nombre no encontrado en los datos enviados']);
    }
}
?>