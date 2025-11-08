<?php
// Archivo: registrar_venta.php
include 'db_connection.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'];
    $monto_total = $_POST['monto_total'];
    $fecha_venta = date("Y-m-d"); 

    $sql = "INSERT INTO Ventas (ID_cliente_venta, Monto_total, Fecha_venta) VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ids", $id_cliente, $monto_total, $fecha_venta);
    
    if ($stmt->execute()) {
        $mensaje = "<p style='color: green; font-weight: bold;'>✅ Venta registrada correctamente (Monto: $" . $monto_total . ")</p>";
    } else {
        $mensaje = "<p style='color: red; font-weight: bold;'>❌ Error al registrar la venta: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Lógica para obtener clientes (para el desplegable)
$clientes_resultado = $conn->query("SELECT Id_cliente, Nombre, Apellido FROM Clientes ORDER BY Apellido");

// No cerramos la conexión hasta el final del script
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta - Tienda</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #e9ecef; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #dc3545; border-bottom: 2px solid #dc3545; padding-bottom: 10px; margin-bottom: 30px; }
        label { display: block; margin-top: 15px; font-weight: 600; color: #343a40; }
        input[type="number"], select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ced4da; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #dc3545; color: white; padding: 12px 15px; border: none; border-radius: 5px; cursor: pointer; margin-top: 25px; width: 100%; font-weight: bold; transition: background-color 0.3s; }
        button:hover { background-color: #c82333; }
        .menu a { margin-right: 15px; text-decoration: none; color: #6f42c1; font-weight: 500;}
    </style>
</head>
<body>
    <div class="container">
        <h1>🛒 Registrar Venta</h1>
        <div class="menu">
            <a href="index.php">🏠 Inicio</a> |
            <a href="ver_ventas.php">Ver Historial de Ventas</a>
        </div>
        <hr style="margin: 20px 0;">
        <?php echo $mensaje; ?>

        <form action="registrar_venta.php" method="POST">
            <label for="id_cliente">Cliente:</label>
            <select id="id_cliente" name="id_cliente" required>
                <option value="">-- Selecciona un Cliente --</option>
                <?php
                if ($clientes_resultado && $clientes_resultado->num_rows > 0) {
                    while($cliente = $clientes_resultado->fetch_assoc()) {
                        echo "<option value='" . $cliente['Id_cliente'] . "'>" . $cliente['Nombre'] . " " . $cliente['Apellido'] . " (ID: " . $cliente['Id_cliente'] . ")</option>";
                    }
                } else {
                    echo "<option value=''>¡No hay clientes registrados!</option>";
                }
                ?>
            </select>

            <label for="monto_total">Monto Total de la Compra:</label>
            <input type="number" id="monto_total" name="monto_total" step="0.01" required>

            <button type="submit">Finalizar Venta</button>
        </form>
    </div>
</body>
</html>