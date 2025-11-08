CREATE TABLE usuarios (
	id_usuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(64) NOT NULL,
    correo_usuario VARCHAR(64) UNIQUE,
    contrasena_usuario VARCHAR(64) NOT NULL
);