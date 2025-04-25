<?php
session_start();
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();

if (isset($_POST['login'])) {
    // 1. Recogemos y saneamos los datos
    $cedula   = trim($_POST['cedula']);
    $password = $_POST['password'];
    $empresa  = trim($_POST['empresa']);

    // 2. Validamos que no vayan vacíos
    if (empty($cedula) || empty($empresa) || empty($password)) {
        echo '<script>alert("Ningún dato puede estar vacío"); window.location="../login.php";</script>';
        exit();
    }

    // 3. Preparamos la consulta filtrando por cédula y empresa
    $sql = $con->prepare(" SELECT * FROM usuarios 
        WHERE cedula = :cedula 
          AND id_empresa = :empresa
        LIMIT 1");

    $sql->bindParam(':cedula',  $cedula,  PDO::PARAM_INT);
    $sql->bindParam(':empresa', $empresa, PDO::PARAM_INT);
    $sql->execute();
    $fila = $sql->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        // 4. Verificamos contraseña
        if (password_verify($password, $fila['contraseña'])) {
            // 5. Creamos variables de sesión
            $_SESSION['cedula']  = $fila['cedula'];
            $_SESSION['empresa'] = $fila['id_empresa'];

            // 6. Redirigimos a la página principal
            header("Location: ../admin/index.php");
            exit();
        } else {
            // contraseña incorrecta
            echo '<script>alert("Contraseña incorrecta"); window.location="../login.php";</script>';
            exit();
        }
    } else {
        // cédula+empresa no encontrado
        echo '<script>alert("Usuario o empresa no encontrados"); window.location="../login.php";</script>';
        exit();
    }
}
?>
