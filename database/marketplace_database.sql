-- ========================================
-- MARKETPLACE DATABASE SQL SCRIPT
-- ========================================
-- Created: June 24, 2025
-- Laravel Backend Marketplace Database Structure
-- ========================================

-- Drop database if exists and create new one
DROP DATABASE IF EXISTS marketplace_db;
CREATE DATABASE marketplace_db;
USE marketplace_db;

-- ========================================
-- TABLE: categorias
-- ========================================
CREATE TABLE `categorias` (
    `id_categoria` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre_categoria` varchar(100) NOT NULL,
    `descripcion` text DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_categoria`)
);

-- ========================================
-- TABLE: productos
-- ========================================
CREATE TABLE `productos` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` varchar(255) NOT NULL,
    `image_path` varchar(255) DEFAULT NULL,
    `descripcion` text DEFAULT NULL,
    `precio` decimal(8,2) NOT NULL,
    `archivo` varchar(255) DEFAULT NULL,
    `id_categoria` bigint(20) UNSIGNED NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `productos_id_categoria_foreign` (`id_categoria`),
    CONSTRAINT `productos_id_categoria_foreign` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE
);

-- ========================================
-- TABLE: usuarios
-- ========================================
CREATE TABLE `usuarios` (
    `id_usuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL,
    `apellidos` varchar(100) NOT NULL,
    `correo` varchar(100) NOT NULL,
    `contrasena` varchar(255) NOT NULL,
    `rol` enum('cliente','admin') NOT NULL DEFAULT 'cliente',
    `creado_en` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_usuario`),
    UNIQUE KEY `usuarios_correo_unique` (`correo`)
);

-- ========================================
-- TABLE: ventas
-- ========================================
CREATE TABLE `ventas` (
    `id_venta` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_usuario` bigint(20) UNSIGNED NOT NULL,
    `total` decimal(10,2) NOT NULL,
    `fecha_venta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_venta`),
    KEY `ventas_id_usuario_foreign` (`id_usuario`),
    CONSTRAINT `ventas_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
);

-- ========================================
-- TABLE: venta_productos
-- ========================================
CREATE TABLE `venta_productos` (
    `id_venta_producto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_venta` bigint(20) UNSIGNED NOT NULL,
    `id` bigint(20) UNSIGNED NOT NULL,
    `precio_unitario` decimal(10,2) NOT NULL,
    `cantidad` int(11) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id_venta_producto`),
    UNIQUE KEY `venta_productos_id_venta_id_unique` (`id_venta`,`id`),
    KEY `venta_productos_id_venta_foreign` (`id_venta`),
    KEY `venta_productos_id_foreign` (`id`),
    CONSTRAINT `venta_productos_id_foreign` FOREIGN KEY (`id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
    CONSTRAINT `venta_productos_id_venta_foreign` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE
);

-- ========================================
-- LARAVEL SYSTEM TABLES
-- ========================================

-- TABLE: users (Laravel default users table)
CREATE TABLE `users` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) NOT NULL,
    `remember_token` varchar(100) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
);

-- TABLE: cache (Laravel cache table)
CREATE TABLE `cache` (
    `key` varchar(255) NOT NULL,
    `value` mediumtext NOT NULL,
    `expiration` int(11) NOT NULL,
    PRIMARY KEY (`key`)
);

-- TABLE: cache_locks (Laravel cache locks table)
CREATE TABLE `cache_locks` (
    `key` varchar(255) NOT NULL,
    `owner` varchar(255) NOT NULL,
    `expiration` int(11) NOT NULL,
    PRIMARY KEY (`key`)
);

-- TABLE: jobs (Laravel jobs queue table)
CREATE TABLE `jobs` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` varchar(255) NOT NULL,
    `payload` longtext NOT NULL,
    `attempts` tinyint(3) UNSIGNED NOT NULL,
    `reserved_at` int(10) UNSIGNED DEFAULT NULL,
    `available_at` int(10) UNSIGNED NOT NULL,
    `created_at` int(10) UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    KEY `jobs_queue_index` (`queue`)
);

-- TABLE: job_batches (Laravel job batches table)
CREATE TABLE `job_batches` (
    `id` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `total_jobs` int(11) NOT NULL,
    `pending_jobs` int(11) NOT NULL,
    `failed_jobs` int(11) NOT NULL,
    `failed_job_ids` longtext NOT NULL,
    `options` mediumtext DEFAULT NULL,
    `cancelled_at` int(10) UNSIGNED DEFAULT NULL,
    `created_at` int(10) UNSIGNED NOT NULL,
    `finished_at` int(10) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`)
);

-- TABLE: failed_jobs (Laravel failed jobs table)
CREATE TABLE `failed_jobs` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` varchar(255) NOT NULL,
    `connection` text NOT NULL,
    `queue` text NOT NULL,
    `payload` longtext NOT NULL,
    `exception` longtext NOT NULL,
    `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
);

-- ========================================
-- SAMPLE DATA INSERTION
-- ========================================

-- Insert sample categories
INSERT INTO `categorias` (`nombre_categoria`, `descripcion`, `created_at`, `updated_at`) VALUES
('Programación Web', NULL, NOW(), NOW()),
('Desarrollo de Software', NULL, NOW(), NOW()),
('Ciberseguridad', NULL, NOW(), NOW()),
('Inteligencia Artificial', NULL, NOW(), NOW()),
('Bases de Datos', NULL, NOW(), NOW()),
('Desarrollo Móvil', NULL, NOW(), NOW()),
('Ofimática y Productividad', NULL, NOW(), NOW());

-- Insert admin user
INSERT INTO `usuarios` (`nombre`, `apellidos`, `correo`, `contrasena`, `rol`, `creado_en`) VALUES
('Samuel', 'Flores', 'ramondino@gmail.com', '2003', 'admin', NOW());

-- Insert sample client user
INSERT INTO `usuarios` (`nombre`, `apellidos`, `correo`, `contrasena`, `rol`, `creado_en`) VALUES
('María', 'González', 'maria.gonzalez@example.com', 'password123', 'cliente', NOW()),
('Juan', 'Pérez', 'juan.perez@example.com', 'password456', 'cliente', NOW());

-- Insert sample products
INSERT INTO `productos` (`nombre`, `image_path`, `descripcion`, `precio`, `archivo`, `id_categoria`, `created_at`, `updated_at`) VALUES
('Curso de Laravel', '/img/curso-laravel.jpg', 'Curso completo de desarrollo con Laravel framework', 49.99, 'curso-laravel.zip', 1, NOW(), NOW()),
('Curso de React', '/img/curso-react.jpg', 'Aprende React desde cero hasta nivel avanzado', 39.99, 'curso-react.zip', 1, NOW(), NOW()),
('Manual de Seguridad Web', '/img/manual-seguridad.jpg', 'Guía completa de seguridad en aplicaciones web', 29.99, 'manual-seguridad.pdf', 3, NOW(), NOW()),
('Curso de Python', '/img/curso-python.jpg', 'Programación en Python para principiantes', 34.99, 'curso-python.zip', 2, NOW(), NOW()),
('Base de Datos MySQL', '/img/curso-mysql.jpg', 'Administración y diseño de bases de datos MySQL', 44.99, 'curso-mysql.zip', 5, NOW(), NOW()),
('Desarrollo de Apps móviles', '/img/curso-movil.jpg', 'Crear aplicaciones móviles con React Native', 54.99, 'curso-movil.zip', 6, NOW(), NOW()),
('Curso de IA con Python', '/img/curso-ia.jpg', 'Introducción a la Inteligencia Artificial', 69.99, 'curso-ia.zip', 4, NOW(), NOW()),
('Office 365 Completo', '/img/curso-office.jpg', 'Domina todas las herramientas de Office 365', 24.99, 'curso-office.zip', 7, NOW(), NOW());

-- Insert sample sales
INSERT INTO `ventas` (`id_usuario`, `total`, `fecha_venta`) VALUES
(2, 89.98, NOW() - INTERVAL 5 DAY),
(3, 49.99, NOW() - INTERVAL 3 DAY),
(2, 74.98, NOW() - INTERVAL 1 DAY);

-- Insert sample sale products
INSERT INTO `venta_productos` (`id_venta`, `id`, `precio_unitario`, `cantidad`, `created_at`, `updated_at`) VALUES
(1, 1, 49.99, 1, NOW(), NOW()),
(1, 2, 39.99, 1, NOW(), NOW()),
(2, 1, 49.99, 1, NOW(), NOW()),
(3, 4, 34.99, 1, NOW(), NOW()),
(3, 2, 39.99, 1, NOW(), NOW());

-- ========================================
-- INDEXES FOR PERFORMANCE OPTIMIZATION
-- ========================================

-- Additional indexes for better performance
CREATE INDEX idx_productos_precio ON productos(precio);
CREATE INDEX idx_productos_categoria ON productos(id_categoria);
CREATE INDEX idx_ventas_fecha ON ventas(fecha_venta);
CREATE INDEX idx_ventas_usuario ON ventas(id_usuario);
CREATE INDEX idx_usuarios_rol ON usuarios(rol);
CREATE INDEX idx_usuarios_correo ON usuarios(correo);

-- ========================================
-- VIEWS FOR COMMON QUERIES
-- ========================================

-- View for product details with category
CREATE VIEW vista_productos_completos AS
SELECT 
    p.id,
    p.nombre,
    p.image_path,
    p.descripcion,
    p.precio,
    p.archivo,
    c.nombre_categoria,
    c.descripcion as categoria_descripcion,
    p.created_at,
    p.updated_at
FROM productos p
INNER JOIN categorias c ON p.id_categoria = c.id_categoria;

-- View for sales summary
CREATE VIEW vista_ventas_resumen AS
SELECT 
    v.id_venta,
    u.nombre,
    u.apellidos,
    u.correo,
    v.total,
    v.fecha_venta,
    COUNT(vp.id_venta_producto) as total_productos
FROM ventas v
INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
LEFT JOIN venta_productos vp ON v.id_venta = vp.id_venta
GROUP BY v.id_venta, u.nombre, u.apellidos, u.correo, v.total, v.fecha_venta;

-- View for sales details
CREATE VIEW vista_detalle_ventas AS
SELECT 
    v.id_venta,
    u.nombre as cliente_nombre,
    u.apellidos as cliente_apellidos,
    u.correo as cliente_correo,
    p.nombre as producto_nombre,
    vp.precio_unitario,
    vp.cantidad,
    (vp.precio_unitario * vp.cantidad) as subtotal,
    v.fecha_venta
FROM ventas v
INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
INNER JOIN venta_productos vp ON v.id_venta = vp.id_venta
INNER JOIN productos p ON vp.id = p.id;

-- ========================================
-- STORED PROCEDURES
-- ========================================

DELIMITER //

-- Procedure to get sales statistics
CREATE PROCEDURE GetSalesStatistics()
BEGIN
    SELECT 
        COUNT(*) as total_ventas,
        SUM(total) as ingresos_totales,
        AVG(total) as promedio_venta,
        MAX(total) as venta_maxima,
        MIN(total) as venta_minima
    FROM ventas;
END //

-- Procedure to get top selling products
CREATE PROCEDURE GetTopSellingProducts(IN limite INT)
BEGIN
    SELECT 
        p.nombre,
        COUNT(vp.id) as total_vendidos,
        SUM(vp.precio_unitario * vp.cantidad) as ingresos_producto
    FROM productos p
    INNER JOIN venta_productos vp ON p.id = vp.id
    GROUP BY p.id, p.nombre
    ORDER BY total_vendidos DESC
    LIMIT limite;
END //

-- Procedure to get customer purchase history
CREATE PROCEDURE GetCustomerPurchaseHistory(IN customer_id INT)
BEGIN
    SELECT 
        v.id_venta,
        v.total,
        v.fecha_venta,
        p.nombre as producto,
        vp.precio_unitario,
        vp.cantidad
    FROM ventas v
    INNER JOIN venta_productos vp ON v.id_venta = vp.id_venta
    INNER JOIN productos p ON vp.id = p.id
    WHERE v.id_usuario = customer_id
    ORDER BY v.fecha_venta DESC;
END //

DELIMITER ;

-- ========================================
-- TRIGGERS
-- ========================================

DELIMITER //

-- Trigger to update sale total when products are added/modified
CREATE TRIGGER tr_actualizar_total_venta
AFTER INSERT ON venta_productos
FOR EACH ROW
BEGIN
    UPDATE ventas 
    SET total = (
        SELECT SUM(precio_unitario * cantidad) 
        FROM venta_productos 
        WHERE id_venta = NEW.id_venta
    )
    WHERE id_venta = NEW.id_venta;
END //

-- Trigger to update sale total when products are updated
CREATE TRIGGER tr_actualizar_total_venta_update
AFTER UPDATE ON venta_productos
FOR EACH ROW
BEGIN
    UPDATE ventas 
    SET total = (
        SELECT SUM(precio_unitario * cantidad) 
        FROM venta_productos 
        WHERE id_venta = NEW.id_venta
    )
    WHERE id_venta = NEW.id_venta;
END //

-- Trigger to update sale total when products are deleted
CREATE TRIGGER tr_actualizar_total_venta_delete
AFTER DELETE ON venta_productos
FOR EACH ROW
BEGIN
    UPDATE ventas 
    SET total = (
        SELECT IFNULL(SUM(precio_unitario * cantidad), 0) 
        FROM venta_productos 
        WHERE id_venta = OLD.id_venta
    )
    WHERE id_venta = OLD.id_venta;
END //

DELIMITER ;

-- ========================================
-- FINAL STATISTICS QUERY
-- ========================================

-- Show database statistics
SELECT 'Database Statistics' as info;
SELECT 'Total Categories' as metric, COUNT(*) as value FROM categorias
UNION ALL
SELECT 'Total Products', COUNT(*) FROM productos
UNION ALL
SELECT 'Total Users', COUNT(*) FROM usuarios
UNION ALL
SELECT 'Total Sales', COUNT(*) FROM ventas
UNION ALL
SELECT 'Total Revenue', CONCAT('$', FORMAT(SUM(total), 2)) FROM ventas;

-- ========================================
-- END OF SCRIPT
-- ========================================

-- Script completed successfully
-- Database: marketplace_db
-- Tables created: 10 (5 main + 5 Laravel system tables)
-- Views created: 3
-- Stored Procedures: 3
-- Triggers: 3
-- Sample data inserted for testing
-- ========================================
