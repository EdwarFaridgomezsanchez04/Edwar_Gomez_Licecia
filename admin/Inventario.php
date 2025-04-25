<?php
require_once('../conex/conexion.php');
session_start();

$conex = new database();
$con = $conex->conectar();

// Consulta para obtener los productos
$productos = $con->query("SELECT * FROM productos")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventario de Productos</title>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        min-height: 100vh;
        background: #f4f6f9;
    }

    .sidebar {
        width: 220px;
        background: #2c3e50;
        color: white;
        padding: 20px;
        position: fixed;
        height: 100vh;
    }

    .sidebar h2 {
        margin-bottom: 30px;
    }

    .sidebar a {
        display: block;
        color: white;
        text-decoration: none;
        padding: 10px 0;
    }

    .sidebar a:hover {
        background: #34495e;
        padding-left: 10px;
    }

    .main {
        margin-left: 220px;
        flex: 1;
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ccc;
        text-align: center;
    }

    th {
        background-color: #2c3e50;
        color: white;
    }

    img.barcode {
        width: 150px;
        height: auto;
    }

    .btn {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: rgb(20, 92, 50);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #219150;
    }

    .btn-print {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-print:hover {
        background-color: #218838;
    }

    @media (max-width: 768px) {
        .sidebar {
            position: static;
            width: 100%;
            height: auto;
        }

        .main {
            margin-left: 0;
        }
    }
</style>
</head>

<body>

<div class="sidebar">
    <h2>Dashboard</h2>
    <a href="index.php">Inicio</a>
    <a href="ventas.php">Ventas</a>
    <a href="inventario.php">Inventario</a>
    <a href="clientes.php">Clientes</a>
</div>

<div class="main">
    <h2>Inventario de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Código de Barras</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($producto['codigo']) ?></td>

                     <td>
                        <?php if (!empty($producto['codigo_barras'])): ?>
                            <img class="barcode" src="barcodes/<?= $producto['codigo_barras'] ?>.png" alt="Código de barras">
                        <?php else: ?>
                            Sin código
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($producto['nombre']) ?></td>
                    <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                    <td>$<?= number_format($producto['precio'], 2) ?></td>
                    <td><?= $producto['stock'] ?></td>
                    <td>
                        <a href="#" onclick="window.open('actualizar.php?id=<?= $producto['id']; ?>', '', 'width=600,height=500,toolbar=NO')" title="Actualizar">✏️</a>
                        <a href="delete.php?id=<?= $producto['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?')" title="Eliminar">🗑️</a>
                        <?php if (!empty($producto['codigo_barras'])): ?>
                            <button class="btn-print" onclick="window.open('imprimir_codigo.php?codigo=<?= $producto['codigo_barras'] ?>', '_blank')">Imprimir</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button class="btn" onclick="window.open('R_inventario.php', '', 'width=600,height=500,toolbar=NO')">Crear nuevo producto</button>
    </div>
</div>

</body>

</html>