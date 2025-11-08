CREATE DATABASE tienda;

USE tienda;

CREATE TABLE clientes (
	id_cliente INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(50),
	apellido VARCHAR(50),
	email VARCHAR(50),
	telefono VARCHAR(20),
	fecha_registro DATE
);

CREATE TABLE ventas (
	id_venta INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_cliente_venta INT NOT NULL,
    monto_total FLOAT NOT NULL,
    fecha_venta DATE NOT NULL,
    FOREIGN KEY (id_cliente_venta) REFERENCES clientes (id_cliente)
);

CREATE TABLE productos (
	id_venta_productos INT NOT NULL,
    id_almacen_productos INT NOT NULL, 
	cantidad INT NOT NULL,
    precio FLOAT NOT NULL,
    subtotal FLOAT NOT NULL,
    FOREIGN KEY (id_venta_productos) REFERENCES ventas (id_venta),
    FOREIGN KEY (id_almacen_productos) REFERENCES almacen (id_almacen)
);

CREATE TABLE almacen (
	id_almacen INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(128) NOT NULL,
    descripcion VARCHAR(512) NOT NULL,
    precio FLOAT NOT NULL,
    existencia INT NOT NULL
);

