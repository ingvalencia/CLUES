<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribución de CLUES por Entidad</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Distribución de CLUES por Entidad</h2>

        
        <div class="mb-3">
            <label for="entidadSelect" class="form-label"><b>Filtrar por Entidad:</b></label>
            <select id="entidadSelect" class="form-select">
                <option value="todos">Todas las Entidades</option>
                    
            </select>
        </div>

        
        <div id="chart" class="mt-4"></div>

        
        <h3 class="text-center mt-5">Tabla Dinámica de CLUES por Institución y Entidad</h3>
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

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const entidadSelect = document.getElementById("entidadSelect");
        let chart;  

        // Función para cargar las entidades en el filtro
        function cargarEntidades() {
            fetch("../controllers/CluesController.php")
                .then(response => response.json())
                .then(data => {
                    let entidades = [...new Set(data.map(item => item.ENTIDAD))]; // Obtener entidades únicas
                    entidades.forEach(entidad => {
                        let option = document.createElement("option");
                        option.value = entidad;
                        option.textContent = entidad;
                        entidadSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Error al cargar las entidades:", error));
        }

        // Función para cargar datos en la gráfica y la tabla
        function cargarDatos(entidadSeleccionada) {
            fetch("../controllers/CluesController.php")
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos para el gráfico:", data);

                    if (!data || data.length === 0) {
                        console.error("No se recibieron datos válidos.");
                        return;
                    }

                    
                    let datosFiltrados = entidadSeleccionada === "todos" ? data : data.filter(item => item.ENTIDAD === entidadSeleccionada);

                    let entidades = datosFiltrados.map(item => item.ENTIDAD);
                    let valores = datosFiltrados.map(item => item.total_clues);

                    
                    document.getElementById("chart").innerHTML = "";
                    if (chart) {
                        chart.destroy();    
                    }

                    var options = {
                        series: [{
                            name: "Total CLUES",
                            data: valores
                        }],
                        chart: {
                            type: "bar",
                            height: 450
                        },
                        title: {
                            text: `CLUES por Entidad Federativa (${entidadSeleccionada === "todos" ? "Todas" : entidadSeleccionada})`
                        },
                        xaxis: {
                            categories: entidades
                        }
                    };

                    chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                })
                .catch(error => console.error("Error al cargar los datos del gráfico:", error));

            // Cargar datos de la tabla con filtro
            fetch("../controllers/CluesTableController.php")
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos para la tabla:", data);

                    let datosFiltrados = entidadSeleccionada === "todos" ? data : data.filter(item => item.entidad === entidadSeleccionada);

                    // Resetear la tabla
                    let table = $("#cluesTable").DataTable();
                    table.clear().draw();   

                    datosFiltrados.forEach(item => {
                        table.row.add([
                            item.institucion,
                            item.entidad,
                            item.total_clues
                        ]).draw(false);
                    });

                })
                .catch(error => console.error("Error al cargar los datos de la tabla:", error));
        }

        
        entidadSelect.addEventListener("change", function () {
            cargarDatos(this.value);
        });

        
        cargarEntidades();
        cargarDatos("todos");
    });
    </script>

</body>
</html>
