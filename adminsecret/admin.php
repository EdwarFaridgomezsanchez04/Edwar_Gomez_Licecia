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
    <a href="index.php">Empresas</a>
    <a href="licencia.php">Licencias</a>
    <a href="admin.php">Administradores</a>
    <a href="#">Configuración</a>
  </div>

  <div class="main">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Cedula</th>
          <th>Nombre</th>
          <th>Empresa</th>
          <th colspan="2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = $con->prepare("SELECT * FROM usuarios
                                INNER JOIN empresa ON usuarios.id_empresa = empresa.id_empresa
                                WHERE cedula ");
        $sql->execute();
        $fila = $sql->fetchAll(PDO::FETCH_ASSOC);
        $count = 1;
        foreach ($fila as $resu) {
        ?>
          <tr>
            <td><?php echo $count++; ?></td>
            <td><input type="text" readonly value="<?php echo $resu['cedula']; ?>"></td>
            <td><input type="text" readonly value="<?php echo $resu['nombre']; ?>"></td>
            <td><input type="text" readonly value="<?php echo $resu['empresa']; ?>"></td>

            <td>
              <a href="#" onclick="window.open('actualizar.php?id=<?php echo $resu['cedula']; ?>', '', 'width=600,height=500,toolbar=NO')" title="Actualizar">
                ✏️
              </a>
            </td>
            <td>
              <a href="delete_em.php?id=<?php echo $resu['cedula']; ?>" onclick="return confirm('¿Estás seguro de eliminar este administrador?')" title="Eliminar">
                  🗑️
                </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <div>

      <button class="btn" onclick="window.open('R_admin.php?id=123', '', 'width=600,height=500,toolbar=NO')">Crear Administrador</button>
    </div>
  </div>

</body>

</html>