<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Auxiliar_m extends CI_Model
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
    var $t1 = 'menu';
    var $t2 = 'grupo_permisos';
    var $t3 = 'grupo_usuarios';
    /**-------------------
    *
    *   Breadcrumb
    *
    */
    public function breadcrumb($menu_nombre)
    {
        $menu_nombre = strtolower($menu_nombre);
        $this->db->select('t1.menu_nombre controlador, t2.menu_nombre menu_principal');
        $this->db->from($this->t1.' t1');
        $this->db->join($this->t1.' t2', 't1.menu_id_padre = t2.menu_id');
        $this->db->where('t1.menu_nombre', $menu_nombre);
        $consulta  = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    /**-------------------
    *
    *   Listar menú por niveles
    *
    */
    public function menu_nivel($menu_nivel)
    {
        $this->db->select('t1.menu_nombre');
        $this->db->from($this->t1.' t1');
        $this->db->where('t1.menu_nivel', $menu_nivel);
        $consulta  = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    /**-------------------
    *
    *   Listar todos los datos de una tabla
    *
    */
    /*public function traer_tabla($tabla)
    {
        $this->db->from($tabla);
        $consulta  = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }*/
    public function traer_tabla($where, $tabla)
    {
        $this->db->from($tabla);
        if ($where != NULL){
            $this->db->where($where);
        }
        $consulta  = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    /**-------------------
    *
    *   Menú de navegación
    *
    */
    public function menu($nivel_usuario_id = 0)
    {
        $this->db->from($this->t2.' t1');
        $this->db->join($this->t3.' t2', 't1.grupo_id = t2.grupo_id and usuario_id = '.$this->session->userdata('usuario_id'));
        $this->db->join($this->t1.' t3', 't3.menu_id = t1.menu_id');
        $this->db->join($this->t1.' t4', 't4.menu_id = t3.menu_id_padre');
        $this->db->group_by('t4.menu_id');        
        $q = $this->db->get();
        
        $final = array();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {                
                $this->db->select(" * FROM
                            grupo_permisos t2
                            JOIN menu t1 ON t1.menu_id = t2.menu_id
                            WHERE
                                t1.menu_nivel = 2
                                 AND t1.menu_id_padre = ".$row->menu_id."
                                  AND t2.grupo_id IN (
                                    SELECT grupo_id FROM grupo_usuarios 
                                    WHERE usuario_id = " . $this->session->userdata('usuario_id') . ")
                            GROUP by t2.menu_id
                                    ");
                
                $q = $this->db->get();
                if ($q->num_rows() > 0) {
                    $row->children = $q->result();
                }
                array_push($final, $row);
            }
        }
        return $final;
    }
    
    /**-------------------
    *
    *   Listado de modulos para select optgroup
    *
    */
    public function listar_modulos()
    {
        $this->db->from($this->t1);
        $this->db->where('menu_nivel', 1);
        $q = $this->db->get();
        
        $final = array();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $this->db->from($this->t1);
                $this->db->where('menu_nivel', 2);
                $this->db->where('menu_id_padre', $row->menu_id);
                $q = $this->db->get();
                
                if ($q->num_rows() > 0) {
                    $row->children = $q->result();
                }
                array_push($final, $row);
            }
        }
        return $final;
    }
}