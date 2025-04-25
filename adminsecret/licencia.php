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
    <a href="empresa.php">Empresas</a>
    <a href="licencia.php">Licencias</a>
    <a href="admin.php">Administradores</a>
    <a href="#">Configuración</a>
  </div>

  <div class="main">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Identificador</th>
          <th>Licencia</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
          <th>Estado</th>
          <th>Empresa</th>
          <th>Valor</th>


          <th colspan="2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = $con->prepare("SELECT * FROM licencia 
        INNER JOIN tipo_licencia ON  licencia.tipo_licencia = tipo_licencia.id_tipo
        INNER JOIN estado_licencia  ON licencia.id_estado = estado_licencia.id_estado 
        INNER JOIN empresa ON licencia.nit = empresa.id_empresa 
         ");
        $sql->execute();
        $fila = $sql->fetchAll(PDO::FETCH_ASSOC);
        $count = 1;
        foreach ($fila as $resu) {
        ?>
          <tr>
            <td><?php echo $count++; ?></td>
            <td><input type="text" readonly value="<?php echo $resu['id_licencia']; ?>"></td>
            <td><input type="text" readonly value="<?php echo $resu['tipo']; ?>"></td>
            <td><input type="text" readonly value="<?php echo $resu['fecha_inicio']; ?>"></td>
            <td><input type="text" readonly value="<?php echo $resu['fecha_fin']; ?>"></td>
            <td><input type="text" readonly value="<?php echo $resu['estado']; ?>"></td>
            <td><input type="text" readonly value="<?php echo $resu['empresa']; ?>"></td>
            <td><input type="text" readonly value="<?php echo $resu['valor']; ?>"></td>


            <td>
              <a href="#" onclick="window.open('actualizar.php?id=<?php echo $resu['id_licencia']; ?>', '', 'width=600,height=500,toolbar=NO')" title="Actualizar">
                ✏️
              </a>
            </td>
            <td>

              <a href="delete.php?id=<?php echo $resu['id_licencia']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta licencia?')" title="Eliminar">
                🗑️
              </a>

            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <div>
      <button class="btn" onclick="window.open('R_licencia.php?id=123', '', 'width=600,height=500,toolbar=NO')">Crear licencia</button>
    </div>
  </div>

</body>

</html>