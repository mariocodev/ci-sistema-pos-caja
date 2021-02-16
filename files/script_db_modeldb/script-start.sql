-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: monteoli_saf_db
-- ------------------------------------------------------
-- Server version	5.7.14
use `adminbase_db`;
INSERT INTO `usuarios` (`usuario_nombre`, `usuario_apellido`, `usuario_user`, `usuario_pass`, `usuario_estado`, `usuario_dateinsert`, `usuario_dateupdate`) 
VALUES ('Miroslav', 'Valsorim', 'superadmin', 'e10adc3949ba59abbe56e057f20f883e', 'activo', NOW(), NOW()),
('Administrador', 'Sistema', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'activo', NOW(), NOW());
-- Menú
INSERT INTO `menu` (`menu_nivel`, `menu_nombre`, `menu_id_padre`, `menu_icono`, `menu_controlador`) 
VALUES ('1', 'Configuración', NULL, 'fa fa-cogs', NULL), 
('2', 'Menú', '1', NULL, 'menu'), 
('2', 'Mantenimiento sistema', '1', NULL, 'mantenimiento_sistema'), 
('1', 'Mantenimiento', NULL, 'fa fa-database', NULL), 
('2', 'Usuarios', '4', NULL, 'usuarios'), ('2', 'Clientes', '4', NULL, 'clientes'), ('2', 'Planes', '4', NULL, 'planes'), 
('1', 'Transacciones', NULL, 'fa fa-money', NULL),('2', 'Pagos', '8', NULL, 'pagos');
-- Grupo
INSERT INTO `grupo` (`grupo_nombre`, `grupo_dateinsert`) VALUES ('Super Administrador', NOW()), 
('Administrador', NOW());
INSERT INTO `grupo_acciones` (`grupo_acciones_nombre`) VALUES ('Crear'),('Editar'),('Eliminar'),('Visualizar');
INSERT INTO `grupo_permisos` (`grupo_id`, `menu_id`, `grupo_acciones_id`) VALUES ('1', '2', '1'), ('1', '3', '1'), ('1', '5', '1'), 
('1', '6', '1'), ('1', '7', '1'), ('1', '9', '1'), ('2', '5', '1'), 
('2', '6', '1'), ('2', '7', '1'), ('2', '9', '1');
INSERT INTO `grupo_usuarios` (`usuario_id`, `grupo_id`) VALUES ('1', '1'), ('2', '2');
-- Clientes
INSERT INTO `clientes_tipo` (`cliente_tipo_nombre`) VALUES ('Titular'), ('Adherente');
-- Planes
INSERT INTO `planes_vigencia` (`plan_vigencia_nombre`, `plan_vigencia_dias`) VALUES ('Inmediata', '0'), ('30 días', '30'), 
('35 días', '35'), ('9 meses', '270'), ('12 meses', '365'), ('18 meses', '540'), ('24 meses', '720'), ('No aplica', '0');
INSERT INTO `planes_rango_edad` (`plan_rango_edad_nombre`, `planes_rango_limite_inferior`, `planes_rango_limite_superior`, `plan_vigencia_id`)
VALUES ('0 a 59 años', '0', '59', '4'), ('60 a 70 años', '60', '70', '5'), ('71 a 85 años', '71', '85', '6'), ('86 a 92 años', '86', '92', '7');
INSERT INTO `planes_categoria` (`plan_categoria_nombre`) VALUES ('Platino'), ('Oro'), ('Plata');
INSERT INTO `planes` (`plan_rango_edad_id`, `plan_categoria_id`, `planes_costo`) VALUES ('1', '1', '20000'),
('1', '2', '15000'), ('1', '3', '12000'), ('2', '1', '30000'), ('2', '2', '25000'), ('2', '3', '22000'), ('3', '1', '40000'),
('3', '2', '35000'), ('3', '3', '32000'), ('4', '1', '60000'), ('4', '2', '50000'), ('4', '3', '45000');
-- TIPO TARJETA
INSERT INTO `pago_forma` (`pago_forma_descripcion`, `pago_forma_tipo`, `pago_forma_alias`) VALUES ('Efectivo', NULL, 'EFE');
INSERT INTO `pago_forma` (`pago_forma_descripcion`, `pago_forma_tipo`, `pago_forma_alias`) VALUES ('T. Débito', NULL, 'TDE');
INSERT INTO `pago_forma` (`pago_forma_descripcion`, `pago_forma_tipo`, `pago_forma_alias`) VALUES ('T Crédito', NULL, 'TCR');
INSERT INTO `pago_forma` (`pago_forma_descripcion`, `pago_forma_tipo`, `pago_forma_alias`) VALUES ('Efectivo + T. Débido', NULL, 'EFE + TDE');
INSERT INTO `pago_forma` (`pago_forma_descripcion`, `pago_forma_tipo`, `pago_forma_alias`) VALUES ('Efectivo + T. Crédito', NULL, 'EFE + TCR');
INSERT INTO `pago_forma` (`pago_forma_descripcion`, `pago_forma_tipo`, `pago_forma_alias`) VALUES ('T. Débido + T. Crédito', NULL, 'TDE + TCR');
INSERT INTO `pago_forma` (`pago_forma_descripcion`, `pago_forma_tipo`, `pago_forma_alias`) VALUES ('Cheque', NULL, 'CHE');