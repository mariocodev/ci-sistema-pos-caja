<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  Class Usuarios
 *
 *  ABM de usuarios
 *  https://stackoverflow.com/questions/21876224/create-an-optgroup-from-an-array-of-data
 *  https://github.com/tomsta93/Countries-drop-down-Codeigniter/wiki/Countries-drop-down-helper-Codeigniter
 *
 *  @package application/controllers/usuarios
 *  @author  seto  
 */
class Usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_m');
        $this->load->model('menu_m');
        $this->load->model('auxiliar_m');
        date_default_timezone_set("America/Asuncion");
    }
    
    public function index()
    {
        $data['listar_modulos']  = $this->menu_m->listar_modulos(0);
        $data['breadcrumb']  = $this->auxiliar_m->breadcrumb($this->router->class);
        
        $this->load->view('html/Head');
        $this->load->view('html/Nav', array(
            'model_menu' => $this->load->model('menu_m'),
            'menus' => $this->menu_m->menu()
        ));
        $this->load->view('html/Breadcrumb_v', $data);
        $this->load->view('admin/Usuarios_v', $data);
        $this->load->view('html/Footer');
    }
    function da(){
        $this->usuarios_m->listar_grupo_usuario(1);
        foreach ($this->usuarios_m->listar_grupo_usuario(2) as $row) {
            echo $row->grupo_id;
        }
    }    
    function datatable_datos()
    {
        $fetch_data = $this->usuarios_m->make_datatables();
        
        $data       = array();
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $row->usuario_id;
            $sub_array[] = $row->usuario_nombre_apellido;
            $sub_array[] = $row->usuario_user;
            $sub_array[] = $row->usuario_estado;
            $sub_array[] = $row->usuario_grupos;
            $sub_array[] = $row->usuario_dateinsert;
            $sub_array[] = $row->usuario_dateupdate;
            $sub_array[] = '';
            $data[]      = $sub_array;
        }
        $output = array(
            "draw"          => intval($this->input->post("draw")),
            "recordsTotal"  => $this->usuarios_m->get_all_data(),
            "recordsFiltered" => $this->usuarios_m->get_filtered_data(),
            "data"          => $data
        );
        if(!isset($headers)){
            $headers='Content-type:application/json';
        }
        header($headers);
        echo json_encode($output, JSON_PRETTY_PRINT);
    }    
    
    /**
    *   Añadir, Editar / Actualizar, Eliminar
    *
    */
    public function agregar()
    {
        date_default_timezone_set("America/Asuncion");
        $data   = array(
            'usuario_nombre'    => $this->input->post('usuario_nombre'),
            'usuario_apellido'  => $this->input->post('usuario_apellido'),
            'usuario_user'      => $this->input->post('usuario_user'),
            'usuario_pass'      => md5($this->input->post('usuario_pass')),
            'usuario_estado'    => $this->input->post('usuario_estado')
        );
        $insert = $this->usuarios_m->agregar($data);
        echo json_encode(array(
            "status" => TRUE
        ));
        if ($insert) {
            foreach ($this->input->post('my_multi_select1') as $tar) {
                $data = array(
                    'usuario_id' => $insert,
                    'grupo_id' => $tar
                );
                $this->usuarios_m->insertar_grupo_usuario($data);
            }
        }
    }
    
    public function editar($id)
    {
        $data = $this->usuarios_m->obtener_por_id($id);
        echo json_encode($data);
    }
    
    public function actualizar()
    {
        $data = array(
            'usuario_nombre'    => $this->input->post('usuario_nombre'),
            'usuario_apellido'  => $this->input->post('usuario_apellido'),
            'usuario_user'      => $this->input->post('usuario_user'),
            'usuario_pass'      => md5($this->input->post('usuario_pass')),
            'usuario_estado'    => $this->input->post('usuario_estado')
        );
        if ($this->input->post('usuario_pass') == '') {
            unset($data['usuario_pass']);
        }
        $this->usuarios_m->update(array(
            'usuario_id' => $this->input->post('usuario_id')
        ), $data);
        echo $exito = json_encode(array(
            "status" => TRUE
        ));
        if ($exito = TRUE) {
            $this->usuarios_m->eliminar_grupo_usuario($this->input->post('usuario_id'));
            foreach ($this->input->post('my_multi_select1') as $tar) {
                $data   = array(
                    'usuario_id' => $this->input->post('usuario_id'),
                    'grupo_id' => $tar
                );
                $insert = $this->usuarios_m->insertar_grupo_usuario($data);
            }
        }
    }
    /* Borrado lógio */
    public function eliminar($id)
    {
        $this->usuarios_m->update(
            array('usuario_id'       => $id),
            array('usuario_estado'   => 'borrado')
        );
        echo json_encode(array("status" => TRUE));
    }
    /*
    * Eliminado físico
    public function eliminar($id)
    {
        $this->usuarios_m->eliminar_por_id($id);
        echo json_encode(array(
            "status" => TRUE
        ));
    }
    */
    /**
    *   Perfiles usuarios
    *
    **/
    public function obtener_grupo_usuario($usuario_id)
    {
        foreach ($this->usuarios_m->listar_grupo($usuario_id) as $row) {
            echo '<option class="op" value="' . $row->grupo_id . '" ' . $row->selected . '>' . $row->grupo_id . ' - ' . $row->grupo_nombre . '</option>';
        }
    }
    public function guardarPerfil()
    {
        $this->usuarios_m->eliminar_grupo_usuario_permisos($this->input->post('grupo_id'), $this->input->post('menu_id'));
        foreach ($this->input->post('grupo_acciones_id') as $tar) {
            $data = array(
                'grupo_id' => $this->input->post('grupo_id'),
                'menu_id' => $this->input->post('menu_id'),
                'grupo_acciones_id' => $tar
            );
            $this->usuarios_m->insertar_grupo_usuario_permisos($data);
            json_encode(array(
                "status" => TRUE
            ));
        }
    }    
    /**
    *   Perfiles permisos
    *
    **/
    public function obtener_grupo_permisos($grupo_id, $menu_id)
    {
        foreach ($this->usuarios_m->listar_grupo_permisos($grupo_id, $menu_id) as $row) {
            echo '<div class="checkbox checkbox-success checkbox-inline">
                <input id="'.$row->grupo_acciones_id.'" value="'.$row->grupo_acciones_id.'" type="checkbox" '.$row->selected.'
                onclick="asignar_permiso_perfil('.$grupo_id.','.$menu_id.', '.$row->grupo_acciones_id.')">
                <label for="'.$row->grupo_acciones_id.'"> '.$row->grupo_acciones_id.'. '.$row->grupo_acciones_nombre.'</label>
                </div>';
        }
    }

    public function guardar_permiso_perfil($grupo_id, $menu_id, $grupo_acciones_id)
    {
        $existe_grupo_permisos = $this->usuarios_m->existe_grupo_permisos($grupo_id, $menu_id, $grupo_acciones_id);

        if ($existe_grupo_permisos == 1){
            $this->usuarios_m->eliminar_grupo_usuario_permisos($grupo_id, $menu_id, $grupo_acciones_id);
        }else{
            $data = array(
                'grupo_id'             => $grupo_id,
                'menu_id'               => $menu_id,
                'grupo_acciones_id'    => $grupo_acciones_id
            );
            $this->usuarios_m->insertar_grupo_usuario_permisos($data);
            json_encode(array(
                "status" => TRUE
            ));
        }
    }
    
    /**
    *   PERFIL: Añadir, Editar / Actualizar, Eliminar
    *
    */
    public function grupo_agregar()
    {
        $data   = array(
            'grupo_nombre'      => $this->input->post('grupo_nombre'),
            'grupo_dateinsert'  => date("Y-m-d H:i:s")
        );
        $insert = $this->usuarios_m->grupo_agregar($data);
        echo json_encode(array(
            "status" => TRUE
        ));
    }
    
    public function grupo_editar($id)
    {
        $data = $this->usuarios_m->grupo_editar_por_id($id);
        echo json_encode($data);
    }
    
    public function grupo_actualizar()
    {
        $data = array(
            'grupo_nombre' => $this->input->post('grupo_nombre')
        );
        $this->usuarios_m->grupo_actualizar(array(
            'grupo_id' => $this->input->post('grupo_id')
        ), $data);
        echo $exito = json_encode(array(
            "status" => TRUE
        ));
    }
    
    public function grupo_eliminar($id)
    {
        $this->usuarios_m->grupo_eliminar_por_id($id);
        echo json_encode(array(
            "status" => TRUE
        ));
    }

    /**
    *   Insertar usuarios de prueba
    *
    */
    function primo($num){
        $cont=0;
        // Funcion que recorre todos los numero desde el 2 hasta el valor recibido
        for($i=2;$i<=$num;$i++){
        if($num%$i==0){
            # Si se puede dividir por algun numero mas de una vez, no es primo
            if(++$cont>1)
                return false;
            }
        }
    return true;
    }
    
    public function insertar_prueba()
    {
        ini_set('MAX_EXECUTION_TIME', 0);
        for ($i = 5; $i < 1500; $i++) {
            if ($this->primo($i)){$estado = 'inactivo';}else{$estado = 'activo';}
            $data   = array(
                'usuario_nombre'    => substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7),
                'usuario_apellido'  => substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6),
                'usuario_user'      => 'u'.$i,
                'usuario_pass'      => md5('123456'),
                'usuario_estado'    => $estado                
            );
            $insert = $this->usuarios_m->agregar($data);
            echo json_encode(array(
                "status" => TRUE
            ));
        }
    }    
    
}