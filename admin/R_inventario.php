<?php
require_once('../conex/conexion.php');
require '../vendor/autoload.php'; // Librerías externas (como el generador de código de barras)

use Picqer\Barcode\BarcodeGeneratorPNG;

session_start();
$conex = new database();
$con = $conex->conectar();


if (isset($_POST['submit'])) {
    $codigo      = $_POST['codigo'];
    $nombre      = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio      = $_POST['precio'];
    $stock       = $_POST['stock'];

    if ( empty($nombre) || empty($descripcion) || empty($precio) || empty($stock)) {
        echo '<script>alert("Todos los campos son obligatorios.");</script>';
        echo '<script>window.location = "R_licencia.php";</script>';
        exit;
    }

    // Verificar si el producto ya existe
    $sql1 = $con->prepare("SELECT * FROM productos WHERE nombre = ?");
    $sql1->execute([$nombre]);
    $fila = $sql1->fetchAll(PDO::FETCH_ASSOC);

    if ($fila) {
        echo '<script>alert("Ya existe un producto con ese nombre.");</script>';
        echo '<script>window.location = "R_licencia.php";</script>';
        exit;
    }

    // Insertar producto
    $insert = $con->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, codigo) VALUES (?, ?, ?, ?, ?)");
    $insert->execute([$nombre, $descripcion, $precio, $stock, $codigo]);

    $id_producto = $con->lastInsertId();

    // Generar código de barras
    $codigo = "PROD-" . str_pad($id_producto, 6, "0", STR_PAD_LEFT);

    // Crear carpeta si no existe
    if (!file_exists('./barcodes/')) {
        mkdir('./barcodes/', 0777, true);
    }

    // Actualizar producto con el código de barras
    $stmtUpdate = $con->prepare("UPDATE productos SET codigo_barras = ? WHERE id = ?");
    $stmtUpdate->execute([$codigo, $id_producto]);

    // Generar imagen del código
    $generator = new BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode($codigo, $generator::TYPE_CODE_128);
    file_put_contents("./barcodes/{$codigo}.png", $barcode);

    // Mensaje y redirección
    echo '<script>alert("Producto registrado con éxito.");</script>';
    echo '<script>window.location.href="dispositivos.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de productos - MotoRacer</title>
    <link rel="stylesheet" href="estilos/Registro.css">
    <style>
        :root {
            --primary-color: #e63946;
            --secondary-color: #1d3557;
            --background-color: #f1faee;
            --text-color: #1d3557;
            --input-bg: #ffffff;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--background-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 8px 24px var(--shadow-color);
            width: 100%;
            max-width: 500px;
            padding: 40px;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        h3 {
            color: var(--secondary-color);
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }

        h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 2px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: var(--input-bg);
            transition: border-color 0.3s, box-shadow 0.3s;
            width: 100%;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(230, 57, 70, 0.2);
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #d62839;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            h3 {
                font-size: 24px;
            }

            input, button {
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h3>Registrar Producto</h3>
    <form method="POST" action="">

        <input type="text" name="codigo" placeholder="Código del producto" required>
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <input type="number" name="precio" placeholder="Precio" step="0.01" required>
        <input type="number" name="stock" placeholder="Cantidad en stock" required>
        
        <button type="submit" name="submit">Registrar</button>
    </form>
</div>

</body>
</html>



