<?php
class Clues {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener CLUES por Entidad
    public function obtenerCluesPorEntidad() {
        $sql = "SELECT ENTIDAD AS ENTIDAD, COUNT(DISTINCT CLUES) AS total_clues
                FROM clues
                GROUP BY ENTIDAD
                ORDER BY ENTIDAD";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Método para obtener CLUES por Institución y Entidad
    public function obtenerCluesInstitucionEntidad() {
        $sql = "SELECT NOMBRE_DE_LA_INSTITUCION AS institucion, ENTIDAD AS entidad, COUNT(DISTINCT CLUES) AS total_clues
                FROM clues
                GROUP BY NOMBRE_DE_LA_INSTITUCION, ENTIDAD
                ORDER BY NOMBRE_DE_LA_INSTITUCION, ENTIDAD";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
