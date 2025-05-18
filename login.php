<?php
// Incluir archivo de conexión
require_once 'connect.php';
    $db_server = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "mikrotik_users";
    // Crear conexión
    $conn = new mysqli($db_server, $db_username, $db_password, $db_name);
    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    // Establecer charset a utf8
    $conn->set_charset("utf8");
// Inicializar variables
$error = "";
$success = "";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener contraseña del formulario
    $password = $_POST['password'];
    
    // Validar datos
    if (empty($password)) {
        $error = "La contraseña es obligatoria";
    } else {
        // Buscar usuario por contraseña
        $query = "SELECT * FROM users";
        $result = $conn->query($query);
        
        $authenticated = false;
        
        if ($result->num_rows > 0) {
            // Verificar cada usuario
            while ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    $authenticated = true;
                    $username = $row['username'];
                    break;
                }
            }
        }
        
        if ($authenticated) {
            $success = "Autenticación exitosa. Bienvenido, $username!";
            
            // Redirigir al Mikrotik con los parámetros necesarios
            // Nota: Ajusta la URL según tu configuración de Mikrotik
            header("refresh:2;url=http://10.5.50.1/login?username=admin2&password=admin2");
            exit;
        } else {
            $error = "Contraseña incorrecta";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesando Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
                <p class="login-link"><a href="login.html">Volver al formulario de login</a></p>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
