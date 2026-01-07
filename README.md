🛠️ Sistema de Administración de Tienda (PHP)
Este es un panel de administración web ligero y funcional diseñado para gestionar las operaciones básicas de una tienda. Permite centralizar el registro de clientes, control de inventario y el historial de ventas en una interfaz limpia y responsiva.

🚀 Características
El panel se divide en dos módulos principales:

➕ Gestión de Registros
Registro de Clientes: Alta de nuevos usuarios en la base de datos.

Registro de Productos: Gestión de inventario entrante.

Registro de Ventas: Interfaz dedicada para procesar transacciones de forma rápida.

🔍 Consultas e Informes
Visualización de Datos: Tablas detalladas de clientes y productos.

Historial de Ventas: Seguimiento completo de las transacciones realizadas.

Buscador Inteligente: Filtro rápido para localizar productos específicos en el inventario.

🛠️ Tecnologías Utilizadas
PHP: Lógica del lado del servidor.

HTML5 & CSS3: Estructura y diseño moderno utilizando CSS Grid para una interfaz adaptable.

Google Fonts & Emojis: Para una experiencia de usuario visualmente intuitiva.

📂 Estructura del Proyecto
El archivo index.php actúa como el núcleo del sistema, conectando con los siguientes módulos (asegúrate de tenerlos creados):

Bash

├── index.php                # Panel principal (Dashboard)
├── registrar_cliente.php    # Formulario de alta de clientes
├── registrar_producto.php   # Formulario de alta de productos
├── registrar_venta.php      # Proceso de venta
├── ver_clientes.php         # Listado de clientes
├── ver_productos.php        # Listado de inventario
├── ver_ventas.php           # Historial transaccional
└── buscar_producto.php      # Motor de búsqueda
💻 Instalación y Uso

🎨 Vista Previa de la Interfaz
El diseño cuenta con un estilo moderno con efectos de elevación (hover) y una paleta de colores profesional:

🟢 Verde: Acciones positivas (Clientes).

🔵 Azul: Acciones informativas (Productos/Sistema).

🔴 Rojo: Acciones críticas o de salida (Ventas).
