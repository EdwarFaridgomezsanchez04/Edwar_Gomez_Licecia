<?php
require_once('../conex/conexion.php'); // Asegúrate de que la ruta sea correcta

$conex = new database();
$con = $conex->conectar();

$sql = $con->prepare("SELECT COUNT(*) AS total_licencias FROM licencia");
$sql->execute();
$result = $sql->fetch(PDO::FETCH_ASSOC);
$total_licencias = $result['total_licencias'];

$sql1 = $con->prepare("SELECT COUNT(*) AS total_empresas FROM empresa");
$sql1->execute();
$result1 = $sql1->fetch(PDO::FETCH_ASSOC);
$total_empresas = $result1['total_empresas'];

$sql2 = $con->prepare("SELECT COUNT(*) AS total_administradores FROM usuarios");
$sql2->execute();
$result2 = $sql2->fetch(PDO::FETCH_ASSOC);
$total_administradores = $result2['total_administradores'] -1;

$sql3 = $con->prepare("SELECT SUM(tipo_licencia.valor) AS total_ventas
                              FROM licencia
                              INNER JOIN tipo_licencia ON licencia.tipo_licencia = tipo_licencia.id_tipo
");
$sql3->execute();
$result3 = $sql3->fetch(PDO::FETCH_ASSOC);
$total_ventas = $result3['total_ventas'] ?? 0; // Si no hay ventas, devuelve 0

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
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

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .card {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card h3 {
      margin-bottom: 10px;
      color: #2c3e50;
    }

    .card p {
      font-size: 24px;
      font-weight: bold;
      color: #27ae60;
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
    <a href="empresa.php">Empresas</a>
    <a href="licencia.php">Licencias</a>
    <a href="admin.php">Administradores</a>
    <a href="#">Configuración</a>
  </div>

  <div class="main">
    <div class="navbar">
      <h1>Panel de Control</h1>
    </div>

    <div class="cards">
      <div class="card">
        <h3>Licencias</h3>
        <p><?php echo $total_licencias; ?></p>
      </div>
      <div class="card">
      <h3>Precio_total</h3>
      <p> $ <?php echo $total_ventas; ?></p>
    </div>
    <div class="card">
      <h3>Empresas</h3>
      <p><?php echo $total_empresas; ?></p>
    </div>
    <div class="card">
      <h3>Administradores</h3>
      <p><?php echo $total_administradores; ?></p>
    </div>

  </div>
  </div>

</body>

</html>