<?php
require_once('../conex/conexion.php');

// Validar que venga el ID por GET
if (!isset($_GET['id'])) {
    echo "ID de licencia no proporcionado.";
    exit;
}

$id_empresa = $_GET['id'];

$conex = new database();
$con = $conex->conectar();

// Ejecutar la eliminación
$sql = $con->prepare("DELETE FROM empresa WHERE id_empresa = :id");
$sql->bindParam(':id', $id_empresa, PDO::PARAM_STR);

if ($sql->execute()) {
    echo "<script>alert('Empresa eliminada correctamente'); window.location.href='empresa.php';</script>";
} else {
    echo "Error al eliminar la empresa.";
}
?>
