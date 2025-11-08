<?php
// Archivo: db_connection.php
// ************************************************
// !!! CONFIGURACIÓN DE INFINITYFREE: DEBES EDITAR LOS SIGUIENTES 4 VALORES !!!
// ************************************************
// Host: (Ej. sqlXXX.infinityfree.com)
$host = "sql300.infinityfree.com"; 

// Usuario de DB: (Ej. if0_12345678)
$user = "if0_40116298";      

// Contraseña de DB: La que definiste en InfinityFree
$password = "UlTRA6Shabo0xS"; 

// Nombre completo de tu DB: (Ej. if0_12345678_tienda_db)
$database = "if0_40116298_tienda"; 
// ************************************************
// ************************************************

// Crear la conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("❌ Error de Conexión: Asegúrate de que los datos en db_connection.php son correctos. Mensaje de error: " . $conn->connect_error);
}

// Establecer el juego de caracteres
$conn->set_charset("utf8");
?>