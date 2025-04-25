<?php
if (!isset($_GET['codigo'])) {
    echo "Código no proporcionado.";
    exit;
}

$codigo = $_GET['codigo'];
$path = "./barcodes/{$codigo}.png";

if (!file_exists($path)) {
    echo "Código de barras no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Imprimir Código</title>
    <style>
        body {
            text-align: center;
            margin-top: 50px;
        }
        img {
            width: 300px;
        }
        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>
<body>

<h2><?= $codigo ?></h2>
<img src="<?= $path ?>" alt="Código de barras">
<br><br>
<button onclick="window.print()">Imprimir</button>

</body>
</html>
