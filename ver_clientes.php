<?php
// Archivo: ver_clientes.php
include 'db_connection.php'; 

$sql = "SELECT Id_cliente, Nombre, Apellido, Email, Telefono, Numero_de_registro FROM Clientes";
$resultado = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Clientes</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f8f9fa; color: #343a40; }
        .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #20c997; border-bottom: 2px solid #20c997; padding-bottom: 10px; margin-bottom: 30px; }
        .menu a { margin-right: 15px; text-decoration: none; color: #6c757d; font-weight: bold; transition: color 0.3s; }
        .menu a:hover { color: #20c997; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #dee2e6; }
        th { background-color: #e9ecef; color: #343a40; font-weight: 600; }
        tr:hover { background-color: #f1f1f1; }
        .no-registros { text-align: center; color: #dc3545; padding: 20px; border: 1px solid #dc3545; background-color: #f8d7da; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>👥 Clientes Registrados</h1>
        <div class="menu">
            <a href="index.php">🏠 Inicio</a> |
            <a href="registrar_cliente.php">➕ Nuevo Cliente</a>
        </div>
        <hr style="margin: 20px 0;">

        <?php if ($resultado->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>N° Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['Id_cliente']; ?></td>
                        <td>**<?php echo htmlspecialchars($fila['Nombre'] . " " . $fila['Apellido']); ?>**</td>
                        <td><?php echo htmlspecialchars($fila['Email']); ?></td>
                        <td><?php echo htmlspecialchars($fila['Telefono']); ?></td>
                        <td><?php echo htmlspecialchars($fila['Numero_de_registro']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-registros">
                Aún no hay clientes registrados en la base de datos.
            </div>
        <?php endif; ?>

    </div>
</body>
</html>