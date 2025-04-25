<?php
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
session_start();
?>

<?php
if (isset($_POST['submit'])) {
    $cedula = $_POST['cedula'];
    $admin = $_POST['administrador'];
    $empresa = $_POST['empresa'];
    $password = $_POST['password'];

    $passw_enc = password_hash($password, PASSWORD_DEFAULT, array("cost" => 12));

    $sql1 = $con->prepare("SELECT * FROM usuarios WHERE cedula = ?");
    $sql1->execute([$cedula]);
    $fila = $sql1->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        echo '<script>alert("Ya existe el documento");</script>';
        echo '<script>window.location = "R_admin.php";</script>';
    } else if ($cedula == "" || $empresa == "" || $admin == "" || $password == "") {
        echo '<script>alert("Todos los campos son obligatorios");</script>';
        echo '<script>window.location = "R_admin.php";</script>';
    } else {
        $insert = $con->prepare("INSERT INTO usuarios (cedula, nombre, 
                                                contraseña, roles, id_empresa) 
                                        VALUES ('$cedula', '$admin', 
                                                '$passw_enc', 'Administrador', '$empresa')");
        $insert->execute();

        echo '<script>alert("Registro guardado exitosamente");</script>';
        echo '<script>window.location = "R_admin.php";</script>';
        
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro MotoRacer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

            input,
            button {
                padding: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="/placeholder.svg?height=80&width=150" alt="MotoRacer Logo">
        </div>

        <form action="R_admin.php" method="post">
            <h3>Registro de Administradores</h3>

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
            <div><input type="text" name="cedula" placeholder="Cedula" required></div>

            <div> <input type="text" name="administrador" placeholder="Nombre de Administrador" required></div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
                <i class="fas fa-eye" id="togglePassword" onclick="togglePassword()"></i>
            </div>

            <button type="submit" name="submit">Registrar Empresa</button>

            <div class="login-link">
            </div>
        </form>
    </div>
    <script>
           function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>

    </script>
</body>


</html>