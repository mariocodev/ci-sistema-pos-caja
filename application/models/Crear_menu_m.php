<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Crear_menu_m extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
	/*****
	*
	*	Tablas a utilizar
	*
	*/
    var $t1 = 'menu';
    var $t2 = 'grupo_permisos';
    var $t3 = 'grupo_acciones';
	var $t4 = 'grupo';

    /**
    *   Configuraciones de DATATABLE
    *   Tabla:  menu
    */
    var $select_column  = array("t1.menu_id", "t1.menu_nivel", "t1.menu_nombre", "t1.menu_icono", "t1.menu_controlador");
    var $order_column   = array(NULL, "menu_nivel", "menu_nombre", NULL, "menu_controlador");
    
    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->t1.' t1');
        $this->db->order_by('COALESCE(t1.menu_id_padre, t1.menu_id)');
        $this->db->order_by('t1.menu_id_padre is NOT NULL', NULL, FALSE);
        $this->db->order_by('t1.menu_id');
        
        if (isset($_POST["search"]["value"])) {
            $this->db->like("t1.menu_nombre", $_POST["search"]["value"]);
            $this->db->or_like("t1.menu_controlador", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('menu_id_padre', 'ASC');
            $this->db->order_by('menu_nivel', 'ASC');
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
        $this->db->where('menu_id',$id);
        
        $query = $this->db->get();
        return $query->row();
    }
	public function update($where1, $data)
    {
        $this->db->where($where1);
        $this->db->update($this->t1, $data);
        return $this->db->affected_rows();
    }
	public function eliminar_por_id($id){
        // Eliminar todos los permisos en la tabla grupo_permisos antes de eliminar el menu
        $this->db->where('menu_id', $id);
        $exito = $this->db->delete($this->t2);
        // Eliminar en la tabla menú
        if ($exito){
            $this->db->where('menu_id', $id);
            $this->db->delete($this->t1);
        }
        //$this->db->query("SET FOREIGN_KEY_CHECKS = 0");        
        //$this->db->query("SET FOREIGN_KEY_CHECKS = 1");
    }


    //  Insertar tambien permisos para el administrador
    //  de todos los menús nuevos
    public function eliminar_grupo_menu($id){
        $this->db->where('menu_id', $id);
        $this->db->delete($this->t2);
    }
    public function insertar_grupo_menu($data)
    {
        $this->db->insert($this->t2, $data);
        return $this->db->insert_id();
    } 
    /****
    *
    *   Listar todas las acciones
    *
    */
    public function listar_acciones() {
        $this->db->select("grupo_acciones_id");
        $this->db->from($this->t3.' t1');
        $consulta     = $this->db->get();
        $resultado    = $consulta->result();
        return $resultado;
    }
	/*********
	*
	*  Call AJAX
	*/
    public function listar_menu_id_padre($menu_id = NULL) {
        $this->db->select("CASE
                    WHEN t1.menu_id = t2.menu_id_padre
                       THEN 'selected'
                    END as selected, 
                    t1.menu_id_padre, t1.menu_id, t1.menu_nombre");
        $this->db->from($this->t1.' t1');
        $this->db->join($this->t1.' t2', 't1.menu_id = t2.menu_id_padre and t2.menu_id = '.$menu_id, 'left');
        
        $this->db->where('t1.menu_nivel', 1);
        //$this->db->order_by('t1.planes_rango_limite_inferior');
        $consulta     = $this->db->get();
        $resultado    = $consulta->result();
        return $resultado;
    }
    public function listar_grupo_menu($menu_id = NULL) {
        $this->db->select("CASE
                    WHEN t2.grupo_id = t1.grupo_id
                       THEN 'selected'
                    END as selected,
                    t1.grupo_id, t1.grupo_nombre");
        $this->db->from($this->t4.' t1');
        $this->db->join($this->t2.' t2', 't1.grupo_id = t2.grupo_id and t2.menu_id = '.$menu_id, 'left');
        $this->db->group_by('t1.grupo_id');
        $consulta     = $this->db->get();
        $resultado    = $consulta->result();
        return $resultado;
    }
}