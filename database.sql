CREATE DATABASE IF NOT EXISTS alertas_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE alertas_db;
DROP TABLE IF EXISTS alertas;
CREATE TABLE alertas (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(120) NOT NULL,
  tipo ENUM('tormenta','inundacion','ola_calor','vientos_fuertes') NOT NULL,
  fecha DATE NOT NULL,
  descripcion TEXT NOT NULL
);
