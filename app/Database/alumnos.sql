CREATE DATABASE IF NOT EXISTS ci4 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ci4;

CREATE USER IF NOT EXISTS 'ci4'@'localhost' IDENTIFIED BY 'ci4';
GRANT ALL PRIVILEGES ON ci4.* TO 'ci4'@'localhost';
FLUSH PRIVILEGES;

DROP TABLE IF EXISTS matricula;
DROP TABLE IF EXISTS horarios;
DROP TABLE IF EXISTS materias;
DROP TABLE IF EXISTS docentes;
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

CREATE TABLE docentes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombres   VARCHAR(100) NOT NULL,
  apellidos VARCHAR(100) NOT NULL,
  email     VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE materias (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre_materia VARCHAR(150) NOT NULL,
  descripcion    TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE horarios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_docente INT UNSIGNED NOT NULL,
  id_materia INT UNSIGNED NOT NULL,
  dia_1      VARCHAR(20) NOT NULL,
  dia_2      VARCHAR(20) DEFAULT NULL,
  hora_inicio TIME NOT NULL,
  hora_fin    TIME NOT NULL,
  KEY fk_horarios_docente (id_docente),
  KEY fk_horarios_materia (id_materia),
  CONSTRAINT fk_horarios_docente FOREIGN KEY (id_docente) REFERENCES docentes (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_horarios_materia FOREIGN KEY (id_materia) REFERENCES materias (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE matricula (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_alumno  INT UNSIGNED NOT NULL,
  id_materia INT UNSIGNED NOT NULL,
  UNIQUE KEY uq_matricula_alumno_materia (id_alumno, id_materia),
  KEY fk_matricula_alumno (id_alumno),
  KEY fk_matricula_materia (id_materia),
  CONSTRAINT fk_matricula_alumno FOREIGN KEY (id_alumno) REFERENCES alumnos (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_matricula_materia FOREIGN KEY (id_materia) REFERENCES materias (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
