SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE table auditoria_logs;

TRUNCATE table caja_cab;
TRUNCATE table caja_det;

TRUNCATE table ci_sessions;

TRUNCATE table clientes;
TRUNCATE table clientes_tipo;

TRUNCATE table grupo;
TRUNCATE table grupo_acciones;
TRUNCATE table grupo_permisos;
TRUNCATE table grupo_usuarios;
TRUNCATE table menu;

TRUNCATE table moneda;

TRUNCATE table pago_cliente;
TRUNCATE table pago_cliente_detalle;
TRUNCATE table pago_forma;

TRUNCATE table planes;
TRUNCATE table planes_categoria;
TRUNCATE table planes_clientes;
TRUNCATE table planes_rango_edad;
TRUNCATE table planes_vigencia;

TRUNCATE table sucursal;

TRUNCATE table usuarios;
SET FOREIGN_KEY_CHECKS = 1;
