<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: LOGIN/login.php");
    exit();
}

$rol = $_SESSION['rol'];

if ($rol === 'admin') {
    header("Location: ../ADMIN/home.php");
    exit();
} elseif ($rol === 'cliente') {
    header("Location: ../CLIENTE/vistaCliente.php");
    exit();
} else {
    echo "Rol no reconocido.";
}
?>
