<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuarios</title>
    <script>
        function validateForm() {
            var usuario = document.forms["registerForm"]["usuario"].value;
            var correo = document.forms["registerForm"]["correo"].value;
            var contraseña = document.forms["registerForm"]["contraseña"].value;
            var confirmContraseña = document.forms["registerForm"]["confirm_contraseña"].value;
            var rol = document.forms["registerForm"]["rol"].value;

            if (usuario == "" || correo == "" || contraseña == "" || confirmContraseña == "" || rol == "") {
                alert("Todos los campos son obligatorios.");
                return false;
            }

            if (contraseña != confirmContraseña) {
                alert("Las contraseñas no coinciden.");
                return false;
            }

            if (contraseña.length < 6) {
                alert("La contraseña debe tener al menos 6 caracteres.");
                return false;
            }

            return true;
        }
    </script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/diseño.css">
</head>
<body>
    <!-- Encabezado -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <a class="navbar-brand" href="../index.html">Home</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Iniciar sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Cuerpo de la página -->
    <div class="container col-md-4 border border-secondary rounded p-4">
        <h2 class="text-center">Formulario de Registro</h2>
        <form name="registerForm" action="registro.php" onsubmit="return validateForm()" method="post" class="mt-4">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" class="form-control" name="correo" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" name="contraseña" required>
            </div>
            <div class="form-group">
                <label for="confirm_contraseña">Confirmar Contraseña:</label>
                <input type="password" class="form-control" name="confirm_contraseña" required>
            </div>
            <div class="form-group">
                <label for="rol">Rol:</label>
                <select class="form-control" name="rol" required>
                    <option value="">Seleccione un rol</option>
                    <option value="cliente">Cliente</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include 'conexion.php';

            $usuario = $conn->real_escape_string($_POST['usuario']);
            $correo = $conn->real_escape_string($_POST['correo']);
            $contraseña = $_POST['contraseña'];
            $confirm_contraseña = $_POST['confirm_contraseña'];
            $rol = $conn->real_escape_string($_POST['rol']);

            // Validaciones del lado del servidor
            if (empty($usuario) || empty($correo) || empty($contraseña) || empty($confirm_contraseña) || empty($rol)) {
                echo "<div class='alert alert-danger mt-3'>Todos los campos son obligatorios.</div>";
            } elseif ($contraseña != $confirm_contraseña) {
                echo "<div class='alert alert-danger mt-3'>Las contraseñas no coinciden.</div>";
            } elseif (strlen($contraseña) < 6) {
                echo "<div class='alert alert-danger mt-3'>La contraseña debe tener al menos 6 caracteres.</div>";
            } else {
                // Verificar si el usuario ya existe
                $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' OR correo='$correo'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-danger mt-3'>El nombre de usuario o el correo electrónico ya está en uso.</div>";
                } else {
                    $hashed_contraseña = password_hash($contraseña, PASSWORD_BCRYPT);
                    $sql = "INSERT INTO usuarios (usuario, correo, pwd, rol) VALUES ('$usuario', '$correo', '$hashed_contraseña', '$rol')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success mt-3'>Registro exitoso!</div>";
                        // Crear cuenta e ingresar a la pantalla de los coches
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['usuario'] = $usuario;
                        $_SESSION['rol'] = $rol;
                        header("Location: proteccion.php");
                    } else {
                        echo "<div class='alert alert-danger mt-3'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                }
            }

            $conn->close();
        }
        ?>
    </div>
    <footer class="bg-dark text-white text-center text-lg-start">
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Empresa de Veco</h5>
                <p>
                    Su socio confiable para la compra de autos nuevos. Ofrecemos una amplia variedad de vehículos de las mejores marcas.
                </p>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Contacto</h5>
                <ul class="list-unstyled mb-0">
                    <li>
                        <i class="fas fa-map-marker-alt"></i> Dirección: Av. Principal 123, Ciudad, País
                    </li>
                    <li>
                        <i class="fas fa-phone"></i> Teléfono: +123 456 7890
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i> Email: veco@gmail.com
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Estamos para servirte</h5>
                
            </div>
        </div>
    </div>

    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2024 Veco. Todos los derechos reservados.
    </div>
</footer>
    <!-- JavaScript de Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
