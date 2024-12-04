<?php
// Incluye el archivo de configuración de la conexión
require('conexion.php');

// Verifica si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtiene los datos enviados desde JavaScript como un objeto JSON
    $data = json_decode(file_get_contents('php://input'));
    
    // Verifica si todos los campos necesarios están presentes
    if (isset($data->name) && isset($data->id) && isset($data->height) && isset($data->weight) && isset($data->type) && isset($data->color) && isset($data->abilities)&& isset($data->imgn)&& isset($data->imgc)) {
        // Asigna los valores de los campos a variables
        $name = $data->name;
        $id= $data->id;
        $height = $data->height;
        $weight = $data->weight;
        $type = $data->type;
        $color = $data->color;
        $abilities = $data->abilities;
        $imgn = $data->imgn;
        $imgc = $data->imgc;

        // Prepara la consulta SQL para insertar los datos en la tabla pokemon
        $sql = "INSERT INTO pokemon (nombre, numero, altura, peso, categoria, color, habilidades, imgn,imgc) VALUES (:name, :id, :height, :weight, :type, :color, :abilities, :imgn, :imgc)";
        $stmt = $mysqli->prepare($sql);

        // Bind parameters (sustituye los marcadores de posición por los valores reales)
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':height', $height);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':abilities', $abilities);
        $stmt->bindParam(':imgn', $imgn);
        $stmt->bindParam(':imgc', $imgc);

        // Ejecuta la consulta preparada
        if ($stmt->execute()) {
            echo "Datos del Pokémon guardados correctamente en la base de datos.";
        } else {
            echo "Error al insertar datos del Pokémon: " . $stmt->errorInfo();
        }
    } else {
        echo "Error: Datos insuficientes enviados desde JavaScript.";
    }
} else {
    echo "Error: Se esperaba una solicitud POST.";
}

// Cierra la conexión a la base de datos
$mysqli = null;
?>