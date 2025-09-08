-- Crea la base y usa el esquema
CREATE DATABASE IF NOT EXISTS pizzeria_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pizzeria_db;

-- Tabla clientes
-- Datos básicos de los clientes
CREATE TABLE clientes (
  id_cliente INT AUTO_INCREMENT PRIMARY KEY,
  nombre_apellido VARCHAR(100) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  direccion VARCHAR(150) NOT NULL,
  email VARCHAR(120),
  barrio VARCHAR(60)
);

-- Tabla pizzas
-- Catálogo de pizzas
CREATE TABLE pizzas (
  id_pizza INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  tamanio ENUM('personal','mediana','grande','familiar') NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  es_vegana BOOLEAN NOT NULL DEFAULT FALSE,
  disponible BOOLEAN NOT NULL DEFAULT TRUE
);

-- Tabla pedidos
-- Encabezado del pedido
CREATE TABLE pedidos (
  id_pedido INT AUTO_INCREMENT PRIMARY KEY,
  id_cliente INT NOT NULL,
  fecha_hora DATETIME NOT NULL,
  estado ENUM('pendiente','en_preparacion','en_reparto','entregado','cancelado') NOT NULL,
  metodo_pago ENUM('efectivo','debito','credito','transferencia','qr') NOT NULL,
  direccion_entrega VARCHAR(150) NOT NULL,
  observaciones VARCHAR(200),
  FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

-- Tabla pedido_detalle
-- Items del pedido
CREATE TABLE pedido_detalle (
  id_detalle INT AUTO_INCREMENT PRIMARY KEY,
  id_pedido INT NOT NULL,
  id_pizza INT NOT NULL,
  cantidad INT NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
  FOREIGN KEY (id_pizza) REFERENCES pizzas(id_pizza)
);

-- Datos de ejemplo
-- Clientes
INSERT INTO clientes (nombre_apellido, telefono, direccion, email, barrio) VALUES
('Juan Pérez', '099111111', 'Calle 1 #123', 'juan@example.com', 'Centro'),
('Ana Gómez', '098222222', 'Calle 2 #456', 'ana@example.com', 'Sur');

-- Pizzas
INSERT INTO pizzas (nombre, tamanio, precio, es_vegana, disponible) VALUES
('Muzzarella', 'grande', 320.00, FALSE, TRUE),
('Napolitana', 'grande', 380.00, FALSE, TRUE),
('Vegana Especial', 'mediana', 420.00, TRUE, TRUE);

-- Pedido 1 (Juan)
INSERT INTO pedidos (id_cliente, fecha_hora, estado, metodo_pago, direccion_entrega, observaciones)
VALUES (1, NOW(), 'entregado', 'efectivo', 'Calle 1 #123', 'sin cebolla');
INSERT INTO pedido_detalle (id_pedido, id_pizza, cantidad, precio_unitario, subtotal) VALUES
(LAST_INSERT_ID(), 1, 2, 320.00, 640.00);

-- Pedido 2 (Ana)
INSERT INTO pedidos (id_cliente, fecha_hora, estado, metodo_pago, direccion_entrega, observaciones)
VALUES (2, NOW(), 'en_preparacion', 'qr', 'Calle 2 #456', 'timbre roto');
INSERT INTO pedido_detalle (id_pedido, id_pizza, cantidad, precio_unitario, subtotal) VALUES
(LAST_INSERT_ID(), 3, 1, 420.00, 420.00);
