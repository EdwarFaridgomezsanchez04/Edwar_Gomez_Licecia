<?php
require_once('../conex/conexion.php');
$db = new database();
$con = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula_cliente'];
    $fecha = $_POST['fecha'];
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $precio_unitario = $_POST['precio_unitario'];
    $subtotal = $cantidad * $precio_unitario;

    // 1. Insertar en la tabla ventas
    $stmt = $con->prepare("INSERT INTO ventas (cedula_cliente, fecha, total) VALUES (?, ?, ?)");
    $stmt->execute([$cedula, $fecha, $subtotal]);
    $id_venta = $con->lastInsertId();

    // 2. Insertar en detalle_venta
    $stmt2 = $con->prepare("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
    $stmt2->execute([$id_venta, $id_producto, $cantidad, $precio_unitario, $subtotal]);

    echo "<script>alert('Venta registrada exitosamente'); window.location.href='index.php';</script>";
}
?>
