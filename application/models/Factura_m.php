<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Factura_m extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
	/*****
	*
	*	Tablas a utilizar
	*
	*/
	var $t1 = 'factura';
    var $t2 = 'timbrado';
    var $t3 = 'sucursal';
    var $t4 = 'usuarios';

    /**
    *   Configuraciones de DATATABLE
    *   Tabla:  factura
    */
    var $order_column   = array(NULL, "nro_timbrado", "nro_desde", "nro_hasta", "nro_actual", "sucursal_descripcion");
    
    function make_query()
    {
        $this->db->select("t1.factura_id, FORMAT(t2.nro_timbrado, 0, 'de_DE') nro_timbrado, t1.nro_desde, t1.nro_hasta, t1.nro_actual, t3.sucursal_descripcion, t1.estado");
        $this->db->from($this->t1.' t1');
        $this->db->join($this->t2.' t2', 't2.timbrado_id = t1.timbrado_id');
        $this->db->join($this->t3.' t3', 't3.sucursal_id = t1.sucursal_id');
        $this->db->where('t1.estado <', 2);
        
        if (isset($_POST["search"]["value"])) {
            $this->db->group_start();
            $this->db->like("t1.nro_desde", $_POST["search"]["value"]);
            $this->db->or_like("t1.nro_hasta", $_POST["search"]["value"]);
            $this->db->or_like("t1.nro_actual", $_POST["search"]["value"]);
            $this->db->or_like("t2.nro_timbrado", $_POST["search"]["value"]);
            $this->db->or_like("t3.sucursal_descripcion", $_POST["search"]["value"]);
            $this->db->group_end();
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
        $this->db->from($this->t1);
        return $this->db->count_all_results();
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
        $this->db->where('factura_id', $id);
        $this->db->delete($this->t1);
    }

    /**
     * Obtener registro por ID
     */
    public function getbyId($id)
    {
        $this->db->from($this->t1);
        $this->db->where('factura_id',$id);
        
        $query = $this->db->get();
        return $query->row();
    }

    public function getBySucursal($sucursal_id)
    {
        $this->db->from($this->t1);
        $this->db->where('sucursal_id', $sucursal_id);
        $this->db->where('estado', 1);
        
        $query = $this->db->get();
        return $query->row();
    }

    public function updateNroActual($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->t1, $data);
        return $this->db->affected_rows();
    }

}