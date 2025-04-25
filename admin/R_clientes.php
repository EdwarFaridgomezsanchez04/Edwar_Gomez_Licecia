<?php 
require_once('../conex/conexion.php');
$conex = new database();
$con = $conex->conectar();
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente</title>
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
            max-width: 450px;
            padding: 40px;
            transition: transform 0.3s ease;
        }
        
        .login-container:hover {
            transform: translateY(-5px);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo img {
            max-width: 150px;
            height: auto;
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
        }
        
        input {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            background-color: var(--input-bg);
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        input:focus {
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
            margin-top: 10px;
        }
        
        button:hover {
            background-color: #d62839;
            transform: translateY(-2px);
        }
        
        button:active {
            transform: translateY(0);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: var(--text-color);
            font-size: 14px;
        }
        
        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
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
        <div class="logo">
            <img src="/placeholder.svg?height=80&width=150" alt="MotoRacer Logo">
        </div>
        
        <form action="R_clientes.php" method="post">
            <h3>Registro de Cliente</h3>
            
            <input type="text" name="cedula" placeholder="Cédula" required>
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="text" name="direccion" placeholder="Dirección" required>
            
            <button type="submit" name="submit">Registrar Cliente</button>
        </form>
    </div>
</body>
</html>
