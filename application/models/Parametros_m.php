<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Parametros_m extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
	/*****
	*
	*	Tablas a utilizar
	*
	*/
	var $t1 = 'parametros';

    // Obtener registro por ID
    public function getbyId($id)
    {
        $this->db->from($this->t1);
        $this->db->where('param_id',$id);
        
        $query = $this->db->get();
        return $query->row();
    }

    // Obtener registro por COD
    public function getbyCod($id)
    {
        $this->db->from($this->t1);
        $this->db->where('param_codigo',$id);
        
        $query = $this->db->get();
        return $query->row();
    }

}