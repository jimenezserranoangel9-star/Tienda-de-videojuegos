<?php
// Archivo: ver_ventas.php
include 'db_connection.php'; 

// Consulta con JOIN para obtener el nombre del cliente
$sql = "
    SELECT 
        V.Id_venta, 
        C.Nombre, 
        C.Apellido, 
        V.Monto_total, 
        V.Fecha_venta 
    FROM Ventas V
    JOIN Clientes C ON V.ID_cliente_venta = C.Id_cliente
    ORDER BY V.Fecha_venta DESC
";
$resultado = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Ventas</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f8f9fa; color: #343a40; }
        .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #6f42c1; border-bottom: 2px solid #6f42c1; padding-bottom: 10px; margin-bottom: 30px; }
        .menu a { margin-right: 15px; text-decoration: none; color: #6c757d; font-weight: bold; transition: color 0.3s; }
        .menu a:hover { color: #6f42c1; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #dee2e6; }
        th { background-color: #e9ecef; color: #343a40; font-weight: 600; }
        tr:hover { background-color: #f1f1f1; }
        .no-registros { text-align: center; color: #dc3545; padding: 20px; border: 1px solid #dc3545; background-color: #f8d7da; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📈 Historial de Ventas</h1>
        <div class="menu">
            <a href="index.php">🏠 Inicio</a> |
            <a href="registrar_venta.php">➕ Nueva Venta</a>
        </div>
        <hr style="margin: 20px 0;">

        <?php if ($resultado->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>Cliente</th>
                        <th>Monto Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['Id_venta']; ?></td>
                        <td>**<?php echo htmlspecialchars($fila['Nombre'] . " " . $fila['Apellido']); ?>**</td>
                        <td>**$<?php echo number_format($fila['Monto_total'], 2); ?>**</td>
                        <td><?php echo date("d/m/Y", strtotime($fila['Fecha_venta'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-registros">
                Aún no hay ventas registradas.
            </div>
        <?php endif; ?>

    </div>
</body>
</html>