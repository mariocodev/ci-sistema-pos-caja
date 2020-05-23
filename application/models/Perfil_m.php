<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Perfil_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Menu function.
     * @access public
     * @return bool true on success, false on failure
     */
    var $t1 = 'usuarios';

    /**-------------------
    *
    *   Breadcrumb
    *
    */
    function get_usuario() {
        $this->db->where('usuario_id', $this->session->userdata('usuario_id'));
        $query = $this->db->get($this->t1); //  Se especifica la tabla        
        if ($query->num_rows() > 0){ //  Validar resultados
            return $query;    
        }else{
            return FALSE; // Imprimir 404
        }

    }
    function get_nombre_foto() {
        $this->db->from($this->t1);
        $this->db->where('usuario_id', $this->session->userdata('usuario_id'));
        return $this->db->get()->row('usuario_foto');
    }
    
    function pass_anterior($usuario_pass) {
        $this->db->from($this->t1);
        $this->db->where('usuario_id', $this->session->userdata('usuario_id'));
        $this->db->where('usuario_pass', $usuario_pass);
        return $this->db->get()->row('usuario_pass');
    }
    
    /**-------------------
    *
    *   Guardar
    *
    */
    function guardar()
    {
        $data = array(
            'usuario_nombre'    => $this->input->post('usuario_nombre'),
            'usuario_apellido'  => $this->input->post('usuario_apellido')
        );
        $this->db->where('usuario_id', $this->session->userdata('usuario_id'));
        $this->db->update($this->t1, $data);
    }
    function cambiar_pass()
    {
        $data = array(
            'usuario_pass'    => md5($this->input->post('usuario_pass'))
        );
        $this->db->where('usuario_id', $this->session->userdata('usuario_id'));
        $this->db->update($this->t1, $data);
    }
    function guardar_foto($archivo_nombre)
    {
        $data = array(
            'usuario_foto'    => $archivo_nombre
        );
        $this->db->where('usuario_id', $this->session->userdata('usuario_id'));
        $this->db->update($this->t1, $data);
    }
    
}