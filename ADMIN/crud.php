<?php
include '../LOGIN/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    $nombre = htmlspecialchars($_POST['nombre']);
    $marca = htmlspecialchars($_POST['marca']);
    $modelo = htmlspecialchars($_POST['modelo']);
    $anio = intval($_POST['anio']);
    $precio = intval($_POST['precio']);
    $detalles = htmlspecialchars($_POST['detalles']);

    if ($accion === 'agregar') {
        $sql = "INSERT INTO carros (nombre, marca, modelo, año, precio, detalles) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssids", $nombre, $marca, $modelo, $anio, $precio, $detalles);
        if ($stmt->execute()) {
            header('Location: home.php?msg=Vehículo agregado correctamente');
        } else {
            header('Location: home.php?msg=Error al agregar el vehículo');
        }
    } elseif ($accion === 'modificar' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $sql = "UPDATE carros SET nombre=?, marca=?, modelo=?, año=?, precio=?, detalles=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssidsi", $nombre, $marca, $modelo, $anio, $precio, $detalles, $id);
        if ($stmt->execute()) {
            header('Location: home.php?msg=Vehículo modificado correctamente');
        } else {
            header('Location: home.php?msg=Error al modificar el vehículo');
        }
    } elseif ($accion === 'eliminar' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM carros WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header('Location: home.php?msg=Vehículo eliminado correctamente');
        } else {
            header('Location: home.php?msg=Error al eliminar el vehículo');
        }
    }
    $stmt->close();
}

$conn->close();
?>
