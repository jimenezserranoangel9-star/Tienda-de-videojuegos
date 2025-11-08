<?php
// Archivo: buscar_producto.php
include 'db_connection.php'; 

$busqueda = "";
$resultado = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busqueda'])) {
    $busqueda = $conn->real_escape_string($_POST['busqueda']);
    
    $sql = "SELECT Id_producto, Nombre_producto, Cantidad, Precio 
            FROM Productos 
            WHERE Nombre_producto LIKE ? 
            ORDER BY Nombre_producto ASC";

    $stmt = $conn->prepare($sql);
    
    $param_busqueda = "%" . $busqueda . "%"; 
    $stmt->bind_param("s", $param_busqueda);
    
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Productos | Tienda</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f8f9fa; color: #343a40; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #17a2b8; border-bottom: 2px solid #17a2b8; padding-bottom: 10px; margin-bottom: 30px; }
        .menu a { margin-right: 15px; text-decoration: none; color: #6c757d; font-weight: bold; transition: color 0.3s; }
        .menu a:hover { color: #17a2b8; }
        .form-busqueda { display: flex; gap: 10px; margin-bottom: 30px; }
        .form-busqueda input[type="text"] { flex-grow: 1; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; font-size: 1em; }
        .form-busqueda button { background-color: #17a2b8; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; }
        .form-busqueda button:hover { background-color: #138496; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #dee2e6; }
        th { background-color: #e9ecef; color: #343a40; font-weight: 600; }
        tr:hover { background-color: #f1f1f1; }
        .info { text-align: center; color: #007bff; padding: 10px; border: 1px solid #007bff; background-color: #cce5ff; border-radius: 5px; margin-top: 20px; }
        .alerta { text-align: center; color: #dc3545; padding: 10px; border: 1px solid #dc3545; background-color: #f8d7da; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔎 Buscar Productos</h1>
        <div class="menu">
            <a href="index.php">🏠 Inicio</a> |
            <a href="registrar_producto.php">➕ Registrar Producto</a> |
            <a href="ver_productos.php">Inventario Completo</a>
        </div>
        <hr style="margin: 20px 0;">

        <form action="buscar_producto.php" method="POST" class="form-busqueda">
            <input type="text" name="busqueda" placeholder="Escribe el nombre del producto (o parte de él)" value="<?php echo htmlspecialchars($busqueda); ?>" required>
            <button type="submit">Buscar</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <div class="info">
                    Se encontraron **<?php echo $resultado->num_rows; ?>** resultados para "<?php echo htmlspecialchars($busqueda); ?>".
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fila['Id_producto']; ?></td>
                            <td>**<?php echo htmlspecialchars($fila['Nombre_producto']); ?>**</td>
                            <td>$<?php echo number_format($fila['Precio'], 2); ?></td>
                            <td><?php echo $fila['Cantidad']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php elseif ($busqueda): ?>
                <div class="alerta">
                    ⚠️ No se encontraron resultados para "<?php echo htmlspecialchars($busqueda); ?>". Intenta con un término diferente.
                </div>
            <?php endif; ?>
        
        <?php else: ?>
            <div class="info">
                Ingresa el nombre de un producto arriba para iniciar la búsqueda.
            </div>
        <?php endif; ?>

    </div>
</body>
</html>