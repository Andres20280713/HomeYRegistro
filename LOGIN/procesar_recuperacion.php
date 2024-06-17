<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $usuario = $conn->real_escape_string($_POST['usuario']);

    $sql = "SELECT * FROM usuarios WHERE email='$email' AND usuario='$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-success'>Usuario encontrado. <a href='actualizar_contraseña.php?email=$email&usuario=$usuario'>Cambiar contraseña</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Correo electrónico o usuario incorrecto.</div>";
    }

    $conn->close();
}
?>
