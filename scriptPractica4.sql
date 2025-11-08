DROP DATABASE IF EXISTS tienda_de_videojuegos;

CREATE DATABASE tienda_de_videojuegos;

USE tienda_de_videojuegos;

-- DEFINICION DE LAS TABLAS EN ORDEN
CREATE TABLE empleados (
	id_empleado INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    primer_nombre VARCHAR(32) NOT NULL DEFAULT ' ',
    segundo_nombre VARCHAR(32) DEFAULT ' ',
    apellido_paterno VARCHAR(32) NOT NULL DEFAULT ' ',
    apellido_materno VARCHAR(32) NOT NULL DEFAULT ' ',
    telefono VARCHAR(32) NOT NULL DEFAULT ' ',
    tipo ENUM('CAJERO', 'ALMACENISTA') NOT NULL DEFAULT 'CAJERO'
);

CREATE TABLE proveedores (
	id_proveedor INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    primer_nombre VARCHAR(32) NOT NULL DEFAULT ' ',
    segundo_nombre VARCHAR(32) DEFAULT ' ',
    apellido_paterno VARCHAR(32) NOT NULL DEFAULT ' ',
    apellido_materno VARCHAR(32) NOT NULL DEFAULT ' ',
    calle VARCHAR(32) NOT NULL DEFAULT ' ',
    num_ext VARCHAR(16) NOT NULL DEFAULT ' ',
    colonia VARCHAR(32) NOT NULL DEFAULT ' ',
    alcaldia VARCHAR(32) NOT NULL DEFAULT ' ',
    codigo_postal VARCHAR(32) NOT NULL DEFAULT ' '
);

CREATE TABLE telefono_proveedor (
	id_telefono INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_proveedor INT NOT NULL,
    telefono VARCHAR(32) NOT NULL DEFAULT ' ',
    
    FOREIGN KEY (id_proveedor) REFERENCES proveedores (id_proveedor) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE contratos (
	id_contrato INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_proveedor INT NOT NULL,
    fecha_inicio DATETIME NOT NULL DEFAULT NOW(),
    fecha_termino DATETIME NOT NULL,
    monto_acordado FLOAT NOT NULL,
	
    CHECK (monto_acordado >= 0.0),
    CHECK (fecha_inicio < fecha_termino),
	FOREIGN KEY (id_proveedor) REFERENCES proveedores (id_proveedor) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE productos (
	id_producto INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_proveedor INT NOT NULL,
    marca VARCHAR(64) NOT NULL DEFAULT ' ',
    categoria VARCHAR(32) NOT NULL DEFAULT ' ',
    precio FLOAT NOT NULL DEFAULT 0.0,
    stock INT NOT NULL DEFAULT 0,
    
    CHECK (stock >= 0),
    CHECK (precio >= 0.0),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores (id_proveedor) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE productos_fisicos (
	id_producto_fisico INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_producto INT NOT NULL,
    peso FLOAT NOT NULL DEFAULT 0.0,
    codigo_almacen VARCHAR(32) NOT NULL DEFAULT ' ',
    
    CHECK (peso >= 0.0),
    FOREIGN KEY (id_producto) REFERENCES productos (id_producto) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE productos_digitales (
	id_producto_digital INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_producto INT NOT NULL,
    duracion_licencia DATETIME NOT NULL DEFAULT NOW(),
    codigo_acceso VARCHAR(32) NOT NULL DEFAULT ' ',
    
    FOREIGN KEY (id_producto) REFERENCES productos (id_producto) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE clientes (
	id_cliente INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    primer_nombre VARCHAR(32) NOT NULL DEFAULT ' ',
    segundo_nombre VARCHAR(32) DEFAULT ' ',
    apellido_paterno VARCHAR(32) NOT NULL DEFAULT ' ',
    apellido_materno VARCHAR(32) NOT NULL DEFAULT ' ',
    telefono VARCHAR(32) NOT NULL DEFAULT ' ',
    direccion VARCHAR(256) NOT NULL DEFAULT ' '
);

CREATE TABLE clientes_estandar (
	id_cliente_estandar INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    
    FOREIGN KEY (id_cliente) REFERENCES clientes (id_cliente) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE clientes_platino (
	id_cliente_platino INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    tipo_credito ENUM('AMPLIO', 'INTERMEDIO', 'REDUCIDO') NOT NULL DEFAULT 'REDUCIDO',
    limite FLOAT NOT NULL DEFAULT '0.0',
    
    CHECK (limite >= 0.0),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE pedidos (
	id_pedido INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    id_empleado INT NOT NULL, 
    fecha_pedido DATETIME NOT NULL DEFAULT NOW(),
    calle VARCHAR(32) NOT NULL DEFAULT ' ',
    num_ext VARCHAR(16) NOT NULL DEFAULT ' ',
    colonia VARCHAR(32) NOT NULL DEFAULT ' ',
    alcaldia VARCHAR(32) NOT NULL DEFAULT ' ',
    codigo_postal VARCHAR(32) NOT NULL DEFAULT ' ',
    
    FOREIGN KEY (id_empleado) REFERENCES empleados (id_empleado) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_cliente) REFERENCES clientes (id_cliente) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE detalle_pedido (
	id_producto INT NOT NULL,
    id_pedido INT NOT NULL,
    precio_unitario FLOAT NOT NULL DEFAULT 0.0,
    cantidad INT NOT NULL DEFAULT 1,
    
    CHECK (precio_unitario > 0.0),
    CHECK (cantidad >= 0),
    PRIMARY KEY (id_pedido, id_producto),
    FOREIGN KEY (id_producto) REFERENCES productos (id_producto) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_pedido) REFERENCES pedidos (id_pedido) ON DELETE RESTRICT ON UPDATE CASCADE
);


-- INSERCION DE DATOS EN LAS TABLAS EN ORDEN
INSERT INTO empleados (primer_nombre, segundo_nombre, apellido_paterno, apellido_materno, telefono, tipo) VALUES 
	('Carlos', 'Andrés', 'López', 'Martínez', '5512345678', 'CAJERO'),
	('María', 'Elena', 'Gómez', 'Ruiz', '5523456789', 'ALMACENISTA'),
	('José', 'Luis', 'Ramírez', 'Torres', '5534567890', 'CAJERO'),
	('Ana', 'Isabel', 'Hernández', 'Díaz', '5545678901', 'CAJERO'),
	('Roberto', 'Miguel', 'Sánchez', 'Flores', '5556789012', 'ALMACENISTA');

INSERT INTO proveedores (primer_nombre, segundo_nombre, apellido_paterno, apellido_materno, calle, num_ext, colonia, alcaldia, codigo_postal) VALUES
	('Jorge', 'Luis', 'Fernández', 'Pérez', 'Av. Central', '101', 'Centro', 'Cuauhtémoc', '06000'),
	('Lucía', 'María', 'García', 'Ramírez', 'Insurgentes', '55', 'Roma Norte', 'Cuauhtémoc', '06700'),
	('Pedro', 'Antonio', 'Martínez', 'Luna', 'Reforma', '230', 'Juárez', 'Cuauhtémoc', '06500'),
	('Carmen', 'Sofía', 'Ruiz', 'Ortega', 'Benito Juárez', '12', 'Del Valle', 'Benito Juárez', '03100'),
	('Luis', 'Felipe', 'Núñez', 'Gómez', 'Eje 8 Sur', '99', 'Narvarte', 'Benito Juárez', '03020');

INSERT INTO telefono_proveedor (id_proveedor, telefono) VALUES
	(1, '5543219876'),
	(2, '5556784321'),
	(3, '5511122233'),
	(4, '5522233344'),
	(5, '5533344455');

INSERT INTO contratos (id_proveedor, fecha_inicio, fecha_termino, monto_acordado) VALUES
	(1, '2024-01-01 00:00:00', '2025-01-01 00:00:00', 150000.00),
	(2, '2024-03-15 00:00:00', '2025-03-15 00:00:00', 95000.50),
	(3, '2023-10-01 00:00:00', '2024-10-01 00:00:00', 125000.75),
	(4, '2024-05-20 00:00:00', '2025-05-20 00:00:00', 180000.00),
	(5, '2024-07-01 00:00:00', '2025-07-01 00:00:00', 110000.00);

INSERT INTO productos (id_proveedor, marca, categoria, precio, stock) VALUES
	(1, 'Nintendo', 'Consola', 7999.99, 10),
	(2, 'Sony', 'Videojuego', 1599.50, 30),
	(3, 'Microsoft', 'Accesorio', 1299.00, 50),
	(4, 'Ubisoft', 'Videojuego', 999.90, 20),
	(5, 'EA Sports', 'Videojuego', 899.00, 40);

INSERT INTO productos_fisicos (id_producto, peso, codigo_almacen) VALUES
	(1, 2.5, 'A-001'),
	(2, 0.2, 'A-002'),
	(3, 0.5, 'A-003'),
	(4, 0.3, 'A-004'),
	(5, 0.25, 'A-005');

INSERT INTO productos_digitales (id_producto, duracion_licencia, codigo_acceso) VALUES
	(2, '2026-12-31 00:00:00', 'SONY-KEY-123'),
	(3, '2026-06-30 00:00:00', 'MICRO-KEY-456'),
	(4, '2025-12-31 00:00:00', 'UBI-KEY-789'),
	(5, '2025-10-21 00:00:00', 'EA-KEY-321'),
	(1, '2026-01-01 00:00:00', 'NINT-KEY-654');

INSERT INTO clientes (primer_nombre, segundo_nombre, apellido_paterno, apellido_materno, telefono, direccion) VALUES
	('Juan', 'Carlos', 'Ramírez', 'García', '5567890123', 'Av. Reforma 101, Juárez'),
	('Laura', 'María', 'Pérez', 'López', '5578901234', 'Insurgentes 220, Roma Norte'),
	('Miguel', 'Ángel', 'Hernández', 'Flores', '5589012345', 'Eje Central 500, Centro'),
	('Sofía', 'Isabel', 'Torres', 'Ruiz', '5590123456', 'Patriotismo 150, Escandón'),
	('Andrés', 'David', 'Gómez', 'Martínez', '5512345678', 'Mixcoac 88, San Pedro');

INSERT INTO clientes_estandar (id_cliente) VALUES 
	(1), (2), (3), (4), (5);
    
INSERT INTO clientes_platino (id_cliente, tipo_credito, limite) VALUES
	(1, 'AMPLIO', 50000.00),
	(2, 'INTERMEDIO', 25000.00),
	(3, 'REDUCIDO', 10000.00),
	(4, 'INTERMEDIO', 30000.00),
	(5, 'AMPLIO', 60000.00);

INSERT INTO pedidos (id_cliente, id_empleado, fecha_pedido, calle, num_ext, colonia, alcaldia, codigo_postal) VALUES
	(1, 1, '2025-10-01 10:00:00', 'Reforma', '120', 'Juárez', 'Cuauhtémoc', '06500'),
	(2, 2, '2025-10-02 11:30:00', 'Insurgentes', '45', 'Roma', 'Cuauhtémoc', '06700'),
	(3, 3, '2025-10-03 09:45:00', 'Eje Central', '500', 'Centro', 'Cuauhtémoc', '06000'),
	(4, 4, '2025-10-04 13:20:00', 'Patriotismo', '150', 'Escandón', 'Miguel Hidalgo', '11800'),
	(5, 5, '2025-10-05 15:10:00', 'Mixcoac', '88', 'San Pedro', 'Benito Juárez', '03900');

INSERT INTO detalle_pedido (id_producto, id_pedido, precio_unitario, cantidad) VALUES
	(1, 1, 7999.99, 1),
	(2, 1, 1599.50, 2),
	(3, 2, 1299.00, 1),
	(4, 3, 999.90, 3),
	(5, 4, 899.00, 2),
	(2, 5, 1599.50, 1);


-- PROYECCION DE LOS DATOS INSERTADOS
SELECT * FROM clientes;
SELECT * FROM clientes_estandar;
SELECT * FROM clientes_platino;
SELECT * FROM contratos;
SELECT * FROM detalle_pedido;
SELECT * FROM empleados;
SELECT * FROM pedidos;
SELECT * FROM productos;
SELECT * FROM productos_digitales;
SELECT * FROM productos_fisicos;
SELECT * FROM proveedores;
SELECT * FROM telefono_proveedor;


-- CREACION DE ROLES
DROP ROLE IF EXISTS 'rol_admin';
DROP ROLE IF EXISTS 'rol_proveedor';
DROP ROLE IF EXISTS 'rol_cajero';
DROP ROLE IF EXISTS 'rol_almacenista';
DROP ROLE IF EXISTS 'rol_cliente';

CREATE ROLE 'rol_admin';
CREATE ROLE 'rol_proveedor';
CREATE ROLE 'rol_almacenista';
CREATE ROLE 'rol_cajero';
CREATE ROLE 'rol_cliente';


-- ASIGNACION DE PERMISOS PARA CADA ROL
-- PERMISOS DE ADMINISRTRADOR
GRANT ALL PRIVILEGES ON tienda_de_videojuegos.* TO 'rol_admin';


-- PROVEEDOR
GRANT SELECT ON tienda_de_videojuegos.proveedores TO 'rol_proveedor';
GRANT UPDATE (calle, num_ext, colonia, alcaldia, codigo_postal) ON tienda_de_videojuegos.proveedores TO 'rol_proveedor';
GRANT SELECT, UPDATE (telefono) ON tienda_de_videojuegos.telefono_proveedor TO 'rol_proveedor';
GRANT SELECT ON tienda_de_videojuegos.contratos TO 'rol_proveedor';


-- PERMISOS DE ALMACENISTA
GRANT SELECT ON tienda_de_videojuegos.productos TO 'rol_almacenista';
GRANT INSERT, UPDATE (id_proveedor, marca, categoria, precio, stock) ON tienda_de_videojuegos.productos TO 'rol_almacenista';

GRANT SELECT ON tienda_de_videojuegos.productos_digitales TO 'rol_almacenista';
GRANT INSERT, UPDATE (id_producto, duracion_licencia, codigo_acceso) ON tienda_de_videojuegos.productos_digitales TO 'rol_almacenista';

GRANT SELECT ON tienda_de_videojuegos.productos_fisicos TO 'rol_almacenista';
GRANT INSERT, UPDATE (id_producto, peso, codigo_almacen) ON tienda_de_videojuegos.productos_fisicos TO 'rol_almacenista';


-- PERMISOS DE CAJERO
GRANT SELECT (id_cliente) ON tienda_de_videojuegos.clientes TO 'rol_cajero';
GRANT SELECT, INSERT, UPDATE (primer_nombre, segundo_nombre, apellido_paterno, apellido_materno, telefono, direccion) ON tienda_de_videojuegos.clientes TO 'rol_cajero';
GRANT SELECT, INSERT, UPDATE ON tienda_de_videojuegos.clientes_estandar TO 'rol_cajero';
GRANT SELECT, INSERT, UPDATE ON tienda_de_videojuegos.clientes_platino TO 'rol_cajero';

GRANT SELECT (id_pedido) ON tienda_de_videojuegos.pedidos TO 'rol_cajero';
GRANT SELECT, INSERT, UPDATE (id_cliente, id_empleado, calle, num_ext, colonia, alcaldia, codigo_postal) ON tienda_de_videojuegos.pedidos TO 'rol_cajero';

GRANT SELECT (id_producto, id_pedido) ON tienda_de_videojuegos.detalle_pedido TO 'rol_cajero';
GRANT SELECT, INSERT, UPDATE (cantidad) ON tienda_de_videojuegos.detalle_pedido TO 'rol_cajero';

GRANT SELECT (id_producto) ON tienda_de_videojuegos.productos TO 'rol_cajero';
GRANT UPDATE (stock) ON tienda_de_videojuegos.productos TO 'rol_cajero';

GRANT SELECT ON tienda_de_videojuegos.productos_digitales TO 'rol_cajero';
GRANT SELECT ON tienda_de_videojuegos.productos_fisicos TO 'rol_cajero';


-- PERMISOS DE CLIENTE
GRANT SELECT (id_cliente) ON tienda_de_videojuegos.clientes TO 'rol_cliente';
GRANT SELECT, UPDATE (primer_nombre, segundo_nombre, apellido_paterno, apellido_materno, telefono, direccion) ON tienda_de_videojuegos.clientes TO 'rol_cliente';

GRANT SELECT ON tienda_de_videojuegos.detalle_pedido TO 'rol_cliente';

GRANT SELECT (id_pedido, id_cliente) ON tienda_de_videojuegos.pedidos TO 'rol_cliente';
GRANT UPDATE (calle, num_ext, colonia, alcaldia, codigo_postal) ON tienda_de_videojuegos.pedidos TO 'rol_cliente';


-- CREACION DE USUARIOS
DROP USER IF EXISTS 'admin'@'localhost';
DROP USER IF EXISTS 'proveedor'@'localhost';
DROP USER IF EXISTS 'almacenista'@'localhost';
DROP USER IF EXISTS 'cajero'@'localhost';
DROP USER IF EXISTS 'cliente'@'localhost';

CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin123';
CREATE USER 'proveedor'@'localhost' IDENTIFIED BY 'proveedor123';
CREATE USER 'almacenista'@'localhost' IDENTIFIED BY 'almacenista123';
CREATE USER 'cajero'@'localhost' IDENTIFIED BY 'cajero123';
CREATE USER 'cliente'@'localhost' IDENTIFIED BY 'cliente123';

GRANT 'rol_admin' TO 'admin'@'localhost';
GRANT 'rol_proveedor' TO 'proveedor'@'localhost';
GRANT 'rol_almacenista' TO 'almacenista'@'localhost';
GRANT 'rol_cajero' TO 'cajero'@'localhost';
GRANT 'rol_cliente' TO 'cliente'@'localhost';


