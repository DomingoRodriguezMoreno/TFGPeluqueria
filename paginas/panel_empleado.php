<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'empleado') {
    header('Location: /TFGPeluqueria/index.html');
    exit();
}

require_once '../funcionalidades/conexion.php'; // Asegúrate de incluir la conexión si es necesaria
include '../plantillas/navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Empleados</title>
    <link rel="stylesheet" href="/TFGPeluqueria/css/styles.css">
</head>
<body>
    <div class="contenedor-principal">
        <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
        
        <div class="botones-panel">
            <a href="empleados.php" class="boton-panel">Empleados</a>
            <a href="citas.php" class="boton-panel">Citas</a>
            <a href="clientes.php" class="boton-panel">Clientes</a> 
        </div>

        <a href="/TFGPeluqueria/funcionalidades/logout.php" class="logout-btn">Cerrar sesión</a>
    </div>
</body>
</html>