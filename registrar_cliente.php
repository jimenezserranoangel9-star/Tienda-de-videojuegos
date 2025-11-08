<?php
// Archivo: registrar_cliente.php
include 'db_connection.php'; 

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $registro = $_POST['registro'];

    $sql = "INSERT INTO Clientes (Nombre, Apellido, Email, Telefono, Numero_de_registro) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellido, $email, $telefono, $registro);
    
    if ($stmt->execute()) {
        $mensaje = "<p style='color: green; font-weight: bold;'>✅ Cliente registrado correctamente!</p>";
    } else {
        $mensaje = "<p style='color: red; font-weight: bold;'>❌ Error al registrar: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Cliente - Tienda</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #e9ecef; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 10px; margin-bottom: 30px; }
        label { display: block; margin-top: 15px; font-weight: 600; color: #343a40; }
        input[type="text"], input[type="email"] { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ced4da; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; padding: 12px 15px; border: none; border-radius: 5px; cursor: pointer; margin-top: 25px; width: 100%; font-weight: bold; transition: background-color 0.3s; }
        button:hover { background-color: #218838; }
        .menu a { margin-right: 15px; text-decoration: none; color: #007bff; font-weight: 500;}
    </style>
</head>
<body>
    <div class="container">
        <h1>👤 Registrar Nuevo Cliente</h1>
        <div class="menu">
            <a href="index.php">🏠 Inicio</a> |
            <a href="ver_clientes.php">Ver Clientes</a>
        </div>
        <hr style="margin: 20px 0;">
        <?php echo $mensaje; ?>

        <form action="registrar_cliente.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono">

            <label for="registro">Número de Registro:</label>
            <input type="text" id="registro" name="registro" required>

            <button type="submit">Guardar Cliente</button>
        </form>
    </div>
</body>
</html>