<?php
session_start();
require_once('../conex/conexion.php');

if (!isset($_SESSION['cedula']) || !isset($_SESSION['empresa'])) {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}

session_regenerate_id(true);
?>
