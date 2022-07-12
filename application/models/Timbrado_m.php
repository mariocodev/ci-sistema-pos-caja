<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Timbrado_m extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
	/*****
	*
	*	Tablas a utilizar
	*
	*/
	var $t1 = 'timbrado';

    /**
    *   Configuraciones de DATATABLE
    *   Tabla:  timbrado
    */
    var $order_column   = array(NULL, "nro_timbrado", "fecha_desde", "fecha_hasta", "estado");
    
    function make_query()
    {
        $this->db->select("t1.*, DATE_FORMAT(t1.fecha_desde, '%d-%m-%Y') fecha_desde, DATE_FORMAT(t1.fecha_hasta, '%d-%m-%Y') fecha_hasta, FORMAT(t1.nro_timbrado, 0, 'de_DE') nro_timbrado ");
        $this->db->from($this->t1.' t1');        
        $this->db->where('t1.estado <', 2);

        if (isset($_POST["search"]["value"])) {            
            $this->db->group_start();
            $this->db->like("t1.nro_timbrado", $_POST["search"]["value"]);
            $this->db->or_like("DATE_FORMAT(t1.fecha_desde, '%d-%m-%Y')", $_POST["search"]["value"]);
            $this->db->or_like("DATE_FORMAT(t1.fecha_hasta, '%d-%m-%Y')", $_POST["search"]["value"]);
            $this->db->or_like("t1.estado", $_POST["search"]["value"]);
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
		$this->db->where('estado', 1);
		$consulta = $this->db->get();
		$resultado = $consulta->result();
		return $resultado;
	}

    // Obtener registro por ID
    public function getbyId($id)
    {
        $this->db->from($this->t1);
        $this->db->where('timbrado_id',$id);
        
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
        $this->db->where('timbrado_id', $id);
        $this->db->delete($this->t1);
    }

}