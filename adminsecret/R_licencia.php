
<?php
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
session_start();
date_default_timezone_set('America/Bogota');
$date = date("Y-m-d H:i:s");
$estado = 1 
    

?>
<?php
function generarCodigoAlfanumerico($longitud = 10) {
    return substr(bin2hex(random_bytes($longitud)), 0, $longitud);
}

$codigo = generarCodigoAlfanumerico(20); // Genera un código de 12 caracteres
?>
<?php
if (isset($_POST['submit'])) {
    $licencia = $_POST['tipo_licencia'];
    $fecha_fin = $_POST['fecha_fin'];	
    $empresa = $_POST['empresa'];


    $sql1 = $con->prepare("SELECT * FROM licencia  
    INNER JOIN tipo_licencia ON licencia.tipo_licencia = tipo_licencia.id_tipo 
    INNER JOIN empresa ON licencia.nit = empresa.id_empresa
    WHERE id_licencia = $licencia");
    $sql1->execute();
    $fila = $sql1->fetchAll(PDO::FETCH_ASSOC);

    if ($fila) {
        echo '<script>alert("Ya existe el documento");</script>';
        echo '<script>window.location = "registro.php";</script>';
    }


    if (  $licencia == "" ||   $fecha_fin == "") {
        echo '<script>alert("Todos los campos son obligatorios");</script>';
        echo '<script>window.location = "registro.php";</script>';
    } else {
        
        $insert = $con->prepare("INSERT INTO licencia  (id_licencia, tipo_licencia, fecha_inicio, fecha_fin, id_estado, nit)
         VALUES ('$codigo', '$licencia', '$date', '$fecha_fin', '$estado', '$empresa')");
        $insert->execute();    

        echo '<script>alert("Registro guardado exitosamente");</script>';
        echo '<script>window.location = "R_licencia.php";</script>';
    }
}

?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Licencia - MotoRacer</title>
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

        label {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        select,
        input {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: var(--input-bg);
            transition: border-color 0.3s, box-shadow 0.3s;
            width: 100%;
        }

        input:focus,
        select:focus {
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
    <h3>Registrar Licencia</h3>
    <form method="POST" action="R_licencia.php">
        <div>
            <label>Empresa</label>
            <select name="empresa" required>
                <option value="">Seleccione una empresa</option>
                <?php
                $sql = $con->prepare("SELECT * FROM empresa");
                $sql->execute();
                while ($fila1 = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . htmlspecialchars($fila1['id_empresa']) . "'>" . htmlspecialchars($fila1['empresa']) . "</option>";
                }
                ?>
            </select>
        </div>

        <div>
            <label>Tipo de Licencia</label>
            <select id="tipoLicencia" name="tipo_licencia" required>
                <option value="">Seleccione una licencia</option>
                <?php
                $sql = $con->prepare("SELECT * FROM tipo_licencia");
                $sql->execute();
                while ($fila1 = $sql->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . htmlspecialchars($fila1['id_tipo']) . "' data-duracion='" . htmlspecialchars($fila1['duracion_dias']) . "'>" . htmlspecialchars($fila1['tipo']) . "</option>";
                }
                ?>
            </select>
        </div>

        <div>
            <label>Fecha de Inicio</label>
            <input type="text" name="fecha_inicio" value="<?php echo $date ?>" readonly required>
        </div>

        <div>
            <label>Fecha de Fin</label>
            <input type="text" id="fecha_fin" name="fecha_fin" required>
        </div>

        <button type="submit" name="submit">Registrar</button>
    </form>
</div>

<script>
    document.getElementById('tipoLicencia').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const duracion = parseInt(selectedOption.getAttribute('data-duracion'));

        if (!isNaN(duracion)) {
            const fechaInicio = new Date();
            fechaInicio.setDate(fechaInicio.getDate() + duracion);

            const yyyy = fechaInicio.getFullYear();
            const mm = String(fechaInicio.getMonth() + 1).padStart(2, '0');
            const dd = String(fechaInicio.getDate()).padStart(2, '0');

            const fechaFin = `${yyyy}-${mm}-${dd}`;
            document.getElementById('fecha_fin').value = fechaFin;
        }
    });
</script>

</body>
</html>
