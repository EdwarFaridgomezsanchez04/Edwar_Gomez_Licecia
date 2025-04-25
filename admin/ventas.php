<?php
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ventas</title>
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

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table th,
    .table td {
      border: 1px solid #ddd;
      padding: 8px;
    }

    .table th {
      background-color: #2c3e50;
      color: white;
      text-align: center;
    }

    .table td {
      text-align: center;
    }

    input[readonly] {
      border: none;
      background: transparent;
      text-align: center;
      width: 100%;
    }

    button.btn {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: rgb(20, 92, 50);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button.btn:hover {
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
    <h3 style="margin-bottom: 20px;">Listado de Ventas</h3>
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Cédula Cliente</th>
          <th>Fecha</th>
          <th>Total</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = $con->prepare("SELECT * FROM ventas");
        $sql->execute();
        $ventas = $sql->fetchAll(PDO::FETCH_ASSOC);
        $count = 1;
        foreach ($ventas as $venta) {
        ?>
          <tr>
            <td><?php echo $count++; ?></td>
            <td><input type="text" readonly value="<?php echo $venta['cedula_cliente']; ?>"></td>
            <td><input type="text" readonly value="<?php echo $venta['fecha']; ?>"></td>
            <td><input type="text" readonly value="<?php echo $venta['total']; ?>"></td>
            <td>
              <a href="delete_venta.php?id=<?php echo $venta['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta venta?')" title="Eliminar">
                🗑️
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>

</html>
