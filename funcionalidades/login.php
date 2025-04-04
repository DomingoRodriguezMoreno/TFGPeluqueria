<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener datos del formulario
$identificador = $_POST['identificador'];
$password = $_POST['password'];

/* Depuración: Verificar datos del formulario
echo "Identificador proporcionado: $identificador<br>";
echo "Contraseña proporcionada: $password<br>";
*/

// Verificar si es un empleado
$query_empleado = "SELECT * FROM empleados WHERE dni = :identificador";
$stmt_empleado = $conn->prepare($query_empleado);
$stmt_empleado->bindParam(':identificador', $identificador);
$stmt_empleado->execute();

if ($stmt_empleado->rowCount() > 0) {
    // Es un empleado
    $empleado = $stmt_empleado->fetch(PDO::FETCH_ASSOC);

    /* Depuración: Verificar datos del empleado
    echo "Hash almacenado (empleado): " . $empleado['contraseña'] . "<br>";
    echo "Resultado de password_verify: " . (password_verify($password, $empleado['contraseña']) ? 'true' : 'false') . "<br>";
    */
    if (password_verify($password, $empleado['contraseña'])) {
        // Contraseña válida
        session_start();
        $_SESSION['tipo_usuario'] = 'empleado';
        $_SESSION['dni'] = $empleado['dni'];
        $_SESSION['nombre'] = $empleado['nombre'];
        $_SESSION['id_rol'] = $empleado['id_rol'];
        // Redirigir al panel de empleados
        header('Location: /TFGPeluqueria/');
        exit();
    } else {
        // Contraseña incorrecta
        echo "Contraseña incorrecta (empleado).<br>";
    }
} else {
    // No es un empleado, verificar si es un cliente
    $query_cliente = "SELECT * FROM clientes WHERE telefono = :identificador";
    $stmt_cliente = $conn->prepare($query_cliente);
    $stmt_cliente->bindParam(':identificador', $identificador);
    $stmt_cliente->execute();

    if ($stmt_cliente->rowCount() > 0) {
        // Es un cliente
        $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);

        /* Depuración: Verificar datos del cliente
        echo "Hash almacenado (cliente): " . $cliente['contraseña'] . "<br>";
        echo "Resultado de password_verify: " . (password_verify($password, $cliente['contraseña']) ? 'true' : 'false') . "<br>";
        */
        if (password_verify($password, $cliente['contraseña'])) {
            // Contraseña válida
            session_start();
            $_SESSION['tipo_usuario'] = 'cliente';
            $_SESSION['id_cliente'] = $cliente['id_cliente'];
            $_SESSION['nombre'] = $cliente['nombre'];
            // Redirigir al panel de clientes
            header('Location: /TFGPeluqueria/');
            exit();
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta (cliente).<br>";
        }
    } else {
        // Usuario no encontrado
        echo "Usuario no encontrado.<br>";
    }
}
?>