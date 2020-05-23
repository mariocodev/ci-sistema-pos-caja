<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Login_m extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
	/*****
	*
	*	Tablas a utilizar
	*
	*/
	var $t1 = 'usuarios';
	var $t2 = 'grupo_usuarios';
	
	public function obtener_usuario($usuario_user, $usuario_pass){
		$this->db->from($this->t1);
		$this->db->where('usuario_user', $usuario_user);
		$this->db->where('usuario_pass', $usuario_pass);
		$this->db->where('usuario_estado', 'activo');
		$consulta = $this->db->get();
		$resultado = $consulta->row();
		return $resultado;
   }
   public function obtener_grupo($usuario_id){
	   $this->db->select('grupo_id');
	   $this->db->from($this->t2);
	   $this->db->where('usuario_id', $usuario_id);
	   $consulta = $this->db->get();
	   $resultado = $consulta->result();
	   return $resultado;
	}
}