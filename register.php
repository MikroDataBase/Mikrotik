<?php
// Incluir archivo de conexión
require_once 'connect.php';

// Inicializar variables
$error = "";
$success = "";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password']; // Obtenemos la contraseña sin escapar para poder hashearla
    $phone = $conn->real_escape_string($_POST['phone']);
    
    // Validar datos
    if (empty($username) || empty($email) || empty($password) || empty($phone)) {
        $error = "Todos los campos son obligatorios";
    } else {
        // Verificar si el usuario ya existe
        $check_query = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_query);
        
        if ($result->num_rows > 0) {
            $error = "Este email ya está registrado";
        } else {
            // Hashear la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insertar nuevo usuario
            $insert_query = "INSERT INTO users (username, email, password, phone) 
                            VALUES ('$username', '$email', '$hashed_password', '$phone')";
            
            if ($conn->query($insert_query) === TRUE) {
                $success = "Registro exitoso. Redirigiendo al login...";
                // Redirigir al login después de 2 segundos
                header("refresh:2;url=login.html");
                exit;
            } else {
                $error = "Error al registrar: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesando Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
                <p class="login-link"><a href="index.html">Volver al formulario de registro</a></p>
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
