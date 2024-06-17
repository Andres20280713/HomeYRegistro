<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../LOGIN/proteccion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de Carros</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .table-custom {
            background-color: #f8f9fa;
        }
        .table-custom thead {
            background-color: #343a40;
            color: white;
        }
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }
        .custom-margin {
            margin-right: 50px; 
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="fas fa-home" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto custom-margin">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Bienvenid@, <?php echo $_SESSION['usuario']; ?>!
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="datosPersonales.php">Datos personales</a>
                        <a class="dropdown-item" href="../LOGIN/cerrar.php">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2 style="text-align: center; color:brown;">Vista de Carros</h2>

        <?php
            include '../LOGIN/conexion.php'; // Ruta de conexión

            $query = "SELECT id, UPPER(nombre) AS Nombre, UPPER(marca) AS Marca, modelo, año, precio, detalles FROM carros";
            $reslt = $conn->query($query);

            if ($reslt) {
                if ($reslt->num_rows > 0) {
                    echo '<table class="table table-bordered table-custom">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Nombre</th>';
                    echo '<th>Marca</th>';
                    echo '<th>Modelo</th>';
                    echo '<th>Precio</th>';
                    echo '<th>Detalle</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    while ($fila = $reslt->fetch_assoc()) {
                        $detalle = "<div class='detalle-carro'>
                                        <p>Nombre: " . htmlspecialchars($fila['Nombre']) . "</p>
                                        <p>Marca: " . htmlspecialchars($fila['Marca']) . "</p>
                                        <p>Modelo: " . htmlspecialchars($fila['modelo']) . "</p>
                                        <p>Año: " . htmlspecialchars($fila['año']) . "</p>
                                        <p>Precio: " . htmlspecialchars($fila['precio']) . "</p>
                                        <p>Detalles: " . htmlspecialchars($fila['detalles']) . "</p>
                                    </div>";

                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($fila['Nombre']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['Marca']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['modelo']) . '</td>';
                        echo '<td>' . htmlspecialchars($fila['precio']) . '</td>';
                        echo '<td><button type="button" class="btn btn-info ver-detalle" data-toggle="modal" data-target="#detalleModal" data-detalle="' . htmlspecialchars($detalle) . '">
                                <i class="fas fa-info-circle"></i>
                              </button></td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<div class="alert alert-info">No se encontraron resultados.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Error en la consulta: ' . $conn->error . '</div>';
            }
            $conn->close();
        ?>

        <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detalleModalLabel">Detalles del Carro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="detalleModalBody">
           
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function(){
            $('#detalleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var detalle = button.data('detalle');
                var modal = $(this);
                modal.find('.modal-body').html(detalle);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
