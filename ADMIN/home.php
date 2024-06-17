<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../LOGIN/proteccion.php");
    exit;
}
$usuario = htmlspecialchars($_SESSION['usuario']);
$rol = $_SESSION['rol']; // Obtén el rol de la sesión
?>
<!DOCTYPE html>
<html>

<head>
    <title>Panel de Usuario</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/719186e97d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../CSS/diseño.css">
    <style>
        .dropdown-menu {
            background-color: #007bff;
        }

        .dropdown-item {
            color: white;
        }

        .dropdown-item:hover {
            background-color: #0056b3;
        }
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
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
                        <a class="dropdown-item" href="#">Datos personales</a>
                        <a class="dropdown-item" href="../LOGIN/cerrar.php">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Listado de Vehículos</h2>
        <?php
        if (isset($_GET['msg'])) {
            echo "<div class='alert alert-info'>" . htmlspecialchars($_GET['msg']) . "</div>";
        }
        ?>
        <button class='btn btn-success' onclick="openModal('agregar')"> <i class='fa-solid fa-square-plus'></i> </button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Precio</th>
                    <th>Detalles</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    include '../LOGIN/conexion.php';
                    $sql = "SELECT * FROM carros";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['modelo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['año']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['precio']) . "</td>";
                            echo "<td>
                                <button class='btn btn-info' onclick=\"openModal('detalles', " . $row['id'] . ")\"> <i class='fa-solid fa-circle-info'></i> </button>
                            </td>";
                            echo "<td>
                                <button class='btn btn-warning' onclick=\"openModal('modificar', " . $row['id'] . ")\"> <i class='fa-solid fa-pen'></i> </button>
                            </td>";
                            echo "<td>
                                <button class='btn btn-danger' onclick=\"openModal('eliminar', " . $row['id'] . ")\"> <i class='fa-solid fa-trash'></i> </button>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No se encontraron vehículos</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="crud" tabindex="-1" aria-labelledby="e_crud" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="e_crud">Vehículo:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="crudForm" action="crud.php" method="post">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="marca">Marca:</label>
                            <input type="text" class="form-control" id="marca" name="marca" required>
                        </div>
                        <div class="form-group">
                            <label for="modelo">Modelo:</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" required>
                        </div>
                        <div class="form-group">
                            <label for="anio">Año:</label>
                            <input type="number" class="form-control" id="anio" name="anio" required>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="number" class="form-control" id="precio" name="precio" required>
                        </div>
                        <div class="form-group">
                            <label for="detalles">Detalles:</label>
                            <textarea class="form-control" id="detalles" name="detalles" required></textarea>
                        </div>
                        <input type="hidden" name="accion" id="accion">
                        <input type="hidden" name="id" id="carroId">
                        <button type="submit" class="btn btn-primary" id="crudButton">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/719186e97d.js" crossorigin="anonymous"></script>
    <script>
        function openModal(action, id = null) {
            $('#crudForm')[0].reset();
            $('#accion').val(action);
            $('#carroId').val(id);
            $('#crudButton').text(action.charAt(0).toUpperCase() + action.slice(1));
            $('#crudButton').show();
            $('#crudForm input, #crudForm textarea').prop('readonly', false);

            if (action === 'modificar' || action === 'eliminar' || action === 'detalles') {
                $.ajax({
                    url: 'fetch_details.php',
                    type: 'POST',
                    data: { id: id },
                    success: function (response) {
                        var details = JSON.parse(response);
                        $('#nombre').val(details.nombre);
                        $('#marca').val(details.marca);
                        $('#modelo').val(details.modelo);
                        $('#anio').val(details.anio);
                        $('#precio').val(details.precio);
                        $('#detalles').val(details.detalles);

                        if (action === 'detalles') {
                            $('#crudForm input, #crudForm textarea').prop('readonly', true);
                            $('#crudButton').hide();
                        } else if (action === 'eliminar') {
                            $('#crudForm input, #crudForm textarea').prop('readonly', true);
                        }
                    }
                });
            }

            $('#crud').modal('show');
        }
    </script>
</body>

</html>
