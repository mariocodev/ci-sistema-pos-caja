<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Sucursal_m extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
	/*****
	*
	*	Tablas a utilizar
	*
	*/
	var $t1 = 'sucursal';

	/**
    *   Configuraciones de DATATABLE
    *   Tabla:  sucursal
    */
    var $order_column   = array(NULL, "sucursal_descripcion", "sucursal_direccion", "sucursal_telefono", "sucursal_ruc", "sucursal_central");
    
    function make_query()
    {
        $this->db->select("t1.*, FORMAT(t1.sucursal_ruc, 0, 'de_DE') sucursal_ruc ");
		$this->db->from($this->t1.' t1');        
        
        if (isset($_POST["search"]["value"])) {            
            $this->db->group_start();
            $this->db->like("t1.sucursal_descripcion", $_POST["search"]["value"]);
			$this->db->like("t1.sucursal_direccion", $_POST["search"]["value"]);
			$this->db->like("t1.sucursal_telefono", $_POST["search"]["value"]);
			$this->db->like("t1.sucursal_ruc", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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
        return $this->db->count_all_results();
    }

    public function getAll() {
		$this->db->from($this->t1);
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}
	// Obtener registro por ID
    public function getbyId($id)
    {
        $this->db->from($this->t1);
        $this->db->where('sucursal_id', $id);
        
        $query = $this->db->get();
        return $query->row();
    }
    /**
     * ABM
     */
    public function add($data)
    {
        $this->db->insert($this->t1, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t1, $data);
        return $this->db->affected_rows();
    }

	public function delete($id){
        $this->db->where('sucursal_id', $id);
        $this->db->delete($this->t1);
    }
	

}