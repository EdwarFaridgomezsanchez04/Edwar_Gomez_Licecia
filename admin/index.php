<?php
require_once('../conex/conexion.php');
$db = new database();
$con = $db->conectar();
date_default_timezone_set('America/Bogota');
$date = date("Y-m-d H:i:s");

if (isset($_POST['submit'])) {
  $cedula = $_POST['cedula'];
  $nombre = $_POST['nombre'];
  $telefono = $_POST['telefono'];
  $direccion = $_POST['direccion'];  
  $fecha = $_POST['fecha'] ?? date("Y-m-d H:i:s");
  $id_producto = $_POST['id_producto'];
  $cantidad = $_POST['cantidad'];
  $precio_unitario = $_POST['precio_unitario'];
  $subtotal = $cantidad * $precio_unitario;

  $sql1 = $con->prepare("SELECT * FROM clientes WHERE cedula = ?");
  $sql1->execute([$cedula]);
  $fila = $sql1->fetch(PDO::FETCH_ASSOC);

  if ($cedula == "" || $nombre == "" || $telefono == "" || $direccion == "") {
    echo '<script>alert("Todos los campos son obligatorios");</script>';
    echo '<script>window.location = "index.php";</script>';
    exit;
  } else {
    // Insertar cliente solo si no existe
    if (!$fila) {
      $insert = $con->prepare("INSERT INTO clientes (cedula, nombre, telefono, direccion) VALUES (?, ?, ?, ?)");
      $insert->execute([$cedula, $nombre, $telefono, $direccion]);
    }

    $stmt = $con->prepare("INSERT INTO ventas (cedula_cliente, fecha, total) VALUES (?, ?, ?)");
    $stmt->execute([$cedula, $fecha, $subtotal]);
    $id_venta = $con->lastInsertId(); 

    $stmt2 = $con->prepare("INSERT INTO detalle_ventas (id_venta, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?)");
    $stmt2->execute([$id_venta, $cantidad, $precio_unitario, $subtotal]);

    echo "<script>alert('Venta registrada exitosamente'); window.location.href='index.php';</script>";
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrar Venta</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    .navbar {
      background: white;
      padding: 10px 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    form {
      margin-top: 30px;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      max-width: 600px;
    }

    form label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    form input,
    form select {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .btn {
      background-color: #145c32;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #219150;
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

    .barcode {
      max-width: 100%;
      margin-bottom: 15px;
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
    <div class="navbar">
      <h1>Panel de Control</h1>
    </div>

    <form action="index.php" method="POST">
      <h2>Registrar Nueva Venta</h2>

      <label for="cedula">Cédula</label>
      <input type="text" name="cedula" required>

      <label for="nombre">Nombre Completo</label>
      <input type="text" name="nombre" required>

      <label for="telefono">Teléfono</label>
      <input type="text" name="telefono" required>

      <label for="direccion">Dirección</label>
      <input type="text" name="direccion" required>

      <label for="id_producto">Código</label>
      <input type="text" name="id_producto" id="id_producto" required>

      <label for="codigo_barras">Código de Barras</label>
      <input type="text" id="codigo_barras" readonly>
      <img class="barcode" id="barcode_image" src="barcodes/default.png" alt="Código de barras">

      <label for="nombre_producto">Nombre del Producto</label>
      <input type="text" id="nombre_producto" readonly>

      <label for="descripcion_producto">Descripción</label>
      <input type="text" id="descripcion_producto" readonly>

      <label for="precio_unitario">Precio Unitario</label>
      <input type="number" id="precio_unitario" name="precio_unitario" readonly>

      <label for="cantidad">Cantidad</label>
      <input type="number" id="cantidad" name="cantidad" min="1" required>

      <label for="subtotal">Subtotal</label>
      <input type="number" id="subtotal" readonly>

      <button type="submit" name="submit" class="btn">Registrar Venta</button>
    </form>
  </div>

  <script>
    $(document).ready(function () {
      $('#id_producto').on('change', function () {
        let productoId = $(this).val();

        if (productoId) {
          $.ajax({
            url: 'obtener_producto.php',
            method: 'POST',
            data: {
              codigo: productoId
            },
            dataType: 'json',
            success: function (data) {
              if (data.error) {
                alert(data.error);
                $('#codigo_barras').val('');
                $('#nombre_producto').val('');
                $('#descripcion_producto').val('');
                $('#precio_unitario').val('');
                $('#barcode_image').attr('src', 'barcodes/default.png');
              } else {
                $('#codigo_barras').val(data.codigo_barras);
                $('#nombre_producto').val(data.nombre);
                $('#descripcion_producto').val(data.descripcion);
                $('#precio_unitario').val(data.precio);

                if (data.codigo_barras) {
                  $('#barcode_image').attr('src', 'barcodes/' + data.codigo_barras + '.png');
                } else {
                  $('#barcode_image').attr('src', 'barcodes/default.png');
                }

                calcularSubtotal();
              }
            },
            error: function () {
              alert('Error al obtener los datos del producto.');
            },
          });
        }
      });

      $('#cantidad').on('input', function () {
        calcularSubtotal();
      });

      function calcularSubtotal() {
        let cantidad = parseFloat($('#cantidad').val());
        let precio = parseFloat($('#precio_unitario').val());
        if (!isNaN(cantidad) && !isNaN(precio)) {
          $('#subtotal').val((cantidad * precio).toFixed(2));
        } else {
          $('#subtotal').val('');
        }
      }
    });
  </script>
</body>

</html>
