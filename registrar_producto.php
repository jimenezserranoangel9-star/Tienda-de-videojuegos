<?php
// Archivo: registrar_producto.php
include 'db_connection.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre_producto'];
    $id_almacen = $_POST['id_almacen'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO Productos (Nombre_producto, ID_almacen_productos, Cantidad, Precio) VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidd", $nombre, $id_almacen, $cantidad, $precio);
    
    if ($stmt->execute()) {
        $mensaje = "<p style='color: green; font-weight: bold;'>✅ Producto registrado correctamente!</p>";
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
    <title>Registro de Producto - Tienda</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #e9ecef; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 30px; }
        label { display: block; margin-top: 15px; font-weight: 600; color: #343a40; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ced4da; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #007bff; color: white; padding: 12px 15px; border: none; border-radius: 5px; cursor: pointer; margin-top: 25px; width: 100%; font-weight: bold; transition: background-color 0.3s; }
        button:hover { background-color: #0056b3; }
        .menu a { margin-right: 15px; text-decoration: none; color: #28a745; font-weight: 500;}
    </style>
</head>
<body>
    <div class="container">
        <h1>📦 Registrar Nuevo Producto</h1>
        <div class="menu">
            <a href="index.php">🏠 Inicio</a> |
            <a href="ver_productos.php">Ver Inventario</a>
        </div>
        <hr style="margin: 20px 0;">
        <?php echo $mensaje; ?>

        <form action="registrar_producto.php" method="POST">
            <label for="nombre_producto">Nombre del Producto:</label>
            <input type="text" id="nombre_producto" name="nombre_producto" required>

            <label for="id_almacen">ID Almacén:</label>
            <input type="number" id="id_almacen" name="id_almacen" required>

            <label for="cantidad">Cantidad (Stock):</label>
            <input type="number" id="cantidad" name="cantidad" required>

            <label for="precio">Precio Unitario:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <button type="submit">Guardar Producto</button>
        </form>
    </div>
</body>
</html>