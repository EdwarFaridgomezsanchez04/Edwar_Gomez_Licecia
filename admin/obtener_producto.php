<?php
require_once('../conex/conexion.php');
$db = new database();
$con = $db->conectar();

if (isset($_POST['id']) || isset($_POST['codigo'])) {
    $id_producto = $_POST['id'] ?? null;
    $codigo_producto = $_POST['codigo'] ?? null;

    // Modificar la consulta para buscar por id o código de barras
    if ($id_producto) {
        $sql = $con->prepare("SELECT * FROM productos WHERE id = ?");
        $sql->execute([$id_producto]);
    } elseif ($codigo_producto) {
        $sql = $con->prepare("SELECT * FROM productos WHERE codigo = ?");
        $sql->execute([$codigo_producto]);
    }

    $producto = $sql->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        echo json_encode($producto); // Devuelve los datos en formato JSON
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }
}
?>
