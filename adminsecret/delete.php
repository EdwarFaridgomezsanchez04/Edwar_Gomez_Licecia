<?php
require_once('../conex/conexion.php');

// Validar que venga el ID por GET
if (!isset($_GET['id'])) {
    echo "ID de licencia no proporcionado.";
    exit;
}

$id_licencia = $_GET['id'];

$conex = new database();
$con = $conex->conectar();

// Ejecutar la eliminación
$sql = $con->prepare("DELETE FROM licencia WHERE id_licencia = :id");
$sql->bindParam(':id', $id_licencia, PDO::PARAM_STR);

if ($sql->execute()) {
    echo "<script>alert('Licencia eliminada correctamente'); window.location.href='licencia.php';</script>";
} else {
    echo "Error al eliminar la licencia.";
}
?>
