<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../models/Clues.php";

class CluesController {
    public function obtenerClues() {
        $database = new Database();
        $db = $database->conectar();
        $cluesModel = new Clues($db);

        // Mando a llamar a mi metodo
        $data = $cluesModel->obtenerCluesPorEntidad();

        if (!empty($data)) {
            error_log(print_r($data[0], true)); 
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

$controller = new CluesController();
$controller->obtenerClues();
?>
