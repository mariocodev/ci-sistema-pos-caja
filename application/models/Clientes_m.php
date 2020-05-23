<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Clientes_m extends CI_Model
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
	
	/**
    *   Configuraciones de DATATABLE
    *   Tabla:  usuarios
    */
    var $select_column  = array("cliente_id", "cliente_nombre", "cliente_apellido", "cliente_ci", "cliente_cel", "DATE_FORMAT(cliente_dateinsert, '%d-%m-%Y %H:%i') cliente_dateinsert");
    
    function make_query()
    {
        $this->db->select("t1.cliente_id, concat(t1.cliente_nombre,' ', t1.cliente_apellido) usuario_nombre_apellido, t2.cliente_tipo_nombre, FORMAT(t1.cliente_ci, 0, 'de_DE') cliente_ci, t1.cliente_cel, t1.cliente_direccion, DATE_FORMAT(cliente_dateinsert, '%d-%m-%Y %H:%i') cliente_dateinsert");
        $this->db->from($this->t1.' t1');
        $this->db->join($this->t2.' t2', 't1.cliente_tipo_id = t2.cliente_tipo_id', 'right');
        $this->db->order_by('COALESCE(t1.cliente_id_padre, t1.cliente_id)');
        $this->db->order_by('t1.cliente_id_padre is NOT NULL', NULL, FALSE);
        $this->db->order_by('t1.cliente_id');

        if (isset($_POST["search"]["value"])) {
            $this->db->group_start();
            $this->db->like("cliente_nombre", $_POST["search"]["value"]);
            $this->db->or_like("cliente_apellido", $_POST["search"]["value"]);
            $this->db->or_like("cliente_ci", $_POST["search"]["value"]);
            $this->db->or_like("cliente_cel", $_POST["search"]["value"]);
            $this->db->group_end();
            $this->db->where('t1.cliente_estado <>', 'borrado');
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
        $this->db->from($this->t1);
        $this->db->where('cliente_estado <>', 'borrado');
        return $this->db->count_all_results();
    }
    /*****
	*
	*	ABM
	*
	*/
	public function agregar($data){
        $this->db->insert($this->t1, $data);
        return $this->db->insert_id();
    }
    public function agregar_plan_cliente($data){
        $this->db->insert($this->t6, $data);
        return $this->db->insert_id();
    }
	public function obtener_por_id($id)
    {
        $this->db->from($this->t1);
        $this->db->where('cliente_id',$id);        
        $query = $this->db->get();
        return $query->row();
    }
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
	/*************
	*	Planes clientes, no actualizar siempre
	*
	*****/
    public function planes_clientes_existe($cliente_id, $plan_id, $planes_clientes_modificar_monto, $planes_clientes_monto, $planes_clientes_fecha_ingreso){
		$this->db->from($this->t6);
        $this->db->where('cliente_id', $cliente_id);
        if ($plan_id != 0){
            $this->db->where('plan_id', $plan_id);
        }
		$this->db->where('planes_clientes_estado', 'activo');
		if ($planes_clientes_modificar_monto != NULL){
            $this->db->where('planes_clientes_modificar_monto', $planes_clientes_modificar_monto);
        }
		if ($planes_clientes_monto != NULL){
			$this->db->where('planes_clientes_monto', $planes_clientes_monto);
		}
		if ($planes_clientes_fecha_ingreso != NULL){
			$this->db->where('planes_clientes_fecha_ingreso', $planes_clientes_fecha_ingreso);
		}
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
    public function listar_clientes_titulares($cliente_id = NULL) {
		$this->db->select("CASE
					WHEN t1.cliente_id_padre = t2.cliente_id
					   THEN 'selected'
					END as selected,
					t2.cliente_id, t2.cliente_nombre, t2.cliente_apellido, FORMAT(t2.cliente_ci, 0, 'de_DE') cliente_ci");
		$this->db->from($this->t1.' t1');
		$this->db->join($this->t1.' t2', 't1.cliente_id_padre = t2.cliente_id and t1.cliente_id = '.$cliente_id, 'right');
		$this->db->where('t2.cliente_tipo_id', '1');
        $this->db->where('t2.cliente_estado <>', 'borrado');
        //$this->db->where('t2.cliente_id <>', $cliente_id);

		$consulta     = $this->db->get();
		$resultado    = $consulta->result();
		return $resultado;
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
		if ($edad <> NULL){
			$this->db->where($edad." BETWEEN t2.planes_rango_limite_inferior AND t2.planes_rango_limite_superior");
			$this->db->order_by('t3.plan_categoria_id');
			}else{
				$this->db->order_by('t3.plan_categoria_nombre, t2.plan_rango_edad_id');
				}
		$consulta     = $this->db->get();
		$resultado    = $consulta->result();
		return $resultado;
	}
    /*
	ORIGINAL
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
		if ($edad <> NULL){
			$this->db->where($edad." BETWEEN t2.planes_rango_limite_inferior AND t2.planes_rango_limite_superior");
			$this->db->order_by('t3.plan_categoria_id');
			}else{
				$this->db->order_by('t3.plan_categoria_nombre, t2.plan_rango_edad_id');
				}
		$consulta     = $this->db->get();
		$resultado    = $consulta->result();
		return $resultado;
	}
	*/
	
	/*** COPIA
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
	*/
}