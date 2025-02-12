<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Dinámica de CLUES</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Tabla Dinámica de CLUES por Institución y Entidad</h2>
        <table id="cluesTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nombre de la Institución</th>
                    <th>Entidad</th>
                    <th>Total CLUES</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("../controllers/CluesTableController.php")
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos:", data); 
                    if (data.length === 0) {
                        console.error("No se recibieron datos desde la API.");
                        return;
                    }

                    let instituciones = [...new Set(data.map(item => item.institucion))]; 
                    let entidades = [...new Set(data.map(item => item.entidad))]; 

                    // tabla dinámica de CLUES
                    let tablaHTML = "<thead><tr><th>Nombre de la Institución</th>";
                    entidades.forEach(entidad => {
                        tablaHTML += `<th>${entidad}</th>`;
                    });
                    tablaHTML += "</tr></thead><tbody>";

                    instituciones.forEach(inst => {
                        tablaHTML += `<tr><td>${inst}</td>`;
                        entidades.forEach(entidad => {
                            let celda = data.find(item => item.institucion === inst && item.entidad === entidad);
                            tablaHTML += `<td>${celda ? celda.total_clues : 0}</td>`;
                        });
                        tablaHTML += "</tr>";
                    });

                    tablaHTML += "</tbody>";
                    document.querySelector("#cluesTable").innerHTML = tablaHTML;

                    // Aplicar DataTables
                    $("#cluesTable").DataTable();
                })
                .catch(error => console.error("Error al cargar los datos:", error));
        });
    </script>
</body>
</html>
