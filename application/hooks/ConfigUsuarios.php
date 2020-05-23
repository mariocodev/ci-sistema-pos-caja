<?php
//if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 *
 *
 *  @package application/hooks
 *  @author  seto   
 */

class ConfigUsuarios
{
    private $ci;
    private $controladores_permitidos;
    private $metodos_permitidos;
    private $metodos_no_permitidos;

    function __construct()
    {
        $this->ci   =& get_instance();
    }
    
    function checkAccess(){
        $controlador    =   $this->ci->router->class;
        
        $this->modulos_permitidos =   ['login', 'registro', 'recuperar_pass'];
        
        // Si variable de sesion está vacía  y el controlador actual no es igual 
        // al valor de $this->modulos_permitidos      
        if(($this->ci->session->userdata('usuario_id') == FALSE)
           && (!in_array($controlador, $this->modulos_permitidos)))
        { 
            redirect(base_url('/'));
        }
    }
    // Controladores permitidos
    function ControladorPermitido(){
        // Controlador actual
        $controlador    =   $this->ci->router->class;
        $this->modulos_permitidos =   ['welcome', 'login', 'perfil'];
        
        /**/
        if (!in_array($controlador, $this->modulos_permitidos)){
            if (($this->ci->session->userdata('usuario_id'))){
                $this->ci->db->from('grupo_permisos t1');
                $this->ci->db->join('grupo_usuarios t2', 't1.grupo_id = t2.grupo_id AND usuario_id = '.$this->ci->session->userdata('usuario_id'));
                $this->ci->db->join('menu t3', 't3.menu_id = t1.menu_id');
                $this->ci->db->where('t3.menu_controlador', $controlador);
                $consulta = $this->ci->db->get();
                if ($consulta->num_rows() == 0){
                    redirect('welcome');
                    //echo 'No tienes permiso '.$consulta->num_rows().' - '.$controlador;
                    //die();
                }
            }
        }
    }
}
/*
/end hooks/ConfigUsuarios.php
*/