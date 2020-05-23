<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Planes_m extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
	/*****
	*
	*	Tablas a utilizar
	*
	*/
	var $t1 = 'planes';
    var $t2 = 'planes_categoria';
    var $t3 = 'planes_rango_edad';
    var $t4 = 'planes_vigencia';
    
    /**
    *   Configuraciones de DATATABLE
    *   Tabla:  menu
    */
    var $order_column   = array(NULL, NULL, "plan_rango_edad_nombre", "planes_costo", "plan_vigencia_nombre", NULL);
    
    function make_query()
    {
        $this->db->select("t1.plan_id, t2.plan_categoria_nombre, t3.plan_rango_edad_nombre, FORMAT(t1.planes_costo, 0, 'de_DE') planes_costo, t4.plan_vigencia_nombre, concat(t3.planes_rango_limite_inferior, ' / ', planes_rango_limite_superior) plan_rango_limite");
        $this->db->from($this->t1.' t1');
        $this->db->join($this->t2.' t2', 't2.plan_categoria_id = t1.plan_categoria_id');
        $this->db->join($this->t3.' t3', 't3.plan_rango_edad_id = t1.plan_rango_edad_id');
        $this->db->join($this->t4.' t4', 't4.plan_vigencia_id = t3.plan_vigencia_id', 'left');
        
        $this->db->order_by('COALESCE(t2.plan_categoria_id, t3.plan_rango_edad_nombre)');
        //$this->db->order_by('t1.menu_id_padre is NOT NULL', NULL, FALSE);
        //$this->db->order_by('t1.menu_id');
        
        if (isset($_POST["search"]["value"])) {
            $this->db->like("t2.plan_categoria_nombre", $_POST["search"]["value"]);
            $this->db->or_like("t3.plan_rango_edad_nombre", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            //$this->db->order_by('menu_id_padre', 'ASC');
            //$this->db->order_by('menu_nivel', 'ASC');
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
        $this->db->from($this->t1);
        return $this->db->count_all_results();
    }
	
	public function listar_menu() {
		$this->db->select('t1.menu_id, t1.menu_nombre, t1.menu_nivel, t2.menu_nombre menu_nombre_padre, t1.menu_icono, t1.menu_controlador');
		$this->db->from($this->t1.' t1');
		$this->db->join($this->t1.' t2', 't1.menu_id_padre = t2.menu_id', 'left');
		$this->db->order_by('t1.menu_id_padre');
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	/*****
	*
	*	ABM
	*
	*/
	public function agregar($data)
    {
        $this->db->insert($this->t1, $data);
        return $this->db->insert_id();
    }
    
	public function obtener_por_id($id)
    {
        $this->db->from($this->t1);
        $this->db->where('plan_id',$id);
        
        $query = $this->db->get();
        return $query->row();
    }
	public function update($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t1, $data);
        return $this->db->affected_rows();
    }
	public function eliminar_por_id($id){
        $this->db->where('menu_id', $id);
        $this->db->delete($this->t1);
    }
    /*****
    *
    *   ABMsitos
    *
    */
    public function agregar_categoria($data)
    {
        $this->db->insert($this->t2, $data);
        return $this->db->insert_id();
    }
    public function categoria_editar($id)
    {
        $this->db->from($this->t2);
        $this->db->where('plan_categoria_id',$id);
        
        $query = $this->db->get();
        return $query->row();
    }
    public function categoria_actualizar($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t2, $data);
        return $this->db->affected_rows();
    }
    /****
    *
    */
    public function rango_edad_agregar($data)
    {
        $this->db->insert($this->t3, $data);
        return $this->db->insert_id();
    }
    public function rango_edad_editar($id)
    {
        $this->db->from($this->t3);
        $this->db->where('plan_rango_edad_id',$id);
        
        $query = $this->db->get();
        return $query->row();
    }
    public function rango_edad_actualizar($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t3, $data);
        return $this->db->affected_rows();
    }
	/*********
	*  JQUERY
	*
	*/
	public function listar_planes_categoria($plan_id = NULL) {
        $this->db->select("CASE
                    WHEN t1.plan_categoria_id = t2.plan_categoria_id
                       THEN 'selected'
                    END as selected, 
                    t1.plan_categoria_id, t1.plan_categoria_nombre");
        $this->db->from($this->t2.' t1');
        $this->db->join($this->t1.' t2', 't1.plan_categoria_id = t2.plan_categoria_id and t2.plan_id = '.$plan_id, 'left');
        
        $this->db->order_by('t1.plan_categoria_id');
        $consulta     = $this->db->get();
        $resultado    = $consulta->result();
        return $resultado;
    }
    public function listar_planes_rango_edad($plan_id = NULL) {
        $this->db->select("CASE
                    WHEN t1.plan_rango_edad_id = t2.plan_rango_edad_id
                       THEN 'selected'
                    END as selected, 
                    t1.plan_rango_edad_id, t1.plan_rango_edad_nombre");
        $this->db->from($this->t3.' t1');
        $this->db->join($this->t1.' t2', 't1.plan_rango_edad_id = t2.plan_rango_edad_id and t2.plan_id = '.$plan_id, 'left');
        
        $this->db->order_by('t1.planes_rango_limite_inferior');
        $consulta     = $this->db->get();
        $resultado    = $consulta->result();
        return $resultado;
    }
    public function listar_planes_vigencia($plan_rango_edad_id = NULL) {
        $this->db->select("CASE
                    WHEN t1.plan_vigencia_id = t2.plan_vigencia_id
                       THEN 'selected'
                    END as selected, 
                    t1.plan_vigencia_id, t1.plan_vigencia_nombre, t1.plan_vigencia_dias");
        $this->db->from($this->t4.' t1');
        $this->db->join($this->t3.' t2', 't1.plan_vigencia_id = t2.plan_vigencia_id and t2.plan_rango_edad_id = '.$plan_rango_edad_id, 'left');
        
        //$this->db->order_by('t1.planes_rango_limite_inferior');
        $consulta     = $this->db->get();
        $resultado    = $consulta->result();
        return $resultado;
    }
}