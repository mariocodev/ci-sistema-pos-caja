<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Pagos_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	/**
	*  Tablas a utilizar
	*  @author: Mario Amarilla
    *  @version: 28/08/2018/A
	*/
	var $t1 = 'clientes';    
	var $t2 = 'clientes_tipo';    
	var $t3 = 'planes';    
	var $t4 = 'planes_rango_edad';    
	var $t5 = 'planes_categoria';    
	var $t6 = 'planes_clientes';    
	var $t7 = 'pago_cliente';    
	var $t8 = 'pago_cliente_detalle';    
	var $t9 = 'usuarios';    
	var $t10 = 'pago_forma';    
	
	/**
    *   Configuraciones de DATATABLE
    *   Tabla:  usuarios
    */
    function make_query()
    {
        $this->db->select("t1.pago_cliente_id, concat(t2.cliente_nombre,' ', t2.cliente_apellido) cliente, DATE_FORMAT(t1.pago_cliente_dateinsert, '%d-%m-%Y %H:%i') pago_cliente_fecha, concat(t3.usuario_nombre,' ', t3.usuario_apellido) cobrador, FORMAT(t1.pago_cliente_monto_plan, 0, 'de_DE') pago_cliente_monto_plan, FORMAT(t1.pago_cliente_monto_total, 0, 'de_DE') pago_cliente_monto_total, pago_cliente_estado");
        $this->db->from($this->t7.' t1');
        $this->db->join($this->t1.' t2', 't1.cliente_id = t2.cliente_id', 'left');
        $this->db->join($this->t9.' t3', 't3.usuario_id = t1.usuario_id', 'left');
        $this->db->order_by('t1.pago_cliente_id', 'desc');
        
        if (isset($_POST["search"]["value"])) {
            $this->db->like("pago_cliente_id", $_POST["search"]["value"]);
            $this->db->or_like("concat(t2.cliente_nombre,' ', t2.cliente_apellido)", $_POST["search"]["value"]);
            $this->db->or_like("concat(t3.usuario_nombre,' ', t3.usuario_apellido)", $_POST["search"]["value"]);
            $this->db->or_like("t1.pago_cliente_fecha", $_POST["search"]["value"]);
            //$this->db->or_where_in("cliente_id", 3);
        }        
    }
     
    function make_datatables()
    {
        $this->make_query();
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        
        if ($length != -1) {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->t7);
        return $this->db->count_all_results();
    }
    /**
    *   Configuraciones de DATATABLE datatableFacturaDetalle
    *   Tabla:  usuarios
    */
    function make_query_datatableFacturaDetalle($cliente_id)
    {
        $this->db->select("t1.cliente_id, CONCAT(t1.cliente_nombre,' ',t1.cliente_apellido) cliente, CASE WHEN (YEAR(CURDATE()) - YEAR(t1.cliente_fecha_nacimiento)) = YEAR(CURDATE()) THEN 'ND' ELSE YEAR(CURDATE()) - YEAR(t1.cliente_fecha_nacimiento) END edad, CASE WHEN (YEAR(CURDATE()) - YEAR(t1.cliente_fecha_nacimiento)) = YEAR(CURDATE()) THEN t5.plan_categoria_nombre ELSE CONCAT(t5.plan_categoria_nombre, ' (', `t6`.`plan_rango_edad_nombre`, ')') END plan, case when t3.planes_clientes_modificar_monto = 'si' then t3.planes_clientes_monto else t4.planes_costo end plan_monto");
        $this->db->from($this->t1.' t1');
        $this->db->join($this->t2.' t2', 't1.cliente_tipo_id = t2.cliente_tipo_id', 'right');
        $this->db->join($this->t6.' t3', 't1.cliente_id = t3.cliente_id and t3.planes_clientes_estado = "activo"', 'left');
        $this->db->join($this->t3.' t4', 't3.plan_id = t4.plan_id', 'left');
        $this->db->join($this->t5.' t5', 't5.plan_categoria_id = t4.plan_categoria_id', 'left');
        $this->db->join($this->t4.' t6', 't4.plan_rango_edad_id = t6.plan_rango_edad_id', 'left');
        
        if (isset($_POST["search"]["value"])) {
            $this->db->group_start();
            $this->db->like("cliente_nombre", $_POST["search"]["value"]);
            $this->db->or_like("cliente_apellido", $_POST["search"]["value"]);
            $this->db->or_like("cliente_ci", $_POST["search"]["value"]);
            $this->db->or_like("cliente_cel", $_POST["search"]["value"]);
            $this->db->group_end();           
        }
        $this->db->where('t1.cliente_id_padre', $cliente_id);
        $this->db->where('t1.cliente_estado <>', 'borrado');
        $this->db->or_where('t1.cliente_id', $cliente_id);
        $this->db->order_by('t1.cliente_tipo_id', 'asc');
    }
     
    function make_datatableFacturaDetalle($cliente_id)
    {
        $this->make_query_datatableFacturaDetalle($cliente_id);
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        
        if ($length != -1) {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function get_filtered_data_datatableFacturaDetalle($cliente_id)
    {
        $this->make_query_datatableFacturaDetalle($cliente_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_all_data_datatableFacturaDetalle($cliente_id)
    {
        $this->db->select("*");
        $this->db->from($this->t1);
        $this->db->where('cliente_id_padre', $cliente_id);
        //$this->db->or_where('cliente_id', $cliente_id);
        return $this->db->count_all_results();
    }
    /*****
	*
	*	ABM
	*
	*/
	public function agregar_cabecera($data){
        $this->db->insert($this->t7, $data);
        return $this->db->insert_id();
    }
    public function agregar_detalle($data){
        $this->db->insert($this->t8, $data);
        return $this->db->insert_id();
    }
    // Recupero los datos
    public function obtener_planes_cliente($cliente_id, $dato)
    {
        $this->db->from($this->t6);
        $this->db->where('cliente_id', $cliente_id);        
        $this->db->where('planes_clientes_estado', 'activo');        
        $query = $this->db->get();
        return $query->row($dato);
    }
    public function obtener_planes_cliente_costo($plan_id, $cliente_id)
    {
        $this->db->select("case when t1.planes_clientes_modificar_monto = 'si' then t1.planes_clientes_monto else planes_costo end planes_costo");
        $this->db->from($this->t6.' t1');
        $this->db->join($this->t3.' t2', 't1.plan_id = t2.plan_id');
        $this->db->where('t1.plan_id', $plan_id);
        $this->db->where('t1.cliente_id', $cliente_id);
        $this->db->where('t1.planes_clientes_estado', 'activo');
        
        $query = $this->db->get();
        return $query->row('planes_costo');
    }
    
    // Obtener total de pagos plan + adicional
    public function total_plan_adicional($pago_cliente_id){
        $this->db->select('SUM(pago_cliente_detalle_monto_plan + pago_cliente_detalle_monto_adicional) monto_plan');
        $this->db->from($this->t8);
        $this->db->where('pago_cliente_id',$pago_cliente_id);
        $query = $this->db->get();
        return $query->row('monto_plan');
    }
    // Actualizar cabecera monto_plan, monto_iva, monto_total
    public function actualizar_montos_cabecera($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t7, $data);
        return $this->db->affected_rows();
    }
    public function obtener_por_id($pago_cliente_id)
    {
        $qry_lang_date = "SET lc_time_names = 'es_ES'";
		$this->db->query($qry_lang_date);
		$this->db->select("concat(t2.cliente_nombre, ' ', t2.cliente_apellido) cliente, t2.cliente_direccion, t2.cliente_estado, t2.cliente_cel, FORMAT(t2.cliente_ci, 0, 'de_DE') cliente_ci, DATE_FORMAT(t1.pago_cliente_dateinsert, '%d-%m-%Y') pago_cliente_fecha, , DATE_FORMAT(t1.pago_cliente_dateinsert, '%H:%i:%s') pago_cliente_hora, t1.pago_cliente_estado, concat(t3.usuario_nombre, ' ', t3.usuario_apellido) cobrador, FORMAT(sum(t4.pago_cliente_detalle_monto_plan), 0, 'de_DE') pago_cliente_monto_plan, FORMAT(sum(t4.pago_cliente_detalle_monto_adicional), 0, 'de_DE') pago_cliente_detalle_monto_adicional, FORMAT(t1.pago_cliente_monto_plan, 0, 'de_DE') total_pago, t1.pago_cliente_cuotas, FORMAT(t1.pago_cliente_monto_total, 0, 'de_DE') pago_cliente_monto_total, case when MONTH(t1.pago_cliente_fecha) = MONTH(t1.pago_cliente_fecha_hasta) then DATE_FORMAT(t1.pago_cliente_fecha, '%M') else concat(DATE_FORMAT(t1.pago_cliente_fecha, '%M'), ' a ', DATE_FORMAT(t1.pago_cliente_fecha_hasta, '%M')) end pago_cliente_desde_hasta, t5.pago_forma_alias");
        $this->db->from($this->t7.' t1');
        $this->db->join($this->t1.' t2', 't1.cliente_id = t2.cliente_id', 'left');
        $this->db->join($this->t9.' t3', 't1.usuario_id = t3.usuario_id', 'left');
        $this->db->join($this->t8.' t4', 't4.pago_cliente_id = t1.pago_cliente_id', 'left');
        $this->db->join($this->t10.' t5', 't5.pago_forma_id = t1.pago_forma_id', 'left');
		$this->db->where('t1.pago_cliente_id', $pago_cliente_id);        
        $query = $this->db->get();
        return $query->row();
    }

    // Listar detalle del ticket
	// Sirve para imprimir el ticket tambien
    public function datatableVerDetalle($pago_cliente_id){
        $this->db->select("t4.cliente_id, concat(t4.cliente_nombre, ' ', t4.cliente_apellido) cliente, CASE WHEN (YEAR(CURDATE()) - YEAR(t4.cliente_fecha_nacimiento)) = YEAR(CURDATE()) THEN 'ND' ELSE YEAR(CURDATE()) - YEAR(t4.cliente_fecha_nacimiento) END edad, CASE WHEN (YEAR(CURDATE()) - YEAR(t4.cliente_fecha_nacimiento)) = YEAR(CURDATE()) THEN CONCAT(t6.plan_categoria_nombre, ' - ', t3.planes_clientes_estado) ELSE CONCAT(t6.plan_categoria_nombre, ' (', `t7`.`plan_rango_edad_nombre`, ') ', t3.planes_clientes_estado) END plan, t6.plan_categoria_nombre plan2, FORMAT(t1.pago_cliente_detalle_monto_adicional, 0, 'de_DE') pago_cliente_detalle_monto_adicional, case when t3.planes_clientes_modificar_monto = 'si' then FORMAT(t3.planes_clientes_monto, 0, 'de_DE') else FORMAT(t1.pago_cliente_detalle_monto_plan, 0, 'de_DE') end pago_cliente_detalle_monto_plan");
        $this->db->from($this->t8.' t1');
        $this->db->join($this->t7.' t2', 't1.pago_cliente_id = t2.pago_cliente_id', 'right');
        $this->db->join($this->t6.' t3', 't1.planes_clientes_id = t3.planes_clientes_id', 'right');
        $this->db->join($this->t1.' t4', 't3.cliente_id = t4.cliente_id', 'right');
        $this->db->join($this->t3.' t5', 't3.plan_id = t5.plan_id', 'right');
        $this->db->join($this->t5.' t6', 't5.plan_categoria_id = t6.plan_categoria_id', 'right');
        $this->db->join($this->t4.' t7', 't5.plan_rango_edad_id = t7.plan_rango_edad_id', 'right');
        
        $this->db->where('t1.pago_cliente_id', $pago_cliente_id);
        $this->db->or_where('t1.pago_cliente_id', $pago_cliente_id);
        $this->db->order_by('t4.cliente_tipo_id', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function listar_clientes_titulares($cliente_id = NULL) {
		$this->db->select("CASE
					WHEN t1.cliente_id = t2.cliente_id
					   THEN 'selected'
					END as selected,
					t1.cliente_id, t1.cliente_nombre, t1.cliente_apellido, FORMAT(t1.cliente_ci, 0, 'de_DE') cliente_ci");
		$this->db->from($this->t1.' t1');
		$this->db->join($this->t7.' t2', 't1.cliente_id = t2.cliente_id and t1.cliente_id = '.$cliente_id, 'left');
		$this->db->where('t1.cliente_tipo_id', '1');
		$consulta     = $this->db->get();
		$resultado    = $consulta->result();
		return $resultado;
	}
    public function mostrar_forma_pago() {
        $this->db->select("CASE
					WHEN pago_forma_id = 1
					   THEN 'selected'
					END as selected, ".$this->t10.".*");
        $this->db->from($this->t10);
		$consulta     = $this->db->get();
		$resultado    = $consulta->result();
		return $resultado;
	}
    public function anular_ticket($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t7, $data);
        return $this->db->affected_rows();
    }
	
    //////////
    public function update($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t1, $data);
        return $this->db->affected_rows();
    }
    public function update_planes_clientes_estado($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t6, $data);
        return $this->db->affected_rows();
    }
    public function planes_clientes_existe($cliente_id, $plan_id){
		$this->db->from($this->t6);
        $this->db->where('cliente_id', $cliente_id);
        if ($plan_id != 0){
            $this->db->where('plan_id', $plan_id);
        }
		$this->db->where('planes_clientes_estado', 'activo');
		$query = $this->db->get();
        return $query->row();
    }
	/*
	*	Último pago
	*
	*/
	public function mostrar_ultimo_pago($cliente_id){
		$qry_lang_date = "SET lc_time_names = 'es_ES'";
		$this->db->query($qry_lang_date);
		$this->db->select("case when MONTH(pago_cliente_fecha) = MONTH(pago_cliente_fecha_hasta)
			then DATE_FORMAT(pago_cliente_fecha, '%M')
			else concat(DATE_FORMAT(pago_cliente_fecha, '%M'), ' a ', DATE_FORMAT(pago_cliente_fecha_hasta, '%M'))
			end pago_cliente_desde_hasta,
			FORMAT(pago_cliente_monto_total, 0, 'de_DE') pago_cliente_monto_total,
			DATE_FORMAT(pago_cliente_dateinsert, '%d-%m-%Y %H:%i') pago_cliente_dateinsert"); // 
		$this->db->from($this->t7);
        $this->db->where('cliente_id', $cliente_id);        
        $this->db->where('pago_cliente_estado', 'Pagado');        
        $this->db->order_by('pago_cliente_id', 'desc');        
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
	}
    /*public function planes_clientes_fecha_ingreso($cliente_id, $plan_id)
    {
        $this->db->select('planes_clientes_fecha_ingreso');
        $this->db->from($this->t6);
        $this->db->where('cliente_id',$id);        
        $query = $this->db->get();
        return $query->row();
    }*/
    // Si se actualiza y el titular ahora es adherente, todos sus adherentes se mueven al nuevo titular
    public function cliente_es_titular($cliente_id, $cliente_tipo_id){
		$this->db->from($this->t1);
        $this->db->where('cliente_tipo_id', $cliente_tipo_id);
		$this->db->where('cliente_id', $cliente_id);
		$query = $this->db->get();
        return $query->row();
    }
    public function eliminar_por_id($id){
        //$this->eliminar_grupo_cliente($id);
		$this->db->where('cliente_id', $id);
        $this->db->delete($this->t1);		
    }
        
    public function listar_planes($edad = NULL, $cliente_id = NULL) {
        $this->db->select("CASE
					WHEN t1.plan_id = t4.plan_id
					   THEN 'selected'
					END as selected,
					t1.plan_id, t3.plan_categoria_id, t3.plan_categoria_nombre, FORMAT(t1.planes_costo, 0, 'de_DE') planes_costo, t2.plan_rango_edad_nombre");
		$this->db->from($this->t3.' t1');
		$this->db->join($this->t4.' t2', 't1.plan_rango_edad_id = t2.plan_rango_edad_id');
		$this->db->join($this->t5.' t3', 't1.plan_categoria_id = t3.plan_categoria_id');
		$this->db->join($this->t6.' t4', 't4.plan_id = t1.plan_id and t4.planes_clientes_estado = "activo" and t4.cliente_id = '.$cliente_id, 'left');
		$this->db->where($edad." BETWEEN t2.planes_rango_limite_inferior AND t2.planes_rango_limite_superior");
		$this->db->order_by('t3.plan_categoria_id');
		$consulta     = $this->db->get();
		$resultado    = $consulta->result();
		return $resultado;
	}
}