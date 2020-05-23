<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Usuarios_m extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
	/**
	*  Tablas a utilizar
	*  @author: Mario Amarilla
    *  @version: 28/08/2018/A
	*/
	var $t1 = 'usuarios';
	var $t2 = 'grupo';
	var $t3 = 'grupo_usuarios';
	var $t4 = 'menu';
	var $t5 = 'grupo_acciones';
	var $t6 = 'grupo_permisos';
    var $t7 = 'menu';    
	
	/**
    *   Configuraciones de DATATABLE
    *   Tabla:  usuarios
    */
    //DATE_FORMAT(usuario_dateupdate, '%d-%m-%Y %H:%i') usuario_dateupdate
    var $order_column   = array('usuario_id', "usuario_nombre_apellido", "usuario_user", "usuario_estado", null, null);
    
    function make_query()
    {
        $this->db->select('t1.usuario_id, concat(t1.usuario_nombre," ", t1.usuario_apellido) usuario_nombre_apellido, t1.usuario_user, t1.usuario_estado, group_concat(t3.grupo_nombre separator " | ") usuario_grupos, DATE_FORMAT(t1.usuario_dateinsert, "%d-%m-%Y %H:%i") usuario_dateinsert, DATE_FORMAT(t1.usuario_dateupdate, "%d-%m-%Y %H:%i") usuario_dateupdate');
        $this->db->from($this->t1.' t1');
        $this->db->join($this->t3.' t2', 't1.usuario_id = t2.usuario_id', 'left');
        $this->db->join($this->t2.' t3', 't3.grupo_id = t2.grupo_id', 'left');
        
        $this->db->group_by('t1.usuario_id');        
        
        if (isset($_POST["search"]["value"])) {
            $this->db->group_start();
            $this->db->like("t1.usuario_nombre", $_POST["search"]["value"]);
            $this->db->or_like("t1.usuario_apellido", $_POST["search"]["value"]);
            $this->db->or_like("t1.usuario_user", $_POST["search"]["value"]);
            $this->db->or_like("t1.usuario_dateinsert", $_POST["search"]["value"]);
            $this->db->group_end();
            $this->db->where('t1.usuario_estado <>', 'borrado');
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('t1.usuario_id', 'ASC');
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
        $this->db->where('usuario_estado <>', 'borrado');
        return $this->db->count_all_results();
    }
    
    /**
    *
    *
    */
	public function listar_grupo($usuario_id = NULL) {
		$this->db->select("CASE
					WHEN t2.grupo_id = t1.grupo_id
					   THEN 'selected'
					END as selected,
					t1.grupo_id, t1.grupo_nombre");
		$this->db->from($this->t2.' t1');
		$this->db->join($this->t3.' t2', 't1.grupo_id = t2.grupo_id and t2.usuario_id = '.$usuario_id, 'left');
		$consulta     = $this->db->get();
		$resultado    = $consulta->result();
		return $resultado;
	}
    public function listar_grupo_usuario($usuario_id) {
		$this->db->select("*");
		$this->db->from($this->t2.' t1');
		$this->db->join($this->t3.' t2', 't1.grupo_id = t2.grupo_id and t2.usuario_id = '.$usuario_id, 'left');
		$consulta     = $this->db->get();
		$resultado    = $consulta->result();
		return $resultado;
	}
    public function listar_grupo_permisos($grupo_id = NULL, $menu_id = NULL) {
		$this->db->select("case
                    WHEN t2.grupo_acciones_id = t1.grupo_acciones_id
                        THEN 'checked'
                    END as selected,
					t1.grupo_acciones_id,
                    t1.grupo_acciones_nombre");
		$this->db->from($this->t5.' t1');
		$this->db->join($this->t6.' t2', 't1.grupo_acciones_id = t2.grupo_acciones_id and t2.grupo_id = '.$grupo_id.' and t2.menu_id = '.$menu_id, 'left');
		$consulta     = $this->db->get();
		$resultado    = $consulta->result();
		return $resultado;
	}
    public function listar_acciones() {		
		$this->db->from($this->t5);
		$consulta     = $this->db->get();
		$resultado    = $consulta->result();
		return $resultado;
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
	public function insertar_grupo_usuario($data)
    {
        $this->db->insert($this->t3, $data);
        return $this->db->insert_id();
    }
    public function eliminar_grupo_usuario($id){
        $this->db->where('usuario_id', $id);
        $this->db->delete($this->t3);
    }    
	public function obtener_por_id($id)
    {
        $this->db->from($this->t1);
        $this->db->where('usuario_id',$id);
        
        $query = $this->db->get();
        return $query->row();
    }
	public function update($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t1, $data);
        return $this->db->affected_rows();
    }

    /*****
	*
	*	PERFIL ABM
	*
	*/
	public function grupo_agregar($data){
        $this->db->insert($this->t2, $data);
        return $this->db->insert_id();
    }
    public function grupo_editar_por_id($id)
    {
        $this->db->from($this->t2);
        $this->db->where('grupo_id',$id);
        
        $query = $this->db->get();
        return $query->row();
    }
    public function grupo_actualizar($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t2, $data);
        return $this->db->affected_rows();
    }
    public function grupo_eliminar_por_id($id){
        if ($this->grupo_eliminar_permisos($id)){
            if ($this->grupo_eliminar_usuarios($id)){
                $this->db->where('grupo_id', $id);
                $this->db->delete($this->t2);
            }        
        }
    }
    public function grupo_eliminar_permisos($id){
        $this->db->where('grupo_id', $id);
        return $this->db->delete($this->t6);
    }
    public function grupo_eliminar_usuarios($id){
        $this->db->where('grupo_id', $id);
        return $this->db->delete($this->t3);
    }
    
    /**
    *
    *
    */
    public function existe_grupo_permisos($grupo_id, $menu_id, $grupo_acciones_id)
    {
        $this->db->from($this->t6)->where('grupo_id', $grupo_id)->where('menu_id', $menu_id)->where('grupo_acciones_id', $grupo_acciones_id);
        return $this->db->count_all_results();
    }
    public function eliminar_grupo_usuario_permisos($grupo_id, $menu_id, $grupo_acciones_id){
        $this->db->where('grupo_id', $grupo_id);
        $this->db->where('menu_id', $menu_id);
        $this->db->where('grupo_acciones_id', $grupo_acciones_id);
        $this->db->delete($this->t6);
    }
    public function insertar_grupo_usuario_permisos($data)
    {
        $this->db->insert($this->t6, $data);
        return $this->db->insert_id();
    }

	
    /*public function eliminar_grupo_usuario_permisos($grupo_id, $menu_id){
        $this->db->where('grupo_id', $grupo_id);
        $this->db->where('menu_id', $menu_id);
        $this->db->delete($this->t6);
    }*/
	public function eliminar_por_id($id){
        $this->eliminar_grupo_usuario($id);
		$this->db->where('usuario_id', $id);
        $this->db->delete($this->t1);
		
    }
	/*********
	*
	*
	*/
	public function listar_menu_nivel($nivel) {
		$this->db->from($this->t1);
		$this->db->where('menu_nivel', $nivel);
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
}