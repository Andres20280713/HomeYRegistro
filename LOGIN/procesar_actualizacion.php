<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $new_password = $conn->real_escape_string($_POST['new_password']);

    $sql = "UPDATE usuarios SET contraseña='$new_password' WHERE email='$email' AND usuario='$usuario'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Contraseña actualizada exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar la contraseña: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>
