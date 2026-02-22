CREATE DATABASE IF NOT EXISTS ci4 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ci4;

CREATE USER IF NOT EXISTS 'ci4'@'localhost' IDENTIFIED BY 'ci4';
GRANT ALL PRIVILEGES ON ci4.* TO 'ci4'@'localhost';
FLUSH PRIVILEGES;

DROP TABLE IF EXISTS alumnos;
DROP TABLE IF EXISTS carrera;

CREATE TABLE carrera (
  codigo_carrera VARCHAR(50) PRIMARY KEY,
  nombre_carrera VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO carrera (codigo_carrera, nombre_carrera) VALUES
  ('INF', 'Ingeniería en Informática'),
  ('SIS', 'Ingeniería en Sistemas'),
  ('ADM', 'Administración');

CREATE TABLE alumnos (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codigo        VARCHAR(50)  NOT NULL,
  nombres       VARCHAR(100) NOT NULL,
  apellidos     VARCHAR(100) NOT NULL,
  telefono      VARCHAR(30)  NOT NULL,
  codigo_carrera VARCHAR(50)  NULL,
  UNIQUE KEY uq_alumnos_codigo (codigo),
  KEY fk_alumnos_carrera (codigo_carrera),
  CONSTRAINT fk_alumnos_carrera FOREIGN KEY (codigo_carrera) REFERENCES carrera (codigo_carrera) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
