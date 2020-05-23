<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
	public function __construct() {
        parent::__construct();        
        $this->load->model('crear_menu_m');
        $this->load->model('auxiliar_m');
	}
	
	public function index() {
		$data['breadcrumb']  = $this->auxiliar_m->breadcrumb($this->router->class);        
		$this->load->view('html/Head');
		$this->load->view('html/Nav', array(
										'model_menu' => $this->load->model('menu_m'), 
										'menus' => $this->menu_m->menu()
										));
        $this->load->view('html/Breadcrumb_v', $data);
		$this->load->view('admin/Menu_v', $data);
		$this->load->view('html/Footer');
	}
    function datatable_datos()
    {
        $fetch_data = $this->crear_menu_m->make_datatables();
        
        $data       = array();
        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $row->menu_id;            
            $sub_array[] = $row->menu_nombre;
            $sub_array[] = $row->menu_nivel;
            $sub_array[] = $row->menu_icono;
            $sub_array[] = $row->menu_controlador;
            $data[]      = $sub_array;
        }
        $output = array(
            "draw"              => intval($this->input->post("draw")),
            "recordsTotal"      => $this->crear_menu_m->get_all_data(),
            "recordsFiltered"   => $this->crear_menu_m->get_filtered_data(),
            "data"              => $data
        );
        if(!isset($headers)){
            $headers='Content-type:application/json';
        }
        header($headers);
        echo json_encode($output, JSON_PRETTY_PRINT);
    }
	/*****
	*
	*	ABM
	*
	*/
	public function agregar(){
        $data = array(
            'menu_nombre'       => $this->input->post('menu_nombre'),
			'menu_nivel'		=> $this->input->post('menu_nivel'),
			'menu_icono'		=> empty($this->input->post('menu_icono')) ? NULL : $this->input->post('menu_icono'),
			'menu_id_padre'     => empty($this->input->post('menu_id_padre')) ? NULL : $this->input->post('menu_id_padre'),
			'menu_controlador'	=> empty($this->input->post('menu_controlador')) ? NULL : $this->input->post('menu_controlador')
        );
        $insert = $this->crear_menu_m->agregar($data);
        if ($insert and $this->input->post('my_multi_select1')){
            foreach ($this->input->post('my_multi_select1') as $row1) {
                foreach ($this->crear_menu_m->listar_acciones() as $row2){
                    $data = array(
                    'grupo_id'          => $row1, // Grupo definido en el formulario
                    'menu_id'           => $insert,
                    'grupo_acciones_id' => $row2->grupo_acciones_id // Todas las acciones
                    );
                    $insert2 = $this->crear_menu_m->insertar_grupo_menu($data);
                }
            }
        }
        echo $insert = $insert2 = json_encode(array("status" => TRUE));
    }
	
    public function editar($id){
        $data = $this->crear_menu_m->obtener_por_id($id);
        echo json_encode($data);
    }

	public function actualizar()
    {
        $data = array(
            'menu_nombre'       => $this->input->post('menu_nombre'),
			'menu_nivel'		=> $this->input->post('menu_nivel'),
			'menu_icono'		=> $this->input->post('menu_icono'),
			'menu_id_padre'	    => $this->input->post('menu_id_padre'),
			'menu_controlador'	=> $this->input->post('menu_controlador')
        );
        $this->crear_menu_m->update(
            array('menu_id'  => $this->input->post('menu_id')),
            $data);
        $exito = json_encode(array("status" => TRUE));
        //
        if ($exito = TRUE and $this->input->post('my_multi_select1')) {
            $this->crear_menu_m->eliminar_grupo_menu($this->input->post('menu_id'));
            foreach ($this->input->post('my_multi_select1') as $row1) {
                foreach ($this->crear_menu_m->listar_acciones() as $row2){
                    $data = array(
                    'grupo_id'          => $row1, // Grupo definido en el formulario
                    'menu_id'           => $this->input->post('menu_id'),
                    'grupo_acciones_id' => $row2->grupo_acciones_id // Todas las acciones
                    );
                    $insert = $this->crear_menu_m->insertar_grupo_menu($data);
                }
            }
        }
        //
        echo $exito = $insert = json_encode(array("status" => TRUE));
    }
	public function eliminar($id){
        $this->crear_menu_m->eliminar_por_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function menu_id_padre($menu_id){
        foreach ($this->crear_menu_m->listar_menu_id_padre($menu_id) as $row) {
            echo '<option value="'.$row->menu_id.'" '.$row->selected.'>'.$row->menu_nombre.'</option>';
        }
    }

    public function obtener_grupo_menu($menu_id)
    {
        foreach ($this->crear_menu_m->listar_grupo_menu($menu_id) as $row) {
            echo '<option class="op" value="' . $row->grupo_id . '" ' . $row->selected . '>' . $row->grupo_id . ' - ' . $row->grupo_nombre . '</option>';
        }
    }
}
