<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../CSS/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/Proyecto/js/scripts.js" defer></script>
    <script>
        $(document).ready(function() {
            $('form[name="loginForm"]').on('submit', function(event) {
                var isValid = true;
                var email = $('input[name="email"]').val().trim();
                var contraseña = $('input[name="contraseña"]').val().trim();

                if (email === "") {
                    isValid = false;
                    alert("Por favor, ingrese su correo electrónico.");
                }

                if (contraseña === "") {
                    isValid = false;
                    alert("Por favor, ingrese la contraseña.");
                }

                return isValid;
            });
            $('#togglePasswordIcon').on('click', function() {
                var passwordField = $('#contraseña');
                var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="../index.html">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="login-container">
        <div class="login-image">
            <img src="../IMG/logo.png" alt="Login Image"> 
        </div>
        <div class="login-form">
            <h2 class="text-center">Bienvenid@</h2>
            <form name="loginForm" action="login.php" method="post">
                <div class="form-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" class="form-control" name="email" required placeholder="Correo electrónico">
                </div>
                <div class="form-group">
                    <input type="password" id="contraseña" class="form-control" name="contraseña" required placeholder="Contraseña">
                    <i class="fa fa-lock"></i>
                    <i id="togglePasswordIcon" class="fa fa-eye toggle-password"></i>
                </div>
                <button type="submit" class="btn btn-primary">INICIAR SESION</button>
                <a href="recuperar.php" class="forgot-password">Olvidé mi contraseña</a>
                <a href="registro.php" class="register">Registrarse</a>
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    include 'conexion.php';

                    $email = $conn->real_escape_string($_POST['email']);
                    $contraseña = $_POST['contraseña'];

                    // Validaciones del lado del servidor
                    if (empty($email) || empty($contraseña)) {
                        echo "<div class='alert alert-danger mt-3'>Todos los campos son obligatorios.</div>";
                    } else {
                        $sql = "SELECT * FROM usuarios WHERE email='$email'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            if ($contraseña == $row['contraseña']) {
                                session_start();
                                $_SESSION['loggedin'] = true;
                                $_SESSION['email'] = $email;
                                $_SESSION['usuario'] = $row['usuario'];
                                $_SESSION['puesto'] = $row['puesto']; // Guardar el puesto del usuario

                                // Redirigir según el puesto del usuario
                                if ($row['puesto'] === 'admin') {
                                    header("Location: ../ADMIN/headerAdmin.php");
                                    exit();
                                } elseif ($row['puesto'] === 'empleado') {
                                    header("Location: ../EMPLEADO/headerEmpleado.php");
                                    exit();
                                } elseif ($row['puesto'] === 'cliente') {
                                    header("Location: ../CLIENTE/vistaCliente.php");
                                    exit();
                                } else {
                                    echo "<div class='alert alert-danger mt-3'>Puesto no reconocido.</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger mt-3'>Contraseña incorrecta.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger mt-3'>Correo electrónico no encontrado.</div>";
                        }
                    }
                    $conn->close();
                }
            ?>
        </div>
    </div>
</body>
</html>
