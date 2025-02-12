<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../models/Clues.php";

class CluesTableController {
    public function obtenerDatosTabla() {
        $database = new Database();
        $db = $database->conectar();
        $cluesModel = new Clues($db);

        
        $data = $cluesModel->obtenerCluesInstitucionEntidad();

        
        if (!empty($data)) {
            error_log(print_r($data[0], true)); // Registrar el primer objeto recibido en el log
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

    
$controller = new CluesTableController();
$controller->obtenerDatosTabla();
?>
