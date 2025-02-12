<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root"; // Si tienes contraseña, agrégala aquí
$password = "";
$database = "catalogo_clues";

// Conectar a MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

// Consulta SQL para obtener el número de CLUES por entidad
$sql = "SELECT ENTIDAD, COUNT(DISTINCT CLUES) AS total_clues FROM clues GROUP BY ENTIDAD";

$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = ["entidad" => $row["ENTIDAD"], "total_clues" => (int)$row["total_clues"]];
    }
} else {
    echo json_encode(["error" => "No se encontraron datos."]);
    exit;
}

// Cerrar conexión
$conn->close();

// Devolver JSON
echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
