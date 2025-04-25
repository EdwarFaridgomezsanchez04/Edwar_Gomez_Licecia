<?php
session_start();
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
unset($_SESSION['cedula']);
session_destroy();
session_write_close();

header("Location: ../login.php");
?>
